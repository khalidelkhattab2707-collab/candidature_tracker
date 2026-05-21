<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCandidatureRequest extends FormRequest
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
            'entreprise'       => ['required', 'string', 'max:255'],
            'poste'            => ['required', 'string', 'max:255'],
            'url_offre'        => ['nullable', 'url', 'max:500'],
            'statut'           => ['required', 'in:' . implode(',', array_keys(Candidature::STATUTS))],
            'priorite'         => ['required', 'in:' . implode(',', array_keys(Candidature::PRIORITES))],
            'notes'            => ['nullable', 'string'],
            'date_candidature' => ['required', 'date'],
        ];
    }
     public function messages(): array
    {
        return [
            'entreprise.required'       => "Le nom de l'entreprise est obligatoire.",
            'poste.required'            => "Le poste visé est obligatoire.",
            'url_offre.url'             => "L'URL de l'offre doit être une adresse valide.",
            'statut.required'           => "Le statut est obligatoire.",
            'priorite.required'         => "La priorité est obligatoire.",
            'date_candidature.required' => "La date de candidature est obligatoire.",
            'date_candidature.date'     => "La date de candidature doit être une date valide.",
        ];
    }
}
