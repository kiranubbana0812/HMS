<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class UsersController extends Controller
{
    public function __construct()
    {
        if (!session()->has('user')) {
            return redirect('/login')->withErrors(['message' => 'Unauthorized. Please login.']);
        }   
    }
    public function index(Request $request)
    {
        $page = $request->query('page', 1);

        $token = session('auth_token'); // Get token from session
        
        if (!$token) {
            return redirect()->route('login')->withErrors(['message' => 'Session expired. Please log in again.']);
        }
        
		$queryParams = $request->query();  

		$queryParams['page'] = $page;

        // Fetch from API
        $response = Http::withToken($token) // Use session token if stored during login
            ->get(env('API_BASE_URL') . '/api/v1/admin/users', $queryParams);

        $usersData = $response->json();

        //dd($usersData);
        //\Log::info('API Response: ' . print_r($usersData));

        if (!$response->successful()) {
            return redirect()->back()->withErrors('Failed to fetch users data');
        }
        
        if(session('user.role') === "superadmin") {
            return view('users.superAdminUsers', [
                'users' => $usersData['data'] ?? [],
                'pagination' => $usersData['pagination'] ?? null,
                'filters' => $request->all()
            ]);
        }
    }
}