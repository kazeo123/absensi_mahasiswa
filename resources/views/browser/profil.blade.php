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
<div class="row">
    <form class="row g-1" id="form-profil">
        <div class="col-lg-8 pe-lg-2">
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="mb-0">Profil Perusahaan</h5>
                </div>
                <div class="card-body bg-body-tertiary">
                    <input type="hidden" id="id_lokasi" name="id">
                    <label class="form-label">Nama Perusahaan</label>
                    <input class="form-control" type="text" name="nama" placeholder="Nama Perusahaan" />
                    <label class="form-label">No. Hp</label>
                    <input class="form-control" type="text" name="no_hp" placeholder="No Hp" />
                    <label class="form-label">Alamat Lengkap</label>
                    <input class="form-control" type="text" name="alamat" placeholder="Alamat Lengkap.."
                        aria-label="Tanggal Absensi" />
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="mb-0">Lokasi</h5>
                </div>
                <div class="card-body bg-body-tertiary">
                    <label class="form-label">Lokasi Perusahaan</label>
                    <div class="input-group"><span class="input-group-text" id="basic-addon1"><i
                                class="fas fa-map-marker-alt"></i></span>
                        <input class="form-control" type="text" name="lokasi" placeholder="Lokasi Perusahaan"
                            aria-label="Tanggal Absensi" />
                    </div>
                    <label class="form-label">Area Absensi</label>
                    <div class="input-group"><span class="input-group-text" id="basic-addon1"><i
                                class="fas fa-map-marker-alt"></i></span>
                        <input class="form-control" type="text" name="area" placeholder="Area Absensi"
                            aria-label="Tanggal Absensi" />
                    </div>
                    <button class="btn btn-outline-primary mt-3" type="button" id="btn_profil"><i
                            class="fa fa-save"></i>
                        Simpan</button>
                </div>
            </div>
        </div>
        <div class="col-lg-4 ps-lg-2">
            <div class="sticky-sidebar">
                <div class="card mb-3 overflow-hidden">
                    <div class="card-header">
                        <h5 class="mb-0">Website</h5>
                    </div>
                    <div class="card-body bg-body-tertiary">
                        <label class="form-label">Logo</label>
                        <div id="logo-perusahaan"></div>
                        <input class="form-control" type="hidden" name="oldImage" />
                        <label class="form-label">Favicon</label>
                        <div id="favicon-perusahaan"></div>
                        <input class="form-control" type="hidden" name="oldImageFav" />
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<script>
    $(document).ready(function() {
            profil();

            $('#btn_profil').click(function() {
                var formData = new FormData($('#form-profil')[0]);
                $.ajax({
                    type: "POST",
                    url: "{{ url('/store_profil') }}",
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        console.log(response);
                        if (response.status === 'success') {
                            Swal.fire({
                                title: 'Berhasil!',
                                text: response.message,
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 2000
                            }).then(function() {
                                profil();
                            });


                        }
                    }
                });
            })
        });

        function profil() {
            $.ajax({
                type: "POST",
                url: "{{ url('/api/get_profil') }}",
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                dataType: "json",
                success: function(response) {
                    console.log(response);
                    $('#id_lokasi').val(response.id);
                    $('input[name="lokasi"]').val(response.lokasi);
                    $('input[name="area"]').val(response.area);
                    $('input[name="nama"]').val(response.nama);
                    $('input[name="alamat"]').val(response.alamat);
                    $('input[name="no_hp"]').val(response.no_hp);
                    $('input[name="oldImage"]').val(response.logo);
                    $('#logo-perusahaan').html(
                        `<input type="file" name="logo" class="dropify" data-height="300"
                        data-default-file="{{ asset('storage') }}/${response.logo}" />`
                    );
                    $('input[name="oldImageFav"]').val(response.favicon);
                    $('#favicon-perusahaan').html(
                    `<input type="file" name="favicon" class="dropify" data-height="300"
                        data-default-file="{{ asset('storage') }}/${response.favicon}" />`
                    );


            $('.dropify').dropify()
                }
            });
        }
</script>
@endsection