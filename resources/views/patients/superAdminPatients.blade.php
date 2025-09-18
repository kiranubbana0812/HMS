@extends('layouts.app')
@push('styles')
    <link href="{{ asset('css/insidestyles.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">    
@endpush

@section('content')
<div class="container-fluid p-0">
    <div class="row g-0">
        <div class="col-md-2">
            @include('superAdminSidebar')
        </div>            
        <div class="col-md-10 main-content px-3" id="mainContent">  
            
         <div class="content-header d-flex justify-content-between align-items-center mb-4"> 
                <h4 class="mb-0 d-flex align-items-center" style="margin-left: 10px;">
                    <i class="fas fa-user-injured me-2"></i>Patients
                </h4>
           
                <div class="action-buttons">
                    <button class="btn btn-primary me-2">
                        <i class="fas fa-plus me-1"></i>
                        <span data-bs-toggle="modal" id="addPatientBtn">Add Patient</span>
                    </button>
                    <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#searchPatientsModal">
                        <i class="fas fa-search me-1 text-white"></i>
                        <span id="searchPatientsBtn">Search</span>
                    </button>
                    {{-- <button class="btn btn-outline-primary">
                        <i class="fas fa-download me-1"></i>
                        <span onclick="exportPatients()">Export</span>
                    </button> --}}
                </div>
            </div>
            <div class="dashboard-card">
                <div class="table-responsive">
					{{-- Filters Summary --}}
					@if(request()->query())
						<div class="mb-3 p-3 border rounded bg-light">
							<h6 class="mb-2">Active Filters:</h6>
							<div class="d-flex flex-wrap align-items-center gap-2">
								@foreach(request()->query() as $key => $value)
									@if(!empty($value))
										<span class="badge bg-primary">
											{{ ucfirst(str_replace('_', ' ', $key)) }}: {{ $value }}
										</span>
									@endif
								@endforeach

								{{-- Clear All Filters --}}
								<a href="{{ url()->current() }}" class="btn btn-sm btn-outline-danger ms-2">
									Clear All Filters
								</a>
							</div>
						</div>
					@endif
                    <table class="table table-hover text-center w-100 m-0">
                        <thead>
                            <tr>
                                <th>S No</th>
                                <th>Patient ID</th>
                                <th>Name</th>
                                <th>Age</th>
                                <th>Gender</th>
                                <th>Phone</th>
                                <th>Blood Group</th>
                                <th>Address</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($patients as $patient)
                                <tr><td>{{ ($page - 1) * $perPage + $loop->iteration }}</td>
                                    <td>{{ $patient['patient_id'] }}</td>
                                    <td>{{ $patient['user']['name'] }}</td>
                                    <td>{{ $patient['date_of_birth'] ? \Carbon\Carbon::parse($patient['date_of_birth'])->age : 'N/A' }}</td>
                                    <td>{{ $patient['gender'] }}</td>
                                    <td>{{ $patient['phone'] }}</td>
                                    <td>{{ $patient['blood_type'] }}</td>
                                    <td>{{ $patient['address'] }}</td>
                                    <td>
                                        <div class="d-flex flex-column flex-md-row gap-1">
                                            <button class="btn btn-sm btn-outline-primary view-btn" data-patient='@json($patient)'>
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-warning edit-btn" data-patient='@json($patient)'>
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <x-pagination :pagination="$pagination" :filters="$filters" />
                </div>
            </div>
        </div>
    </div>
</div>    
<!-- Add/Edit Patient Modal -->
<div class="modal fade" id="patientFormModal" tabindex="-1" role="dialog" aria-labelledby="patientFormModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="patientForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="patientFormModalLabel">
                        <i class="fas fa-user-md me-2"></i> Add / Edit Patient
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="patient-id">
                    <div class="container-fluid">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" required>
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" class="form-control" id="phone" required>
                            </div>
                            <div class="col-md-6">
                                <label for="gender" class="form-label">Gender</label>
                                <select class="form-select" id="gender" required>
                                    <option value="">Choose...</option>
                                    <option>Male</option>
                                    <option>Female</option>
                                    <option>Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="date_of_birth" class="form-label">Date of Birth</label>
                                <input type="date" class="form-control" id="date_of_birth" required>
                            </div>
                            <div class="col-md-6">
                                <label for="blood_type" class="form-label">Blood Type</label>
                                <input type="text" class="form-control" id="blood_type">
                            </div>
                        </div>                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="address" class="form-label">Address</label>
                                <textarea class="form-control" id="address" rows="2"></textarea>
                            </div>
                            <div class="col-md-6">
                                <label for="alternatPhone" class="form-label">Alternate Phone</label>
                                <input type="tel" class="form-control" name="emergency_contact" id="alternatephone">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Save Patient
                        </button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>    
        </div>
    </div>
</div>
    <!-- Modal -->
    <div class="modal fade" id="patientModal" tabindex="-1" role="dialog" aria-labelledby="patientModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">            
                <div class="modal-header">
                    <h5 class="modal-title" id="patientModalLabel">
                        <i class="fas fa-user me-2"></i> Patient Details
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>                
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-md-4 fw-bold">Name:</div>
                            <div class="col-md-8" id="modal-name"></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4 fw-bold">Email:</div>
                            <div class="col-md-8" id="modal-email"></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4 fw-bold">Phone:</div>
                            <div class="col-md-8" id="modal-phone"></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4 fw-bold">Gender:</div>
                            <div class="col-md-8" id="modal-gender"></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4 fw-bold">Date of Birth:</div>
                            <div class="col-md-8" id="modal-dob"></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4 fw-bold">Age:</div>
                            <div class="col-md-8" id="modal-age"></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4 fw-bold">Address:</div>
                            <div class="col-md-8" id="modal-address"></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4 fw-bold">Blood Type:</div>
                            <div class="col-md-8" id="modal-blood"></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4 fw-bold">Alternate Contact:</div>
                            <div class="col-md-8" id="modal-emergency"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="searchPatientsModal" tabindex="-1" aria-labelledby="searchPatientsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="searchPatientsModalLabel">
                    <i class="fa fa-search me-2"></i> Search Patient
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="GET" action="{{ route('patients.index') }}">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Patient ID</label>
                            <input type="text" name="patient_id" class="form-control" value="{{ $filters['patient_id'] ?? '' }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Name</label>
                            <input type="text" name="patient_name" class="form-control" value="{{ $filters['patient_name'] ?? '' }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Phone</label>
                            <input type="text" name="phone" class="form-control" value="{{ $filters['phone'] ?? '' }}">
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary me-2">Search</button>
                        <a href="{{ route('patients.index') }}" class="btn btn-secondary">Reset</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
const API_BASE_URL = "{{ config('services.api.base_url') }}";
const AUTH_TOKEN = localStorage.getItem('auth_token');
</script>
<script src="{{ asset('js/script.js') }}"></script>
@endpush
