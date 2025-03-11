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
                'Access-Control-Request-Method' => ['GET', 'POST', 'OPTIONS', 'PUT, DELETE'],
                'Access-Control-Allow-Credentials' => true,
            ],
        ];
        return $behaviors;
    }

    public function beforeAction($action)
    {
        if (Yii::$app->request->isOptions) {
            Yii::$app->response->headers->set('Access-Control-Allow-Origin', 'http://localhost:5173');
            Yii::$app->response->headers->set('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, DELETE');
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
                'id'        => $user->id,
                'username'  => $user->username,
                'role'      => $user->role,
                'email'     => $user->email, 
                'token'     => $user->auth_key
            ],
        ];
    }

    public function actionGetUser($id) {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $user = User::findOne($id);

        if(!$user) {
            return ['error' => 'Usuário não encontrado!'];
    
        }

        return [
            'id'        => $user->id,
            'username'  => $user->username,
            'role'      => $user->role,
            'status'    => $user->status,
            'email'     => $user->email
        ];
    }

    public function actionGetUsers() {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    
        $users = User::find()->select(['id', 'username', 'status', 'role', 'email'])->asArray()->all();
    
        return $users ?: [];
    }

    public function actionCreateUser() {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    
        $request = Yii::$app->request->post();
    
        $user = new User();
        $user->username = $request['username'];
        $user->email = $request['email'];
        $user->password_hash = Yii::$app->security->generatePasswordHash($request['password']);
        $user->role = $request['role'];
    
        if ($user->save()) {
            if ($user->role === 'aluno') {
                Yii::$app->db->createCommand()->insert('students', [
                    'user_id'   => $user->id,
                    'age'       => $request['age'] ?? null,
                    'weight'    => $request['weight'] ?? null,
                    'height'    => $request['height'] ?? null,
                ])->execute();
            } elseif ($user->role === 'professor') {
                Yii::$app->db->createCommand()->insert('teachers', [
                    'user_id'       => $user->id,
                    'specialty'     => $request['specialty'] ?? null,
                    'experience'    => $request['experience'] ?? null,
                ])->execute();
            }
    
            return ['success' => true, 'message' => 'Usuário criado com sucesso!'];
        } else {
            return ['success' => false, 'message' => 'Erro ao criar usuário', 'errors' => $user->errors];
        }
    }

    public function actionUpdateUser($id) {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    
        $request = Yii::$app->request->post();
        $user = User::findOne($id);
    
        if (!$user) {
            return ['success' => false, 'message' => 'Usuário não encontrado.'];
        }
    
        // Atualiza o status, se enviado na requisição
        if (isset($request['status'])) {
            if ($request['status'] == 1) {
                // Se for liberado por 1 dia, salva a data de expiração
                $user->status = 1;
                $user->access_expiration = date('Y-m-d H:i:s', strtotime('+1 day'));
            } else {
                $user->status = 0;
                $user->access_expiration = null; // Bloqueia indefinidamente
            }
        }
    
        // Atualiza os dados normais do usuário
        $user->username = $request['username'] ?? $user->username;
        $user->email = $request['email'] ?? $user->email;
        if (!empty($request['password'])) {
            $user->password_hash = Yii::$app->security->generatePasswordHash($request['password']);
        }
    
        // Atualiza dados adicionais de alunos e professores
        if ($user->role === 'aluno') {
            $aluno = Yii::$app->db->createCommand("SELECT * FROM students WHERE user_id = :user_id", [':user_id' => $user->id])->queryOne();
            if ($aluno) {
                Yii::$app->db->createCommand()->update('students', [
                    'age'    => $request['age'] ?? $aluno['age'],
                    'weight' => $request['weight'] ?? $aluno['weight'],
                    'height' => $request['height'] ?? $aluno['height'],
                ], ['user_id' => $user->id])->execute();
            }
        } elseif ($user->role === 'professor') {
            $professor = Yii::$app->db->createCommand("SELECT * FROM teachers WHERE user_id = :user_id", [':user_id' => $user->id])->queryOne();
            if ($professor) {
                Yii::$app->db->createCommand()->update('teachers', [
                    'specialty'  => $request['specialty'] ?? $professor['specialty'],
                    'experience' => $request['experience'] ?? $professor['experience'],
                ], ['user_id' => $user->id])->execute();
            }
        }
    
        if ($user->save()) {
            return ['success' => true, 'message' => 'Usuário atualizado com sucesso!'];
        } else {
            return ['success' => false, 'message' => 'Erro ao atualizar usuário', 'errors' => $user->errors];
        }
    }

    public function actionDeleteUser($id) {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    
        $user = User::findOne($id);
    
        if (!$user) {
            return ['success' => false, 'message' => 'Usuário não encontrado.'];
        }
    
        // alteração de fluxo para excluir os alunos ou os profs depende da role
        if ($user->role === 'aluno') {
            Yii::$app->db->createCommand()->delete('students', ['user_id' => $user->id])->execute();
        } elseif ($user->role === 'professor') {
            Yii::$app->db->createCommand()->delete('teachers', ['user_id' => $user->id])->execute();
        }
    
        if ($user->delete()) {
            return ['success' => true, 'message' => 'Usuário deletado com sucesso!'];
        } else {
            return ['success' => false, 'message' => 'Erro ao deletar usuário.'];
        }
    }
    
    public function actionAlunos() {
        return User::find()->where(['role' => 'aluno'])->all();
    }
    
    public function actionProfessores() {
        return User::find()->where(['role' => 'professor'])->all();
    }
    
    public function actionTemporaryAccess()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $request = Yii::$app->request;
        $userId = $request->post('userId');

        if (!$userId) {
            return ['success' => false, 'message' => 'ID do usuário não fornecido'];
        }

        $user = User::findOne($userId);

        if (!$user) {
            return ['success' => false, 'message' => 'Usuário não encontrado'];
        }

        $user->status = 1; 
        $user->access_expiration = date('Y-m-d H:i:s', strtotime('+1 day'));

        if ($user->save()) {
            return ['success' => true, 'message' => 'Acesso liberado por 1 dia'];
        } else {
            return ['success' => false, 'message' => 'Erro ao salvar no banco de dados'];
        }
    }

    public function actionRegisterPayment()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $request = Yii::$app->request->post();
        $userId = $request['userId'] ?? null;

        if (!$userId) {
            return ['success' => false, 'message' => 'ID do usuário não fornecido.'];
        }

        $user = User::findOne($userId);
        if (!$user) {
            return ['success' => false, 'message' => 'Usuário não encontrado.'];
        }

        $hoje = new \DateTime();
        $expiracao = $user->access_expiration ? new \DateTime($user->access_expiration) : null;
        
        if ($expiracao && $expiracao < $hoje) {
            // Caso o pagamento esteja vencido, bloquear usuário antes de registrar o novo pagamento
            $user->status = 0;
        }
        
        // Atualizar a data de expiração para 30 dias a partir de hoje
        $user->status = 1;
        $user->access_expiration = date('Y-m-d H:i:s', strtotime('+30 days'));
        
        if ($user->save()) {
            return ['success' => true, 'message' => 'Pagamento registrado com sucesso!'];
        } else {
            return ['success' => false, 'message' => 'Erro ao registrar pagamento.'];
        }
    }
}
