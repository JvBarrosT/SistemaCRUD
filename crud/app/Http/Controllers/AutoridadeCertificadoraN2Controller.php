<?php

namespace App\Http\Controllers;

use App\Models\AutoridadeCertificadora;
use App\Models\AutoridadeCertificadoraN2;
use Illuminate\Http\Request;

class AutoridadeCertificadoraN2Controller extends Controller
{
    public function index()
    {
        $n2s = AutoridadeCertificadoraN2::with('ac')->orderBy('nome')->paginate(20);
        return view('n2s.index', compact('n2s'));
    }

    public function create()
    {
        return view('n2s.form', [
            'n2'  => new AutoridadeCertificadoraN2(),
            'acs' => AutoridadeCertificadora::orderBy('nome')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'autoridade_certificadora_id' => 'required|exists:autoridade_certificadoras,id',
            'origem_id' => 'required|integer|unique:autoridade_certificadora_n2s,origem_id',
            'nome'      => 'required|string|max:255',
            'tipo'      => 'nullable|string|max:50',
            'situacao'  => 'nullable|integer',
        ]);

        AutoridadeCertificadoraN2::create($data);
        return redirect()->route('n2s.index')->with('ok', 'AC N2 criada!');
    }

    public function show(AutoridadeCertificadoraN2 $n2)
    {
        return redirect()->route('n2s.edit', $n2);
    }

    public function edit(AutoridadeCertificadoraN2 $n2)
    {
        return view('n2s.form', [
            'n2'  => $n2,
            'acs' => AutoridadeCertificadora::orderBy('nome')->get(),
        ]);
    }

    public function update(Request $request, AutoridadeCertificadoraN2 $n2)
    {
        $data = $request->validate([
            'autoridade_certificadora_id' => 'required|exists:autoridade_certificadoras,id',
            'nome'     => 'required|string|max:255',
            'tipo'     => 'nullable|string|max:50',
            'situacao' => 'nullable|integer',
        ]);

        $n2->update($data);
        return redirect()->route('n2s.index')->with('ok', 'AC N2 atualizada!');
    }

    public function destroy(AutoridadeCertificadoraN2 $n2)
    {
        $n2->delete();
        return back()->with('ok', 'AC N2 removida!');
    }
}