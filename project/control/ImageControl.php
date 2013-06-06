<?php

class ImageControl extends Control{

  public function byDefault(array $parameters){
    $this->makelist($parameters);
  }

  public function makelist(array $parameters){
    $this->showView("ImagesList", array(
      "images" => Image::searchAll()
    ));
  }

} 
