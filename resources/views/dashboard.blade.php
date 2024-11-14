@extends('layout.app')
@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row gy-4 mb-4">
                <div class="col-xl-4 col-lg-4 col-md-12 col-sm-8 col-12">
                    <div class="card h-100">
                        <div class="card-body text-nowrap">
                            <h4 class="card-title mb-1 d-flex gap-2 flex-wrap">
                                Congratulations <strong>Norris!</strong> 🎉
                            </h4>
                            <p class="pb-0">Best seller of the month</p>
                            <h4 class="text-primary mb-1">$42.8k</h4>
                            <p class="mb-2 pb-1">78% of target 🚀</p>
                            <a href="javascript:;" class="btn btn-sm btn-primary">View Sales</a>
                        </div>
                        <img src="{{ asset('sneat/assets/img/illustrations/trophy.png') }}"
                        class="position-absolute bottom-0 end-0 me-3" height="140" alt="view sales" />
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer_script')
    <script src="{{ asset('sneat/assets/js/dashboards-crm.js') }}"></script>
@endsection
