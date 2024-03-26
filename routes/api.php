 <?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AllUserController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
    
    //Route::resource('/allusers', \App\Http\Controllers\AllUserController::class);//->middleware(\App\Http\Middleware\ValidateToken::class);

    Route::post('/login',[App\Http\Controllers\AllUserController::class, 'login']);
    Route::post('/register',[App\Http\Controllers\AllUserController::class, 'store']);
    Route::get('/profile/user',[App\Http\Controllers\AllUserController::class, 'store']);



    Route::get('/getUsers',[App\Http\Controllers\AllUserController::class, 'index']);
    // Route::put('/update/{id}',[App\Http\Controllers\AllUserController::class, 'update']);
    // Route::delete('/delete/{id}',[App\Http\Controllers\AllUserController::class, 'destroy']);








    Route::post('/donation',[App\Http\Controllers\DonationController::class, 'store']);






    Route::get('/getAllActiveCampaigns',[App\Http\Controllers\CampaignController::class, 'index']);
    Route::post('/campaign',[App\Http\Controllers\CampaignController::class, 'store']);
    Route::post('/campaign/update',[App\Http\Controllers\CampaignController::class, 'update']);
    Route::post('/campaign/donate',[App\Http\Controllers\CampaignController::class, 'donate']);



    Route::get('/dashboard',[App\Http\Controllers\AllUserController::class, 'Dashboard'])->middleware('checkUserRole');



    // Route::get('/admin/users', [AdminController::class, 'index']);
    // Route::get('/admin/users/create', [AdminController::class, 'create']);
    // Route::post('/admin/users', [AdminController::class, 'store']);
    // Route::get('/admin/users/{id}', [AdminController::class, 'show']);
    // Route::get('/admin/users/{id}/edit', [AdminController::class, 'edit']);
    // Route::put('/admin/users/{id}', [AdminController::class, 'update']);
    // Route::delete('/admin/users/{id}', [AdminController::class, 'destroy']);


    

    
    
    

