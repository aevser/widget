@section('title') {{ 'Статистика заявок' }} @endsection

@extends('layouts.app')

@section('content')
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">

            @include('components.aside.aside')

            <div class="layout-page">
                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">

                        <h3 class="mb-4">Статистика заявок</h3>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">За сутки</h5>
                                        <h2 class="mb-0">{{ $day }}</h2>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">За неделю</h5>
                                        <h2 class="mb-0">{{ $week }}</h2>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">За месяц</h5>
                                        <h2 class="mb-0">{{ $month }}</h2>
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
