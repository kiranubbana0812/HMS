<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProductController extends Controller
{
    public function __construct()
    {
        if (!session()->has('user')) {
            redirect('/login')->withErrors(['message' => 'Unauthorized. Please login.'])->send();
        }
    }

    public function index(Request $request)
    {
        $page = $request->query('page', 1);
        $perPage = $request->get('per_page', 15);
        $token = session('auth_token');
       // dd($token);
        if (!$token) {
            return redirect()->route('login')->withErrors(['message' => 'Session expired. Please log in again.']);
        }

        // Collect filters from request
        $queryParams = $request->query();
        $queryParams['page'] = $page;

        $response = Http::withToken($token)->get(
            env('API_BASE_URL') . '/api/v1/admin/products', 
            $queryParams
        );

        if (!$response->successful()) {
            return redirect()->back()->withErrors('Failed to fetch product data');
        }

         $productsData = $response->json();


        
        
 
//dd($productsData);
     
        // Fetch units
        $unitsResponse = Http::withToken($token)->get(
            env('API_BASE_URL') . '/api/v1/admin/units'
        );
        $unitsData = $unitsResponse->json();

        // Fetch categories
        $categoriesResponse = Http::withToken($token)->get(
            env('API_BASE_URL') . '/api/v1/admin/productcategories'
        );
        $categoriesData = $categoriesResponse->json();

        return view('products.superAdminProducts', [
            'products' => $productsData['data'] ?? [],
            'pagination' => $productsData['pagination'] ?? null,
            'filters' => $queryParams,
            'page' => $page,
			'perPage' =>$perPage,
            'units' => $unitsData['data'] ?? [],
            'categories' => $categoriesData['data'] ?? [],
            
           
        ]);
    }
}