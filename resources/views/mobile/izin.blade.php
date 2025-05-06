@extends('layout.mobile.main')
@section('konten')
<div class="appHeader bg-primary text-light">
    <div class="left">
        <a href="javascript:;" class="headerButton goBack">
            <ion-icon name="chevron-back-outline"></ion-icon>
        </a>
    </div>
    <div class="pageTitle">Data Izin</div>
    <div class="right"></div>
</div>
<div class="row" style="margin-top: 70px;">
    <div class="col" id="data-izin">

    </div>
</div>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Pengajuan Data Izin</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-pengajuan-izin">
                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <input type="text" class="form-control pengajuan-izin" id="datepicker" name="tgl_izin"
                                placeholder="Tanggal Pengajuan Izin">
                        </div>
                        <div class="form-group boxed">
                            <div class="input-wrapper">
                                <select name="status" class="form-control" id="izin">
                                    <option value="">Izin</option>
                                    <option value="izin">Izin</option>
                                    <option value="sakit">Sakit</option>
                                    <option value="cuti">Cuti</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group boxed">
                            <div class="input-wrapper">
                                <textarea name="keterangan" class="form-control" id="keterangan"
                                    placeholder="Keterangan" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" id="close-modal"
                    data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-sm btn-primary" id="simpan-pengajuan">Simpan</button>
            </div>
        </div>
    </div>
</div>

<div class="fab-button bottom-right" style="margin-bottom: 4rem;">
    <button type="button" class="fab" style="border:none;" data-toggle="modal" data-target="#exampleModal">
        <ion-icon name="add-outline"></ion-icon>
    </button>
</div>
@endsection
@push('myscript')
<script>
    $(document).ready(function() {
            get_izin();
            $('#simpan-pengajuan').click(function() {
                var formData = new FormData($('#form-pengajuan-izin')[0]);
                $.ajax({
                    type: "post",
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    data: formData,
                    url: "{{ url('/store_izin') }}",
                    dataType: "json",
                    processData: false, // Tambahkan ini
                    contentType: false, // Tambahkan ini
                    success: function(response) {
                        if (response.status == 'success') {
                            Swal.fire({
                                title: 'Berhasil!',
                                text: 'Izin berhasil ditambahkan!',
                                icon: 'success',
                                timer: 2000,
                                showConfirmButton: false,
                            });
                            $('#close-modal').click();
                            get_izin();
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: response.message,
                                icon: 'error',
                                timer: 2000,
                                showConfirmButton: false,
                            });
                        }
                    }
                });
            });
        });

        function get_izin() {
            $.ajax({
                url: '/get_izin',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                dataType: "json",
                success: function(response) {
                    console.log(response);
                    var html = '';

                    for (var i = 0; i < response.length; i++) {

                    }
                    response.forEach(element => {
                        var status_approv='';
                        var status_span = '';
                        if(element.status_approv===0){
                            status_approv+='Waiting';
                            status_span +='warning';
                        }else if(element.status_approv===1){
                            status_approv+='Disetujui';
                            status_span +='success';
                        }else{
                            status_approv+='Ditolak';
                            status_span +='danger';

                        }
                        html += `
                        <ul class="listview image-listview">
                        <li>
                            <div class="item">
                                <div class="in">
                                    <div>
                                        <b>
                                            ${element.tgl_izin} (${element.status})
                                        </b>
                                        <br />
                                        <small class="text-muted">${element.keterangan}</small>
                                    </div>
                                    <span class="badge badge-${status_span}">${status_approv}</span>
                                </div>
                            </div>
                        </li>
                        </ul>
                        `;
                    });
                    $('#data-izin').html(html);
                }
            });
        }
</script>
@endpush
