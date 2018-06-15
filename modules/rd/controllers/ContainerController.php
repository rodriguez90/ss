<?php

namespace app\modules\rd\controllers;

use Codeception\Util\JsonArray;
use Yii;
use app\modules\rd\models\Container;
use app\modules\rd\models\ContainerSearch;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ContainerController implements the CRUD actions for Container model.
 */
class ContainerController extends Controller
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
                ],
            ],
        ];
    }

    /**
     * Lists all Container models.
     * @return mixed
     */
    public function actionIndex()
    {
        if(!Yii::$app->user->can("warehouse_list"))
            throw new ForbiddenHttpException('Usted no tiene permiso ver esta vista');

        $searchModel = new ContainerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Container model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        if(!Yii::$app->user->can("warehouse_view"))
            throw new ForbiddenHttpException('Usted no tiene permiso ver esta vista');

        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Container model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if(!Yii::$app->user->can("warehouse_create"))
            throw new ForbiddenHttpException('Usted no tiene permiso ver esta vista');

        $model = new Container();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Container model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        if(!Yii::$app->user->can("warehouse_update"))
            throw new ForbiddenHttpException('Usted no tiene permiso ver esta vista');

        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Container model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if(!Yii::$app->user->can("warehouse_delete"))
            throw new ForbiddenHttpException('Usted no tiene permiso ver esta vista');

        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionGetContainerJson($blCode)
    {
        $data =  [];
        $types = ["DRY", "RRF"];
        $tonnages = ["20", "40"];
        // alert("Random: " +);;

        for ($i = 0; $i < 10; $i++)
        {
            $container = [
                'name'=>"Contenedor " + $i,
                'type'=>"Type " + $i,
                'deliver_date'=>new DateTime(),
                'agency'=>"Agencia " + $i,
            ];
//            data.
        }
    }

    /**
     * Finds the Container model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Container the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Container::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
