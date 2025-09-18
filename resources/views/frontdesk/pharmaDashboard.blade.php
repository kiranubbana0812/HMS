@extends('layouts.app')
@push('styles')
    <link href="{{ asset('css/insidestyles.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">    
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
    </style>
@endpush
@section('content')
<div class="container-fluid p-0">
    <div class="row g-0">
        <div class="col-md-2">
            @include('pharamacySidebar')
        </div>
        <div class="col-md-10 main-content px-3" id="mainContent">    
            <div class="content-header d-flex justify-content-between align-items-center mb-4">      
                <h4 class="mb-0 d-flex align-items-center" style="margin-left: 10px;">
                    <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                </h4>
            </div>
            <!-- Dashboard Cards -->
            <div class="row">                
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="dashboard-card">
                        <div class="card-content">
                            <div class="card-info">
                                <!-- First row: icon hard left, title hard right -->
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-pills card-icon orange-icon me-auto"></i>
                                    <h6 class="card-title fw-bold mb-0">Medicines</h6>
                                </div>

                                <!-- Second row: count (left aligned under icon) -->
                                <h2 class="card-number mt-2">
                                    {{ $data['total_products'] ?? 0 }}
                                </h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="dashboard-card">
                        <div class="card-content">
                            <div class="card-info">
                                <!-- First row: icon hard left, title hard right -->
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-file-invoice-dollar card-icon green-icon me-auto"></i>
                                    <h6 class="card-title fw-bold mb-0">Billing</h6>
                                </div>

                                <!-- Second row: count (left aligned under icon) -->
                                <h2 class="card-number mt-2">
                                    @if(isset($data))
                                        {{ $data['total_sales_amount'] ?? 0 }}
                                    @endif
                                </h2>
                            </div>
                        </div>
                    </div>
                </div>
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
@endpush
