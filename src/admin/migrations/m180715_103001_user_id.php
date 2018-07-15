<?php

use yii\db\Migration;

/**
 * Class m180715_103001_user_id
 */
class m180715_103001_user_id extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('smsnewsletter_log_message', 'admin_user_id', $this->integer());
        $this->addColumn('smsnewsletter_log_message', 'origin', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('smsnewsletter_log_message', 'admin_user_id');
        $this->dropColumn('smsnewsletter_log_message', 'origin');
    }
}
