<?php

class MainControl extends Control{

  public function byDefault(array $parameters){
    $data= array(
      "title"=>"My Title",
      "content"=>"content",
    );
    $this->showView("byDefault", $data);
  }

}  

