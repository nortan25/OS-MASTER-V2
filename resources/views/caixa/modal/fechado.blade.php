
    

    <!-- Modal para fechar o caixa -->
    <div class="modal fade" id="modalFecharCaixa" tabindex="-1" aria-labelledby="modalFecharCaixaLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalFecharCaixaLabel">Fechar Caixa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Tem certeza que deseja fechar o caixa?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="btnConfirmarFecharCaixa">Confirmar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            // Evento para confirmação de fechamento do caixa
            $('#btnConfirmarFecharCaixa').on('click', function() {
                // Obtém o valor total do dia da tabela
                var totalDia = $('#totalDia').text().replace('R$ ', '').trim(); // Ajustado para capturar o texto do elemento
                console.log('Total do Dia:', totalDia); // Adiciona um console.log para debug

                // Exibe um diálogo de confirmação para o usuário com SweetAlert2
                Swal.fire({
                    title: 'Tem certeza?',
                    text: totalDia < 0 ? 'O valor total do dia está negativo. Deseja fechar o caixa mesmo assim?' : 'Deseja fechar o caixa?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sim, fechar!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Chama a função para registrar o valor total do dia
                        registrarValorTotalDia(totalDia);
                    }
                });
            });

            // Função para registrar o valor total do dia na tabela
            function registrarValorTotalDia(totalDia) {
                // Obtém o token CSRF do meta tag
                var csrfToken = $('meta[name="csrf-token"]').attr('content');

                // Faz a requisição AJAX para o Laravel
                $.ajax({
                    type: "POST",
                    url: "{{ route('registrar.valor.total.dia') }}",
                    dataType: "json",
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    data: {
                        totalDia: totalDia
                    },
                    success: function(response) {
                        if (response.success) {
                            console.log('Valor total do dia registrado com sucesso:', response.message);
                            Swal.fire({
                                icon: 'success',
                                title: 'Sucesso!',
                                text: 'Caixa fechado com sucesso!',
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                location.reload();
                            });
                            // Aqui você pode adicionar a lógica para atualizar a tabela ou realizar outras ações necessárias
                        } else {
                            console.error('Erro ao fechar caixa:', response.message);
                            Swal.fire({
                                icon: 'error',
                                title: 'Erro!',
                                text: 'Erro ao fechar caixa. Por favor, tente novamente.',
                                timer: 3000,
                                showConfirmButton: false
                            }).then(() => {
                                location.reload();
                            });
                        }
                        // Fecha o modal após a conclusão do processo
                        $('#modalFecharCaixa').modal('hide');
                    },
                    error: function(xhr, status, error) {
                        console.error('Erro na requisição AJAX:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Erro!',
                            text: 'Erro ao fechar caixa. Por favor, tente novamente.',
                            timer: 3000,
                            showConfirmButton: false
                        });
                        // Fecha o modal após a conclusão do processo
                        $('#modalFecharCaixa').modal('hide');
                    }
                });
            }
        });
    </script>
</body>
</html>
