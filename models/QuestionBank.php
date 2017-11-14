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
    public $status = "true";

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['questions', 'options', 'optionCount', 'checkboxData'], 'required']
        ];
    }
}
