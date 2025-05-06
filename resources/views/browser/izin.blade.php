@extends('layout.browser.main')
@section('konten')
<style>
    button:disabled,
    .page-item.disabled .page-link {
        cursor: not-allowed !important;
        opacity: 0.5;
        pointer-events: none;
    }
</style>
<div class="row g-3 mb-3">
    <h5 class="mb-0" data-anchor="data-anchor">{{ $title }}</h5>
    <div class="card">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-auto align-self-center">
                    <div class="row">
                        <div class="col-md-4">
                            <select class="form-select js-choice" id="organizerSingle" size="1" name="organizerSingle"
                                data-options='{"removeItemButton":true,"placeholder":true}'>
                                <option value="">Pilih Karyawan...</option>
                                @foreach ($karyawan as $item)
                                <option value="{{ $item->nik }}">{{ $item->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <div class="input-group-text bg-transparent"><span
                                                class="fa fa-calendar fs-10 text-600"></span>
                                        </div>
                                        <input class="form-control form-control-sm shadow-none search" type="text"
                                            id="tanggal" name="dari" placeholder="Dari..." aria-label="search" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <div class="input-group-text bg-transparent"><span
                                                class="fa fa-calendar fs-10 text-600"></span>
                                        </div>
                                        <input class="form-control form-control-sm shadow-none search" type="text"
                                            id="tanggal" name="sampai" placeholder="Sampai..." aria-label="search" />
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-auto ms-auto">
                    <div class="nav nav-pills">
                        <button class="btn btn-sm btn-falcon-default ms-1" type="button" title="Next"
                            onclick="dataIzin()"> <i class="fa fa-search"></i> Cari</button>
                    </div>
                </div>
            </div>
            <div id="tableExample3">
                <div class="table-responsive scrollbar">
                    <table class="table table-bordered table-striped fs-10 mb-0">
                        <thead class="bg-200">
                            <tr>
                                <th class="text-900" width="10%">No</th>
                                <th class="text-900">Nik</th>
                                <th class="text-900">Nama</th>
                                <th class="text-900">Izin</th>
                                <th class="text-900">Keterangan</th>
                                <th class="text-900">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="dataIzin">
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

<div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog" role="document" style="max-width: 800px">
        <div class="modal-content position-relative">
            <div class="position-absolute top-0 end-0 mt-2 me-2 z-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                    data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div class="rounded-top-3 py-3 ps-4 pe-6 bg-body-tertiary">
                    <h4 class="mb-1" id="modalExampleDemoLabel">Update {{ $title }} </h4>
                </div>
                <div class="p-4 pb-0">
                    <form class="row mb-4" id="form-update-aprove">
                        <div class="col-md-12">
                            <label class="col-form-label" for="recipient-name">Pilih Status Approve</label>
                            <input type="hidden" class="form-control input_edit" name="id">
                            <select class="form-control input_edit" type="text" name="status_approv">

                            </select>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Tutup</button>
                <button class="btn btn-success" type="button" id="btn_update_aprove">Approve </button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
            dataIzin();
            $('#btn_update_aprove').click(function(e) {
                $('#btn_update_aprove').attr('disabled', true);
                $('#btn_update_aprove').html(' <img src="/load.gif" alt="" width="20"> Loading...');
                e.preventDefault();
                var formData = new FormData($('#form-update-aprove')[0]);
                $.ajax({
                    type: "POST",
                    url: "{{ url('/store_approv') }}",
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(response) {
                        if (response.status == 'success') {
                            Swal.fire({
                                title: 'Berhasil!',
                                text: 'Izin berhasil diupdate.',
                                icon: 'success',
                                timer: 2000,
                                showConfirmButton: false,
                            });
                            dataIzin();
                        }
                    }
                });
                $('#edit-modal').modal('hide');
                $('#btn_update_aprove').attr('disabled', false);
                $('#btn_update_aprove').html('Simpan');
            });

        });


        const ITEMS_PER_PAGE = 10;
        let currentPage = 1;
        let allData = [];

        function dataIzin() {

            var nik = $('#organizerSingle').val();
            var dari = $('input[name="dari"]').val();
            var sampai = $('input[name="sampai"]').val();

            console.log(nik,dari,sampai);
            $.ajax({
                type: "post",
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                data: {
                    nik,dari,sampai
                },
                url: "{{ url('/api/get_izin') }}",
                dataType: "json",
                success: function(response) {

                    allData = response;
                    renderTable(currentPage);
                    renderPagination();
                    updatePaginationInfo();

                }
            });
        }

        function renderTable(page) {
            const startIndex = (page - 1) * ITEMS_PER_PAGE;
            const endIndex = startIndex + ITEMS_PER_PAGE;
            const paginatedData = allData.slice(startIndex, endIndex);
            console.log(paginatedData);
            let html = '';
            let no = startIndex + 1;
            if (paginatedData.length == 0) {
                html = `<tr>
                <td colspan="6" align="center">Data Kosong</td>
            </tr>`;
            } else {
                paginatedData.forEach(izin => {
                    let detail = btoa(JSON.stringify(izin))
                    var status_approv = '';
                    if(izin.status_approv == 0){
                        status_approv += '<span class="badge bg-warning">Pending</span>'
                    }else if(izin.status_approv == 1){
                        status_approv += '<span class="badge bg-success">Disetujui</span>'
                    }else{
                        status_approv += '<span class="badge bg-danger">Ditolak</span>'
                    }
                    html += `
            <tr>
                <td>${no++}</td>
                <td>${izin.nik}</td>
                <td>${izin.nama}</td>
                <td>${izin.status} ${status_approv}</td>
                <td>${izin.keterangan}</td>
                <td>
                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="approve_izin(${izin.id},${izin.status_approv} )"> <span class="fas fa-check-square"></span></button>
                </td>
            </tr>`;
                });
            }

            $("#dataIzin").html(html);
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


        function approve_izin(id,status_approv) {
            $(`#edit-modal`).modal('show')
            $('.input_edit[name="id"]').val(id);

            var select =
            $('.input_edit[name="status_approv"]').html(`
            <option value="">Pilih Status</option>
            <option value="1" ${status_approv===1 ? 'selected' : '' }>Disetujui</option>
            <option value="2" ${status_approv===2 ? 'selected' : '' }>Ditolak</option>
            `);

        }
</script>
@endsection
