<?php

namespace app\models;

use Yii;
use yii\base\Model;

class AddQueueForm extends Model
{
    public $queueName;

    public function rules()
    {
        return [
            [['queueName'], 'required'],
        ];
    }
}

?>