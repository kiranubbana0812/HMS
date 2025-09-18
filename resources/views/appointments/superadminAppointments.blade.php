@extends('layouts.app')
@push('styles')
    <link href="{{ asset('css/insidestyles.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">   
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <style>
        .card-icon {
            font-size: 1.8rem;
            margin: 0;          /* reset spacing */
            padding: 0; 
        }

        .card-title {
            font-size: 1rem;
            font-weight: bold;
        }

        .card-number {
            font-size: 1.6rem;
            margin: 0;
            text-align: left; /* stays left below */
        }

        /* Fit calendar in Bootstrap form nicely */
        #datepicker {
            width: 100%;
            border: none; /* remove duplicate borders */
        }

        /* Available slots */
        .available-date a {
            background-color: #28a745 !important;
            color: #fff !important;
            border-radius: 50% !important;
        }

        /* Unavailable slots */
        .unavailable-date a {
            background-color: #e9ecef !important;
            color: #6c757d !important;
            pointer-events: none;
            border-radius: 50% !important;
        }
    </style>
@endpush

@section('content')
<div class="container-fluid p-0">
    <div class="row g-0">
        <div class="col-md-2">
			@include('superAdminSidebar')
        </div>
        <div class="col-md-10 main-content px-3" id="mainContent">          
            <div class="row mb-4">
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="dashboard-card">
                        <div class="card-content">
                            <div class="card-info">
                                <h6 class="card-title">Today's Appointments</h6>
                                <h2 class="card-number">{{ $todaysCount['total'] }}</h2>
                                <p class="card-subtitle">Scheduled</p>
                            </div>
                            <div class="card-icon purple-icon">
                                <i class="fas fa-calendar-day"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="dashboard-card">
                        <div class="card-content">
                            <div class="card-info">
                                <h6 class="card-title">Completed</h6>
                                <h2 class="card-number">{{ $todaysCount['completed'] }}</h2>
                                <p class="card-subtitle">Today</p>
                            </div>
                            <div class="card-icon green-icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="dashboard-card">
                        <div class="card-content">
                            <div class="card-info">
                                <h6 class="card-title">Cancelled</h6>
                                <h2 class="card-number">{{ $todaysCount['cancelled'] }}</h2>
                                <p class="card-subtitle">Today</p>
                            </div>
                            <div class="card-icon pink-icon">
                                <i class="fas fa-times-circle"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-header d-flex justify-content-between align-items-center mb-4">
                <h4 class="mb-0 d-flex align-items-center" style="margin-left: 10px;">
                    <i class="fas fa-user-injured me-2"></i>Appointments
                </h4>
                <div class="action-buttons">
                    <button class="btn btn-primary me-2">
                        <i class="fas fa-plus me-1"></i>
                        <span data-bs-toggle="modal" id="addAppointmentBtn">Add Appointment</span>
                    </button>
                    <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#searchAppointmentModal">
                        <i class="fas fa-search me-1 text-white"></i>
                        <span id="searchAppointmentBtn">Search</span>
                    </button>
                </div>
            </div>
            <div id="alertBox"></div>
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
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Patient ID</th>
                                    <th>Patient Name</th>
                                    <th>Doctor ID</th>
                                    <th>Doctor Name</th>
                                    <th>Department</th>
                                    <th>Appointment Date</th>
                                    <th>Appointment Time</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($appointments as $appointment)
                                    <tr>
                                        <td>{{ $appointment['patient']['patient_id'] }}</td>
                                        <td>{{ $appointment['patient']['user']['name'] }}</td>
                                        <td>{{ $appointment['doctor']['doctor_id'] }}</td>
                                        <td>{{ $appointment['doctor']['user']['name'] }}</td>
                                        <td>{{ $appointment['doctor']['department']['name'] }}</td>
                                        <td>{{ $appointment['appointment_date'] }}</td>
                                        <td>{{ $appointment['appointment_time'] }}</td>
                                        <td>{{ $appointment['status'] }}</td>
                                        <td>
                                            <div class="d-flex flex-column flex-md-row gap-1">
                                                <button class="btn btn-sm btn-outline-primary view-btn" 
                                                        data-appointment='@json($appointment)' 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#appointmentModal">
                                                    <i class="fas fa-eye"></i>
                                                </button>

                                                @if ($appointment['status'] === 'Scheduled')
                                                    <button class="btn btn-sm btn-outline-warning edit-btn edit-appointment" 
                                                            data-appointment='@json($appointment)'>
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                @endif
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
    <!-- Appointment Details -->
    <div class="modal fade" id="appointmentModal" tabindex="-1" role="dialog" aria-labelledby="appointmentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="appointmentModalLabel">
                        <i class="fas fa-calendar-check me-2"></i> Appointment Details
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">                    
                    <div class="text-center mb-3">
                        <img id="modal-image" src="" class="img-fluid rounded shadow-sm d-none" alt="Patient/Doctor Image" />
                    </div>
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-md-4 fw-bold">Patient ID:</div>
                            <div class="col-md-8" id="modal-patient-id"></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4 fw-bold">Patient Name:</div>
                            <div class="col-md-8" id="modal-patient-name"></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4 fw-bold">Doctor ID:</div>
                            <div class="col-md-8" id="modal-doctor-id"></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4 fw-bold">Doctor Name:</div>
                            <div class="col-md-8" id="modal-doctor-name"></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4 fw-bold">Consultation Fee:</div>
                            <div class="col-md-8" id="modal-doctor-fee"></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4 fw-bold">Department:</div>
                            <div class="col-md-8" id="modal-department"></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4 fw-bold">Appointment Date:</div>
                            <div class="col-md-8" id="modal-appointment-date"></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4 fw-bold">Appointment Time:</div>
                            <div class="col-md-8" id="modal-appointment-time"></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4 fw-bold">Status:</div>
                            <div class="col-md-8" id="modal-appointment-status"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- New Appointment Modal -->
    <div class="modal fade" id="newAppointmentModal" tabindex="-1" aria-labelledby="newAppointmentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                
                <div class="modal-header">
                    <h5 class="modal-title" id="newAppointmentModalLabel">
                        <i class="fas fa-calendar-plus me-2"></i> Schedule New Appointment
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form id="newAppointmentForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="patientSearch" class="form-label">Patient</label>
                                <input type="text" id="patientSearch" class="form-control" placeholder="Search Patient" autocomplete="off">
                                <input type="hidden" id="patient_id" name="patient_id">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="appointmentDepartment" class="form-label">Department</label>
                                <select class="form-select" id="appointmentDepartment" required>
                                    <option value="">Select Department</option>
                                    @foreach($departmentData as $department)
                                        <option value="{{ $department['id'] }}">{{ $department['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>                    
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="doctor_id" class="form-label">Doctor</label>
                                <select class="form-select" id="doctor_id" name="doctor_id" required>
                                    <option value="">Select Doctor</option>
                                </select>

                                <!-- Availability placeholder (shown later via JS) -->
                                <div id="doctorAvailability" class="mt-2 d-none">
                                    <div class="alert alert-info p-2 mb-0">
                                        <small><i class="fas fa-info-circle me-1"></i>
                                        Please select a date to view availability.</small>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Date</label>
                                <div id="datepicker"></div>
                                <input type="hidden" name="appointment_date" id="appointmentDate">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Time</label>
                                <div id="time-slots"></div>
                                <input type="hidden" name="appointment_time" id="appointmentTime">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="appointmentType" class="form-label">Appointment Type</label>
                                <select class="form-select" id="appointmentType" name="appointment_type" required>
                                    <option value="">Select Type</option>
                                    <option value="Consultation">Consultation</option>
                                    <option value="Follow-up">Follow-up</option>
                                    <option value="Regular Checkup">Regular Checkup</option>
                                    <option value="Emergency">Emergency</option>
                                </select>
                            </div>
                        </div>                    
                        {{--<div class="mb-3">
                            <label for="appointmentNotes" class="form-label">Notes / Reason for Visit</label>
                            <textarea class="form-control" id="appointmentNotes" name="appointment_notes" rows="3" placeholder="Brief description of the appointment purpose"></textarea>
                        </div>--}}              
                        <input type="hidden" id="appointment_id" name="appointment_id">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" form="newAppointmentForm" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Schedule Appointment
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>                    
                </div>
            </div>
        </div>
    </div>
	                                            <!-- Search Appointment Modal -->
	<div class="modal fade" id="searchAppointmentModal" tabindex="-1" aria-labelledby="searchAppointmentModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="searchAppointmentModalLabel">
						<i class="fa fa-search me-2"></i> Search Appointment
					</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<form method="GET" action="{{ route('superadmin.appointments') }}">
						<div class="row">
							<div class="col-md-6 mb-3">
								<label>Patient ID</label>
								<input type="text" name="patient_id" class="form-control" value="{{ $filters['patient_id'] ?? '' }}">
							</div>
							<div class="col-md-6 mb-3">
								<label>Patient Name</label>
								<input type="text" name="patient_name" class="form-control" value="{{ $filters['patient_name'] ?? '' }}">
							</div>
							<div class="col-md-6 mb-3">
								<label>Doctor ID</label>
								<input type="text" name="doctor_id" class="form-control" value="{{ $filters['doctor_id'] ?? '' }}">
							</div>
							<div class="col-md-6 mb-3">
								<label>Doctor Name</label>
								<input type="text" name="doctor_name" class="form-control" value="{{ $filters['doctor_name'] ?? '' }}">
							</div>
							<div class="col-md-6 mb-3">
								<label>Department</label>
								<input type="text" name="department" class="form-control" value="{{ $filters['department'] ?? '' }}">
							</div>
							<div class="col-md-3 mb-3">
								<label>From Date</label>
								<input type="date" name="from_date" class="form-control" value="{{ $filters['from_date'] ?? '' }}">
							</div>
							<div class="col-md-3 mb-3">
								<label>To Date</label>
								<input type="date" name="to_date" class="form-control" value="{{ $filters['to_date'] ?? '' }}">
							</div>
						</div>
						<div class="text-center">
							<button type="submit" class="btn btn-primary me-2">Search</button>
							<a href="{{ route('superadmin.appointments') }}" class="btn btn-secondary">Reset</a>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<script src="{{ asset('js/appointmentscript.js') }}"></script>
@endpush
