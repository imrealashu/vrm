<?php namespace Listbees\VRM\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AccountController extends Controller
{
    public function logout()
    {
        session()->forget('vrm-admin');

        return redirect()->route('vrm-login');
    }

    public function login()
    {
        return view('vrm::login');
    }

    public function processLogin(Request $request)
    {
        $password = $request->password;
        $hash = config('vrm.password');

        if ($password != $hash) return redirect()->route('vrm-login')->with(['message' => 'The password is wrong.']);

        session(['vrm-admin' => true]);
        return redirect()->route('vrm-home');
    }
}