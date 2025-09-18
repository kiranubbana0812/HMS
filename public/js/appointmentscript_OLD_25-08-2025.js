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
        
        $('#appointmentModal').modal('show');
    });

    // Open modal for editing patient
    $('.edit-btn').on('click', function () {
        const appointment = $(this).data('appointment');
        
        $('#patient-id').val(patient.user_id);
        $('#name').val(patient.user?.name || '');
        $('#email').val(patient.user?.email || '');
        $('#phone').val(patient.phone || '');
        $('#gender').val(patient.gender || '');
        $('#date_of_birth').val(patient.date_of_birth || '');
        $('#blood_type').val(patient.blood_type || '');
        $('#address').val(patient.address || '');

        $('#patientFormModalLabel').text('Edit Patient');
        $('#patientFormModal').modal('show');
    });

    // Open modal for new patient
    $('#addAppointmentBtn').on('click', function () {
        $('#newAppointmentForm')[0].reset();
        $('#appointment-id').val('');
        $('#appointmentFormModalLabel').text('Add Patient');
        $('#newAppointmentModal').modal('show');
    });

    const AUTH_TOKEN = localStorage.getItem('auth_token');
    const API_BASE_URL = document.querySelector('meta[name="api-base-url"]').getAttribute('content');
    
    function initAutocomplete(inputSelector, hiddenFieldSelector, apiEndpoint) {
        $(inputSelector).autocomplete({
            appendTo: "#newAppointmentModal", // modal container
            minLength: 2,
            source: function (request, response) {
                $.ajax({
                    url: `${API_BASE_URL}${apiEndpoint}`,
                    headers: { Authorization: `Bearer ${AUTH_TOKEN}` },
                    data: { q: request.term },
                    success: function (data) {
                        response($.map(data, function (item) {
                            /*if(item.department_name) {
                                return {
                                    label: item.name,
                                    value: item.name,
                                    id: item.id,
                                    department_name: item.department_name
                                };
                            }
                            else {*/
                                return {
                                    label: item.name + " (" + item.patient_id + ")",
                                    value: item.name + " (" + item.patient_id + ")",
                                    id: item.id
                                };
                            //}
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
                //$("#department").val(ui.item.department_name || ""); // Auto-fill department
                console.log(`Selected: ${ui.item.label} (ID: ${ui.item.id})`);
                //loadDoctorAvailability(ui.item.id);
            }
        });
    }
    
    // Initialize both autocompletes
    //initAutocomplete("#doctorSearch", "#doctor_id", "/api/v1/admin/doctors/search/autocomplete");
    initAutocomplete("#patientSearch", "#patient_id", "/api/v1/admin/patients/search/autocomplete");

    // Submit Form with AJAX
    $('#newAppointmentForm').on('submit', function(e) {
        e.preventDefault();
        let appointmentId = $("#appointment_id").val();
        let url = appointmentId 
            ? "/api/v1/admin/appointments/update/" + appointmentId   // edit
            : "/api/v1/admin/appointments/create";                   // create
        let method = appointmentId ? "PUT" : "POST";
        
        $.ajax({
            url: API_BASE_URL + url,
            headers: { Authorization: `Bearer ${AUTH_TOKEN}` },
            method: method,
            data: $(this).serialize(),
            success: function(res) {
                $('#newAppointmentModal').modal('hide'); // close modal
                //alert('Appointment Added Successfully! BOW BOW::' + res);

                // Refresh grid
                $("#appointmentsTable tbody").load(location.href + " #appointmentsTable tbody>*", "");
            },
            error: function(xhr) {
                let res = xhr.responseJSON;

                if (res && res.message) {
                    $('#newAppointmentModal').modal('hide'); // close modal
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

    
    function loadDoctorAvailability(doctorId) {
		$.ajax({
			url: `${API_BASE_URL}/api/v1/doctors/${doctorId}/availability`,
			headers: { Authorization: `Bearer ${AUTH_TOKEN}` },
			success: function (data) {
				doctorAvailability = data;

				$("#datepicker").datepicker("destroy").datepicker({
					dateFormat: "yy-mm-dd",
					beforeShowDay: function (date) {
						let d = $.datepicker.formatDate('yy-mm-dd', date);
						if (doctorAvailability[d]) {
							return [true, "available-date", "Available"];
						} else {
							return [false, "unavailable-date", "Unavailable"];
						}
					},
					onSelect: function (dateText) {
					    console.log("Selected Date Slot:", dateText);
					    $('#appointmentDate').val(dateText);
						showTimeSlots(dateText);
					}
				});
			},
			error: function (xhr) {
				console.error("Error fetching availability:", xhr);
			}
		});
	}

	function showTimeSlots(date) {
		let slots = doctorAvailability[date] || [];
		let html = "<h5>Available Slots for " + date + ":</h5>";
		if (slots.length === 0) {
			html += "<p>No slots available.</p>";
		} else {
			slots.forEach(time => {
				html += `<div class="slot" data-time="${time}">${time}</div>`;
			});
		}
		$("#time-slots").html(html);

		// Add click event for highlighting
		$(".slot").on("click", function () {
			$(".slot").removeClass("selected");
			$(this).addClass("selected");
			let selectedTime = $(this).data('time');
			if (selectedTime.length === 5) { // e.g. 14:30
                selectedTime += ':00';
            }
            $('#appointmentTime').val(selectedTime);
			//$('#appointmentTime').val($(this).data("time"));
			console.log("Selected Time Slot:", $(this).data("time"));
		});
	}
	
	$('#appointmentDepartment').on('change', function() {
	    
        let departmentId = $(this).val();

        if (!departmentId) {
            $('#doctor_id').html('<option value="">Select Doctor</option>');
            return;
        }

        $.ajax({
                url: API_BASE_URL+'/api/v1/admin/departments/' + departmentId + '/doctors',
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
    
    $('#doctor_id').on('change', function() {
        let doctor_id = $(this).val();

        loadDoctorAvailability(doctor_id);
    });
    
    $(document).on("click", ".edit-appointment", function() {
        let appointment = $(this).data("appointment");
        openEditAppointmentModal(appointment);
    });
    
    function openEditAppointmentModal(appointment) {
        $("#newAppointmentModalLabel").text("Edit Appointment");

        // fill form with existing data
        $("#appointment_id").val(appointment.id);
        $("#patient_id").val(appointment.patient_id);
        $("#appointmentDepartment").val(appointment.department_id).trigger("change");
        $("#doctor_id").val(appointment.doctor_id);
        $("#appointmentDate").val(appointment.appointment_date);
        $("#appointmentTime").val(appointment.appointment_time);
        $("#appointmentType").val(appointment.appointment_type);
        $("#appointmentNotes").val(appointment.notes);

        $("#newAppointmentModal").modal("show");
    }
});
