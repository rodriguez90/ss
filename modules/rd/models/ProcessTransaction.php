<?php

namespace app\modules\rd\models;

use Yii;

/**
 * This is the model class for table "process_transaction".
 *
 * @property int $id
 * @property string $process_id
 * @property int $container_id
 * @property string $register_truck
 * @property string $register_driver
 * @property string $delivery_date
 * @property int $active
 * @property string $name_driver
 * @property int $trans_company_id
 *
 * @property Container $container
 * @property Process $process
 * @property TransCompany $transCompany
 * @property Ticket $ticket
 */
class ProcessTransaction extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'process_transaction';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['process_id', 'container_id', 'delivery_date', 'active', 'trans_company_id'], 'required'],
            [['process_id', 'container_id', 'active', 'trans_company_id'], 'integer'],
            [['register_truck', 'register_driver', 'name_driver'], 'string'],
            [['delivery_date'], 'safe'],
            [['container_id'], 'exist', 'skipOnError' => true, 'targetClass' => Container::class, 'targetAttribute' => ['container_id' => 'id']],
            [['process_id'], 'exist', 'skipOnError' => true, 'targetClass' => Process::class, 'targetAttribute' => ['process_id' => 'id']],
            [['trans_company_id'], 'exist', 'skipOnError' => true, 'targetClass' => TransCompany::class, 'targetAttribute' => ['trans_company_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'process_id' => 'Número',
            'container_id' => 'Contenedor',
            'register_truck' => 'Placa del Camión',
            'register_driver' => 'Cédula del Chofer',
            'delivery_date' => 'Fecha de Devolución',
            'active' => 'Activa',
            'name_driver' => 'Nombre del Chofer',
            'trans_company_id' => 'Compañia de Transporte',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContainer()
    {
        return $this->hasOne(Container::class, ['id' => 'container_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProcess()
    {
        return $this->hasOne(Process::class, ['id' => 'process_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransCompany()
    {
        return $this->hasOne(TransCompany::class, ['id' => 'trans_company_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTicket()
    {
        return $this->hasOne(Ticket::class, ['process_transaction_id' => 'id']);
    }
}
