@extends('layouts.app')
@push('styles')
    <link href="{{ asset('css/insidestyles.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
@endpush

@section('content')
<div class="dashboard-wrapper">
    @php
        $user = session('user');
    @endphp

    @if($user)
        <p><strong>Name:</strong> {{ $user['name'] ?? '-' }}</p>
        <p><strong>Email:</strong> {{ $user['email'] ?? '-' }}</p>
        <br>
        <button id="logout-btn">Logout</button>
    @else
        <p>User info not found in session.</p>
    @endif
</div>
<div class="container-fluid">
        <div class="row">
            @include('sidebar')
            <!-- Main Content -->
            <div class="col-md-10 main-content" id="mainContent">
                <div class="content-header d-flex justify-content-between align-items-center mb-4">
                    <h4 class="mb-0"><i class="fas fa-user-injured me-2"></i>Doctors</h4>
                </div>
                <div class="dashboard-card">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Doctor ID</th>
                                        <th>Name</th>
                                        <th>Department</th>
                                        <th>Specialization</th>
                                        <th>Experience</th>
                                        <th>Consultation Fee</th>
                                        <th>Actions</th>
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
                                                <button class="btn btn-sm btn-outline-primary me-1 view-btn" data-doctor='@json($doctor)' data-bs-toggle="modal" data-bs-target="#doctorModal">
                                                    <i class="fas fa-eye"></i>
                                                </button>
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
    <div class="modal fade" id="doctorModal" tabindex="-1" role="dialog" aria-labelledby="doctorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="doctorModalLabel">Doctor Details</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <p><img id="modal-image" src="" width="750px" /></p>
            <p><strong>Name:</strong> <span id="modal-name"></span></p>
            <p><strong>Doctor Id:</strong> <span id="modal-doctor-id"></span></p>
            <p><strong>Department:</strong> <span id="modal-department"></span></p>
            <p><strong>Specialization:</strong> <span id="modal-specialization"></span></p>
            <p><strong>Experience:</strong> <span id="modal-experience"></span></p>
            <p><strong>Consultation Fee:</strong> <span id="modal-consultaion-fee"></span></p>
        </div>
        </div>
    </div>
    </div>

@endsection
@push('scripts')
const API_BASE_URL = "{{ config('services.api.base_url') }}";
const AUTH_TOKEN = localStorage.getItem('auth_token');
<script src="{{ asset('js/doctorscript.js') }}"></script>
@endpush