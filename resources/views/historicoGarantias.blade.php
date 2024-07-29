@extends('layouts.bar')

@section('content')
<div class="container">
    <h1>Histórico de Garantias</h1>

    <div class="mb-3">
        <div class="input-group">
            <input type="text" id="searchInput" class="form-control" placeholder="Pesquisar por produto, tipo de garantia, modelo">
        </div>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Nome do Produto</th>
                <th>Tipo de Garantia</th>
                <th>Modelo do Aparelho</th>
                <th>Tempo de Garantia Produto</th>
                <th>Serviço Realizado</th>
                <th>Tempo de Garantia Serviço</th>
                <th>Data de Criação</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody id="garantiasTable">
            <!-- Linhas preenchidas dinamicamente pelo JavaScript -->
            @foreach ($garantias as $garantia)
            <tr class="garantia-row">
                <td>{{ $garantia->id }}</td>
                <td>{{ $garantia->name }}</td>
                <td>{{ $garantia->nomeProduto }}</td>
                <td>{{ $garantia->tipoGarantia }}</td>
                <td>{{ $garantia->modeloAparelho }}</td>
                <td>{{ $garantia->tempoGarantiaProduto }}</td>
                <td>{{ $garantia->servicoRealizado }}</td>
                <td>{{ $garantia->tempoGarantiaServico }}</td>
                <td>{{ $garantia->created_at }}</td>
                <td>
                    <!-- Botão para imprimir garantia -->
                    <a href="{{ route('gerar_pdf_garantia', '') }}/${garantia.id}" class="btn btn-primary">Imprimir</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
  $(document).ready(function() {
    var searchInput = $('#searchInput');
    var orderBy = 'name'; // Ordenação pelo nome do cliente
    var orderDirection = 'asc'; // Direção padrão

    function fetchGarantias(query = '') {
        $.ajax({
            url: "{{ route('busca_garantias') }}",
            type: 'GET',
            data: {
                query: query,
                order_by: orderBy,
                order_direction: orderDirection
            },
            success: function(data) {
                console.log('Dados recebidos:', data);

                var garantiasTable = $('#garantiasTable');
                garantiasTable.empty();

                data.forEach(function(garantia) {
                    var row = `
                        <tr>
                            <td>${garantia.id}</td>
                            <td>${garantia.name}</td>
                            <td>${garantia.nomeProduto}</td>
                            <td>${garantia.tipoGarantia}</td>
                            <td>${garantia.modeloAparelho}</td>
                            <td>${garantia.tempoGarantiaProduto}</td>
                            <td>${garantia.servicoRealizado}</td>
                            <td>${garantia.tempoGarantiaServico}</td>
                            <td>${garantia.created_at}</td>
                            <td>
                                <a href="{{ route('gerar_pdf_garantia', '') }}/${garantia.id}" class="btn btn-primary">Imprimir</a>
                            </td>
                        </tr>
                    `;

                    garantiasTable.append(row);
                });

                // Esconder linhas da tabela que não correspondem à busca
                hideNonMatchingRows(query);
            },
            error: function(xhr, status, error) {
                console.error('Erro na requisição:', error);
            }
        });
    }

    // Evento de digitação no campo de busca
    searchInput.on('keyup', function() {
        var query = searchInput.val().trim();
        fetchGarantias(query);
    });

    // Função para esconder linhas da tabela que não correspondem à busca
    function hideNonMatchingRows(query) {
        var tableRows = $('#garantiasTable').find('tr'); // Todas as linhas da tabela
        tableRows.each(function(index, row) {
            var rowData = $(row).find('td'); // Células da linha atual

            // Verificar se alguma célula contém o texto da busca
            var found = false;
            rowData.each(function(idx, cell) {
                var cellText = $(cell).text().toLowerCase();
                if (cellText.includes(query.toLowerCase())) {
                    found = true;
                    return false; // Terminar a iteração se encontrou correspondência
                }
            });

            // Mostrar ou esconder a linha com base no resultado da busca
            if (found) {
                $(row).show();
            } else {
                $(row).hide();
            }
        });
    }

    // Chamar fetchGarantias inicialmente para carregar os dados
    fetchGarantias();
});

</script>
