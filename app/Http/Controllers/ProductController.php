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
<<<<<<< HEAD
        $token = session('auth_token');
        
=======
        $perPage = $request->get('per_page', 15);
        $token = session('auth_token');
       // dd($token);
>>>>>>> 6b8595dc1c62273c0bff306bbd6788244a439795
        if (!$token) {
            return redirect()->route('login')->withErrors(['message' => 'Session expired. Please log in again.']);
        }

        // Collect filters from request
        $queryParams = $request->query();
        $queryParams['page'] = $page;

<<<<<<< HEAD
        if(session('user.role') === "pharma") {
            $response = Http::withToken($token)->get(
                env('API_BASE_URL') . '/api/v1/pharma/products', 
                $queryParams
            ); 
        }
        else {
            $response = Http::withToken($token)->get(
                env('API_BASE_URL') . '/api/v1/admin/products', 
                $queryParams
            );    
        }
        
=======
        $response = Http::withToken($token)->get(
            env('API_BASE_URL') . '/api/v1/admin/products', 
            $queryParams
        );

>>>>>>> 6b8595dc1c62273c0bff306bbd6788244a439795
        if (!$response->successful()) {
            return redirect()->back()->withErrors('Failed to fetch product data');
        }

<<<<<<< HEAD
        $productsData = $response->json();
        
        // Fetch units
        if(session('user.role') === "pharma") {
            $unitsResponse = Http::withToken($token)->get(
                env('API_BASE_URL') . '/api/v1/pharma/units'
            );
        }
        else {
            $unitsResponse = Http::withToken($token)->get(
                env('API_BASE_URL') . '/api/v1/admin/units'
            );    
        }
        
        
        $unitsData = $unitsResponse->json();

        // Fetch categories
        if(session('user.role') === "pharma") {
            $categoriesResponse = Http::withToken($token)->get(
                env('API_BASE_URL') . '/api/v1/pharma/productcategories'
            );    
        }
        else {
            $categoriesResponse = Http::withToken($token)->get(
                env('API_BASE_URL') . '/api/v1/admin/productcategories'
            );
        }
        
        $categoriesData = $categoriesResponse->json();

        if(session('user.role') === "pharma") {
            return view('products.pharmaAdminProducts', [
                'products' => $productsData['data'] ?? [],
                'pagination' => $productsData['pagination'] ?? null,
                'filters' => $queryParams,
                'units' => $unitsData['data'] ?? [],
                'categories' => $categoriesData['data'] ?? [],
            ]);
        }
        else {
            return view('products.superAdminProducts', [
                'products' => $productsData['data'] ?? [],
                'pagination' => $productsData['pagination'] ?? null,
                'filters' => $queryParams,
                'units' => $unitsData['data'] ?? [],
                'categories' => $categoriesData['data'] ?? [],
            ]);
        }
=======
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
>>>>>>> 6b8595dc1c62273c0bff306bbd6788244a439795
    }
}