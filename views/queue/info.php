<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$queueContent = $model->getQueueContent($queue)
?>

<div class="site-index">

    <h1><?php echo $queue; ?></h1>

    <?php if (isset($msg) && $msg): ?>
    <div class="alert alert-info">
        <?php echo $msg; ?>
    </div>
    <?php endif; ?> 

    <?php if($queueContent): ?>
	    <table class="table">
	        <thead>
	            <th>ID</th>
	            <th>Content</th>
	        </thead>
	        <tbody>
	            <?php foreach( $queueContent as $position => $content ): ?>
	                <tr>
	                    <td><?php echo $position; ?></td>
	                    <td><?php echo $content ?></td>
	                </tr>
	        <?php endforeach; ?>
	        </tbody>
	    </table
	<?php else: ?>
        <p>Queue is empty</p>
    <?php endif; ?>    

    <hr />

    <div class="row">
        <div class="col-md-4">
        	<h4>Show Queue Value by ID</h4>
		    <?php $form = ActiveForm::begin(); ?>
		    <?= $form->field($ShowByIdForm, 'queueName')->textInput(['readonly' => true, 'value' => $queue]); ?>
		    <?= $form->field($ShowByIdForm, 'queueIndex') ?>
			<?= Html::submitButton('Get Value', ['class' => 'btn btn-primary']) ?>
			<?php ActiveForm::end(); ?>
        </div>
        <div class="col-md-4">
        	<h4>Push To This Queue</h4>
    		<?php $form = ActiveForm::begin(); ?>
    		<?= $form->field($push, 'queueName')->textInput(['readonly' => true, 'value' => $queue]); ?>
    		<?= $form->field($push, 'pushValue') ?>
			<?= Html::submitButton('Push', ['class' => 'btn btn-primary']) ?>
			<?php ActiveForm::end(); ?>
        </div>
        <div class="col-md-4">
        	<h4>Pop From This Queue</h4>
    		<?php $form = ActiveForm::begin(); ?>
    		<?= $form->field($pop, 'queueName')->textInput(['readonly' => true, 'value' => $queue]); ?>
			<?= Html::submitButton('Pop', ['class' => 'btn btn-primary']) ?>
			<?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
