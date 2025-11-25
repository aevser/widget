<?php

namespace App\Http\Requests\Ticket\TicketReply;

use Illuminate\Foundation\Http\FormRequest;

class UpdateManagerReplyRequest extends FormRequest
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
            'user_id' => 'required|integer|exists:users,id',
            'ticket_id' => 'required|integer|exists:tickets,id',
            'message' => 'required|string|min:3|max:5000'
        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'message.required' => 'Поле сообщения обязательно для заполнения',
            'message.string' => 'Сообщение должно быть текстом',
            'message.min' => 'Сообщение должно содержать минимум :min символа',
            'message.max' => 'Сообщение не должно превышать :max символов'
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge(['user_id' => auth()->id(), 'ticket_id' => $this->route('id')]);
    }
}
