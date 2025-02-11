<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface {
    public static function tableName()
    {
        return 'users'; 
    }

    public function rules()
    {
        return [
            [['username', 'email', 'password_hash', 'role'], 'required'],
            [['username', 'email', 'auth_key'], 'string', 'max' => 255], // Adicionando auth_key
            [['role'], 'in', 'range' => ['admin', 'professor', 'aluno']],
            [['email'], 'email'],
            [['username', 'email'], 'unique'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Usuário',
            'email' => 'E-mail',
            'password_hash' => 'Senha',
            'role' => 'Tipo de Usuário',
            'auth_key' => 'Chave de Autenticação',
        ];
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['auth_key' => $token]);
    }

    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->auth_key; // Retorna a chave de autenticação
    }

    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey; // Valida a chave de autenticação
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }
}
