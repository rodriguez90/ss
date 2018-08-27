<?php

namespace app\modules\rd\controllers;

use app\modules\rd\models\Container;
use app\modules\rd\models\ContainerType;
use app\modules\rd\models\ContainerSearch;
use app\modules\rd\models\ProcessTransaction;

use Yii;
use yii\db\Command;
use yii\db\Exception;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Response;

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
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
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
        if(!Yii::$app->user->can("container_list"))
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
        if(!Yii::$app->user->can("container_view"))
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
        if(!Yii::$app->user->can("container_create"))
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
        if(!Yii::$app->user->can("container_update"))
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
        if(!Yii::$app->user->can("container_delete"))
            throw new ForbiddenHttpException('Usted no tiene permiso ver esta vista');

        $model = $this->findModel($id);

        if($model)
        {
            $model->active = -1;
            $model->save();
        }

        return $this->redirect(['index']);
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
        if (($model = Container::findOne(['id'=>$id, 'active'=>1])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
