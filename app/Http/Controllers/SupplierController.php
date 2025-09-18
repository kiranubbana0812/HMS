<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;

class SupplierController extends Controller
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
        
        // ✅ Collect all query params dynamically
		$queryParams = $request->query();  

		// ✅ Ensure page is always set (override if missing)
		$queryParams['page'] = $page;
		
		$queryParams['perPage'] = $perPage;
		

        $queryParams = array_filter($queryParams, fn($value) => !is_null($value) && $value !== '');
        
        $response = Http::withToken($token)
            ->get(env('API_BASE_URL') . '/api/v1/admin/supplier', $queryParams);

        $suppliersData = $response->json();

        //dd($suppliersData);
        //\Log::info('API Response: ' . print_r($appointmentData, true));

        if (!$response->successful()) {
            return redirect()->back()->withErrors('Failed to fetch suppliers data');
        }
        
        if(session('user.role') === "superadmin") {
            return view('suppliers.superadminSuppliers', [
                'suppliers' => $suppliersData['data'] ?? [],
                'pagination' => $suppliersData['pagination'] ?? null,
                'filters' => $queryParams,
            ]);
        }
        /*$suppliers = collect($suppliersData['data'] ?? []);
        $total = $suppliersData['total'] ?? $suppliers->count();
        $currentPage = $suppliersData['current_page'] ?? $page;

        $paginator = new LengthAwarePaginator(
            $suppliers,
            $total,
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );        
        
        if(session('user.role') === "superadmin") {
			return view('suppliers.superadminSuppliers', [
				'suppliers' => $paginator,
				'filters' => $request->all(),
			]);
		}*/
		
        /*else {
			return view('suppliers.index', [
				'suppliers' => $paginator,
				'filters' => $request->all(),
			]);
		}*/
    }
}
