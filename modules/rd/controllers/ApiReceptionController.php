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
use DateTime;
use DateTimeZone;
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
        unset($actions['deelete']);
        unset($actions['update']);
        unset($actions['view']);
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
            'transaction' => ['GET', 'HEAD'],
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

            try {
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

                            $aux = new DateTime($container['deliveryDate']);
                            $aux->setTimezone(new DateTimeZone("UTC"));

                            $receptionTransModel->delivery_date = $aux->format("Y-m-d G:i:s");
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
                        $agency= $model->agency ? $model->agency->name:'';
                        $ciaTransporte = $model->transCompany ? $model->transCompany->name:'';


//                        $emailConten .= Html::beginTag('div', ['class'=>'jumbotron'])
//                                        . Html::beginTag('div', ['class'=>'panel panel-default'])
//                                            . Html::tag('div', Html::encode('Notificación de solicitud de recepción'), ['class'=>'panel-heading'])
//                                            . Html::beginTag('div', ['class'=>'panel-body'])
//
//                                                . Html::tag('h5', Html::encode('Número de la Recepción: ' . $model->id))
//                                                . Html::tag('p', Html::encode('Agencia: ' . $agency))
//                                                . Html::tag('h5', Html::encode('Cia de Trasnporte: ' . $ciaTransporte))
//                                                . Html::tag('p', Html::encode('Código BL: ' . $model->bl))
//                                                . Html::tag('p', Html::encode('Fecha de Envío: ' . $model->created_at))
//                                                . Html::tag('h5', Html::encode('Contenedores'))
//                                                . Html::beginTag('div', ['class'=>'list-group'])
//                                                    . Html::ul($containers, ['item' => function($item, $index) {
//                                                        $li = Html::tag(
//                                                            'li',
//                                                            Html::encode($item['name'] . ' '. $item['type'] . ' ' . $item['tonnage']),
//                                                            ['class'=>'list-group-item-heading']
//                                                        );
//                                                        //                                        var_dump($li) ; die;
//                                                        return $li;
//                                                    }])
//                                                . Html::endTag('div')
//                                                . Html::tag('p', Html::encode('Cantidad de Cotenedores: ' .$model->getContainerAmount()))
//                                            . Html::endTag('div')
//                                        . Html::a('Ir a solicitud', Url::to(['/rd/reception/trans-company', 'id'=>$model->id], true), [])
//                                        . Html::endTag('div')
//                                    . Html::endTag('div');

                        Yii::$app->mailer->compose('/rd/reception/email', ['model' => $model])
                            ->setFrom($remitente->email)
                            ->setTo($destinatario->email)
//                            ->setFrom("admin@test.co")
//                            ->setTo("test@test.co")
                            ->setSubject("Nueva Solicitud de Recepción")
//                            ->setHtmlBody($emailConten)
                            ->setTextBody('Test')
                            ->send();

                        $response['success'] = true;
                        $response['msg'] = Yii::t("app", "Recepción creada correctamente.");
//                    $response['url'] = Url::toRoute(['/site/index', 'option'=>1]);
                        $response['url'] = Url::to(['/site/index']);
                    }
                }
                else {
                    $response['success'] = false;
                    $response['msg'] =  $model->getFirstError();
                }
            }
            catch (Exception $e)
            {
                $response['success'] = false;
                $response['msg'] = $e->getMessage();
                $transaction->rollBack();
            }
        }
        else {
            $response['success'] = false;
            $response['msg'] = Yii::t("app", "No fue posible procesar los datos.");
        }

        return json_encode($response);
    }
}