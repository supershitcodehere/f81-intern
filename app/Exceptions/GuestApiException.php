<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class GuestApiException extends Exception
{
    public $message;
    public $code;

    public function render(){
        if(is_null($this->code)){
            $this->code = 503;
        }
        if(is_null($this->message)){
            $this->message = '';
        }
        return response()->json(['result'=>'NG','message'=>$this->message],$this->code);
    }
}
