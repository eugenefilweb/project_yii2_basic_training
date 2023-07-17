<?php

use app\models\User;
use app\models\Role;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\UserSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'id',
        'user_name',
        [
            'attribute' => 'role_name',
            'value' => function ($model) {

                return Role::findOne($model->role_id)->role_name ?? null;
                // return isset($model->role_id) ? Role::findOne($model->role_id)->role_name : null;
            },
            // 'contentOptions' => ['style' => 'color: rgba(var(--bs-link-color-rgb), var(--bs-link-opacity, 1)); text-decoration: none;'],
            'headerOptions' => ['style' => 'color: rgba(var(--bs-link-color-rgb), var(--bs-link-opacity, 1)); text-decoration: underline;'],
            'filter' => Html::activeTextInput($searchModel, 'role_name', ['class' => 'form-control']),
        ],
        'user_email:email',
        'password',
        'nick_name',
        [
            'class' => ActionColumn::className(),
            // 'template' => '{view} {update} {delete}', // Specify the buttons to include
            'template' => $role->id === 1 ? '{view} {update} {delete}' : ($role->id === 2 ? '{view} {update}' : ($role->id === 5 ? '{view}' : null)),
            'urlCreator' => function ($action, $model, $key, $index) {
                return Url::toRoute([$action, 'id' => $model->id]);
            },
        ],
    ],
]); ?>



</div>
