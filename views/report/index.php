<?php

use app\models\Report;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
//use yii\helpers\BaseVarDumper;

/** @var yii\web\View $this */
/** @var app\models\ReportSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Reports';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="report-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php
            if(Yii::$app->user->identity->role_id == '2') {
                echo Html::a('Создать', ['create'], ['class' => 'btn btn-success']) ;
            }
        ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'number',
            'description:ntext',
            'user',
            'status_id',
            [
                'attribute'=> 'status',
                //смена статуса вмдна только админу
                'visible' => (Yii::$app->user->identity->role_id == '1')?true:false,
                'format'=> 'raw',
                'value'=> function ($data) { 
                    $html = html::beginForm(Url::to(['update', 'id' => $data->id]));
                    $html .= html::activeDropDownList($data, 'status_id', [
                        2 => 'Confirmed',
                        3=> 'Deslined',
                    ],
                    [
                        'prompt' => [
                            'text'=> 'new',
                            'options' => [
                                'value'=> '1',
                                'style'=> 'display: none',
                            ]
                        ]
                    ]);
                    $html .= html::endForm();
                    return $html;
                }
            ],
        ],
    ]); ?>


</div>
