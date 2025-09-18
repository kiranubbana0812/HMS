@extends('layouts.app')
@push('styles')
    <link href="{{ asset('css/insidestyles.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
@endpush
@section('content')

<div class="container-fluid">
        <div class="row">
            @include('sidebar')
            <!-- Main Content -->
            <div class="col-md-10 main-content" id="mainContent">
                <div class="content-header d-flex justify-content-between align-items-center mb-4">
                    <h4 class="mb-0"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</h4>
                    <div class="action-buttons">
                        <button class="btn btn-primary me-2">
                            <i class="fas fa-plus me-1"></i>
                            patientsRegister
                        </button>
                        <button class="btn btn-primary">
                            <i class="fas fa-plus me-1"></i>
                            Add Appointments
                        </button>
                    </div>
                </div>

                <!-- Dashboard Cards -->
                <div class="row">
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="dashboard-card">
                            <div class="card-content">
                                <div class="card-info">
                                    <h6 class="card-title">Doctors on board</h6>
                                    <h2 class="card-number">
                                        @if(isset($data))
                                            {{ $data['doctors_count'] ?? 0 }}
                                        @endif
                                    </h2>
                                    <p class="card-subtitle">On duty</p>
                                </div>
                                <div class="card-icon orange-icon">
                                    <i class="fas fa-user-md"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="dashboard-card">
                            <div class="card-content">
                                <div class="card-info">
                                    <h6 class="card-title">Patients in hospital</h6>
                                    <h2 class="card-number">
                                        @if(isset($data))
                                            {{ $data['patients_count'] ?? 0 }}
                                        @endif
                                    </h2>
                                    <p class="card-subtitle">In hospital</p>
                                </div>
                                <div class="card-icon pink-icon">
                                    <i class="fas fa-bed"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- <div class="col-lg-3 col-md-6 mb-4">
                        <div class="dashboard-card">
                            <div class="card-content">
                                <div class="card-info">
                                    <h6 class="card-title">Reports</h6>
                                    <h2 class="card-number">45</h2>
                                    <p class="card-subtitle">Patients Reports</p>
                                </div>
                                <div class="card-icon green-icon">
                                    <i class="fas fa-chart-line"></i>
                                </div>
                            </div>
                        </div>
                    </div> --}}

                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="dashboard-card">
                            <div class="card-content">
                                <div class="card-info">
                                    <h6 class="card-title">Billing</h6>
                                    <h2 class="card-number">₹
                                        @if(isset($data))
                                            {{ $data['appointments_doctors_total_fees'] ?? 0 }}
                                        @endif
                                    </h2>
                                    <p class="card-subtitle">Total Amount</p>
                                </div>
                                <div class="card-icon green-money-icon">
                                    <i class="fas fa-money-bill-wave"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="dashboard-card">
                            <div class="card-content">
                                <div class="card-info">
                                    <h6 class="card-title">Appointments</h6>
                                    <h2 class="card-number">
                                        @if(isset($data))
                                            {{ $data['appointments_count'] ?? 0 }}
                                        @endif
                                    </h2>
                                    <p class="card-subtitle">Appointments</p>
                                </div>
                                <div class="card-icon purple-icon">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Register Modal -->
    <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="registerModalLabel">
                        <i class="fas fa-user-plus me-2"></i>Register New Patient
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="registerForm">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="firstName" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="firstName" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="lastName" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="lastName" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="tel" class="form-control" id="phone" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="age" class="form-label">Age</label>
                                <input type="number" class="form-control" id="age" min="1" max="120" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="gender" class="form-label">Gender</label>
                                <select class="form-select" id="gender" required>
                                    <option value="">Select Gender</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="bloodGroup" class="form-label">Blood Group</label>
                                <select class="form-select" id="bloodGroup">
                                    <option value="">Select Blood Group</option>
                                    <option value="A+">A+</option>
                                    <option value="A-">A-</option>
                                    <option value="B+">B+</option>
                                    <option value="B-">B-</option>
                                    <option value="AB+">AB+</option>
                                    <option value="AB-">AB-</option>
                                    <option value="O+">O+</option>
                                    <option value="O-">O-</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <textarea class="form-control" id="address" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="medicalHistory" class="form-label">Medical History</label>
                            <textarea class="form-control" id="medicalHistory" rows="3" placeholder="Any existing conditions, allergies, or medications"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" form="registerForm" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>Register Patient
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Appointment Modal -->
    <div class="modal fade" id="addAppointmentModal" tabindex="-1" aria-labelledby="addAppointmentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addAppointmentModalLabel">
                        <i class="fas fa-calendar-plus me-2"></i>Add New Appointment
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addAppointmentForm">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="patientSelect" class="form-label">Patient</label>
                                <select class="form-select" id="patientSelect" required>
                                    <option value="">Select Patient</option>
                                    <option value="1">John Doe</option>
                                    <option value="2">Jane Smith</option>
                                    <option value="3">Mike Johnson</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="doctorSelect" class="form-label">Doctor</label>
                                <select class="form-select" id="doctorSelect" required>
                                    <option value="">Select Doctor</option>
                                    <option value="1">Dr. Sarah Smith - Cardiologist</option>
                                    <option value="2">Dr. Michael Johnson - Neurologist</option>
                                    <option value="3">Dr. Emily Brown - Pediatrician</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="appointmentDate" class="form-label">Date</label>
                                <input type="date" class="form-control" id="appointmentDate" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="appointmentTime" class="form-label">Time</label>
                                <input type="time" class="form-control" id="appointmentTime" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="department" class="form-label">Department</label>
                            <select class="form-select" id="department" required>
                                <option value="">Select Department</option>
                                <option value="cardiology">Cardiology</option>
                                <option value="neurology">Neurology</option>
                                <option value="pediatrics">Pediatrics</option>
                                <option value="orthopedics">Orthopedics</option>
                                <option value="dermatology">Dermatology</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="appointmentReason" class="form-label">Reason for Visit</label>
                            <textarea class="form-control" id="appointmentReason" rows="3" placeholder="Brief description of the appointment purpose"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="priority" class="form-label">Priority</label>
                                <select class="form-select" id="priority">
                                    <option value="normal">Normal</option>
                                    <option value="urgent">Urgent</option>
                                    <option value="emergency">Emergency</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="duration" class="form-label">Duration (minutes)</label>
                                <select class="form-select" id="duration">
                                    <option value="30">30 minutes</option>
                                    <option value="45">45 minutes</option>
                                    <option value="60">1 hour</option>
                                    <option value="90">1.5 hours</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" form="addAppointmentForm" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>Schedule Appointment
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
<script>
    const API_BASE_URL = "{{ config('services.api.base_url') }}";
    const LOGOUT_ROUTE = "{{ route('logout') }}";
    const CSRF_TOKEN = "{{ csrf_token() }}";
</script>
<script src="{{ asset('js/logout.js') }}"></script>
@endpush