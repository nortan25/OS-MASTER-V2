<!-- Modal Registrar Saída -->
<div class="modal fade" id="modalRegistrarSaida" tabindex="-1" aria-labelledby="modalRegistrarSaidaLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalRegistrarSaidaLabel">Registrar Saída</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <form id="formRegistrarSaida">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="descricaoSaida" class="form-label">Descrição:</label>
                        <input type="text" class="form-control" id="descricaoSaida" name="descricao" required>
                    </div>
                    <div class="mb-3">
                        <label for="valorSaida" class="form-label">Valor:</label>
                        <input type="number" step="0.01" class="form-control" id="valorSaida" name="valor" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Registrar Saída</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        $('#formRegistrarSaida').on('submit', function(event) {
            event.preventDefault(); // Evita o comportamento padrão de submissão do formulário

            // Obtém os valores dos campos
            var descricao = $('#descricaoSaida').val();
            var valor = $('#valorSaida').val();

            // Objeto com os dados a serem enviados para o controller
            var formData = {
                descricao: descricao,
                valor: parseFloat(valor),
                _token: '{{ csrf_token() }}' // Adicione o token CSRF para segurança
            };

            // Envia os dados via AJAX para o controller
            $.ajax({
                url: '{{ route("registrar.saida") }}', // Substitua 'registrar.saida' pela rota adequada do seu controller
                method: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    // Ação após o sucesso
                    console.log(response); // Exibir no console para depuração
                    Swal.fire({
                        icon: 'success',
                        title: 'Sucesso!',
                        text: 'Saída registrada com sucesso!',
                        timer: 2000,
                        showConfirmButton: false,
                    }).then(() => {
                        location.reload();
                        willClose: () => {
                            $('#modalRegistrarSaida').modal('hide'); // Fecha o modal após o registro
                        }
                    }).then(() => {
                        location.reload();
                    });
                    // Pode incluir a lógica para atualizar a tabela de movimentações, se necessário
                },
                error: function(xhr, status, error) {
                    // Em caso de erro na requisição AJAX
                    console.error(xhr.responseText); // Exibir detalhes do erro no console para depuração
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro!',
                        text: 'Erro ao registrar a saída. Verifique os dados e tente novamente.',
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











