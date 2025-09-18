@extends('layouts.app')
@push('styles')
    <link href="{{ asset('css/insidestyles.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <style>
    .ui-autocomplete {
		z-index: 9999 !important; /* Ensures list is above modal backdrop */
	}
    </style>
@endpush

@section('content')
<div class="dashboard-wrapper">
    
</div>
<div class="container-fluid">
        <div class="row">
            @include('sidebar')
            <!-- Main Content -->
            <div class="col-md-10 main-content" id="mainContent">
                <!-- Appointments Cards -->
              <div class="content-header d-flex justify-content-between align-items-center mb-4">
                    <h4 class="mb-0"><i class="fas fa-user-injured me-2"></i>Appointments</h4>
                    <div class="action-buttons">
                        <button class="btn btn-primary me-2">
                            <i class="fas fa-plus me-1"></i>
                            <span data-bs-toggle="modal" id="addAppointmentBtn">Add Appointment</span>
                        </button>
                    </div>
                </div>
            
                <div id="alertBox"></div>
                <div class="dashboard-card">
                        <div class="table-responsive">
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
                                                <button class="btn btn-sm btn-outline-primary me-1 view-btn" data-appointment='@json($appointment)' data-bs-toggle="modal" data-bs-target="#appointmentModal">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                @if ($appointment['status'] === 'Scheduled')
                                                    <button class="btn btn-sm btn-outline-warning me-1 edit-btn edit-appointment" data-appointment='@json($appointment)'>
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                @endif
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
    

    <!-- Modal -->
    <div class="modal fade" id="appointmentModal" tabindex="-1" role="dialog" aria-labelledby="appointmentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="doctorModalLabel">Appointment Details</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <p><img id="modal-image" src="" width="750px" /></p>
            <p><strong>Patient ID:</strong> <span id="modal-patient-id"></span></p>
            <p><strong>Patient Name:</strong> <span id="modal-patient-name"></span></p>
            <p><strong>Doctor Id:</strong> <span id="modal-doctor-id"></span></p>
            <p><strong>Doctor Name:</strong> <span id="modal-doctor-name"></span></p>
            <p><strong>Doctor Consultation Fee:</strong> <span id="modal-doctor-fee"></span></p>
            <p><strong>Department:</strong> <span id="modal-department"></span></p>
            <p><strong>Appointment Date:</strong> <span id="modal-appointment-date"></span></p>
            <p><strong>Appointment Time:</strong> <span id="modal-appointment-time"></span></p>
            <p><strong>Appointment Status:</strong> <span id="modal-appointment-status"></span></p>
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
                        <i class="fas fa-calendar-plus me-2"></i>Schedule New Appointment
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="newAppointmentForm">
						@csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="appointmentPatient" class="form-label">Patient</label>
                                <input type="text" id="patientSearch" placeholder="Search Patient" autocomplete="off">
                                <input type="hidden" id="patient_id" name="patient_id">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="appointmentDepartment" class="form-label">Department</label>
                                <select class="form-select" id="appointmentDepartment" required="">
                                    <option value="">Select Department</option>
                                    {{-- <option value="cardiology">Cardiology</option>
                                    <option value="neurology">Neurology</option>
                                    <option value="pediatrics">Pediatrics</option>
                                    <option value="orthopedics">Orthopedics</option>
                                    <option value="dermatology">Dermatology</option>
                                    <option value="general">General Medicine</option> --}}
                                    @foreach($departmentData as $department)
                                    <option value="{{ $department['id'] }}">{{ $department['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="appointmentDoctor" class="form-label">Doctor</label>
                                <select class="form-select" id="doctor_id" name="doctor_id" required>
									<option value="">Select Doctor</option>
								</select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="appointmentDate2" class="form-label">Date</label>
                                <div id="datepicker"></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="appointmentTime2" class="form-label">Time</label>
                                <div id="time-slots"></div>
                            </div>
                        </div>
                        
                        <input type="hidden" name="appointment_date" id="appointmentDate">
						<input type="hidden" name="appointment_time" id="appointmentTime">
						<input type="hidden" id="appointment_id" name="appointment_id">

                        <div class="row">
                            
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
                        <div class="mb-3">
                            <label for="appointmentNotes" class="form-label">Notes/Reason for Visit</label>
                            <textarea class="form-control" id="appointmentNotes" name="appointment_notes" rows="3" placeholder="Brief description of the appointment purpose"></textarea>
                        </div>
                        {{--<div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="appointmentPriority" class="form-label">Priority</label>
                                <select class="form-select" id="appointmentPriority" name="appointment_priority">
                                    <option value="normal">Normal</option>
                                    <option value="urgent">Urgent</option>
                                    <option value="emergency">Emergency</option>
                                </select>
                            </div>
                        </div>--}}
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" form="newAppointmentForm" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>Schedule Appointment
                    </button>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('scripts')
const API_BASE_URL = "{{ config('services.api.base_url') }}";
const AUTH_TOKEN = localStorage.getItem('auth_token');
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<script src="{{ asset('js/appointmentscript.js') }}"></script>
@endpush
