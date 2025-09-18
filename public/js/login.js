//$(document).ready(function () {
document.addEventListener("DOMContentLoaded", function () {
	//const API_BASE_URL = "{{ config('services.api.base_url') }}";
    //const SESSION_ROUTE = "{{ route('session.store') }}";
    //const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    $('#login-form').on('submit', function (e) {
	    e.preventDefault();

	    let email = $('#username').val().trim();
	    let password = $('#password').val().trim();
	    let isValid = true;

	    $('.error').remove();

	    // Email validation
	    if (email === '') {
	        $('#username').after('<div class="error" style="color:red;">Email is required.</div>');
	        isValid = false;
	    } else if (!validateEmail(email)) {
	        $('#username').after('<div class="error" style="color:red;">Invalid email format.</div>');
	        isValid = false;
	        $('#username').addClass('invalid');
	    } else {
	        $('#username').removeClass('invalid');
	    }

	    // Password validation
	    if (password === '') {
	        $('#password').after('<div class="error" style="color:red;">Password is required.</div>');
	        isValid = false;
	    } else if (password.length < 6) {
	        $('#password').after('<div class="error" style="color:red;">Password must be at least 6 characters.</div>');
	        isValid = false;
	        $('#password').addClass('invalid');
	    } else {
	        $('#password').removeClass('invalid');
	    }

	    if (!isValid) return;

	    // AJAX login
	    $.ajax({
	        url: API_BASE_URL + '/api/v1/admin/login',
	        method: 'POST',
	        data: {
	            email: email,
	            password: password,
	        },
	        success: function (response) {
	            console.log("USER DETAILS:::", response.token);
	            localStorage.setItem('auth_token', response.token);

	            let userPayload = null;
	            let redirectUrl = "/";

	            // Case 1: doctor login
	            if (response.doctor) {
	                let doctor = response.doctor;
	                let user   = doctor.user;

	                // attach doctor details into user object
	                user.doctor = {
	                    id: doctor.id,
	                    doctor_id: doctor.doctor_id,
	                    department_id: doctor.department_id,
	                    specialization: doctor.specialization,
	                    availability: doctor.availability,
	                    experience: doctor.experience,
	                    consultation_fee: doctor.consultation_fee,
	                    department: doctor.department || null,
	                    availabilities: doctor.availabilities || []
	                };

	                userPayload = user;
	            }
	            // Case 2: admin/frontdesk/superadmin
	            else if (response.user) {
	                userPayload = response.user;
	            }

	            if (userPayload) {
	                // Decide redirect based on role
	                switch (userPayload.role) {
	                    case "frontdesk":
	                        redirectUrl = "/frontdesk/dashboard";
	                        break;
	                    case "doctor":
	                        redirectUrl = "/doctorsinfo";
	                        break;
	                    case "admin":
	                        redirectUrl = "/admin/dashboard";
	                        break;
	                    case "superadmin":
	                        redirectUrl = "/superadmin/dashboard";
	                        break;
<<<<<<< HEAD
	                    case "pharma":
	                        redirectUrl = "/pharma/dashboard";
	                        break;
=======
>>>>>>> 6b8595dc1c62273c0bff306bbd6788244a439795
	                }

	                // Store session in Laravel
	                $.ajax({
	                    url: SESSION_ROUTE,
	                    method: "POST",
	                    headers: {
	                        'X-CSRF-TOKEN': CSRF_TOKEN
	                    },
	                    data: {
	                        user: userPayload,
	                        login_token: response.token,
	                        role: userPayload.role
	                    },
	                    success: function () {
	                        window.location.href = redirectUrl;
	                    },
	                    error: function (xhr) {
	                        console.error("Store session failed:", xhr.responseText);
	                        $('#login-form').prepend('<p class="error" style="color:red;">Session store failed</p>');
	                    }
	                });
	            } else {
	                alert("Invalid login response.");
	            }
	        },
	        error: function () {
	            $('#login-form').prepend('<p class="error" style="color:red;">Login failed</p>');
	        }
	    });
	});

    function validateEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email.toLowerCase());
    }
});
