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
                        <input class="form-control form-control-sm shadow-none search" type="search" id="cari-karyawan"
                            placeholder="Cari Karyawan..." aria-label="search" />
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
                                <th class="text-900">Nik</th>
                                <th class="text-900">Nama</th>
                                <th class="text-900">Jabatan</th>
                                <th class="text-900">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="dataKaryawan">
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
                    <form class="row mb-4" id="form-karyawan">
                        <div class="col-md-6">
                            <label class="col-form-label" for="recipient-name">Nik</label>
                            <input class="form-control " type="text" name="nik" id="validationTooltip03"
                                placeholder="Nik..." />
                            <span class="text-danger error-text nik_error" id="nik_error"></span>
                        </div>
                        <div class="col-md-6">
                            <label class="col-form-label" for="recipient-name">Nama</label>
                            <input class="form-control " type="text" name="nama" placeholder="Nama..." />
                            <span class="text-danger error-text nama_error" id="nama_error"></span>
                        </div>
                        <div class="col-md-6">
                            <label class="col-form-label" for="recipient-name">Jabatan</label>
                            <input class="form-control" type="text" name="jabatan" placeholder="Jabatan..." />
                            <span class="text-danger error-text jabatan_error" id="jabatan_error"></span>
                        </div>
                        <div class="col-md-6">
                            <label class="col-form-label" for="recipient-name">No Hp</label>
                            <input class="form-control" type="text" name="no_hp" placeholder="No Hp..." />
                            <span class="text-danger error-text no_hp_error" id="no_hp_error"></span>
                        </div>
                        <div class="col-md-6">
                            <label class="col-form-label" for="recipient-name">Password</label>
                            <input class="form-control" type="password" name="password" placeholder="Password..." />
                            <span class="text-danger error-text password_error" id="password_error"></span>
                        </div>
                        <div class="col-md-6">
                            <label class="col-form-label" for="recipient-name">Departemen</label>
                            <select class="form-control" name="kode_dpt" id="dataDpt">
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label class="col-form-label" for="recipient-name">Upload Profil</label>
                            <input type="file" class="dropify" name="foto">
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Tutup</button>
                <button class="btn btn-primary" type="button" id="btn_karyawan">Simpan </button>
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
                    <form class="row mb-4" id="form-update-karyawan">
                        <div class="col-md-6">
                            <label class="col-form-label" for="recipient-name">Nik</label>
                            <input class="form-control input_edit" type="text" name="nik" id="validationTooltip03"
                                placeholder="Nik..." />
                            <input type="hidden" class="form-control input_edit" name="id_karyawan">
                            <span class="text-danger error-text nik_error" id="nik_error"></span>
                        </div>
                        <div class="col-md-6">
                            <label class="col-form-label" for="recipient-name">Nama</label>
                            <input class="form-control input_edit" type="text" name="nama" placeholder="Nama..." />
                            <span class="text-danger error-text nama_error" id="nama_error"></span>
                        </div>
                        <div class="col-md-6">
                            <label class="col-form-label" for="recipient-name">Jabatan</label>
                            <input class="form-control input_edit" type="text" name="jabatan"
                                placeholder="Jabatan..." />
                            <span class="text-danger error-text jabatan_error" id="jabatan_error"></span>
                        </div>
                        <div class="col-md-6">
                            <label class="col-form-label " for="recipient-name">No Hp</label>
                            <input class="form-control input_edit" type="text" name="no_hp" placeholder="No Hp..." />
                            <span class="text-danger error-text no_hp_error" id="no_hp_error"></span>
                        </div>
                        <div class="col-md-6">
                            <label class="col-form-label" for="recipient-name">Password</label>
                            <input class="form-control" type="password" name="password" placeholder="Password..." />
                            <span class="text-danger error-text password_error" id="password_error"></span>
                        </div>
                        <div class="col-md-6">
                            <label class="col-form-label" for="recipient-name">Departemen</label>
                            <select class="form-control" name="kode_dpt" id="edit-dataDpt">
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label class="col-form-label" for="recipient-name">Upload Profil</label>
                            <div id="foto"></div>
                            <input type="hidden" class="form-control input_edit" name="oldImage">
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Tutup</button>
                <button class="btn btn-primary" type="button" id="btn_update_karyawan">Simpan </button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
            selectDpt();
            dataKaryawan();
            $('#btn_karyawan').click(function(e) {
                $('#btn_karyawan').attr('disabled', true);
                $('#btn_karyawan').html(' <img src="/load.gif" alt="" width="20"> Loading...');
                e.preventDefault();

                var nik = $('input[name="nik"]').val();
                var nama = $('input[name="nama"]').val();
                var no_hp = $('input[name="no_hp"]').val();
                var jabatan = $('input[name="jabatan"]').val();
                var password = $('input[name="password"]').val();


                if (!validasi(nik, nama, no_hp, jabatan, password)) {
                    $('#btn_karyawan').attr('disabled', false);
                    $('#btn_karyawan').html('Simpan');
                    return;
                }

                var formData = new FormData($('#form-karyawan')[0]);

                formData.append("foto", $('input[name="foto"]')[0].files[0] || '');

                $.ajax({
                    type: "POST",
                    url: "{{ url('/store_karyawan') }}",
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
                                dataKaryawan();
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

                $('#btn_karyawan').attr('disabled', false);
                $('#btn_karyawanP').html('Simpan');
            });
        });

        $('#btn_update_karyawan').click(function(e) {
            $('#btn_update_karyawan').attr('disabled', true);
            $('#btn_karyawan').html(' <img src="/load.gif" alt="" width="20"> Loading...');
            e.preventDefault();
            var formData = new FormData($('#form-update-karyawan')[0]);
            $.ajax({
                type: "POST",
                url: "{{ url('/store_karyawan') }}",
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
                            text: 'Karyawan berhasil diubah.',
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false,
                        });
                        dataKaryawan();
                    }
                }
            });
            $('#edit-modal').modal('hide');
            $('#btn_update_karyawan').attr('disabled', false);
            $('#btn_update_karyawan').html('Simpan');
        });
        const ITEMS_PER_PAGE = 10;
        let currentPage = 1;
        let allData = [];

        function dataKaryawan(search = null) {
            $.ajax({
                type: "post",
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                data: {
                    search
                },
                url: "{{ url('/api/get_karyawan') }}",
                dataType: "json",
                success: function(response) {

                    allData = response;
                    renderTable(currentPage);
                    renderPagination();
                    updatePaginationInfo();
                }
            });
            $('#cari-karyawan').off('keyup').on('keyup', function() {
                let cari = $(this).val().trim();
                dataKaryawan(cari);
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
                paginatedData.forEach(karyawan => {
                    let detail = btoa(JSON.stringify(karyawan))
                    html += `
            <tr>
                <td>${no++}</td>
                <td>${karyawan.nik}</td>
                <td>${karyawan.nama}</td>
                <td>${karyawan.jabatan}</td>
                <td>
                    <button type="button" class="btn btn-sm btn-outline-warning" onclick="editKaryawan('${detail}')"> <span class="fas fa-edit"></span></button>
                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="del_karyawan(${karyawan.id_karyawan},'${karyawan.foto}' )"> <span class="fas fa-trash-alt"></span></button>
                </td>
            </tr>`;
                });
            }

            $("#dataKaryawan").html(html);
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

        function selectDpt(kode_dpt = null) {

            $.ajax({
                type: "post",
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                url: "{{ url('/api/get_dpt') }}",
                dataType: "json",
                success: function(response) {

                    var html = "<option>Pilih</option>";
                    response.forEach(dpt => {
                        if (kode_dpt != null) {
                            var select = (dpt.kode == kode_dpt) ? "selected" : "";
                        }
                        html += `
                            <option value="${dpt.kode}" ${select}>${dpt.departemen}</option>
                        `;
                    });

                    $('#dataDpt').html(html)
                    $('#edit-dataDpt').html(html)
                }
            });
        }

        function editKaryawan(item) {
            $(`#edit-modal`).modal('show')
            item = JSON.parse(atob(item));

            $('.input_edit[name="id_karyawan"]').val(item.id_karyawan);
            $('.input_edit[name="nama"]').val(item.nama);
            $('.input_edit[name="nik"]').val(item.nik);
            $('.input_edit[name="jabatan"]').val(item.jabatan);
            $('.input_edit[name="no_hp"]').val(item.no_hp);
            $('.input_edit[name="oldImage"]').val(item.foto);
            selectDpt(item.kode_dpt);
            $('#foto').html(
                `<input type="file" name="foto" class="dropify"   data-height="300"
            data-default-file="{{ asset('storage') }}/${item.foto}" />`
            );
            $('.dropify').dropify()
        }

        function validasi(nik, nama, jabatan, no_hp, password) {
            let isValid = true;

            if (!nik) {
                $('#nik_error').text('NIK Tidak Boleh Kosong');
                $('input[name="nik"]').addClass('is-invalid');
                isValid = false;
            } else {
                $('#nik_error').text('');
                $('input[name="nik"]').removeClass('is-invalid');
            }
            if (!nama) {
                $('#nama_error').text('Nama Tidak Boleh Kosong');
                $('input[name="nama"]').addClass('is-invalid');
                isValid = false;
            } else {
                $('#nama_error').text('');
                $('input[name="nama"]').removeClass('is-invalid');
            }
            if (!jabatan) {
                $('#jabatan_error').text('Jabatan Tidak Boleh Kosong');
                $('input[name="jabatan"]').addClass('is-invalid');
                isValid = false;
            } else {
                $('#jabatan_error').text('');
                $('input[name="jabatan"]').removeClass('is-invalid');
            }
            if (!no_hp) {
                $('#no_hp_error').text('No Hp Tidak Boleh Kosong');
                $('input[name="no_hp"]').addClass('is-invalid');
                isValid = false;
            } else {
                $('#no_hp_error').text('');
                $('input[name="no_hp"]').removeClass('is-invalid');
            }
            if (!password) {
                $('#password_error').text('Password Tidak Boleh Kosong');
                $('input[name="password"]').addClass('is-invalid');
                isValid = false;
            } else {
                $('#password_error').text('');
                $('input[name="password"]').removeClass('is-invalid');
            }

            return isValid;
        }

        function del_karyawan(id, foto) {
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Karyawan ini akan dihapus",
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
                        url: "{{ url('/hapus_karyawan') }}",
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        data: {
                            id,
                            foto
                        },
                        success: function(response) {
                            if (response.status == 'success') {
                                Swal.fire({
                                    title: 'Berhasil!',
                                    text: 'Karyawan berhasil dihapus.',
                                    icon: 'success',
                                    timer: 2000,
                                    showConfirmButton: false,
                                });
                                dataKaryawan();
                            }

                        }
                    });
                }
            })
        }
</script>
@endsection