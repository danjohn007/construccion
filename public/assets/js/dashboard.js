// Dashboard JavaScript functionality

document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Auto-hide alerts after 5 seconds
    setTimeout(function() {
        var alerts = document.querySelectorAll('.alert:not(.alert-permanent)');
        alerts.forEach(function(alert) {
            var bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 5000);

    // Mobile sidebar toggle
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.querySelector('.sidebar');
    
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('show');
        });
    }

    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', function(event) {
        if (window.innerWidth <= 768) {
            if (!sidebar.contains(event.target) && !sidebarToggle.contains(event.target)) {
                sidebar.classList.remove('show');
            }
        }
    });

    // Form validation
    const forms = document.querySelectorAll('.needs-validation');
    forms.forEach(function(form) {
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        });
    });

    // Currency formatting for input fields
    const currencyInputs = document.querySelectorAll('.currency-input');
    currencyInputs.forEach(function(input) {
        input.addEventListener('blur', function() {
            const value = parseFloat(this.value);
            if (!isNaN(value)) {
                this.value = value.toFixed(2);
            }
        });
    });

    // Percentage formatting for input fields
    const percentageInputs = document.querySelectorAll('.percentage-input');
    percentageInputs.forEach(function(input) {
        input.addEventListener('blur', function() {
            const value = parseFloat(this.value);
            if (!isNaN(value)) {
                this.value = Math.min(100, Math.max(0, value)).toFixed(2);
            }
        });
    });

    // Confirm delete actions
    const deleteButtons = document.querySelectorAll('.btn-delete');
    deleteButtons.forEach(function(button) {
        button.addEventListener('click', function(event) {
            if (!confirm('¿Está seguro de que desea eliminar este elemento?')) {
                event.preventDefault();
            }
        });
    });

    // Auto-calculate fields
    function autoCalculate() {
        // Calculate amounts (quantity * unit price)
        const quantityInputs = document.querySelectorAll('[data-calculate="amount"]');
        quantityInputs.forEach(function(input) {
            const row = input.closest('tr') || input.closest('.row');
            if (row) {
                const quantity = parseFloat(row.querySelector('[name*="cantidad"]')?.value) || 0;
                const unitPrice = parseFloat(row.querySelector('[name*="precio"]')?.value) || 0;
                const amountField = row.querySelector('[name*="importe"]');
                if (amountField) {
                    amountField.value = (quantity * unitPrice).toFixed(2);
                }
            }
        });
    }

    // Add event listeners for auto-calculation
    document.addEventListener('input', function(event) {
        if (event.target.hasAttribute('data-calculate')) {
            autoCalculate();
        }
    });

    // Initialize calculations on page load
    autoCalculate();
});

// Utility functions
function showLoading(element) {
    const originalText = element.innerHTML;
    element.innerHTML = '<span class="loading"></span> Cargando...';
    element.disabled = true;
    return originalText;
}

function hideLoading(element, originalText) {
    element.innerHTML = originalText;
    element.disabled = false;
}

// AJAX form submission
function submitForm(formId, callback) {
    const form = document.getElementById(formId);
    const formData = new FormData(form);
    
    fetch(form.action, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (callback) callback(data);
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al procesar la solicitud');
    });
}

// Export functionality
function exportData(type, endpoint) {
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = endpoint;
    
    const typeInput = document.createElement('input');
    typeInput.type = 'hidden';
    typeInput.name = 'export_type';
    typeInput.value = type;
    
    form.appendChild(typeInput);
    document.body.appendChild(form);
    form.submit();
    document.body.removeChild(form);
}