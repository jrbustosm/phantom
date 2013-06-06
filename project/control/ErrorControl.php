<?php



class ErrorControl extends Control{

  function byDefault(array $parameters){

    echo "page does not exist";

    print_r($parameters);

  }



}

