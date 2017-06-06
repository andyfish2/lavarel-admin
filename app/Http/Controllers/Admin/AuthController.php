<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    use AuthenticatesUsers;

    public function showLoginForm()
    {
        return view('admin.login.login');
    }

    public function username()
    {
        return 'name';
    }

    protected function authenticated(Request $request, $user)
    {
        echo "OK";
    }
}
