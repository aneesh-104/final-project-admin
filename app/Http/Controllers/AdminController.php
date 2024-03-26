<?php
namespace App\Http\Controllers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin');
    }

    public function login(Request $request)
    {
        
        $request->validate([
            'username' => 'required',
            'password' => 'required',
            'security_token'=>'required',
        ]);

        if (Auth::guard('admin')->attempt(['username' => $request->username, 'password' => $request->password, 'security_token' => $request->security_token])) {
            // Authentication successful, redirect to the dashboard
            return redirect()->route('dashboard');
        } else {
            // Authentication failed, redirect back with error message
            return back()->withErrors([
                'username' => 'The provided credentials do not match our records.',
            ])->withInput($request->only('username'));
        }
        
        
    }
    public function dashboard(Request $request)
    {
        print_r(Auth::guard('admin')->user()->toArray());

    }
}
    // public function hashAndPrintPassword($password)
    // {
    //     $hashedPassword = Hash::make((string) $password);
    //     echo "Hashed password: " . $hashedPassword . "\n";
    // }
    // }
    // $adminController = new AdminController();
    // $adminController->hashAndPrintPassword(123456); // Replace 123456 with your integer password
