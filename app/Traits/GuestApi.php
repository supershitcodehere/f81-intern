<?php
namespace App\Traits;

use App\Exceptions\GuestApiException;
use App\TestUser;

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

    public function validatePostParams(array $body){
        if(!TestUser::isUserExists($body['user_id'])){
            throw new GuestApiException("ユーザが見つかりません",400);
        }
        $textCount = mb_strlen($body['text']);
        if($textCount <= 0 || $textCount > 100){
            throw new GuestApiException("textは1文字以上100文字以下にしてください",400);
        }
    }
}
