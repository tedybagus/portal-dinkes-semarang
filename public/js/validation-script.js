/**
 * ============================================
 * VALIDATION & CONFIRMATION SCRIPT - FIXED
 * Handle form submission with better error handling
 * ============================================
 */

document.addEventListener('DOMContentLoaded', function() {
    
    console.log('Validation script loaded');
    
    /**
     * DELETE CONFIRMATION
     */
    document.querySelectorAll('.delete-form').forEach(function(form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const itemName = form.dataset.itemName || 'data ini';
            
            Swal.fire({
                title: 'Konfirmasi Hapus',
                html: `Apakah Anda yakin ingin menghapus <strong>${itemName}</strong>?<br><small style="color: #6b7280;">Data yang dihapus tidak dapat dikembalikan!</small>`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: '<i class="fas fa-trash"></i> Ya, Hapus!',
                cancelButtonText: '<i class="fas fa-times"></i> Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Menghapus...',
                        html: 'Mohon tunggu sebentar',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    
                    form.submit();
                }
            });
        });
    });
    
    /**
     * DELETE BUTTON
     */
    document.querySelectorAll('.delete-btn').forEach(function(button) {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            const form = this.closest('form');
            if (!form) {
                console.error('Form tidak ditemukan');
                return;
            }
            
            const itemName = this.dataset.itemName || form.dataset.itemName || 'data ini';
            
            Swal.fire({
                title: 'Konfirmasi Hapus',
                html: `Apakah Anda yakin ingin menghapus <strong>${itemName}</strong>?<br><small style="color: #6b7280;">Data yang dihapus tidak dapat dikembalikan!</small>`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: '<i class="fas fa-trash"></i> Ya, Hapus!',
                cancelButtonText: '<i class="fas fa-times"></i> Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Menghapus...',
                        html: 'Mohon tunggu sebentar',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    
                    form.submit();
                }
            });
        });
    });
    
    /**
     * UPDATE/SAVE CONFIRMATION - IMPROVED
     * Dengan opsi untuk skip confirmation
     */
    
    // Check if confirmation is enabled (default: true)
    const confirmationEnabled = document.querySelector('meta[name="enable-confirmation"]')?.content !== 'false';
    
    document.querySelectorAll('.update-form, .save-form').forEach(function(form) {
        form.addEventListener('submit', function(e) {
            
            // Skip confirmation if disabled via data attribute
            if (this.dataset.skipConfirmation === 'true' || !confirmationEnabled) {
                console.log('Skipping confirmation, submitting form directly');
                return true; // Allow form to submit
            }
            
            e.preventDefault();
            
            const isUpdate = form.classList.contains('update-form');
            const title = isUpdate ? 'Konfirmasi Update' : 'Konfirmasi Simpan';
            const message = isUpdate ? 'Apakah Anda yakin ingin menyimpan perubahan?' : 'Apakah Anda yakin ingin menyimpan data ini?';
            
            console.log('Showing confirmation modal for:', title);
            
            Swal.fire({
                title: title,
                text: message,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3b82f6',
                cancelButtonColor: '#6b7280',
                confirmButtonText: '<i class="fas fa-save"></i> Ya, Simpan!',
                cancelButtonText: '<i class="fas fa-times"></i> Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    console.log('User confirmed, submitting form');
                    
                    Swal.fire({
                        title: 'Menyimpan...',
                        html: 'Mohon tunggu sebentar',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    
                    // Remove the event listener temporarily to prevent loop
                    this.dataset.skipConfirmation = 'true';
                    this.submit();
                } else {
                    console.log('User cancelled');
                }
            }).catch((error) => {
                console.error('SweetAlert error:', error);
                // If SweetAlert fails, submit anyway
                this.dataset.skipConfirmation = 'true';
                this.submit();
            });
        });
    });
    
    /**
     * FLASH MESSAGES
     */
    
    // Success message
    const successMessage = document.querySelector('[data-success-message]');
    if (successMessage) {
        const message = successMessage.dataset.successMessage;
        console.log('Showing success message:', message);
        
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: message,
            timer: 3000,
            showConfirmButton: false,
            toast: true,
            position: 'top-end'
        });
    }
    
    // Error message
    const errorMessage = document.querySelector('[data-error-message]');
    if (errorMessage) {
        const message = errorMessage.dataset.errorMessage;
        console.log('Showing error message:', message);
        
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: message,
            timer: 3000,
            showConfirmButton: false,
            toast: true,
            position: 'top-end'
        });
    }
    
    /**
     * BULK DELETE
     */
    const bulkDeleteBtn = document.getElementById('bulk-delete-btn');
    if (bulkDeleteBtn) {
        bulkDeleteBtn.addEventListener('click', function() {
            const checkedBoxes = document.querySelectorAll('.item-checkbox:checked');
            
            if (checkedBoxes.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Tidak Ada Data Dipilih',
                    text: 'Pilih minimal 1 data untuk dihapus',
                    confirmButtonColor: '#3b82f6'
                });
                return;
            }
            
            Swal.fire({
                title: 'Konfirmasi Hapus Massal',
                html: `Anda akan menghapus <strong>${checkedBoxes.length} data</strong>.<br>Lanjutkan?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: `Hapus ${checkedBoxes.length} Data`,
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    const ids = Array.from(checkedBoxes).map(cb => cb.value);
                    document.getElementById('bulk-delete-ids').value = ids.join(',');
                    document.getElementById('bulk-delete-form').submit();
                }
            });
        });
    }
    
    /**
     * SELECT ALL CHECKBOX
     */
    const selectAllCheckbox = document.getElementById('select-all');
    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.item-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
            updateBulkActionButtons();
        });
    }
    
    // Update bulk action buttons
    document.querySelectorAll('.item-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', updateBulkActionButtons);
    });
    
    function updateBulkActionButtons() {
        const checkedCount = document.querySelectorAll('.item-checkbox:checked').length;
        const bulkActions = document.getElementById('bulk-actions');
        
        if (bulkActions) {
            if (checkedCount > 0) {
                bulkActions.style.display = 'flex';
                const countElement = document.getElementById('selected-count');
                if (countElement) {
                    countElement.textContent = checkedCount;
                }
            } else {
                bulkActions.style.display = 'none';
            }
        }
    }
    
    /**
     * FORM VALIDATION HELPER
     */
    
    // Show validation errors
    document.querySelectorAll('form').forEach(function(form) {
        form.addEventListener('invalid', function(e) {
            e.preventDefault();
            
            // Find first invalid field
            const firstInvalid = form.querySelector(':invalid');
            if (firstInvalid) {
                firstInvalid.focus();
                
                // Show error message
                const fieldName = firstInvalid.name || 'Field';
                const label = form.querySelector(`label[for="${firstInvalid.id}"]`);
                const fieldLabel = label ? label.textContent.replace('*', '').trim() : fieldName;
                
                Swal.fire({
                    icon: 'error',
                    title: 'Validasi Gagal',
                    text: `${fieldLabel} wajib diisi`,
                    confirmButtonColor: '#3b82f6'
                });
            }
        }, true);
    });
    
});

/**
 * NO-CONFIRM UTILITY
 * Untuk form yang tidak perlu konfirmasi
 */
function submitFormWithoutConfirm(formId) {
    const form = document.getElementById(formId);
    if (form) {
        form.dataset.skipConfirmation = 'true';
        form.submit();
    }
}

/**
 * CONSOLE LOG HELPER
 */
console.log('Validation script initialized successfully');
console.log('SweetAlert2 available:', typeof Swal !== 'undefined');