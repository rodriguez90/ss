<?php

namespace app\modules\administracion\controllers;

use app\modules\administracion\models\AdmUser;
use app\modules\administracion\models\AuthItem;
use Yii;

use app\modules\administracion\models\UserSearch;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
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
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
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
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if ( \Yii::$app->user->can('User_create')) {

        $confirm = Yii::$app->request->post('AdmUser')["passwordConfirm"];
        $model = new AdmUser();


        if ($model->load(Yii::$app->request->post()) ) {

        $rol = Yii::$app->request->post("rol");

        if($rol=="---" ||  $rol ==null){
            $model->addError('error', 'Seleccione almenos un rol.');
        }

        if( $confirm!=null && $model->password != $confirm){
            $model->addError('error', 'Las contraseñas no son iguales.');
        }

        if (!$model->hasErrors())
            {
                $model->setPassword($model->password);
                if ($model->save())
                {
                    $auth =  Yii::$app->authManager;
                    $rol_user = $auth->createRole($rol);
                    $auth->assign($rol_user,$model->id);
                    return $this->redirect(['view', 'id' => $model->id]);
                }

            }
            return $this->render('create', ['model' => $model ]);
        }

        return $this->render('create', [ 'model' => $model ]);

        }
        else{
            throw new ForbiddenHttpException('Acceso denegado');
        }
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $confirm = Yii::$app->request->post('AdmUser')["passwordConfirm"];

        if ($model->load(Yii::$app->request->post()) ) {

            $rol = Yii::$app->request->post("rol");

            if($rol=="---" ||  $rol ==null){
                $model->addError('error', 'Seleccione almenos un rol.');
            }

            if( $confirm!=null && $model->password != $confirm){
                $model->addError('error', 'Las contraseñas no son iguales.');
            }

            if (!$model->hasErrors())
            {
                $model->setPassword($model->password);
                if ($model->save())
                {
                    $auth =  Yii::$app->authManager;
                    $new_rol = $auth->createRole($rol);
                    $rol_actual=$auth->getRolesByUser($model->id);

                    $auth->revoke($rol_actual,$model->id);

                    $auth->assign($new_rol,$model->id);
                }

            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AdmUser::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
