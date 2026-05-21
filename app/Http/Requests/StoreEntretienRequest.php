<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreEntretienRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
         return [
            'type'               => ['required', 'in:' . implode(',', array_keys(Entretien::TYPES))],
            'date_heure'         => ['required', 'date'],
            'notes_preparation'  => ['nullable', 'string'],
            'resultat'           => ['required', 'in:' . implode(',', array_keys(Entretien::RESULTATS))],
        ];
    }
    public function messages(): array
    {
        return [
            'type.required'       => "Le type d'entretien est obligatoire.",
            'date_heure.required' => "La date et l'heure sont obligatoires.",
            'date_heure.date'     => "La date et l'heure doivent être valides.",
            'resultat.required'   => "Le résultat est obligatoire.",
        ];
    }
}
