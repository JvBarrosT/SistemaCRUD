<?php

namespace App\Http\Controllers;

use App\Models\AutoridadeCertificadoraN2;
use App\Models\AutoridadeRegistro;
use Illuminate\Http\Request;

class AutoridadeRegistroController extends Controller
{
    public function index()
    {
        $ars = AutoridadeRegistro::with('n2.ac')->orderBy('nome')->paginate(20);
        return view('ars.index', compact('ars'));
    }

    public function create()
    {
        return view('ars.form', [
            'ar'  => new AutoridadeRegistro(),
            'n2s' => AutoridadeCertificadoraN2::with('ac')->orderBy('nome')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'autoridade_certificadora_n2_id' => 'required|exists:autoridade_certificadora_n2s,id',
            'origem_id' => 'required|integer|unique:autoridade_registros,origem_id',
            'nome'      => 'required|string|max:255',
            'situacao'  => 'nullable|integer',
        ]);

        AutoridadeRegistro::create($data);
        return redirect()->route('ars.index')->with('ok', 'AR criada!');
    }

    public function show(AutoridadeRegistro $ar)
    {
        return redirect()->route('ars.edit', $ar);
    }

    public function edit(AutoridadeRegistro $ar)
    {
        return view('ars.form', [
            'ar'  => $ar,
            'n2s' => AutoridadeCertificadoraN2::with('ac')->orderBy('nome')->get(),
        ]);
    }

    public function update(Request $request, AutoridadeRegistro $ar)
    {
        $data = $request->validate([
            'autoridade_certificadora_n2_id' => 'required|exists:autoridade_certificadora_n2s,id',
            'nome'     => 'required|string|max:255',
            'situacao' => 'nullable|integer',
        ]);

        $ar->update($data);
        return redirect()->route('ars.index')->with('ok', 'AR atualizada!');
    }

    public function destroy(AutoridadeRegistro $ar)
    {
        $ar->delete();
        return back()->with('ok', 'AR removida!');
    }
}