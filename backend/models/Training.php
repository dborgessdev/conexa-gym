<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "training".
 *
 * @property int $id
 * @property int $user_id
 * @property string $day_of_week
 * @property string $exercise_name
 * @property int $sets
 * @property int $repetitions
 * @property string $created_at
 */
class Training extends ActiveRecord
{
    public static function tableName()
    {
        return 'training';
    }

    public function rules()
    {
        return [
            [['user_id', 'exercise_name', 'sets', 'repetitions'], 'required'],
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
