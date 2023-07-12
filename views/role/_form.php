<?php

use yii\helpers\Html;
// use yii\web\View;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Role $model */
/** @var yii\widgets\ActiveForm $form */




function controller_actions($controller_name=null)
{

$controllers = \yii\helpers\FileHelper::findFiles(Yii::getAlias('@app/controllers'), ['recursive' => true]);

    foreach ($controllers as $controller) {
        $contents = file_get_contents($controller);
        $controller_name = \yii\helpers\Inflector::camel2id(substr(basename($controller), 0, -14));
        preg_match_all('/public function action(\w+?)\(/', $contents, $result);
        $actions=null;
    foreach ($result[1] as $action) {
        $action_name = \yii\helpers\Inflector::camel2id($action);

        if ($action_name !== "s") {
            $actions[] = $action_name;
        }
    }
        if ($actions){
            $controllers_action[$controller_name]=['title'=>ucwords($controller_name),'actions'=>$actions, 'other_settings'=>null];
        }
    }

//  ksort($controller_actions);


return $controllers_action;
}


$test = controller_actions($controller_name=null);
// foreach($test as $key => $action){
    
    
//     print_r($action['title']);
//     print_r($action['title']);
//     print_r($action['title']);
//     echo "<br>";
// }
// print_r($test);

print_r($model->access_role);

$model->role_list['access_role']=$model->access_role;

?>






<div class="role-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'role_name')->textInput(['maxlength' => true]) ?>

    <?php // $form->field($model, 'access_role')->textarea(['rows' => 6]) ?>


    <?php /*
    <table class="table">
    <tr>
        <th>Role</th>
        <!-- <th style="text-align: center;">Actions</th> -->
        <th>Actions</th>
    </tr>
    <?php foreach($test as $key => $role) : ?>
    <tr>
        <td>
            <?= $role['title']  ?>
            <?= $form->field($model, 'role_list[][title]')->textInput(['value'=>$key]) ?>
            <?= $form->field($model, 'role_list[][action]')->checkboxList($role['actions'],['itemOptions'=>['labelOptions'=>['labelOptions'=>['class'=>'col-md-1']]]]) 
            ?>
        </td>
        <td>
                <?php foreach($role['actions'] as $k => $action) : ?>    
                    <?php echo $action. " |" ?>
                <?php endforeach; ?>
        </td>
    </tr>
    <?php endforeach; ?>
    </table>
                    */
    ?>

    <?php if($test)?>
    <table class='table'>
        <tr>
            <td>Role</td>
            <td>Action</td>

            <?php
                foreach($test as $key=>$row) {

                    if($row['actions'] && is_array($row['actions'])){
                        $actions = null;
                        $actions2 = null;
                        foreach($row['actions'] as $k=>$d){
                            $actions .= $d. ' | ';

                            $actions2[$d]=$d;
                        }
                    }

                    echo '
                    <tr>
                        <td>'
                            .$row['title']
                            .$form->field($model,'role_list[title][]')->textInput(['value'=>$key])
                            // .$form->field($model,'role_list[][action]')->checkboxList($row['actions'],['itemOptions'=>['labelOptions'=>['class'=>'checkbox-label']]])
                            // .$form->field($model,'role_list[action]['.$key.'][]')->checkboxList($actions2,['itemOptions'=>['labelOptions'=>['class'=>'checkbox-label']]])
                            .$form->field($model,'role_list[access_role]['.$key.'][]')->checkboxList($actions2,['itemOptions'=>['labelOptions'=>['class'=>'checkbox-label']]])
                            .
                        '</td>
                        <td>'.$actions.'</td>
                    </tr>';            
                }
            ?>
    </table>
    <?php "}" ?>



    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
