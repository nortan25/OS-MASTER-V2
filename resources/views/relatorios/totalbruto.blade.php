<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Relatórios</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css"> <!-- Atualização do SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script> <!-- Atualização do SweetAlert2 -->
</head>
<body>
    <div>
        <h1>Relatórios de Caixa Total</h1>

        <form id="reportForm">
            <label for="period">Período:</label>
            <select id="period" name="period">
                <option value="monthly">Mensal</option>
                <option value="daily">Diário</option>
                <option value="weekly">Semanal</option> <!-- Adicionando opção semanal -->
            </select>

            <div id="monthly-options" style="display: none;">
                <label for="year">Ano:</label>
                <input type="number" id="year" name="year" value="{{ date('Y') }}">

                <label for="month">Mês:</label>
                <select id="month" name="month">
                    <option value="">Todos os Meses</option>
                    <option value="1">Janeiro</option>
                    <option value="2">Fevereiro</option>
                    <option value="3">Março</option>
                    <option value="4">Abril</option>
                    <option value="5">Maio</option>
                    <option value="6">Junho</option>
                    <option value="7">Julho</option>
                    <option value="8">Agosto</option>
                    <option value="9">Setembro</option>
                    <option value="10">Outubro</option>
                    <option value="11">Novembro</option>
                    <option value="12">Dezembro</option>
                </select>
            </div>

            <div id="daily-options" style="display: none;">
                <label for="start_date">Data de Início:</label>
                <input type="date" id="start_date" name="start_date">

                <label for="end_date">Data de Fim:</label>
                <input type="date" id="end_date" name="end_date">
            </div>

            <button type="submit">Gerar Relatório</button>
        </form>

        <div>
            <canvas id="reportChart"></canvas>
        </div>
    </div>

    <script>
    let currentChart = null;

    document.getElementById('period').addEventListener('change', function() {
        const period = this.value;
        document.getElementById('monthly-options').style.display = (period === 'monthly') ? 'block' : 'none';
        document.getElementById('daily-options').style.display = (period === 'daily') ? 'block' : 'none';
    });

    document.getElementById('reportForm').addEventListener('submit', function(event) {
        event.preventDefault();

        const formData = new FormData(this);
        fetch('{{ route('relatorios.getReportData') }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            const labels = data.map(item => item.date || (item.month + '/' + item.year));
            const values = data.map(item => item.total);

            // Destrua o gráfico existente se houver
            if (currentChart) {
                currentChart.destroy();
            }

            // Crie um novo gráfico
            const ctx = document.getElementById('reportChart').getContext('2d');
            currentChart = new Chart(ctx, {
                type: 'bar', // Tipo de gráfico
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Total',
                        data: values,
                        backgroundColor: values.map(value => value < 0 ? 'rgba(255, 99, 132, 0.2)' : 'rgba(75, 192, 192, 0.2)'), // Cor de fundo das barras: vermelho para negativos, verde para positivos
                        borderColor: values.map(value => value < 0 ? 'rgba(255, 99, 132, 1)' : 'rgba(75, 192, 192, 1)'), // Cor da borda das barras: vermelho para negativos, verde para positivos
                        borderWidth: 1 // Largura da borda das barras
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: true
                        },
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    const value = tooltipItem.raw;
                                    return tooltipItem.label + ': R$ ' + (typeof value === 'number' ? value.toFixed(2) : value);
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Período'
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Total'
                            },
                            min: Math.min(...values) * 1.1, // Ajusta a escala mínima para acomodar valores negativos
                            ticks: {
                                beginAtZero: true,
                                callback: function(value) {
                                    return 'R$ ' + value;
                                }
                            }
                        }
                    }
                }
            });
        });
    });
    </script>
</body>
</html>
