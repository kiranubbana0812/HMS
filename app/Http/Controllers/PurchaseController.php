<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PurchaseController extends Controller
{
    public function index(Request $request)
    {
<<<<<<< HEAD
        $page = $request->query('page', 1);
        $token = session('auth_token'); // Get token from session
=======
        
       
        
        $page = $request->query('page', 1);
        $perPage = $request->get('per_page', 15);
        $token = session('auth_token'); // Get token from session

        //dd($token);
>>>>>>> 6b8595dc1c62273c0bff306bbd6788244a439795
        if (!$token) {
            return redirect()->route('login')->withErrors(['message' => 'Session expired. Please log in again.']);
        }

        $queryParams = $request->query();
        $queryParams['page'] = $page;
<<<<<<< HEAD

        if(session('user.role') === "pharma") {
            $purchaseDataresponse = Http::withToken($token) 
                    ->get(env('API_BASE_URL') . '/api/v1/pharma/get/purchases', $queryParams);
            $responseSuppliers = Http::withToken($token) 
                                ->get(env('API_BASE_URL') . '/api/v1/pharma/supplier');
            $productsDataresponse = Http::withToken($token) 
                                ->get(env('API_BASE_URL') . '/api/v1/pharma/products');  
        }
        else {

            $purchaseDataresponse = Http::withToken($token) 
                    ->get(env('API_BASE_URL') . '/api/v1/inventory/admin/get/purchases', $queryParams);
            $responseSuppliers = Http::withToken($token) 
                                ->get(env('API_BASE_URL') . '/api/v1/admin/supplier');
            $productsDataresponse = Http::withToken($token) 
                                ->get(env('API_BASE_URL') . '/api/v1/admin/products'); 
        }


        

        $purchasesData = $purchaseDataresponse->json();

        //dd($purchasesData);

        /*$responseSuppliers = Http::withToken($token) 
                                ->get(env('API_BASE_URL') . '/api/v1/admin/supplier');*/
        $Suppliers[] = $responseSuppliers->json();
        $suppliersData = $responseSuppliers->json()['data'] ?? [];
               
=======
        $purchaseDataresponse = Http::withToken($token) // Use session token if stored during login
                    ->get(env('API_BASE_URL') . '/api/v1/inventory/admin/purchase', $queryParams);

                    

        $purchasesData = $purchaseDataresponse->json();

         //dd($purchasesData);
        $responseSuppliers = Http::withToken($token) 
                                ->get(env('API_BASE_URL') . '/api/v1/admin/supplier');           
        $Suppliers[] = $responseSuppliers->json();
        $suppliersData = $responseSuppliers->json()['data'] ?? [];
        $productsDataresponse = Http::withToken($token) 
                                ->get(env('API_BASE_URL') . '/api/v1/admin/products');         
>>>>>>> 6b8595dc1c62273c0bff306bbd6788244a439795
        $productsData = $productsDataresponse->json()['data'] ?? [];
        if (!$purchaseDataresponse->successful()) {
            return redirect()->back()->withErrors('Failed to fetch doctor data');
        }
<<<<<<< HEAD
        
        if(session('user.role') === "pharma") {
            return view('purchases.pharmaPurchases', [
                'purchasesData' => $purchasesData['data'] ?? [],
                'pagination' => $purchasesData['pagination'] ?? null,
                'filters' => $queryParams,
                'suppliersData' => $suppliersData,
                'productsData' => $productsData,
            ]);
        }
        else {
            return view('purchases.purchases', [
                'purchasesData' => $purchasesData['data'] ?? [],
                'pagination' => $purchasesData['pagination'] ?? null,
                'filters' => $queryParams,
                'suppliersData' => $suppliersData,
                'productsData' => $productsData,
            ]);
        }       
=======
               
        return view('purchases.purchases', [
            'purchasesData' => $purchasesData['data'] ?? [],
            'pagination' => $purchasesData['pagination'] ?? null,
            'filters' => $queryParams,
            'page' => $page,
			'perPage' =>$perPage,
            'suppliersData' => $suppliersData,
            'productsData' => $productsData,
        ]);
>>>>>>> 6b8595dc1c62273c0bff306bbd6788244a439795
    }
}