<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Despesa Fixa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Botão para abrir o modal -->
    

    <!-- Modal para registrar Despesa Fixa -->
    <div class="modal fade" id="modalRegistrarDespesa" tabindex="-1" aria-labelledby="modalRegistrarDespesaLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalRegistrarDespesaLabel">Registrar Despesa Fixa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formDespesaFixa">
                        <div class="mb-3">
                            <label for="descricaoDespesa" class="form-label">Descrição</label>
                            <input type="text" class="form-control" id="descricaoDespesa" name="descricao" required>
                        </div>
                        <div class="mb-3">
                            <label for="valorDespesa" class="form-label">Valor</label>
                            <input type="number" step="0.01" min="0" class="form-control" id="valorDespesa" name="valor" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger" form="formDespesaFixa">Registrar Despesa</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            $('#formDespesaFixa').on('submit', function(event) {
                event.preventDefault(); // Evita o comportamento padrão de submissão do formulário

                // Obtém os valores dos campos
                var descricao = $('#descricaoDespesa').val();
                var valor = $('#valorDespesa').val();

                // Objeto com os dados a serem enviados para o controller
                var formData = {
                    descricao: descricao,
                    valor: parseFloat(valor),
                    _token: '{{ csrf_token() }}' // Adicione o token CSRF para segurança
                };

                // Envia os dados via AJAX para o controller
                $.ajax({
                    url: '{{ route("registrar.despesa") }}', // Substitua 'registrar.despesa' pela rota adequada do seu controller
                    method: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        // Ação após o sucesso
                        console.log(response); // Exibir no console para depuração
                        Swal.fire({
                            icon: 'success',
                            title: 'Sucesso!',
                            text: 'Despesa fixa registrada com sucesso!',
                            timer: 2000,
                            showConfirmButton: false,
                        }).then(() => {
                            location.reload();
                            
                            willClose: () => {
                                $('#modalRegistrarDespesa').modal('hide'); // Fecha o modal após o registro
                                // Pode incluir a lógica para atualizar a tabela de movimentações, se necessário
                                carregarDadosDoServidor(); // Exemplo de função para recarregar os dados do servidor
                            }
                        });
                    },
                    error: function(xhr, status, error) {
                        // Em caso de erro na requisição AJAX
                        console.error(xhr.responseText); // Exibir detalhes do erro no console para depuração
                        Swal.fire({
                            icon: 'error',
                            title: 'Erro!',
                            text: 'Erro ao registrar a despesa fixa. Verifique os dados e tente novamente.',
                            timer: 3000,
                            showConfirmButton: false,
                        }).then(() => {
                            location.reload();
                            
                        });
                    }
                });
            });
        });
    </script>
</body>
</html>
