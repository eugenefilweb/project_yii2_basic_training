<?php

use app\models\Role;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\User $model */
/** @var yii\widgets\ActiveForm $form */


$list_role = Role::find()->all();
$list_role = ArrayHelper::map($list_role, 'id', 'role_name');
$role = Role::findOne(['id'=>2]);

echo $role->role_name;
// print_r($list_role);

?>

<div class="user-form">

    <?php
     
    $model->password = null;

    $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'user_email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nick_name')->textInput(['maxlength' => true]) ?>

    <?php // $form->field($model, 'authKey')->textInput(['maxlength' => true]) ?>

    <?php // $form->field($model, 'accessToken')->textInput(['maxlength' => true]) ?>

    <?php // $form->field($model, 'date_created')->textInput() 
    
    echo $form->field($model, 'role_id')->dropDownList(['' => 'Select Role'] + $list_role
        // ['a' => 'Item A', 'b' => 'Item B', 'c' => 'Item C']
    );

    ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
