<?php

namespace app\models;

use Yii;
use yii\base\Model;
use Predis;


class QueuesModel extends Model {

	public $mainList = "queues";
	public $redis;

	public function __construct(){
		$this->redis = new Predis\Client();
	}

	public function getListContent($list){
		if ($this->redis->exists($list)) {
			return $this->redis->lrange($list, 0, -1);
		}
	}

	public function getQueueslist(){
		return $this->getListContent($this->mainList);
	}

	public function isQueueExists($queue){
		$allQueues = $this->getQueueslist();

		if( in_array($queue, $allQueues)){
			return true;
		}
	}

	public function createNewQueue($q_name){	
		$queuesList = $this->getQueueslist();
		
		if( !is_null($queuesList) ){
			if ( !in_array($q_name, $queuesList) ) {
				$this->redis->rpush($this->mainList, $q_name);
				return '"' . $q_name . '" queue has been created.';
			}else{
				return '"' . $q_name . '" already exists';
			}
		}else{
			$this->redis->rpush($this->mainList, $q_name);
			return '"' . $q_name . '" queue has been created.';
		}
	}

	public function deleteQueue($queue){
		$this->redis->del($queue);
		$this->redis->lrem($this->mainList, 0, $queue);
	}

	public function getFirstItem($queue){
		$first = $this->redis->lindex($queue, 0);
		return $first ? $first : $queue . ' queue is empty.';
	}

	public function getQueuesData(){
		$queuesList = $this->getQueueslist();

		if( !is_null($queuesList) ){
			$results;

			foreach ($queuesList as $queue) {
				$results[$queue] = $this->redis->llen($queue);
			}

			return $results;
		}
		return false;
	}

	public function getQueueContent($queue){
		
		return $this->redis->lrange($queue, 0, -1);
	}

	public function ShowContentByIndex($queue, $index){
		$info = $this->redis->lindex($queue, $index);
		
		if($info){
			return 'item with id #' . $index . ' is: "' . $info . '".';
		}else{
			return 'id #' . $index . ' not exist';
		}
	}

	public function pushToQueue($queue, $pushValue){
		
		$queueContent = $this->getQueueContent($queue);

		if( in_array($pushValue, $queueContent) ){
			return $pushValue . ' already exist in "' . $queue . '" queue'; 
		}else{
			$this->redis->rpush($queue, $pushValue);
			$this->createNewQueue($queue);
			return $pushValue . ' has been added to "' . $queue . '" queue';
		}
	}

	public function popFromQueue($queue){
		
		$pop = $this->redis->lpop($queue);
		return $pop . ' popped from ' . $queue;
	}

	public function loadSampleData(){
        $sampleData = array(
            'Games'     => array('Injustice 2','Mortal Kombat XL','Uncharted 4','Batman: Arkham Knight','Crash Bandicoot'),
            'Consoles'  => array('Playstation 4','Xbox 360','Playstation 3','Sega Genesis','Nintendo Wii'),
            'Genres'    => array('Action','Platform','Shooter','Action-Advanture','Strategy')
        );

        foreach ($sampleData as $queue => $content) {
            $this->createNewQueue($queue);

            foreach ($content as $title) {
                $this->pushToQueue($queue,$title);
            }
        }
    }
}