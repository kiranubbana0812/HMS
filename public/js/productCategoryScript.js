$(document).ready(function () 
{
    // View Category Details
    $(document).on('click', '.view-btn', function () 
    {
        const category = $(this).data('category');

        if (!category) {
            console.error('Category data missing!', $(this));
            return;
        }

        $('#modal-name').text(category.name || '');
        $('#modal-description').text(category.description || '');
        $('#modal-status').text(category.status || 'active');

        $('#categoryModal').modal('show');
    });

      // ===== Add Category Button Click =====
    $('#addCategoryBtn').on('click', function() 
    {      
        $('#categoryForm')[0].reset();
        $('#category-id').val('');
        
        $('#statusRow').hide();
       
        $('#categoryFormModalLabel').html('<i class="fas fa-layer-group me-2"></i> Add Product Category');
        
        $('#categoryFormModal').modal('show');
    });

    // ===== Edit Category Button Click =====
    $(document).on('click', '.edit-btn', function() 
    {
        const category = $(this).data('category');
        console.log(category);
        
        $('#category-id').val(category.id);
        $('#name').val(category.name || '');
        $('#description').val(category.description || '');
        $('#status').val(category.status || 'active');
       
        $('#statusRow').show();
       
        $('#categoryFormModalLabel').html('<i class="fas fa-edit me-2"></i> Edit Product Category');
       
        $('#categoryFormModal').modal('show');
    });

    // ===== Submit Category Form =====
    $('#categoryForm').on('submit', function (e) 
    {
        e.preventDefault();

        const API_BASE_URL = document.querySelector('meta[name="api-base-url"]').getAttribute('content');
        const categoryId = $('#category-id').val();
        const isEdit = !!categoryId;

        const url = isEdit
            ? `${API_BASE_URL}/api/v1/admin/productcategories/${categoryId}` // update
            : `${API_BASE_URL}/api/v1/admin/productcategories`;             // create

        const method = isEdit ? 'PUT' : 'POST';
       
        let payload = {
            name: $('#name').val(),
            description: $('#description').val(),
        };
        
        if (isEdit) {
            payload.status = $('#status').val();
        } else {
            payload.status = 'active';
        }

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
                alert('Category saved successfully!');
                $('#categoryFormModal').modal('hide');
                location.reload();
            },
            error: function (xhr) 
            {
                let errorMsg = 'Failed to save category';
                if (xhr.responseJSON && xhr.responseJSON.errors) 
                {
                    const errors = xhr.responseJSON.errors;
                    errorMsg = Object.values(errors).flat().join('\n');
                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                }
                alert(errorMsg);
                console.error(xhr.responseText);
            }
        });
    });
});