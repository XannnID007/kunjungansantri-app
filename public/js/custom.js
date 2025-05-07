/**
 * custom.js for Sistem Pengelolaan Jadwal Kunjungan Santri
 * Template Sneat
 */

document.addEventListener('DOMContentLoaded', function() {
    // Auto-dismiss alerts after 5 seconds
    const autoAlerts = document.querySelectorAll('.alert-dismissible');
    if (autoAlerts.length > 0) {
        autoAlerts.forEach(alert => {
            setTimeout(() => {
                const closeBtn = alert.querySelector('.btn-close');
                if (closeBtn) {
                    closeBtn.click();
                } else {
                    alert.remove();
                }
            }, 5000);
        });
    }
    
    // Handle print functionality
    const printButtons = document.querySelectorAll('.btn-print');
    if (printButtons.length > 0) {
        printButtons.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                window.print();
            });
        });
    }
    
    // Dynamic form fields for barang (items) in kunjungan form
    const tambahBarangBtn = document.getElementById('tambah-barang');
    if (tambahBarangBtn) {
        const barangContainer = document.getElementById('barang-container');
        let barangCount = document.querySelectorAll('.barang-item').length;
        
        tambahBarangBtn.addEventListener('click', function() {
            const barangItem = document.createElement('div');
            barangItem.className = 'barang-item mb-3';
            barangItem.innerHTML = `
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-floating">
                            <input type="text" name="barang[${barangCount}][nama_barang]" class="form-control" id="barang-${barangCount}-nama" placeholder="Nama Barang">
                            <label for="barang-${barangCount}-nama">Nama Barang</label>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-floating">
                            <input type="number" name="barang[${barangCount}][jumlah]" class="form-control" id="barang-${barangCount}-jumlah" placeholder="Jumlah" min="1" value="1">
                            <label for="barang-${barangCount}-jumlah">Jumlah</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="text" name="barang[${barangCount}][deskripsi]" class="form-control" id="barang-${barangCount}-deskripsi" placeholder="Deskripsi/Keterangan">
                            <label for="barang-${barangCount}-deskripsi">Deskripsi/Keterangan</label>
                        </div>
                    </div>
                    <div class="col-md-1 d-flex align-items-center">
                        <button type="button" class="btn btn-danger btn-sm hapus-barang">
                            <i class="bx bx-trash"></i>
                        </button>
                    </div>
                </div>
            `;
            
            barangContainer.appendChild(barangItem);
            barangCount++;
            
            // Add event listener to delete button
            const hapusBarangBtns = document.querySelectorAll('.hapus-barang');
            hapusBarangBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    this.closest('.barang-item').remove();
                });
            });
        });
    }
    
    // Handle hapus barang buttons that exist on page load
    const existingHapusBarangBtns = document.querySelectorAll('.hapus-barang');
    if (existingHapusBarangBtns.length > 0) {
        existingHapusBarangBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                this.closest('.barang-item').remove();
            });
        });
    }
    
    // Flatpickr initialization if available
    if (typeof flatpickr !== 'undefined') {
        const datePickers = document.querySelectorAll('.datepicker');
        if (datePickers.length > 0) {
            flatpickr(datePickers, {
                dateFormat: "Y-m-d",
                allowInput: true,
                locale: {
                    firstDayOfWeek: 1
                }
            });
        }
        
        const timePickers = document.querySelectorAll('.timepicker');
        if (timePickers.length > 0) {
            flatpickr(timePickers, {
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i",
                time_24hr: true
            });
        }
    }
    
    // QR Code scanning if available
    const scanBarangBtn = document.getElementById('scanBarangBtn');
    if (scanBarangBtn && typeof Html5Qrcode !== 'undefined') {
        scanBarangBtn.addEventListener('click', function() {
            const html5QrCode = new Html5Qrcode("qr-reader");
            html5QrCode.start(
                { facingMode: "environment" },
                {
                    fps: 10,
                    qrbox: 250
                },
                (decodedText) => {
                    // success callback
                    document.getElementById('kode_barang').value = decodedText;
                    html5QrCode.stop();
                    document.getElementById('qr-reader').style.display = 'none';
                },
                (errorMessage) => {
                    // error callback
                    console.error(errorMessage);
                }
            )
            .catch((err) => {
                console.error(`Unable to start scanning: ${err}`);
            });
        });
    }
    
    // Select2 initialization if available
    if (typeof $.fn.select2 !== 'undefined') {
        $('.select2').select2({
            theme: "bootstrap-5",
            width: '100%'
        });
    }
});