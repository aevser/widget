<?php

namespace App\Http\Requests\Ticket;

use Illuminate\Foundation\Http\FormRequest;

class IndexTicketRequest extends FormRequest
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
            'status_id' => ['nullable', 'array'],
            'status_id.*' => ['integer', 'exists:ticket_statuses,id'],
            'email' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'date_from' => ['nullable', 'date'],
            'date_to' => ['nullable', 'date', 'after_or_equal:date_from'],
            'perPage' => ['nullable', 'integer', 'min:1', 'max:100'],
            'page' => ['nullable', 'integer', 'min:1']
        ];
    }

    public function messages(): array
    {
        return [
            'status_id.array' => 'Статус должен быть массивом',
            'status_id.*.integer' => 'ID статуса должен быть числом',
            'status_id.*.exists' => 'Выбранный статус не существует',

            'email.string' => 'Email должен быть строкой',
            'email.max' => 'Email не должен превышать 255 символов',

            'phone.string' => 'Телефон должен быть строкой',
            'phone.max' => 'Телефон не должен превышать 50 символов',

            'date_from.date' => 'Неверный формат даты начала',
            'date_to.date' => 'Неверный формат даты окончания',
            'date_to.after_or_equal' => 'Дата окончания должна быть больше или равна дате начала',

            'perPage.integer' => 'Количество записей на странице должно быть числом',
            'perPage.min' => 'Минимальное количество записей на странице: 1',
            'perPage.max' => 'Максимальное количество записей на странице: 100',

            'page.integer' => 'Номер страницы должен быть числом',
            'page.min' => 'Номер страницы должен быть больше 0'
        ];
    }
}
