<?php

namespace frontend\controllers;

use common\models\News;
use common\models\subscriber;
use frontend\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use Yii;
use yii\base\InvalidParamException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * Site controller
 */
class SiteController extends Controller
{
    public $enableCsrfValidation = false;
    public $successUrl = 'Success';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
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
                    'switch-language' => ['post'],
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
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'successCallback'],
            ]
        ];
    }

    public function successCallback($client)
    {
        $attributes = $client->getUserAttributes();
//        die(print_r($attributes));

        $model = subscriber::find()->where(['id_facebook' => $attributes['id']])->one();
        if (!empty($model)) {
            $session = Yii::$app->session;
            Yii::$app->user->login($model);
        } else {
            // save to database
            $model = new subscriber();
            $model->full_name = $attributes['name'];
            if (isset($attributes['email']) && $attributes['email'] != null) {
                $model->email = $attributes['email'];
            }
            $model->id_facebook = $attributes['id'];
            $model->save(false);
            // start to login
            Yii::$app->user->login($model);
        }
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            if ($model->login()) {
                $message = Yii::t('app', 'Login success');
                return $this->render('index', ['message' => $message, 'success' => true]);
            } else {
                $message = Yii::t('app', 'Login failed');
                Yii::error($model->getErrors());
                return $this->render('index', [
                    'model' => $model,
                    'message' => $message,
                    'success' => false
                ]);
            }
        } else {
            return $this->render('index', ['show_login' => 'show']);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        $message = Yii::t('app', 'Logout success');
        return $this->render('index', ['message' => $message, 'success' => true]);
    }

    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    $message = Yii::t('app', 'Register success');
                    return $this->render('index', [
                        'message' => $message,
                        'success' => true
                    ]);
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->getSession()->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->getSession()->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->getSession()->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    public function actionAbout()
    {
        $new = News::findOne(['type' => News::TYPE_ABOUT, 'status' => News::STATUS_ACTIVE]);
        if (!$new) {
            \Yii::$app->session->setFlash('error', Yii::t('app', 'Not yet update info'));
            return $this->redirect(['site/index']);
        }
        return $this->render('detail', [
            'new' => $new,
        ]);
    }

    public function actionContact()
    {
        $new = News::findOne(['type' => News::TYPE_CONTACT, 'status' => News::STATUS_ACTIVE]);
        if (!$new) {
            \Yii::$app->session->setFlash('error', Yii::t('app', 'Not yet update info'));
            return $this->redirect(['site/index']);
        }
        return $this->render('detail', [
            'new' => $new,
        ]);
    }

    public function actionSwitchLanguage(){
        $language = Yii::$app->request->post('language');
        if($language){
            Yii::$app->language = $language;
            $cookies = Yii::$app->response->cookies;
            $cookies->add(new \yii\web\Cookie([
                'name' => 'language',
                'value' => $language,
            ]));
            return true;
        }
    }
}
