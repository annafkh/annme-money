<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class GoogleController extends Controller
{
    public function redirect()
    {
        // pakai stateless() supaya token bisa lewat WebView tanpa session mismatch
        return Socialite::driver('google')
                        ->stateless()
                        ->with(['prompt' => 'select_account'])
                        ->redirect();
    }

    public function callback()
    {
        $guser = Socialite::driver('google')->stateless()->user();
    
        $user = User::firstOrCreate(
          ['email' => $guser->getEmail()],
          ['name' => $guser->getName(), 'password' => bcrypt(str()->random())]
        );
        Auth::login($user);
    
        // Kirim token atau flag lewat URL
        $token = $user->createToken('mobile')->plainTextToken;
    
        return redirect("dompetannme://callback?token={$token}");
    }    
}