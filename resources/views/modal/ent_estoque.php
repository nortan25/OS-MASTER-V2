<!-- Modal "Dar Entrada no Estoque" -->
<div class="modal fade" id="darEntradaModal" tabindex="-1" aria-labelledby="darEntradaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="darEntradaModalLabel">Dar Entrada no Estoque</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form-entrada-estoque">
                    <!-- Campo de busca e dropdown de produtos -->
                    <div class="mb-3">
                        <label for="produtoSearchEntrada">Buscar Produto:</label>
                        <input type="text" class="form-control" id="produtoSearchEntrada" placeholder="Digite o nome, tag ou código do produto">
                        <select class="form-control mt-2" id="produtoDropdownEntrada" size="5" style="display: none;">
                            <!-- Opções serão adicionadas dinamicamente via AJAX -->
                        </select>
                    </div>
                    <!-- Campo de quantidade -->
                    <div class="mb-3">
                        <label for="quantidade_entrada">Quantidade:</label>
                        <input type="number" class="form-control" id="quantidade_entrada" min="1" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-success" id="btnDarEntrada">Dar Entrada</button>
            </div>
        </div>
    </div>
</div>

<!-- CSRF Token for AJAX Requests -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Script para carregar produtos e dar entrada no estoque -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.all.min.js"></script>

<script>
    $(document).ready(function() {
        const produtoSearchEntrada = $('#produtoSearchEntrada');
        const produtoDropdownEntrada = $('#produtoDropdownEntrada');
        const btnDarEntrada = $('#btnDarEntrada');

        // Função para carregar produtos com base no termo de busca
        function loadProdutosEntrada(searchTerm = '') {
            $.ajax({
                url: "estoque/todos", // URL direta da rota
                type: 'GET',
                data: { search: searchTerm },
                success: function(data) {
                    produtoDropdownEntrada.empty();
                    if (data.length > 0) {
                        data.forEach(function(produto) {
                            produtoDropdownEntrada.append($('<option>', {
                                value: produto.id,
                                text: produto.nome_produto
                            }));
                        });
                        produtoDropdownEntrada.show(); // Mostra o dropdown após carregar os produtos
                    } else {
                        produtoDropdownEntrada.append($('<option>', {
                            value: '',
                            text: 'Nenhum produto encontrado'
                        }));
                        produtoDropdownEntrada.hide(); // Esconde o dropdown se não houver produtos
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Erro na requisição:', error);
                    
                }
            });
        }

        // Evento de digitação no campo de busca
        produtoSearchEntrada.keyup(function() {
            const searchTerm = $(this).val().trim();
            loadProdutosEntrada(searchTerm);
        });

        // Evento de foco no campo de busca
        produtoSearchEntrada.focus(function() {
            const searchTerm = $(this).val().trim();
            if (searchTerm.length > 0) {
                loadProdutosEntrada(searchTerm);
            }
        });

        // Evento de clique no campo de busca para mostrar a prévia dos produtos
        produtoSearchEntrada.click(function() {
            const searchTerm = $(this).val().trim();
            if (searchTerm.length > 0) {
                loadProdutosEntrada(searchTerm);
            }
        });

        // Selecionar um produto no dropdown
        produtoDropdownEntrada.change(function() {
            const selectedProduto = $(this).val();
            if (selectedProduto) {
                produtoSearchEntrada.val($('#produtoDropdownEntrada option:selected').text()); // Atualiza o campo de busca com o nome do produto selecionado
                produtoDropdownEntrada.hide(); // Esconde o dropdown após selecionar o produto
            }
        });

        // Evento de clique no botão "Dar Entrada"
        btnDarEntrada.click(function() {
            const produtoId = produtoDropdownEntrada.val();
            const quantidade = $('#quantidade_entrada').val();
            
            // Requisição AJAX para dar entrada no estoque
            $.ajax({
                url: "estoque/entrada", // Rota para dar entrada no estoque
                type: 'POST',
                data: {
                    produto_id: produtoId,
                    quantidade: quantidade,
                    _token: $('meta[name="csrf-token"]').attr('content') // Token CSRF obtido do meta tag
                },
                success: function(response) {
                    $('#darEntradaModal').modal('hide'); // Fechar o modal após sucesso
                    Swal.fire({
                        icon: 'success',
                        title: 'Entrada no Estoque',
                        text: response.success
                    }).then(() => {
                        location.reload(); // Recarregar a página após o alerta (opcional)
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Erro na requisição:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro ao Dar Entrada',
                        text: 'Erro ao dar entrada no estoque. Verifique os dados e tente novamente.'
                    });
                }
            });
        });
    });
</script>
