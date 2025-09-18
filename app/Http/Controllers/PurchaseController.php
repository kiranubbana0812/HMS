<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PurchaseController extends Controller
{
    public function index(Request $request)
    {
        $page = $request->query('page', 1);
        $token = session('auth_token'); // Get token from session
        if (!$token) {
            return redirect()->route('login')->withErrors(['message' => 'Session expired. Please log in again.']);
        }

        $queryParams = $request->query();
        $queryParams['page'] = $page;

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
               
        $productsData = $productsDataresponse->json()['data'] ?? [];
        if (!$purchaseDataresponse->successful()) {
            return redirect()->back()->withErrors('Failed to fetch doctor data');
        }
        
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
    }
}