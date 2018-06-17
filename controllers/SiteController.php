<?php

namespace app\controllers;

use app\modules\administracion\models\AdmUser;
use app\modules\rd\models\Process;
use app\modules\rd\models\ProcessSearch;
use app\modules\rd\models\Reception;
use app\modules\rd\models\ReceptionSearch;
use app\modules\rd\models\ReceptionTransaction;
use app\modules\rd\models\TicketSearch;
use app\modules\rd\models\UserAgency;
use app\modules\rd\models\UserTranscompany;

use DateTime;
use DateTimeZone;


use Yii;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

use Da\QrCode\QrCode;


class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout', 'contact', 'about', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                   // 'logout' => ['post','get'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $user = AdmUser::findOne(['id'=>Yii::$app->user->getId()]);
        $params = Yii::$app->request->queryParams;
        if($user && $user->hasRol('Agencia'))
        {
            $userAgency = UserAgency::findOne(['user_id'=>$user->id]);
            $params['agency_id'] = '';
//            if($userAgency)
//            {
//                $params['agency_id'] = $userAgency->agency->name;
//            }
        }
        else if ($user && $user->hasRol('Cia_transporte')){
            $userCiaTrans = UserTranscompany::findOne(['user_id'=>$user->id]);
            $params['trans_company_id'] = '';
            if($userCiaTrans)
            {
                $params['trans_company_id'] = $userCiaTrans->transcompany->name;
            }
        }

        $searchModel = new ProcessSearch();
        $dataProvider = $searchModel->search($params);
        $importCount = $searchModel->search(["type"=>Process::PROCESS_IMPORT])->totalCount;
        $exportCount = $searchModel->search(["type"=>Process::PROCESS_EXPORT])->totalCount;
        $ticketCount = TicketSearch::find()->count();
        $myparams = array();
        $myparams['searchModel'] = $searchModel;
        $myparams['dataProvider'] = $dataProvider;
        $myparams['importCount'] = $importCount;
        $myparams['exportCount'] = $exportCount;
        $myparams['ticketCount'] = $ticketCount;
        return $this->render('index', $myparams);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        $this->layout = '@app/views/layouts/login';

        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()))
        {
            if ($model->login())
            {
                $session = Yii::$app->session;
                $session->open();

                $user = AdmUser::findOne(['id'=>Yii::$app->user->id]);
                $session->set('user',$user);

                return $this->redirect(Url::toRoute('/site/index'));
            }
            else
            {
                return $this->render('login', ['model' => $model]);
            }

        }else{
            return $this->render('login', ['model' => $model]);
        }


    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        if(Yii::$app->user->logout())
            return $this->redirect(Url::toRoute('/site/login') );
        //return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionQr(){

        $qrCode = new QrCode("yopt");

        $qrCode->writeFile(__DIR__ . '/my-code.png');


    }

}
