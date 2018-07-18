<?php

namespace app\modules\rd\controllers;

use app\modules\rd\models\TransCompanyPhone;
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
                    'trunks' => ['GET'],
                    'drivers' => ['GET'],
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

            for ($count = 0; $count <1000; $count++) {
                $phone = Yii::$app->request->post('telefono-' . $count);
                if ($phone != null) {
                    $phonenumber = new TransCompanyPhone();
                    $phonenumber->phone_number = $phone;
                    $phonenumber->trans_company_id = $model->id;
                    $phonenumber->save();
                }else{
                    break;
                }
            }
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
        $phones = TransCompanyPhone::findAll(['trans_company_id'=>$model->id]);
        $number1 = null;
        if(count($phones)>0 ){
            $number1 = array_shift($phones);
        }


        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            foreach ($phones as $p){
                $p->delete();
            }
            if($number1!=null)
                $number1->delete();

            for ($count = 0; $count <1000; $count++) {
                $phone = Yii::$app->request->post('telefono-' . $count);
                if ($phone != null) {
                    $phonenumber = new TransCompanyPhone();
                    $phonenumber->phone_number = $phone;
                    $phonenumber->trans_company_id = $model->id;
                    $phonenumber->save();
                }else{
                    break;
                }
            }

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,'phones'=>$phones,'number1'=>$number1,
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

        $model = $this->findModel($id);

        if($model)
        {
            $model->active = -1;
            $model->save();
        }

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
                $doCommit = false;

                foreach ($results as $result)
                {
                    $t = TransCompany::findOne(['ruc'=>$result['ruc_empresa']]);

                    if($t === null)
                    {
                        $doCommit = true;
                        $t = new TransCompany();
                        $str = utf8_decode($result['nombre_empresa']);
                        $t->name = $str;
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
                        $str = utf8_encode($t->name);
                        $t->name = $str;
                    }
                    $response['trans_companies'][] = $t;
                }

                if($response['success'])
                {
                    if($doCommit)
                        $trasaction->commit();
                }
                else
                {
                    $trasaction->rollBack();
                }
            }
            catch ( \PDOException $e)
            {
                if($e->getCode() !== '01000')
                {
                    $response['success'] = false;
                    $response['msg'] = "Ah ocurrido un error al buscar las Empresas de Transporte.";
                    $response['msg_dev'] = $e->getMessage();
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
        $response['trunks'] = [];
        $response['msg'] = '';
        $response['msg_dev'] = '';

        $code = Yii::$app->request->get('code');
        $mode = Yii::$app->request->get('mode');

        if(!isset($code))
        {
            $response['success'] = false;
            $response['msg'] = "Debe especificar el código de búsqueda.";
        }

        if($response['success'])
        {
            if($mode == 1)
            {
                $sql = "exec sp_sgt_placa_cons '" .$code ."'";
                $response['trunks'] = Yii::$app->db2->createCommand($sql)->queryAll();
            }
            else
            {
//                id: item.placa,
//                                    text: item.placa,
//                                    err_code: item.err_code,
//                                    err_msg: item.err_msg,
//                                    rfid: item.rfid,

                for($i = 0; $i < 5; $i++)
                {
                   $trunk = ['placa'=>$i . $i . $i,
                             'err_code'=>"0",
                             'err_msg'=>"",
                             'rfid'=>$i . $i . $i];

                    $response['trunks'][] = $trunk;
                }
            }
        }
        return $response;
    }

    public function actionDrivers()
    {
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
            $sql = "exec sp_sgt_chofer_cons '" .$code ."'";
            $response['drivers'] = Yii::$app->db2->createCommand($sql)->queryAll();
        }
        return $response;
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

        $model = TransCompany::find()
            ->where(['id'=>$id])
            ->andWhere(['<>', 'active',-1])
            ->one();

        if ($model  !== null) {
            return $model;
        }


        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
