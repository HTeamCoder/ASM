<?php
namespace backend\controllers;

//use common\models\AccessRules;
use backend\models\ChiPhiKhac;
use backend\models\DonViTinh;
use backend\models\HouseBill;
use backend\models\KhoCang;
use backend\models\MasterBillOfLoading;
use backend\models\search\ChiTietHBLSearch;
use backend\models\Vessel;
use Yii;
use yii\base\Exception;
use yii\helpers\Json;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use common\models\myFuncs;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['login','logout', 'index', 'error', 'updatekhocang','updatevesselmbl'],
                'rules' => [
                    [
                        'actions' => ['login'],
                        'allow' => true,
                        'roles' => ['?']
                    ],
                    [
                        'actions' => ['error', 'updatekhocang', 'updatehbl','updatevesselmbl'],
                        'allow' => true
                    ],
                    [
                        'actions' => ['logout', 'index','importchiphihbl','updatetongtienhbl'],
                        'allow' => true,
//                        'matchCallback' => function($rule, $action){
//                            return Yii::$app->user->identity->username == 'adamin';
//                        }
                        'roles' => ['@']
                    ],
                ],
//                'denyCallback' => function ($rule, $action) {
//                    throw new Exception('You are not allowed to access this page', 404);
//                }
            ],
//            'verbs' => [
//                'class' => VerbFilter::className(),
//                'actions' => [
//                    'logout' => ['post'],
//                ],
//            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->renderPartial('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionError()
    {
        $exception = Yii::$app->errorHandler->exception;
        if ($exception !== null) {
            if(Yii::$app->request->isAjax){
                echo myFuncs::getMessage($exception->getMessage(),'danger', "Lỗi!");
                exit;
            }
            return $this->render('error', ['exception' => $exception]);
        }
    }
}
