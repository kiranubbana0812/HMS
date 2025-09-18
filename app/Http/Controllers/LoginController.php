<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function logout(Request $request)
    {
        session()->forget('user');
        return redirect()->route('login')->with('message', 'Logged out successfully');
    }
}
// End of file: app/Http/Controllers/LoginController.php