<?php
/**
 * Created by PhpStorm.
 * User: pedro
 * Date: 01/06/2018
 * Time: 9:57
 */

namespace app\modules\rd\controllers;

use app\modules\administracion\models\AdmUser;
use app\modules\rd\models\Container;
use app\modules\rd\models\Reception;
use app\modules\rd\models\ReceptionTransaction;
use Yii;
use yii\helpers\Html;
use yii\helpers\Url;
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
//            print_r($model->bl);
//            print_r($model->active);
//            print_r($model->agency_id);
//            print_r($model->trans_company_id);
//
            $transaction = Reception::getDb()->beginTransaction();


            if($model->save())
            {
                $containers = Yii::$app->request->post()["containers"];
                $tmpResult = true;
                foreach ($containers as $container)
                {
                    $containerModel = new Container();
                    $containerModel->name = $container['name'];
                    $containerModel->code = $container['type'];
                    $containerModel->tonnage = $container['tonnage'];
                    $containerModel->active = 1;

                    if($containerModel->save())
                    {
                        $receptionTransModel = new ReceptionTransaction();
                        $receptionTransModel->reception_id = $model->id;
                        $receptionTransModel->container_id = $containerModel->id;
                        $receptionTransModel->delivery_date = strtotime($container['deliveryDate']);
                        $receptionTransModel->active = 1;

                        if(!$receptionTransModel->save()) {
                            $tmpResult = false;
                            $response['msg'] = implode(" ", $receptionTransModel->getErrorSummary(false));// implode(", ", $receptionTransModel->getErrors());
                            $transaction->rollBack();
                            break;
                        }
                    }
                    else{
                        $tmpResult = false;
                        $response['msg'] = implode(", ", $containerModel->getErrorSummary(false)); // $containerModel->getFirstError();
                        $transaction->rollBack();
                        break;
                    }
                }

                if($tmpResult)
                {
                    $transaction->commit();

                    // send email
                    $remitente = AdmUser::findOne(['id'=>\Yii::$app->user->getId()]);
                    $destinatario = AdmUser::find()
                        ->innerJoin("user_transcompany","user_transcompany.user_id = adm_user.id ")
                        ->where(["user_transcompany.transcompany_id"=>$model->trans_company_id])
                        ->one();

                    // TODO: send email user too from the admin system
//                    $emailConten = null;

                    $emailConten = Html::beginTag('div')
                                   . Html::tag('p', Html::encode('Notificación de solicitud de recepción'))
                                   . Html::ul($containers, ['item' => function($item, $index) {
                                        $li = Html::tag(
                                            'li',
                                            Html::encode($item['name']),
                                            []
                                        );
//                                        var_dump($li) ; die;
                                        return $li;
                                    }])
                                    . Html::tag('p', Html::encode($model->created_at))
//                                    . Html::tag('p', Html::encode($model->getAgency() ? $model->getAgency()->name): '')
                                    . Html::tag('p', Html::encode($model->bl))
                                    . Html::tag('p', Html::encode($model->getContainerAmount()))
//                                    . Html::a('Ir a solicitud', Url::toRoute(['/rd/reception/trans-company', 'id'=>$model->id]), [])
                                    . Html::a('Ir a solicitud', Url::to(['/rd/reception/trans-company', 'id'=>$model->id], true), [])
                                    . Html::endTag('div');

                    Yii::$app->mailer->compose()
//                    ->setFrom($remitente->email)
//                    ->setTo($destinatario->email)
                        ->setFrom("admin@test.co")
                        ->setTo("test@test.co")
                        ->setSubject( "email de prueba." )
                        ->setHtmlBody($emailConten)
                        ->send();

                    $response['success'] = true;
                    $response['msg'] = Yii::t("app", "Recepción creada correctamente.");
//                    $response['url'] = Url::toRoute(['/site/index', 'option'=>1]);
                    $response['url'] = Url::to('/site/index');
                }
            }
            else {
                $response['success'] = false;
                $response['msg'] =  $model->getFirstError();
            }
        }
        else {
            $response['success'] = false;
            $response['msg'] = Yii::t("app", "No fue posible procesar los datos.");
        }

        return json_encode($response);
    }
}