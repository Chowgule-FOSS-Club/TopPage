<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
/* @var $this yii\web\View */

$this->title = 'Top Paper';
?>
 <button type="button" class="btn btn-primary add-question-btn">Add Question</button>
 <button type="button" class="btn btn-danger remove-question-btn">Remove Question</button>

    <?php $form = ActiveForm::begin([
        'id' => 'bank-form',
        'fieldConfig' => [
            'template' => "{input}",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); 
    ?>
    <div class="row">
        <div class="col-md-6">
            <br>
            <?= $form->field($model, 'semester')->textInput(['autofocus' => true, 'placeholder'=>'Semester']) ?>
            <?= $form->field($model, 'subject')->textInput(['autofocus' => true, 'placeholder'=>'Subject']) ?>
            <?= $form->field($model, 'time')->textInput(['autofocus' => true, 'placeholder'=>'Time']) ?>
            <?= $form->field($model, 'marks')->textInput(['autofocus' => true, 'placeholder'=>'Marks']) ?>
            <?= $form->field($model, 'setCount')->textInput(['autofocus' => true, 'placeholder'=>'Set Number', 'type'=>'number']) ?>
        </div>
        <div class="col-md-6">
            
        </div>
    </div>
<div class="question-bank container">
<?php $checkboxTemplate = '{input}'; ?>
        <div class="question-card">
            <div class="row">
                <div class="col-md-12">
                    <!-- <h3 class="question-number">Question - 1</h3> -->
                    <hr>
                    <div class="input-group">
                        <span class="input-group-addon question-number" id="basic-addon1">Question 1</span>
                        <?= $form->field($model, 'questions[]')->textInput(['autofocus' => true]) ?>
                    </div><br>
                    <div class="row">
                        <div class="count-div">
                        <?= $form->field($model, 'optionCount[]')->hiddenInput(['value'=> '4', 'class' =>'counter']) ?>
                           <!-- <input type="hidden" value="4" class="counter"> -->
                        </div>
                        <div class="col-md-6 option-div">
                            <div class="input-group checkbox-div">
                                <span class="input-group-addon" id="basic-addon1"><?= $form->field($model, 'checkboxData[]')->checkbox(['template' => $checkboxTemplate, 'class' => 'checkbox']); ?></span>
                                <?= $form->field($model, 'options[]')->textInput(['autofocus' => true]) ?>
                            </div>
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1"><?= $form->field($model, 'checkboxData[]')->checkbox(['template' => $checkboxTemplate]); ?></span>
                                <?= $form->field($model, 'options[]')->textInput(['autofocus' => true]) ?>    
                            </div>
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1"><?= $form->field($model, 'checkboxData[]')->checkbox(['template' => $checkboxTemplate]); ?></span>
                                <?= $form->field($model, 'options[]')->textInput(['autofocus' => true]) ?>    
                            </div>
                            <div class="input-group">
                            
                                <span class="input-group-addon" id="basic-addon1"><?= $form->field($model, 'checkboxData[]')->checkbox(['template' => $checkboxTemplate]); ?></span>
                                <?= $form->field($model, 'options[]')->textInput(['autofocus' => true]) ?>    
                            </div>
                        </div>
                        <div class="col-md-6">
                            <button type="button" class="btn btn-success add-option-btn">Add New Option</button>
                            <button type="button" class="btn btn-danger remove-option-btn">Remove Option</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-lg-offset-1 col-lg-11">
            <?= Html::submitButton('Generate Papers', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
    <?php 
    $script = <<< JS
        $(document).ready(function () {
            var checkbox = $('.option-div').find(".checkbox").last();
            checkbox.prop("checked", 'checked');
            var question_number = 1;
            $('body').on('click', '.add-option-btn', function (){
                console.log("adding new option");
                /*
                    option_div is the division that contains all the option values.
                */
                var option_div = $($(this).closest('div').parent()).children('.option-div');

                var new_option = "<div class=\"input-group\">"+
                                "<span class=\"input-group-addon\" id=\"basic-addon1\"><div class=\"form-group field-questionbank-checkboxdata\">"+
"<input type=\"hidden\" name=\"QuestionBank[checkboxData]\" value=\"0\"><input type=\"checkbox\" id=\"questionbank-checkboxdata\" name=\"QuestionBank[checkboxData]\" value=\"1\">"+
"</div></span>"+
                                "<div class=\"form-group field-questionbank-options\">"+
"<input type=\"text\" id=\"questionbank-options\" class=\"form-control\" name=\"QuestionBank[options]\" autofocus=\"\">"+
"</div>                            </div>";
                
                
                option_div.append($('.option-div').children().last().clone());
                /*
                    increasing the counter in the division =
                */
                var counter_input = $($(this).closest('div').parent()).children('.count-div').find('.counter');
                counter_input.val(Number(counter_input.val()) + 1);
            });

            $('body').on('click', '.remove-option-btn', function (){
                console.log("remove option");
                if($($(this).closest('div').parent()).children('.option-div').children().length > 2){
                    $($(this).closest('div').parent()).children('.option-div').children().last().remove();
                /*
                    Descrease the counter in the division =
                */
                    var counter_input = $($(this).closest('div').parent()).children('.count-div').find('.counter');
                    if (Number(counter_input.val()) > 0)
                        counter_input.val(Number(counter_input.val()) - 1);
                }
            });

            $('.add-question-btn').click(function () {
                
                /* var checkbox1 = $('.question-bank').children().last().find('.checkbox');
                alert(checkbox1.type);
                checkbox1.prop("checked", 'checked'); */
                question_number++;
                $('.question-bank').append($('.question-card').html());
                $('.question-bank').children().last().find('.question-number').html("Question - "+question_number);
            });
            $('.remove-question-btn').click(function () {
                /*
                    if loop to make sure you cannot remove all the elements. Keep some elements
                */
                if($('.question-bank').children().length > 1){
                    $('.question-bank').children().last().remove();
                    question_number--;
                }
            });
        });
JS;
        $this->registerJs($script);

    ?>