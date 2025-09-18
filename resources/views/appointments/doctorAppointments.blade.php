@extends('layouts.app')
@push('styles')
    <link href="{{ asset('css/insidestyles.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">   
@endpush

@section('content')
<div class="container-fluid p-0">
    <div class="row g-0">
        <div class="col-md-2">
            @switch(session('user.role'))
				@case('doctor')
					@include('doctorSidebar')
					@break

				{{-- @case('frontdesk')
					@include('frontdeskSidebar')
					@break --}}

				@default
					@include('sidebar')
			@endswitch
        </div>
        <div class="col-md-10 main-content px-3" id="mainContent">          
            <div class="row mb-4">
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="dashboard-card">
                        <div class="card-content">
                            <div class="card-info">
                                <h6 class="card-title">Today's Appointments szdsadsadsada</h6>
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
                    <i class="fas fa-user-injured me-2"></i>Appointments 123456
                </h4>
            </div>
            <div id="alertBox"></div>
                <div class="dashboard-card">
                    <div class="table-responsive">
                        <table class="appointmentsTable table table-hover">
                            <thead>
                                <tr>
                                    <th>S No</th>
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
                                        <td>{{ ($page - 1) * $perPage + $loop->iteration }}</td>
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
                    </div>
                </div>
            </div>
            {{-- Pagination --}}
            @if(isset($pagination) && isset($pagination['total']) && $pagination['total'] > $pagination['per_page'])
                <nav>
                    <ul class="pagination">
                        @for ($i = 1; $i <= $pagination['last_page']; $i++)
                            <li class="page-item {{ $pagination['current_page'] == $i ? 'active' : '' }}">
                                <a class="page-link" href="{{ url()->current() }}?page={{ $i }}">{{ $i }}</a>
                            </li>
                        @endfor
                    </ul>
                </nav>
            @endif
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
                        <div class="row mb-2">
                            <div class="col-md-4 fw-bold">Notes:</div>
                            <div class="col-md-8" id="modal-appointment-notes"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Edit Appointment By Doctor -->
    <div class="modal fade" id="editAppointmentModalLabel" tabindex="-1" role="dialog" aria-labelledby="appointmentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="appointmentModalLabel">
                        <i class="fas fa-calendar-check me-2"></i> Appointment Edit
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body"> 
					<form id="updateAppointmentForm">
						@csrf  
						<input type="hidden" name="appointment_id" id="modal-appointment-id-val" />                 
						<div class="container-fluid">
							<div class="row mb-2">
								<div class="col-md-4 fw-bold">Patient ID:</div>
								<div class="col-md-8" id="modal-edit-patient-id"></div>
								<input type="hidden" name="patient_id" id="modal-patient-id-val" />
							</div>
							<div class="row mb-2">
								<div class="col-md-4 fw-bold">Patient Name:</div>
								<div class="col-md-8" id="modal-edit-patient-name"></div>
							</div>
							<div class="row mb-2">
								<div class="col-md-4 fw-bold">Doctor ID:</div>
								<div class="col-md-8" id="modal-edit-doctor-id"></div>
								<input type="hidden" name="doctor_id" id="modal-doctor-id-val" />
							</div>
							<div class="row mb-2">
								<div class="col-md-4 fw-bold">Doctor Name:</div>
								<div class="col-md-8" id="modal-edit-doctor-name"></div>
							</div>
							<div class="row mb-2">
								<div class="col-md-4 fw-bold">Consultation Fee:</div>
								<div class="col-md-8" id="modal-edit-doctor-fee"></div>
							</div>
							<div class="row mb-2">
								<div class="col-md-4 fw-bold">Department:</div>
								<div class="col-md-8" id="modal-edit-department"></div>
							</div>
							<div class="row mb-2">
								<div class="col-md-4 fw-bold">Appointment Date:</div>
								<div class="col-md-8" id="modal-edit-appointment-date"></div>
								<input type="hidden" name="appointment_date" id="modal-appointment-date-val" />
							</div>
							<div class="row mb-2">
								<div class="col-md-4 fw-bold">Appointment Time:</div>
								<div class="col-md-8" id="modal-edit-appointment-time"></div>
								<input type="hidden" name="appointment_time" id="modal-appointment-time-val" />
							</div>
							<div class="row mb-2">
								<div class="col-md-4 fw-bold">Appointment Type:</div>
								<div class="col-md-8" id="modal-edit-appointment-type"></div>
							</div>
							<div class="row mb-2">
								<div class="col-md-4 fw-bold">Status:</div>
									<select class="form-select" id="modal-appointment-status-val" name="status" required>
										<option value="Scheduled">Scheduled</option>
										<option value="Completed">Completed</option>
										<option value="Cancelled">Cancelled</option>                        
									</select>
							</div>
							<div class="row mb-2">
								<div class="col-md-4 fw-bold">Notes:</div>
								<div class="col-md-8" id="modal-edit-appointment-notes">
									<textarea class="form-control" id="appointmentNotes" name="notes" rows="3" placeholder="Brief description of the appointment purpose"></textarea>
								</div>
							</div>
						</div>
					</form>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
						<button type="submit" form="updateAppointmentForm" class="btn btn-primary">
							<i class="fas fa-save me-1"></i>Update Appointment
						</button>
					</div>
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
<script src="{{ asset('js/doctorAppointmentscript.js') }}"></script>
@endpush
