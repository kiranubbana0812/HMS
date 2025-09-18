$(document).ready(function () {
    $('.view-btn').on('click', function () {
        const supplier = $(this).data('suppliers');
        //console.log(":: Supplier DATA ::"+JSON.stringify(supplier));

        $('#modal-name').text(supplier.name || '');
        $('#modal-phone-no').text(supplier.contact_number || '');
        $('#modal-email').text(supplier.email || '');
        $('#modal-address').text(supplier.address || '');
        $('#modal-created-at').text(dayjs(supplier.created_at).format('DD-MM-YYYY'));
        $('#modal-updated-at').text(dayjs(supplier.updated_at).format('DD-MM-YYYY'));


        $('#suppliersModal').modal('show');
    });

    // Open modal for new patient
    $('#addSuppliersBtn').on('click', function () {
        $('#addSuppliersForm')[0].reset();
        $('#suppliers_id').val('');
        $('#suppliersModalLabel').text('Add New Supplier');
        $('#addSuppliersModal').modal('show');
    });

    // Open modal for editing patient
    $('.edit-btn').on('click', function () {
        const supplier = $(this).data('suppliers');
        
        $('#suppliers_id').val(supplier.id);
        $('#supplierName').val(supplier.name || '');
        $('#suppliersEmail').val(supplier.email || '');
        $('#contactNumber').val(supplier.contact_number || '');
        $('#suppliersAddress').val(supplier.address || '');

        $('#suppliersFormModalLabel').text('Edit/Update Supplier');
        $('#addSuppliersModal').modal('show');
    });


    // Submit form
    $('#addSuppliersForm').on('submit', function (e) {
        e.preventDefault();

        // Clear previous errors
        $('.error-message').remove();
        $('.form-control').removeClass('is-invalid');

        let valid = true;

        // Get field values
        const supplierName   = $('#supplierName').val().trim();
        const contactNumber  = $('#contactNumber').val().trim();
        const suppliersEmail = $('#suppliersEmail').val().trim();
        const suppliersAddress = $('#suppliersAddress').val().trim();

        // Validation
        if (!supplierName) {
            $('#supplierName').addClass('is-invalid')
                .after('<div class="error-message text-danger">Supplier name is required</div>');
            valid = false;
        }

        if (!contactNumber) {
            $('#contactNumber').addClass('is-invalid')
                .after('<div class="error-message text-danger">Phone number is required</div>');
            valid = false;
        } else if (!/^[0-9]{10}$/.test(contactNumber)) {
            $('#contactNumber').addClass('is-invalid')
                .after('<div class="error-message text-danger">Enter a valid 10-digit phone number</div>');
            valid = false;
        }

        if (!suppliersEmail) {
            $('#suppliersEmail').addClass('is-invalid')
                .after('<div class="error-message text-danger">Email is required</div>');
            valid = false;
        } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(suppliersEmail)) {
            $('#suppliersEmail').addClass('is-invalid')
                .after('<div class="error-message text-danger">Enter a valid email</div>');
            valid = false;
        }

        if (!suppliersAddress) {
            $('#suppliersAddress').addClass('is-invalid')
                .after('<div class="error-message text-danger">Address is required</div>');
            valid = false;
        }

        if (!valid) return; // ❌ stop submit if errors

        // Proceed with AJAX if valid ✅
        const API_BASE_URL = document.querySelector('meta[name="api-base-url"]').getAttribute('content');
        const supplierId = $('#suppliers_id').val();
        const isEdit = !!supplierId;
        const url = isEdit
            ? `${API_BASE_URL}/api/v1/admin/supplier/${supplierId}`
            : `${API_BASE_URL}/api/v1/admin/supplier`;

        const method = isEdit ? 'PUT' : 'POST';

        const payload = {
            name: supplierName,
            email: suppliersEmail,
            contact_number: contactNumber,
            address: suppliersAddress,
        };

        const AUTH_TOKEN = localStorage.getItem('auth_token');

        $.ajax({
            url,
            method,
            headers: {
                Authorization: `Bearer ${AUTH_TOKEN}`
            },
            contentType: 'application/json',
            data: JSON.stringify(payload),
            success: function (response) {
                alert('Supplier saved successfully!');
                $('#addSuppliersModal').modal('hide');
                location.reload(); // Refresh list
            },
            error: function (xhr) {
                alert('Failed to save supplier');
                console.log(xhr.responseText);
            }
        });
    });

});