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
                    <h4 class="mb-0"><i class="fas fa-user-injured me-2"></i>Doctors</h4>
                    <div class="action-buttons">
                         <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#addDoctorModal">
                        <i class="fas fa-plus me-1"></i>
                        Add Doctor
                    </button>
                    </div>
                </div>
            
                <div id="alertBox"></div>
                <div class="dashboard-card">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Doctor ID</th>                            
                                        <th>Doctor Name</th>
                                        <th>Department</th>
                                        <th>experience</th>
                                        <th>consultation_fee</th>
                                        <th>availability</th>
                                        <th>status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>

                                      @php 
                                     //dd($doctors);
                                      @endphp
                                       @foreach($doctors as $doctor)
                                      
                                        <tr>

                                         <td>{{ $doctor['doctor_id'] }}</td>                                          
                                         <td>{{ $doctor['user']['name'] }}</td>
                                         <td>{{ $doctor['department']['name'] }}</td>
                                         <td>{{ $doctor['experience'] }}</td>
                                         <td>{{ $doctor['consultation_fee'] }}</td>
                                         <td>{{ $doctor['availability'] }}</td>
                                        <td>{{ $doctor['user']['status'] }}</td>
                                        
                                           
                                            <td>
                                                  <button class="btn btn-sm btn-outline-primary me-1 view-btn" data-doctor='@json($doctor)' data-bs-toggle="modal" data-bs-target="#doctorModal">
                                                    <i class="fas fa-eye"></i>
                                                </button>

                                                         @if ($doctor['user']['status'] === 'active')
                                                          <button class="btn btn-sm btn-outline-warning me-1 edit-btn edit-doctor" data-doctor='@json($doctor)'>
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
    


    <div class="modal fade" id="doctorModal" tabindex="-1" role="dialog" aria-labelledby="doctorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="doctorModalLabel">Doctor Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><img id="modal-image" src="" width="750px" /></p>
                <p><strong>Doctor ID:</strong> <span id="modal-doctor-id"></span></p>
                <p><strong>Doctor Name:</strong> <span id="modal-doctor-name"></span></p>
                <p><strong>Department:</strong> <span id="modal-department"></span></p>
                <p><strong>Experience:</strong> <span id="modal-experience"></span></p>
                <p><strong>Consultation Fee:</strong> <span id="modal-consultation-fee"></span></p>
                <p><strong>Availability</strong></p>
                <div id="modal-availability-grid"></div> <!-- Grid for availability -->
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
          <div class="col-md-6">
            <label for="name" class="form-label">Doctor Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
          </div>
          <div class="col-md-6">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
          </div>
          <div class="col-md-6">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
          </div>
          <div class="col-md-6">
            <label for="password_confirmation" class="form-label">Confirm Password</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
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
                                <select class="form-select" id="department_id" required="">
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
         
                        <!-- Availability Slot -->
                        <div id="availability-wrapper">
                <div class="row availability-slot mb-3">
                  <div class="col-md-6">
                    <label class="form-label">Day of Week</label>
                    <select class="form-select" name="availability[0][days_of_week]" required>
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
                    <input type="time" class="form-control" name="availability[0][start_time]" required>
                  </div>
                  <div class="col-md-3">
                    <label class="form-label">End Time</label>
                    <input type="time" class="form-control" name="availability[0][end_time]" required>
                  </div>
                </div>
              </div>

<!-- Add Slot Button -->
<button type="button" class="btn btn-secondary" onclick="addAvailabilitySlot()">+ Add Slot</button>


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
const API_BASE_URL = "{{ config('services.api.base_url') }}";
const AUTH_TOKEN = localStorage.getItem('auth_token');
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<script src="{{ asset('js/doctorscript.js') }}"></script>
<script>

let slotIndex = 1; // starts at 1 since 0 is already in the DOM

function addAvailabilitySlot() {
  const wrapper = document.getElementById('availability-wrapper');

  const newSlot = document.createElement('div');
  newSlot.className = 'row availability-slot mb-3';

  newSlot.innerHTML = `
    <div class="col-md-6">
      <label class="form-label">Day of Week</label>
      <select class="form-select" name="availability[${slotIndex}][days_of_week]" required>
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
      <input type="time" class="form-control" name="availability[${slotIndex}][start_time]" required>
    </div>
    <div class="col-md-3">
      <label class="form-label">End Time</label>
      <div class="d-flex">
        <input type="time" class="form-control me-2" name="availability[${slotIndex}][end_time]" required>
        <button type="button" class="btn btn-danger" onclick="removeSlot(this)">×</button>
      </div>
    </div>
  `;

  wrapper.appendChild(newSlot);
  slotIndex++;
}

function removeSlot(button) {
  const row = button.closest('.availability-slot');
  row.remove();
}
</script>



@endpush
