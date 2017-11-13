<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class QuestionBank extends Model
{
    
    public $questions[];
    public $answers[];
    public $optionCount[];
    public $checkboxData[];

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [

        ];
    }
}
