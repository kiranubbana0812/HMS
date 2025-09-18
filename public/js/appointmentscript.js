$(document).ready(function () {
    const AUTH_TOKEN = localStorage.getItem('auth_token');
    const API_BASE_URL = document.querySelector('meta[name="api-base-url"]').getAttribute('content');
    let doctorAvailability = {};

    /** -------------------------
     * VIEW APPOINTMENT DETAILS
     ------------------------- */
    $('.view-btn').on('click', function () {
        const appointment = $(this).data('appointment');
        
        $('#modal-patient-id').text(appointment.patient?.patient_id || '');
        $('#modal-patient-name').text(appointment.patient?.user?.name || '');
        $('#modal-doctor-id').text(appointment.doctor?.doctor_id || '');
        $('#modal-doctor-name').text(appointment.doctor?.user?.name || '');
        $('#modal-doctor-fee').text(appointment.consultation_fee || '');
        $('#modal-department').text(appointment.doctor?.department?.name || '');
        $('#modal-appointment-date').text(appointment.appointment_date || '');
        $('#modal-appointment-time').text(appointment.appointment_time || '');
        $('#modal-appointment-status').text(appointment.status || '');

        $('#appointmentModal').modal('show');
    });

    /** -------------------------
     * OPEN "ADD APPOINTMENT" MODAL
     ------------------------- */
    $('#addAppointmentBtn').on('click', function () {
        $('#newAppointmentForm')[0].reset();
        $('#appointment_id').val('');
        $('#newAppointmentModalLabel').text('Schedule New Appointment');
        $('#doctor_id').html('<option value="">Select Doctor</option>');
        $('#time-slots').empty();
        $('#datepicker').empty();
        $('#newAppointmentModal').modal('show');
    });

    /** -------------------------
     * AUTOCOMPLETE (Patients)
     ------------------------- */
    function initAutocomplete(inputSelector, hiddenFieldSelector, apiEndpoint) {
        $(inputSelector).autocomplete({
            appendTo: "#newAppointmentModal",
            minLength: 2,
            source: function (request, response) {
                $.ajax({
                    url: `${API_BASE_URL}${apiEndpoint}`,
                    headers: { Authorization: `Bearer ${AUTH_TOKEN}` },
                    data: { q: request.term },
                    success: function (data) {
                        response($.map(data, function (item) {
                            return {
                                label: `${item.name} (${item.patient_id})`,
                                value: `${item.name} (${item.patient_id})`,
                                id: item.id
                            };
                        }));
                    },
                    error: function (xhr) {
                        console.error("Autocomplete API error:", xhr);
                        response([]);
                    }
                });
            },
            select: function (event, ui) {
                $(hiddenFieldSelector).val(ui.item.id);
                console.log(`Selected: ${ui.item.label} (ID: ${ui.item.id})`);
            }
        });
    }

    initAutocomplete("#patientSearch", "#patient_id", "/api/v1/admin/patients/search/autocomplete");

    /** -------------------------
     * CREATE / UPDATE APPOINTMENT
     ------------------------- */
    $('#newAppointmentForm').on('submit', function(e) {
        e.preventDefault();

        let appointmentId = $("#appointment_id").val();
        let url = appointmentId 
            ? `/api/v1/admin/appointments/update/${appointmentId}` 
            : "/api/v1/admin/appointments/create";
        let method = appointmentId ? "PUT" : "POST";

        $.ajax({
            url: API_BASE_URL + url,
            headers: { Authorization: `Bearer ${AUTH_TOKEN}` },
            method: method,
            data: $(this).serialize(),
            success: function(res) {
                alert('Appointment saved successfully!');
                $('#newAppointmentModal').modal('hide');
                location.reload(); // full refresh to sync data
            },
            error: function(xhr) {
                let res = xhr.responseJSON;
                let html = '';

                if (res && res.message) {
                    html = `<div class="alert alert-danger">${res.message}</div>`;
                } else if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    html = '<div class="alert alert-danger"><ul>';
                    $.each(errors, function(key, value) {
                        html += `<li>${value[0]}</li>`;
                    });
                    html += '</ul></div>';
                } else {
                    html = `<div class="alert alert-danger">Something went wrong. Please try again.</div>`;
                }
                $("#alertBox").html(html);
                $('#newAppointmentModal').modal('hide');
            }
        });
    });

    /** -------------------------
     * LOAD DOCTOR AVAILABILITY
     ------------------------- */
    function loadDoctorAvailability(doctorId) {
        $.ajax({
            url: `${API_BASE_URL}/api/v1/doctors/${doctorId}/availability`,
            headers: { Authorization: `Bearer ${AUTH_TOKEN}` },
            success: function (data) {
                doctorAvailability = data;

                $("#datepicker").datepicker("destroy").datepicker({
                    dateFormat: "yy-mm-dd",
                    showOtherMonths: true,
                    selectOtherMonths: true,
                    changeMonth: true,
                    changeYear: true,
                    beforeShowDay: function (date) {
                        let d = $.datepicker.formatDate('yy-mm-dd', date);
                        return doctorAvailability[d] 
                            ? [true, "available-date", "Available"] 
                            : [false, "unavailable-date", "Unavailable"];
                    },
                    onSelect: function (dateText) {
                        $('#appointmentDate').val(dateText);
                        showTimeSlots(dateText);
                    }
                }).css("width", "100%");
            },
            error: function (xhr) {
                console.error("Error fetching availability:", xhr);
            }
        });
    }

    function showTimeSlots(date) {
        let slots = doctorAvailability[date] || [];
        let html = "<h6>Available Slots:</h6>";

        if (slots.length === 0) {
            html += "<p>No slots available.</p>";
        } else {
            slots.forEach(time => {
                html += `<button type="button" class="btn btn-outline-primary btn-sm m-1 slot" data-time="${time}">${time}</button>`;
            });
        }
        $("#time-slots").html(html);

        $(".slot").on("click", function () {
            $(".slot").removeClass("active");
            $(this).addClass("active");

            let selectedTime = $(this).data('time');
            if (selectedTime.length === 5) selectedTime += ':00';
            $('#appointmentTime').val(selectedTime);
        });

         $(".slot").focus(function(){
            $(".slot").removeClass("active");
            $(this).addClass("active");

            let selectedTime = $(this).data('time');
            if (selectedTime.length === 5) selectedTime += ':00';
            $('#appointmentTime').val(selectedTime);
        });
    }

    /** -------------------------
     * LOAD DOCTORS BY DEPARTMENT
     ------------------------- */
    $('#appointmentDepartment').on('change', function() {
        let departmentId = $(this).val();

        if (!departmentId) {
            $('#doctor_id').html('<option value="">Select Doctor</option>');
            return;
        }

        $.ajax({
            url: `${API_BASE_URL}/api/v1/admin/departments/${departmentId}/doctors`,
            headers: { Authorization: `Bearer ${AUTH_TOKEN}` },
            type: 'GET',
            success: function(doctors) {
                let options = '<option value="">Select Doctor</option>';
                $.each(doctors, function(index, doctor) {
                    options += `<option value="${doctor.id}">${doctor.name}</option>`;
                });
                $('#doctor_id').html(options);
            },
            error: function(err) {
                console.error("Error fetching doctors:", err);
            }
        });
    });

    /** -------------------------
     * DOCTOR CHANGE = LOAD AVAILABILITY
     ------------------------- */
    $('#doctor_id').on('change', function() {
        let doctorId = $(this).val();
        if (doctorId) loadDoctorAvailability(doctorId);
    });

    /** -------------------------
     * EDIT APPOINTMENT
     ------------------------- */
    $(document).on("click", ".edit-appointment", function() {
        let appointment = $(this).data("appointment");

        $("#newAppointmentModalLabel").text("Edit Appointment");
        $("#appointment_id").val(appointment.id);

        // Set patient
        $("#patientSearch").val(`${appointment.patient.user.name} (${appointment.patient.patient_id})`);
        $("#patient_id").val(appointment.patient_id);

        // Set department & doctor, then load availability
        $("#appointmentDepartment").val(appointment.doctor.department_id).trigger("change");

        // Wait until doctors are loaded, then select the doctor and availability
        setTimeout(() => {
            $("#doctor_id").val(appointment.doctor_id);

            // Load availability for this doctor
            loadDoctorAvailability(appointment.doctor_id);

            // After availability loads, set date & time
            setTimeout(() => {
                // Set selected date in datepicker
                $("#datepicker").datepicker("setDate", appointment.appointment_date);
                $("#appointmentDate").val(appointment.appointment_date);

                // Show slots for that date
                showTimeSlots(appointment.appointment_date);

                // Select saved time slot
                setTimeout(() => {
                    $(".slot").each(function() {
                        let slotTime = $(this).data("time");
                        if (slotTime === appointment.appointment_time || slotTime + ":00" === appointment.appointment_time) {
                            $(this).addClass("active");
                            $("#appointmentTime").val(slotTime);
                        }
                    });
                }, 300);
            }, 600);
        }, 500);

        // Appointment type & notes
        $("#appointmentType").val(appointment.appointment_type);
        $("#appointmentNotes").val(appointment.notes);

        $("#newAppointmentModal").modal("show");
    });

});