<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\LoginFormRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function __construct(User $user)
    {
        $this->user = $user;
    }
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

        // 1.アカウントがロックしていたら弾く
        $user = $this->user->getUserByEmail($credentials['email']);
        // $user = User::where('email', '=', $credentials['email'] )->first();

        if (!is_null($user)){
            if($this->user->isAccountLocked($user)) {
                return back()->withErrors([
                    'danger' => 'アカウントがロックされています。',
                   ]);
            }

            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                // 2.ログインが成功したらエラーアカウントをリセット
                $this->user->resetErrorCount($user);
     
                return redirect()->route('home')->with('success','ログイン成功しました。');
             //    return redirect()->route('home')->with('login_success','ログイン成功しました。');
            }

            // 3.ログインに失敗したらエラーアカウントを１増やす
            $user->error_count = $this->user->addErrorCount($user->error_count);
            
            // 4.エラーアカウントが６以上の場合はアカウントをロックする
            if($this->user->lockAccount($user)) {
                return back()->withErrors([
                    'danger' => 'アカウントがロックされました。解除したい場合は運営者に連絡してください。',
                   ]);
             }
            $user->save();
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
