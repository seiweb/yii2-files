<?php

use yii\db\Migration;

class m170318_205556_create_index extends Migration
{
    public function up()
    {
        $this->createIndex('id_object_model_key_sort','{{%file}}',['id_object','model_key','sort']);
    }

    public function down()
    {
        echo "m170318_205555_create_table_model_key cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
