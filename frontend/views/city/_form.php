<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\Status;

/* @var $this yii\web\View */
/* @var $model common\models\City */
/* @var $form yii\widgets\ActiveForm */

$statuses = Status::getAllCityStatus();

?>

<div class="city-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <!--   -->
    <?= $form->field($model, 'status')->dropDownList(
        $statuses,
        [ 'prompt'=>'Select']
    ) ?>

    <!--    -->

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
