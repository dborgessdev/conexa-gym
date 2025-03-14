<?php

namespace app\controllers;

use Yii;
use yii\rest\Controller;
use app\models\Training;
use yii\web\Response;
use yii\web\NotFoundHttpException;

class TrainingController extends Controller
{
    public $enableCsrfValidation = false;

    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'corsFilter' => [
                'class' => \yii\filters\Cors::class,
                'cors' => [
                    'Origin' => ['*'], // Permite requisições de qualquer origem
                    'Access-Control-Request-Method' => ['POST', 'GET', 'OPTIONS'],
                    'Access-Control-Request-Headers' => ['*'],
                ],
            ],
        ]);
    }

    public function actionSave()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        $request = Yii::$app->request->post();
        $userId = $request['userId'] ?? null;
        $treinos = $request['treinos'] ?? [];
    
        if (!$userId || empty($treinos)) {
            return ['success' => false, 'message' => 'Dados inválidos'];
        }
    
        foreach ($treinos as $dia => $exercicios) {
            foreach ($exercicios as $exercicio) {
                $training = new Training();
                $training->user_id = $userId;
                $training->exercise_name = $exercicio['exercise_name'];
                $training->sets = $exercicio['sets'];
                $training->repetitions = $exercicio['repetitions'];
    
                if (!$training->save()) {
                    Yii::error("Erro ao salvar treino: " . json_encode($training->errors), 'training');
                    return ['success' => false, 'message' => 'Erro ao salvar treino', 'errors' => $training->errors];
                }
            }
        }
    
        return ['success' => true, 'message' => 'Treinos salvos com sucesso'];
    }

    public function actionGet($userId)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        
        $trainings = Training::find()->where(['user_id' => $userId])->asArray()->all();
    
        if (!$trainings) {
            return ['success' => false, 'message' => 'Nenhum treino encontrado'];
        }
    
        return ['success' => true, 'treinos' => $trainings];
    }    
}
