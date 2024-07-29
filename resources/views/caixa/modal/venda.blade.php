<!-- Modal Registrar Venda -->
<div class="modal fade" id="modalRegistrarVenda" tabindex="-1" aria-labelledby="modalRegistrarVendaLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalRegistrarVendaLabel">Registrar Venda</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <form id="formRegistrarVenda">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="descricao" class="form-label">Descrição:</label>
                        <input type="text" class="form-control" id="descricao" name="descricao" required>
                    </div>
                    <div class="mb-3">
                        <label for="valor" class="form-label">Valor:</label>
                        <input type="number" step="0.01" class="form-control" id="valor" name="valor" required>
                    </div>
                    <div class="mb-3">
                        <label for="produtoSearch" class="form-label">Buscar Produto: (Opcional)</label>
                        <input type="text" class="form-control" id="produtoSearch" placeholder="Digite o nome, tag ou código do produto">
                        <select class="form-control mt-2" id="produtoDropdown" size="5" style="display: none;">
                            <!-- Opções serão adicionadas dinamicamente via AJAX -->
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Registrar Venda</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Bibliotecas necessárias (JQuery e SweetAlert2) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Script para carregar produtos, registrar venda e dar baixa no estoque -->
<script>
    $(document).ready(function() {
        // Função para carregar produtos com base no termo de busca
        function loadProdutos(searchTerm = '') {
            $.ajax({
                url: "estoque/todos", // URL direta da rota
                type: 'GET',
                data: { search: searchTerm },
                success: function(data) {
                    var produtoDropdown = $('#produtoDropdown');
                    produtoDropdown.empty();
                    if (data.length > 0) {
                        data.forEach(function(produto) {
                            produtoDropdown.append($('<option>', {
                                value: produto.id,
                                text: produto.nome_produto,
                                'data-valor': produto.valor_produto // Adiciona o valor como atributo de dados
                            }));
                        });
                        produtoDropdown.show(); // Mostra o dropdown após carregar os produtos
                    } else {
                        produtoDropdown.append($('<option>', {
                            value: '',
                            text: 'Nenhum produto encontrado'
                        }));
                        produtoDropdown.hide(); // Esconde o dropdown se não houver produtos
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Erro na requisição:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro!',
                        text: 'Erro ao carregar produtos. Tente novamente mais tarde.',
                        timer: 3000,
                        showConfirmButton: false
                    });
                }
            });
        }

        // Eventos para buscar produtos dinamicamente
        $('#produtoSearch').on('keyup focus click', function() {
            const searchTerm = $(this).val().trim();
            loadProdutos(searchTerm);
        });

        // Evento ao selecionar um produto no dropdown
        $('#produtoDropdown').change(function() {
            const selectedProduto = $(this).find('option:selected');
            if (selectedProduto.val()) {
                $('#produtoSearch').val(selectedProduto.text()); // Atualiza o campo de busca com o nome do produto selecionado
                $('#valor').val(selectedProduto.data('valor')); // Atualiza o campo valor com o valor do produto selecionado
                $(this).hide(); // Esconde o dropdown após selecionar o produto
            }
        });

        // Evento de submissão do formulário de Registrar Venda
        $('#formRegistrarVenda').on('submit', function(event) {
            event.preventDefault(); // Evita o comportamento padrão de submissão do formulário

            // Obtém os valores dos campos
            var descricao = $('#descricao').val();
            var valor = $('#valor').val();
            var produto = $('#produtoDropdown').val(); // Valor do produto selecionado no dropdown

            // Objeto com os dados a serem enviados para o controller
            var formData = {
                descricao: descricao,
                valor: valor,
                produto: produto,
                _token: '{{ csrf_token() }}' // Adicione o token CSRF para segurança
            };

            // Envia os dados via AJAX para o controller de registrar venda
            $.ajax({
                url: '{{ route("registrar.venda") }}', // Rota para registrar venda
                method: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    // Ação após o sucesso
                    console.log(response); // Exibir no console para depuração
                    Swal.fire({
                        icon: 'success',
                        title: 'Sucesso!',
                        text: 'Venda registrada com sucesso!',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload(); // Recarregar a página após o alerta (opcional)
                    });
                    $('#modalRegistrarVenda').modal('hide'); // Fecha o modal após o registro
                    darBaixaEstoque(produto, 1); // Chama a função para dar baixa no estoque
                    // Pode incluir a lógica para atualizar a tabela de movimentações, se necessário
                },
                error: function(xhr, status, error) {
                    // Em caso de erro na requisição AJAX
                    console.error(xhr.responseText); // Exibir detalhes do erro no console para depuração
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro!',
                        text: 'Erro ao registrar a venda. Verifique os dados e tente novamente.',
                        timer: 3000,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload(); // Recarregar a página após o alerta (opcional)
                    });
                }
            });
        });

        // Função para dar baixa no estoque
        function darBaixaEstoque(produtoId, quantidade) {
            // Requisição AJAX para dar baixa no estoque
            $.ajax({
                url: "estoque/baixa", // Rota para dar baixa no estoque
                type: 'POST',
                data: {
                    produto_id: produtoId,
                    quantidade: quantidade,
                    _token: $('meta[name="csrf-token"]').attr('content') // Token CSRF obtido do meta tag
                }
            });
        }
    });
</script>
