<?php

use common\models\Make;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Makes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="make-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Make', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],


            'name',
            [
                'label'=>'status',
                'attribute'=>'status_id',
                'value'=>function ($data) {
//                    var_dump($data->status);
//                    die();
                    return (new common\Status)->getMakeStatus($data->status); // $data['name'] for array data, e.g. using SqlDataProvider.
                },
            ],

            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Make $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
