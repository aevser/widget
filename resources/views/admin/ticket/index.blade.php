@section('title') {{ 'Заявки' }} @endsection

@extends('layouts.app')

@section('content')
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">

            @include('components.aside.aside')

            <div class="layout-page">

                <div class="content-wrapper">

                    <div class="container-xxl flex-grow-1 container-p-y">
                        <div class="card">
                            <h5 class="card-header">Список заявок</h5>
                            <div class="table-responsive text-nowrap">
                                <table class="table" style="text-align: center">
                                    <thead>
                                    <tr class="text-nowrap">
                                        <th>#</th>
                                        <th># Менаджера</th>
                                        <th>Телефон</th>
                                        <th>Почта</th>
                                        <th>Статус</th>
                                        <th>Тема</th>
                                        <th>Текст</th>
                                        <th>Дата ответа</th>
                                        <th>Дата создания</th>
                                        <th>Дата обновления</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse ($tickets as $ticket)
                                        <tr>
                                            <td><a href="{{ route('tickets.show', $ticket->id) }}">{{ $ticket->id }}</a></td>
                                            <td>{{ $ticket->replies->first()->user->id ?? '-' }}</td>
                                            <td>{{ $ticket->customer->phone ?? '-' }}</td>
                                            <td>{{ $ticket->customer->email ?? '-' }}</td>
                                            <td>{{ $ticket->status->name ?? '-' }}</td>
                                            <td>{{ $ticket->subject ?? '-' }}</td>
                                            <td>{{ $ticket->message ?? '-' }}</td>
                                            <td>{{ $ticket->manager_replied_at ?? '-' }}</td>
                                            <td>{{ $ticket->created_at ?? '-' }}</td>
                                            <td>{{ $ticket->updated_at ?? '-' }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="10" class="text-center">Заявки не найдены</td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <div class="card-footer">
                                {{ $tickets->links('components.pagination.pagination') }}
                            </div>
                        </div>
                    </div>

                    <div class="content-backdrop fade"></div>
                </div>
            </div>
        </div>

        <div class="layout-overlay layout-menu-toggle"></div>
    </div>

@endsection
