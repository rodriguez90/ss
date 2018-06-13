<?php

namespace app\controllers;

use app\modules\administracion\models\AdmUser;
use app\modules\rd\models\Reception;
use app\modules\rd\models\ReceptionSearch;
use app\modules\rd\models\ReceptionTransaction;
use app\modules\rd\models\UserAgency;
use app\modules\rd\models\UserTranscompany;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;


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
        $user = AdmUser::findOne(['id'=>Yii::$app->user->id]);
//        var_dump($user);die;
        $params = Yii::$app->request->queryParams;
//        var_dump($params);die;
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
        $receptionCount = $searchModel->search($params)->totalCount;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'receptionCount'=>$receptionCount
        ]);
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

//        var_dump(Yii::$app->user->getReturnUrl());die;

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()))
        {
            if ($model->login())
            {
                $session = Yii::$app->session;
                $session->open();

//                $urlBeforeLogin = Yii::$app->session->get('urlBeforeLogin');
//                var_dump($urlBeforeLogin);die;
//                if(!empty($urlBeforeLogin))
//                {
//                    Yii::$app->session->set('urlBeforeLogin', null);
//
////                    return $this->redirect('/rd/reception/trans-company?id=56');
//                    return $this->redirect($urlBeforeLogin);
//                }

                $user = AdmUser::findOne(['id'=>Yii::$app->user->id]);
                $session->set('user',$user);

                return $this->redirect('/site/index');
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
            return $this->redirect("/site/login" );
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
}
