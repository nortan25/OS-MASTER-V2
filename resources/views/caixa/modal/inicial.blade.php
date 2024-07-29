


    <!-- Modal Adicionar Valor Inicial -->
    <div class="modal fade" id="modalAdicionarValorInicial" tabindex="-1" aria-labelledby="modalAdicionarValorInicialLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAdicionarValorInicialLabel">Adicionar Valor Inicial do Caixa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formAdicionarValorInicial">
                        <div class="mb-3">
                            <label for="valorInicial" class="form-label">Valor Inicial</label>
                            <input type="number" step="0.01" class="form-control" id="valorInicial" name="valorInicial" placeholder="Insira o valor inicial do caixa" required>
                        </div>
                    </form>
                    <div id="mensagem"></div> <!-- Elemento para exibir mensagens de sucesso ou erro -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary" onclick="salvarValorInicial()">Salvar Valor Inicial</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function salvarValorInicial() {
            var valorInicial = document.getElementById('valorInicial').value;
            var userId = {{ auth()->user()->id }}; // Obtém o ID do usuário logado

            // Requisição AJAX para enviar o valor inicial
            $.ajax({
                type: "POST",
                url: "{{ route('caixa.salvar-valor-inicial') }}",
                data: {
                    '_token': '{{ csrf_token() }}',
                    'valorInicial': parseFloat(valorInicial),
                    'user_id': userId
                },
                success: function(response) {
                    if (response.success) {
                        // Exibe a mensagem de sucesso com SweetAlert2
                        Swal.fire({
                            icon: 'success',
                            title: 'Sucesso!',
                            text: response.message,
                            timer: 2000,
                            showConfirmButton: false,
                            timerProgressBar: false,
                        }).then(() => {
                            location.reload();
                            
                        });
                            
                            
                  

                        // Atualiza a tabela com o novo valor inicial, se necessário
                        atualizarTabela(response.data);

                        // Recalcula e atualiza o total do dia
                        var totalDia = calcularTotalDia();
                        $('#totalDia').text('R$ ' + totalDia.toFixed(2));
                    } else {
                        // Exibe a mensagem de erro com SweetAlert2
                        Swal.fire({
                            icon: 'error',
                            title: 'Erro!',
                            text: response.message,
                            timer: 3000,
                            showConfirmButton: false,
                        }).then(() => {
                            location.reload();
                            
                        });
                    }
                },
                error: function(xhr, status, error) {
                    // Exibe a mensagem de erro com SweetAlert2
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro!',
                        text: 'Ocorreu um erro ao salvar o valor inicial do caixa. Por favor, tente novamente.',
                        timer: 3000,
                        showConfirmButton: false,
                    }).then(() => {
                        location.reload();
                        
                    
                    });
                    console.error(xhr.responseText); // Exibe a resposta de erro no console
                }
            });
        }
    </script>
</body>
</html>
