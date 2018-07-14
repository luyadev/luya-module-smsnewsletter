<?php

use luya\admin\ngrest\aw\CallbackFormWidget;
use luya\smsnewsletter\admin\Module;

/**
 * SmsActiveWindow Index View.
 *
 * @var $this \luya\admin\ngrest\base\ActiveWindowView
 * @var $model \luya\admin\ngrest\base\NgRestModel
 */
?>
<script>
zaa.bootstrap.register('SmsController', ['$scope', function($scope) {
    $scope.list = [];
    $scope.detail;
    $scope.currentId;
    $scope.openLogMessage = function(id) {
        $scope.currentId = id;
        $scope.$parent.sendActiveWindowCallback('load-message-log', {id:id}).then(function(response) {
            $scope.list = response.data.list;
            $scope.detail = response.data.message;
        });
    };
}]);
</script>
<div class="row" ng-controller="SmsController">
    <div class="col-md-6">
        <div class="row">
            <div class="col">
                <p class="lead"><?= Module::t('sms.aw.title.latestmessages'); ?></p>
                <ul class="list-group">
                <?php foreach ($model->logMessages as $log): ?>
                    <a ng-class="{'active':currentId==<?= $log->id; ?>}" class="list-group-item list-group-item-action" ng-click="openLogMessage(<?= $log->id; ?>)"><?= date("d.m.Y", $log->timestamp); ?> <small><?= $log->message; ?></small></a>
                <?php endforeach; ?>
                </ul>
            </div>
            <div class="col" ng-show="detail">
                <p><?= Module::t('sms.aw.title.deliverystatus'); ?><button type="button" ng-click="openLogMessage(currentId)" class="btn btn-icon btn-success float-right"><i class="material-icons">refresh</i></button></p>
                <p><small><code>{{detail.message}}</code></small></p>
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th><?= Module::t('sms.aw.status.person'); ?></th>
                            <th><?= Module::t('sms.aw.status.deliverystatus'); ?></th>
                            <th><?= Module::t('sms.aw.status.created'); ?></th>
                            <th><?= Module::t('sms.aw.status.notified'); ?></th>
                        </tr>
                    </thead>
                    <tr ng-repeat="status in list">
                        <td>{{ status.person.firstname}} {{status.person.lastname}}</td>
                        <td>{{ status.tracking.deliveryStatus }}</td>
                        <td>{{ status.log.timestamp }}</td>
                        <td>
                            <span class="badge badge-pill"
                                ng-class="{'badge-success':status.tracking.deliveryStatusBool, 'badge-danger': !status.tracking.deliveryStatusBool}"
                            >{{ status.tracking.notificationDate }}</span>
                    </tr>
                </table>
            </div>
        </div>
        
    </div>
    <div class="col-md-6">
        <p class="lead"><?= Module::t('sms.aw.title.send'); ?><span class="badge badge-secondary float-right"><?= Module::t('sms.aw.status.credits', ['credits_count' => $credits]); ?></span></p>
        <?php $form = CallbackFormWidget::begin(['callback' => 'send', 'buttonValue' =>  Module::t('sms.aw.form.submit'), 'options' => ['reloadWindowOnSuccess' => true]]); ?>
        <?= $form->field('origin', Module::t('sms.aw.form.origin'))->textInput(); ?>
        <?= $form->field('message', Module::t('sms.aw.form.message'))->textarea(); ?>
        <p ng-show="params.message"><small class="float-right"><?= Module::t('sms.aw.form.chars'); ?></small></p>
        <?php $form::end(); ?>
        <p class="lead mt-5"><?= Module::t('sms.aw.title.recipients'); ?></p>
        <ul class="list-group">
            <?php foreach ($model->persons as $person): ?>
            <li class="list-group-item"><?= $person->firstname; ?> <?= $person->lastname; ?> (<?= $person->phone; ?>)</li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>