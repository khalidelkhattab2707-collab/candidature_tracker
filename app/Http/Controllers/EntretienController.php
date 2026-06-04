<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEntretienRequest;
use App\Http\Requests\UpdateEntretienRequest;
use App\Models\Candidature;
use App\Models\Entretien;
use Illuminate\Http\Request;

class EntretienController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $entretiens = \App\Models\Entretien::whereHas('candidature', function ($q) {
            $q->where('user_id', auth()->id());
        })
        ->with('candidature')
        ->orderBy('date_heure', 'desc')
        ->paginate(15);

        return view('entretiens.index', compact('entretiens'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEntretienRequest $request, Candidature $candidature)
    {
          $this->authorize('update', $candidature); // L'utilisateur doit posséder la candidature

        $candidature->entretiens()->create($request->validated());

        return redirect()
            ->route('candidatures.show', $candidature)
            ->with('success', 'Entretien ajouté !');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Entretien $entretien)
    {
          $this->authorize('update', $entretien);

        return view('entretiens.edit', [
            'entretien' => $entretien,
            'types'     => Entretien::TYPES,
            'resultats' => Entretien::RESULTATS,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEntretienRequest $request, Entretien $entretien)
    {
        $this->authorize('update', $entretien);

        $entretien->update($request->validated());

        return redirect()
            ->route('candidatures.show', $entretien->candidature)
            ->with('success', 'Entretien mis à jour !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Entretien $entretien)
    {
        $this->authorize('delete', $entretien);

        $candidature = $entretien->candidature;
        $entretien->delete();

        return redirect()
            ->route('candidatures.show', $candidature)
            ->with('success', 'Entretien supprimé.');
    }
    public function avenirs(){
    
        $entretienAvenir=Entretien::where('date_heure',">", now())->get();
        return view('entretienavenir',compact("entretienAvenir"));
    }
}
