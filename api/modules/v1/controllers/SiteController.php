<?php
/**
 * Created by PhpStorm.
 * User: lincoln
 * Date: 04/09/2017
 * Time: 21:26
 */

namespace api\modules\v1\controllers;


use yii\rest\Controller;

class SiteController extends Controller
{
    public function actionAutoPull()
    {
        $resultCD = shell_exec('cd /var/www/html/lince');
        $resultPull = shell_exec('git pull');
        return [
            'code' => 1,
            'msg' => 'Successful',
            'cd' => $resultCD,
            'pull' => $resultPull,
        ];
    }

    public function actionTest()
    {
        return [
            'code' => 1,
            'msg' => 'Test is successful now!'
        ];
    }

    public function actionError()
    {
        return [
            'code' => 0,
            'msg' => "error"
        ];
    }
}