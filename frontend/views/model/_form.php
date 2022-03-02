<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\Status;

$statuses = Status::getAllMakeStatus();
?>

<div class="model-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'make_id')->dropDownList(
        ArrayHelper::map(\common\models\Make::find()->all(),'id','name'),
        [ 'prompt'=>'Select']
    ) ?>

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
