<?php

use common\models\User;
use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel common\models\OrdersControl */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Orders';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="orders-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'sum',
            [
                'attribute' => 'user_id',
                'value' => function ($model) {
                    return User::find($model->user_id)->one()->username;
                },
            ],
            [
                'label' => 'Books',
                'value' => function ($model) {
                    $books = '';
                    foreach ($model->orderItems as $item) {
                        $books .= $item->book->title . ', ';
                    }
                    return rtrim($books, ', ');
                },
            ],
            'created_at',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {delete}',
            ],
        ],
    ]);
    ?>
</div>
