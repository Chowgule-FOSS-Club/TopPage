<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
 <button type="button" class="btn btn-primary add-question-btn">Add Question</button>
    <button type="button" class="btn btn-danger remove-question-btn">Remove Question</button>
    <div class="question-bank container">
        <div class="question-card">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="question-number">Question - 1</h3>
                    <hr>
                    <div class="input-group">
                        <span class="input-group-addon" id="basic-addon1">Question 1</span>
                        <input type="text" class="form-control" placeholder="" aria-describedby="basic-addon1">
                    </div><br>
                    <div class="row">
                        <div class="count-div">
                            <input type="hidden" value="4" class="counter">
                        </div>
                        <div class="col-md-6 option-div">
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1"><input class="form-check-input" type="checkbox" value=""></span>
                                <input type="text" class="form-control" placeholder="" aria-describedby="basic-addon1">
                            </div>
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1"><input class="form-check-input" type="checkbox" value=""></span>
                                <input type="text" class="form-control" placeholder="" aria-describedby="basic-addon1">
                            </div>
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1"><input class="form-check-input" type="checkbox" value=""></span>
                                <input type="text" class="form-control" placeholder="" aria-describedby="basic-addon1">
                            </div>
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1"><input class="form-check-input" type="checkbox" value=""></span>
                                <input type="text" class="form-control" placeholder="" aria-describedby="basic-addon1">
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

    <?php 
    $script = <<< JS
        $(document).ready(function () {
            var question_number = 1;
            $('.add-option-btn').click(function () {
                console.log("adding new option");
                /*
                    option_div is the division that contains all the option values.
                */
                var option_div = $($(this).closest('div').parent()).children('.option-div');
                var new_option = "<div class=\"input-group\">"+
                               " <span class=\"input-group-addon\" id=\"basic-addon1\"><input class=\"form-check-input\" type=\"checkbox\" value=\"\"></span>"+
                                "<input type=\"text\" class=\"form-control\" placeholder=\"\" aria-describedby=\"basic-addon1\">"+
                            "</div>";
                
                option_div.append(new_option);
                /*
                    increasing the counter in the division =
                */
                var counter_input = $($(this).closest('div').parent()).children('.count-div').children('.counter');
                counter_input.val(Number(counter_input.val()) + 1);
                console.log($($(this).closest('div').parent()).children('.count-div').children('.counter').val());
            });
            $('.remove-option-btn').click(function () {
                console.log("remove option");
                if($($(this).closest('div').parent()).children('.option-div').children().length > 2){
                    $($(this).closest('div').parent()).children('.option-div').children().last().remove();
                /*
                    Descrease the counter in the division =
                */
                    var counter_input = $($(this).closest('div').parent()).children('.count-div').children('.counter');
                    if (Number(counter_input.val()) > 0)
                        counter_input.val(Number(counter_input.val()) - 1);
                }
            });

            $('.add-question-btn').click(function () {
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