<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Campaign;


class CampaignController extends Controller
{

        public function index(Request $request)
        {
            $campaigns = Campaign::all();
            return response()->json($campaigns);
        }
    
        public function store(Request $request)
        {
            //print_r ($request);
            //return response()->json($request);

            

            $requiredFields = [
                'user_id',
                'cause',
                'title',
                'description',
                'goal_amount',
                'start_date',
                'end_date',
                'beneficiary_name',
                'beneficiary_age',
                'beneficiary_city',
                'beneficiary_mobile',
                'status'
            ];
        
            // Iterate over the required fields
            foreach ($requiredFields as $field) {
                // Check if the field is missing in the request
                if (!$request->has($field)) {
                    // Return an error response indicating the missing field
                    return response()->json(['error' => 'The ' . $field . ' field is required.'], 422);
                }
            }

    

            $request->validate([
                'user_id' => 'required|exists:allusers,id',
                'cause' => 'required|string|max:255',
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'goal_amount' => 'required|numeric|min:0',
                'current_amount' => 'nullable|numeric|min:0',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
                'beneficiary_name' => 'required|string|max:255',
                'beneficiary_age' => 'required|integer|min:0',
                'beneficiary_city' => 'required|string|max:255',
                'beneficiary_mobile' => 'required|string|max:255',
                'status' => 'required|in:active,inactive,pending',
            ]);
            $user_id = Auth::id();
            dd($user_id);
            $campaign = new Campaign();
            $campaign->fill($request->input());

            if ($campaign) {
                $campaign->status = 'pending';
            }

            $campaign->save();


            return response()->json([

                "message" => "campain createdSuccess",
                "userData"=> $campaign,
            
                
            ],201);


        }
          
        public function show($id)
        {
            $user = Campaign::findOrFail($id);
            return response()->json($user);
        }
    
        public function update(Request $request, $id)
        {
            $campaign = Campaign::findOrFail($id);  
            
            if ($campaign->user_id != $request->userInfo['id']) {
                return response()->json(['error' => 'Unauthorized action.'], 403);
            }        
            
            // Validate the request data
            $request->validate([
                'cause' => 'required|string|max:255',
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'goal_amount' => 'required|numeric|min:0',
                'current_amount' => 'nullable|numeric|min:0',
                'end_date' => 'required|date|after_or_equal:start_date',
                'beneficiary_name' => 'required|string|max:255',
                'beneficiary_age' => 'required|integer|min:0',
                'beneficiary_city' => 'required|string|max:255',
                'beneficiary_mobile' => 'required|string|max:255',
            ]);

            // Exclude fields that should not be updated
            $data = $request->except(['user_id', 'start_date', 'status']);

            // Update the campaign with the request data
            $campaign->update($data);

            return response()->json([

                "message" => "campain createdSuccess",
                "userData"=> $campaign,
                "request"=> $request->userInfo['id']
                
            ],201);
        }

        public function donate(Request $request){

                   // Validate the donation request
        $request->validate([
            'donor_id' => 'required|exists:users,id',
            'campaign_id' => 'required|exists:campaigns,id',
            'amount' => 'required|numeric|min:0',
        ]);

        // Get user and campaign
        $user = User::findOrFail($request->donor_id);
        $campaign = Campaign::findOrFail($request->campaign_id);

        // Validate user's balance
        if ($user->balance < $request->amount) {
            return response()->json(['error' => 'Insufficient balance'], 400);
        }

        // Update user's balance
        $user->balance -= $request->amount;
        $user->save();

        // Update campaign's current amount
        $campaign->current_amount += $request->amount;
        $campaign->save();

        // Create donation record
        $donation = new Donation();
        $donation->user_id = $user->id;
        $donation->campaign_id = $campaign->id;
        $donation->amount = $request->amount;
        $donation->transaction_date = Carbon::now(); // Set transaction date to current date
        $donation->save();

        return response()->json(['message' => 'Donation successful'], 200);

        }
    
        public function destroy($id)
        {
         $user = Campaign::findOrFail($id);

         if ($campaign->user_id != $request->userInfo['id']) {
            return response()->json(['error' => 'Unauthorized action.'], 403);
        }   

         $user->delete();
         return response()->json($user);
        }
    
    }
    

