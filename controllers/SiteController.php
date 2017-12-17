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
use app\models\fpdf;


class SiteController extends Controller
{
    
    /**
     * @inheritdoc
     */
    protected $col = 0; // Current column
    protected $y0;      // Ordinate of column start
    public $pdf;
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

    

    public function actionIndex()
    {
        if(!Yii::$app->user->isGuest){
        $model = new QuestionBank();
        if ($model->load(Yii::$app->request->post())) {
                $this->cleanUp();
                $uid = Yii::$app->user->identity->getid();
                $checkboxData =  $model->checkboxData;
                $answerString = "";
                foreach($checkboxData as $check){
                    $answerString .= $check;
                }
                $answerString = str_replace("01","1",$answerString) /* . "<br>" */;
                $questions = $model->questions;
                $options = $model->options;
                $optionCount = $model->optionCount;
                $iCount = 0; 
                foreach($questions as $key=>$question){
                    $questionObj = new Questions();
                    $questionObj->name = $question;
                    $questionObj->save(false);

                    for($i = 0; $i < $optionCount[$key]; $i++){
                        $optionObj = new Options();
                        $optionObj->name = $options[$iCount];
                        $optionObj->save();
                        if($answerString[$iCount]=='0'){
                            $questionAnswer = new UsersOptionsAnswers();
                            $questionAnswer->uid = $uid;
                            $questionAnswer->qid = $questionObj->getPrimaryKey();
                            $questionAnswer->oid = $optionObj->getPrimaryKey();
                            $questionAnswer->flag = 'false';
                        }else{
                             $questionAnswer = new UsersOptionsAnswers();
                            $questionAnswer->uid = $uid;
                            $questionAnswer->qid = $questionObj->getPrimaryKey();
                            $questionAnswer->oid = $optionObj->getPrimaryKey();
                            $questionAnswer->flag = 'true';
                            
                        }
                        $questionAnswer->save();
                        $iCount++;
                    }
                }
                
                $no_of_sets = (int)$model->setCount;
                $set = new SetGenerator();
                $randomSet = $set->getSet($uid);
                for($i=1; $i<=$no_of_sets;$i++){
                    $set = new SetGenerator();
                    $randomSet = $set->getSet($uid);
                    $this->generateQuestionPaper($randomSet, "Question-Set-". $i, $model->semester, $model->subject, $model->marks, $model->time);
                    $this->generateAnswerPaper($randomSet, "Answer-Set-". $i, $model->semester, $model->subject, $model->marks, $model->time);
                }
                $this->createZip();
            }else{
                return $this->render('index', [
                    'model' => $model,
                ]);
            }
        }else{
            $model = new LoginForm();
            if ($model->load(Yii::$app->request->post()) && $model->login()) {
                return $this->goBack();
            }
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    function Header(){
        $pdf->Rect( 4, 4 , 201 , 285);
    }

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

    public function generateAnswerPaper($randomSet, $name){
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->Rect( 4, 4 , 201 , 285);
        $pdf->SetFont('Arial','B',16);
        $pdf->Image('img/logo1.png',10,10,-200);
        $pdf->Image('img/logo2.png',175,10,-200);
        $pdf->Cell(190,7,'Parvatibai Chowgule College of Arts and Science', 0, 1, 'C');
        $pdf->Cell(190,6,'Autonomous', 0, 1, 'C');
        $pdf->Ln(1);
        $pdf->SetFont('Arial','',16);
        $pdf->Cell(190,6,$name, 0, 1, 'C');
        $pdf->Cell(190,6,'SET - A', 0, 1, 'C');
        $pdf->setFont("Arial", '', 14);
        $pdf->Cell(190,6,'____________________________________________________________', 0, 1, 'C');
        $pdf->Ln(6);
        $pdf->setFont("Arial", "", 12);
        $pdf->MultiCell(20,6,$this->getAnswers($randomSet));
        $pdf->Output("files/".$name.".pdf", "F");
    }

    public function generateQuestionPaper($randomSet, $name, $semester, $subject, $marks, $time){
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->Rect( 4, 4 , 201 , 285);
        $pdf->SetFont('Arial','B',16);
        $pdf->Image('img/logo1.png',10,10,-200);
        $pdf->Image('img/logo2.png',175,10,-200);
        $pdf->Cell(190,7,'Parvatibai Chowgule College of Arts and Science', 0, 1, 'C');
        $pdf->Cell(190,6,'Autonomous', 0, 1, 'C');
        $pdf->Ln(1);
        $pdf->SetFont('Arial','',16);
        $pdf->Cell(190,6,$name, 0, 1, 'C');
        $pdf->setFont("Arial", '', 14);
        $pdf->Cell(190,3,'', 0, 1, 'C');
        $pdf->Cell(190,8,'', 0, 1, 'C');
        $pdf->Cell(90,6,'Subject: '.$subject, 0, 0, 'L');
        $pdf->Cell(90,6,'Semester: '.$semester, 0, 1, 'R');
        $pdf->Cell(90,6,'Marks: '.$marks, 0, 0, 'L');
        $pdf->Cell(90,6,'Time: '.$time, 0, 1, 'R');
        $pdf->Cell(190,6,'____________________________________________________________', 0, 1, 'C');
        $pdf->Ln(6);
        $pdf->setFont("Arial", "", 12);
        $pdf->MultiCell(0,6,$this->getQuestions($randomSet));
        $pdf->Output("files/".$name.".pdf", "F");
    }


    public function getAnswers($randomSet)
    {
        $str="";
        $answer_labels = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
        $question_label = 1;
        foreach($randomSet as $question){
            //echo $question->question->name."<br>";
            $str .= $question_label.") ";
            $options = $question->option_array;
            $option_label = "A";
            $answers = $question->answer_array;

            if(sizeof($answers) > 0){
                foreach($answers as $answer){
                    $str .= $answer_labels[$answer]." ";
                    $option_label++;
                    //echo "Ans-". $answer->name. "<br>";
                }
            }else{
                $str .= "No Answer";
            }
            $question_label++;
            $str .= "\n";
        }
        return $str;
    }

    public function getQuestions($randomSet)
    {
        $str="";
        
        $question_label = 1;
        foreach($randomSet as $question){
            //echo $question->question->name."<br>";
            $str .= $question_label.") ".$question->question->name."\n";
            $options = $question->option_array;
            $option_label = "A";
            foreach($options as $option){
                //echo "->".$option->name. "<br>";
                $str .= "\t\t\t".$option_label. ". ".$option->name."\n";
                $option_label++;
            }
            $question_label++;
            $str .= "\n";
        }
        return stripslashes($str);
    }

    function createZip(){
        $filename="zip/QuestionBank.zip";
        header("Content-disposition: attachment;filename=$filename");
        $zip = new \ZipArchive();
        $filename = "zip/QuestionBank.zip";
        
        if ($zip->open($filename, \ZipArchive::CREATE)!==TRUE) {
            exit("cannot open <$filename>\n");
        }
        $dir = glob("files/*");
        foreach($dir as $file){
            if(!is_dir($file)){
                $zip->addFile($file);
            }
        }
        $zip->close();
        
        readfile($filename);
    }

    function cleanUp(){
        //delete all the files in the files folder
        $dir = glob("files/*");
        foreach($dir as $file){
            if(!is_dir($file)){
                unlink($file);
            }
        }
        $dir = glob("zip/*");
        foreach($dir as $file){
            if(!is_dir($file)){
                unlink($file);
            }
        }
        //clean the database
        $userAnswersOptions = new UsersOptionsAnswers();
        $userAnswersOptions::deleteAll();
        $questions = new Questions(); 
        $questions::deleteAll();
        $options = new Options();
        $options::deleteAll();
    }

    function SetCol($col)
    {
        // Set position at a given column
        $this->col = $col;
        $x = 10+$col*65;
        $pdf->SetLeftMargin($x);
        $pdf->SetX($x);
    }
    
    function AcceptPageBreak()
    {
        // Method accepting or not automatic page break
        if($this->col<2)
        {
            // Go to next column
            $this->SetCol($this->col+1);
            // Set ordinate to top
            $pdf->SetY($this->y0);
            // Keep on page
            return false;
        }
        else
        {
            // Go back to first column
            $this->SetCol(0);
            // Page break
            return true;
        }
    }

}
