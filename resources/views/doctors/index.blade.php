@extends('layouts.app')
@push('styles')
    <link href="{{ asset('css/insidestyles.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">    
@endpush

@section('content')
<div class="container-fluid p-0">
    <div class="row g-0">
        <div class="col-md-2">
            @include('sidebar')    
        </div>
        <div class="col-md-10 main-content px-3" id="mainContent">   
            <div class="content-header d-flex justify-content-between align-items-center mb-4">    
                <h4 class="mb-0 d-flex align-items-center" style="margin-left: 10px;">
                    <i class="fas fa-user-injured me-2"></i>Doctors
                </h4>
                <div class="action-buttons">
                    <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#searchDoctorModal">
                        <i class="fas fa-search me-1 text-white"></i>
                        <span id="searchDoctorBtn">Search</span>
                    </button>
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
                                <th class="text-center">S No</th>
                                <th class="text-center">Doctor ID</th>
                                <th class="text-center">Name</th>
                                <th class="text-center">Department</th>
                                <th class="text-center">Specialization</th>
                                <th class="text-center">Experience</th>
                                <th class="text-center">Consultation Fee</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($doctors as $doctor)
                                <tr>
                                    <td>{{ ($page - 1) * $perPage + $loop->iteration }}</td>
                                    <td>{{ $doctor['doctor_id'] }}</td>
                                    <td>{{ $doctor['user']['name'] }}</td>
                                    <td>{{ $doctor['department']['name'] }}</td>
                                    <td>{{ $doctor['specialization'] }}</td>
                                    <td>{{ $doctor['experience'] }}</td>
                                    <td>{{ $doctor['consultation_fee'] }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary me-1 view-btn" data-doctor='@json($doctor)' data-bs-toggle="modal" data-bs-target="#doctorModal">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <x-pagination :pagination="$pagination" />
                </div>
            </div>
        </div>
    </div>
</div>
    <!-- Modal -->
<div class="modal fade" id="doctorModal" tabindex="-1" role="dialog" aria-labelledby="doctorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="doctorModalLabel">
                    <i class="fas fa-user-md me-2"></i> Doctor Details
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">                        
                        <div class="col-md-5 text-center">
                            <img id="modal-image" src="" class="img-fluid rounded shadow-sm" alt="Doctor Image" style="max-height:250px;" />
                        </div>
                        <div class="col-md-7">
                            <div class="row mb-2">
                                <div class="col-4 fw-bold">Name:</div>
                                <div class="col-8" id="modal-name"></div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4 fw-bold">Doctor ID:</div>
                                <div class="col-8" id="modal-doctor-id"></div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4 fw-bold">Department:</div>
                                <div class="col-8" id="modal-department"></div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4 fw-bold">Specialization:</div>
                                <div class="col-8" id="modal-specialization"></div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4 fw-bold">Experience:</div>
                                <div class="col-8" id="modal-experience"></div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4 fw-bold">Consultation Fee:</div>
                                <div class="col-8" id="modal-consultaion-fee"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
                                            <!--- Search filter --->
<div class="modal fade" id="searchDoctorModal" tabindex="-1" aria-labelledby="searchDoctorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="searchDoctorModalLabel">
                    <i class="fa fa-search me-2"></i> Search Billing
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="GET" action="{{ route('doctors.index') }}">
                    <div class="mb-3">
                        <label>Doctor ID</label>
                        <input type="text" name="doctor_id" class="form-control" value="{{ $filters['doctor_id'] ?? '' }}">
                    </div>
                    <div class="mb-3">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" value="{{ $filters['name'] ?? '' }}">
                    </div>
                    <div class="mb-3">
                        <label>Department</label>
                        <input type="text" name="department" class="form-control" value="{{ $filters['department'] ?? '' }}">
                    </div>
                    <div class="mb-3">
                        <label>Specialization</label>
                        <input type="text" name="specialization" class="form-control" value="{{ $filters['specialization'] ?? '' }}">
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary me-2">Search</button>
                        <a href="{{ route('doctors.index') }}" class="btn btn-secondary">Reset</a>
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
<script src="{{ asset('js/doctorscript.js') }}"></script>
@endpush
