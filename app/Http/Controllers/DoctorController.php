<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DoctorController extends Controller
{
    public function __construct()
    {
        if (!session()->has('user')) {
            return redirect('/login')->withErrors(['message' => 'Unauthorized. Please login.']);
        }   
    }
    public function index(Request $request)
    {
        $page = $request->query('page', 1);

        $token = session('auth_token'); // Get token from session
        if (!$token) {
            return redirect()->route('login')->withErrors(['message' => 'Session expired. Please log in again.']);
        }
        // Collect all filters from request
		$queryParams = $request->query();
		$queryParams['page'] = $page; // Always set page

		$response = Http::withToken($token)
		    ->get(env('API_BASE_URL') . '/api/v1/admin/doctors/search', $queryParams);

        $doctorsData = $response->json();

        //dd($doctorsData);
        //\Log::info('API Response: ' . print_r($doctorsData));

        $responseDepartments = Http::get(env('API_BASE_URL') . '/api/v1/departments');
        $departmentsData = $responseDepartments->json();
         
        // Collect filters from request
        $queryParams = $request->query();
        $queryParams['page'] = $page;

        if (!$response->successful()) {
            return redirect()->back()->withErrors('Failed to fetch doctor data');
        }

        if(session('user.role') === "superadmin") {
			return view('doctors.superadminDoctors', [
				'doctors' => $doctorsData['data'] ?? [],
				'pagination' => $doctorsData['pagination'] ?? null,
				'filters' => $queryParams,
				'departmentData' => $departmentsData['data'] ?? []
			]);
		}
		else {
			return view('doctors.index', [
				'doctors' => $doctorsData['data'] ?? [],
				'pagination' => $doctorsData['pagination'] ?? null,
				'filters' => $queryParams,
				'departmentData' => $departmentsData['data'] ?? []
			]);
		}
    }
    
    public function dashboard()
    {
		$token = session('auth_token'); // Get token from session
        
        if (!$token) {
            return redirect()->route('login')->withErrors(['message' => 'Session expired. Please log in again.']);
        }

        $responseTodaysCount = Http::withToken($token) // Use session token if stored during login
            ->get(env('API_BASE_URL') . '/api/v1/admin/appointments/doctorStats');
        
		$allCount = $responseTodaysCount->json();
		
		return view('doctors.doctor_info', [           
            'allCount' => $allCount['data'] ?? [],          
        ]);
	}

    public function show()
    {
        $token = session('auth_token'); 
		$response = Http::withToken($token) 
                    ->get(env('API_BASE_URL') . '/api/v1/doctor/profile');

        $doctorsData = $response->json();  
        
        //dd($doctorsData);  

        return view('doctors.doctor_profile', [
			'doctordata' => $doctorsData['data'] ?? [],
        ]);            
	}
    
    public function edit()
    {
		$token = session('auth_token'); 
		$response = Http::withToken($token) 
			->get(env('API_BASE_URL') . '/api/v1/doctor/profile');
		$doctorsUpdateData = $response->json();    
		//dd($doctorsUpdateData['data']);
        return view('doctors.doctor_profileupdate', [
				'doctorupdatedata' => $doctorsUpdateData['data'] ?? [],
		]);               
	}


	/*public function update(Request $request)
    {
		//dd($request->profile_image);
        $validated = $request->validate([
			'id' => 'required|integer',
            'name' => 'required|string|max:255',
            'phone' => 'required|string',
            'email' => 'required|email',
            'specialization' => 'nullable|string',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',              
		]);
		
		$token = session('auth_token');
		$doctorId = $validated['id'];
        
        unset($validated['id']);
		
		$multipart = [];
		
		foreach ($validated as $key => $value) {
			$multipart[] = [
				'name' => $key,
                'contents' => $value,
			];
        }
		
		if ($request->hasFile('profile_image')) {
			$multipart[] = [
				'name'     => 'image',
                'contents' => fopen($request->file('profile_image')->getPathname(), 'r'),
                'profile_image' => $request->file('profile_image')->getClientOriginalName(),
			];
		}

        //dd($multipart); 
          
        $response = Http::withToken($token)
			->put(env('API_BASE_URL') . "/api/v1/doctor/update", $validated);

		$doctorsUpdateData1 = $response->json();
		//Log::info('API Response: ' . print_r($doctorsUpdateData1, true));

		if ($response->successful()) {
			return redirect()->back()->with('success', 'Doctor profile updated successfully.');
		} else {
			return redirect()->back()->withErrors('Failed to update doctor profile.');
		}
	}*/
	
	public function update(Request $request)
	{
		try {
			$validated = $request->validate([
				'id' => 'required|integer',
				'name' => 'required|string|max:255',
				'phone' => 'required|string',
				'email' => 'required|email',
				'specialization' => 'nullable|string',
				'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
			]);

			$token = session('auth_token');
			$doctorId = $validated['id'];
			unset($validated['id']);

			if ($request->hasFile('profile_image')) {
				$image = $request->file('profile_image');

				if (!$image->isValid()) {
					throw new \Exception('Uploaded image is not valid.');
				}

				$filename = time() . '_' . $image->getClientOriginalName();

				// ✅ Save inside Laravel public/images/doctors/
				$destinationPath = public_path('images/doctors');
				
				if (!file_exists($destinationPath)) {
					mkdir($destinationPath, 0777, true);
				}
				
				// ✅ Remove old image if exists
				if (!empty($user->profile_image)) {
					$oldImagePath = public_path(str_replace(url('/'), '', $user->profile_image));

					if (file_exists($oldImagePath)) {
						unlink($oldImagePath);
						\Log::info("Old doctor image deleted: " . $oldImagePath);
					}
				}

				//$moved = $image->move($destinationPath, $filename);
				if (!$image->move($destinationPath, $filename)) {
					throw new \Exception("File could not be moved to $destinationPath");
				}

				// ✅ Store full URL to send in API
				$validated['profile_image'] = url('images/doctors/' . $filename);
			}
			
			// Send update request to API
			$response = Http::withToken($token)
				->put(env('API_BASE_URL') . "/api/v1/doctor/update", $validated);

			if ($response->successful()) {
				return redirect()->back()->with('success', 'Doctor profile updated successfully.');
			} else {
				return redirect()->back()->withErrors('Failed to update doctor profile. API error.');
			}

		} catch (\Illuminate\Validation\ValidationException $e) {
			return redirect()->back()->withErrors($e->validator->errors())->withInput();
		} catch (\Exception $e) {
			\Log::error('Doctor Update Error: ' . $e->getMessage());
			return redirect()->back()->withErrors('Something went wrong while updating the profile. Please try again.');
		}
	}
}
