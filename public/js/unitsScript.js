$(document).ready(function () {
    $('.view-btn').on('click', function () {
        const unit = $(this).data('units');
        //console.log(":: Unit DATA ::"+JSON.stringify(unit));

        $('#modal-name').text(unit.name || '');
        $('#modal-short-name').text(unit.short_name || '');
        $('#modal-description').text(unit.description || '');
        $('#modal-created-at').text(dayjs(unit.created_at).format('DD-MM-YYYY'));
        $('#modal-updated-at').text(dayjs(unit.updated_at).format('DD-MM-YYYY'));


        $('#unitsModal').modal('show');
    });

    // Open modal for new patient
    $('#addUnitsBtn').on('click', function () {
        $('#addUnitsForm')[0].reset();
        $('#units_id').val('');
        $('#unitsModalLabel').text('Add New Unit');
        $('#addUnitsModal').modal('show');
    });

    // Open modal for editing patient
    $('.edit-btn').on('click', function () {
        const unit = $(this).data('units');
        
        $('#units_id').val(unit.id);
        $('#unitName').val(unit.name || '');
        $('#shortName').val(unit.short_name || '');
        $('#unitsDescription').val(unit.description || '');
        
        $('#unitsFormModalLabel').text('Edit/Update Unit');
        $('#addUnitsModal').modal('show');
    });


    // Submit form
    $('#addUnitsForm').on('submit', function (e) {
        e.preventDefault();

        // Clear previous errors
        $('.error-message').remove();
        $('.form-control').removeClass('is-invalid');

        let valid = true;

        // Get field values
        const unitName   = $('#unitName').val().trim();
        const shortName  = $('#shortName').val().trim();
        const unitsDescription = $('#unitsDescription').val().trim();
        
        // Validation
        if (!unitName) {
            $('#unitName').addClass('is-invalid')
                .after('<div class="error-message text-danger">Unit name is required</div>');
            valid = false;
        }

        if (!shortName) {
            $('#shortName').addClass('is-invalid')
                .after('<div class="error-message text-danger">Short name is required</div>');
            valid = false;
        }

        if (!unitsDescription) {
            $('#unitsDescription').addClass('is-invalid')
                .after('<div class="error-message text-danger">Units description is required</div>');
            valid = false;
        }


        if (!valid) return; // ❌ stop submit if errors

        // Proceed with AJAX if valid ✅
        const API_BASE_URL = document.querySelector('meta[name="api-base-url"]').getAttribute('content');
        const unitId = $('#units_id').val();
        const isEdit = !!unitId;
        const url = isEdit
            ? `${API_BASE_URL}/api/v1/admin/units/${unitId}`
            : `${API_BASE_URL}/api/v1/admin/units`;

        const method = isEdit ? 'PUT' : 'POST';

        const payload = {
            name: unitName,
            short_name: shortName,
            description: unitsDescription,
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
                alert('Unit saved successfully!');
                $('#addUnitsModal').modal('hide');
                location.reload(); // Refresh list
            },
            error: function (xhr) {
                alert('Failed to save unit');
                console.log(xhr.responseText);
            }
        });
    });

});