<?php

use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\Status;
use common\models\Post;

/* @var $this yii\web\View */
/* @var $model common\models\PostSearch */
/* @var $form yii\widgets\ActiveForm */

$statuses = Status::getAllPostStatus();

?>

<div class="post-search">

    <?php $form = ActiveForm::begin([
        'action' => Url::to(['search']),
        'method' => 'GET',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'price') ?>

    <?= $form->field($model, 'make_id')->dropDownList(
        ArrayHelper::map(\common\models\Make::find()->all(),'id','name'),
        [ 'prompt'=>'Select']
    ) ?>

    <?= $form->field($model, 'model_id')->dropDownList(
        ArrayHelper::map(\common\models\Model::find()->all(),'id','name'),
        [ 'prompt'=>'Select']
    ) ?>

    <?= $form->field($model, 'city_id')->dropDownList(
        ArrayHelper::map(\common\models\City::find()->all(),'id','name'),
        [ 'prompt'=>'Select']
    ) ?>

        <?php echo '<label class="form-label">Valid Dates</label>';
        echo DatePicker::widget([
            'name' => 'PostSearch[from_date]',
            'value' => '2022-01-01',
            'type' => DatePicker::TYPE_RANGE,
            'name2' => 'PostSearch[to_date]',
            'value2' => '2023-01-01',
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'yyyy-mm-dd'
            ]
        ]);?>
    <!--    -->
        <!--Add Is New Here        -->
    <!--   -->
    <?= $form->field($model, 'status')->dropDownList(
        $statuses,
        [ 'prompt'=>'Select']
    ) ?>



    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
