<?php

namespace App\Http\Controllers;

use App\Models\AutoridadeCertificadora;
use App\Models\AutoridadeCertificadoraN2;
use App\Models\AutoridadeRegistro;
use Illuminate\Http\Request;

class ImportController extends Controller
{
    public function index()
    {
        return view('import');
    }

    public function store(Request $request)
    {
        $request->validate([
            'arquivo' => 'required|file|extensions:json,txt',
        ]);

        $conteudo = file_get_contents($request->file('arquivo')->getRealPath());
        $json = json_decode($conteudo, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return back()->withErrors([
                'arquivo' => 'Arquivo não é um JSON válido: ' . json_last_error_msg(),
            ]);
        }

        if (!is_array($json) || !isset($json['id'], $json['nome'])) {
            return back()->withErrors([
                'arquivo' => 'JSON sem os campos obrigatórios ("id", "nome").',
            ]);
        }

        $stats = $this->importarAc($json);

        return back()->with('ok', sprintf(
            'Importação concluída: %d AC(s), %d AC N2(s), %d AR(s).',
            $stats['ac'],
            $stats['n2'],
            $stats['ar']
        ));
    }

    /**
     * Percorre: ac-root -> ac-1 -> ac-2 -> ar
     * Criando: ac-root = AC, ac-2 = AC N2, ar = AR
     * Retorna estatísticas: ['ac' => n, 'n2' => n, 'ar' => n]
     */
    private function importarAc(array $node): array
    {
        $stats = ['ac' => 0, 'n2' => 0, 'ar' => 0];

        $ac = AutoridadeCertificadora::updateOrCreate(
            ['origem_id' => $node['id']],
            [
                'nome'            => $node['nome'],
                'tipo'            => $node['tipo'] ?? null,
                'telefone'        => $node['telefone'] ?? null,
                'situacao'        => $node['situacao'] ?? null,
                'atualizado_data' => $node['atualizado_data'] ?? null,
                'atualizado_hora' => $node['atualizado_hora'] ?? null,
            ]
        );
        $stats['ac']++;

        foreach ($node['entidades_vinculadas'] ?? [] as $nivel1) {
            if (($nivel1['tipo'] ?? '') !== 'ac-1') {
                continue;
            }

            foreach ($nivel1['entidades_vinculadas'] ?? [] as $nivel2) {
                if (($nivel2['tipo'] ?? '') !== 'ac-2') {
                    continue;
                }

                $n2 = AutoridadeCertificadoraN2::updateOrCreate(
                    ['origem_id' => $nivel2['id']],
                    [
                        'autoridade_certificadora_id' => $ac->id,
                        'nome'     => $nivel2['nome'],
                        'tipo'     => $nivel2['tipo'],
                        'situacao' => $nivel2['situacao'] ?? null,
                    ]
                );
                $stats['n2']++;

                foreach ($nivel2['entidades_vinculadas'] ?? [] as $arJson) {
                    if (($arJson['tipo'] ?? '') !== 'ar') {
                        continue;
                    }

                    AutoridadeRegistro::updateOrCreate(
                        ['origem_id' => $arJson['id']],
                        [
                            'autoridade_certificadora_n2_id' => $n2->id,
                            'nome'     => $arJson['nome'],
                            'situacao' => $arJson['situacao'] ?? null,
                        ]
                    );
                    $stats['ar']++;
                }
            }
        }

        return $stats;
    }
}