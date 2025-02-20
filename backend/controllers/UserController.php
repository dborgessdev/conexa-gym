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
        $transaction = Yii::$app->db->beginTransaction(); // Inicia a transação
    
        try {
            // Criar novo usuário
            $user = new User();
            $user->username      = $request['username'];
            $user->email         = $request['email'];
            $user->password_hash = Yii::$app->security->generatePasswordHash($request['password']); 
            $user->role          = $request['role'];
    
            if (!$user->save()) {
                return ['success' => false, 'message' => 'Erro ao criar usuário', 'errors' => $user->errors];
            }
    
            // Se for aluno, adicionar na tabela students
            if ($request['role'] === 'aluno') {
                $student = new Students();
                $student->user_id = $user->id;
                $student->age     = $request['age'] ?? null;
                $student->weight  = $request['weight'] ?? null;
                $student->height  = $request['height'] ?? null;
    
                if (!$student->save()) {
                    $transaction->rollBack(); // Desfaz tudo se der erro
                    return ['success' => false, 'message' => 'Erro ao salvar aluno', 'errors' => $student->errors];
                }
            }
    
            // Se for professor, adicionar na tabela teachers
            if ($request['role'] === 'professor') {
                $teacher = new Teachers();
                $teacher->user_id    = $user->id;
                $teacher->specialty  = $request['specialty'] ?? null;
                $teacher->experience = $request['experience'] ?? null;
    
                if (!$teacher->save()) {
                    $transaction->rollBack(); // Desfaz tudo se der erro
                    return ['success' => false, 'message' => 'Erro ao salvar professor', 'errors' => $teacher->errors];
                }
            }
    
            $transaction->commit(); // Confirma as operações no banco
            return ['success' => true, 'message' => 'Usuário criado com sucesso!'];
    
        } catch (\Exception $e) {
            $transaction->rollBack(); // Desfaz alterações em caso de erro
            return ['success' => false, 'message' => 'Erro inesperado', 'error' => $e->getMessage()];
        }
    }

    public function actionCreateAluno() {
        return $this->actionCreateUser(); // Apenas chama o método genérico de criação
    }

    public function actionAlunos() {
        return User::find()->where(['role' => 'aluno'])->all();
    }
    
    public function actionProfessores() {
        return User::find()->where(['role' => 'professor'])->all();
    }    

}
