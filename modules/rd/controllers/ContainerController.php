<?php

namespace app\modules\rd\controllers;

use app\modules\rd\models\ProcessTransaction;
use Yii;
use app\modules\rd\models\Container;
use app\modules\rd\models\ContainerType;
use app\modules\rd\models\ContainerSearch;
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
                    'containers' => ['GET']
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

        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionContainers()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $response = array();
        $response['success'] = true;
        $response['containers'] = [];
        $response['msg'] = '';
        $response['msg_dev'] = '';

        $bl = Yii::$app->request->get('bl');

        if(!isset($bl))
        {
            $response['success'] = false;
            $response['msg'] = "Debe especificar el código de búsqueda.";
        }

        if($response['success'])
        {
            try{
                $sql = "exec disv..sp_sgt_bl_cons " . $bl;
                $results = Yii::$app->db->createCommand($sql)->queryAll();

                foreach ($results as $result) {

                    $data = Container::find()
                        ->select('container.id, 
                                           container.name, 
                                           container.status, 
                                           process_transaction.delivery_date as deliveryDate, 
                                           process_transaction.id as ptId, 
                                           container_type.id as typeId, 
                                           container_type.name as typeName, 
                                           container_type.code as typeCode, 
                                           container_type.tonnage as typeTonnage')
                        ->innerJoin('process_transaction', 'process_transaction.container_id=container.id')
                        ->innerJoin('process', 'process.id=process_transaction.process_id')
                        ->innerJoin('container_type', 'container_type.id=container.type_id')
                        ->where(['process.bl' => $bl])
                        ->andWhere(['container.name' => $result['contenedor']])
                        ->asArray()
                        ->one();

                    $container = null;

                    if ($data === null) {
                        $container = [];
                        $container['id'] = -1;
                        $container['name'] = $result['contenedor'];
                        $container['ptId'] = -1;
                        $container['type'] = ["id"=>-1,"name"=>""];
                        $container['status'] = 'PENDIENTE';
                        $container['deliveryDate'] = $result['fecha_limite'];
                    }
                    else
                    {
                        $container = [];
                        $container['id'] = $data['id'];
                        $container['name'] = $data['name'];
                        $container['ptId'] =  $data['ptId'];
                        $container['type'] = new  ContainerType();
                        $container['type']->id = $data['typeId'];
                        $container['type']->name = $data['typeName'];
                        $container['type']->code = $data['typeCode'];
                        $container['type']->tonnage = $data['typeTonnage'];

                        $container['status'] = $data['status'];
                        $container['deliveryDate'] = $data['deliveryDate'];
                    }
                    $response['containers'][] = $container;
                }
            }
            catch (Exception $ex)
            {
                $response['success'] = false;
                $response['msg'] = 'Ah occurrido un error al buscar los contenedores.';
                $response['msg_dev'] = $ex->getMessage();
            }
        }
        return $response;
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

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
