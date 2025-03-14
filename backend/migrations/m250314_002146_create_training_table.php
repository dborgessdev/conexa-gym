<?php

use yii\db\Migration;

class m250314_002146_create_training_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('training', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(), // Removido UNSIGNED
            'exercise_name' => $this->string(255)->notNull(),
            'sets' => $this->integer()->notNull(),
            'repetitions' => $this->integer()->notNull(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);
    
        $this->addForeignKey(
            'fk-training-user_id',
            'training',
            'user_id',
            'users',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }    
    
    public function safeDown()
    {
        $this->dropForeignKey('fk-training-user_id', 'training');
        $this->dropTable('training');
    }    
}
