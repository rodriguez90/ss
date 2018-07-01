<?php

namespace app\modules\rd\controllers;

use Yii;
use app\modules\rd\models\TransCompany;
use app\modules\rd\models\TransCompanySearch;
use yii\base\Exception;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Response;

/**
 * TransCompanyController implements the CRUD actions for TransCompany model.
 */
class TransCompanyController extends Controller
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
                    'from-sp' => ['GET'],
                ],
            ],
        ];
    }

    /**
     * Lists all TransCompany models.
     * @return mixed
     */
    public function actionIndex()
    {
        if(!Yii::$app->user->can("trans_company_list"))
            throw new ForbiddenHttpException('Usted no tiene permiso ver esta vista');

        $searchModel = new TransCompanySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TransCompany model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        if(!Yii::$app->user->can("trans_company_view"))
            throw new ForbiddenHttpException('Usted no tiene permiso ver esta vista');

        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new TransCompany model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if(!Yii::$app->user->can("trans_company_create"))
            throw new ForbiddenHttpException('Usted no tiene permiso ver esta vista');


        $model = new TransCompany();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing TransCompany model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        if(!Yii::$app->user->can("trans_company_update"))
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
     * Deletes an existing TransCompany model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if(!Yii::$app->user->can("trans_company_delete"))
            throw new ForbiddenHttpException('Usted no tiene permiso ver esta vista');

        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionFromSp()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $response = array();
        $response['success'] = true;
        $response['trans_companies'] = [];
        $response['msg'] = '';
        $response['msg_dev'] = '';

        $code = Yii::$app->request->get('code');

        if(!isset($code))
        {
            $response['success'] = false;
            $response['msg'] = "Debe especificar el código de búsqueda.";
        }

        if($response['success'])
        {
            $sql = "exec sp_sgt_companias_cons " . $code;
            $results = Yii::$app->db2->createCommand($sql)->queryAll();

            try{
                $trasaction = TransCompany::getDb()->beginTransaction();

                foreach ($results as $result)
                {
                    $t = TransCompany::findOne(['ruc'=>$result['ruc_empresa']]);

                    if($t === null)
                    {
                        $t = new TransCompany();
                        $str = iconv("CP1257", "UTF-8", $result['nombre_empresa']);
                        $t->name = Html::encode($str);
                        $t->ruc = $result['ruc_empresa'];
                        $t->address = "NO TIENE";
                        $t->active = 1;
                        if(!$t->save())
                        {
                            $response['success'] = false;
                            $response['msg'] = "Ah ocurrido un error al buscar las Empresas de Transporte.";
                            $response['msg_dev'] = implode(' ', $t->getErrors(false));
                            break;
                        }
                    }
                    else {
                        $str = iconv("CP1257", "UTF-8",  $t->name);
                        $t->name =$str;
                    }
                    $response['trans_companies'][] = $t;
                }

                if($response['success'])
                {
                    $trasaction->commit();
                }
                else
                {
                    $trasaction->rollBack();
                }
            }
            catch (Exception $e)
            {
                if($e->getCode() !== '01000')
                {
                    $trasaction->rollBack();
                }
            }
        }

        return $response;
    }

    public function actionTrunks()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $response = array();
        $response['success'] = true;
        $response['trucks'] = [];
        $response['msg'] = '';
        $response['msg_dev'] = '';

        $code = Yii::$app->request->get('code');

        if(!isset($code))
        {
            $response['success'] = false;
            $response['msg'] = "Debe especificar el código de búsqueda.";
        }

        if($response['success'])
        {
            $sql = "exec sp_sgt_placa_cons " . $code;
            $response['trucks'] = Yii::$app->db2->createCommand($sql)->queryAll();
        }

        return $response;
    }

    public function actionSPRegisterDriver()
    {
//        exec sp_sgt_chofer_cons '0992125861001'


        Yii::$app->response->format = Response::FORMAT_JSON;

        $response = array();
        $response['success'] = true;
        $response['drivers'] = [];
        $response['msg'] = '';
        $response['msg_dev'] = '';

        $code = Yii::$app->request->get('code');

        if(!isset($code))
        {
            $response['success'] = false;
            $response['msg'] = "Debe especificar el código de búsqueda.";
        }

        if($response['success'])
        {
            $sql = "exec sp_sgt_chofer_cons " . $code;
            $response['drivers'] = Yii::$app->createCommand($sql)->execute();
        }
//        mb_convert_encoding($data['name'], 'UTF-8', 'UTF-8');
        return json_encode($response);
    }

    /**
     * Finds the TransCompany model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TransCompany the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TransCompany::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
