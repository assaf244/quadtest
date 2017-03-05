<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\QueuesModel;
use app\models\PushForm;
use app\models\PopForm;
use app\models\ShowByIdForm;

class QueueController extends Controller
{
	public function actionIndex(){
    	return $this->redirect(Yii::$app->homeUrl);
    }

    public function actionInfo(){
    	$queue = preg_replace('/[^-a-zA-Z0-9_]/', '', Yii::$app->request->get('q'));
        $model = new QueuesModel();
        $pushForm = new PushForm();
        $popForm = new PopForm();
        $ShowByIdForm = new ShowByIdForm();
        $msg = false;

        $post = Yii::$app->request->post();

        if( !$model->isQueueExists($queue) ){
        	return $this->redirect(Yii::$app->homeUrl);
        }

        if( $post && isset($post['ShowByIdForm']) ){
        	$msg = $model->ShowContentByIndex($queue, $post['ShowByIdForm']['queueIndex']);
        }

        if( $post && isset($post['PushForm']) ){
        	$msg = $model->pushToQueue($queue, $post['PushForm']['pushValue']);
        }

        if($post && isset($post['PopForm']) ){
        	$msg = $model->popFromQueue($queue);
        }

        return $this->render('info', [
            'model' => $model,
            'push' => $pushForm,
            'pop' => $popForm,
            'ShowByIdForm' => $ShowByIdForm,
            'queue' => $queue,
            'msg' => $msg,
            'post' => $post
        ]);
    }

    public function actionDelete(){
    	$queue = preg_replace('/[^-a-zA-Z0-9_]/', '', Yii::$app->request->get('q'));
        $model = new QueuesModel();
        $model->deleteQueue($queue);
        return $this->redirect(Yii::$app->homeUrl);
    }

    public function actionSample(){
		$model = new QueuesModel();
		$model->loadSampleData();
		return $this->redirect(Yii::$app->homeUrl);
    }
}