<?php
/**
 * Created by PhpStorm.
 * User: pedro
 * Date: 01/06/2018
 * Time: 9:52
 */

namespace app\modules\rd\controllers;


use yii\rest\ActiveController;

class ApiTransCompanyController extends ActiveController
{
    public $modelClass = 'app\modules\rd\models\TransCompany';

    public function behaviors()
    {
        // remove rateLimiter which requires an authenticated user to work
        $behaviors = parent::behaviors();
        unset($behaviors['rateLimiter']);
        return $behaviors;
    }
}