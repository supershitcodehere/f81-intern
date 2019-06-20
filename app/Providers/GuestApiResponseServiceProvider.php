<?php
namespace App\Providers;

use Carbon\Laravel\ServiceProvider;
use Illuminate\Support\Facades\Response;

class GuestApiResponseServiceProvider extends ServiceProvider{
    public function boot()
    {
        Response::macro('success',function($data = []){
            return \response()->json(array_merge(['result'=>'OK'],$data));
        });

        Response::macro('error',function($reason,$data){
            return \response()->json(array_merge(['result'=>'NG','message'=>$reason],$data),400);
        });

        Response::macro('unavailable',function($reason,$data){
            return \response()->json(array_merge(['result'=>'NG','message'=>$reason],$data),503);
        });

    }
}
