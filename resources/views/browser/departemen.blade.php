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
            <div class="row flex-between-end mb-3">
                <div class="col-auto align-self-center">
                    <div class="input-group">
                        <div class="input-group-text bg-transparent"><span class="fa fa-search fs-10 text-600"></span>
                        </div>
                        <input class="form-control form-control-sm shadow-none search" type="search" id="cari-dpt"
                            placeholder="Cari Departemen..." aria-label="search" />
                    </div>
                </div>
                <div class="col-auto ms-auto">
                    <div class="nav nav-pills">

                        <button class="btn btn-falcon-success me-1 mb-1" data-bs-toggle="modal"
                            data-bs-target="#tambah-modal">+ Tambah</button>
                    </div>
                </div>
            </div>
            <div id="tableExample3">
                <div class="table-responsive scrollbar">
                    <table class="table table-bordered table-striped fs-10 mb-0">
                        <thead class="bg-200">
                            <tr>
                                <th class="text-900" width="10%">No</th>
                                <th class="text-900">Departemen</th>
                                <th class="text-900">Kode</th>
                                <th class="text-900">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="dataDpt">
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

<div class="modal fade" id="tambah-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog" role="document" style="max-width: 800px">
        <div class="modal-content position-relative">
            <div class="position-absolute top-0 end-0 mt-2 me-2 z-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                    data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div class="rounded-top-3 py-3 ps-4 pe-6 bg-body-tertiary">
                    <h4 class="mb-1" id="modalExampleDemoLabel">Tambah {{ $title }} </h4>
                </div>
                <div class="p-4 pb-0">
                    <form class="row mb-4" id="form-dpt">
                        <div class="col-md-12">
                            <label class="col-form-label" for="recipient-name">Departemen</label>
                            <input class="form-control " type="text" name="departemen" id="validationTooltip03"
                                placeholder="Departemen..." />
                            <span class="text-danger error-text dpt_error" id="dpt_error"></span>
                        </div>
                        <div class="col-md-12">
                            <label class="col-form-label" for="recipient-name">Kode Departemen</label>
                            <input class="form-control " type="text" name="kode" placeholder="Kode Departemen..." />
                            <span class="text-danger error-text kode_dpt" id="kode_dpt"></span>
                        </div>

                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Tutup</button>
                <button class="btn btn-primary" type="button" id="btn_dpt">Simpan </button>
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
                    <h4 class="mb-1" id="modalExampleDemoLabel">Edit {{ $title }} </h4>
                </div>
                <div class="p-4 pb-0">
                    <form class="row mb-4" id="form-update-dpt">
                        <div class="col-md-12">
                            <label class="col-form-label" for="recipient-name">Departemen</label>
                            <input class="form-control input_edit" type="text" name="departemen"
                                placeholder="Departemen..." />
                            <input type="hidden" class="form-control input_edit" name="id">
                        </div>
                        <div class="col-md-12">
                            <label class="col-form-label" for="recipient-name">Kode Departemen</label>
                            <input class="form-control input_edit" type="text" name="kode"
                                placeholder="Kode Departemen..." />
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Tutup</button>
                <button class="btn btn-primary" type="button" id="btn_update_dpt">Simpan </button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
            dataDpt();
            $('#btn_dpt').click(function(e) {
                $('#btn_dpt').attr('disabled', true);
                $('#btn_dpt').html(' <img src="/load.gif" alt="" width="20"> Loading...');
                e.preventDefault();

                var kode = $('input[name="kode"]').val();
                var departemen = $('input[name="departemen"]').val();


                if (!validasi(departemen, kode)) {
                    $('#btn_dpt').attr('disabled', false);
                    $('#btn_dpt').html('Simpan');
                    return;
                }

                var formData = new FormData($('#form-dpt')[0]);
                $.ajax({
                    type: "POST",
                    url: "{{ url('/store_dpt') }}",
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire({
                                title: 'Berhasil!',
                                text: response.message,
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 2000
                            }).then(function() {
                                dataDpt();
                            $('#form-dpt')[0].reset();
                                $('#tambah-modal').modal('hide');
                            });


                        }
                    },
                    error: function(xhr, status, error) {
                        console.log("Error: ", error);
                        Swal.fire({
                            title: 'Gagal!',
                            text: 'Terjadi kesalahan saat mengupload file.',
                            icon: 'error',
                        });
                    }
                });

                $('#btn_dpt').attr('disabled', false);
                $('#btn_dpt').html('Simpan');
            });
        });

        $('#btn_update_dpt').click(function(e) {
            $('#btn_update_dpt').attr('disabled', true);
            $('#btn_update_dpt').html(' <img src="/load.gif" alt="" width="20"> Loading...');
            e.preventDefault();
            var formData = new FormData($('#form-update-dpt')[0]);
            $.ajax({
                type: "POST",
                url: "{{ url('/store_dpt') }}",
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
                            text: 'Departemen berhasil diubah.',
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false,
                        });
                        dataDpt();
                    }
                }
            });
            $('#edit-modal').modal('hide');
            $('#btn_update_dpt').attr('disabled', false);
            $('#btn_update_dpt').html('Simpan');
        });
        const ITEMS_PER_PAGE = 10;
        let currentPage = 1;
        let allData = [];

        function dataDpt(search = null) {
            $.ajax({
                type: "post",
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                data: {
                    search
                },
                url: "{{ url('/api/get_dpt') }}",
                dataType: "json",
                success: function(response) {

                    allData = response;
                    renderTable(currentPage);
                    renderPagination();
                    updatePaginationInfo();

                }
            });
            $('#cari-dpt').off('keyup').on('keyup', function() {
                let cari = $(this).val().trim();
                dataDpt(cari);
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
                <td colspan="5" align="center">Data Kosong</td>
            </tr>`;
            } else {
                paginatedData.forEach(dpt => {
                    let detail = btoa(JSON.stringify(dpt))
                    html += `
            <tr>
                <td>${no++}</td>
                <td>${dpt.departemen}</td>
                <td>${dpt.kode}</td>
                <td>
                    <button type="button" class="btn btn-sm btn-outline-warning" onclick="editDpt('${detail}')"> <span class="fas fa-edit"></span></button>
                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="del_dpt(${dpt.id} )"> <span class="fas fa-trash-alt"></span></button>
                </td>
            </tr>`;
                });
            }

            $("#dataDpt").html(html);
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


        function editDpt(item) {
            $(`#edit-modal`).modal('show')
            item = JSON.parse(atob(item));

            $('.input_edit[name="id"]').val(item.id);
            $('.input_edit[name="departemen"]').val(item.departemen);
            $('.input_edit[name="kode"]').val(item.kode);
        }

        function validasi(departemen, kode) {
            let isValid = true;

            if (!departemen) {
                $('#dpt_error').text('Departemen Tidak Boleh Kosong');
                $('input[name="departemen"]').addClass('is-invalid');
                isValid = false;
            } else {
                $('#dpt_error').text('');
                $('input[name="departemen"]').removeClass('is-invalid');
            }
            if (!kode) {
                $('#kode_dpt').text('Kode Departemen Tidak Boleh Kosong');
                $('input[name="kode"]').addClass('is-invalid');
                isValid = false;
            } else {
                $('#kode_dpt').text('');
                $('input[name="kode"]').removeClass('is-invalid');
            }


            return isValid;
        }

        function del_dpt(id) {
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Departemen ini akan dihapus",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "{{ url('/hapus_dpt') }}",
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        data: {
                            id
                        },
                        success: function(response) {
                            if (response.status == 'success') {
                                Swal.fire({
                                    title: 'Berhasil!',
                                    text: 'Departemen berhasil dihapus.',
                                    icon: 'success',
                                    timer: 2000,
                                    showConfirmButton: false,
                                });
                                dataDpt();
                            }

                        }
                    });
                }
            })
        }
</script>
@endsection
