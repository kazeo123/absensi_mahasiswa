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
                        <input class="form-control form-control-sm shadow-none search" type="search" id="cari-user"
                            placeholder="Cari Nama..." aria-label="search" />
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
                                <th class="text-900">Nama </th>
                                <th class="text-900">Username</th>
                                <th class="text-900">Status</th>
                                <th class="text-900">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="dataUser">
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
                    <form class="row mb-4" id="form-user">
                        <div class="col-md-12">
                            <label class="col-form-label">Nama Lengkap</label>
                            <input class="form-control " type="text" name="name" id="validationTooltip03"
                                placeholder="Nama Lengkap..." />
                            <span class="text-danger error-text name_error" id="name_error"></span>
                        </div>
                        <div class="col-md-12">
                            <label class="col-form-label">Username</label>
                            <input class="form-control " type="text" name="email" placeholder="Username..." />
                            <span class="text-danger error-text email_error" id="email_error"></span>
                        </div>
                        <div class="col-md-12">
                            <label class="col-form-label">Password</label>
                            <input class="form-control " type="password" name="password" placeholder="Password..." />
                            <span class="text-danger error-text password_error" id="password_error"></span>
                        </div>
                        <div class="col-md-12">
                            <label class="col-form-label">Stats</label>
                            <select class="form-control" name="status">
                                <option value="1">Aktif</option>
                                <option value="0">Tidak Aktif</option>
                            </select>
                        </div>

                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Tutup</button>
                <button class="btn btn-primary" type="button" id="btn_user">Simpan </button>
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
                    <form class="row mb-4" id="form-update-user">
                        <div class="col-md-12">
                            <label class="col-form-label">Nama Lengkap</label>
                            <input class="form-control input_edit" type="text" name="name"
                                placeholder="Nama Lengkap..." />
                            <input type="hidden" class="form-control input_edit" name="id">
                        </div>
                        <div class="col-md-12">
                            <label class="col-form-label">Username</label>
                            <input class="form-control input_edit" type="text" name="email" placeholder="Username..." />
                        </div>
                        <div class="col-md-12">
                            <label class="col-form-label">Password</label>
                            <input class="form-control input_edit" type="password" name="password"
                                placeholder="Password..." />
                        </div>
                        <div class="col-md-12">
                            <label class="col-form-label">Status</label>
                            <select class="form-control input_edit" type="text" name="status">

                            </select>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Tutup</button>
                <button class="btn btn-primary" type="button" id="btn_update_user">Simpan </button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
            dataUser();
            $('#btn_user').click(function(e) {
                $('#btn_user').attr('disabled', true);
                $('#btn_user').html(' <img src="/load.gif" alt="" width="20"> Loading...');
                e.preventDefault();

                var name = $('input[name="name"]').val();
                var email = $('input[name="email"]').val();
                var password = $('input[name="password"]').val();


                if (!validasi(name, email,password)) {
                    $('#btn_user').attr('disabled', false);
                    $('#btn_user').html('Simpan');
                    return;
                }

                var formData = new FormData($('#form-user')[0]);
                $.ajax({
                    type: "POST",
                    url: "{{ url('/store_user') }}",
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
                                dataUser();
                            $('#form-user')[0].reset();
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

                $('#btn_user').attr('disabled', false);
                $('#btn_user').html('Simpan');
            });
        });

        $('#btn_update_user').click(function(e) {
            $('#btn_update_user').attr('disabled', true);
            $('#btn_update_user').html(' <img src="/load.gif" alt="" width="20"> Loading...');
            e.preventDefault();
            var formData = new FormData($('#form-update-user')[0]);
            $.ajax({
                type: "POST",
                url: "{{ url('/store_user') }}",
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
                            text: 'User berhasil diubah.',
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false,
                        });
                        dataUser();
                    }
                }
            });
            $('#edit-modal').modal('hide');
            $('#btn_update_user').attr('disabled', false);
            $('#btn_update_user').html('Simpan');
        });
        const ITEMS_PER_PAGE = 10;
        let currentPage = 1;
        let allData = [];

        function dataUser(search = null) {
            $.ajax({
                type: "post",
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                data: {
                    search
                },
                url: "{{ url('/api/get_user') }}",
                dataType: "json",
                success: function(response) {

                    allData = response;
                    renderTable(currentPage);
                    renderPagination();
                    updatePaginationInfo();

                }
            });
            $('#cari-user').off('keyup').on('keyup', function() {
                let cari = $(this).val().trim();
                dataUser(cari);
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
                paginatedData.forEach(user => {
                    let detail = btoa(JSON.stringify(user))
                    var status = '';
                    if(user.status == 1){
                        status += '<span class="badge bg-success">Aktif</span>';
                    }else{
                        status += '<span class="badge bg-danger">Tidak Aktif</span>';
                    }
                    html += `
            <tr>
                <td>${no++}</td>
                <td>${user.name}</td>
                <td>${user.email}</td>
                <td>${status}</td>
                <td>
                    <button type="button" class="btn btn-sm btn-outline-warning" onclick="editUser('${detail}')"> <span class="fas fa-edit"></span></button>
                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="del_user(${user.id} )"> <span class="fas fa-trash-alt"></span></button>
                </td>
            </tr>`;
                });
            }

            $("#dataUser").html(html);
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


        function editUser(item) {
            $(`#edit-modal`).modal('show')
            item = JSON.parse(atob(item));

            $('.input_edit[name="id"]').val(item.id);
            $('.input_edit[name="name"]').val(item.name);
            $('.input_edit[name="email"]').val(item.email);
            $('.input_edit[name="status"]').html(`
            <option value="1" ${item.status == 1 ? 'selected' : ''}>Aktif</option>
            <option value="0" ${item.status == 0 ? 'selected' : ''}>Tidak Aktif</option>
            `)
        }

        function validasi(name, email,password) {
            let isValid = true;

            if (!name) {
                $('#name_error').text('nama lengkap Tidak Boleh Kosong');
                $('input[name="name"]').addClass('is-invalid');
                isValid = false;
            } else {
                $('#name_error').text('');
                $('input[name="name"]').removeClass('is-invalid');
            }
            if (!email) {
                $('#email_error').text('username Tidak Boleh Kosong');
                $('input[name="email"]').addClass('is-invalid');
                isValid = false;
            } else {
                $('#email_error').text('');
                $('input[name="email"]').removeClass('is-invalid');
            }
            if (!password) {
                $('#password_error').text('password Tidak Boleh Kosong');
                $('input[name="password"]').addClass('is-invalid');
                isValid = false;
            } else {
                $('#password_error').text('');
                $('input[name="password"]').removeClass('is-invalid');
            }


            return isValid;
        }

        function del_user(id) {
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
                                dataUser();
                            }

                        }
                    });
                }
            })
        }
</script>
@endsection