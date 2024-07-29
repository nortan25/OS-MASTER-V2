@extends('layouts.bar')

@section('content')
<div class="container">
    <h1>Histórico de Orcamentos</h1>
    <input type="text" id="searchInput" class="form-control mb-3" placeholder="Digite o nome do cliente..." oninput="searchOrdens(this.value)">

    <div class="table-responsive">
        <table class="table table-sm table-bordered">
            <thead>
                <tr>
                    <th>Cliente</th>
                    <th>Cidade</th>
                    <th>CEP</th>
                    <th>Rua</th>
                    <th>Bairro</th>
                    <th>Modelo</th>
                    <th style="width: 120px;">Problema Relatado</th>
                    <th style="width: 100px;">Ações</th>
                </tr>
            </thead>
            <tbody id="ordensTableBody">
                @foreach($ordens as $ordem)
                <tr>
                    <td>{{ $ordem->cliente }}</td>
                    <td>{{ $ordem->cidade }}</td>
                    <td>{{ $ordem->cep }}</td>
                    <td>{{ $ordem->rua }}</td>
                    <td>{{ $ordem->bairro }}</td>
                    <td>{{ $ordem->modelo }}</td>
                    <td class="text-truncate" style="max-width: 120px;">{{ $ordem->problema }}</td>
                    <td>
                        <a href="{{ route('orcamentos.gerar-pdf', ['id' => $ordem->id]) }}" class="btn btn-primary btn-sm">Imprimir</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
function searchOrdens(value) {
    var searchValue = value.toLowerCase();
    var rows = document.querySelectorAll('#ordensTableBody tr');
    rows.forEach(row => {
        var clientName = row.cells[0].textContent.toLowerCase();
        if (clientName.includes(searchValue)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}
</script>
@endsection
