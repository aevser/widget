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
    const fieldName = field.split('.')[0];
    const el = document.getElementById(`error-${fieldName}`);
    if (el) {
        if (!el.textContent) {
            el.textContent = msg;
        }
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
        const res = await fetch('api/v1/tickets', {
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
