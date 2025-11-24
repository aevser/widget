<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        #openWidget {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: #3498db;
            color: white;
            border: none;
            border-radius: 50px;
            padding: 15px 25px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(52, 152, 219, 0.4);
            z-index: 9998;
        }

        #openWidget:hover {
            background: #2980b9;
        }

        #widgetOverlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 9999;
        }

        #widgetOverlay.active {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Модалка */
        #widgetModal {
            background: white;
            border-radius: 12px;
            width: 90%;
            max-width: 500px;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
            position: relative;
        }

        /* Header */
        .widget-header {
            padding: 25px;
            border-bottom: 1px solid #eee;
        }

        .widget-header h2 {
            margin: 0 0 5px 0;
            font-size: 22px;
            color: #333;
        }

        .widget-header p {
            margin: 0;
            color: #666;
            font-size: 14px;
        }

        #closeWidget {
            position: absolute;
            top: 20px;
            right: 20px;
            background: none;
            border: none;
            font-size: 28px;
            color: #999;
            cursor: pointer;
            width: 32px;
            height: 32px;
            border-radius: 50%;
        }

        #closeWidget:hover {
            background: #f5f5f5;
            color: #333;
        }

        /* Body */
        .widget-body {
            padding: 25px;
        }

        /* Alert */
        .alert {
            padding: 14px;
            border-radius: 6px;
            margin-bottom: 20px;
            display: none;
        }

        .alert.show {
            display: block;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        /* Form */
        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
            font-size: 14px;
        }

        .form-group label .required {
            color: #e74c3c;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
            font-family: inherit;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #3498db;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }

        .form-group small {
            display: block;
            margin-top: 6px;
            color: #999;
            font-size: 12px;
        }

        .error {
            color: #e74c3c;
            font-size: 12px;
            margin-top: 6px;
            display: none;
        }

        .error.show {
            display: block;
        }

        .submit-btn {
            width: 100%;
            padding: 14px;
            background: #3498db;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
        }

        .submit-btn:hover {
            background: #2980b9;
        }

        .submit-btn:disabled {
            background: #95a5a6;
            cursor: not-allowed;
        }

        .loader {
            border: 3px solid #f3f3f3;
            border-top: 3px solid #3498db;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            animation: spin 1s linear infinite;
            margin: 0 auto;
            display: none;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .loader.show {
            display: block;
        }
    </style>
</head>
<body>
<button id="openWidget">✉️ Обратная связь</button>

<div id="widgetOverlay">
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
                    <input type="text" name="name" required>
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
                    <input type="text" name="subject" required>
                    <div class="error" id="error-subject"></div>
                </div>

                <div class="form-group">
                    <label>Сообщение <span class="required">*</span></label>
                    <textarea name="message" required></textarea>
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
</div>

<script>
    const overlay = document.getElementById('widgetOverlay');
    const form = document.getElementById('ticketForm');
    const loader = document.querySelector('.loader');
    const submitBtn = document.querySelector('.submit-btn');

    document.getElementById('openWidget').onclick = () => {
        overlay.classList.add('active');
        document.body.style.overflow = 'hidden';
    };

    const close = () => {
        overlay.classList.remove('active');
        document.body.style.overflow = '';
    };

    document.getElementById('closeWidget').onclick = close;
    overlay.onclick = (e) => {
        if (e.target === overlay) close();
    };

    const clearErrors = () => {
        document.querySelectorAll('.error').forEach(el => {
            el.textContent = '';
            el.classList.remove('show');
        });
        document.querySelectorAll('.alert').forEach(el => el.classList.remove('show'));
    };

    const showError = (field, msg) => {
        const el = document.getElementById(`error-${field}`);
        if (el) {
            el.textContent = msg;
            el.classList.add('show');
        }
    };

    const showSuccess = (msg) => {
        const el = document.getElementById('successAlert');
        el.textContent = msg;
        el.classList.add('show');
    };

    const showGeneralError = (msg) => {
        const el = document.getElementById('errorAlert');
        el.textContent = msg;
        el.classList.add('show');
    };

    form.onsubmit = async (e) => {
        e.preventDefault();
        clearErrors();

        loader.classList.add('show');
        submitBtn.disabled = true;

        const formData = new FormData(form);

        try {
            const res = await fetch('{{ route("tickets.store") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
                body: formData
            });

            const data = await res.json();

            if (res.ok && data.success) {
                showSuccess(data.message);
                form.reset();
                setTimeout(() => {
                    close();
                    clearErrors();
                }, 2000);
            } else {
                if (data.errors) {
                    Object.keys(data.errors).forEach(field => {
                        showError(field, data.errors[field][0]);
                    });
                } else {
                    showGeneralError(data.message || 'Ошибка отправки');
                }
            }
        } catch (err) {
            console.error(err);
            showGeneralError('Ошибка отправки. Попробуйте позже.');
        } finally {
            loader.classList.remove('show');
            submitBtn.disabled = false;
        }
    };
</script>
</body>
</html>
