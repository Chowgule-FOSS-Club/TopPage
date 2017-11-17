<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\Questions;
use app\models\Options;
use app\models\UsersOptionsAnswers;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class SetGenerator extends Model
{

     function getRandomArray($size){
        $randomIndexArray[] = -1;
        $count = 0;

        while ( $count < $size ) {
            $flag = true;
            $num=rand(0, $size-1);
            foreach ($randomIndexArray as $p) {
                if ($num == $p) {
                    $flag= false;
                }
            }
            if ($flag == true) {
                $randomIndexArray[$count] = $num;
                $count++;
            }
        }   

        return $randomIndexArray;
    }

    public function getSet($uid=1)
    {

        $user1 = Users::find();
        $user1->joinWith('questions');
        $users1=$user1->where(['users.uid' => $uid])
        ->one();

        $usersOptionsAnswers = UsersOptionsAnswers::find();
        $usersOptionsAnswer=$usersOptionsAnswers->where(['uid' => 1,'flag' => true])
        ->all();

        $question_array = $users1->questions;
        $size = sizeof($question_array);
        $randomIndexArray = $this->getRandomArray($size);        


        $randomQuestionArray = [];

        for ($i=0; $i<sizeof($randomIndexArray); $i++) {
            $randomQuestionArray[$i] = $question_array[$randomIndexArray[$i]];
        }    

        $randomRandomQuestionArray = [];  
        $count = 0;

               
       
        foreach($randomQuestionArray as $question){
            $answerArray = [];
            $randomQuestion = new RandomQuestion();
            $randomRandomQuestionArray[$count]= $randomQuestion;
            $randomQuestion->question = $question;

            $options_array=$question->options;
            $size = sizeof($options_array);
            $randomIndexArray = $this->getRandomArray($size);        
    
            $randomOptionArray = [];
    
            for ($i=0; $i<sizeof($randomIndexArray); $i++) {
                $randomOptionArray[$i] = $options_array[$randomIndexArray[$i]];
            }           

            $randomQuestion->option_array = $randomOptionArray;            

            for($i=0; $i < sizeof($usersOptionsAnswer); $i++){
                if($question->qid == $usersOptionsAnswer[$i]->qid){                     
                    for($j=0; $j < sizeof($options_array); $j++){
                        if($usersOptionsAnswer[$i]->oid == $options_array[$j]->oid){
                           array_push($answerArray,$j);     
                    }
                }
            }
            $randomQuestion->answer_array = $answerArray;
            $count++;
        }
    }


        return $randomRandomQuestionArray;
       
   

    }


}


