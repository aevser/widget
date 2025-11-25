<?php

namespace App\Http\Requests\V1\Ticket;

use Illuminate\Foundation\Http\FormRequest;

class CreateTicketRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'regex:/^\+[1-9]\d{9,14}$/', 'min:11', 'max:16'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
            'files' => ['nullable', 'array', 'max:5'],
            'files.*' => ['file', 'max:10240', 'mimes:pdf,doc,docx,jpeg,jpg,png,gif']
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Укажите ваше имя',
            'name.max' => 'Имя не должно превышать 255 символов',

            'email.required' => 'Укажите ваш e-mail',
            'email.email' => 'Укажите корректный email',

            'phone.required' => 'Укажите ваш телефон',
            'phone.regex' => 'Укажите телефон в международном формате (например: +1234567890)',
            'phone.min' => 'Телефон должен содержать минимум 11 символов',
            'phone.max' => 'Телефон не должен превышать 16 символов',

            'subject.required' => 'Укажите тему обращения',
            'subject.max' => 'Тема не должна превышать 255 символов',

            'message.required' => 'Напишите сообщение',
            'message.max' => 'Сообщение не должно превышать 5000 символов',

            'files.max' => 'Можно прикрепить максимум 5 файлов',
            'files.*.max' => 'Размер файла не должен превышать 10 МБ',
            'files.*.mimes' => 'Допустимые форматы: PDF, DOC, DOCX, JPG, JPEG, PNG, GIF'
        ];
    }
}
