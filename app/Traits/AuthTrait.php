<?php

namespace App\Traits;
use Auth;

trait AuthTrait {

    public function authID()
    {
        return Auth::id();
    }

}
