@section('title') {{ 'Просмотр заявки #' . $ticket->id }} @endsection

@extends('layouts.app')

@section('content')

    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">

            @include('components.aside.aside')

            <div class="layout-page">

                @include('components.nav.nav')

                <div class="content-wrapper">

                    <div class="container-xxl flex-grow-1 container-p-y">
                        <h4 class="fw-bold py-3 mb-4">
                            Заявка #{{ $ticket->id }}
                        </h4>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="left-column">
                                    <div class="card">
                                        <h5 class="card-header">Детали заявки</h5>
                                        <div class="card-body">
                                            <div class="mb-2">
                                                <small class="text-muted d-block">ID заявки</small>
                                                <strong>{{ $ticket->id }}</strong>
                                            </div>
                                            <hr class="my-2">
                                            <div class="mb-2">
                                                <small class="text-muted d-block">ID менеджера</small>
                                                <strong>{{ $ticket->replies->first()->user->id ?? '-' }}</strong>
                                            </div>
                                            <hr class="my-2">
                                            <div class="mb-2">
                                                <small class="text-muted d-block">Статус</small>
                                                <strong>{{ $ticket->status->name ?? '-' }}</strong>
                                            </div>
                                            <hr class="my-2">
                                            <div class="mb-2">
                                                <small class="text-muted d-block">Дата создания</small>
                                                <strong>{{ $ticket->created_at ? $ticket->created_at->format('d.m.Y H:i') : '-' }}</strong>
                                            </div>
                                            <hr class="my-2">
                                            <div class="mb-2">
                                                <small class="text-muted d-block">Дата обновления</small>
                                                <strong>{{ $ticket->updated_at ? $ticket->updated_at->format('d.m.Y H:i') : '-' }}</strong>
                                            </div>
                                            <hr class="my-2">
                                            <div class="mb-0">
                                                <small class="text-muted d-block">Дата ответа менеджера</small>
                                                <strong>{{ $ticket->manager_replied_at ? $ticket->manager_replied_at->format('d.m.Y H:i') : '-' }}</strong>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card">
                                        <h5 class="card-header">Контактная информация</h5>
                                        <div class="card-body">
                                            <div class="mb-2">
                                                <small class="text-muted d-block">Телефон</small>
                                                <strong>{{ $ticket->customer->phone ?? '-' }}</strong>
                                            </div>
                                            <hr class="my-2">
                                            <div class="mb-0">
                                                <small class="text-muted d-block">Email</small>
                                                <strong>{{ $ticket->customer->email ?? '-' }}</strong>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card">
                                        <h5 class="card-header">Прикрепленные файлы</h5>
                                        <div class="card-body">
                                            @php $media = $ticket->getMedia('attachments'); @endphp
                                            @if($media->count() > 0)
                                                <div class="list-group list-group-flush">
                                                    @foreach($media as $file)
                                                        <a href="{{ route('tickets.attachment.download', ['id' => $ticket->id, 'media' => $file->id]) }}"
                                                           class="list-group-item list-group-item-action d-flex align-items-center px-0 py-2">
                                                            <i class="bx bx-file me-2 fs-5"></i>
                                                            <div class="flex-grow-1 text-truncate">
                                                                <div class="fw-medium text-truncate">{{ $file->file_name }}</div>
                                                                <small class="text-muted">{{ number_format($file->size / 1024, 2) }} KB</small>
                                                            </div>
                                                            <i class="bx bx-download ms-2"></i>
                                                        </a>
                                                    @endforeach
                                                </div>
                                            @else
                                                <p class="text-muted mb-0">Файлы не прикреплены</p>
                                            @endif
                                        </div>
                                    </div>

                                    <div>
                                        <a href="{{ route('tickets.index') }}" class="btn btn-secondary w-100">
                                            <i class="bx bx-arrow-back"></i> Назад к списку
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="right-column">
                                    <div class="card">
                                        <h5 class="card-header">Информация о заявке</h5>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <small class="text-muted d-block">Тема</small>
                                                <strong>{{ $ticket->subject ?? '-' }}</strong>
                                            </div>
                                            <div class="mb-0">
                                                <small class="text-muted d-block">Текст заявки</small>
                                                <p class="mb-0 mt-1">{{ $ticket->message ?? '-' }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card">
                                        <h5 class="card-header">Ответы</h5>
                                        <div class="card-body">
                                            @if($ticket->replies && $ticket->replies->count() > 0)
                                                @foreach($ticket->replies as $reply)
                                                    <div class="mb-3 p-3 border rounded reply-item">
                                                        <div class="d-flex justify-content-between mb-2">
                                                            <strong>{{ $reply->user->name ?? 'Система' }}</strong>
                                                            <small class="text-muted">{{ $reply->created_at->format('d.m.Y в H:i') }}</small>
                                                        </div>
                                                        <div class="reply-content" data-full-text="{{ $reply->message }}">
                                                            <p class="mb-0 reply-text">
                                                                {{ Str::limit($reply->message, 300) }}
                                                            </p>
                                                            @if(strlen($reply->message) > 300)
                                                                <button type="button" class="btn btn-link btn-sm p-0 mt-2 toggle-reply">
                                                                    Показать полностью
                                                                </button>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <p class="text-muted mb-0">Ответов пока нет</p>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="card card-stretch">
                                        <h5 class="card-header">Ответить на заявку</h5>
                                        <div class="card-body">
                                            @if(filled($ticket->manager_replied_at))
                                                <div class="alert alert-info mb-3">
                                                    <i class="bx bx-check-circle me-2"></i>
                                                    Вы уже ответили на эту заявку {{ $ticket->manager_replied_at->format('d.m.Y в H:i') }}
                                                </div>
                                            @endif

                                            <form action="{{ route('tickets.reply', $ticket->id) }}" method="POST">
                                                @csrf
                                                <div class="mb-3">
                                                    <label for="reply_message" class="form-label">Ваш ответ</label>
                                                    <textarea
                                                        class="form-control @error('message') is-invalid @enderror"
                                                        id="reply_message"
                                                        name="message"
                                                        rows="4"
                                                        {{ filled($ticket->manager_replied_at) ? 'disabled' : 'required' }}
                                                    >{{ old('message') }}</textarea>
                                                    @error('message')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <button
                                                    type="submit"
                                                    class="btn btn-primary"
                                                    {{ filled($ticket->manager_replied_at) ? 'disabled' : '' }}
                                                >
                                                    <i class="bx bx-send me-1"></i>
                                                    Отправить ответ
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="content-backdrop fade"></div>
                </div>
            </div>
        </div>

        <div class="layout-overlay layout-menu-toggle"></div>
    </div>

    <style>
        .left-column {
            display: grid;
            grid-template-rows: auto auto auto 1fr;
            gap: 1.5rem;
            height: 100%;
        }

        .right-column {
            display: grid;
            grid-template-rows: auto auto 1fr;
            gap: 1.5rem;
            height: 100%;
        }

        .card-stretch {
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .card-stretch .card-body {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .card-stretch form {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .card-stretch form .mb-3 {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .card-stretch form textarea {
            flex: 1;
            resize: none;
        }

        .list-group-item {
            transition: background-color 0.2s;
        }

        .list-group-item:hover {
            background-color: rgba(0, 0, 0, 0.03);
        }

        .list-group-item .text-truncate {
            max-width: 100%;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleButtons = document.querySelectorAll('.toggle-reply');

            toggleButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const replyContent = this.closest('.reply-content');
                    const replyText = replyContent.querySelector('.reply-text');
                    const fullText = replyContent.dataset.fullText;
                    const isExpanded = this.dataset.expanded === 'true';

                    if (isExpanded) {
                        replyText.textContent = fullText.substring(0, 300) + '...';
                        this.textContent = 'Показать полностью';
                        this.dataset.expanded = 'false';
                    } else {
                        replyText.textContent = fullText;
                        this.textContent = 'Скрыть';
                        this.dataset.expanded = 'true';
                    }
                });
            });
        });
    </script>

@endsection
