@extends('layout.browser.main')
@section('konten')
<div class="row g-3 mb-3">
    <div class="col-lg-12">
        <div class="row g-3 mb-3">
            <div class="col-sm-3">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="row flex-between-center g-0">
                            <div class="col-6 d-lg-block flex-between-center">
                                <h6 class="mb-2 text-900">Karayawan Hadir</h6>
                                <h4 class="fs-6 fw-normal text-700 mb-0">{{ $rekappresensi->jmlhadir }}</h4>
                            </div>
                            <div class="col-auto h-100">
                                <div style="height:50px;min-width:80px;">
                                    <i class="fas fa-fingerprint text-800 fs-2"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="row flex-between-center g-0">
                            <div class="col-6 d-lg-block flex-between-center">
                                <h6 class="mb-2 text-900">Karayawan Izin</h6>
                                <h4 class="fs-6 fw-normal text-700 mb-0">{{ $rekapizin->jmlizin }}</h4>
                            </div>
                            <div class="col-auto h-100">
                                <div style="height:50px;min-width:80px;">
                                    <i class="far fa-file-alt text-800 fs-2"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="row flex-between-center g-0">
                            <div class="col-6 d-lg-block flex-between-center">
                                <h6 class="mb-2 text-900">Karayawan Sakit</h6>
                                <h4 class="fs-6 fw-normal text-700 mb-0">{{ $rekapizin->jmlsakit }}</h4>
                            </div>
                            <div class="col-auto h-100">
                                <div style="height:50px;min-width:80px;">
                                    <i class="far fa-sad-tear text-800 fs-2"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="row flex-between-center g-0">
                            <div class="col-6 d-lg-block flex-between-center">
                                <h6 class="mb-2 text-900">Karayawan Terlambat</h6>
                                <h4 class="fs-6 fw-normal text-700 mb-0">{{ $rekappresensi->jmlterlambat ?? 0 }}</h4>
                            </div>
                            <div class="col-auto h-100">
                                <div style="height:50px;min-width:80px;">
                                    <i class="far fa-clock text-800 fs-2"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
