<?php

namespace app\modules\rd\controllers;


use DateTime;
use DateTimeZone;
use app\modules\administracion\models\AdmUser;
use app\modules\rd\models\Container;
use app\modules\rd\models\Process;
use app\modules\rd\models\UserAgency;
use app\modules\rd\models\ProcessSearch;
use app\modules\rd\models\ContainerSearch;
use app\modules\rd\models\ProcessTransaction;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use Yii\web\Response;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\mpdf\Pdf;
use Mpdf\Mpdf;

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
        $searchModel = new ContainerSearch();

        $query = $searchModel->find()
                ->innerJoin('process_transaction', 'process_transaction.container_id = container.id')
                ->innerJoin('process', 'process_transaction.process_id = process.id')
                ->where(['process.id'=>$id]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 3,
            ],
            'sort' => [
                'defaultOrder' => [
                    'name' => SORT_ASC,
                ]
            ],
        ]);

        return $this->render('view', [
            'model' => $model,
            'dataProvider'=>$dataProvider,
            'searchModel'=>$searchModel ,
        ]);
    }

    /**
     * Creates a new Process model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($type)
    {

        if((int)$type !== Process::PROCESS_IMPORT && (int)$type  !== Process::PROCESS_EXPORT)
            throw new ForbiddenHttpException('Error en el tipo de solicitud.');

//        if(!Yii::$app->user->can("reception_create"))
//            throw new ForbiddenHttpException('Usted no tiene permiso para crear un proceso');

        $model = new Process();
        $user = AdmUser::findOne(['id'=>Yii::$app->user->getId()]);
        $userAgency = UserAgency::findOne(['user_id'=>$user->id]);

        $agency = null;
        if($userAgency)
        {
            $agency = $userAgency->agency;
        }
//        var_dump(Yii::$app->request->post());
        if ($model->load(Yii::$app->request->post())) {
            return $this->createProcess($model);
        }

        return $this->render('create', [
            'model' => $model,
            'type'=>$type,
//            'agency'=>$userAgency,
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

    protected function createProcess($model)
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
            $transaction = Process::getDb()->beginTransaction();
            $containersByTransCompany = [];

            try {
                $aux = new DateTime($model->delivery_date);
                $aux->setTimezone(new DateTimeZone("UTC"));

                $model->delivery_date = $aux->format("Y-m-d G:i:s");

                if($model->save())
                {
                    $containers = Yii::$app->request->post()["containers"];
                    $tmpResult = true;
                    foreach ($containers as $container)
                    {
                        $containerModel = Container::findOne(['name'=>$container['name']]);

                        if($containerModel !== null)
                        {
                            $containerModel->status = 'Pendiente';
                            $result = $containerModel->update();
                            if($result === false)
                            {
                                $tmpResult = false;
                                $response['msg'] = "Ah ocurrido un error al actualizar el estado del contenedor.";
                                $response['msg_dev'] = implode(", ", $containerModel->getErrorSummary(false));
                                $transaction->rollBack();
                                break;
                            }
                        }
                        else
                        {
                            $containerModel = new Container();
                            $containerModel->name = $container['name'];
                            $containerModel->code = $container['type'];
                            $containerModel->tonnage = $container['tonnage'];
                            $containerModel->status = 'Pendiente';
                            $containerModel->active = 1;

                            if(!$containerModel->save())
                            {
                                $tmpResult = false;
                                $response['msg'] = "Ah ocurrido un error al guardar los datos de los contenedores.";
                                $response['msg_dev'] = implode(", ", $containerModel->getErrorSummary(false));
                                $transaction->rollBack();
                                break;
                            }
                        }

                        $processTransModel = new ProcessTransaction();
                        $processTransModel->process_id = $model->id;
                        $processTransModel->container_id = $containerModel->id;
//                        $processTransModel->delivery_date = $model->delivery_date;
                        $processTransModel->active = 1;
                        $processTransModel->trans_company_id = $container['transCompany']['id'];

                        if(isset($containersByTransCompany[$processTransModel->trans_company_id]))
                        {
                            array_push($containersByTransCompany[$processTransModel->trans_company_id], $containerModel);
                        }
                        else {
                            $containersByTransCompany[$processTransModel->trans_company_id]=[];
                            array_push($containersByTransCompany[$processTransModel->trans_company_id], $containerModel);
                        }

                        $aux = new DateTime($container['deliveryDate']);
                        $aux->setTimezone(new DateTimeZone("UTC"));

                        $processTransModel->delivery_date = $aux->format("Y-m-d G:i:s");
                        $processTransModel->active = 1;

                        if(!$processTransModel->save()) {
                            $tmpResult = false;
                            $response['msg'] = "Ah ocurrido un error al salvar los datos de los contenedores.";
                            $response['msg_dev'] = implode(" ", $processTransModel->getErrorSummary(false));
                            $transaction->rollBack();
                            break;
                        }
                    }

                    if($tmpResult)
                    {
                        $transaction->commit();

                        // send email
                        $remitente = AdmUser::findOne(['id'=>\Yii::$app->user->getId()]);

                        foreach($containersByTransCompany as $t=>$c) {

                            $destinatario = AdmUser::find()
                                ->innerJoin("user_transcompany","user_transcompany.user_id = adm_user.id ")
                                ->where(["user_transcompany.transcompany_id"=>$t])
                                ->one();

                            if($destinatario)
                            {

                                $containers1 = [];
                                $containers2 = [];
                                $i=1;

                                foreach ($c as $c2) {
                                    if ($i % 2 !== 0) {
                                        $containers1 []= $c2;
                                    } else {
                                        $containers2 []= $c2;
                                    }
                                    $i++;
                                }

                                //pdf create
                                $pdf =  new mPDF( );
                                $pdf->SetTitle("Prueba d generaciÃ³n de PDF.");
                                $pdf->WriteHTML($this->renderPartial('@app/mail/layouts/html3.php', ['model' => $model,
                                    'containers1'=>$containers1,
                                    'containers2'=>$containers2]));
                                $path= $pdf->Output("","S");

                                $body = Yii::$app->view->renderFile('@app/mail/layouts/html3.php', ['model' => $model,
                                    'containers1'=>$containers1,
                                    'containers2'=>$containers2]);

                                // TODO: send email user too from the admin system
                                Yii::$app->mailer->compose()
                                    ->setFrom($remitente->email)
                                    ->setTo($destinatario->email)
                                    ->setSubject("Nueva Solicitud de Recepción")
                                    ->setHtmlBody($body)
                                    ->attachContent($path,[ 'fileName'=> "Nueva Solicitud de RecepciÃ³n.pdf",'contentType'=>'application/pdf'])
                                    ->send();
                            }
                        }
                        $response['success'] = true;
                        $response['msg'] = Yii::t("app", "Recepción creada correctamente.");
                        $response['url'] = Url::to(['/site/index']);
                    }
                }
                else {
                    $response['success'] = false;
                    $response['msg'] =  "No fue posible crear la solicitud.";
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

        return $response;
    }
}
