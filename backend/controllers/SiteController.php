<?php
namespace backend\controllers;


use backend\models\Donhang;
use backend\models\Hocvien;
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
        $hocvien_count = Hocvien::find()->count();
        $donhangs = Donhang::find()->orderBy('id DESC')->all();
        return $this->render('index',['donhangs'=>$donhangs,'hocvien_count'=>$hocvien_count]);
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
    public function actionGetlichthidonhang(){
        $donhang = Donhang::find()->select('ngaythi,id,name')->all();
        echo Json::encode($donhang);
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
