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
        $perPage = $request->get('per_page', 15);
        $token = session('auth_token'); // Get token from session

        //dd($token);
        if (!$token) {
            return redirect()->route('login')->withErrors(['message' => 'Session expired. Please log in again.']);
        }

        $queryParams = $request->query();
        $queryParams['page'] = $page;
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
        $productsData = $productsDataresponse->json()['data'] ?? [];
        if (!$purchaseDataresponse->successful()) {
            return redirect()->back()->withErrors('Failed to fetch doctor data');
        }
               
        return view('purchases.purchases', [
            'purchasesData' => $purchasesData['data'] ?? [],
            'pagination' => $purchasesData['pagination'] ?? null,
            'filters' => $queryParams,
            'page' => $page,
			'perPage' =>$perPage,
            'suppliersData' => $suppliersData,
            'productsData' => $productsData,
        ]);
    }
}