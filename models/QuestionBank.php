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

    public $questions;
    public $options;
    public $optionCount;
    public $checkboxData;
    public $semester;
    public $subject;
    public $marks;
    public $time;
    public $setCount;
    public $status = "true";

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['questions', 'options', 'optionCount', 'checkboxData', 'semester', 'subject', 'marks', 'time', 'setCount'], 'required']
        ];
    }
}
