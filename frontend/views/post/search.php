
<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
//use yii\grid\GridView;
use kartik\grid\GridView;
use yii\widgets\ActiveForm;
use common\models\Post;
use common\models\PostSearch;
use common\Status;
use kartik\export\ExportMenu;


/* @var $this yii\web\View */
/* @var $searchModel common\models\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Posts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-search">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Post', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php
//$columns=[
//
//    //            ['class'=>'kartik\grid\SerialColumn'],
//            'title',
//            'make_id',
//            'model_id',
//            'city',
//            'status'
//
//    ];
//    $export= ExportMenu::widget([
//            'dataProvider'=>$dataProvider,
//            'showConfirmAlert'=>true,
//            'columns'=>$columns,
//            'target'=>ExportMenu::TARGET_BLANK
//
//    ]);
//    echo $export;
//    ?>
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
//        'toolbar'=>[$export],
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],

            'id',

            'title',
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

            [
                'label'=>'status',
                'attribute'=>'status_id',
                'value'=>function ($data) {
//                    var_dump($data->status);
//                    die();
                    return (new common\Status)->getPostStatus($data->status); // $data['name'] for array data, e.g. using SqlDataProvider.
                },
            ],
            'created_at',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Post $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>


</div>
