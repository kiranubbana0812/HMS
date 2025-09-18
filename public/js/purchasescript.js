<<<<<<< HEAD
const USER_ROLE = document.querySelector('meta[name="user-role"]').getAttribute('content');
$(document).ready(function () {
    const API_BASE_URL = document.querySelector('meta[name="api-base-url"]').getAttribute('content');
    const AUTH_TOKEN = localStorage.getItem('auth_token');
    //const USER_ROLE = document.querySelector('meta[name="user-role"]').getAttribute('content');
=======
$(document).ready(function () {
    const API_BASE_URL = document.querySelector('meta[name="api-base-url"]').getAttribute('content');
    const AUTH_TOKEN = localStorage.getItem('auth_token');
>>>>>>> 6b8595dc1c62273c0bff306bbd6788244a439795

    // View Doctor Details
    $('.view-btn').on('click', function () {
        const purchase = $(this).data('purchase');
        console.log('Parsed .data("purchase"):', purchase);

        $('#modal-supplier_id').text(purchase.supplier_id || '');
        $('#modal-supplier-name').text(purchase.supplier.name || '');
        $('#modal-invoice_no').text(purchase.invoice_no || '');
        $('#modal-purchase_date').text(purchase.purchase_date || '');
        $('#modal-totalAmount').text(purchase.total_amount || '');
       
        if (purchase.batches?.length > 0) {
            let html = '<table class="table text-center"><thead><tr><th>Product Id</th><th>Product Name</th><th>Batch No</th><th>Expiry Date</th><th>Quantity</th> <th>MRP</th> <th>Purchase Price</th><th>GST</th></tr></thead><tbody>';
            purchase.batches.forEach(slot => {
                html += `<tr>
                    <td>${slot.product_id}</td>
                    <td>${slot.product.name}</td>                    
                    <td>${slot.batch_no}</td>
                    <td>${slot.expiry_date}</td>
                     <td>${slot.quantity}</td>
                     <td>${slot.mrp}</td>
                    <td>${slot.purchase_price}</td>
                     <td>${slot.gst_percent}</td>
                </tr>`;
            });
            html += '</tbody></table>';
            $('#modal-availability-grid').html(html);
        } else {
            $('#modal-availability-grid').html('<p>No availability data.</p>');
        }

        $('#purchaseModal').modal('show');
    });



    // Reset form on modal close
    $('#addpurchaseModal').on('hidden.bs.modal', function () {
        $('#addpurchaseForm')[0].reset();
        $('#id').val('');      
        $('#addpurchaseModalLabel').text('Add Purchase');
        $('#addpurchaseForm button[type="submit"]').text('Add Purchase');
        $('#availability-wrapper').empty();
        batchCount = 0;
        addBatchSlot(); // default slot
    });

    

   $(document).on('click', '.edit-btn', function () {
    const purchase = $(this).data('purchase'); 
    if (!purchase) {
        console.error("No purchase data found");
        return;
    }

    // Set supplier name and ID
    $('#purchaseSearch').val(purchase.supplier.name); // visible field
    $('#supplier_id').val(purchase.supplier_id);      // hidden field

    // Set other fields
    $('#id').val(purchase.id);
    $('#invoice_no').val(purchase.invoice_no);
    $('#purchase_date').val(purchase.purchase_date);
    $('#totalAmount').val(purchase.total_amount);

    // Reset batch slots
    $('#batchContainer').empty();
    batchCount = 0;

    if (Array.isArray(purchase.batches) && purchase.batches.length > 0) {

         
        purchase.batches.forEach(batch => addBatchSlot(batch));
    } else {
        addBatchSlot();
    }

    // Update modal labels and show modal
    $('#addpurchaseModalLabel').text('Edit Purchase');
    $('#addpurchaseForm button[type="submit"]').text('Update Purchase');

    const modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('addpurchaseModal'));
    modal.show();

    // Reset modal on close
    $('#addpurchaseModal').on('hidden.bs.modal', function () {
        $('#addpurchaseForm')[0].reset();
        $('#id').val('');
        $('#supplier_id').val('');
        $('#batchContainer').empty();
        $('#addpurchaseModalLabel').text('Add Purchase');
        $('#addpurchaseForm button[type="submit"]').text('Add Purchase');
        batchCount = 0;
        addBatchSlot();
    });
});

function initAutocomplete(inputSelector, hiddenFieldSelector, apiEndpoint) {
    $(inputSelector).autocomplete({
        appendTo: "#addpurchaseModal", // modal container
        minLength: 3,
        source: function (request, response) {
            $.ajax({
                url: `${API_BASE_URL}${apiEndpoint}`,
                headers: { Authorization: `Bearer ${AUTH_TOKEN}` },
                data: { q: request.term },
                success: function (data) {
                    response($.map(data, function (item) {
                        return {
                            label: item.name,
                            value: item.name,
                            id: item.id
                        };
                    }));
                },
                error: function (xhr) {
                    console.error("Autocomplete API error:", xhr);
                    response([]);
                }
            });
        },
        select: function (event, ui) {
            $(hiddenFieldSelector).val(ui.item.id);
        }
    });
}

<<<<<<< HEAD

// Initialize both autocompletes
//initAutocomplete("#purchaseSearch", "#supplier_id", "/api/v1/admin/supplier/search/autocomplete");
// Decide endpoint based on role
const supplierEndpoint = USER_ROLE === "pharma"
    ? "/api/v1/pharma/supplier/search/autocomplete"
    : "/api/v1/admin/supplier/search/autocomplete";

// Initialize autocomplete with correct path
initAutocomplete("#purchaseSearch", "#supplier_id", supplierEndpoint);
=======
// Initialize both autocompletes

initAutocomplete("#purchaseSearch", "#supplier_id", "/api/v1/admin/supplier/search/autocomplete");

>>>>>>> 6b8595dc1c62273c0bff306bbd6788244a439795

$('#addpurchaseForm').on('submit', function (e) {

    e.preventDefault();

<<<<<<< HEAD
    const isEdit = !!$('#id').val();   
           let url;
            try {                
                if(!isEdit) {
                    const basePath = USER_ROLE === "pharma"
                    ? "pharma/add/purchases"
                    : "inventory/admin/add/purchases";
                    url = `${API_BASE_URL}/api/v1/${basePath}`;
                }
                else {
                    const basePath = USER_ROLE === "pharma"
                    ? "pharma/edit/purchases/"
                    : "inventory/admin/edit/purchases";
                    url = `${API_BASE_URL}/api/v1/${basePath}/${$('#id').val()}`;
                }
                  

                // You can now safely use `url` here
               // console.log("Constructed URL:", url);

            } catch (error) {
                console.error("Error constructing the URL:", error);
                // Optional: Show error to user or handle fallback
            }
=======
    const isEdit = !!$('#id').val();
    const url = isEdit
        ? `${API_BASE_URL}/api/v1/inventory/admin/purchase/${$('#id').val()}`
        : `${API_BASE_URL}/api/v1/inventory/admin/purchase`;
>>>>>>> 6b8595dc1c62273c0bff306bbd6788244a439795

    const method = isEdit ? 'PUT' : 'POST';
    const formData = {
        supplier_id : $('#supplier_id').val(),
        invoice_no: $('#invoice_no').val(),
        purchase_date: $('#purchase_date').val(),
        total_amount: $('#totalAmount').val(),
        batches: []
    };

    $('#batchContainer .row').each(function () {
        const row = $(this);
        formData.batches.push({
            product_id: row.find('[name*="[product_id]"]').val(),
            batch_no: row.find('[name*="[batch_no]"]').val(),
            expiry_date: row.find('[name*="[expiry_date]"]').val(),
            quantity: row.find('[name*="[quantity]"]').val(),
            mrp: row.find('[name*="[mrp]"]').val(),
            purchase_price: row.find('[name*="[purchase_price]"]').val(),
            gst_percent: row.find('[name*="[gst_percent]"]').val()
        });
    });

    console.log("formdata",formData);

    $.ajax({
        url: url,
        method: method,
        headers: {
            'Authorization': `Bearer ${AUTH_TOKEN}`,
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        data: JSON.stringify(formData),
            success: function (res) {
                $('#addpurchaseModal').modal('hide');
                $('#addpurchaseForm')[0].reset();
                $('#batchContainer').html('');
                $('#alertBox').html(`<div class="alert alert-success">Purchase ${isEdit ? 'updated' : 'added'} successfully.</div>`);
                setTimeout(() => location.reload(), 1000);
            },
            error: function (xhr) {
                console.error("Error:", xhr.responseText);
                $('#addpurchaseModal').modal('hide');
                const message = xhr.responseJSON?.message || 'Something went wrong.';
                $('#alertBox').html(`<div class="alert alert-danger">${message}</div>`);
            }
        });
    });
});

$(document).on('input', '.productSearch', function () {
    const input = $(this);
    const query = input.val().trim();

    // quick access to API config (matches your file's usage)
    const API_BASE_URL = document.querySelector('meta[name="api-base-url"]').getAttribute('content');
    const AUTH_TOKEN = localStorage.getItem('auth_token');

    // container to attach dropdown (closest column / position-relative element)
    const container = input.closest('.position-relative, .col-md-3, .col-md-4, .col-md-6').first();

    // ensure container is positioned relative so absolute dropdown aligns
    if (container.length) {
        if (container.css('position') === 'static') container.css('position', 'relative');
    }

    // remove any existing dropdown for this input BEFORE debounce (prevents duplicates)
    container.find('.product-dropdown').remove();

    // cancel any pending debounce timer for this input
    const prevTimer = input.data('dropdownTimer');
    if (prevTimer) clearTimeout(prevTimer);

    // hide if less than 3 chars
    if (query.length < 3) {
        return input.data('dropdownTimer', null);
    }

    // debounce AJAX
    const timer = setTimeout(() => {
        // append an empty dropdown placeholder (so keyboard positioning looks instant)
        const dropdown = $('<ul class="list-group product-dropdown position-absolute w-100"></ul>');
        // position: below the input (use padding so it doesn't sit over label)
        dropdown.css({ top: (input.position().top + input.outerHeight() + 6) + 'px', left: 0 });

        container.append(dropdown);

        // store the query to detect stale responses
        const currentQuery = query;

        $.ajax({
<<<<<<< HEAD
            //url: `${API_BASE_URL}/api/v1/admin/products/search`,
            url: USER_ROLE === "pharma"
            ? `${API_BASE_URL}/api/v1/pharma/products/search`
            : `${API_BASE_URL}/api/v1/admin/products/search`,
=======
            url: `${API_BASE_URL}/api/v1/admin/products/search`,
>>>>>>> 6b8595dc1c62273c0bff306bbd6788244a439795
            headers: { Authorization: `Bearer ${AUTH_TOKEN}` },
            method: 'GET',
            data: { q: currentQuery },
            success: function (response) {
                // if user changed input since request started, ignore this result
                if (input.val().trim() !== currentQuery) {
                    dropdown.remove();
                    return;
                }

                dropdown.empty();

                if (!response || response.length === 0) {
                    dropdown.append('<li class="list-group-item text-muted">No results</li>');
                    return;
                }

                response.forEach(function (product) {
                    // escape quotes for safety
                    const safeName = (product.name || '').replace(/"/g, '&quot;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
                    dropdown.append(
                        `<li class="list-group-item productSearch-option" data-id="${product.id}" data-name="${safeName}">${safeName}</li>`
                    );
                });
            },
            error: function (xhr) {
                console.error('Product search failed:', xhr);
                dropdown.remove();
            }
        });
    }, 260); // 260ms debounce

    input.data('dropdownTimer', timer);
});


// click handler: pick a product option (delegated)
$(document).on('click', '.productSearch-option', function (e) {
    e.preventDefault();
    const li = $(this);
    const prodId = li.data('id');
    const prodName = li.data('name');

    // find the row and the input that spawned the dropdown
    const dropdown = li.closest('.product-dropdown');
    const container = dropdown.parent(); // where we appended
    const row = li.closest('.batch-row');
    const input = row.find('.productSearch').first();

    // fill values
    input.val(prodName);
    // hidden input - ensure you have one
    row.find('.product_id').val(prodId);

    // remove dropdown
    dropdown.remove();
});


// remove dropdown when clicking outside
$(document).on('click', function (e) {
    if ($(e.target).closest('.productSearch, .product-dropdown').length === 0) {
        $('.product-dropdown').remove();
    }
});

// also remove dropdown on input blur with slight timeout so click can register
$(document).on('blur', '.productSearch', function () {
    const input = $(this);
    setTimeout(() => {
        const container = input.closest('.position-relative, .col-md-3, .col-md-4, .col-md-6').first();
        container.find('.product-dropdown').remove();
    }, 200);
});

let batchCount = 1; // first batch already exists

function addBatchSlot(batchData = {}) {
    batchCount++;

    let html = `
    <div class="row g-2 mb-2 batch-row" data-index="${batchCount}">
        <div class="col-md-3">
            <label class="form-label">Product</label>
            <input type="text" class="form-control productSearch" placeholder="Search Product" autocomplete="off" value="${batchData.product?.name || ''}" required>
            <input type="hidden" name="batches[${batchCount}][product_id]" class="product_id" value="${batchData.product_id || ''}" required>
        </div>
        <div class="col-md-2">
            <label class="form-label">Batch No</label>
            <input type="text" class="form-control" name="batches[${batchCount}][batch_no]" value="${batchData.batch_no || ''}" required>
        </div>
        <div class="col-md-2">
            <label class="form-label">Expiry Date</label>
            <input type="date" class="form-control" name="batches[${batchCount}][expiry_date]" value="${batchData.expiry_date || ''}" required>
        </div>
        <div class="col-md-1">
            <label class="form-label">Qty</label>
            <input type="number" min="1" class="form-control qty"  placeholder="Qty" name="batches[${batchCount}][quantity]" value="${batchData.quantity || ''}" required>
        </div>
        <div class="col-md-1">
            <label class="form-label">MRP</label>
            <input type="number" step="0.01" class="form-control" placeholder="MRP" name="batches[${batchCount}][mrp]" value="${batchData.mrp || ''}" required>
        </div>
        <div class="col-md-2">
            <label class="form-label">Purchase Price</label>
            <input type="number" step="0.01" class="form-control purchasePrice" placeholder="Purchase Price" name="batches[${batchCount}][purchase_price]" value="${batchData.purchase_price || ''}" required>
        </div>
        <div class="col-md-1">
            <label class="form-label">GST %</label>
            <input type="number" step="0.01" class="form-control gst" placeholder="GST %" name="batches[${batchCount}][gst_percent]" value="${batchData.gst_percent || ''}" required>
        </div>
        <div class="col-md-12 d-flex justify-content-end mt-2">
            <button type="button" class="btn btn-danger btn-sm remove-batch">Remove</button>
        </div>
    </div>`;

    $('#batchContainer').append(html);
}


// Remove row
$(document).on('click', '.remove-batch', function () {
    $(this).closest('.batch-row').remove();
});

// Show modal → load one default batch
$('#addpurchaseModal').on('shown.bs.modal', function () {
    if ($('#batchContainer').children().length === 0) {
        addBatchSlot();
    }
});

function calculateTotal() {
    let grandTotal = 0;

    $('.batch-row').each(function () {
        let qty = parseFloat($(this).find('.qty').val()) || 0;
        let price = parseFloat($(this).find('.purchasePrice').val()) || 0;
        let gst = parseFloat($(this).find('.gst').val()) || 0;

        let subtotal = qty * price;
        let gstAmount = subtotal * (gst / 100);
        let rowTotal = subtotal + gstAmount;

        // update row total field
        $(this).find('.rowTotal').val(rowTotal.toFixed(2));

        // add to grand total
        grandTotal += rowTotal;
    });

    // update grand total field
    $('#totalAmount').val(grandTotal.toFixed(2));
}

// trigger calculation when qty, price, or gst changes
$(document).on('input', '.qty, .purchasePrice, .gst', function () {
    calculateTotal();
});