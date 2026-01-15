<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\NewsletterSubscription;
use Illuminate\Support\Facades\Validator;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        try {
            // Validate the email
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|max:255'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please provide a valid email address.'
                ], 422);
            }

            $email = $request->input('email');

            // Check if already subscribed
            if (NewsletterSubscription::isSubscribed($email)) {
                return response()->json([
                    'success' => false,
                    'message' => 'This email is already subscribed.'
                ], 400);
            }

            // Prepare subscription data
            $subscriptionData = ['email' => $email];

            // Add user info if authenticated
            if (Auth::check()) {
                $user = Auth::user();
                $subscriptionData['user_id'] = $user->id;
                $subscriptionData['name'] = $user->name;
            }

            // Create subscription
            NewsletterSubscription::create($subscriptionData);

            return response()->json([
                'success' => true,
                'message' => 'Successfully subscribed to newsletter!'
            ]);
        } catch (\Exception $e) {
            Log::error('Newsletter subscription error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Something went wrong. Please try again.'
            ], 500);
        }
    }

    public function unsubscribe(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid email address.'
                ], 422);
            }

            $email = $request->input('email');

            // Find and deactivate subscription
            $subscription = NewsletterSubscription::where('email', $email)->first();

            if ($subscription) {
                $subscription->update(['is_active' => false]);

                return response()->json([
                    'success' => true,
                    'message' => 'Successfully unsubscribed from newsletter.'
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Email not found in subscription list.'
            ], 404);
        } catch (\Exception $e) {
            Log::error('Newsletter unsubscribe error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Something went wrong. Please try again.'
            ], 500);
        }
    }
}
