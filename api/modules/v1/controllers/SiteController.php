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
        $signature = Yii::$app->request->headers->get('X-Hub-Signature');
        $payload = Yii::$app->request->post('payload');
        $mySignature = 'sha1=' . hash_hmac('sha1', $payload, 'qwertyuiop');

        $result = shell_exec('cd ../../ && git pull origin master 2>&1');
        return [
            'code' => 1,
            'msg' => 'Successful',
            'result' => $result,
//            'payload' => $payload,
            'signature' => $signature,
            'mySignature' => $mySignature,
        ];
    }

    public function actionTest()
    {
        return [
            'code' => 1,
            'msg' => 'Request is successful now.',
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