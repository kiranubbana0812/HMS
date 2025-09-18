@extends('layouts.app')
@push('styles')
    <link href="{{ asset('css/insidestyles.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">    
@endpush

@section('content')
<div class="container-fluid p-0">
	<div class="row g-0">
        <div class="col-md-2">
            @include('doctorSidebar')    
        </div>
		<!-- Main Content -->
		<div class="col-md-10 main-content px-3" id="mainContent">
			<!-- Appointments Cards -->
			<div class="row mb-4">
                    <div class="col-lg-3 col-md-6 mb-3">
                        <div class="dashboard-card">
                            <div class="card-content">
                                <div class="card-info">
                                    <h6 class="card-title">Appointments</h6>
                                    <h2 class="card-number">{{ $allCount['totaltoday'] }}</h2>
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
                                  <h2 class="card-number">{{ $allCount['completedtoday'] }}</h2>
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
                                   <h2 class="card-number">{{ $allCount['cancelledtoday'] }}</h2>
                                    <p class="card-subtitle">Today</p>
                                </div>
                                <div class="card-icon pink-icon">
                                    <i class="fas fa-times-circle"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-3">
                        <div class="dashboard-card">
                            <div class="card-content">
                                <div class="card-info">
                                    <h6 class="card-title">Appointments</h6>
                                    <h2 class="card-number">{{ $allCount['total'] }}</h2>
                                    <p class="card-subtitle">Till Today</p>
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
                                  <h2 class="card-number">{{ $allCount['completed'] }}</h2>
                                    <p class="card-subtitle">Till Today</p>
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
                                   <h2 class="card-number">{{ $allCount['cancelled'] }}</h2>
                                    <p class="card-subtitle">Till Today</p>
                                </div>
                                <div class="card-icon pink-icon">
                                    <i class="fas fa-times-circle"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
			</div>
		</div>
	</div>
</div>
@endsection
