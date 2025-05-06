@extends('layout.mobile.main')
@section('konten')
<div class="appHeader bg-primary text-light">
    <div class="left">
        <a href="javascript:;" class="headerButton goBack">
            <ion-icon name="chevron-back-outline"></ion-icon>
        </a>
    </div>
    <div class="pageTitle">Histori Presensi</div>
    <div class="right"></div>
</div>

@csrf
<div class="col" style="margin-top: 4rem;">
    <div class="form-group boxed">
        <div class="input-wrapper">
            <select name="bulan" class="form-control" id="bulan">
                <option value="">Bulan</option>
                @foreach ($bulan as $item)
                <option value="{{ $item['id'] }}">{{ $item['nama'] }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group boxed">
        <div class="input-wrapper">
            <select name="tahun" class="form-control" id="tahun">
                <option value="">Tahun</option>
                @foreach ($tahun as $item)
                <option value="{{ $item->tahun }}">{{ $item->tahun }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group boxed">
        <div class="input-wrapper">
            <button type="button" class="btn btn-primary btn-block" id="btn-histori">
                <ion-icon name="search-outline"></ion-icon>
                Submit
            </button>
        </div>
    </div>
    <ul class="listview image-listview mt-3" style="display: none;" id="show-histori">

    </ul>
</div>
@push('myscript')
<script>
    $(document).ready(function() {


        $('#btn-histori').click(function() {

            let bulan = $('#bulan').val();
            let tahun = $('#tahun').val();

            $.ajax({
                type: "post",
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                data: {
                    bulan: bulan,
                    tahun: tahun
                },
                url: "{{ url('/get_histori') }}",
                dataType: "json",
                success: function(response) {
                    let html ='';
                    response.forEach(element => {
                        var html_out ='';
                        if(element.jam_out < "20:00"){
                            html_out += "primary";
                        }else{
                            html_out += "danger";
                        }
                        var html_in ='';
                        if(element.jam_out < "10:00"){
                            html_in += "success";
                        }else{
                            html_in += "danger";
                        }
                        html +=`
                        <li>
                            <div class="item">
                                <img src="/mobile/assets/img/sample/avatar/avatar1.jpg" alt="image" class="image">
                                <div class="in">
                                    <div>
                                            ${element.tgl}
                                    </div>
                                    <span class="badge badge-${html_in}">${element.jam_in}</span>
                                    <span class="badge badge-${html_out}">${element.jam_out}</span>
                                </div>
                            </div>
                        </li>
                        `;
                    })
                   $('#show-histori').html(html);
                   $('#show-histori').css('display', 'block');

                }
            });
        });
        });

</script>
@endpush
@endsection
