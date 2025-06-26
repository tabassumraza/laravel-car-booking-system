<?php

namespace App\Http\Requests\Booking;

use Illuminate\Foundation\Http\FormRequest;

class HourlyBookingRequest extends FormRequest
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
            'car_id'         => 'required|exists:carlists,id',
            'start_time'     => 'required|date_format:H:i',
            'duration_hours' => 'required|integer|min:1|max:12',
            'booking_date'   => 'required|date|after_or_equal:today',
        ];
    }
}
