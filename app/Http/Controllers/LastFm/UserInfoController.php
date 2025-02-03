<?php

namespace App\Http\Controllers\LastFm;

use App\Http\Controllers\Controller;

class UserInfoController extends Controller
{
    public function __invoke()
    {
        return view('last-fm.user_info');
    }
}
