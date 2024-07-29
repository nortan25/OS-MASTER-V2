@extends('layouts.bar')

@section('content')
<div class="container">
    <h1 id="tituloHistorico">Histórico de Caixa - Dia {{ date('d/m/Y') }}</h1>

    <!-- Filtros de Data -->
    <div class="row mb-3">
        <div class="col-md-2">
            <!-- Dropdown para Dia -->
            <div class="form-group">
                <label for="selectDay">Dia:</label>
                <select class="form-control" id="selectDay">
                    <option value="">Selecione o dia</option>
                    <!-- Opções para os dias -->
                    @for ($day = 1; $day <= 31; $day++)
                        <option value="{{ $day }}">{{ $day }}</option>
                    @endfor
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <!-- Dropdown para Mês -->
            <div class="form-group">
                <label for="selectMonth">Mês:</label>
                <select class="form-control" id="selectMonth">
                    <option value="">Selecione o mês</option>
                    <!-- Opções para os meses -->
                    @for ($month = 1; $month <= 12; $month++)
                        <option value="{{ $month }}">{{ strftime('%B', mktime(0, 0, 0, $month, 1)) }}</option>
                    @endfor
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <!-- Dropdown para Ano -->
            <div class="form-group">
                <label for="selectYear">Ano:</label>
                <select class="form-control" id="selectYear">
                    <option value="">Selecione o ano</option>
                    <!-- Opções para os anos -->
                    @php
                        $currentYear = date('Y');
                        $startYear = $currentYear - 10; // Altere conforme necessário
                        $endYear = $currentYear;
                    @endphp
                    @for ($year = $startYear; $year <= $endYear; $year++)
                        <option value="{{ $year }}">{{ $year }}</option>
                    @endfor
                </select>
            </div>
        </div>
        
        <div class="col-md-2">
            <!-- Botão para Aplicar Filtro -->
             <br>
             
            <button id="applyFilter" class="btn btn-primary btn-block">Aplicar Filtro</button>
        </div>
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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    // Função para formatar a data como DD/MM/YYYY
    function formatarData(date) {
        var d = new Date(date),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear();

        if (month.length < 2) month = '0' + month;
        if (day.length < 2) day = '0' + day;

        return [day, month, year].join('/');
    }

    // Função para carregar os dados na tabela
    function carregarDadosCaixas(data) {
        var tbody = $('#tabelaMovimentacoes');

        // Limpa o conteúdo atual da tabela
        tbody.empty();

        // Adiciona as linhas para vendas, saídas e despesas fixas
        for (var i = 0; i < data.caixas.length; i++) {
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

        // Atualiza o título com a data selecionada
        if (data.dataSelecionada) {
            $('#tituloHistorico').text('Histórico de Caixa - Dia ' + data.dataSelecionada);
        }
    }

    // Função para calcular o total do dia
    function calcularTotalDia(caixas) {
        var total = 0;

        // Percorre cada registro de caixa
        for (var i = 0; i < caixas.length; i++) {
            var caixa = caixas[i];

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
        }

        return total;
    }

    // Função para fazer a requisição AJAX e carregar os dados
    function carregarDadosDoServidor(selectedDate) {
        $.ajax({
            type: "GET",
            url: "{{ route('historico.caixa') }}",
            data: selectedDate ? { ano: selectedDate.year, mes: selectedDate.month, dia: selectedDate.day } : {},
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
        // Aplica o filtro ao clicar no botão
        $('#applyFilter').on('click', function() {
            var day = $('#selectDay').val();
            var month = $('#selectMonth').val();
            var year = $('#selectYear').val();

            // Verifica se todos os campos de filtro foram selecionados
            if (day && month && year) {
                var selectedDate = { year: year, month: month, day: day };
                carregarDadosDoServidor(selectedDate);

                // Atualiza o título com a data selecionada
                var dataSelecionada = day + '/' + month + '/' + year;
                $('#tituloHistorico').text('Histórico de Caixa - Dia ' + dataSelecionada);
            } else {
                alert('Por favor, selecione o dia, mês e ano.');
            }
        });
    });
</script>

@endsection
