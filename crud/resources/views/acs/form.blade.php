<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $ac->exists ? 'Editar AC' : 'Nova AC' }}
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
                  action="{{ $ac->exists ? route('acs.update', $ac) : route('acs.store') }}">
                @csrf
                @if ($ac->exists) @method('PUT') @endif

                @if (!$ac->exists)
                    <div class="mb-3">
                        <label class="block text-sm font-medium">ID no JSON (origem_id)</label>
                        <input type="number" name="origem_id" value="{{ old('origem_id') }}"
                               class="block w-full border p-2 rounded" required>
                    </div>
                @endif

                <div class="mb-3">
                    <label class="block text-sm font-medium">Nome</label>
                    <input type="text" name="nome" value="{{ old('nome', $ac->nome) }}"
                           class="block w-full border p-2 rounded" required>
                </div>

                <div class="mb-3">
                    <label class="block text-sm font-medium">Tipo</label>
                    <input type="text" name="tipo" value="{{ old('tipo', $ac->tipo) }}"
                           class="block w-full border p-2 rounded">
                </div>

                <div class="mb-3">
                    <label class="block text-sm font-medium">Telefone</label>
                    <input type="text" name="telefone" value="{{ old('telefone', $ac->telefone) }}"
                           class="block w-full border p-2 rounded">
                </div>

                <div class="mb-3">
                    <label class="block text-sm font-medium">Situação</label>
                    <input type="number" name="situacao" value="{{ old('situacao', $ac->situacao) }}"
                           class="block w-full border p-2 rounded">
                </div>

                <div class="flex gap-3 mt-4">
                    <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Salvar
                    </button>
                    <a href="{{ route('acs.index') }}" class="px-4 py-2 bg-gray-200 rounded">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>