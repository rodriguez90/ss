<?php

namespace app\modules\rd\models;

use Yii;

/**
 * This is the model class for table "process".
 *
 * @property string $id
 * @property string $bl
 * @property int $agency_id
 * @property int $active
 * @property string $created_at
 * @property int $type
 *
 * @property Agency $agency
 * @property ProcessTransaction[] $processTransactions
 */
class Process extends \yii\db\ActiveRecord
{
    const PROCESS_IMPORT = 1;
    const PROCESS_EXPORT = 2;

    const PROCESS_LABEL = [PROCESS_IMPORT=>'Importación',
        PROCESS_EXPORT=>'Exportación'];

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
            [['bl', 'agency_id', 'active', 'type'], 'required'],
            [['bl'], 'string'],
            [['agency_id', 'active', 'type'], 'integer'],
            [['created_at'], 'safe'],
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
            'active' => 'Activa',
            'created_at' => 'Fecha de Límite',
            'type' => 'Proceso',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAgency()
    {
        return $this->hasOne(Agency::class, ['id' => 'agency_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProcessTransactions()
    {
        return $this->hasMany(ProcessTransaction::class, ['process_id' => 'id']);
    }

    public function getContainerAmount()
    {
        return $this->getReceptionTransactions()->count();
    }
}
