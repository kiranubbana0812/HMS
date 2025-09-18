<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class FrontdeskController extends Controller
{
    public function storeSession(Request $request)
    {
        session(['user' => $request->input('user')]);
        session(['auth_token' => $request->input('login_token')]);
        session(['role' => $request->input('role')]);

        if (session()->has('user')) {
            return response()->json(['message' => 'User stored']);
        } else {
            return response()->json(['message' => 'Failed to store user'], 500);
        }
    }
    
    public function dashboard(Request $request)
    {
        try {
			//\Log::info('Stored user session in dashboard: ', session()->all());
			
			$sessionData = session()->has('user');
			$userId= session('user.id', null);
			//\Log::info('User session data: ', $sessionData ? session('user') : 'No user session found');
			
			//\Log::info('User ID: ' . $userId);
			
			// Optional: prevent access if session is missing
			if (!$sessionData || !$userId) {
				return redirect('/login')->withErrors(['message' => 'Unauthorized. Please login.']);
			}

			$token = session('auth_token'); // Get token from session
			
			$apiUrl = config('services.api.base_url') . '/api/v1/frontdesk/dasshboard/counts';

			if (!$token) {
				return redirect()->route('login')->withErrors(['message' => 'Session expired. Please log in again.']);
			}

			//\Log::info('API URL: ' . $apiUrl);
			$response = Http::withToken($token)->get($apiUrl);
			//\Log::info('Raw API Response: ' . $response->body());      
			//dd($response);

			if ($response->successful()) {
				$data = $response->json();
				return view('frontdesk.dashboard', compact('data'));
			} else {
				return view('frontdesk.dashboard')->withErrors(['api' => 'Failed to load dashboard data']);
			}
        } catch (\Exception $e) {
			DB::rollBack();

			return response()->json([
				'success' => false,
				'message' => $e->getMessage(),
			], 500);
		}
    }
}
