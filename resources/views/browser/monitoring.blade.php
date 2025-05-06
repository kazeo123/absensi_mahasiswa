@extends('layout.browser.main')
@section('konten')
<style>
    button:disabled,
    .page-item.disabled .page-link {
        cursor: not-allowed !important;
        opacity: 0.5;
        pointer-events: none;
    }

    #map {
        height: 180px;
    }
</style>
<div class="row g-3 mb-3">
    <h5 class="mb-0" data-anchor="data-anchor">{{ $title }}</h5>
    <div class="card">
        <div class="card-body">
            <label class="form-label" for="datepicker">Filter Tanggal Absensi</label>
            <div class="input-group mb-3"><span class="input-group-text" id="basic-addon1"><i
                        class="fas fa-calendar-alt"></i></span>
                <input class="form-control" type="text" id="tanggal" placeholder="Tanggal Absensi"
                    onchange="monitoring()" aria-label="Tanggal Absensi" aria-describedby="basic-addon1"
                    value="{{ date('Y-m-d') }}" />
            </div>
        </div>
    </div>
    <div class="card" id="table-monitoring" style="display: none">
        <div class="card-body">
            {{-- <div class="row flex-between-end mb-3">
                <div class="col-auto align-self-center">
                    <div class="input-group">
                        <div class="input-group-text bg-transparent"><span class="fa fa-search fs-10 text-600"></span>
                        </div>
                        <input class="form-control form-control-sm shadow-none search" type="search" id="cari-monitor"
                            placeholder="Cari Absensi..." aria-label="search" />
                    </div>
                </div>
            </div> --}}
            <div id="tableExample3">
                <div class="table-responsive scrollbar">
                    <table class="table table-bordered table-striped fs-10 mb-0">
                        <thead class="bg-200">
                            <tr>
                                <th class="text-900" width="10%">No</th>
                                <th class="text-900">Nik</th>
                                <th class="text-900">Nama</th>
                                <th class="text-900">Departemen</th>
                                <th class="text-900">Masuk</th>
                                <th class="text-900">Foto</th>
                                <th class="text-900">Pulang</th>
                                <th class="text-900">Foto</th>
                                <th class="text-900">Keterangan</th>
                                <th class="text-900">Lokasi</th>
                            </tr>
                        </thead>
                        <tbody id="dataMonitoring">
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center mt-3">
                    <button class="btn btn-sm btn-falcon-default me-1" type="button" title="Previous"
                        data-list-pagination="prev" onclick="changePage(currentPage - 1)">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <ul class="pagination mb-0"></ul>
                    <button class="btn btn-sm btn-falcon-default ms-1" type="button" title="Next"
                        data-list-pagination="next" onclick="changePage(currentPage + 1)">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
                <div id="pagination-info" class="text-center mt-2"></div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="show-lokasi" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog" role="document" style="max-width: 500px">
        <div class="modal-content position-relative">
            <div class="position-absolute top-0 end-0 mt-2 me-2 z-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                    data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div class="rounded-top-3 py-3 ps-4 pe-6 bg-body-tertiary">
                    <h4 class="mb-1" id="modalExampleDemoLabel">Lokasi Absensi </h4>
                </div>
                <div class="p-4 pb-0">
                    <div id="map"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
            monitoring();

        });
        const ITEMS_PER_PAGE = 10;
        let currentPage = 1;
        let allData = [];

        function monitoring() {
            var tanggal = $('#tanggal').val();

            $.ajax({
                type: "POST",
                url: "{{ url('/monitor_absen') }}",
                data: {
                    tanggal
                },
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                dataType: "json",
                success: function(response) {

                    if (tanggal != '') {
                        $('#table-monitoring').show();
                        allData = response;
                        renderTable(currentPage);
                        renderPagination();
                        updatePaginationInfo();
                    }

                }
            });
            $('#cari-monitor').off('keyup').on('keyup', function() {
                let cari = $(this).val().trim();
                dataMonitor(cari);
            });
        }

        function renderTable(page) {
            const startIndex = (page - 1) * ITEMS_PER_PAGE;
            const endIndex = startIndex + ITEMS_PER_PAGE;
            const paginatedData = allData.slice(startIndex, endIndex);



            let html = '';
            let no = startIndex + 1;
            if (paginatedData.length == 0) {
                html = `<tr>
        <td colspan="8" align="center">Data Kosong</td>
    </tr>`;
            } else {
                paginatedData.forEach(monitor => {
                    let detail = btoa(JSON.stringify(monitor))
                    var ket = '';
                    var status_out = '';
                    var status_foto_out = '';

                    let terlambat = selisih('07:00:00', monitor.jam_in);
                    if (monitor.jam_in > '07:00') {
                        ket = `<span class="badge bg-danger">Terlambat (${terlambat})</span>`;
                    } else {
                        ket = '<span class="badge bg-success">Tepat Waktu</span>';
                    }
                    if (monitor.jam_out == null) {
                        status_out = '<span class="badge bg-danger">Belum Absen Pulang</span>';
                    } else {
                        status_out = monitor.jam_out;
                    }
                    if (monitor.foto_out == null) {
                        status_foto_out = 'Tidak ada foto';
                    } else {
                        status_foto_out = `<img src="/storage/${monitor.foto_out}" width="50px" height="50px">`;
                    }


                    html += `
    <tr>
        <td>${no++}</td>
        <td>${monitor.nik}</td>
        <td>${monitor.nama}</td>
        <td>${monitor.departemen}</td>
        <td>${monitor.jam_in}</td>
        <td><img src="/storage/${monitor.foto_in}" width="50px" height="50px"></td>
        <td>${status_out}</td>
        <td>${status_foto_out}</td>
        <td>${ket}</td>

                    <td><button type="button" class="btn btn-sm btn-outline-danger" onclick="showLokasi('${detail}')"> <span
                            class="fas fa-map-marked-alt"></span></button></td>
    </tr>`;
                });
            }

            $("#dataMonitoring").html(html);
        }

        function renderPagination() {
            const totalPages = Math.ceil(allData.length / ITEMS_PER_PAGE);
            let paginationHtml = '';

            const isDataEmpty = allData.length === 0;

            // Tombol Previous
            paginationHtml += `
    <button class="btn btn-sm btn-falcon-default me-1 ${currentPage === 1 || isDataEmpty ? 'disabled' : ''}" type="button"
        title="Previous" data-list-pagination="prev" onclick="changePage(${currentPage - 1})" ${currentPage===1 ||
        isDataEmpty ? 'disabled' : '' }>
        <i class="fas fa-chevron-left"></i>
    </button>`;

            // Nomor halaman
            paginationHtml += '<ul class="pagination mb-0">';
            for (let i = 1; i <= totalPages; i++) {
                paginationHtml += ` <li
            class="page-item ${i === currentPage ? 'active' : ''} ${isDataEmpty ? 'disabled' : ''}">
            <button class="page page-link" type="button" data-i="${i}" data-page="${totalPages}" onclick="changePage(${i})"
                ${isDataEmpty ? 'disabled' : '' }>${i}</button>
            </li>`;
            }
            paginationHtml += '</ul>';

            // Tombol Next
            paginationHtml += `
    <button class="btn btn-sm btn-falcon-default ms-1 ${currentPage === totalPages || isDataEmpty ? 'disabled' : ''}"
        type="button" title="Next" data-list-pagination="next" onclick="changePage(${currentPage + 1})"
        ${currentPage===totalPages || isDataEmpty ? 'disabled' : '' }>
        <i class="fas fa-chevron-right"></i>
    </button>`;

            $(".d-flex.justify-content-center").html(paginationHtml);
        }

        function updatePaginationInfo() {
            const totalEntries = allData.length; // Total data
            const startEntry = (currentPage - 1) * ITEMS_PER_PAGE + 1;
            const endEntry = Math.min(startEntry + ITEMS_PER_PAGE - 1, totalEntries);
            $('#pagination-info').text(`Menampilkan ${startEntry} hingga ${endEntry} dari ${totalEntries} data`);
        }

        function changePage(page) {
            const totalPages = Math.ceil(allData.length / ITEMS_PER_PAGE);
            if (page < 1 || page > totalPages) return;
            currentPage = page;
            renderTable(currentPage);
            renderPagination();
            updatePaginationInfo();
        }

        function selisih(jamMasuk, jamKeluar) {
            let [h1, m1, s1] = jamMasuk.split(":").map(Number);
            let [h2, m2, s2] = jamKeluar.split(":").map(Number);

            let dtAwal = new Date(2000, 0, 1, h1, m1, s1);
            let dtAkhir = new Date(2000, 0, 1, h2, m2, s2);

            let selisihMs = dtAkhir - dtAwal;
            let totalMenit = Math.floor(selisihMs / (1000 * 60));

            let jam = Math.floor(totalMenit / 60);
            let menit = totalMenit % 60;

            return `${jam}:${menit < 10 ? "0" : "" }${menit}`;
        }

        function showLokasi(item) {
            $(`#show-lokasi`).modal('show'); // Tampilkan modal
            item = JSON.parse(atob(item));
            var lokasi = item.lokasi.split(',');
            latitude = lokasi[0];
            longitude = lokasi[1];
            if (typeof map !== "undefined") {
                map.remove();
            }

            // Inisialisasi ulang peta
            var map = L.map('map').setView([latitude, longitude], 18);

            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 15,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);

            var marker = L.marker([latitude, longitude]).addTo(map);
            var circle = L.circle([latitude, longitude], {
                color: 'red',
                fillColor: '#f03',
                fillOpacity: 0.5,
                radius: 300
            }).addTo(map);

            var popup = L.popup()
                .setLatLng([latitude, longitude])
                .setContent(`${item.nama}`)
                .openOn(map);

            // Tunggu modal terbuka, lalu atur ulang ukuran peta
            $('#show-lokasi').on('shown.bs.modal', function() {
                map.invalidateSize();
            });
        }
</script>
@endsection
