@extends('layouts.bar')

@section('content')
<div class="container">


    <h1>Fluxo de Caixa - Dia {{ now()->format('d/m/Y') }}</h1>
    <style>
        /* CSS para o botão personalizado */
        .btn-custom {
            background-color: #4CAF50; /* Verde */
            color: white;
        }

        .btn-custom:hover {
            background-color: #45a049; /* Verde escuro */
        }
    </style>


    <!-- Botões de Ação -->
    <div class="mb-3">
        <!-- Botão para adicionar valor inicial do caixa -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAdicionarValorInicial">
        Adicionar Valor Inicial
    </button>
        
        <!-- Botões para abrir modais de registro -->
        <!-- Botão para abrir o modal -->
        <button type="button" class="btn btn-custom" data-bs-toggle="modal" data-bs-target="#modalRegistrarVenda">
    Registrar Venda
</button>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalRegistrarSaida">
    Registrar Saída
</button>
<button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalRegistrarDespesa">
        Registrar Despesa Fixa
    </button>
        
        <!-- Botão para fechar o caixa -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalFecharCaixa">
        Fechar Caixa
    </button>
    </div>
    
    <!-- Tabela de Movimentações -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Data</th>
                <th>Descrição</th>
                <th>Tipo</th>
                <th>Valor</th>
            </tr>
        </thead>
        <tbody id="tabelaMovimentacoes">
            <!-- Aqui serão exibidas as movimentações do caixa -->
            <tr id="linhaValorInicial">
                <td>{{ now()->format('d/m/Y H:i') }}</td>
                <td>Valor Inicial</td>
                <td>Inicial</td>
                <td id="valorInicial">R$ 0,00</td> {{-- Valor inicial --}}
            </tr>
            <!-- Outras movimentações serão listadas aqui -->
        </tbody>
        <tfoot>
            <!-- Total do Caixa no Dia -->
            <tr class="table-secondary" id="linhaTotalDia">
                <td colspan="3" class="text-right"><strong>Total do Dia:</strong></td>
                <td id="totalDia"><strong>R$ 0,00</strong></td> {{-- Total do dia --}}
            </tr>
        </tfoot>
    </table>
</div>

@endsection


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    // Função para carregar os dados na tabela
    function carregarDadosCaixas(data) {
        var tbody = $('#tabelaMovimentacoes');

        // Limpa o conteúdo atual da tabela
        tbody.empty();

        // Adiciona a linha para o valor inicial do caixa
if (data.caixas.length > 0 && data.caixas[0].valor_inicial) {
    var valorInicialRow = '<tr id="linhaValorInicial">' +
                            '<td>' + data.caixas[0].created_at + '</td>' +
                            '<td>Valor Inicial</td>' +
                            '<td>Inicial</td>' +
                            '<td id="valorInicial">R$ ' + parseFloat(data.caixas[0].valor_inicial).toFixed(2) + '</td>' +
                          '</tr>';
    tbody.append(valorInicialRow);
}

// Adiciona as linhas para vendas, saídas e despesas fixas
for (var i = 1; i < data.caixas.length; i++) {
    var caixa = data.caixas[i];
    var tipo = caixa.venda ? 'Venda' : (caixa.saida ? 'Saída' : 'Despesa Fixa');
    var valor = caixa.venda || -caixa.saida || -caixa.despesa_fixa;
    var valorAbsoluto = Math.abs(valor);
    
    // Verifica se o valor não é zero e não é nulo
    if (valor !== 0 && valor !== null) {
        var corTexto = tipo === 'Saída' || tipo === 'Despesa Fixa' ? 'red' : 'black';
        var valorFormatado = '<span style="color: ' + corTexto + ';">' + (valor < 0 ? '- ' : '') + 'R$ ' + valorAbsoluto.toFixed(2) + '</span>';
        var row = '<tr>' +
                    '<td>' + caixa.created_at + '</td>' +
                    '<td>' + caixa.descricao + '</td>' +
                    '<td>' + tipo + '</td>' +
                    '<td>' + valorFormatado + '</td>' +
                  '</tr>';
        tbody.append(row);
    }
}


        // Calcula e preenche o total do dia
        var totalDia = calcularTotalDia(data.caixas);
        $('#totalDia').html('<strong>R$ ' + totalDia.toFixed(2) + '</strong>');
    }

    // Função para calcular o total do dia
    function calcularTotalDia(caixas) {
        var total = 0;

        // Percorre cada registro de caixa
        caixas.forEach(function(caixa) {
            // Adiciona o valor inicial do caixa, se houver
            if (caixa.valor_inicial) {
                total += parseFloat(caixa.valor_inicial);
            }

            // Adiciona o valor da venda, se houver
            if (caixa.venda) {
                total += parseFloat(caixa.venda);
            }

            // Subtrai o valor da saída, se houver
            if (caixa.saida) {
                total -= parseFloat(caixa.saida);
            }

            // Subtrai o valor da despesa fixa, se houver
            if (caixa.despesa_fixa) {
                total -= parseFloat(caixa.despesa_fixa);
            }
        });

        return total;
    }

    // Função para fazer a requisição AJAX e carregar os dados
    function carregarDadosDoServidor() {
        $.ajax({
            type: "GET",
            url: "{{ route('caixas.get') }}",
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    carregarDadosCaixas(response.data);
                } else {
                    console.error('Erro ao carregar os dados do servidor:', response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('Erro na requisição AJAX:', error);
            }
        });
    }

    // Carrega os dados iniciais ao carregar a página
    $(document).ready(function() {
        carregarDadosDoServidor();
    });
</script>







<!-- Modal Registrar Saída -->

<!-- Botão para abrir o modal -->




@include('caixa.modal.saida')
@include('caixa.modal.venda')
@include('caixa.modal.inicial')
@include('caixa.modal.inicial')
@include('caixa.modal.despesa')
@include('caixa.modal.fechado')
















































