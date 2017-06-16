<?php

namespace app\controllers;

use app\models\Guestbook;
use app\models\GuestbookForm;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{

    public $defaultAction = 'guestbook';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
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
        return $this->redirect(['site/guestbook'], 302);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Отобразить гостевую книгу
     *
     * @return string|Response
     */
    public function actionGuestbook()
    {
        $model = new GuestbookForm();
        $dataProvider = new ActiveDataProvider([
            'query' => Guestbook::find(),
            'sort' => [
                'attributes' => [ 'username', 'email', 'date' ],
                'defaultOrder' => [ 'date' => SORT_DESC ]
            ],
            'pagination' => [
                'pageSize' => 15,
            ]
        ]);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->save();

            return $this->refresh();
        }

        return $this->render('guestbook', [
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }

}
