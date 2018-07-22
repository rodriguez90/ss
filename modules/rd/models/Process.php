<?php

namespace app\modules\rd\models;

use Yii;
use app\modules\rd\models\Ticket;

/**
 * This is the model class for table "process".
 *
 * @property string $id Número
 * @property string $bl BL
 * @property int $agency_id Cliente
 * @property int $active Activo
 * @property string $delivery_date Fecha Líimite
 * @property int $type Processo
 * @property string $created_at Fecha de Creación
 *
 * @property Line $line
 * @property Agency $agency
 * @property ProcessTransaction[] $processTransactions
 */
class Process extends \yii\db\ActiveRecord
{
    const PROCESS_IMPORT = 1;
    const PROCESS_EXPORT = 2;

    const PROCESS_LABEL = [1=>'Importación',
        2=>'Exportación'];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'process';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bl', 'agency_id', 'active', 'delivery_date', 'type'], 'required'],
            [['bl'], 'string'],
            [['agency_id', 'active', 'type', 'line_id'], 'integer'],
            [['delivery_date', 'created_at'], 'safe'],
            [['line_id'], 'exist', 'skipOnError' => true, 'targetClass' => Line::className(), 'targetAttribute' => ['line_id' => 'id']],
            [['agency_id'], 'exist', 'skipOnError' => true, 'targetClass' => Agency::className(), 'targetAttribute' => ['agency_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Número',
            'bl' => 'BL',
            'agency_id' => 'Cliente',
            'active' => 'Activo',
            'delivery_date' => 'Fecha Límite',
            'type' => 'Tipo de trámite',
            'created_at' => 'Fecha de Creación',
            'line_id' => 'Linea',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLine()
    {
        return $this->hasOne(Line::className(), ['id' => 'line_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAgency()
    {
        return $this->hasOne(Agency::className(), ['id' => 'agency_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProcessTransactions()
    {
        return $this->hasMany(ProcessTransaction::className(), ['process_id' => 'id'])->andWhere(['active'=>1]);
    }

    public function getProcessTransactionsByUser()
    {
        $user = Yii::$app->user->identity;
        $condition = $user->processCondition();
        if(count($condition) > 0)
        {
            return ProcessTransaction::find()
                    ->innerJoin('process','process_id=process.id')
                    ->where(['process_id'=>$this->id])
                    ->andWhere($condition)
                    ->andWhere(['or','process_transaction.active='. 1, 'process_transaction.active='. 0])
                    ->all();
        }

        return [];
    }

    public function getProcessTransactionsByTransCompany($transCompanyId)
    {
        return ProcessTransaction::find()->where(['process_id'=>$this->id])
                                         ->andWhere(['trans_company_id'=>$transCompanyId])
                                         ->andWhere(['active'=>1])
                                         ->all();
    }

    public function getContainerAmount()
    {
        return $this->getProcessTransactions()->count();
    }

    public function getCountTicketReserved()
    {
        return Ticket::find()
                ->innerJoin('process_transaction', 'process_transaction.id=ticket.process_transaction_id')
                ->innerJoin('process', 'process_transaction.process_id=process.id')
                ->where(['process.id'=>$this->id])
                ->count();
    }
}
