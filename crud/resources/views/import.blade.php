<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Importar JSON
        </h2>
    </x-slot>

    <div class="py-8 max-w-2xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 shadow rounded">

            @if (session('ok'))
                <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                    {{ session('ok') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('import.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="file" name="arquivo" accept=".json,.txt"
                       class="block w-full mb-4 border p-2 rounded">

                <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Importar
                </button>
            </form>

            <p class="mt-4 text-sm text-gray-500">
                Formato esperado: o <code>structure.json</code> do site
                <a href="https://estrutura.iti.gov.br/assets/structure.json"
                   class="text-blue-600 underline" target="_blank">estrutura.iti.gov.br</a>.
            </p>
        </div>
    </div>
</x-app-layout>