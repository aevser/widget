<div class="d-flex gap-2 mb-3">
    <button type="button"
            class="btn btn-primary filter-toggle"
            data-bs-toggle="modal"
            data-bs-target="#filterModal"
            style="height: 38px; min-width: 120px;">
        Фильтр
        @if(request()->hasAny(['status_id', 'date_from', 'date_to', 'email', 'phone']))
            <span class="badge bg-light text-dark ms-1">
                {{ count(array_filter(request()->only(['status_id', 'date_from', 'date_to', 'email', 'phone']))) }}
            </span>
        @endif
    </button>
</div>

<div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('tickets.index') }}" method="GET" id="filterForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="filterModalLabel">Фильтр заявок</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Дата от</label>
                        <input type="date"
                               name="date_from"
                               value="{{ request('date_from') }}"
                               class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Дата до</label>
                        <input type="date"
                               name="date_to"
                               value="{{ request('date_to') }}"
                               class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Статус заявки</label>
                        <div class="filter-scroll-container">
                            @foreach($statuses as $status)
                                <div class="form-check">
                                    <input type="checkbox"
                                           name="status_id[]"
                                           value="{{ $status->id }}"
                                           {{ in_array($status->id, (array) request('status_id', [])) ? 'checked' : '' }}
                                           class="form-check-input"
                                           id="status_{{ $status->id }}">
                                    <label class="form-check-label" for="status_{{ $status->id }}">
                                        {{ $status->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email клиента</label>
                        <input type="email"
                               name="email"
                               value="{{ request('email') }}"
                               class="form-control"
                               placeholder="Введите email">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Телефон клиента</label>
                        <input type="text"
                               name="phone"
                               value="{{ request('phone') }}"
                               class="form-control"
                               placeholder="Введите телефон">
                    </div>

                    @if(request('perPage'))
                        <input type="hidden" name="perPage" value="{{ request('perPage') }}">
                    @endif
                </div>

                <div class="modal-footer justify-content-between">
                    <div>
                        <button type="submit" class="btn btn-primary">Применить</button>
                        <a href="{{ route('tickets.index') }}" class="btn btn-outline-secondary">Сбросить</a>
                    </div>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .filter-scroll-container {
        min-height: 100px;
        max-height: 200px;
        overflow-y: auto;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        background: #fff;
    }

    .form-check {
        margin-bottom: 8px;
    }

    .form-label {
        font-weight: 500;
        margin-bottom: 8px;
    }

    .modal-body {
        max-height: calc(100vh - 200px);
        overflow-y: auto;
        padding: 20px;
    }

    .badge {
        font-size: 0.75rem;
        padding: 0.25em 0.5em;
    }
</style>
