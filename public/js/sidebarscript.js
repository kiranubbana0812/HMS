// Sidebar toggle functionality
document.addEventListener('DOMContentLoaded', function() {
     const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('mainContent');

    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function () {
            sidebar.classList.toggle('sidebar-collapsed');
            mainContent.classList.toggle('main-content-expanded');
        });
    }

    // Add active class to current page navigation
    // const currentPage = window.location.pathname.split('/').pop() || 'index.html';
    // const navLinks = document.querySelectorAll('.sidebar .nav-link');
    
    // navLinks.forEach(link => {
    //     const href = link.getAttribute('href');
    //     if (href === currentPage) {
    //         link.classList.add('active');
    //     } else {
    //         link.classList.remove('active');
    //     }
    // });

    const currentPath = window.location.pathname;
    const navLinks = document.querySelectorAll('.sidebar .nav-link');

    navLinks.forEach(link => {
        const href = link.getAttribute('href');
        if (currentPath.startsWith(href)) {
            link.classList.add('active');
        } else {
            link.classList.remove('active');
        }
    });

    // Search functionality
    const searchInput = document.querySelector('.search-bar input');
    if (searchInput) {
        searchInput.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            // Add search functionality here based on current page
            console.log('Searching for:', searchTerm);
        });
    }

    // Notification click handlers
    const notificationIcons = document.querySelectorAll('.notification-icon');
    notificationIcons.forEach(icon => {
        icon.addEventListener('click', function() {
            // Add notification handling here
            console.log('Notification clicked');
        });
    });

    // Settings icon click handler
    const settingsIcon = document.querySelector('.settings-icon');
    if (settingsIcon) {
        settingsIcon.addEventListener('click', function() {
            // Add settings handling here
            console.log('Settings clicked');
        });
    }

    // Language dropdown click handler
    const languageDropdown = document.querySelector('.language-dropdown');
    if (languageDropdown) {
        languageDropdown.addEventListener('click', function() {
            // Add language selection handling here
            console.log('Language dropdown clicked');
        });
    }

    // User profile click handler
    const userProfile = document.querySelector('.user-profile');
    if (userProfile) {
        userProfile.addEventListener('click', function() {
            // Add user profile handling here
            console.log('User profile clicked');
        });
    }

    // Card hover effects
    const dashboardCards = document.querySelectorAll('.dashboard-card');
    dashboardCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });

    // Button click handlers
    /*const actionButtons = document.querySelectorAll('.action-buttons .btn');
    actionButtons.forEach(button => {
        button.addEventListener('click', function() {
            const buttonText = this.textContent.trim();
            console.log('Action button clicked:', buttonText);
            // Add specific button handling here
        });
    });*/

    // Table action buttons
    /*const tableActionButtons = document.querySelectorAll('table .btn');
    tableActionButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const action = this.querySelector('i').className;
            console.log('Table action clicked:', action);
            // Add specific table action handling here
        });
    });*/
});

// Responsive sidebar handling
window.addEventListener('resize', function() {
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('mainContent');
    
    if (window.innerWidth <= 768) {
        sidebar.classList.add('sidebar-mobile');
        mainContent.classList.add('main-content-mobile');
    } else {
        sidebar.classList.remove('sidebar-mobile');
        mainContent.classList.remove('main-content-mobile');
    }
});

// Form submission handlers
document.addEventListener('DOMContentLoaded', function() {
    // Register form handler
    const registerForm = document.getElementById('registerForm');
    if (registerForm) {
        registerForm.addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Patient registered successfully!');
            bootstrap.Modal.getInstance(document.getElementById('registerModal')).hide();
        });
    }

    // Add Patient form handler
    const addPatientForm = document.getElementById('addPatientForm');
    if (addPatientForm) {
        addPatientForm.addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Patient added successfully!');
            bootstrap.Modal.getInstance(document.getElementById('addPatientModal')).hide();
        });
    }

    // Add Appointment form handler
    const addAppointmentForm = document.getElementById('addAppointmentForm');
    /*if (addAppointmentForm) {
        addAppointmentForm.addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Appointment scheduled successfully!');
            bootstrap.Modal.getInstance(document.getElementById('addAppointmentModal')).hide();
        });
    }

    // New Appointment form handler
    const newAppointmentForm = document.getElementById('newAppointmentForm');
    if (newAppointmentForm) {
        newAppointmentForm.addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Appointment scheduled successfully!');
            bootstrap.Modal.getInstance(document.getElementById('newAppointmentModal')).hide();
        });
    }*/

    // Add Doctor form handler
    const addDoctorForm = document.getElementById('addDoctorForm');
    if (addDoctorForm) {
        addDoctorForm.addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Doctor added successfully!');
            bootstrap.Modal.getInstance(document.getElementById('addDoctorModal')).hide();
        });
    }

    // Schedule form handler
    const scheduleForm = document.getElementById('scheduleForm');
    if (scheduleForm) {
        scheduleForm.addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Schedule saved successfully!');
            bootstrap.Modal.getInstance(document.getElementById('scheduleModal')).hide();
        });
    }

    // Generate Report form handler
    const generateReportForm = document.getElementById('generateReportForm');
    if (generateReportForm) {
        generateReportForm.addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Report generated successfully!');
            bootstrap.Modal.getInstance(document.getElementById('generateReportModal')).hide();
        });
    }

    // Create Invoice form handler
    const createInvoiceForm = document.getElementById('createInvoiceForm');
    if (createInvoiceForm) {
        createInvoiceForm.addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Invoice created successfully!');
            bootstrap.Modal.getInstance(document.getElementById('createInvoiceModal')).hide();
        });
    }

    // New Ticket form handler
    const newTicketForm = document.getElementById('newTicketForm');
    if (newTicketForm) {
        newTicketForm.addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Support ticket created successfully!');
            bootstrap.Modal.getInstance(document.getElementById('newTicketModal')).hide();
        });
    }
});

// Export functions
function exportPatients() {
    alert('Exporting patients data...');
}

function exportAllReports() {
    alert('Exporting all reports...');
}

function exportBilling() {
    alert('Exporting billing data...');
}

// Invoice calculation functions
function addServiceItem() {
    const serviceItems = document.getElementById('serviceItems');
    const newItem = document.querySelector('.service-item').cloneNode(true);
    
    // Clear the values in the cloned item
    newItem.querySelectorAll('select, input').forEach(input => {
        if (input.type !== 'number' || !input.classList.contains('quantity-input')) {
            input.value = '';
        }
    });
    
    serviceItems.appendChild(newItem);
    attachServiceItemListeners(newItem);
}

function removeServiceItem() {
    const serviceItems = document.getElementById('serviceItems');
    if (serviceItems.children.length > 1) {
        serviceItems.removeChild(serviceItems.lastElementChild);
        calculateTotal();
    }
}

function attachServiceItemListeners(item) {
    const serviceSelect = item.querySelector('.service-select');
    const quantityInput = item.querySelector('.quantity-input');
    const rateInput = item.querySelector('.rate-input');
    const amountInput = item.querySelector('.amount-input');

    serviceSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const price = selectedOption.getAttribute('data-price');
        if (price) {
            rateInput.value = price;
            calculateItemAmount(item);
        }
    });

    quantityInput.addEventListener('input', () => calculateItemAmount(item));
    rateInput.addEventListener('input', () => calculateItemAmount(item));
}

function calculateItemAmount(item) {
    const quantity = parseFloat(item.querySelector('.quantity-input').value) || 0;
    const rate = parseFloat(item.querySelector('.rate-input').value) || 0;
    const amount = quantity * rate;
    item.querySelector('.amount-input').value = amount.toFixed(2);
    calculateTotal();
}

function calculateTotal() {
    const serviceItems = document.querySelectorAll('.service-item');
    let subtotal = 0;
    
    serviceItems.forEach(item => {
        const amount = parseFloat(item.querySelector('.amount-input').value) || 0;
        subtotal += amount;
    });
    
    const discount = parseFloat(document.getElementById('discount').value) || 0;
    const tax = parseFloat(document.getElementById('tax').value) || 0;
    
    const discountAmount = (subtotal * discount) / 100;
    const taxableAmount = subtotal - discountAmount;
    const taxAmount = (taxableAmount * tax) / 100;
    const total = taxableAmount + taxAmount;
    
    document.getElementById('totalAmount').value = total.toFixed(2);
}

// Initialize service item listeners on page load
document.addEventListener('DOMContentLoaded', function() {
    const serviceItems = document.querySelectorAll('.service-item');
    serviceItems.forEach(item => attachServiceItemListeners(item));
    
    // Add listeners for discount and tax changes
    const discountInput = document.getElementById('discount');
    const taxInput = document.getElementById('tax');
    
    if (discountInput) discountInput.addEventListener('input', calculateTotal);
    if (taxInput) taxInput.addEventListener('input', calculateTotal);
});

// Filter functions
function clearFilters() {
    document.getElementById('filterForm').reset();
}

function applyFilters() {
    alert('Filters applied successfully!');
    bootstrap.Modal.getInstance(document.getElementById('filterModal')).hide();
}
// Initialize responsive handling
window.dispatchEvent(new Event('resize'));

// Dashboard JavaScript Functions

// Form Handling Functions
function handlePatientForm() {
    const form = document.getElementById('addPatientForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(form);
            const patientData = {
                firstName: formData.get('patientFirstName') || document.getElementById('patientFirstName').value,
                lastName: formData.get('patientLastName') || document.getElementById('patientLastName').value,
                email: document.getElementById('patientEmail').value,
                phone: document.getElementById('patientPhone').value,
                age: document.getElementById('patientAge').value,
                gender: document.getElementById('patientGender').value,
                bloodGroup: document.getElementById('patientBloodGroup').value,
                emergencyContact: document.getElementById('emergencyContact').value,
                emergencyPhone: document.getElementById('emergencyPhone').value,
                address: document.getElementById('patientAddress').value,
                medicalHistory: document.getElementById('patientMedicalHistory').value,
                insuranceInfo: document.getElementById('insuranceInfo').value
            };
            
            // Save patient data
            savePatient(patientData);
            
            // Close modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('addPatientModal'));
            modal.hide();
            
            // Reset form
            form.reset();
            
            // Show success message
            showNotification('Patient added successfully!', 'success');
        });
    }
}

function handleAppointmentForm() {
    const form = document.getElementById('newAppointmentForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const appointmentData = {
                patient: document.getElementById('appointmentPatient').value,
                doctor: document.getElementById('appointmentDoctor').value,
                date: document.getElementById('appointmentDate2').value,
                time: document.getElementById('appointmentTime2').value,
                department: document.getElementById('appointmentDepartment').value,
                type: document.getElementById('appointmentType').value,
                notes: document.getElementById('appointmentNotes').value,
                priority: document.getElementById('appointmentPriority').value,
                duration: document.getElementById('appointmentDuration').value
            };
            
            // Save appointment data
            saveAppointment(appointmentData);
            
            // Close modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('newAppointmentModal'));
            modal.hide();
            
            // Reset form
            form.reset();
            
            // Show success message
            showNotification('Appointment scheduled successfully!', 'success');
        });
    }
}

// Data Management Functions
function savePatient(patientData) {
    // Get existing patients from localStorage
    let patients = JSON.parse(localStorage.getItem('patients') || '[]');
    
    // Add new patient with ID
    const newPatient = {
        id: 'P' + String(patients.length + 1).padStart(3, '0'),
        ...patientData,
        createdAt: new Date().toISOString(),
        status: 'Active'
    };
    
    patients.push(newPatient);
    
    // Save to localStorage
    localStorage.setItem('patients', JSON.stringify(patients));
    
    // Refresh patient table
    loadPatients();
}

function saveAppointment(appointmentData) {
    // Get existing appointments from localStorage
    let appointments = JSON.parse(localStorage.getItem('appointments') || '[]');
    
    // Add new appointment with ID
    const newAppointment = {
        id: 'A' + String(appointments.length + 1).padStart(3, '0'),
        ...appointmentData,
        createdAt: new Date().toISOString(),
        status: 'Scheduled'
    };
    
    appointments.push(newAppointment);
    
    // Save to localStorage
    localStorage.setItem('appointments', JSON.stringify(appointments));
    
    // Refresh appointment table
    loadAppointments();
}

// UI Functions
function showNotification(message, type = 'info') {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
    notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    notification.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    // Add to page
    document.body.appendChild(notification);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        if (notification.parentNode) {
            notification.remove();
        }
    }, 5000);
}

function loadPatients() {
    const patients = JSON.parse(localStorage.getItem('patients') || '[]');
    const tbody = document.querySelector('#patientsTable tbody');
    
    if (tbody) {
        tbody.innerHTML = '';
        
        patients.forEach(patient => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>#${patient.id}</td>
                <td>
                    <div class="d-flex align-items-center">
                        <img src="https://images.pexels.com/photos/1239291/pexels-photo-1239291.jpeg?auto=compress&cs=tinysrgb&w=40&h=40&fit=crop" class="rounded-circle me-2" width="40" height="40">
                        ${patient.firstName} ${patient.lastName}
                    </div>
                </td>
                <td>${patient.age}</td>
                <td>${patient.gender}</td>
                <td>${patient.phone}</td>
                <td><span class="badge bg-success">${patient.status}</span></td>
                <td>
                    <button class="btn btn-sm btn-outline-primary me-1" onclick="viewPatient('${patient.id}')">
                        <i class="fas fa-eye"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-warning me-1" onclick="editPatient('${patient.id}')">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-danger" onclick="deletePatient('${patient.id}')">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            `;
            tbody.appendChild(row);
        });
    }
}

function loadAppointments() {
    const appointments = JSON.parse(localStorage.getItem('appointments') || '[]');
    const tbody = document.querySelector('#appointmentsTable tbody');
    
    if (tbody) {
        tbody.innerHTML = '';
        
        appointments.forEach(appointment => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${appointment.time}</td>
                <td>${appointment.patient}</td>
                <td>${appointment.doctor}</td>
                <td>${appointment.department}</td>
                <td>${appointment.type}</td>
                <td><span class="badge bg-primary">${appointment.status}</span></td>
                <td>
                    <button class="btn btn-sm btn-outline-primary me-1" onclick="viewAppointment('${appointment.id}')">
                        <i class="fas fa-eye"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-warning me-1" onclick="editAppointment('${appointment.id}')">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-danger" onclick="deleteAppointment('${appointment.id}')">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            `;
            tbody.appendChild(row);
        });
    }
}

// Export Functions
function exportPatients() {
    const patients = JSON.parse(localStorage.getItem('patients') || '[]');
    const csvContent = convertToCSV(patients);
    downloadCSV(csvContent, 'patients.csv');
    showNotification('Patients exported successfully!', 'success');
}

function exportAppointments() {
    const appointments = JSON.parse(localStorage.getItem('appointments') || '[]');
    const csvContent = convertToCSV(appointments);
    downloadCSV(csvContent, 'appointments.csv');
    showNotification('Appointments exported successfully!', 'success');
}

function convertToCSV(data) {
    if (data.length === 0) return '';
    
    const headers = Object.keys(data[0]);
    const csvRows = [headers.join(',')];
    
    data.forEach(row => {
        const values = headers.map(header => {
            const value = row[header];
            return `"${value}"`;
        });
        csvRows.push(values.join(','));
    });
    
    return csvRows.join('\n');
}

function downloadCSV(content, filename) {
    const blob = new Blob([content], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = filename;
    a.click();
    window.URL.revokeObjectURL(url);
}

// Sidebar Toggle Function
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('mainContent');
    
    if (sidebar && mainContent) {
        sidebar.classList.toggle('collapsed');
        mainContent.classList.toggle('expanded');
    }
}

// Search Function
function searchTable(tableId, searchTerm) {
    const table = document.getElementById(tableId);
    const rows = table.querySelectorAll('tbody tr');
    
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        const match = text.includes(searchTerm.toLowerCase());
        row.style.display = match ? '' : 'none';
    });
}

// Initialize all functions when page loads
document.addEventListener('DOMContentLoaded', function() {
    // Initialize form handlers
    handlePatientForm();
    //handleAppointmentForm();
    
    // Load existing data
    loadPatients();
    loadAppointments();
    
    // Initialize sidebar toggle
    const sidebarToggle = document.getElementById('sidebarToggle');
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', toggleSidebar);
    }
    
    // Initialize search functionality
    const searchInputs = document.querySelectorAll('.search-input');
    searchInputs.forEach(input => {
        input.addEventListener('input', function() {
            const tableId = this.getAttribute('data-table');
            if (tableId) {
                searchTable(tableId, this.value);
            }
        });
    });
});

// Utility Functions
function formatDate(date) {
    return new Date(date).toLocaleDateString();
}

function formatTime(time) {
    return new Date(`2000-01-01T${time}`).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
}

function generateId(prefix) {
    return prefix + Date.now().toString(36) + Math.random().toString(36).substr(2);
}

// Error handling
function handleError(error, context) {
    console.error(`Error in ${context}:`, error);
    showNotification(`An error occurred: ${error.message}`, 'danger');
}

// Data validation
function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

function validatePhone(phone) {
    const re = /^[\+]?[1-9][\d]{0,15}$/;
    return re.test(phone.replace(/\s/g, ''));
}
