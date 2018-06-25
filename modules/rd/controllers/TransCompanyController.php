<?php

namespace app\modules\rd\controllers;

use app\modules\rd\models\TransCompanyPhone;
use Yii;
use app\modules\rd\models\TransCompany;
use app\modules\rd\models\TransCompanySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

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

        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionSP()
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
            $result = \Yii::$app->db->createCommand("exec sp_sgt_companias_cons(:ruc)")
                ->bindValue(':ruc' , $code )
                ->execute();

            var_dump($result);die;
        }

        return $response;
    }

    public function actionSPRegisterTruck()
    {
//        exec sp_sgt_placa_cons '0992125861001'


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
            $result = \Yii::$app->db->createCommand("exec sp_sgt_placa_cons(:ruc)")
                ->bindValue(':ruc' , $code )
                ->execute();

            var_dump($result);die;
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
            $result = \Yii::$app->db->createCommand("exec sp_sgt_chofer_cons(:ruc)")
                ->bindValue(':ruc' , $code )
                ->execute();

            var_dump($result);die;
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
        if (($model = TransCompany::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
