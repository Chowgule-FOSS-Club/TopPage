<?php

namespace app\controllers;

use Yii;
use app\models\fpdf;

//use app\models\fpdf;
//require('app\models\fpdf');

class TestController extends \yii\web\Controller
{
    public function actionIndex()
    {
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
        $str = "Q1: this is a a new question\n\t\t\tA. Hello World\n\t\t\tB. Bye wORLD\n\t\t\tC. Yo man \n\t\t\tD. Yeahhhhhh".
               "\n\nQ2: Which of the following states is the capital state of India? \n\t\t\tA. Goa\n\t\t\tB. Bye wORLD\n\t\t\tC. Yo man \n\t\t\tD. Yeahhhhhh";
        $pdf->MultiCell(0,6,$str);

        $pdf->Output("test.pdf", "D");
        //return $this->render('index');
    }

}
