@extends('layouts.app')
@push('styles')
    <link href="{{ asset('css/insidestyles.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">  
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">  
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
                    <i class="fas fa-user-injured me-2"></i>Doctors
                </h4>
                <div class="action-buttons">
                    <button class="btn btn-primary add-doctor-button" data-bs-toggle="modal" data-bs-target="#addDoctorModal">
                        <i class="fas fa-plus me-1"></i>
                        Add Doctor
                    </button>
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
                                   
                                    <td>{{ $doctor['doctor_id'] }}</td>
                                    <td>{{ $doctor['user']['name'] }}</td>
                                    <td>{{ $doctor['department']['name'] }}</td>
                                    <td>{{ $doctor['specialization'] }}</td>
                                    <td>{{ $doctor['experience'] }}</td>
                                    <td>{{ $doctor['consultation_fee'] }}</td>
                                    <td>
										<div class="d-flex flex-column flex-md-row gap-1">
                                            <button class="btn btn-sm btn-outline-primary view-btn" data-doctor='@json($doctor)'>
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-warning edit-btn" data-doctor='@json($doctor)'>
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
                <!-- Availability Table Below -->
                <p><strong>Availability</strong></p>
                <div id="modal-availability-grid"></div>
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
<!-- New Doctor Modal -->


<div class="modal fade" id="addDoctorModal" tabindex="-1" aria-labelledby="addDoctorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="addDoctorForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="addDoctorModalLabel">Add New Doctor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body row g-3">
                <!-- User Info -->
                
                <input type="hidden" id="id" name="id">

                <div class="col-md-6">
                    <label for="name" class="form-label">Doctor Name</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
          
                <div class="col-md-6">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email">
                  
                </div>
                
              
                       <div class="col-md-6" id="passwordLabel">
                        <label for="password" class="form-label">Password</label>
                        <input type="password"
                            class="form-control @error('password') is-invalid @enderror"
                            id="password"
                            name="password"
                           
                            minlength="6">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                </div>
            
                    <div class="col-md-6" id="conformpasswordLabel">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input type="password"
                            class="form-control @error('password_confirmation') is-invalid @enderror"
                            id="password_confirmation"
                            name="password_confirmation"
                            
                            minlength="6">
                        @error('password_confirmation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
               
                
                <div class="col-md-6">
                    <label for="phone" class="form-label">Phone</label>
                      <input type="text" class="form-control" id="phone" name="phone">
                </div>

                <!-- Doctor Info -->
                <div class="col-md-6">
                    <label for="specialization" class="form-label">Specialization</label>
                    <input type="text" class="form-control" id="specialization" name="specialization" required>
                </div>
                <div class="col-md-6">
                    <label for="experience" class="form-label">Experience (Years)</label>
                    <input type="text" class="form-control" id="experience" name="experience" required>
                </div>
                <div class="col-md-6">
                    <label for="consultation_fee" class="form-label">Consultation Fee</label>
                    <input type="number" class="form-control" id="consultation_fee" name="consultation_fee" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="appointmentDepartment" class="form-label">Department</label>
                    <select class="form-select" id="department_id" required>
                      <option value="">Select Department</option>
                      @foreach($departmentData as $department)
                        <option value="{{ $department['id'] }}">{{ $department['name'] }}</option>
                      @endforeach
                    </select>
                </div>

                <!-- Availability Slot -->
                <div id="availability-wrapper">
                    <div class="row availability-slot mb-3" id="slot-template">
                        <div class="col-md-6">
                            <label class="form-label">Day of Week</label>
                            <select class="form-control weekday-select" name="availability[0][days_of_week]" required>
                                <option value="">Select Day</option>
                                <option value="Monday">Monday</option>
                                <option value="Tuesday">Tuesday</option>
                                <option value="Wednesday">Wednesday</option>
                                <option value="Thursday">Thursday</option>
                                <option value="Friday">Friday</option>
                                <option value="Saturday">Saturday</option>
                                <option value="Sunday">Sunday</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Start Time</label>
                            <input type="time" class="form-control start-time" name="availability[0][start_time]" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">End Time</label>
                                <input type="time" class="form-control end-time" name="availability[0][end_time]" required>
                            </div>
                        </div>
                    </div>

                    <!-- Add Slot Button -->
                    <button type="button" class="btn btn-secondary" onclick="addAvailabilitySlot()">+ Add Slot</button>

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Add Doctor</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
@push('scripts')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>  
<script src="{{ asset('js/doctorscript.js') }}"></script>
<script>

    let slotIndex = 1;

    function addAvailabilitySlot(data = {}) {

            const template = $('#slot-template').html();
            const $slot = $(template);

            
        const wrapper = document.getElementById('availability-wrapper');
        const newSlot = document.createElement('div');
        newSlot.className = 'row availability-slot mb-3';


        newSlot.innerHTML = `
             <input type="hidden" name="availability[${slotIndex}][id]" class="id" value="${data.id || ''}" required>
            <div class="col-md-6">
                <label class="form-label">Day of Week</label>
                <select class="form-select" name="availability[${slotIndex}][days_of_week]" required>
                    <option value="">Select Day</option>
                    ${['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'].map(day => `
                        <option value="${day}" ${data.days_of_week === day ? 'selected' : ''}>${day}</option>
                    `).join('')}
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Start Time</label>
                <input type="time" class="form-control" name="availability[${slotIndex}][start_time]" value="${data.start_time || ''}" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">End Time</label>
                <div class="d-flex">
                    <input type="time" class="form-control me-2" name="availability[${slotIndex}][end_time]" value="${data.end_time || ''}" required>
                    <button type="button" class="btn btn-danger" onclick="removeSlot(this)">×</button>
                </div>
            </div>
        `;

        wrapper.appendChild(newSlot);
        slotIndex++;
    }

            function removeSlot(button) {
            const slot = button.closest('.availability-slot');
            if (slot) {
                slot.remove();
            }
            }
            </script>
           
<script>
    const password = document.getElementById('password');
    const confirm = document.getElementById('password_confirmation');

    confirm.addEventListener('input', function () {
        if (confirm.value !== password.value) {
            confirm.setCustomValidity("Passwords do not match");
        } else {
            confirm.setCustomValidity("");
        }
    });

  
</script>

@endpush
