<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\LoginFormRequest;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * @return view
     */
    public function showLogin()
    {
        return view('login.login_form');
    }

    /**
     * @param App\Http\Requests\LoginFormRequest
     * 
     */
    public function login(LoginFormRequest $request)
    {
       $credentials = $request->only('email','password');

       if (Auth::attempt($credentials)) {
           $request->session()->regenerate();

           return redirect()->route('home')->with('success','ログイン成功しました。');
        //    return redirect()->route('home')->with('login_success','ログイン成功しました。');
       }

       return back()->withErrors([
        'danger' => 'メールアドレスかパスワードが間違っています。',
        // 'login_error' => 'メールアドレスかパスワードが間違っています。',
       ]);
    }
    /**
     * ユーザーをアプリケーションからログアウトさせる
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login.show')->with('danger','ログアウトしました。');
        // return redirect()->route('login.show')->with('logout','ログアウトしました。');
    }
}
