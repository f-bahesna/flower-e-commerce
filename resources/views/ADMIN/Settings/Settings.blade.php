@extends('layouts.admin.appAdmin')

@section('content')
    <h2>Menu Settings (Coming Soon)</h2>
    <div class="container-fluid">
        <div class="row">
            {{-- foreach --}}
            <div class="col-md-4 mt-4">
                <a href="#" id="settings-carousel">
                    <div class="card">
                        <div class="card-body text-center">
                            <i class="fas fa-3x fa-cart-arrow-down"></i>
                            <h4 class="card-text text-dark">Carousel</h4>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
@endsection