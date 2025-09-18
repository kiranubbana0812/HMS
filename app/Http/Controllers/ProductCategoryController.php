<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProductCategoryController extends Controller
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

        if (!$token) {
            return redirect()->route('login')->withErrors(['message' => 'Session expired. Please log in again.']);
        }

        $queryParams = $request->query();
        $queryParams['page'] = $page;
        
        $categoriesResponse = Http::withToken($token)->get(
            env('API_BASE_URL') . '/api/v1/admin/productcategories',
            $queryParams
        );

        if (!$categoriesResponse->successful()) {
            return redirect()->back()->withErrors('Failed to fetch product categories');
        }

        $categoriesData = $categoriesResponse->json();
        $categories = collect($categoriesData['data'] ?? [])->sortBy('id')->values()->all();

        //dd($categoriesData);

        return view('productcategories.superAdminCategories', [
            'categories' => $categories,
            'pagination' => $categoriesData['pagination'] ?? null,
            'page' => $page,
			'perPage' =>$perPage,
            'filters'    => $queryParams,
        ]);
    }
}