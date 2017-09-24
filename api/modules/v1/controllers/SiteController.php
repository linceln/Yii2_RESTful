<?php
/**
 * Created by PhpStorm.
 * User: lincoln
 * Date: 04/09/2017
 * Time: 21:26
 */

namespace api\modules\v1\controllers;

use common\models\Bmi;
use Yii;
use yii\rest\Controller;

class SiteController extends Controller
{
    public function actionAutoPull()
    {
        $signature = Yii::$app->request->headers->get('X-Hub-Signature');
        list($algo, $hash) = explode('=', $signature, 2);
        $payload = file_get_contents('php://input');

        $myHash = hash_hmac($algo, $payload, Yii::$app->params['githubWebhookSecret']);
        if (hash_equals($myHash, $hash)) {
            $result = shell_exec('cd ../../ && git pull origin master 2>&1');
            return [
                'code' => 1,
                'msg' => 'Successful',
                'result' => $result,
            ];
        } else {
            return [
                'code' => 0,
                'msg' => 'Bad signature.',
            ];
        }
    }

    public function actionTest()
    {
        $bmis = Bmi::a();
        return [
            'code' => 1,
            'msg' => 'Request is OK.',
            'count' => count($bmis),
            'data' => $bmis,
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