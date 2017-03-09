<?php
class Routing{
    public $url;

    public function route(){
        $this->url = $_SERVER['REQUEST_URI'];
        if($this->url=='/index.php' || $this->url=='/'){
            return ['controller'=>'Site','action'=>'index'];
        }else{
            $dataArray = explode('/',$this->url);
            if(isset($dataArray[2])){
                $action = explode('?',end($dataArray));
                $data['action']=isset($action[0])?$action[0]:$dataArray[2];
            }
            $data['controller']=isset($dataArray[1])?$dataArray[1]:false;
            return $data;
        }

    }


}