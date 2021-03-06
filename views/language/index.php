<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\base\Widget;
use app\models\Timezone;
$this->title = 'Language List';
$this->params['breadcrumbs'][] = $this->title;
?>
<p>
	<div class="btn-group">
    	<?= Html::a('Delete Selected', [''], ['class' => 'btn btn-danger delete-all', 'disabled' => 'disabled']) ?>
    	<span class="btn btn-default delete-num">0</span>
    </div>
    <?= Html::a('New Language', ['create'], ['class' => 'btn btn-success']) ?>
    <?= Html::a('Import Languages', ['import'], ['class' => 'btn btn-warning']) ?>
    <?= Html::a('Export Languages', ['export'], ['class' => 'btn btn-info']) ?>
</p>
<?= GridView::widget([
    'options' => ['class' => 'gridview', 'style' => 'overflow:auto', 'id' => 'grid'],
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'pager' => [
        'firstPageLabel' => 'First Page',
        'lastPageLabel' => 'Last Page',
    ],
    'rowOptions' => function($model, $key, $index, $grid){
        return ['class' => $index % 2 == 0 ? 'label-white' : 'label-grey' ];
    },
    'columns' => [
        [
            'class' => 'yii\grid\CheckboxColumn',
            'name' => 'id',
            'checkboxOptions' => function ($model, $key, $index, $column){
                if(!empty($model->channels)){
                    return ['disabled' => 'disabled'];
                }
                return [];
            },
            'headerOptions' => ['width' => '10'],
        ],
        [
            'class' => 'yii\grid\SerialColumn',
            'headerOptions' => ['width' => '10'],
        ],
        'languageName',
        [
            'attribute' => 'createTime',
            'value' => function($model){
                return Timezone::date($model->createTime);
            }
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'header' => 'Operations',
            'headerOptions' => ['width' => '90'],
            'template' => '{view}&nbsp;&nbsp;&nbsp;{update}&nbsp;&nbsp;&nbsp;{delete}',
            'buttons' => [
                'view' => function($url, $model, $key){
                return Html::a('<i class="glyphicon glyphicon-eye-open"></i>',
                    ['view', 'languageId' => $key],
                    ['title' => 'View']);
                },
                'update' => function($url, $model, $key){
                return Html::a('<i class="glyphicon glyphicon-pencil"></i>',
                    ['update', 'languageId' => $key],
                    ['title' => 'Update']);
                },
                'delete' => function($url, $model, $key){
                    if(!empty($model->channels)) return '<i class="glyphicon glyphicon-trash" style="color:gray;"></i>';
                    return Html::a('<span class="glyphicon glyphicon-trash"></span>',
                    ['delete', 'languageId' => $key],
                    ['title' => 'Delete',
                     'data' => ['confirm' => "Are you sure to delete language $model->languageName?"],
                    ]);
                },
            ],
        ],
    ],
]); 
$this->registerJs("
$(document).on('click', '.gridview', function () {
    var keys = $('#grid').yiiGridView('getSelectedRows');
    if(keys.length>0){
        $('.delete-all').attr('disabled', false);
        $('.delete-num').html(keys.length);
        $('.delete-all').attr('href', 'index.php?r=language/delete-all&keys='+keys);
    }else{
        $('.delete-all').attr('disabled', 'disabled');
        $('.delete-num').html(0);
        $('.delete-all').attr('href', '');
    }
});
$(document).on('click', '.delete-all', function(){
    if($(this).attr('disabled')){
        return false;
    }else{
        var num = $('.delete-num').html();
        if(!confirm('are you sure to delete these '+num+' languages?')){
            return false;
        }
    }
});
");
?>
<p>
	<div class="btn-group">
    	<?= Html::a('Delete Selected', [''], ['class' => 'btn btn-danger delete-all', 'disabled' => 'disabled']) ?>
    	<span class="btn btn-default delete-num">0</span>
    </div>
    <?= Html::a('New Language', ['create'], ['class' => 'btn btn-success']) ?>
    <?= Html::a('Import Languages', ['import'], ['class' => 'btn btn-warning']) ?>
    <?= Html::a('Export Languages', ['export'], ['class' => 'btn btn-info']) ?>
</p>
