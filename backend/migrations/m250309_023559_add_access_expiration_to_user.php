<?php

use yii\db\Migration;

/**
 * Class m250309_023559_add_access_expiration_to_user
 */
class m250309_023559_add_access_expiration_to_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('users', 'access_expiration', $this->dateTime()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('user', 'access_expiration');
    }
}

