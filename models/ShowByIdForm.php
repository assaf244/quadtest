<?php

namespace app\models;

use Yii;
use yii\base\Model;

class ShowByIdForm extends Model
{
    public $queueName;
    public $queueIndex;

    public function rules()
    {
        return [
            [['queueName', 'queueIndex'], 'required'],
            ['queueIndex', 'number'],
        ];
    }
}

?>