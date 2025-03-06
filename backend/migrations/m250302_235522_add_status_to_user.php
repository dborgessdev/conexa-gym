<?php

use yii\db\Migration;

/**
 * Class m250302_235522_add_status_to_user
 */
class m250302_235522_add_status_to_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('users', 'status', $this->boolean()->defaultValue(0)->notNull());
    }
    
    public function safeDown()
    {
        $this->dropColumn('users', 'status');
    }
}
