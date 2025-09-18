$(document).ready(function () {
    $('.view-btn').on('click', function () {
        
        const appointment = $(this).data('appointment');
        
        $('#modal-patient-id').text(appointment.patient?.patient_id || '');
        $('#modal-patient-name').text(appointment.patient.user?.name || '');
        $('#modal-doctor-id').text(appointment.doctor?.doctor_id || '');
        $('#modal-doctor-name').text(appointment.doctor.user?.name || '');
        $('#modal-doctor-fee').text(appointment.consultation_fee || '');
        $('#modal-department').text(appointment.doctor.department?.name || '');
        $('#modal-appointment-date').text(appointment.appointment_date || '');
        $('#modal-appointment-time').text(appointment.appointment_time || '');
        $('#modal-appointment-status').text(appointment.status || '');
        $('#modal-appointment-notes').text(appointment.notes || '');
        
        $('#appointmentModal').modal('show');
    });

    const AUTH_TOKEN = localStorage.getItem('auth_token');
    const API_BASE_URL = document.querySelector('meta[name="api-base-url"]').getAttribute('content');
    
    $(document).on("click", ".edit-appointment", function() {
        let appointment = $(this).data("appointment");
        openEditAppointmentModal(appointment);
    });
    
    function openEditAppointmentModal(appointment) {
        $("#newAppointmentModalLabel").text("Edit Appointment");

        // fill form with existing data
        $("#modal-appointment-id-val").val(appointment.id);
        $("#modal-edit-patient-id").text(appointment.patient.patient_id);
        $("#modal-patient-id-val").val(appointment.patient_id);
        $('#modal-edit-patient-name').text(appointment.patient.user?.name || '');
        $('#modal-edit-doctor-id').text(appointment.doctor?.doctor_id || '');
        $('#modal-doctor-id-val').val(appointment.doctor_id);
        $('#modal-edit-doctor-name').text(appointment.doctor.user?.name || '');
        $("#modal-edit-department").text(appointment.doctor.department.name);
        $("#modal-edit-doctor-fee").text(appointment.doctor?.consultation_fee || '');
        $("#modal-edit-appointment-date").text(appointment.appointment_date);
        $("#modal-appointment-date-val").val(appointment.appointment_date);
        $("#modal-edit-appointment-time").text(appointment.appointment_time);
        $("#modal-appointment-time-val").val(appointment.appointment_time);
        $("#modal-edit-appointment-type").text(appointment.appointment_type);
        $("#appointmentNotes").text(appointment.notes);
        $('#modal-appointment-status-val').val(appointment.status);

        $("#editAppointmentModalLabel").modal("show");
    }
    
    // Submit Update Form with AJAX
    $('#updateAppointmentForm').on('submit', function(e) {
        e.preventDefault();
        let appointmentId = $("#modal-appointment-id-val").val();
        
        let url = "/api/v1/admin/appointments/update/" + appointmentId;
        let method = "PUT";
        
        $.ajax({
            url: API_BASE_URL + url,
            headers: { Authorization: `Bearer ${AUTH_TOKEN}` },
            method: method,
            data: $(this).serialize(),
            success: function(res) {
                $('#editAppointmentModalLabel').modal('hide'); // close modal
                
                alert("Appointment updataed successfully");
                // Refresh grid
                //$(".appointmentsTable tbody").load(location.href + " #appointmentsTable tbody>*", "");
                $(".appointmentsTable tbody").load(location.href + " .appointmentsTable tbody>*");

            },
            error: function(xhr) {
                let res = xhr.responseJSON;

                if (res && res.message) {
                    $('#editAppointmentModalLabel').modal('hide'); // close modal
                    // your custom error from controller
                    $("#alertBox").html(
                        `<div class="alert alert-danger">${res.message}</div>`
                    );
                } else if (xhr.status === 422) {
                    // Laravel validation errors
                    let errors = xhr.responseJSON.errors;
                    let html = '<div class="alert alert-danger"><ul>';
                    $.each(errors, function(key, value) {
                        html += `<li>${value[0]}</li>`;
                    });
                    html += '</ul></div>';
                    $("#alertBox").html(html);
                } else {
                    $("#alertBox").html(
                        `<div class="alert alert-danger">Something went wrong. Please try again.</div>`
                    );
                }
            }
        });
    });
});
