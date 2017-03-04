<?php

namespace app\models;

use Yii;
use yii\base\Model;

class PopForm extends Model
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