<?php

namespace app\modules\rd\controllers;

use app\modules\administracion\models\AdmUser;
use app\modules\rd\models\Container;
use app\modules\rd\models\ContainerSearch;
use app\modules\rd\models\ReceptionTransaction;
use app\modules\rd\models\Reception;
use app\modules\rd\models\ReceptionSearch;
use app\modules\rd\models\UserAgency;
use app\modules\rd\models\UserTranscompany;
use Yii;
use Yii\web\Response;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ReceptionController implements the CRUD actions for Reception model.
 */
class ReceptionController extends Controller
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
                    'containers' => ['GET'],
                ],
            ],
        ];
    }

    /**
     * Lists all Reception models.
     * @return mixed
     */
    public function actionIndex()
    {
//        var_dump(Yii::$app->request->queryParams);

        $session = Yii::$app->session;
        $user = $session->get('user', null);


        $params = Yii::$app->request->queryParams;

        if($user && $user->hasRol('Agencia'))
        {
            $userAgency = UserAgency::findOne(['user_id'=>$user->id]);
            if($userAgency)
                $params['agency_id'] = $userAgency->agency->name;
        }
        else if ($user && $user->hasRol('Cia_transporte')){
            $userCiaTrans = UserTranscompany::findOne(['user_id'=>$user->id]);
            if($userCiaTrans)
                $params['trans_company_id'] = $userCiaTrans->transcompany->name;
        }

        $searchModel = new ReceptionSearch();
        $dataProvider = $searchModel->search($params);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Reception model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $user = AdmUser::findOne(['id'=>Yii::$app->user->id]);

        $params = Yii::$app->request->queryParams;

        $model = $this->findModel($id);

        if($user && !($user->hasRol('Agencia') || $user->hasRol('Cia_transporte') || $user->hasRol('Administracion')) )
            throw new ForbiddenHttpException('Usted no tiene acceso a esta recepción');

        if($user && $user->hasRol('Agencia'))
        {
            $userAgency = UserAgency::findOne(['user_id'=>$user->id]);
            if($userAgency && $userAgency->agency_id !== $model->agency_id)
                throw new ForbiddenHttpException('Usted no tiene acceso a esta recepción');

        }
        else if ($user && $user->hasRol('Cia_transporte')){
            $userCiaTrans = UserTranscompany::findOne(['user_id'=>$user->id]);
            if($userCiaTrans && $userCiaTrans->transcompany_id !== $model->trans_company_id)
                throw new ForbiddenHttpException('Usted no tiene acceso a esta recepción');
        }

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Reception model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Reception model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionTransCompany($id)
    {
        $user = AdmUser::findOne(['id'=>Yii::$app->user->id]);
        if($user && !($user->hasRol('Cia_transporte')))
            throw new ForbiddenHttpException('Usted no tiene permiso para resevar cupos en la recepción');

        return $this->render('_formTransCompany', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        if(!Yii::$app->user->can("reception_create"))
            throw new ForbiddenHttpException('Usted ni tiene permiso para crear una recepción');


        $model = new Reception();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionTransactions()
    {

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

    public function actionContainers()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $response = array();
        $response['msg'] = '';
        $response['containers'] = [];
        $response['success'] = false;
        $bl = Yii::$app->request->get('bl');

        if(isset($bl))
        {
            $response['containers'] = Container::find()
                                    ->innerJoin('reception_transaction', 'reception_transaction.container_id = container.id')
                                    ->innerJoin('reception', 'reception_transaction.reception_id = reception.id')
                                    ->where(['bl'=>$bl])
                                    ->all();
            $response['success'] = true;
        }
        else {
            $response['msg'] = "Tiene que especificar un código BL.";
        }

        return $response;
    }

    /**
     * Finds the Reception model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Reception the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Reception::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
