// Pengajuan Wizard JavaScript

(function() {
    'use strict';

    let currentStep = 1;
    const totalSteps = 4;
    let autoSaveInterval;

    // Signature Canvas Variables
    let canvas, ctx, isDrawing = false;
    let signatureData = null;

    // Initialize on DOM ready
    document.addEventListener('DOMContentLoaded', function() {
        initializeWizard();
        initializeSignatureCanvas();
        initializeDocumentUpload();
        initializeAutoSave();
        loadDraftData();
    });

    function initializeWizard() {
        // Next buttons
        document.querySelectorAll('.btn-next').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                if (validateStep(currentStep)) {
                    goToStep(currentStep + 1);
                }
            });
        });

        // Previous buttons
        document.querySelectorAll('.btn-prev').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                goToStep(currentStep - 1);
            });
        });

        // Form submission
        const form = document.getElementById('pengajuanForm');
        if (form) {
            form.addEventListener('submit', function(e) {
                if (!validateAllSteps()) {
                    e.preventDefault();
                    alert('Mohon lengkapi semua data yang diperlukan.');
                    return false;
                }
                
                // Add signature to form
                const ttdInput = document.getElementById('ttd_digital');
                if (ttdInput && signatureData) {
                    ttdInput.value = signatureData;
                } else if (ttdInput) {
                    e.preventDefault();
                    alert('Tanda tangan digital wajib diisi.');
                    return false;
                }

                // Clear autosave
                clearAutoSave();
            });
        }
    }

    function goToStep(step) {
        if (step < 1 || step > totalSteps) return;

        // Hide current step
        document.getElementById(`step-${currentStep}`).classList.remove('active');
        document.querySelector(`.wizard-progress .step[data-step="${currentStep}"]`).classList.remove('active');

        // Mark as completed
        if (step > currentStep) {
            document.querySelector(`.wizard-progress .step[data-step="${currentStep}"]`).classList.add('completed');
        }

        // Show new step
        currentStep = step;
        document.getElementById(`step-${currentStep}`).classList.add('active');
        document.querySelector(`.wizard-progress .step[data-step="${currentStep}"]`).classList.add('active');

        // Scroll to top
        window.scrollTo({ top: 0, behavior: 'smooth' });

        // Generate review summary if on step 4
        if (currentStep === 4) {
            generateReviewSummary();
        }
    }

    function validateStep(step) {
        const stepElement = document.getElementById(`step-${step}`);
        const requiredFields = stepElement.querySelectorAll('[required]');
        let isValid = true;

        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                field.classList.add('is-invalid');
                isValid = false;
            } else {
                field.classList.remove('is-invalid');
            }
        });

        if (!isValid) {
            alert('Mohon lengkapi semua field yang wajib diisi (*)');
        }

        return isValid;
    }

    function validateAllSteps() {
        for (let i = 1; i <= 3; i++) {
            if (!validateStep(i)) {
                goToStep(i);
                return false;
            }
        }
        return true;
    }

    function generateReviewSummary() {
        const form = document.getElementById('pengajuanForm');
        const formData = new FormData(form);
        const summary = document.getElementById('review-summary');

        let html = '<h6>Data Pribadi</h6>';
        html += `<div class="summary-item"><strong>Nama:</strong> ${formData.get('nama_lengkap') || '-'}</div>`;
        html += `<div class="summary-item"><strong>NIK:</strong> ${formData.get('nik') || '-'}</div>`;
        html += `<div class="summary-item"><strong>Email:</strong> ${formData.get('email') || '-'}</div>`;
        html += `<div class="summary-item"><strong>No. HP:</strong> ${formData.get('telepon_kantor') || '-'}</div>`;

        html += '<h6>Pendidikan</h6>';
        html += `<div class="summary-item"><strong>Pendidikan:</strong> ${formData.get('kualifikasi_pendidikan') || '-'}</div>`;
        html += `<div class="summary-item"><strong>Institusi:</strong> ${formData.get('nama_institusi') || '-'}</div>`;

        html += '<h6>Dokumen</h6>';
        const dokumenFiles = form.querySelectorAll('input[name="dokumen[]"]');
        let dokumenCount = 0;
        dokumenFiles.forEach(input => {
            if (input.files.length > 0) {
                dokumenCount++;
            }
        });
        html += `<div class="summary-item"><strong>Jumlah Dokumen:</strong> ${dokumenCount} file</div>`;

        summary.innerHTML = html;
    }

    // Signature Canvas
    function initializeSignatureCanvas() {
        canvas = document.getElementById('signature-canvas');
        if (!canvas) return;

        ctx = canvas.getContext('2d');

        // Set canvas background to white
        ctx.fillStyle = 'white';
        ctx.fillRect(0, 0, canvas.width, canvas.height);
        ctx.strokeStyle = '#000';
        ctx.lineWidth = 2;
        ctx.lineCap = 'round';

        // Mouse events
        canvas.addEventListener('mousedown', startDrawing);
        canvas.addEventListener('mousemove', draw);
        canvas.addEventListener('mouseup', stopDrawing);
        canvas.addEventListener('mouseout', stopDrawing);

        // Touch events for mobile
        canvas.addEventListener('touchstart', handleTouchStart);
        canvas.addEventListener('touchmove', handleTouchMove);
        canvas.addEventListener('touchend', stopDrawing);

        // Modal controls
        const openBtn = document.getElementById('open-signature-modal');
        const closeBtn = document.querySelector('.close-signature-modal');
        const cancelBtn = document.getElementById('btn-signature-cancel');
        const clearBtn = document.getElementById('btn-signature-clear');
        const saveBtn = document.getElementById('btn-signature-save');
        const uploadInput = document.getElementById('signature-upload');
        const backdrop = document.getElementById('signature-modal-backdrop');

        if (openBtn) {
            openBtn.addEventListener('click', () => {
                backdrop.classList.add('show');
            });
        }

        if (closeBtn) {
            closeBtn.addEventListener('click', closeSignatureModal);
        }

        if (cancelBtn) {
            cancelBtn.addEventListener('click', closeSignatureModal);
        }

        if (clearBtn) {
            clearBtn.addEventListener('click', clearSignature);
        }

        if (saveBtn) {
            saveBtn.addEventListener('click', saveSignature);
        }

        if (uploadInput) {
            uploadInput.addEventListener('change', handleSignatureUpload);
        }

        // Close on backdrop click
        backdrop.addEventListener('click', function(e) {
            if (e.target === backdrop) {
                closeSignatureModal();
            }
        });
    }

    function startDrawing(e) {
        isDrawing = true;
        const rect = canvas.getBoundingClientRect();
        ctx.beginPath();
        ctx.moveTo(e.clientX - rect.left, e.clientY - rect.top);
    }

    function draw(e) {
        if (!isDrawing) return;
        const rect = canvas.getBoundingClientRect();
        ctx.lineTo(e.clientX - rect.left, e.clientY - rect.top);
        ctx.stroke();
    }

    function stopDrawing() {
        isDrawing = false;
    }

    function handleTouchStart(e) {
        e.preventDefault();
        const touch = e.touches[0];
        const mouseEvent = new MouseEvent('mousedown', {
            clientX: touch.clientX,
            clientY: touch.clientY
        });
        canvas.dispatchEvent(mouseEvent);
    }

    function handleTouchMove(e) {
        e.preventDefault();
        const touch = e.touches[0];
        const mouseEvent = new MouseEvent('mousemove', {
            clientX: touch.clientX,
            clientY: touch.clientY
        });
        canvas.dispatchEvent(mouseEvent);
    }

    function clearSignature() {
        ctx.fillStyle = 'white';
        ctx.fillRect(0, 0, canvas.width, canvas.height);
        signatureData = null;
    }

    function saveSignature() {
        if (isCanvasBlank()) {
            alert('Mohon buat tanda tangan terlebih dahulu.');
            return;
        }

        signatureData = canvas.toDataURL();
        
        // Show preview
        const preview = document.getElementById('signature-preview');
        const previewImg = document.getElementById('signature-preview-img');
        if (preview && previewImg) {
            previewImg.src = signatureData;
            preview.style.display = 'block';
        }

        closeSignatureModal();
    }

    function handleSignatureUpload(e) {
        const file = e.target.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = function(event) {
            const img = new Image();
            img.onload = function() {
                ctx.fillStyle = 'white';
                ctx.fillRect(0, 0, canvas.width, canvas.height);
                ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
                signatureData = canvas.toDataURL();
            };
            img.src = event.target.result;
        };
        reader.readAsDataURL(file);
    }

    function closeSignatureModal() {
        const backdrop = document.getElementById('signature-modal-backdrop');
        if (backdrop) {
            backdrop.classList.remove('show');
        }
    }

    function isCanvasBlank() {
        const blank = document.createElement('canvas');
        blank.width = canvas.width;
        blank.height = canvas.height;
        const blankCtx = blank.getContext('2d');
        blankCtx.fillStyle = 'white';
        blankCtx.fillRect(0, 0, blank.width, blank.height);
        return canvas.toDataURL() === blank.toDataURL();
    }

    // Document Upload
    function initializeDocumentUpload() {
        const addBtn = document.getElementById('btn-add-dokumen');
        if (addBtn) {
            addBtn.addEventListener('click', function() {
                const container = document.getElementById('dokumen-container');
                const newItem = container.querySelector('.dokumen-item').cloneNode(true);
                newItem.querySelector('input[type="file"]').value = '';
                container.appendChild(newItem);
            });
        }
    }

    // Auto-save functionality
    function initializeAutoSave() {
        autoSaveInterval = setInterval(saveDraft, 30000); // Every 30 seconds
    }

    function saveDraft() {
        const form = document.getElementById('pengajuanForm');
        const formData = new FormData(form);
        const data = {};

        // Convert FormData to object
        for (let [key, value] of formData.entries()) {
            if (data[key]) {
                if (!Array.isArray(data[key])) {
                    data[key] = [data[key]];
                }
                data[key].push(value);
            } else {
                data[key] = value;
            }
        }

        // Save to localStorage
        localStorage.setItem('pengajuan_draft', JSON.stringify(data));

        // Also save to server via AJAX
        fetch('/pengajuan/draft', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(data)
        }).then(response => response.json())
          .then(data => {
              if (data.success) {
                  showAutoSaveIndicator();
              }
          })
          .catch(error => console.error('Auto-save error:', error));
    }

    function loadDraftData() {
        const draft = localStorage.getItem('pengajuan_draft');
        if (!draft) return;

        try {
            const data = JSON.parse(draft);
            const form = document.getElementById('pengajuanForm');

            // Fill form fields
            for (let [key, value] of Object.entries(data)) {
                const field = form.querySelector(`[name="${key}"]`);
                if (field && !field.files) { // Skip file inputs
                    field.value = value;
                }
            }
        } catch (e) {
            console.error('Error loading draft:', e);
        }
    }

    function clearAutoSave() {
        clearInterval(autoSaveInterval);
        localStorage.removeItem('pengajuan_draft');
    }

    function showAutoSaveIndicator() {
        const indicator = document.getElementById('auto-save-indicator');
        if (indicator) {
            indicator.classList.add('show');
            setTimeout(() => {
                indicator.classList.remove('show');
            }, 2000);
        }
    }

})();
