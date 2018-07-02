<?php

namespace app\modules\rd\controllers;

use app\modules\administracion\models\AdmUser;
use app\modules\rd\models\Ticket;
use app\modules\rd\models\Warehouse;
use DateTime;
use DateTimeZone;
use Yii;
use app\modules\rd\models\Calendar;
use app\modules\rd\models\CalendarSearch;
use yii\db\Exception;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\filters\AccessControl;

/**
 * CalendarController implements the CRUD actions for Calendar model.
 */
class CalendarController extends Controller
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
     * Lists all Calendar models.
     * @return mixed
     */
    public function actionIndex()
    {
        if ( \Yii::$app->user->can('calendar_list')) {

            $model = new Calendar();

            return $this->render('create',[ 'model' => $model]);
        } else{
            throw new ForbiddenHttpException('Acceso denegado');
        }
    }

    /**
     * Displays a single Calendar model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        if(!Yii::$app->user->can("calendar_view"))
            throw new ForbiddenHttpException('Usted no tiene permiso ver esta vista');

        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Calendar model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if ( \Yii::$app->user->can('calendar_create')) {


            Yii::$app->response->format = Response::FORMAT_JSON;

            $result = [];
            $result ['events'] = [];
            $result ['msg'] = "";
            $result ['msg_dev'] ="";

            $events = Yii::$app->request->post('events');

            $transaction = Calendar::getDb()->beginTransaction();

            $ok = true;


            try{

                $id_warehouse = Warehouse::find()
                    ->innerJoin("","")
                    ->where(['user_id'=>\Yii::$app->user->getId()])
                    ->select("id");

                foreach ( $events as $event) {

                    if((int)$event['id'] == -1){

                        $model = new Calendar();
                        $aux = new DateTime($event['start']);
                        $aux->setTimezone(new DateTimeZone("UTC"));
                        $model->start_datetime = $aux->format("Y-m-d H:i:s");  //date_format( new \DateTime($event['start'],new DateTimeZone("UTC")),"Y-m-d G:i:s");
                        var_dump($model->start_datetime);

                        $aux1 = new DateTime($event['end']);
                        $aux1->setTimezone(new DateTimeZone("UTC"));
                        $model->end_datetime = $aux1->format("Y-m-d H:i:s");// date_format(new \DateTime($event['end'],new DateTimeZone("UTC")),"Y-m-d G:i:s");
                        var_dump($model->end_datetime);
//                        die;
                        $model->amount = $event['title'];
                        $model->id_warehouse =  1;

                        if($ok && !$model->save())
                        {
                            $ok = false;
                            $result ['status']= 0;
                            $result['msg'] = "Error al crear a disponibilidad en el calendario.";
                            $result['msg_dev'] = implode(" ", $model->getErrors(false));
                            break;
                        }

                        $event = ['update'=>false, 'id'=>$model->id, 'title'=>$model->amount,'start'=>$model->start_datetime,'end'=>$model->end_datetime  , 'url'=>Url::toRoute('/rd/calendar/delete?id='.$model->id),   'allDay'=>false, 'className'=>['event_rd'], 'editable'=>false];
                        $result ['events'] [] = $event;

                    }
                    else{
                        $model = Calendar::findOne($event['id']);
                        $aux = new \DateTime($event['start']);
                        $aux->setTimezone(new DateTimeZone("UTC"));
                        $model->start_datetime = $aux->format("Y-m-d H:i:s");  //date_format( new \DateTime($event['start'],new DateTimeZone("UTC")),"Y-m-d G:i:s");
                        var_dump($model->start_datetime);

                        $aux1 = new \DateTime($event['end']);
                        $aux1->setTimezone(new DateTimeZone("UTC"));
                        $model->end_datetime = $aux1->format("Y-m-d H:i:s");// date_format(new \DateTime($event['end'],new DateTimeZone("UTC")),"Y-m-d G:i:s");
                        var_dump($model->end_datetime);

                        die;

                        $reservados = Calendar::find()
                            ->innerJoin("ticket","calendar.id = ticket.calendar_id")
                            ->where(["calendar.id"=>$model->id])
                            ->count();

                        if( (int)$reservados <= (int)$event['title'] ){
                            $model->amount = $event['title'];
                            if($model->update() == false)
                            {
                                $ok = false;
                                $result ['status']= 0;
                                $result['msg'] = "Error al crear a disponibilidad en el calendario.";
                                //$result['msg_dev'] = implode(" ", $model->getErrors(false));
                                break;
                            }
                        }

                        $event = ['update'=>false, 'id'=>$model->id, 'title'=>$model->amount,'start'=>$model->start_datetime,'end'=>$model->end_datetime  , 'url'=>Url::toRoute('/rd/calendar/delete?id='.$model->id),   'allDay'=>false, 'className'=>['event_rd'], 'editable'=>false];
                        $result ['events'] [] = $event;
                    }
                }

                if($ok)
                {
                    $transaction->commit();
                    $result ['status']= 1;
                    $result['msg'] = "Disponibilidad creada correctamente.";
                }
                else{
                    $transaction->rollBack();
                }

            }catch (\PDOException $ex){


                if($ex->getCode() !== '01000')
                {
                    $result ['status']= 0;
                    $result['msg'] = "!Error: ".$ex->getMessage();
                    $transaction->rollBack();
                }
            }


            return $result;

        }
        else{
            throw new ForbiddenHttpException('Acceso denegado');
        }
        /*

        $model = new Calendar();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);

        */

    }

    /**
     * Updates an existing Calendar model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    /*
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }
*/
    /**
     * Deletes an existing Calendar model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if ( \Yii::$app->user->can('calendar_delete')) {

            Yii::$app->response->format = Response::FORMAT_JSON;
            $result = [];
            $model = $this->findModel($id);
            $amount = $model->amount;


            $reservados = Calendar::find()
                ->innerJoin("ticket","calendar.id = ticket.calendar_id")
                ->where(["calendar.id"=>$model->id])
                ->count();

            if($reservados == 0){
                //var_dump($reservados);
                if($this->findModel($id)->delete()>0){
                    $result ['status']= 1;
                    $result['msg'] = "Cupos eliminados: ".$amount;
                }else{
                    $result ['status']= 0;
                    $result['msg'] = "No se pudieron eliminar los cupos.";
                }
            }else{
                $result ['status']= 0;
                $result['msg'] = "No se pueden eliminar cupos reservados.";
            }

            return $result;
        }
        else{
            throw new ForbiddenHttpException('Acceso denegado');
        }

        // return $this->redirect(['index']);
    }

    /**
     * Finds the Calendar model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Calendar the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Calendar::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    public function actionGetcalendar(){

//        if ( \Yii::$app->user->can('calendar_list')) {

            Yii::$app->response->format = Response::FORMAT_JSON;

            $startDate = Yii::$app->request->get('start');
            $endDate = Yii::$app->request->get('end');
            $calendars= [];

            /*
             * Select * from calendar
             * Where start >= $startDate and end <= $endDate
             * Order By start, ASC
             */

            $query =  Calendar::find();

            if(isset($startDate) && $startDate !== "")
            {
                $aux = new \DateTime($startDate);
                $aux->setTimezone(new DateTimeZone("UTC"));
                $datetimeFormated = $aux->format("Y-m-d G:i:s");
//                var_dump($datetimeFormated);
                $query->andWhere(['>=','start_datetime', $datetimeFormated]);
            }
            if (isset($endDate) && $endDate !== "")
            {
                $aux = new \DateTime($endDate);
                $aux->setTimezone(new DateTimeZone("UTC"));
                $datetimeFormated = $aux->format("Y-m-d G:i:s");
//                var_dump($datetimeFormated);die;
                $query->andWhere(['<=','end_datetime', $datetimeFormated]);
            }

            $calendars= $query
                        ->orderBy("start_datetime",SORT_ASC)
                        ->all();

            $result = [];

            foreach ($calendars as $cal){
                $result [] = [
                    'id'=>$cal['id'],
                    'title'=>$cal['amount']."",
                    'start'=> $cal['start_datetime'] ,
                    'end'=>$cal['end_datetime'],
                    'count'=>$cal['amount'],
                    'update'=>false,
                    'allDay'=> false,
                    'className'=>['event_rd bg-blue'],
                    'editable'=>false,
                    'url'=>Url::toRoute('/rd/calendar/delete?id='.$cal['id'])
                ];
            }
            return $result;


//        } else{
//            throw new ForbiddenHttpException('Acceso denegado');
//        }
    }
}
