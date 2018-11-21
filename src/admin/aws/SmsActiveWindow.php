<?php

namespace luya\smsnewsletter\admin\aws;

use Yii;
use Aspsms\Aspsms;
use luya\admin\ngrest\base\ActiveWindow;
use luya\smsnewsletter\models\LogMessage;
use luya\smsnewsletter\models\LogMessagePerson;
use luya\smsnewsletter\admin\Module;
use yii\base\InvalidCallException;

/**
 * Sms Active Window.
 *
 * File has been created with `aw/create` command.
 */
class SmsActiveWindow extends ActiveWindow
{
    /**
     * @var string The name of the module where the ActiveWindow is located in order to finde the view path.
     */
    public $module = '@smsnewsletteradmin';

    /**
     * Default label if not set in the ngrest model.
     *
     * @return string The name of of the ActiveWindow. This is displayed in the CRUD list.
     */
    public function defaultLabel()
    {
        return Module::t('sms.aw.defaultlabel');
    }

    /**
     * Returns the active window titel for the current model.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->model->title;
    }
    
    /**
     * Default icon if not set in the ngrest model.
     *
     * @var string The icon name from goolges material icon set (https://material.io/icons/)
     */
    public function defaultIcon()
    {
        return 'sms';
    }

    /**
     * The default action which is going to be requested when clicking the ActiveWindow.
     *
     * @return string The response string, render and displayed trough the angular ajax request.
     */
    public function index()
    {
        return $this->render('index', [
            'model' => $this->model,
            'credits' => $this->getAspsms(null)->credits(),
        ]);
    }
    
    /**
     *
     * @return Aspsms
     */
    public function getAspsms($origin)
    {
        return new Aspsms(Module::getInstance()->aspsmsKey, Module::getInstance()->aspsmsPassword, [
            'Originator' => $origin,
        ]);
    }
    
    /**
     * Send the message.
     *
     * @param string $message
     * @param string $origin
     * @return array
     */
    public function callbackSend($message, $origin)
    {
        $recipients = [];
        $log = [];
        foreach ($this->model->persons as $person) {
            $trackingNr = md5(uniqid(md5($person->id . $this->model->id))); // ensure its a-z0-9 value
            $recipients[$trackingNr] = $person->phone;
            $log[$trackingNr] = $person;
        }
        $gateway = $this->getAspsms($origin);
        $status = $gateway->sendTextSms($message, $recipients);
        
        if (!$status) {
            return $this->sendError($gateway->getSendStatus());
        }
        
        $logMessage = new LogMessage();
        $logMessage->message = $message;
        $logMessage->timestamp = time();
        $logMessage->list_id = $this->model->id;
        $logMessage->admin_user_id = Yii::$app->adminuser->id;
        $logMessage->origin = $origin;
        
        if ($logMessage->save()) {
            foreach ($log as $tracking => $person) {
                $model = new LogMessagePerson();
                $model->person_id = $person->id;
                $model->log_message_id = $logMessage->id;
                $model->tracking_id = $tracking;
                $model->timestamp = time();
                $model->save();
            }
        }
        
        return $this->sendSuccess('Sheduled for sending in the queue.');
    }

    /**
     *
     * @param integer $id
     * @return array
     */
    public function callbackLoadMessageLog($id)
    {
        $message = LogMessage::find()->where(['id' => $id])->with(['logMessagePersons.person'])->one();
        
        $data = [];
        try {
            $lastNumber = null;
            foreach ($message->logMessagePersons as $logPerson) {
                $lastNumber = $logPerson->tracking_id;
                $data[] = [
                    'log' => $logPerson,
                    'person' => $logPerson->person,
                    'tracking' => $this->getAspsms(null)->deliveryStatus($logPerson->tracking_id),
                ];
            }
        } catch (\Exception $e) {
            throw new InvalidCallException("Unable to find the tracking number '{$lastNumber}'. ASPSMS Error: " . $e->getMessage());
        }
        
        return ['message' => $message, 'list' => $data];
    }
}
