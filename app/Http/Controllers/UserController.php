<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Customer;
use App\Http\Requests\LoginRequest;
use Auth;

class UserController extends Controller
{
    public function login(): View {
        return view('pages.login.index');
    }

    public function logout() {
        Auth::logout();
        return redirect()->route('login');
    }

    public function loginSubmit(LoginRequest $request): Response {
       // dd($request->all());
        if (Auth::attempt(['email' => $request->email,'password' =>$request->password],true)) {
            $user=User::find(Auth::user()->id);
            return Response(['code'=>200 , 'message'=>'Đăng nhập thành công' ],200);
        }
        return Response(['code'=>400 , 'message'=>'Email hoặc mật khẩu không đúng' ],400);
    }
}
