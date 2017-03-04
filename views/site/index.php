<?php

/* @var $this yii\web\View */
$this->title = 'My Yii Application';

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$queuesData = $model->getQueuesData();
?>

<div class="site-index">

    <h1>Redis Queues</h1>
 
    <?php if (isset($msg) && $msg): ?>
    <div class="alert alert-info">
        <?php echo $msg; ?>
    </div>
    <?php endif; ?> 

    <?php if( $queuesData ): ?>
        <table class="table">
            <thead>
                <th>Queue Name</th>
                <th>Queue Size</th>
            </thead>
            <tbody>
                <?php foreach( $queuesData as $q_name => $q_size ): ?>
                    <tr>
                        <td><a href="<?php echo Yii::$app->homeUrl;?>/queue/info?q=<?php echo $q_name;?>"><?php echo $q_name?></a></td>
                        <td><?php echo $q_size ?></td>
                        <td><a href="<?php echo Yii::$app->homeUrl;?>/queue/delete?q=<?php echo $q_name;?>" class="btn btn-danger">Delete</a></td>
                    </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No Queues Available</p>
        <a class="btn btn-default" href="<?php echo Yii::$app->homeUrl;?>/queue/sample">Load Sample Data</a>
    <?php endif; ?>

    <hr/>

    <div>
        <h4>Add New Queue</h4>
        
        <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($add, 'queueName') ?>
        <?= Html::submitButton('Add', ['class' => 'btn btn-primary']) ?>
        <?php ActiveForm::end(); ?>
    </div>
</div>