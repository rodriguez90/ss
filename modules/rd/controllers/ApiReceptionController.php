<?php
/**
 * Created by PhpStorm.
 * User: pedro
 * Date: 01/06/2018
 * Time: 9:57
 */

namespace app\modules\rd\controllers;

use app\modules\rd\models\Reception;
use Yii;
use yii\rest\ActiveController;
use yii\web\Response;

class ApiReceptionController extends  ActiveController
{
    public $modelClass = 'app\modules\rd\models\Reception';

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['create']);
        return $actions;
    }

    /* Declare methods supported by APIs */
    protected function verbs(){
        return [
            'index' => ['GET', 'HEAD'],
            'view' => ['GET', 'HEAD'],
            'create' => ['POST'],
            'update' => ['PUT', 'PATCH'],
            'delete' => ['DELETE'],
        ];
    }

    public function behaviors()
    {
        // remove rateLimiter which requires an authenticated user to work
        $behaviors = parent::behaviors();
        unset($behaviors['rateLimiter']);
        return $behaviors;
    }

    public function actionCreate()
    {
        //        print_r(Yii::$app->request->post());

        $response = array();

        Yii::$app->response->format = Response::FORMAT_JSON;

        $model = new Reception();

        $response['success'] = false;

        if($model->load(Yii::$app->request->post()))
        {
//            die('2');
            if($model->save())
            {
                $response['success'] = true;

            }
            else {
                $response['success'] = false;
                $response['msg'] = Yii::t("app", "No fue posible procesar la recepción.");
            }
        }
//        die('1');

        return json_encode($response);
//        return $response;
    }
}