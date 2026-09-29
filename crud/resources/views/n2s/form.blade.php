<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $n2->exists ? 'Editar AC N2' : 'Nova AC N2' }}
        </h2>
    </x-slot>

    <div class="py-8 max-w-2xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 shadow rounded">
            @if ($errors->any())
                <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST"
                  action="{{ $n2->exists ? route('n2s.update', $n2) : route('n2s.store') }}">
                @csrf
                @if ($n2->exists) @method('PUT') @endif

                <div class="mb-3">
                    <label class="block text-sm font-medium">AC Principal</label>
                    <select name="autoridade_certificadora_id" class="block w-full border p-2 rounded" required>
                        <option value="">-- escolha --</option>
                        @foreach ($acs as $ac)
                            <option value="{{ $ac->id }}"
                                @selected(old('autoridade_certificadora_id', $n2->autoridade_certificadora_id) == $ac->id)>
                                {{ $ac->nome }}
                            </option>
                        @endforeach
                    </select>
                </div>

                @if (!$n2->exists)
                    <div class="mb-3">
                        <label class="block text-sm font-medium">ID no JSON (origem_id)</label>
                        <input type="number" name="origem_id" value="{{ old('origem_id') }}"
                               class="block w-full border p-2 rounded" required>
                    </div>
                @endif

                <div class="mb-3">
                    <label class="block text-sm font-medium">Nome</label>
                    <input type="text" name="nome" value="{{ old('nome', $n2->nome) }}"
                           class="block w-full border p-2 rounded" required>
                </div>

                <div class="mb-3">
                    <label class="block text-sm font-medium">Tipo</label>
                    <input type="text" name="tipo" value="{{ old('tipo', $n2->tipo) }}"
                           class="block w-full border p-2 rounded">
                </div>

                <div class="mb-3">
                    <label class="block text-sm font-medium">Situação</label>
                    <input type="number" name="situacao" value="{{ old('situacao', $n2->situacao) }}"
                           class="block w-full border p-2 rounded">
                </div>

                <div class="flex gap-3 mt-4">
                    <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Salvar</button>
                    <a href="{{ route('n2s.index') }}" class="px-4 py-2 bg-gray-200 rounded">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>