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
                    <i class="fas fa-user-injured me-2"></i>Billing
                </h4>                
                <div class="action-buttons">
                    <button class="btn btn-primary me-2" id="addBillingBtn" data-bs-toggle="modal" data-bs-target="#addBillingModal">
                        <i class="fa fa-plus me-1"></i> 
                        <span data-bs-toggle="modal" id="addAppointmentBtn">Add Billing</span>
                    </button>
                    <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#searchBillingModal">
                        <i class="fas fa-search me-1 text-white"></i>
                        <span id="searchPatientsBtn">Search</span>
                    </button>
                    <form id="filtersForm" method="GET" action="{{ url()->current() }}">
						{{-- Preserve existing filters --}}
						@foreach(request()->except('payment_type') as $key => $value)
							<input type="hidden" name="{{ $key }}" value="{{ $value }}">
						@endforeach
						<div class="position-relative">
							<i class="fas fa-filter position-absolute text-secondary" style="top: 50%; left: 12px; transform: translateY(-50%); pointer-events: none;"></i>
							<select name="payment_type" onchange="document.getElementById('filtersForm').submit();" class="form-select ps-5" id="filterDropdown" style="min-width: 150px;">
								<option value="">Filter by</option>
								<option value="cash" {{ request('payment_type') == 'cash' ? 'selected' : '' }}>Cash</option>
								<option value="card" {{ request('payment_type') == 'card' ? 'selected' : '' }}>Card</option>
							</select>
						</div>
                    </form>
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
                                <th class="text-center">Customer Name</th>
                                <th class="text-center">Phone Number</th>
                                <th class="text-center">Billing date</th>
                                <th class="text-center">Invoice Number</th>
                                <th class="text-center">Payment Type</th>
                                <th class="text-center">Net Value</th>
                                <th class="text-center">GST</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($billing as $billingValue)
                            <tr>
								<td>{{ ($page - 1) * $perPage + $loop->iteration }}</td>
								@if ($billingValue['patient_id'])
									<td>{{ $billingValue['patient']['user']['name'] }}</td>
									<td>{{ $billingValue['patient']['user']['phone'] }}</td>
								@else
									<td>{{ $billingValue['patient_name'] }}</td>
									<td>{{ $billingValue['patient_phone_number'] }}</td>
								@endif
								<td>{{ \Carbon\Carbon::parse($billingValue['created_at'])->format('d-m-Y') }}</td>
								<td>{{ $billingValue['invoice_no'] }}</td>
								<td>{{ $billingValue['payment_type'] }}</td>
								<td>{{ $billingValue['net_amount'] }}</td>
								<td>{{ $billingValue['gst_amount'] }}</td>
								<td>
                                    <button class="btn btn-sm btn-outline-primary me-1 view-btn" data-bs-toggle="modal" data-bs-target="#billingModal" data-billing='@json($billingValue)'>
                                        <i class="fas fa-eye"></i>
                                    </button>
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
                                                <!---- Add Billing model --->
<div class="modal fade" id="addBillingModal" tabindex="-1" aria-labelledby="addBillingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addBillingModalLabel">
                    <i class="fa fa-file-invoice me-2"></i> Add New Billing
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
				<form id="addBillingForm">
					<input type="hidden" name="patient_id" />
					<div class="mb-3">
						<label for="customerName" class="form-label">Customer Name</label>
						<input type="text" class="form-control" id="customerName" name="patient_name" required>
					</div>

					<div class="mb-3">
						<label for="phoneNumber" class="form-label">Phone Number</label>
						<input type="tel" class="form-control" id="phoneNumber" name="patient_phone_number" required>
					</div>

					<div class="mb-3">
						<label for="billingDate" class="form-label">Billing Date</label>
						<input type="date" class="form-control" id="billingDate" name="sale_date" required>
					</div>

					<div class="mb-3">
						<label for="paymentType" class="form-label">Payment Type</label>
						<select class="form-select" id="paymentType" name="payment_type" required>
							<option value="">Select</option>
							<option value="Cash">Cash</option>
							<option value="Card">Card</option>
							<option value="Online">Online</option>
						</select>
					</div>

					<!-- Medicines Section -->
					<div id="medicine-container">
						<div class="medicine-row row g-2 mb-2">
							<input type="hidden" class="product-id" name="items[0][product_id]">
							
							<div class="col-md-4">
								<input type="text" class="form-control medicine-name" placeholder="Medicine name" required autocomplete="off">
							</div>
							<div class="col-md-2">
								<input type="number" class="form-control quantity" name="items[0][quantity]" placeholder="Qty" min="1" value="1" required>
							</div>
							<div class="col-md-2">
								<input type="text" class="form-control price" name="items[0][price]" placeholder="Price" readonly>
							</div>
							<div class="col-md-2">
								<input type="text" class="form-control total" name="items[0][total]" placeholder="Total" readonly>
							</div>
							<div class="col-md-2">
								<button type="button" class="btn btn-sm btn-success add-medicine">+</button>
							</div>
						</div>
					</div>



					<!-- Grand Total -->
					<div class="mt-3">
						<h5 class="text-end">Grand Total: <span id="grand-total">0</span></h5>
					</div>
				</form>
			</div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" form="addBillingForm">Save Billing</button>                
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>                
            </div>
        </div>
    </div>
</div>
                                                    <!---- Billing model --->
<div class="modal fade" id="billingModal" tabindex="-1" role="dialog" aria-labelledby="billingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="billingModalLabel">
                    <i class="fas fa-user-md me-2"></i> Billing Details
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">                                    
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-md-4 fw-bold">Name:</div>
                        <div class="col-md-8" id="modal-name"></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4 fw-bold">Phone No:</div>
                        <div class="col-md-8" id="modal-phone-no"></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4 fw-bold">Billing Date:</div>
                        <div class="col-md-8" id="modal-billing-date"></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4 fw-bold">Invoice No:</div>
                        <div class="col-md-8" id="modal-invoice"></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4 fw-bold">Payment Type:</div>
                        <div class="col-md-8" id="modal-payment-type"></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4 fw-bold">Total Qty:</div>
                        <div class="col-md-8" id="modal-total-qty"></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4 fw-bold">Total Amount:</div>
                        <div class="col-md-8" id="modal-total-amt"></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4 fw-bold">Total GST:</div>
                        <div class="col-md-8" id="modal-total-gst"></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4 fw-bold">Total Discount:</div>
                        <div class="col-md-8" id="modal-total-discount"></div>
                    </div>
                    <div class="row mb-2" id="sales-products"></div>
                </div>
            </div>
        </div>
    </div>
</div>

	                                            <!-- Search Billing Modal -->
	<div class="modal fade" id="searchBillingModal" tabindex="-1" aria-labelledby="searchBillingModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="searchAppointmentModalLabel">
						<i class="fa fa-search me-2"></i> Search Billing
					</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<form method="GET" action="{{ route('billing.index') }}">
						<div class="row">
							<div class="col-md-6 mb-3">
								<label>Patient Name</label>
								<input type="text" name="patient_name" class="form-control" value="{{ $filters['patient_name'] ?? '' }}">
							</div>
							<div class="col-md-6 mb-3">
								<label>Invoice Number</label>
								<input type="text" name="invoice_no" class="form-control" value="{{ $filters['invoice_no'] ?? '' }}">
							</div>
							<div class="col-md-6 mb-3">
								<label>Patient Phone</label>
								<input type="text" name="patient_phone_number" class="form-control" value="{{ $filters['patient_phone_number'] ?? '' }}">
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
							<a href="{{ route('billing.index') }}" class="btn btn-secondary">Reset</a>
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
<script src="{{ asset('js/billingscript.js') }}"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const paymentFilter = document.getElementById('paymentTypeFilter');
    if (paymentFilter) {
        paymentFilter.addEventListener('change', function() {
            document.getElementById('filtersForm').submit();
        });
    }
});
</script>
@endpush
