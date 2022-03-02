<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use common\models\Post;


/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Posts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Post', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

<!--    --><?//= var_dump($dataProvider) ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            'price',
            [
                'attribute'=>'make_id',
                'value'=>'make.name'
            ],
            [
                'attribute'=>'model_id',
                'value'=>'model.name'
            ],
            [
                'attribute'=>'city_id',
                'value'=>'city.name'
            ],
            //            $is_new_id='is_new';
            [
            'attribute'=>'is_new',
            'value'=>function ($data) {
//                    var_dump($data->status);
//                    die();
                return  Post::getPostNewness($data->is_new);
            }
            ],


            [
                'label'=>'status',
                'attribute'=>'status_id',
                'value'=>function ($data) {
//                    var_dump($data->status);
//                    die();
                    return (new common\Status)->getPostStatus($data->status); // $data['name'] for array data, e.g. using SqlDataProvider.
                },
            ],
            //'created_at',
            //'updated_at',
            //'created_by',
            //'updated_by',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Post $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>





</div>



