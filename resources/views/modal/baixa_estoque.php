<!-- Modal "Dar Baixa no Estoque" -->
<div class="modal fade" id="darBaixaModal" tabindex="-1" aria-labelledby="darBaixaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="darBaixaModalLabel">Dar Baixa no Estoque</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form-baixa-estoque">
                    <!-- Campo de busca e dropdown de produtos -->
                    <div class="mb-3">
                        <label for="produtoSearch">Buscar Produto:</label>
                        <input type="text" class="form-control" id="produtoSearch" placeholder="Digite o nome, tag ou código do produto">
                        <select class="form-control mt-2" id="produtoDropdown" size="5" style="display: none;">
                            <!-- Opções serão adicionadas dinamicamente via AJAX -->
                        </select>
                    </div>
                    <!-- Campo de quantidade -->
                    <div class="mb-3">
                        <label for="quantidade_baixa">Quantidade:</label>
                        <input type="number" class="form-control" id="quantidade_baixa" min="1" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="btnDarBaixa">Dar Baixa</button>
            </div>
        </div>
    </div>
</div>

<!-- CSRF Token for AJAX Requests -->
<meta name="csrf-token" content="{{ csrf_token() }}">


<!-- Script para carregar produtos e dar baixa no estoque -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.all.min.js"></script>

<script>
    $(document).ready(function() {
        const produtoSearch = $('#produtoSearch');
        const produtoDropdown = $('#produtoDropdown');
        const btnDarBaixa = $('#btnDarBaixa');

        // Função para carregar produtos com base no termo de busca
        function loadProdutos(searchTerm = '') {
            $.ajax({
                url: "estoque/todos", // URL direta da rota
                type: 'GET',
                data: { search: searchTerm },
                success: function(data) {
                    produtoDropdown.empty();
                    if (data.length > 0) {
                        data.forEach(function(produto) {
                            produtoDropdown.append($('<option>', {
                                value: produto.id,
                                text: produto.nome_produto
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
                    
                }
            });
        }

        // Evento de digitação no campo de busca
        produtoSearch.keyup(function() {
            const searchTerm = $(this).val().trim();
            loadProdutos(searchTerm);
        });

        // Evento de foco no campo de busca
        produtoSearch.focus(function() {
            const searchTerm = $(this).val().trim();
            if (searchTerm.length > 0) {
                loadProdutos(searchTerm);
            }
        });

        // Evento de clique no campo de busca para mostrar a prévia dos produtos
        produtoSearch.click(function() {
            const searchTerm = $(this).val().trim();
            if (searchTerm.length > 0) {
                loadProdutos(searchTerm);
            }
        });

        // Selecionar um produto no dropdown
        produtoDropdown.change(function() {
            const selectedProduto = $(this).val();
            if (selectedProduto) {
                produtoSearch.val($('#produtoDropdown option:selected').text()); // Atualiza o campo de busca com o nome do produto selecionado
                produtoDropdown.hide(); // Esconde o dropdown após selecionar o produto
            }
        });

        
// Evento de clique no botão "Dar Baixa"
        btnDarBaixa.click(function() {
            const produtoId = produtoDropdown.val();
            const quantidade = $('#quantidade_baixa').val();
            
            // Requisição AJAX para dar baixa no estoque
            $.ajax({
                url: "estoque/baixa", // Rota para dar baixa no estoque
                type: 'POST',
                data: {
                    produto_id: produtoId,
                    quantidade: quantidade,
                    _token: $('meta[name="csrf-token"]').attr('content') // Token CSRF obtido do meta tag
                },
                success: function(response) {
                    $('#darBaixaModal').modal('hide'); // Fechar o modal após sucesso
                    Swal.fire({
                        icon: 'success',
                        title: 'Baixa no Estoque',
                        text: response.success
                    }).then(() => {
                        location.reload(); // Recarregar a página após o alerta (opcional)
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Erro na requisição:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro ao Dar Baixa',
                        text: 'Erro ao dar baixa no estoque. Verifique os dados e tente novamente.'
                    });
                }
            });
        });
    });
</script>