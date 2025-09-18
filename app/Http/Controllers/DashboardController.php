<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class DashboardController extends Controller
{
	public function dashboard(Request $request)
	{
		$authToken = session()->has('auth_token') ? session('auth_token') : null;
		$role=session('user.role');

		if (!$authToken) {
			return redirect('/login')->withErrors(['message' => 'Unauthorized. Please login.']);
		}
	   
		if (!$role) {
			abort(403, 'User role is missing');
		}

		// API call to get dashboard counts
		$apiUrl = config('services.api.base_url') . '/api/v1/frontdesk/dasshboard/counts';
		\Log::info('API URL: ' . $apiUrl);
		\Log::info('Using token: ' . $authToken);

		$response = Http::withToken($authToken)->get($apiUrl);

		if ($response->successful()) {
			$data = $response->json(); // Assuming API returns JSON data
		} else {
			$data = null; // or []
		}

<<<<<<< HEAD
	   switch ($role) {
=======
	   
		switch ($role) {
>>>>>>> 6b8595dc1c62273c0bff306bbd6788244a439795
			case 'superadmin':
				if ($data) {
					return view('dashboard.superadmin', compact('data'));
				} else {
					return view('dashboard.superadmin')->withErrors(['api' => 'Failed to load dashboard data']);
				}

			case 'admin':
				return view('dashboard.admin', compact('data'));

			case 'frontdesk':
				return view('dashboard.frontdesk', compact('data'));

			default:
				abort(403, 'Unauthorized role');
		}
	}


    public function appointments(Request $request)
    {

//dd($request);
     $token = session()->has('auth_token') ? session('auth_token') : null;
     $role=session('user.role'); 
   
    $page = $request->query('page', 1);


    if (!$token) {
        return redirect()->route('login')->withErrors(['message' => 'Session expired. Please log in again.']);
    }

  
    $response = Http::withToken($token)->get(env('API_BASE_URL') . '/api/v1/admin/appointments/all', [
        'page' => $page
    ]);

    $appointmentData = $response->json();

    //dd($appointmentData);

    $responseDepartments = Http::get(env('API_BASE_URL') . '/api/v1/departments');
    $departmentsData = $responseDepartments->json();

    return view('dashboard.appointments', [
         'appointments' => $appointmentData['data'] ?? [],
        'pagination' => $appointmentData['pagination'] ?? null,      
        'departmentData' => $departmentsData['data'] ?? []
    ]);
}


    public function doctors(Request $request)
    {
        $token = session()->has('auth_token') ? session('auth_token') : null;
        $role=session('user.role'); 
        $page = $request->query('page', 1);
        $page = $request->query('page', 1);

        $token = session('auth_token'); // Get token from session
        if (!$token) {
            return redirect()->route('login')->withErrors(['message' => 'Session expired. Please log in again.']);
        }
        // Fetch from API
        $response = Http::withToken($token) // Use session token if stored during login
                ->get(env('API_BASE_URL') . '/api/v1/admin/doctors/search', [
                    'page' => $page,
        ]);

        $doctordata = $response->json();


        if (!$response->successful()) {
            return redirect()->back()->withErrors('Failed to fetch doctor data');
        }

        //dd($doctordata);

        $responseDepartments = Http::get(env('API_BASE_URL') . '/api/v1/departments');
        $departmentsData = $responseDepartments->json();

        return view('dashboard.doctors', [
             'doctors' => $doctordata['data'] ?? [],
            'pagination' => $doctordata['pagination'] ?? null,      
            'departmentData' => $departmentsData['data'] ?? []
        ]);
    }

    public function show()
    {
        $token = session('auth_token');       
              
<<<<<<< HEAD
        if(session('user.role') === "pharma") {
            $response = Http::withToken($token) 
                        ->get(env('API_BASE_URL') . '/api/v1/pharma/user/profile');
        }
        else {
            $response = Http::withToken($token) 
                        ->get(env('API_BASE_URL') . '/api/v1/user/profile');
        }
        
        $UserData = $response->json();  
        //dd($UserData);

        if(session('user.role') === "pharma") {
            return view('dashboard.pharmaUserProfile', [
                'userdata' => $UserData['data'] ?? [],
            ]);
        }
        else {
            return view('dashboard.userprofile', [
                'userdata' => $UserData['data'] ?? [],
            ]);    
        }
        
=======
        $response = Http::withToken($token) 
                        ->get(env('API_BASE_URL') . '/api/v1/user/profile');
        $UserData = $response->json();  
       // dd($UserData);

        return view('dashboard.userprofile', [
            'userdata' => $UserData['data'] ?? [],
        ]);
>>>>>>> 6b8595dc1c62273c0bff306bbd6788244a439795
    
    }

    public function edit()
    {
        $token = session('auth_token'); 
<<<<<<< HEAD
        if(session('user.role') === "pharma") {
            $response = Http::withToken($token) 
            ->get(env('API_BASE_URL') . '/api/v1/pharma/user/profile');
        }
        else {
            $response = Http::withToken($token) 
            ->get(env('API_BASE_URL') . '/api/v1/user/profile');
        }
        
        $userUpdateData = $response->json();    
        //dd($userUpdateData);
        if(session('user.role') === "pharma") {
            return view('dashboard.pharmaUserProfileupdate', [
                'userdata' => $userUpdateData['data'] ?? [],
            ]);
        }
        else {
            return view('dashboard.user_profileupdate', [
                'userdata' => $userUpdateData['data'] ?? [],
            ]);
        }
                       
=======
        $response = Http::withToken($token) 
            ->get(env('API_BASE_URL') . '/api/v1/user/profile');
        $userUpdateData = $response->json();    
        //dd($userUpdateData);
        return view('dashboard.user_profileupdate', [
                'userdata' => $userUpdateData['data'] ?? [],
        ]);               
>>>>>>> 6b8595dc1c62273c0bff306bbd6788244a439795
    }

    public function update(Request $request)
    {
        
        try {
            $validated = $request->validate([
                'id' => 'required|integer',
                'name' => 'required|string|max:255',
                'phone' => 'required|string',
                'email' => 'required|email',                
                'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            ]);

            $token = session('auth_token');
  
            $Id = $validated['id'];
            unset($validated['id']);

            if ($request->hasFile('profile_image')) {
                $image = $request->file('profile_image');

                if (!$image->isValid()) {
                    throw new \Exception('Uploaded image is not valid.');
                }

                $filename = time() . '_' . $image->getClientOriginalName();

            
                $destinationPath = public_path('images/users');
                
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }
                
                
                if (!empty($user->profile_image)) {
                    $oldImagePath = public_path(str_replace(url('/'), '', $user->profile_image));

                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                        \Log::info("Old doctor image deleted: " . $oldImagePath);
                    }
                }

            
                if (!$image->move($destinationPath, $filename)) {
                    throw new \Exception("File could not be moved to $destinationPath");
                }

            
                $validated['profile_image'] = url('images/users/' . $filename);
            }
<<<<<<< HEAD
            
            if(session('user.role') === "pharma") {
                $response = Http::withToken($token)
                ->put(env('API_BASE_URL') . "/api/v1/pharma/user/update", $validated);
            }
            else {
                $response = Http::withToken($token)
                ->put(env('API_BASE_URL') . "/api/v1/user/update", $validated);
            }
            
=======
            $response = Http::withToken($token)
                ->put(env('API_BASE_URL') . "/api/v1/user/update", $validated);
>>>>>>> 6b8595dc1c62273c0bff306bbd6788244a439795
            if ($response->successful()) {
                return redirect()->back()->with('success', 'User profile updated successfully.');
            } else {
                return redirect()->back()->withErrors('Failed to update User profile. API error.');
            }

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        } catch (\Exception $e) {
            \Log::error('Doctor Update Error: ' . $e->getMessage());
            return redirect()->back()->withErrors('Something went wrong while updating the profile. Please try again.');
        }
    }
}
