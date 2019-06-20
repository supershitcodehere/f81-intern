<?php

namespace App\Providers;

use App\Exceptions\GuestApiException;
use App\Traits\GuestApi;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\ServiceProvider;

class GuestApiRequestServiceProvider extends ServiceProvider
{

    use GuestApi;

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->addMacroGuestApiRequest();
    }

    private function addMacroGuestApiRequest(){
        Request::macro('getGuestApiRequest', function () {
           $body = $this->input();
           if(empty($body)){
               throw new GuestApiException("不正なリクエストボディです",400);
           }
            return $this->input();
        });
    }
}
