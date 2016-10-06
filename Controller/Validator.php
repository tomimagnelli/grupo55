<?php

namespace Controller;

class Validator {
     // Singleton of Validator
     private static $instance;

     public static function getInstance() {
         if (!isset(self::$instance)) {
           self::$instance = new self();
         }
         return self::$instance;
     }

     private function __construct() {}
   // Validators..
     public function isEmail ($value) {
         $response = true;
         if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
             $response = false;
         }
         return $response;
     }

     public function isNumeric ($value) {
         return is_numeric($value);
     }

     public function hasLength($number,$value) {
        return (strlen($value) <= $number);
     }

}


?>
