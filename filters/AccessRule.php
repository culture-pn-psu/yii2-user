<?php
/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace anda\user\filters;
/**
 * Access rule class for simpler RBAC.
 * @see http://yii2-user.dmeroff.ru/docs/custom-access-control
 * @author Dmitry Erofeev <dmeroff@gmail.com>
 */
class AccessRule extends \yii\filters\AccessRule
{
    /**
     * @inheritdoc
     */
    protected function matchRole($user)
    {
        if (empty($this->roles)) {
            return true;
        }
        foreach ($this->roles as $role) {
            if ($role === '?') {
                if ($user->getIsGuest()) {
                    return true;
                }
            } elseif ($role === '@') {
                if (!$user->getIsGuest()) {
                    return true;
                }
            // Check if the user is logged in, and the roles match
            } elseif (!\Yii::$app->user->isGuest && in_array(\Yii::$app->user->identity->username, \Yii::$app->controller->module->admins)) {
                /*echo 'role: '.$role.'<br />';
                print_r(\Yii::$app->controller->module->admins); echo '<br />';
                echo 'username: '.\Yii::$app->user->identity->username.'<br />';*/
                return true;
            }
        }

        return false;
    }
}