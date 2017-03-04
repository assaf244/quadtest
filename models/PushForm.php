<?php

namespace app\models;

use Yii;
use yii\base\Model;

class PushForm extends Model
{
    public $queueName;
    public $pushValue;

    public function rules()
    {
        return [
            [['queueName', 'pushValue'], 'required'],
        ];
    }
}

?>