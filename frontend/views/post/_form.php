<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\Status;
use common\models\Post;


/* @var $this yii\web\View */
/* @var $model common\models\Post */
/* @var $form yii\widgets\ActiveForm */

$statuses = Status::getAllPostStatus();
$newness=Post::getAllPostNewness();

?>

<div class="post-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'price') ?>

    <?= $form->field($model, 'make_id')->dropDownList(
        ArrayHelper::map(\common\models\Make::find()->all(),'id','name'),
        [ 'prompt'=>'Select']
    ) ?>

    <?= $form->field($model, 'model_id')->dropDownList(

        [ 'prompt'=>'Select']
    ) ?>

    <?= $form->field($model, 'city_id')->dropDownList(
        ArrayHelper::map(\common\models\City::find()->all(),'id','name'),
        [ 'prompt'=>'Select']
    ) ?>

    <?= $form->field($model, 'is_new')->dropDownList(
        $newness,
        [ 'prompt'=>'Select']
    ) ?>

    <?= $form->field($model, 'status')->dropDownList(
        $statuses,
        [ 'prompt'=>'Select']
    ) ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script>

    $('#post-make_id').on('change',function(){



        let makeId=$('#post-make_id').val();
        console.log(makeId);

        $.ajax({
            'type':'GET',

            'url':'?r=post%2Fmodels&makeId='+makeId,


            // 'data':make_id,
            // inside func $('#otherdropdownlist').html(html);
            'success':function(messages){

                console.log(messages);
                // console.log(typeof(messages));
                // Array.prototype.forEach.call(messages,function(message){
                console.log('----');
                console.log(JSON.parse(messages))
                let arr=JSON.parse(messages)
                arr.forEach(function(message){
                    console.log(message);

                    let id=message['id'];
                    let value=message['name'];
                    $('#post-model_id').append('<option value='+ id+'>'+value +'</option>'  );
                })





            }

            //\yii\helpers\JSON::encode(\yii\helpers\ArrayHelper::map(Doctype::find()->All(), 'id', 'name'));
            //    could help us in the success
        });

        return false;

    });

</script>


