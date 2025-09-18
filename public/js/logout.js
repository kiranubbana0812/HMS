$(document).ready(function () {
    // 🔴 LOGOUT handler
    $('#logout-btn').on('click', function () {
            //alert('Logout clicked');
        const token = localStorage.getItem('auth_token');

        if (!token) {
            window.location.href = "/login";
            return;
        }

		const AUTH_TOKEN = localStorage.getItem('auth_token');
		const API_BASE_URL = document.querySelector('meta[name="api-base-url"]').getAttribute('content');
		const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
		const LOGOUT_ROUTE = document.querySelector('meta[name="logout-route"]').getAttribute('content');
		
		
        // 1. Call API to logout
        $.ajax({
            url: API_BASE_URL + '/api/v1/admin/logout', // update if needed
            method: 'POST',
            headers: {
                'Authorization': 'Bearer ' + token
            },
            success: function () {
                // 2. Clear Laravel session
                $.post(LOGOUT_ROUTE, {
                    _token: CSRF_TOKEN
                }, function () {
                    // 3. Clear local storage and redirect
                    localStorage.removeItem('auth_token');
                    window.location.href = "/login";
                });
            },
            error: function () {
                alert("Logout failed at API.");
            }
        });
    });
});
