<?php

use yii\db\Migration;

/**
 * Class m181024_025222_cre_tbl_tag_control
 */
class m181024_025222_cre_tbl_tag_control extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('tag_control', [
            'id' => $this->primaryKey(),
            'tag_' => $this->string(255)->notNull(),
            'time' => $this->datetime(),
            'note' => $this->string(255),
            'comment' => $this->string(255)
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%tag_control}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181024_025222_cre_tbl_tag_control cannot be reverted.\n";

        return false;
    }
    */
}
