<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PatientController extends Controller
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
        
        // ✅ Collect all query params dynamically
		$queryParams = $request->query();  

		// ✅ Ensure page is always set (override if missing)
		$queryParams['page'] = $page;

		/*echo "<pre>";
		print_r($queryParams);
		exit();*/
        
        // Fetch from API
        $response = Http::withToken($token) // Use session token if stored during login
            ->get(env('API_BASE_URL') . '/api/v1/admin/patients', $queryParams);

        $patientsData = $response->json();

        //dd($patientsData);
        //\Log::info('API Response: ' . print_r($patientsData));

        if (!$response->successful()) {
            return redirect()->back()->withErrors('Failed to fetch patient data');
        }
        
        if(session('user.role') === "superadmin") {
            return view('patients.superAdminPatients', [
                'patients' => $patientsData['data'] ?? [],
                'pagination' => $patientsData ?? null,   // ✅ send full array, not $patientsData['pagination']
                'filters' => $request->all()
            ]);
        }
        else {
            return view('patients.index', [
                'patients' => $patientsData['data'] ?? [],
                'pagination' => $patientsData ?? null,   // ✅ same fix here
                'filters' => $request->all()
            ]);
        }
    }
}