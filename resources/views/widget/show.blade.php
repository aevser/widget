@extends('layouts.app')

@section('content')
    <div id="widgetModal">
        <div class="widget-header">
            <button id="closeWidget">&times;</button>
            <h2>Обратная связь</h2>
            <p>Мы ответим вам в ближайшее время</p>
        </div>

        <div class="widget-body">
            <div id="successAlert" class="alert alert-success"></div>
            <div id="errorAlert" class="alert alert-error"></div>

            <form id="ticketForm">
                <div class="form-group">
                    <label>Имя <span class="required">*</span></label>
                    <input type="text" name="name">
                    <div class="error" id="error-name"></div>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email">
                    <div class="error" id="error-email"></div>
                </div>

                <div class="form-group">
                    <label>Телефон</label>
                    <input type="tel" name="phone" placeholder="+1234567890">
                    <small>Формат: +1234567890</small>
                    <div class="error" id="error-phone"></div>
                </div>

                <div class="form-group">
                    <label>Тема <span class="required">*</span></label>
                    <input type="text" name="subject">
                    <div class="error" id="error-subject"></div>
                </div>

                <div class="form-group">
                    <label>Сообщение <span class="required">*</span></label>
                    <textarea name="message"></textarea>
                    <div class="error" id="error-message"></div>
                </div>

                <div class="form-group">
                    <label>Файлы</label>
                    <input type="file" name="files[]" multiple accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.gif">
                    <small>Максимум 5 файлов, до 10 МБ</small>
                    <div class="error" id="error-files"></div>
                </div>

                <div class="error" id="error-contact"></div>
                <div class="error" id="error-duplicate"></div>

                <div class="loader"></div>
                <button type="submit" class="submit-btn">Отправить</button>
            </form>
        </div>
    </div>
@endsection
