<?php

namespace app\controllers;

use Yii;
use app\models\fpdf;
use app\models\SetGenerator;

//use app\models\fpdf;
//require('app\models\fpdf');

class TestController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $set = new SetGenerator();
        $randomSet = $set->getSet(Yii::$app->user->identity->uid);
        $this->generateQuestionPaper($randomSet);
        //return $this->render('index');
    }

    public function generateQuestionPaper($randomSet){
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
        $pdf->Cell(190,6,'SET - A', 0, 1, 'C');
        $pdf->setFont("Arial", '', 14);
        $pdf->Cell(190,3,'', 0, 1, 'C');
        $pdf->Cell(190,8,'', 0, 1, 'C');
        $pdf->Cell(90,6,'Subject: Web Designing', 0, 0, 'L');
        $pdf->Cell(90,6,'Semester: III', 0, 1, 'R');
        $pdf->Cell(90,6,'Marks: 20', 0, 0, 'L');
        $pdf->Cell(90,6,'Time: 30min', 0, 1, 'R');
        $pdf->Cell(190,6,'____________________________________________________________', 0, 1, 'C');
        $pdf->Ln(6);
        $pdf->setFont("Arial", "", 12);
        $pdf->MultiCell(0,6,$this->getQuestions($randomSet));

        $pdf->Output("test.pdf", "D");
    }


    public function getAnswers($randomSet)
    {
        $str="";
        
        $question_label = 1;
        foreach($randomSet as $question){
            //echo $question->question->name."<br>";
            $str .= $question_label.") ".$question->question->name."\n";
            $options = $question->option_array;
            $option_label = "A";
            /*foreach($options as $option){
                //echo "->".$option->name. "<br>";
                $str .= "\t\t\t".$option_label. ". ".$option->name."\n";
                $option_label++;
            }*/
            $option_label = "A";
            $answers = $question->answer_array;
            foreach($answers as $answer){
                $str .= "\t\t\t".$option_label. ". ".$answer->name."\n";
                $option_label++;
                //echo "Ans-". $answer->name. "<br>";
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
            $answers = $question->answer_array;
            foreach($answers as $answer){
                //echo "Ans-". $answer->name. "<br>";
            }
            $question_label++;
            $str .= "\n";
        }
        return $str;
    }


}
