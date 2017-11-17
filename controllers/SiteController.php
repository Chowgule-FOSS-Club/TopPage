<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\QuestionBank;
use app\models\Questions;
use app\models\Options;
use app\models\UsersOptionsAnswers;
use app\models\SetGenerator;

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
    public function actionTest(){
        $setGen = new SetGenerator();
        $setGen->getSet();
    }
     /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $model = new QuestionBank();
        if ($model->load(Yii::$app->request->post())) {
            $uid = Yii::$app->user->identity->getid();
            $checkboxData =  $model->checkboxData;
            $answerString = "";
            foreach($checkboxData as $check){
                $answerString .= $check;
            }
            
            //echo $answerString ."<br>";
            $answerString = str_replace("01","1",$answerString) . "<br>";
            $questions = $model->questions;
            $options = $model->options;
            $optionCount = $model->optionCount;
            $iCount = 0; // iCount is the counter to which option we are corrently at.
            foreach($questions as $key=>$question){
                $questionObj = new Questions();
                $questionObj->name = $question;
                $questionObj->save(false);

                echo $answerString; 
                echo $question. "<br>";
                
                //echo $optionCount[$key];
                for($i = 0; $i < $optionCount[$key]; $i++){
                    $optionObj = new Options();
                    $optionObj->name = $options[$iCount];
                    $optionObj->save();
                    echo "Option Inerted - ".$options[$iCount]."<br>";
                    if($answerString[$iCount]=='0'){
                        echo "Answer value is 0 <br>";
                        echo "VALUES<br> uid=".$uid."<br>qid=".$questionObj->getPrimaryKey()."<br>oid=".$optionObj->getPrimaryKey()."<br>";
                        $questionAnswer = new UsersOptionsAnswers();
                        $questionAnswer->uid = $uid;
                        $questionAnswer->qid = $questionObj->getPrimaryKey();
                        $questionAnswer->oid = $optionObj->getPrimaryKey();
                        $questionAnswer->flag = 'false';
                        if($questionAnswer->save(false)){
                            echo "Record Inserted <br>";
                        }else{
                            echo "Fail <br>";
                        }
                    }else{
                        echo "Answer value is 1 <br>";
                        $questionAnswer = new UsersOptionsAnswers();
                        echo "VALUES<br> uid=".$uid."<br>qid=".$questionObj->getPrimaryKey()."<br>oid=".$optionObj->getPrimaryKey()."<br>";
                        $questionAnswer->uid = $uid;
                        $questionAnswer->qid = $questionObj->getPrimaryKey();
                        $questionAnswer->oid = $optionObj->getPrimaryKey();
                        $questionAnswer->flag = 'true';
                        if($questionAnswer->save(false)){
                            echo "Record Inserted <br>";
                        }else{
                            echo "Fail <br>";
                        }
                    }
                    echo "-----------<br>";
                    $iCount++;
                }
            }
        }else{
            return $this->render('index', [
                'model' => $model,
            ]);
        }
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
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
