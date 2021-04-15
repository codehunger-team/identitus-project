<?php

namespace App\Traits;
use Carbon\Carbon;
use Auth;

trait AuthTrait {

    public function authID()
    {
        return Auth::id();
    }

}
