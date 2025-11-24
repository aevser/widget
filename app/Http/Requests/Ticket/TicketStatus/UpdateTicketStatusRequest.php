<?php

namespace App\Http\Requests\Ticket\TicketStatus;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTicketStatusRequest extends FormRequest
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
            'status_id' => ['required', 'integer', 'exists:ticket_statuses,id']
        ];
    }

    public function messages(): array
    {
        return [
            'status_id.required' => 'Поле статус обязательно для заполнения',
            'status_id.integer' => 'Статус должен быть числом',
            'status_id.exists' => 'Выбранный статус не существует'
        ];
    }
}
