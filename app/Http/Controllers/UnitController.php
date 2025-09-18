<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;

class UnitController extends Controller
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
            ->get(env('API_BASE_URL') . '/api/v1/admin/units', $queryParams);

        $unitsData = $response->json();

        //dd($unitsData);
        //\Log::info('API Response: ' . print_r($unitsData, true));

        if (!$response->successful()) {
            return redirect()->back()->withErrors('Failed to fetch units data');
        }
        
        if(session('user.role') === "superadmin") {
            return view('units.superadminUnits', [
                'units' => $unitsData['data'] ?? [],
                'pagination' => $unitsData['pagination'] ?? null,
                'page' => $page,
			    'perPage' =>$perPage,
                'filters' => $queryParams,
            ]);
        }
		/*else {
			return view('units.index', [
				'units' => $paginator,
				'filters' => $request->all(),
			]);
		}*/
    }
}
