<?php
namespace App\Traits;

trait GuestApi{

    private $errors = [];

    public function getLastErrors() : array{
        return $this->errors;
    }

    public function isValidJson($json){
        json_decode($json);
        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->errors[] =  json_last_error_msg();
            return false;
        }
        return true;
    }
}
