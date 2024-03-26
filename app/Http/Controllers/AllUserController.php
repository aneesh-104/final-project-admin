<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\AllUser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class AllUserController extends Controller
{
    public function index(Request $request)
    {
        $allusers = AllUser::all();
        return response()->json($allusers);
    }

    public function store(Request $request)
    {
        
        $requiredFields = [
            'name',
            'email',
            'password',
            'role',
            'sex'
        ];
    
        // Iterate over the required fields
        foreach ($requiredFields as $field) {
            // Check if the field is missing in the request
            if (!$request->has($field)) {
                // Return an error response indicating the missing field
                return response()->json(['error' => 'The ' . $field . ' field is required.'], 422);
            }
        }

        $existingUser = AllUser::where('email', $request->email)->first();
        if ($existingUser) {
            return response()->json(['error' => 'The email has already been taken  .'], 422);
        }

    
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:allusers,email',
            'password' => 'required',
            'role' => 'required|in:donor,fundraiser',
            'sex'=>'required|in:male,female,other',
            'pan' => 'unique:allusers',
            'dob' => 'nullable|date',
            'age' => 'nullable',
            'balance' => 'nullable|numeric',
            'address' => 'nullable',
            'city' => 'nullable',
            'profile_picture' => 'nullable',
            'description' => 'nullable',
        ]);


        $currentDate = date('Y-m-d');
        $age = date_diff(date_create($request->dob), date_create($currentDate))->y;

        try {
            $user = new AllUser();
            $user->fill($request->input());
            $user->age=$age;
            $user->password = bcrypt($request->password);     
            $user->save();
        } catch (Exception $error){

            return response()->json(['error' => $error->getMessage(),"message"=>"db error"], 401);

        }



        return response()->json(
            ["message"=>"user created successfully",
             "logedin user"=>$user]
        ,201);


    }
      
    public function show(Request $request)
    {
        $user = AllUser::findOrFail($request->userInfo['id']);
        return response()->json($user);
    }

    public function update(Request $request)
    {
        
     $user = AllUser::findOrFail($id);
     $request->validate([
        'name' => 'required|max:255',
        'email' => 'required|email|unique:allusers,email,' . $user->id,
        'password' => 'required',
        'role' => 'required|in:donor,fundraiser',
        'dob' => 'nullable|date',
        'age' => 'nullable',
        'address' => 'nullable',
        'city' => 'nullable',
        'profile_picture' => 'nullable',
        'description' => 'nullable',]);

        $user->fill($request->input());
        $user->save();
        return response()->json($user);
    }

    public function destroy($id)
    {
     $user = AllUser::findOrFail($id);
     $user->delete();
     return response()->json($user);
    }

    public function login(Request $request)
    {
            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);
        
            if (Auth::attempt($credentials)) {
                $user = Auth::user();
                
                // Create token payload
                $tokenPayload = [
                    'email' => $user->email,
                    'role' => $user->role,
                    'id' => $user->id
                ];
                // Encrypt the token payload
                $encryptedPayload = Crypt::encrypt(json_encode($tokenPayload));
                
                // Set encrypted payload in cookie
                $cookie = cookie('token', $encryptedPayload,60, null, null, false, false);
        
                return response()->json([
                    "message" => "success",
                    "user" => $user,
                    "token" => $encryptedPayload
                ])->cookie($cookie);
            }
        
            return response()->json([
                "message" => "BAD CREDENTIALS",
                "code" => "401"
            ],401);
    }




    public function Dashboard(Request $request){

        $user = AllUser::find($request->userInfo['id']);

        if (!$user) {
            return response()->json([
                "message" => "Faliure",
                "message"=> "user Not Found",
            ],401);
        }

        return response()->json([

            "message" => "Success",
            "userData"=> $user,
            "request"=> $request->userInfo['id']
            
        ]);

    }



}
