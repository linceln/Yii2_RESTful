<?php
/**
 * Created by PhpStorm.
 * User: lincoln
 * Date: 04/09/2017
 * Time: 21:26
 */

namespace api\modules\v1\controllers;

use Yii;
use yii\rest\Controller;

class SiteController extends Controller
{
    public function actionAutoPull()
    {
        $headers = Yii::$app->request->headers;
        $signature = $headers->get('X-Hub-Signature');
        $payload = Yii::$app->request->post('Payload');
        $result = shell_exec('cd ../../ && git pull origin master 2>&1');
        return [
            'code' => 1,
            'msg' => 'Successful',
            'result' => $result,
            'payload' => $payload,
            'signature' => $signature,
        ];
    }

    public function actionTest()
    {
        return [
            'code' => 1,
            'msg' => 'Request is successful.',
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