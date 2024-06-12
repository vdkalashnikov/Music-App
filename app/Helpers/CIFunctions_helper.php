<?php

use App\Libraries\CiAuth;
use App\Models\UserModel;

if( !function_exists('get_user')) {
    function get_user() {
        if( CiAuth::check() ){
            $user = new UserModel();
            return $user->asObject()->where('id', CiAuth::id())->first();
        } else {
            return null;
        }
    }
}