@extends('layout.mobile.main')
@section('konten')
<div class="appHeader bg-primary text-light">
    <div class="left">
        <a href="javascript:;" class="headerButton goBack">
            <ion-icon name="chevron-back-outline"></ion-icon>
        </a>
    </div>
    <div class="pageTitle">Profile</div>
    <div class="right"></div>
</div>

<form id="form-update-profil">
    @csrf
    <div class="col" style="margin-top: 4rem;">
        <div class="form-group boxed">
            <div class="input-wrapper">
                <input type="hidden" name="id" value="{{ $profil->id_karyawan }}">
                <input type="text" class="form-control" value="{{ $profil->nama }}" name="nama_lengkap"
                    placeholder="Nama Lengkap" autocomplete="off">
            </div>
        </div>
        <div class="form-group boxed">
            <div class="input-wrapper">
                <input type="text" class="form-control" value="{{ $profil->no_hp }}" name="no_hp" placeholder="No. HP"
                    autocomplete="off">
            </div>
        </div>
        <div class="form-group boxed">
            <div class="input-wrapper">
                <input type="password" class="form-control" name="password" placeholder="Password" autocomplete="off">
            </div>
        </div>
        <div class="custom-file-upload" id="fileUpload1">
            <input type="hidden" name="oldImage" value="{{ $profil->foto  }}">
            <input type="file" name="foto" id="fileuploadInput" accept=".png, .jpg, .jpeg">
            <label for="fileuploadInput">
                <span>
                    <strong>
                        <ion-icon name="cloud-upload-outline" role="img" class="md hydrated"
                            aria-label="cloud upload outline"></ion-icon>
                        <i>Tap to Upload</i>
                    </strong>
                </span>
            </label>
        </div>
        <div class="form-group boxed">
            <div class="input-wrapper">
                <button type="button" id="btn-update-profil" class="btn btn-primary btn-block">
                    <ion-icon name="refresh-outline"></ion-icon>
                    Update
                </button>
            </div>
        </div>
    </div>
</form>
@push('myscript')
<script>
    $(document).ready(function() {
            $('#btn-update-profil').click(function() {
                var formData = new FormData($('#form-update-profil')[0]);
                $.ajax({
                    url: '/update_profil',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.status == 'success') {
                            Swal.fire({
                                title: 'Success!',
                                text: 'Profil berhasil diupdate!',
                                icon: 'success',
                                timer: 2000,
                                showConfirmButton: false,
                            });
                            setTimeout(() => {
                                window.location.href = '/profil';
                            }, 2000);
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: response.message,
                                icon: 'error',
                                timer: 2000,
                                showConfirmButton: false,
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Terjadi kesalahan pada server.',
                            icon: 'error',
                            timer: 2000,
                            showConfirmButton: false,
                        });
                    }
                });
            })
        });
</script>
@endpush
@endsection
