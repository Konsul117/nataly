<h1>Книги</h1>

<?php

use common\components\Formatter;
use common\modules\book\models\Book;
use yii\data\ActiveDataProvider;
use yii\grid\ActionColumn;
use yii\grid\DataColumn;
use yii\grid\GridView;
use yii\helpers\Html;

/** @var ActiveDataProvider $dataProvider */
/** @var \common\modules\book\models\Book $searchModel */
?>

<p>
    <?= Html::a('Добавить', ['create'], ['class' => 'btn btn-success']) ?>
</p>

<?=
GridView::widget([
    'dataProvider'   => $dataProvider,
    'filterModel'    => $searchModel,
    'columns'        => [
        Book::ATTR_ID,
        Book::ATTR_TITLE,
        Book::ATTR_URL,
        [
            'class'     => DataColumn::class,
            'attribute' => Book::ATTR_INSERT_STAMP,
            'format'    => 'localDateTime',
        ],
        [
            'class'     => DataColumn::class,
            'attribute' => Book::ATTR_UPDATE_STAMP,
            'format'    => 'localDateTime',
        ],
        [
            'class'    => ActionColumn::class,
            'template' => '{update} {delete}',
        ],
    ],
    'layout'         => "{pager}\n{summary}\n{items}\n{pager}",
    'formatter'      => [
        'class'      => Formatter::class,
        'dateFormat' => 'd.m.Y H:i',
    ],
    'filterSelector' => 'select[name="per-page"]',
])
?>
