<?php

namespace App\Http\Controllers;

use App\Models\AutoridadeCertificadora;
use Illuminate\Http\Request;

class AutoridadeCertificadoraController extends Controller
{
    public function index()
    {
        $acs = AutoridadeCertificadora::orderBy('nome')->paginate(20);
        return view('acs.index', compact('acs'));
    }

    public function create()
    {
        return view('acs.form', ['ac' => new AutoridadeCertificadora()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'origem_id' => 'required|integer|unique:autoridade_certificadoras,origem_id',
            'nome'      => 'required|string|max:255',
            'tipo'      => 'nullable|string|max:50',
            'telefone'  => 'nullable|string|max:50',
            'situacao'  => 'nullable|integer',
        ]);

        AutoridadeCertificadora::create($data);
        return redirect()->route('acs.index')->with('ok', 'AC criada com sucesso!');
    }

    public function show(AutoridadeCertificadora $ac)
    {
        return redirect()->route('acs.edit', $ac);
    }

    public function edit(AutoridadeCertificadora $ac)
    {
        return view('acs.form', compact('ac'));
    }

    public function update(Request $request, AutoridadeCertificadora $ac)
    {
        $data = $request->validate([
            'nome'     => 'required|string|max:255',
            'tipo'     => 'nullable|string|max:50',
            'telefone' => 'nullable|string|max:50',
            'situacao' => 'nullable|integer',
        ]);

        $ac->update($data);
        return redirect()->route('acs.index')->with('ok', 'AC atualizada!');
    }

    public function destroy(AutoridadeCertificadora $ac)
    {
        $ac->delete();
        return back()->with('ok', 'AC removida!');
    }
}