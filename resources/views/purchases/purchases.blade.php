@extends('layouts.app')
@push('styles')
    <link href="{{ asset('css/insidestyles.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">   
 <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <style>
        .ui-autocomplete {
            z-index: 9999 !important; /* Ensures list is above modal backdrop */
        }

        .btn-success {
          background-color: #7c4dff !important;
          border-color: #7c4dff !important;
        }

        .btn-success:hover {
          background-color: #693de6 !important; /* Slightly darker on hover */
          border-color: #693de6 !important;
        }

        .modal-info {
          max-width: 50px;
          margin: 0 auto;
          font-family: Arial, sans-serif;
        }

        .modal-info-row {
          display: flex;
          justify-content: space-between;
          padding: 8px 0;
          border-bottom: 1px solid #eee;
        }

        .modal-label {
          flex: 1;
          font-weight: bold;
          text-align: left;
        }

        .modal-value {
          flex: 1;
          text-align: left;
        }

        .batch-row .form-label {
            font-size: 0.85rem;
            font-weight: 600;
        }

        .batch-row .form-control {
            padding: 0.375rem 0.5rem;
            font-size: 0.85rem;
        }

        .batch-row .btn-sm {
            padding: 0.25rem 0.5rem;
        }

        .ui-autocomplete {
            z-index: 1056 !important; /* Bootstrap modal z-index is 1055 */
            max-height: 200px;
            overflow-y: auto;
            overflow-x: hidden;
            border-radius: 0.25rem;
        }

        /* dropdown style */
        .product-dropdown {
          z-index: 2050 !important; /* above modal backdrop */
          max-height: 220px;
          overflow-y: auto;
          overflow-x: hidden;
          border-radius: 0.25rem;
          box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }

        /* item hover */
        .product-dropdown .productSearch-option:hover {
          background: #f8f9fa;
          cursor: pointer;
        }
    </style>
@endpush

@section('content')
<div class="container-fluid p-0">
    <div class="row g-0">
        <div class="col-md-2">
            @include('superAdminSidebar')
        </div>
         <div class="col-md-10 main-content" id="mainContent">
            <!-- Appointments Cards -->
            <div class="content-header d-flex justify-content-between align-items-center mb-4">
                <h4 class="mb-0"><i class="fas fa-user-injured me-2"></i>Purchase</h4>
                <div class="action-buttons">
                    <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#addpurchaseModal">
                    <i class="fas fa-plus me-1"></i>
                    Add purchase
                </button>
                  <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#searchPurchaseModal">
                    <i class="fas fa-search me-1 text-white"></i>
                    <span id="searchPurchaseBtn">Search</span>
                </button>
                </div>                   
            </div>
            <div id="alertBox"></div>
            <div class="dashboard-card">
                <div class="table-responsive">

                    {{-- Active Filters --}}
                    @if(request()->query())
                        <div class="mb-3 p-3 border rounded bg-light">
                            <h6 class="mb-2">Active Filters:</h6>
                            <div class="d-flex flex-wrap align-items-center gap-2">
                                @foreach(request()->query() as $key => $value)
                                    @if(!empty($value) && $key !== 'page')
                                        <span class="badge bg-primary">
                                            {{ ucfirst($key) }}: {{ $value }}
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

                    {{-- Purchases Table --}}
                    <table class="table table-hover text-center w-100 m-0">
                        <thead>
                            <tr>
                                <th>Supplier Name</th>
                                <th>Invoice No</th>
                                <th>Purchase Date</th>
                                <th>Total Amount</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($purchasesData as $purchaseData)
                                <tr>
                                    <td>{{ $purchaseData['supplier']['name'] ?? '-' }}</td>
                                    <td>{{ $purchaseData['invoice_no'] ?? '-' }}</td>
                                    <td>{{ $purchaseData['purchase_date'] ?? '-' }}</td>
                                    <td>{{ $purchaseData['total_amount'] ?? '-' }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary me-1 view-btn" data-purchase='@json($purchaseData)' data-bs-toggle="modal" data-bs-target="#purchaseModal">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-warning me-1 edit-btn" data-purchase='@json($purchaseData)'>
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">No purchase records found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{-- Pagination --}}
                    <x-pagination :pagination="$pagination" :filters="$filters" />

                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="purchaseModal" tabindex="-1" role="dialog" aria-labelledby="billingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="purchaseModalLabel">
                    <i class="fas fa-user-md me-2"></i> Purchase Details
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">                                    
                <div class="container-fluid">
                    <div class="row mb-2">
                        <span class="modal-label">Supplier Id:</span>
                    <span id="modal-supplier_id" class="modal-value"></span>
                    </div>
                    <div class="row mb-2">
                        <span class="modal-label">Supplier Name:</span>
                    <span id="modal-supplier-name" class="modal-value"></span>
                    </div>
                    <div class="row mb-2">
                        <span class="modal-label">Invoice No:</span>
                    <span id="modal-invoice_no" class="modal-value"></span>
                    </div>
                    <div class="row mb-2">
                        <span class="modal-label">Purchase Date:</span>
                    <span id="modal-purchase_date" class="modal-value"></span>
                    </div>
                    <div class="row mb-2">
                        <span class="modal-label">Total Amount:</span>
                    <span id="modal-total_amount" class="modal-value"></span>
                    </div>
                    <hr>
                <p><strong>Batches</strong></p>
                    <div class="row mb-2" id="modal-availability-grid"></div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="searchPurchaseModal" tabindex="-1" aria-labelledby="searchPurchaseModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="searchPurchaseModalLabel">
                    <i class="fa fa-search me-2"></i> Search Purchase
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="GET" action="{{ route('superadmin.purchases') }}">
                    <div class="row">
                      

                          <div class="col-md-6 mb-3">
                            <label>Supplier Name</label>
                            <input type="text" name="supplier_name" class="form-control" value="{{ $filters['supplier']['name'] ?? '' }}">
                        </div> 
                        
                        <div class="col-md-6 mb-3">
                            <label>Invoice</label>
                            <input type="text" name="invoice_no" class="form-control" value="{{ $filters['invoice_no'] ?? '' }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>From Date</label>
                            <input type="date" name="from_date" class="form-control" value="{{ $filters['purchase_date'] ?? '' }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>To Date</label>
                            <input type="date" name="to_date" class="form-control" value="{{ $filters['purchase_date'] ?? '' }}">
                        </div>

                      
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary me-2">Search</button>
                        <a href="{{ route('superadmin.purchases') }}" class="btn btn-secondary">Reset</a>
                    </div>
                </form>
            </div>
        </div>
    </div>   
 </div>

<!-- Modal -->
<!-- Purchase Modal -->
<div class="modal fade" id="addpurchaseModal" tabindex="-1" aria-labelledby="addpurchaseModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <form id="addpurchaseForm">
        <div class="modal-header">
          <h5 class="modal-title" id="addpurchaseModalLabel">Add Purchase</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body row g-3">
            <div class="col-md-6 mb-3">
                <label for="purchaseSearch" class="form-label">Supplier Name</label>
                <input type="text" id="purchaseSearch" class="form-control" name="supplier_name" placeholder="Search Supplier Name" autocomplete="off" required>
                <input type="hidden" id="id" name="id">
                <input type="hidden" id="supplier_id" name="supplier_id" required>                             
            </div> 

            <div class="col-md-6">
                <label class="form-label">Invoice No</label>
                <input type="text" class="form-control" name="invoice_no" id="invoice_no" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Purchase Date</label>
                <input type="date" class="form-control" name="purchase_date" id="purchase_date" required>
            </div>

            <!-- Batches -->
            <div id="batchContainer" class="col-12">
                <div class="row g-2 mb-2 batch-row" data-index="1">
                    <div class="col-md-3">
                        <label class="form-label">Product</label>
                        <input type="text" class="form-control productSearch" placeholder="Search Product" autocomplete="off" required>
                        <input type="hidden" name="batches[1][product_id]" class="product_id" required>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">Batch No</label>
                        <input type="text" class="form-control" name="batches[1][batch_no]" required>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">Expiry Date</label>
                        <input type="date" class="form-control" name="batches[1][expiry_date]" required>
                    </div>

                    <div class="col-md-1">
                        <label class="form-label">Qty</label>
                        <input type="number" min="1" class="form-control qty" name="batches[1][quantity]"  placeholder="Qty" required>
                    </div>

                    <div class="col-md-1">
                        <label class="form-label">MRP</label>
                        <input type="number" step="0.01" class="form-control" name="batches[1][mrp]" placeholder="Purchase Price" required>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">Purchase Price</label>
                        <input type="number" step="0.01" class="form-control purchasePrice" name="batches[1][purchase_price]" required>
                    </div>

                    <div class="col-md-1">
                        <label class="form-label">GST %</label>
                        <input type="number" step="0.01" class="form-control gst" name="batches[1][gst_percent]" placeholder="GST %" required>
                    </div>

                    <div class="col-md-12 d-flex justify-content-end mt-2">
                        <button type="button" class="btn btn-danger btn-sm remove-batch">Remove</button>
                    </div>
                </div>
            </div>

            <div class="col-12 mb-2">
                <button type="button" class="btn btn-secondary" onclick="addBatchSlot()">+ Add Batch</button>
            </div>

            <div class="col-md-6">
                <label class="form-label">Total Amount</label>
                <input type="text" class="form-control" name="total_amount" id="totalAmount" required readonly>
            </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Save</button>
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
<script src="{{ asset('js/purchasescript.js') }}"></script>
@endpush
