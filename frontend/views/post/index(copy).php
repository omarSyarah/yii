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


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            'make_id',
            'model_id',
            'city_id',
            'status',
            //'created_at',
            //'updated_at',
            //'created_by',
            //'updated_by',
//            no clue as what the above is commented for
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Post $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
