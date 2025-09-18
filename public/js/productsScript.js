$(document).ready(function () {
 
   $('.view-btn').on('click', function () 
   {
    const product = $(this).data('product');


    // Now you can use parsedProduct.id, etc.
    $('#modal-name').text(product.name || '');
    $('#modal-unit').text(product.unit?.name || '');
    $('#modal-category').text(product.category?.name || '');
    $('#modal-description').text(product.description || '');
    $('#modal-gst').text(product.gst || '');
    $('#modal-created-at').text(dayjs(product.created_at).format('DD-MM-YYYY'));
    $('#modal-updated-at').text(dayjs(product.updated_at).format('DD-MM-YYYY'));


            
                if (!product || !Array.isArray(product.batches)) 
                {
                    console.log("No batches available for this product");
                            $('#batch-table-body').html(`
                                <tr>
                                    <td colspan="2" class="text-center">No batches available for this product</td>
                                </tr>
                            `);
                } else 
                              
                 {
                            const filteredBatches = product.batches;               
                            const batchTotals = {};

                            filteredBatches.forEach(batch => {
                                const code = batch.batch_no || 'N/A';
                                const qty = parseFloat(batch.quantity) || 0;
                                batchTotals[code] = (batchTotals[code] || 0) + qty;
                            });
            
                            $('#batch-table-body').empty();

   
                        const batchKeys = Object.keys(batchTotals);
                        if (batchKeys.length > 0) {
                            let hasRows = false;

                            batchKeys.forEach(code => 
                                {
                                    const totalQty = batchTotals[code];
                                    if (totalQty > 0) {
                                        const row = `
                                            <tr>
                                                <td>${code}</td>
                                                <td>${totalQty}</td>
                                            </tr>
                                        `;
                                        $('#batch-table-body').append(row);
                                        hasRows = true;
                                    }
                            });

                                 if (!hasRows) 
                                {
                                    $('#batch-table-body').append(`
                                        <tr>
                                            <td colspan="2" class="text-center">No batches available for this product</td>
                                        </tr>
                                    `);
                                }
                                } else 
                                    {
                                        $('#batch-table-body').append(`
                                            <tr>
                                                <td colspan="2" class="text-center">No batches available for this product</td>
                                            </tr>
                                        `);
                                    }

                        // Show modal
                        $('#productModal').modal('show');
                    }

   });





    // Open modal for new patient
    $('#addProductBtn').on('click', function () {
        $('#productForm')[0].reset();
        $('#product-id').val('');
        $('#productFormModalLabel').text('Add New Product');
        $('#productFormModal').modal('show');
    });

    // Open modal for editing patient
    $('.edit-btn').on('click', function () {
        const product = $(this).data('product');
        
        $('#product-id').val(product.id);
        $('#name').val(product.name || '');
        $('#unit_id').val(product.unit_id || '');
        $('#category_id').val(product.category_id || '');
        $('#description').text(product.description || '');
        $('#gst_percent').val(product.gst_percent || '');
        
        $('#productFormModalLabel').text('Edit/Update Product');
        $('#productFormModal').modal('show');
    });


    // Submit Product Form
    $('#productForm').on('submit', function (e) {
        e.preventDefault();

        // 🔹 Clear old errors
        $('.error-message').remove();
        $('.form-control, .form-select').removeClass('is-invalid');

        let valid = true;

        // Collect values
        const name        = $('#name').val().trim();
        const unitId      = $('#unit_id').val();
        const categoryId  = $('#category_id').val();
        const gstPercent  = $('#gst_percent').val().trim();
        const description = $('#description').val().trim();

        // 🔹 Validation rules
        if (!name) {
            $('#name').addClass('is-invalid')
                .after('<div class="error-message text-danger">Product name is required</div>');
            valid = false;
        }

        if (!unitId) {
            $('#unit_id').addClass('is-invalid')
                .after('<div class="error-message text-danger">Please select a unit</div>');
            valid = false;
        }

        if (!categoryId) {
            $('#category_id').addClass('is-invalid')
                .after('<div class="error-message text-danger">Please select a category</div>');
            valid = false;
        }


       
        if (!valid) return;

        // Proceed with AJAX if valid ✅
        const API_BASE_URL = document.querySelector('meta[name="api-base-url"]').getAttribute('content');
        const productId = $('#product-id').val();
        const isEdit = !!productId;

        const url = isEdit
            ? `${API_BASE_URL}/api/v1/admin/products/${productId}`
            : `${API_BASE_URL}/api/v1/admin/products`;

        const method = isEdit ? 'PUT' : 'POST';

        let payload = {
            name,
            description,
            unit_id: unitId,
            category_id: categoryId,
            gst_percent: gstPercent,
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
            success: function () {
                alert('Product saved successfully!');
                $('#productFormModal').modal('hide');
                location.reload(); // Refresh list
            },
            error: function (xhr) {
                alert('Failed to save product');
                console.error(xhr.responseText);
            }
        });
    });


});