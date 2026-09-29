<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Autoridades Certificadoras (AC)
        </h2>
    </x-slot>

    <div class="py-8 max-w-6xl mx-auto sm:px-6 lg:px-8">

        @if (session('ok'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('ok') }}</div>
        @endif

        <div class="bg-white p-6 shadow rounded">
            <div class="mb-4 flex justify-between items-center">
                <a href="{{ route('acs.create') }}"
                   class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    + Nova AC
                </a>
                <a href="{{ route('import.index') }}" class="text-sm text-gray-600 underline">Importar JSON</a>
            </div>

            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b">
                        <th class="py-2">ID JSON</th>
                        <th class="py-2">Nome</th>
                        <th class="py-2">Tipo</th>
                        <th class="py-2">Telefone</th>
                        <th class="py-2">Situação</th>
                        <th class="py-2 text-right">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($acs as $ac)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-2">{{ $ac->origem_id }}</td>
                            <td class="py-2">{{ $ac->nome }}</td>
                            <td class="py-2">{{ $ac->tipo }}</td>
                            <td class="py-2">{{ $ac->telefone }}</td>
                            <td class="py-2">{{ $ac->situacao }}</td>
                            <td class="py-2 text-right space-x-2">
                                <button type="button" class="btn-qr text-purple-600 underline"
                                        data-url="{{ route('acs.show', $ac) }}">
                                    QRCode
                                </button>
                                <a href="{{ route('acs.edit', $ac) }}" class="text-blue-600 underline">Editar</a>

                                <form action="{{ route('acs.destroy', $ac) }}" method="POST" class="inline"
                                      onsubmit="return confirm('Remover esta AC?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600 underline">Excluir</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="py-4 text-center text-gray-500">Nenhuma AC cadastrada.</td></tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-4">{{ $acs->links() }}</div>
        </div>
    </div>

    {{-- Modal do QRCode --}}
    <div id="qr-modal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,.6); z-index:50;">
        <div style="background:#fff; padding:24px; margin:80px auto; width:320px; border-radius:8px; text-align:center;">
            <img id="qr-img" src="" alt="QRCode" style="width:100%; display:block;">
            <p id="qr-url" class="text-xs text-gray-500 mt-3 break-all"></p>
            <button onclick="document.getElementById('qr-modal').style.display='none'"
                    class="mt-4 px-4 py-2 bg-gray-200 rounded">Fechar</button>
        </div>
    </div>

    <script>
        document.querySelectorAll('.btn-qr').forEach(function (botao) {
            botao.addEventListener('click', function () {
                var url = botao.dataset.url;
                document.getElementById('qr-img').src = '/qrcode?url=' + encodeURIComponent(url);
                document.getElementById('qr-url').textContent = url;
                document.getElementById('qr-modal').style.display = 'block';
            });
        });
    </script>
</x-app-layout>