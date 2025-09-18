$(document).ready(function () {
<<<<<<< HEAD
    $('.view-btn').on('click', function () {
        const product = $(this).data('product');
        //console.log(":: product DATA ::"+JSON.stringify(product));

        $('#modal-name').text(product.name || '');
        $('#modal-unit').text(product.unit?.name || '');
        $('#modal-category').text(product.category?.name || '');
        $('#modal-description').text(product.description || '');
        $('#modal-gst').text(product.gst || '');
        $('#modal-created-at').text(dayjs(product.created_at).format('DD-MM-YYYY'));
        $('#modal-updated-at').text(dayjs(product.updated_at).format('DD-MM-YYYY'));


         if (!product || !Array.isArray(product.batches)) 
=======
 
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
>>>>>>> 6b8595dc1c62273c0bff306bbd6788244a439795
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

<<<<<<< HEAD
                            filteredBatches.forEach(batch => 
                            {
=======
                            filteredBatches.forEach(batch => {
>>>>>>> 6b8595dc1c62273c0bff306bbd6788244a439795
                                const code = batch.batch_no || 'N/A';
                                const qty = parseFloat(batch.quantity) || 0;
                                batchTotals[code] = (batchTotals[code] || 0) + qty;
                            });
            
                            $('#batch-table-body').empty();

   
                        const batchKeys = Object.keys(batchTotals);
<<<<<<< HEAD
                        if (batchKeys.length > 0) 
                            {
                                let hasRows = false;
                                batchKeys.forEach(code => 
                                {
                                    const totalQty = batchTotals[code];
                                    if (totalQty > 0) 
                                     {
                                        const row = `<tr>
                                                        <td>${code}</td>
                                                        <td>${totalQty}</td>
                                                    </tr>`;
                                        $('#batch-table-body').append(row);
                                        hasRows = true;
                                    }
                                 });

                                 if (!hasRows) 
=======
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
>>>>>>> 6b8595dc1c62273c0bff306bbd6788244a439795
                                    {
                                        $('#batch-table-body').append(`
                                            <tr>
                                                <td colspan="2" class="text-center">No batches available for this product</td>
                                            </tr>
                                        `);
                                    }
<<<<<<< HEAD
                             } else 
                                    {
                                        $('#batch-table-body').append(`
                                            <tr><td colspan="2" class="text-center">No batches available for this product</td>
                                            </tr>
                                        `);
                                    }
=======
>>>>>>> 6b8595dc1c62273c0bff306bbd6788244a439795

                        // Show modal
                        $('#productModal').modal('show');
                    }

<<<<<<< HEAD
    });
=======
   });




>>>>>>> 6b8595dc1c62273c0bff306bbd6788244a439795

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


<<<<<<< HEAD
        // ❌ Stop if invalid
=======
       
>>>>>>> 6b8595dc1c62273c0bff306bbd6788244a439795
        if (!valid) return;

        // Proceed with AJAX if valid ✅
        const API_BASE_URL = document.querySelector('meta[name="api-base-url"]').getAttribute('content');
        const productId = $('#product-id').val();
        const isEdit = !!productId;
<<<<<<< HEAD
        const USER_ROLE = document.querySelector('meta[name="user-role"]').getAttribute('content');

        // 🔹 Pick base route depending on role
        const basePath = USER_ROLE === 'pharma' ? 'pharma' : 'admin';

        const url = isEdit
            ? `${API_BASE_URL}/api/v1/${basePath}/products/${productId}`
            : `${API_BASE_URL}/api/v1/${basePath}/products`;

        /*const url = isEdit
            ? `${API_BASE_URL}/api/v1/admin/products/${productId}`
            : `${API_BASE_URL}/api/v1/admin/products`;*/
=======

        const url = isEdit
            ? `${API_BASE_URL}/api/v1/admin/products/${productId}`
            : `${API_BASE_URL}/api/v1/admin/products`;
>>>>>>> 6b8595dc1c62273c0bff306bbd6788244a439795

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

<<<<<<< HEAD
    // Click on Import button
    $('#importBtn').on('click', function (e) {
        e.preventDefault(); // stop form submit if inside a form
        console.log("Button clicked");
        $('#importFile').trigger('click');
    });

    // When file is selected
    $('#importFile').change(function () {
        let fileInput = $('#importFile')[0];
        if (fileInput.files.length === 0) {
            return;
        }

        let formData = new FormData();
        formData.append("file", fileInput.files[0]);

        const API_BASE_URL = document.querySelector('meta[name="api-base-url"]').getAttribute('content');
        const USER_ROLE = document.querySelector('meta[name="user-role"]').getAttribute('content');
        
        // 🔹 Pick base route depending on role
        const basePath = USER_ROLE === 'pharma' ? 'pharma' : 'admin';

        const url = basePath === "pharma"
            ? `${API_BASE_URL}/api/v1/${basePath}/products/products-import`
            : `${API_BASE_URL}/api/v1/${basePath}/products/products-import`;

        $.ajax({
            url: url,
            type: "POST",
            headers: {
                Authorization: "Bearer " + localStorage.getItem("auth_token")
            },
            data: formData,
            processData: false,
            contentType: false,
            success: function (res) {
                alert(res.message || "Import successful!");
                location.reload();
            },
            error: function (xhr) {
                console.error(xhr.responseText);
                alert("Import failed");
            }
        });
    });

    // Click on Export button
    $('#exportBtn').on('click', function(e) {
        e.preventDefault();

        // Build the export API URL
        const API_BASE_URL = document.querySelector('meta[name="api-base-url"]').getAttribute('content');
        const USER_ROLE = document.querySelector('meta[name="user-role"]').getAttribute('content');
        const basePath = USER_ROLE === 'pharma' ? 'pharma' : 'admin';

        // Optional: add format and filters (here format xlsx)
        let query = new URLSearchParams({
            format: 'csv'
        }).toString();

        const url = `${API_BASE_URL}/api/v1/${basePath}/products/products-export?${query}`;

        // Trigger download
        const authToken = localStorage.getItem('auth_token');

        fetch(url, {
            method: 'GET',
            headers: {
                Authorization: `Bearer ${authToken}`
            }
        })
        .then(response => {
            if (!response.ok) throw new Error('Export failed');
            return response.blob();
        })
        .then(blob => {
            const link = document.createElement('a');
            //const filename = `products_${new Date().toISOString().slice(0,19).replace(/:/g,"")}.xlsx`;
            const filename = `products_${new Date().toISOString().slice(0,19).replace(/:/g,"")}.csv`;
            link.href = window.URL.createObjectURL(blob);
            link.download = filename;
            link.click();
            window.URL.revokeObjectURL(link.href);
        })
        .catch(err => {
            console.error(err);
            alert('Failed to export products.');
        });
    });
=======
>>>>>>> 6b8595dc1c62273c0bff306bbd6788244a439795

});