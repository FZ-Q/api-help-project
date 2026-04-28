<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use App\Enums\TrainClass;
use Illuminate\Validation\Rule;

class UpdateTrainRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $trainId = $this->route('train')->id;

        return [
            Rule::unique('trains')->ignore($trainId),
            'name' => 'required|string|max:255',
            'class' => ['required', Rule::enum(TrainClass::class)]
        ];
    }
}
