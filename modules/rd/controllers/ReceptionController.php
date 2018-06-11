<?php

namespace app\modules\rd\controllers;

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
        $session = Yii::$app->session;
        $user = $session->get('user', null);


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
     * Creates a new Reception model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $session = Yii::$app->session;
        $user = $session->get('user', null);
        if($user && !($user->hasRol('Agencia')))
            throw new ForbiddenHttpException('Usted ni tiene permiso para crear una recepción');

        $model = new Reception();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
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


    public function actionCreateByAgency()
    {
        $session = Yii::$app->session;
        $user = $session->get('user', null);
        if($user && !($user->hasRol('Agencia')))
            throw new ForbiddenHttpException('Usted ni tiene permiso para crear una recepción');


        $model = new Reception();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create_agency', [
            'model' => $model,
        ]);
    }

    public function actionTransCompany($id)
    {
        $session = Yii::$app->session;
        $user = $session->get('user', null);
        if($user && !($user->hasRol('Cia_transporte')))
            throw new ForbiddenHttpException('Usted no tiene permiso para resevar cupos en la recepción');

        return $this->render('forTrasnCompany', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionTransactions()
    {

        Yii::$app->response->format = Response::FORMAT_JSON;

        $response = array();
        $response['msg'] = '';
        $response['transactions'] = [];
        $id = Yii::$app->request->get('id');
        if(isset($id))
        {
            $reception = Reception::findOne(['id'=>$id]);

            if($reception)
            {
                $response['success'] = true;
                $response['msg'] = Yii::t("app", "Datos encontrados.");
//                $response['transactions'] = json_encode($reception->receptionTransactions);
                $response['transactions'] = $reception->receptionTransactions;
                $response['reception'] = $reception;
                $response['angecy'] = $reception->agency;
                $response['containers'] = [];
                foreach ( $response['transactions'] as $t)
                {
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
