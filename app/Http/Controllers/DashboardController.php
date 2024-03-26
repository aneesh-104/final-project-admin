<?php

namespace App\Http\Controllers;
use App\Models\Campaign;
use App\Models\AllUser;
use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
         $campaigns = Campaign::all();
         $allusers  = AllUser::all();
         $donations = Donation::all();
         return view('dashboard', compact('campaigns', 'allusers','donations'));

     
         //dd($allusers);

        //return view('allusertable', compact('allusers'));
        // return view('allusertable',compact('allusers'));
        

        // $userId = Auth::id();
    

        // // Fetch campaigns associated with the authenticated user
        // $campaigns = Campaign::where('user_id', $userId)->get();

        
    }

    // public function approve(Campaign $campaign)
    // {
    //     $campaign->status = 'active';
    //     $campaign->save();

    //     return redirect()->route('dashboard');
    // }

    // public function deny(Campaign $campaign)
    // {
    //     $campaign->status = 'inactive';
    //     $campaign->save();

    //     return redirect()->route('dashboard');
    // }
    public function approve($id)
    {
        $campaign = Campaign::findOrFail($id);
        $campaign->status = 'active';
        $campaign->save();

        return redirect()->route('dashboard')->with('success', 'Campaign approved successfully');
    }

    public function deny($id)
    {
        $campaign = Campaign::findOrFail($id);
        $campaign->status = 'inactive';
        $campaign->save();

        return redirect()->route('dashboard')->with('success', 'Campaign denied successfully');
    }

}
