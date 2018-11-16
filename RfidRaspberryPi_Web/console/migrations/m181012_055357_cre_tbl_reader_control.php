<?php

use yii\db\Migration;

/**
 * Class m181012_055357_cre_tbl_reader_control
 */
class m181012_055357_cre_tbl_reader_control extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
         $this->createTable('reader_control', [
            'id' => $this->primaryKey(),
//            'reader_code' => $this->string(255)->notNull(),
            'key' => $this->string(255),
            'value' => $this->string(255),
            'comment' => $this->string(255)
         ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%reader_control}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181012_055357_cre_tbl_reader_control cannot be reverted.\n";

        return false;
    }
    */
}
