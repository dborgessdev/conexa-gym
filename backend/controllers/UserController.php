<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use app\models\User;
use yii\filters\Cors;

class UserController extends Controller
{
    public function behaviors() {
        $behaviors = parent::behaviors();
        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::class,
            'cors' => [
                'Origin' => ['http://localhost:5173'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'OPTIONS'],
                'Access-Control-Allow-Credentials' => true,
            ],
        ];
        return $behaviors;
    }

    public function beforeAction($action)
    {
        if (Yii::$app->request->isOptions) {
            Yii::$app->response->headers->set('Access-Control-Allow-Origin', 'http://localhost:5173');
            Yii::$app->response->headers->set('Access-Control-Allow-Methods', 'GET, POST, OPTIONS');
            Yii::$app->response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With');
            Yii::$app->end();
        }
        return parent::beforeAction($action);
    }

    public function actionOptions($id = null)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        Yii::$app->response->headers->set('Access-Control-Allow-Origin', 'http://localhost:5173');
        Yii::$app->response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        Yii::$app->response->headers->set('Access-Control-Allow-Headers', 'content-type, authorization, x-requested-with');
        Yii::$app->response->headers->set('Access-Control-Allow-Credentials', 'true');
        Yii::$app->response->statusCode = 200;
        return 'OK';
    }

    public function actionLogin()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $request = Yii::$app->request->post();
    
        $username = $request['username'] ?? '';
        $password = $request['password'] ?? '';
    
        $user = User::findOne(['username' => $username]);
    
        if (!$user || !Yii::$app->security->validatePassword($password, $user->password_hash)) {
            return ['success' => false, 'message' => 'Usuário ou senha inválidos.'];
        }
    
        // Gerar um novo auth_key
        $user->auth_key = Yii::$app->security->generateRandomString();
        $user->save();
    
        return [
            'success' => true,
            'user' => [
                'id'       => $user->id,
                'username' => $user->username,
                'role'     => $user->role,
                'email' => $user->email, 
                'token'    => $user->auth_key
            ],
        ];
    }
    

    public function actionCreateUser() {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    
        $request = Yii::$app->request->post();
    
        $user                = new User();
        $user->username      = $request['username'];
        $user->email         = $request['email'];
        $user->password_hash = Yii::$app->security->generatePasswordHash($request['password']); // Hash correto
        $user->role          = $request['role'];
    
        if ($user->save()) {
            return ['success' => true, 'message' => 'Usuário criado com sucesso!'];
        } else {
            return ['success' => false, 'message' => 'Erro ao criar usuário', 'errors' => $user->errors];
        }
    }

}
