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
            <div class="row">
                <div class="col-md-6">
                    <label class="form-label" for="datepicker">Bulan</label>
                    <div class="input-group mb-3"><span class="input-group-text"><i
                                class="fas fa-calendar-alt"></i></span>
                        <select class="form-control" name="bulan">
                            <option value="">Pilih Bulan</option>
                            @foreach ($bulan as $item)
                            <option value="{{ $item['id'] }}">{{ $item['nama'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="datepicker">Tahun</label>
                    <div class="input-group mb-3"><span class="input-group-text"><i
                                class="fas fa-calendar-alt"></i></span>
                        <select class="form-control" name="tahun">
                            <option value="">Pilih Tahun</option>
                            @foreach ($tahun as $item)
                            <option value="{{ $item->tahun }}">{{ $item->tahun }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

            </div>
            <button class="btn btn-sm btn-outline-primary" type="button" onclick="cetak()"><i class="fa fa-print"></i>
                Cetak</button>
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
        });

        function cetak() {
            var bulan = $(`select[name=bulan]`).val();
            var tahun = $(`select[name=tahun]`).val();
            var nik = $(`select[name=nik]`).val();

            window.open(`{{ url('cetak_rekap_presensi') }}?bulan=${bulan}&tahun=${tahun}&nik=${nik}`, '_blank');
        }
</script>
@endsection
