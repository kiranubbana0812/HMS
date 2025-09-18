<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AppointmentController extends Controller
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
<<<<<<< HEAD
        
=======
        $perPage = 15;
>>>>>>> 6b8595dc1c62273c0bff306bbd6788244a439795
        /*$filters = $request->only([
            'patient_id', 'patient_name', 'doctor_id', 'doctor_name', 'department', 'from_date', 'to_date'
        ]);*/

        $token = session('auth_token'); // Get token from session
        if (!$token) {
            return redirect()->route('login')->withErrors(['message' => 'Session expired. Please log in again.']);
        }

        // Collect filters from request
        $queryParams = $request->query();
        $queryParams['page'] = $page;

        // Fetch from API
        if(session('user.role') === "doctor") {
			$response = Http::withToken($token) // Use session token if stored during login
            ->get(env('API_BASE_URL') . '/api/v1/admin/appointments/doctor-appointments', $queryParams);
		}
		else {
			// Appointments API call
			$response = Http::withToken($token)
				->get(env('API_BASE_URL') . '/api/v1/admin/appointments/all', $queryParams);
		}
        
        $appointmentData = $response->json();

        // Fetch from API
        if(session('user.role') === "doctor") {
			$responseTodaysCount = Http::withToken($token) // Use session token if stored during login
            ->get(env('API_BASE_URL') . '/api/v1/admin/appointments/doctorStats');
		}
		else {
			$responseTodaysCount = Http::withToken($token) // Use session token if stored during login
            ->get(env('API_BASE_URL') . '/api/v1/admin/appointments/todays-count');
		}
		
        $todaysCount = $responseTodaysCount->json();
        
        if(session('user.role') === "doctor") {
			// Take only totaltoday but rename to total
			$todaysCount = [
				'data' => [
					'total'     => $todaysCount['data']['totaltoday'] ?? 0,
					'completed' => $todaysCount['data']['completedtoday'] ?? 0,
					'cancelled' => $todaysCount['data']['cancelledtoday'] ?? 0,
				]
			];
		}
        
        $responseDepartments = Http::get(env('API_BASE_URL') . '/api/v1/departments');
        $departmentsData = $responseDepartments->json();
        //dd($departmentsData);
        //dd($appointmentData);
        //\Log::info('API Response: ' . print_r($appointmentData, true));

        if (!$response->successful()) {
            return redirect()->back()->withErrors('Failed to fetch doctor data');
        }
        //dd($appointmentData);
        
        if(session('user.role') === "doctor") {
			return view('appointments.doctorAppointments', [
				'appointments' => $appointmentData['data'] ?? [],
				'pagination' => $appointmentData['pagination'] ?? null,
				'filters' => $queryParams,
<<<<<<< HEAD
=======
				'page' => $page,
				'perPage' =>$perPage,
>>>>>>> 6b8595dc1c62273c0bff306bbd6788244a439795
				'todaysCount' => $todaysCount['data'] ?? [],
				'departmentData' => $departmentsData['data'] ?? []
			]);
		}
		else if(session('user.role') === "superadmin"){
			return view('appointments.superadminAppointments', [
				'appointments' => $appointmentData['data'] ?? [],
				'pagination' => $appointmentData['pagination'] ?? null,
				'filters' => $queryParams,
<<<<<<< HEAD
=======
				'page' => $page,
				'perPage' =>$perPage,
>>>>>>> 6b8595dc1c62273c0bff306bbd6788244a439795
				'todaysCount' => $todaysCount['data'] ?? 0,
				'departmentData' => $departmentsData['data'] ?? [],
			]);
		}
		else {
			return view('appointments.index', [
				'appointments' => $appointmentData['data'] ?? [],
				'pagination' => $appointmentData['pagination'] ?? null,
				'filters' => $queryParams,
<<<<<<< HEAD
=======
				'page' => $page,
				'perPage' =>$perPage,
>>>>>>> 6b8595dc1c62273c0bff306bbd6788244a439795
				'todaysCount' => $todaysCount['data'] ?? 0,
				'departmentData' => $departmentsData['data'] ?? [],
			]);
		}
    }
}
