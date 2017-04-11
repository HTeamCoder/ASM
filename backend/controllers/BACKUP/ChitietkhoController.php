<?php
/**
 * Created by PhpStorm.
 * User: hungd
 * Date: 10/15/2016
 * Time: 1:07 PM
 */

namespace backend\controllers;


use backend\models\search\ChitietkhoSearch;
use yii\web\Controller;

class ChitietkhoController extends Controller
{
    public function actionIndex(){
        $searchModel = new ChitietkhoSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}