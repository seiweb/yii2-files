<?php

use yii\db\Migration;

class m170318_205555_alter_varchar extends Migration
{
    public function up()
    {
        $this->alterColumn('{{%file}}','model_key',$this->char(255));
        $this->alterColumn('{{%file}}','file_name',$this->char(50));
        $this->alterColumn('{{%file}}','mime',$this->char(50));
        $this->alterColumn('{{%file}}','ext',$this->char(10));
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
