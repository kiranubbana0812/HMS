$(document).ready(function () {
    const AUTH_TOKEN = localStorage.getItem('auth_token');                
    const API_BASE_URL = document.querySelector('meta[name="api-base-url"]').getAttribute('content');
    $('.view-btn').on('click', function () {

        const user = $(this).data('user');

        $('#modal-name').text(user.name || '');
        $('#modal-email').text(user.email || '');
        $('#modal-phone').text(user.phone || '');
        $('#modal-role').text(user.role || '');

        $('#userModal').modal('show');
    });

    // Open modal for new user
    $('#addUserBtn').on('click', function () {
        $('#userForm')[0].reset();
        $('#user-id').val('');
        $('#userFormModalLabel').text('Add User');
        $('#userFormModal').modal('show');
    });

    // Open modal for editing user
    $('.edit-btn').on('click', function () {
        const user = $(this).data('user');
        
        $('#user-id').val(user.id);
        $('#name').val(user.name || '');
        $('#email').val(user.email || '');
        $('#phone').val(user.phone || '');
        $('#role').val(user.role || '');
        
        $('#userFormModalLabel').text('Edit User');
        $('#userFormModal').modal('show');
    });

    // Submit form
    $('#userForm').on('submit', function (e) {
        e.preventDefault();
        const userId = $('#user-id').val();
        const isEdit = !!userId;
        const url = isEdit
            ? `${API_BASE_URL}/api/v1/admin/users/${userId}`
            : `${API_BASE_URL}/api/v1/admin/users`;

        let payload = {};
        const method = isEdit ? 'PUT' : 'POST';
        
        if(method == "POST") {
            payload = {
                name: $('#name').val(),
                email: $('#email').val(),
                phone: $('#phone').val(),
                role: $('#role').val(),
                password: '123456',
                password_confirmation: '123456',
            };
        }
        else {
            payload = {
                name: $('#name').val(),
                email: $('#email').val(),
                phone: $('#phone').val(),
                role: $('#role').val(),
            };
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
            success: function (response) {
                alert('User saved successfully!');
                $('#userFormModal').modal('hide');
                location.reload(); // Refresh list
            },
            error: function (xhr) {
                alert('Failed to save user');
                console.log(xhr.responseText);
                $('#userFormModal').modal('hide');
            }
        });
    });
});