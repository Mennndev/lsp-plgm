// public/js/pengajuan-wizard.js
(function () {
  'use strict';

  let currentStep = 1;
  const totalSteps = 4;
  let autoSaveInterval;

  // Signature
  let canvas, ctx, isDrawing = false;
  let signatureData = null;

  document.addEventListener('DOMContentLoaded', function () {
    if (window.__wizardInit) return;
    window.__wizardInit = true;

    initializeWizard();
    initializeSignatureCanvas();
    initializeDocumentUpload();
    initializePortfolioUpload();
    initializeRemoveHandlers();
    initializeAutoSave();
    loadDraftData();
    restoreSignaturePreviewFromOld();
  });

  // =========================
  // WIZARD
  // =========================
  function initializeWizard() {
    // Next
    document.querySelectorAll('.btn-next').forEach(btn => {
      btn.addEventListener('click', function (e) {
        e.preventDefault();
        if (validateStep(currentStep)) {
          goToStep(currentStep + 1);
        }
      });
    });

    // Prev
    document.querySelectorAll('.btn-prev').forEach(btn => {
      btn.addEventListener('click', function (e) {
        e.preventDefault();
        goToStep(currentStep - 1);
      });
    });

    // Submit
    const form = document.getElementById('formPengajuan');
    if (!form) return;

    form.addEventListener('submit', function (e) {
      e.preventDefault();

      // update current_step sebelum submit
      const stepInput = document.getElementById('current_step');
      if (stepInput) stepInput.value = currentStep;

      // Validasi TTD
      const ttdInput = document.getElementById('ttd_digital');
      if (!ttdInput || !ttdInput.value) {
        alert('Tanda tangan digital wajib diisi!');
        const btnBuatTtd = document.getElementById('open-signature-modal');
        if (btnBuatTtd) btnBuatTtd.scrollIntoView({ behavior: 'smooth' });
        return false;
      }

      // Validasi persetujuan
      const agree = document.getElementById('agree');
      if (!agree || !agree.checked) {
        alert('Anda harus menyetujui pernyataan terlebih dahulu!');
        if (agree) agree.focus();
        return false;
      }

      // Validasi semua required field (HTML5)
      if (!form.checkValidity()) {
        form.reportValidity();
        return false;
      }

      if (!confirm('Apakah Anda yakin data yang diisi sudah benar dan ingin mengirim pengajuan?')) {
        return false;
      }

      const btnSubmit = document.getElementById('btnSubmit');
      if (btnSubmit) {
        btnSubmit.disabled = true;
        btnSubmit.innerHTML = '<i class="bi bi-hourglass-split"></i> Mengirim...';
      }

      clearAutoSave();
      form.submit();
    });
  }

  function goToStep(step) {
    if (step < 1 || step > totalSteps) return;

    // Hide all
    for (let i = 1; i <= totalSteps; i++) {
      const stepEl = document.getElementById(`step-${i}`);
      if (stepEl) {
        stepEl.classList.remove('active');
        stepEl.style.display = 'none';
      }

      const progressStep = document.querySelector(`.wizard-progress .step[data-step="${i}"]`);
      if (progressStep) {
        progressStep.classList.remove('active', 'completed');
      }
    }

    // completed
    for (let i = 1; i < step; i++) {
      const progressStep = document.querySelector(`.wizard-progress .step[data-step="${i}"]`);
      if (progressStep) progressStep.classList.add('completed');
    }

    currentStep = step;

    // set hidden current_step
    const stepInput = document.getElementById('current_step');
    if (stepInput) stepInput.value = currentStep;

    // show current
    const newStepEl = document.getElementById(`step-${currentStep}`);
    const newProgressStep = document.querySelector(`.wizard-progress .step[data-step="${currentStep}"]`);

    if (newStepEl) {
      newStepEl.classList.add('active');
      newStepEl.style.display = 'block';
    }
    if (newProgressStep) newProgressStep.classList.add('active');

    window.scrollTo({ top: 0, behavior: 'smooth' });

    if (currentStep === 4) generateReviewSummary();
  }

  // biar bisa dipanggil dari blade
  window.goToStep = goToStep;

  function validateStep(step) {
    const stepEl = document.getElementById(`step-${step}`);
    if (!stepEl) return true;

    const requiredFields = stepEl.querySelectorAll('[required]');
    let isValid = true;

    requiredFields.forEach(field => {
      if (field.type === 'checkbox') {
        if (!field.checked) {
          field.classList.add('is-invalid');
          isValid = false;
        } else {
          field.classList.remove('is-invalid');
        }
        return;
      }

      if (field.type === 'file') {
        field.classList.remove('is-invalid');
        return;
      }

      const val = (field.value || '').trim();
      if (!val) {
        field.classList.add('is-invalid');
        isValid = false;
      } else {
        field.classList.remove('is-invalid');
      }
    });

    if (!isValid) alert('Mohon lengkapi semua field yang wajib diisi (*)');
    return isValid;
  }

  function generateReviewSummary() {
    const form = document.getElementById('formPengajuan');
    const summaryDiv = document.getElementById('review-summary');
    if (!form || !summaryDiv) return;

    const formData = new FormData(form);

    let html = '';

    html += '<div class="review-section mb-4">';
    html += '<h6 class="fw-bold text-primary mb-3"><i class="bi bi-person"></i> Data Pribadi</h6>';
    html += '<div class="row g-2">';
    html += `<div class="col-md-6"><div class="summary-item"><strong>Nama:</strong> ${formData.get('nama_lengkap') || '-'}</div></div>`;
    html += `<div class="col-md-6"><div class="summary-item"><strong>NIK:</strong> ${formData.get('nik') || '-'}</div></div>`;
    html += `<div class="col-md-6"><div class="summary-item"><strong>Email:</strong> ${formData.get('email') || '-'}</div></div>`;
    html += `<div class="col-md-6"><div class="summary-item"><strong>No. HP:</strong> ${formData.get('hp') || '-'}</div></div>`;
    html += '</div></div>';

    html += '<div class="review-section mb-4">';
    html += '<h6 class="fw-bold text-primary mb-3"><i class="bi bi-mortarboard"></i> Pendidikan</h6>';
    html += '<div class="row g-2">';
    html += `<div class="col-md-6"><div class="summary-item"><strong>Pendidikan:</strong> ${formData.get('kualifikasi_pendidikan') || '-'}</div></div>`;
    html += `<div class="col-md-6"><div class="summary-item"><strong>Institusi:</strong> ${formData.get('nama_institusi') || '-'}</div></div>`;
    html += '</div></div>';

    html += '<div class="review-section">';
    html += '<h6 class="fw-bold text-primary mb-3"><i class="bi bi-file-earmark"></i> Dokumen</h6>';

    const fileInputs = form.querySelectorAll('input[type="file"]');
    let count = 0;
    fileInputs.forEach(input => {
      if (input.files && input.files.length) count += input.files.length;
    });
    html += `<div class="summary-item"><strong>Jumlah Dokumen:</strong> ${count} file</div>`;
    html += '</div>';

    summaryDiv.innerHTML = html;
  }

  // =========================
  // SIGNATURE
  // =========================
  function initializeSignatureCanvas() {
    canvas = document.getElementById('signature-canvas');
    if (!canvas) return;

    ctx = canvas.getContext('2d');

    setWhiteCanvas();

    ctx.strokeStyle = '#000';
    ctx.lineWidth = 2;
    ctx.lineCap = 'round';

    canvas.addEventListener('mousedown', startDrawing);
    canvas.addEventListener('mousemove', draw);
    canvas.addEventListener('mouseup', stopDrawing);
    canvas.addEventListener('mouseout', stopDrawing);

    canvas.addEventListener('touchstart', handleTouchStart, { passive: false });
    canvas.addEventListener('touchmove', handleTouchMove, { passive: false });
    canvas.addEventListener('touchend', stopDrawing);

    const openBtn = document.getElementById('open-signature-modal');
    const closeBtn = document.querySelector('.close-signature-modal');
    const cancelBtn = document.getElementById('btn-signature-cancel');
    const clearBtn = document.getElementById('btn-signature-clear');
    const saveBtn = document.getElementById('btn-signature-save');
    const uploadInput = document.getElementById('signature-upload');
    const backdrop = document.getElementById('signature-modal-backdrop');

    if (openBtn) openBtn.addEventListener('click', () => backdrop && backdrop.classList.add('show'));
    if (closeBtn) closeBtn.addEventListener('click', closeSignatureModal);
    if (cancelBtn) cancelBtn.addEventListener('click', closeSignatureModal);
    if (clearBtn) clearBtn.addEventListener('click', clearSignature);
    if (saveBtn) saveBtn.addEventListener('click', saveSignature);
    if (uploadInput) uploadInput.addEventListener('change', handleSignatureUpload);

    if (backdrop) {
      backdrop.addEventListener('click', function (e) {
        if (e.target === backdrop) closeSignatureModal();
      });
    }
  }

  function setWhiteCanvas() {
    if (!ctx || !canvas) return;
    ctx.fillStyle = 'white';
    ctx.fillRect(0, 0, canvas.width, canvas.height);
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
    const t = e.touches[0];
    canvas.dispatchEvent(new MouseEvent('mousedown', { clientX: t.clientX, clientY: t.clientY }));
  }

  function handleTouchMove(e) {
    e.preventDefault();
    const t = e.touches[0];
    canvas.dispatchEvent(new MouseEvent('mousemove', { clientX: t.clientX, clientY: t.clientY }));
  }

  function clearSignature() {
    setWhiteCanvas();
    signatureData = null;

    const ttd = document.getElementById('ttd_digital');
    if (ttd) ttd.value = '';

    const preview = document.getElementById('signature-preview');
    if (preview) preview.style.display = 'none';
  }

  function saveSignature() {
    if (isCanvasBlank()) {
      alert('Mohon buat tanda tangan terlebih dahulu.');
      return;
    }

    signatureData = canvas.toDataURL('image/png');

    const ttd = document.getElementById('ttd_digital');
    if (ttd) ttd.value = signatureData;

    showSignaturePreview(signatureData);

    closeSignatureModal();
    alert('Tanda tangan berhasil disimpan!');
  }

  function showSignaturePreview(dataUrl) {
    const preview = document.getElementById('signature-preview');
    const img = document.getElementById('signature-preview-img');
    if (!preview || !img) return;

    img.src = dataUrl;
    preview.style.display = 'block';
  }

  function handleSignatureUpload(e) {
    const file = e.target.files && e.target.files[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onload = function (event) {
      const img = new Image();
      img.onload = function () {
        setWhiteCanvas();
        ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
        signatureData = canvas.toDataURL('image/png');

        const ttd = document.getElementById('ttd_digital');
        if (ttd) ttd.value = signatureData;

        showSignaturePreview(signatureData);
      };
      img.src = event.target.result;
    };
    reader.readAsDataURL(file);
  }

  function closeSignatureModal() {
    const backdrop = document.getElementById('signature-modal-backdrop');
    if (backdrop) backdrop.classList.remove('show');
  }

  function isCanvasBlank() {
    const blank = document.createElement('canvas');
    blank.width = canvas.width;
    blank.height = canvas.height;
    const bctx = blank.getContext('2d');
    bctx.fillStyle = 'white';
    bctx.fillRect(0, 0, blank.width, blank.height);
    return canvas.toDataURL() === blank.toDataURL();
  }

  function restoreSignaturePreviewFromOld() {
    const ttd = document.getElementById('ttd_digital');
    if (ttd && ttd.value) {
      showSignaturePreview(ttd.value);
    }
  }

  // =========================
  // DOKUMEN
  // =========================
  function initializeDocumentUpload() {
    const addBtn = document.getElementById('btn-add-dokumen');
    if (!addBtn) return;

    addBtn.addEventListener('click', function () {
      const container = document.getElementById('dokumen-container');
      if (!container) return;

      const first = container.querySelector('.dokumen-item');
      if (!first) return;

      const newItem = first.cloneNode(true);

      // clear file + reset select ke default
      const fileInput = newItem.querySelector('input[type="file"]');
      if (fileInput) fileInput.value = '';

      // kalau tombol hapus belum ada, tambahkan
      if (!newItem.querySelector('.btn-remove-dokumen')) {
        const wrap = document.createElement('div');
        wrap.className = 'mt-2';
        wrap.innerHTML = `
          <button type="button" class="btn btn-sm btn-danger btn-remove-dokumen">
            <i class="bi bi-trash"></i> Hapus Baris
          </button>
        `;
        newItem.appendChild(wrap);
      }

      container.appendChild(newItem);
    });
  }

  // =========================
  // PORTFOLIO
  // =========================
  function initializePortfolioUpload() {
    // validasi ukuran file portfolio (2MB per file, multiple files)
    document.addEventListener('change', function (e) {
      const input = e.target;
      if (!input.matches('input[type="file"][name^="portfolio"]')) return;

      const maxSize = 2 * 1024 * 1024; // 2MB
      const files = input.files;
      if (!files || files.length === 0) return;

      for (let i = 0; i < files.length; i++) {
        if (files[i].size > maxSize) {
          alert('Ukuran file terlalu besar! Maksimal 2MB per file.\nFile: ' + files[i].name);
          input.value = '';
          return;
        }
      }
    });
  }

  // remove handlers (delegation) untuk dokumen saja
  function initializeRemoveHandlers() {
    document.addEventListener('click', function (e) {
      const btnD = e.target.closest('.btn-remove-dokumen');
      if (btnD) {
        const item = btnD.closest('.dokumen-item');
        if (item) item.remove();
      }
    });
  }

  // =========================
  // AUTOSAVE (LOCALSTORAGE)
  // =========================
  function initializeAutoSave() {
    autoSaveInterval = setInterval(saveDraft, 30000);
  }

  function saveDraft() {
    const form = document.getElementById('formPengajuan');
    if (!form) return;

    const formData = new FormData(form);
    const data = {};

    for (let [key, value] of formData.entries()) {
      // skip file uploads
      if (key === 'dokumen[]') continue;
      if (key.startsWith('portfolio[')) continue;

      // checkbox multiple (tujuan_asesmen[])
      if (key.endsWith('[]')) {
        const k = key.slice(0, -2);
        if (!Array.isArray(data[k])) data[k] = [];
        data[k].push(value);
        continue;
      }

      // normal
      data[key] = value;
    }

    try {
      localStorage.setItem('pengajuan_draft', JSON.stringify(data));
      showAutoSaveIndicator();
    } catch (e) {
      console.error('LocalStorage save error:', e);
    }
  }

  function loadDraftData() {
    // kalau server lagi balikin old() karena validasi, itu prioritas.
    // jadi localStorage hanya membantu kalau user refresh/keluar halaman.
    const draft = localStorage.getItem('pengajuan_draft');
    if (!draft) return;

    let data;
    try {
      data = JSON.parse(draft);
    } catch (e) {
      console.error('Draft JSON parse error:', e);
      return;
    }

    const form = document.getElementById('formPengajuan');
    if (!form) return;

    Object.entries(data).forEach(([key, value]) => {
      // array checkbox
      if (Array.isArray(value)) {
        value.forEach(v => {
          const cb = form.querySelector(`[name="${key}[]"][value="${cssEscape(v)}"]`);
          if (cb) cb.checked = true;
        });
        return;
      }

      // radio
      const radios = form.querySelectorAll(`[name="${key}"]`);
      if (radios && radios.length && radios[0].type === 'radio') {
        radios.forEach(r => r.checked = (r.value === value));
        return;
      }

      // checkbox single
      const singleCb = form.querySelector(`[name="${key}"]`);
      if (singleCb && singleCb.type === 'checkbox') {
        singleCb.checked = !!value;
        return;
      }

      // text/select/textarea
      const field = form.querySelector(`[name="${key}"]`);
      if (field && field.type !== 'file') {
        field.value = value;
      }
    });
  }

  function clearAutoSave() {
    if (autoSaveInterval) clearInterval(autoSaveInterval);
    localStorage.removeItem('pengajuan_draft');
  }

  function showAutoSaveIndicator() {
    const indicator = document.getElementById('auto-save-indicator');
    if (!indicator) return;

    indicator.classList.add('show');
    setTimeout(() => indicator.classList.remove('show'), 2000);
  }

  // helper agar selector aman
  function cssEscape(str) {
    if (window.CSS && CSS.escape) return CSS.escape(str);
    return String(str).replace(/"/g, '\\"');
  }

})();
