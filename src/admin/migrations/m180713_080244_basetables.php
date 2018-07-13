<?php

use yii\db\Migration;

/**
 * Class m180713_080244_basetables
 */
class m180713_080244_basetables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('smsnewsletter_person', [
            'id' => $this->primaryKey(),
            'firstname' => $this->string()->notNull(),
            'lastname' => $this->string()->notNull(),
            'phone' => $this->string(50)->notNull(),
            'is_deleted' => $this->boolean()->defaultValue(false),
        ]);
        
        $this->createTable('smsnewsletter_list', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
        ]);
        
        $this->createTable('smsnewsletter_list_person_ref', [
            'person_id' => $this->integer()->notNull(),
            'list_id' => $this->integer()->notNull(),
        ]);
        
        $this->addPrimaryKey('smsnewsletter_list_person_ref_pk', 'smsnewsletter_list_person_ref', ['person_id', 'list_id']);
        
        $this->createTable('smsnewsletter_log_message', [
            'id' => $this->primaryKey(),
            'list_id' => $this->integer()->notNull(),
            'message' => $this->text()->notNull(),
            'timestamp' => $this->integer()->notNull(),
        ]);
        
        $this->createTable('smsnewsletter_log_message_person', [
            'id' => $this->primaryKey(),
            'person_id' => $this->integer()->notNull(),
            'log_message_id' => $this->integer()->notNull(),
            'tracking_id' => $this->string(120)->unique(),
            'timestamp' => $this->integer()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('smsnewsletter_person');
        $this->dropTable('smsnewsletter_list');
        $this->dropTable('smsnewsletter_list_person_ref');
        $this->dropTable('smsnewsletter_log_message');
        $this->dropTable('smsnewsletter_log_message_person');
    }
}
