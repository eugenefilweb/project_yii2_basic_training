<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Role;
use yii\web\ForbiddenHttpException;

class BaseController extends Controller
{
    public function beforeAction($action)
    {
        if (Yii::$app->user->isGuest) {
            return parent::beforeAction($action);
        }

        $id = Yii::$app->user->identity['role_id'] ?? null;
        $role = Role::findOne(['id' => $id]);

        if (!$role || empty($role->access_role)) {
            throw new ForbiddenHttpException('You are not authorized to perform this action.');
            // echo 'You are not authorized to perform this action.';
        }

        $accessRole = json_decode($role->access_role, true);
        $controllerId = $this->id;
        $actionId = $action->id;

        if (!$this->isAuthorized($accessRole, $controllerId, $actionId)) {
          // Yii::$app->session->setFlash('error', 'You are not authorized to perform this action.');
            throw new ForbiddenHttpException('You are not authorized to perform this action.');
          }

        return parent::beforeAction($action);
    }

    protected function isAuthorized($accessRole, $controllerId, $actionId)
    {
        return isset($accessRole[$controllerId]) && is_array($accessRole[$controllerId]) && in_array($actionId, $accessRole[$controllerId]);
        // return isset($accessRole[$controllerId]) && in_array($actionId, $accessRole[$controllerId]);
    }
}
