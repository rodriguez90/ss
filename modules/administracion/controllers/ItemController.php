<?php

namespace app\modules\administracion\controllers;

use PHPUnit\Framework\Exception;
use Yii;
use app\modules\administracion\models\AuthItem;
use app\modules\administracion\models\AuthItemSearch;
use yii\rbac\Item;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * ItemController implements the CRUD actions for AuthItem model.
 */
class ItemController extends Controller
{

    protected $manager;


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


/*
    public function actionIndex()
    {
        return $this->render('tabs');

    }
*/

    /**
     * Lists all AuthItem models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AuthItemSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $type = Yii::$app->request->get('type');
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'type'=>$type,
        ]);
    }

    /**
     * Displays a single AuthItem model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new AuthItem model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $type = Yii::$app->request->get('type');
        $auth =  Yii::$app->authManager;
        $item= null;
        $model = new AuthItem();
        if ($model->load(Yii::$app->request->post())) {
            if($type ==2){
                $item =  $auth->createPermission($model->name);
            }else{
                $item =  $auth->createRole($model->name);
            }
            if($item !=null){
                $item->description = $model->description;
                try{
                    $auth->add($item);
                }catch (\yii\db\Exception $ex){
                    $error_msg = $type == 1 ? 'Ya existe el rol ( '.$model->name." )" :'Ya existe el permiso ( '.$model->name." )";
                    $model->addError('error',$error_msg );
                    return $this->render('create', [ 'model' => $model, 'type' =>$type, ]);
                }
            }

            return $this->redirect(['index','type'=>$type]);

        }
        return $this->render('create', [
            'model' => $model,
            'type' =>$type,
        ]);
    }

    /**
     * Updates an existing AuthItem model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //return $this->redirect(['view', 'id' => $model->name]);
            return $this->redirect(['index','type'=>$model->type]);
        }

        return $this->render('update', [
            'model' => $model,
            'type' =>$model->type,
        ]);
    }

    /**
     * Deletes an existing AuthItem model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $item = $this->findModel($id);
        $type = $item->type;
        $item->delete();
        //preguntar si algun user tiene este rol y mandar msg de error...
        return $this->redirect(['index','type'=>$type]);
    }

    /**
     * Finds the AuthItem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return AuthItem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AuthItem::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    public function actionAssign($idparent,$idchild)
    {
        $auth =  Yii::$app->authManager;
        $rol = $auth->getRole($idparent);
        $perm = $auth->getPermission($idchild);

        if($rol != null && $perm !=null && !$auth->hasChild($rol,$perm)  ){

                $auth->addChild($rol,$perm);
            echo "OK";
            //}
        }else{
            echo "No";
        }

    }


    public function actionGetroles($term){

        Yii::$app->response->format = Response::FORMAT_JSON;

        $roles = AuthItem::find()->where(['like','name',$term])
            ->andWhere(['type'=>1])
            ->select("name")
            ->all();

        if($roles!=null)
            return $roles;

        return false;

    }







}
