<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\StoreCandidatureRequest;
use App\Http\Requests\UpdateCandidatureRequest;
use App\Models\Candidature;


class CandidatureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
         $candidatures = auth()->user()
            ->candidatures()
            ->with('entretiens')              // Évite le N+1 : charge les entretiens d'un coup
            ->withCount('entretiens')         // Ajoute entretiens_count sans requête sup.
            ->when($request->statut, function ($query, $statut) {
                $query->where('statut', $statut);
            })
            ->when($request->priorite, function ($query, $priorite) {
                $query->where('priorite', $priorite);
            })
            ->latest()
            ->get();

        return view('candidatures.index', [
            'candidatures' => $candidatures,
            'filtres'      => $request->only(['statut', 'priorite']),
            'statuts'      => Candidature::STATUTS,
            'priorites'    => Candidature::PRIORITES,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         return view('candidatures.create', [
            'statuts'  => Candidature::STATUTS,
            'priorites'=> Candidature::PRIORITES,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCandidatureRequest $request)
    {
          // $request->validated() retourne UNIQUEMENT les champs validés
        // On n'utilise pas $request->all() pour éviter l'injection de champs
        auth()->user()->candidatures()->create($request->validated());

        return redirect()
            ->route('candidatures.index')
            ->with('success', 'Candidature créée avec succès !');
    }

    /**
     * Display the specified resource.
     */
    public function show(Candidature $candidature)
    {
        $this->authorize('view', $candidature); // Vérifie la Policy

        $candidature->load('entretiens'); // Charge les entretiens si pas déjà chargés

        return view('candidatures.show', compact('candidature'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Candidature $candidature)
    {
    $this->authorize('update', $candidature);

        return view('candidatures.edit', [
            'candidature' => $candidature,
            'statuts'     => Candidature::STATUTS,
            'priorites'   => Candidature::PRIORITES,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCandidatureRequest $request, Candidature $candidature)
    {
        $this->authorize('update', $candidature);

        $candidature->update($request->validated());

        return redirect()
            ->route('candidatures.show', $candidature)
            ->with('success', 'Candidature mise à jour !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Candidature $candidature)
    {
        $this->authorize('delete', $candidature);

        $candidature->delete(); // Soft delete : remplit deleted_at, ne supprime pas la ligne

        return redirect()
            ->route('candidatures.index')
            ->with('success', 'Candidature archivée.');
    }
       // ── PAGE ARCHIVES ─────────────────────────────────────────
    public function archives()
    {
        $candidatures = auth()->user()
            ->candidatures()
            ->onlyTrashed()              // Retourne SEULEMENT les soft-deleted
            ->latest('deleted_at')
            ->get();

        return view('candidatures.archives', compact('candidatures'));
    }
     // ── RESTAURATION ──────────────────────────────────────────
    public function restore($id)
    {
        // withTrashed() pour inclure les enregistrements soft-deleted dans la requête
        $candidature = Candidature::withTrashed()->findOrFail($id);

        $this->authorize('restore', $candidature);

        $candidature->restore(); // Remet deleted_at à NULL

        return redirect()
            ->route('candidatures.archives')
            ->with('success', 'Candidature restaurée !');
    }
}