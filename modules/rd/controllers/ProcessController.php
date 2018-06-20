<?php

namespace app\modules\rd\controllers;

use app\modules\rd\models\ContainerSearch;
use DateTime;
use DateTimeZone;
use app\modules\administracion\models\AdmUser;
use app\modules\rd\models\Container;
use app\modules\rd\models\Process;
use app\modules\rd\models\ProcessSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use Yii\web\Response;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * ProcessController implements the CRUD actions for Process model.
 */
class ProcessController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'transactions' => ['GET'],
                    'containers' => ['GET']
                ],
            ],
        ];
    }

//    /**
//     * Lists all Process models.
//     * @return mixed
//     */
//    public function actionIndex()
//    {
//        if(!Yii::$app->user->can("process_list"))
//            throw new ForbiddenHttpException('Usted no tiene acceso a esta recepción');
//
//        $searchModel = new ProcessSearch();
//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//
//        return $this->render('index', [
//            'searchModel' => $searchModel,
//            'dataProvider' => $dataProvider,
//        ]);
//    }

    /**
     * Displays a single Process model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        if(!Yii::$app->user->can("reception_view")) // FIXME: change permission to process_view
            throw new ForbiddenHttpException('Usted no tiene acceso a esta recepción');

        $user = AdmUser::findOne(['id'=>Yii::$app->user->id]);

        $model = $this->findModel($id);

        if($user && $user->hasRol('Agencia')) // FIXME: change role to Importer/Exporter
        {
            $userAgency = UserAgency::findOne(['user_id'=>$user->id]);
            if($userAgency && $userAgency->agency_id !== $model->agency_id)
                throw new ForbiddenHttpException('Usted no tiene acceso a este proceso');

        }
        else if ($user && $user->hasRol('Cia_transporte')){
            $userCiaTrans = UserTranscompany::findOne(['user_id'=>$user->id]);
            if($userCiaTrans && $userCiaTrans->transcompany_id !== $model->trans_company_id)
                throw new ForbiddenHttpException('Usted no tiene acceso a este proceso');
        }

        $containersSearchModel = new ContainerSearch();
        $containerDataProvider = $containersSearchModel->innerJoin('process_transaction', 'process_transaction.container_id = container.id')
            ->innerJoin('process', 'process_transaction.process_id = process.id')
            ->where(['process.id'=>$id])
            ->all();

        return $this->render('view', [
            'model' => $model,
            'containerDataProvider'=>$containerDataProvider,
            'containersSearchModel'=>$containersSearchModel,
        ]);
    }

    /**
     * Creates a new Process model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if(!Yii::$app->user->can("reception_create"))
            throw new ForbiddenHttpException('Usted no tiene permiso para eliminar esta recepción');

        $model = new Process();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Process model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        if(!Yii::$app->user->can("reception_update"))
            throw new ForbiddenHttpException('Usted no tiene permiso para crear una recepción');

        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Process model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if(!Yii::$app->user->can("reception_delete"))
            throw new ForbiddenHttpException('Usted no tiene permiso para eliminar esta recepción');


        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Process model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Process the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Process::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    public function actionContainers()
    {
        if(!Yii::$app->user->can("reception_list"))
            throw new ForbiddenHttpException('Usted no tiene permiso para crear una recepción');

        Yii::$app->response->format = Response::FORMAT_JSON;

        $response = array();
        $response['msg'] = '';
        $response['containers'] = [];
        $response['success'] = false;
        $bl = Yii::$app->request->get('bl');

        if(isset($bl))
        {
            $response['containers'] = Container::find()
                ->innerJoin('process_transaction', 'process_transaction.container_id = container.id')
                ->innerJoin('process', 'process_transaction.process_id = process.id')
                ->where(['bl'=>$bl])
                ->all();
            $response['success'] = true;
        }
        else {
            $response['msg'] = "Tiene que especificar un código BL.";
        }

        return $response;
    }

    public function actionTransactions()
    {
        if(!Yii::$app->user->can("reception_list"))
            throw new ForbiddenHttpException('Usted no tiene permiso para crear una recepción');

        Yii::$app->response->format = Response::FORMAT_JSON;

        $response = array();
        $response['msg'] = '';
        $response['transactions'] = [];
        $id = Yii::$app->request->get('id');
        $actived = Yii::$app->request->get('actived');
        if(isset($id))
        {
            $reception = Reception::findOne(['id'=>$id]);
            $condition = 'reception_id = ' . $id;
            if(isset($actived))
            {
                $condition = $condition . ' and active = ' . $actived;
            }

            if($reception)
            {
                $transactions = ReceptionTransaction::find()->where($condition)
                    ->orderBy('delivery_date', SORT_ASC)
                    ->all();

                $response['success'] = true;
                $response['msg'] = "Datos encontrados.";
//                $transactions = $reception->receptionTransactions;
                $response['transactions'] = [];
                $response['reception'] = $reception;
                $response['angecy'] = $reception->agency;
                $response['containers'] = [];
                foreach ( $transactions as $t)
                {
                    array_push($response['transactions'], $t);
                    array_push($response['containers'], $t->container);
                }
            }
            else
            {
                $response['success'] = false;
                $response['msg'] = Yii::t("app", "No fue posible encontrar los datos.");
            }
        }
        else
        {
            $response['success'] = false;
            $response['msg'] = Yii::t("app", "No fue posible procesar los datos.");
        }
//        return json_encode($response);
//        return $response;
        return $response;
    }

    protected function createReception($model)
    {
        $response = array();

        Yii::$app->response->format = Response::FORMAT_JSON;

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

//                        $body = $this->renderFile('@app/modules/rd/views/reception/email', ['model' => $model]);
                        //                        Yii::$app->mailer->compose('layouts/html')
//                        Yii::$app->mailer->compose('@app/modules/rd/views/reception/email', ['model' => $model])
                        $body = Yii::$app->view->renderFile('@app/mail/layouts/html2.php', ['model' => $model,
                            'containers'=>$containers]);
                        Yii::$app->mailer->compose()
                            ->setFrom($remitente->email)
                            ->setTo($destinatario->email)
                            ->setSubject("Nueva Solicitud de Recepción")
                            ->setHtmlBody($body)
                            ->send();

                        $response['success'] = true;
                        $response['msg'] = Yii::t("app", "Recepción creada correctamente.");
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
