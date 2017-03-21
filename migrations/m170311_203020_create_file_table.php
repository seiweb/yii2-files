<?php

use yii\db\Migration;

/**
 * Handles the creation of table `file`.
 */
class m170311_203020_create_file_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
            $this->createTable('{{%file}}', [
                'id' => $this->primaryKey(),
                'id_object' => $this->integer()->notNull(),
                'model_key' => $this->string(255)->notNull(),
                'group_key' => $this->integer()->notNull(),
                'mime' => $this->string(255)->notNull(),
                'file_name' => $this->string(255)->notNull(),
                'uf_file_name' => $this->string(255)->notNull(),
                'size'=>$this->integer(11)->notNull(),
                'sort'=>$this->integer(11)->notNull(),
                'ext'=>$this->string(6)->notNull(),
                'created_at'=>$this->dateTime()->notNull(),
                'updated_at'=>$this->dateTime()->notNull(),
            ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%file}}');
    }
}
