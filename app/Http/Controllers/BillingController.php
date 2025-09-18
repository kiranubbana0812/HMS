<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;

class BillingController extends Controller
{
    public function __construct()
    {
        if (!session()->has('user')) {           
            $this->middleware(function ($request, $next) 
            {
                if (!session()->has('user')) 
                {
                    return redirect('/login')
                        ->withErrors(['message' => 'Unauthorized. Please login.']);
                }
                return $next($request);
            });
        }   
    }
    
    public function index(Request $request)
    {        
       $page = $request->query('page', 1);
       $perPage = $request->get('per_page', 15);

        $token = session('auth_token'); // Get token from session
        if (!$token) {
            return redirect()->route('login')->withErrors(['message' => 'Session expired. Please log in again.']);
        }
        
        /*$queryParams = [
            'page' => $page,
            'per_page' => $perPage,
            'patient_id' => $request->get('patient_id'),
            'patient_name' => $request->get('patient_name'),
            'patient_phone_number' => $request->get('patient_phone_number'),
            'invoice_no' => $request->get('invoice_no'),
            'date_from' => $request->get('date_from'),
            'date_to' => $request->get('date_to'),
        ];*/
        
        // ✅ Collect all query params dynamically
		$queryParams = $request->query();  

		// ✅ Ensure page is always set (override if missing)
		$queryParams['page'] = $page;
		
		$queryParams['perPage'] = $perPage;
		

        $queryParams = array_filter($queryParams, fn($value) => !is_null($value) && $value !== '');
        
<<<<<<< HEAD
        if(session('user.role') === "pharma") {
            $response = Http::withToken($token)
            ->get(env('API_BASE_URL') . '/api/v1/pharma/sales', $queryParams);
        }
        else {
            $response = Http::withToken($token)
            ->get(env('API_BASE_URL') . '/api/v1/billing/admin/sales', $queryParams);
        }
        
=======
        $response = Http::withToken($token)
            ->get(env('API_BASE_URL') . '/api/v1/billing/admin/sales', $queryParams);
>>>>>>> 6b8595dc1c62273c0bff306bbd6788244a439795

        $billingData = $response->json();

        //dd($billingData);
        //\Log::info('API Response: ' . print_r($appointmentData, true));

        if (!$response->successful()) {
            return redirect()->back()->withErrors('Failed to fetch billing data');
        }
        
        $billingData = $response->json();

        //dd($billingData);
        
        if(session('user.role') === "superadmin") {
            return view('billing.superadminBilling', [
                'billing' => $billingData['data'] ?? [],
                'pagination' => $billingData['pagination'] ?? null,
                'filters' => $queryParams,
<<<<<<< HEAD
=======
                'page' => $page,
				'perPage' =>$perPage,
                'units' => $unitsData['data'] ?? [],
                'categories' => $categoriesData['data'] ?? [],
            ]);
		}elseif(session('user.role') === "frontdesk") {
            return view('billing.frontdeskBilling', [
                'billing' => $billingData['data'] ?? [],
                'pagination' => $billingData['pagination'] ?? null,
                'filters' => $queryParams,
                'page' => $page,
				'perPage' =>$perPage,
>>>>>>> 6b8595dc1c62273c0bff306bbd6788244a439795
                'units' => $unitsData['data'] ?? [],
                'categories' => $categoriesData['data'] ?? [],
            ]);
		}
<<<<<<< HEAD
        else if(session('user.role') === "pharma") {
            return view('billing.pharmaBilling', [
                'billing' => $billingData['data'] ?? [],
                'pagination' => $billingData['pagination'] ?? null,
                'filters' => $queryParams,
                'units' => $unitsData['data'] ?? [],
                'categories' => $categoriesData['data'] ?? [],
            ]);
        }
=======
>>>>>>> 6b8595dc1c62273c0bff306bbd6788244a439795
		else {
            return view('billing.index', [
                'billing' => $billingData['data'] ?? [],
                'pagination' => $billingData['pagination'] ?? null,
                'filters' => $queryParams,
<<<<<<< HEAD
=======
                'page' => $page,
				'perPage' =>$perPage,
>>>>>>> 6b8595dc1c62273c0bff306bbd6788244a439795
            ]);
		}
    }
}
