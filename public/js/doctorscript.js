$(document).ready(function () {
      const API_BASE_URL = document.querySelector('meta[name="api-base-url"]').getAttribute('content');
    const AUTH_TOKEN = localStorage.getItem('auth_token');

    // View Doctor Details
    $('.view-btn').on('click', function () {
        const doctor = $(this).data('doctor');

       console.log("Doctor",doctor);

        $('#modal-doctor-id').text(doctor.doctor_id || '');
        $('#modal-name').text(doctor.user.name || '');
        $('#modal-department').text(doctor.department.name || '');
        $('#modal-experience').text(doctor.experience || '');
        $('#modal-consultaion-fee').text(doctor.consultation_fee || '');
        $('#modal-specialization').text(doctor.specialization || '');
        $('#modal-image').attr('src', doctor.user?.image || '/default-profile.png');
        if (doctor.availabilities?.length > 0) {
            let html = '<table class="table text-center"><thead><tr><th>Day</th><th>Start</th><th>End</th></tr></thead><tbody>';
            doctor.availabilities.forEach(slot => {
                html += `<tr>
                    <td>${slot.days_of_week}</td>
                    <td>${slot.start_time}</td>
                    <td>${slot.end_time}</td>
                </tr>`;
            });
            html += '</tbody></table>';
            $('#modal-availability-grid').html(html);
        } else {
            $('#modal-availability-grid').html('<p>No availability data.</p>');
        }

        $('#doctorModal').modal('show');
    });

    // Reset form on modal close
    $('#addDoctorModal').on('hidden.bs.modal', function () {
        $('#addDoctorForm')[0].reset();
        $('#id').val('');
        $('#user_id').val('');
        $('#addDoctorModalLabel').text('Add Doctor');
        $('#addDoctorForm button[type="submit"]').text('Add Doctor');
        $('#availability-wrapper').empty();
        addAvailabilitySlot(); // default slot
         $('#passwordLabel').show();
         $('#conformpasswordLabel').show();         
        $('#password, #password_confirmation').attr('required', true);
        $('#email').attr('required', true);
   
       
    });

    // Populate form on Edit
    $('.edit-btn').on('click', function () {
    const doctor = $(this).data('doctor');

    $('#id').val(doctor.id);
    $('#user_id').val(doctor.user.id);
    $('#name').val(doctor.user.name);
    $('#email').val(doctor.user.email);
    $('#phone').val(doctor.user.phone);
    $('#specialization').val(doctor.specialization);
    $('#experience').val(doctor.experience);
    $('#consultation_fee').val(doctor.consultation_fee);
    $('#department_id').val(doctor.department_id);


    $('#passwordLabel').hide();
    $('#conformpasswordLabel').hide(); 
    $('#availability-wrapper').empty();
    slotIndex = 0;
    if (doctor.availabilities?.length > 0) {
        doctor.availabilities.forEach(slot => {
            addAvailabilitySlot({
              
                days_of_week: slot.days_of_week,
                start_time: slot.start_time?.slice(0, 5),
                end_time: slot.end_time?.slice(0, 5)
            });
        });
    } else {
        addAvailabilitySlot();
    }

    $('#addDoctorModalLabel').text('Edit Doctor');
    $('#addDoctorForm button[type="submit"]').text('Update Doctor');
    $('#addDoctorModal').modal('show');
});




    // Submit form (Add or Edit)
    $('#addDoctorForm').on('submit', function (e) {
        e.preventDefault();

        const isEdit = !!$('#id').val();
        const url = isEdit
            ? `${API_BASE_URL}/api/v1/admin/doctor/update/${$('#id').val()}`
            : `${API_BASE_URL}/api/v1/admin/doctor/register`;

        const method = isEdit ? 'PUT' : 'POST';

        const formData = {
            user_id: $('#user_id').val(),
            name: $('#name').val(),
            email: $('#email').val(),
            phone: $('#phone').val(),
            password: $('#password').val(),
            password_confirmation: $('#password_confirmation').val(),
            department_id: $('#department_id').val(),
            specialization: $('#specialization').val(),
            experience: $('#experience').val(),
            consultation_fee: $('#consultation_fee').val(),
            availability: []
        };

        $('.availability-slot').each(function () {
            formData.availability.push({
                id: $(this).find('[name$="[id]"]').val(),
                days_of_week: $(this).find('[name$="[days_of_week]"]').val(),
                start_time: $(this).find('[name$="[start_time]"]').val() + ':00',
                end_time: $(this).find('[name$="[end_time]"]').val() + ':00',
            });
        });

        // Send AJAX
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
                console.log("res",res);
                $('#addDoctorModal').modal('hide');
                $('#addDoctorForm')[0].reset();
                $('#alertBox').html(`<div class="alert alert-success">${isEdit ? 'Doctor updated' : 'Doctor added'} successfully.</div>`);
                setTimeout(() => location.reload(), 1000);
            },
            error: function (xhr) {
                console.error("Error:", xhr.responseText);
                const message = xhr.responseJSON?.message || 'Something went wrong.';
                $('#alertBox').html(`<div class="alert alert-danger">${message}</div>`);
            }
        });
    });
});
