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
class RandomQuestion extends Model
{

     public $question;
     public $option_array;
     public $answer_array;   

}
