<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Post */
/* @var $view_num common\models\View */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<?php $is_new_id=$model->is_new ?>
<div class="post-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>


        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('PDF version', ['report','id'=>$model->id], ['class' => 'btn btn-info']) ?>

    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'price',

            [
                'attribute'=>'make_id',
                'value'=>$model->make->name
            ],
            [
                'attribute'=>'model_id',
                'value'=>$model->model->name
            ],
            [
                'attribute'=>'city_id',
                'value'=>$model->city->name
            ],
            [
                'attribute'=>'is_new',
                'value'=>$model->getPostNewness($is_new_id)
            ],
            [                   // the owner name of the model
                'status',
                'label' => 'Status',
                'value' => function($model)
                {

                    return \common\Status::getPostStatus($model->status);
                },

            ],
            [
                    'views',
                    'label'=>'views',
                    //'value'=>$view_num ,
//                    'value'=>function($model){
//                    var_dump($model->view);
//                    die();
//                    },
                    'value'=>$model->view->view_num


            ],
            'created_at',
            'updated_at',
            'created_by',
            'updated_by',
        ],
    ]) ?>

</div>
