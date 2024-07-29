<!-- Modal de Registro de Estoque -->
<div class="modal fade" id="registerStockModal" tabindex="-1" role="dialog" aria-labelledby="registerStockModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="registerStockModalLabel">Registrar Estoque</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Formulário de Registro de Estoque -->
                <form id="registerStockForm" class="needs-validation" novalidate>
                    <div class="card-body">
                        <div class="row g-3">
                            <!-- Campo: Nome do Produto -->
                            <div class="col-md-6">
                                <label for="productName" class="form-label">Nome do Produto</label>
                                <input type="text" class="form-control" id="productName" name="productName" placeholder="Digite o nome do produto" required>
                                <div class="invalid-feedback">
                                    Por favor, insira o nome do produto.
                                </div>
                            </div>

                            <!-- Campo: Tag do Produto -->
                            <div class="col-md-6">
                                <label for="productTag" class="form-label">Tag do Produto</label>
                                <input type="text" class="form-control" id="productTag" name="productTag" placeholder="Digite a tag do produto">
                                <div class="invalid-feedback">
                                    Por favor, insira a tag do produto.
                                </div>
                            </div>

                            <!-- Campo: Valor do Produto -->
                            <div class="col-md-6">
                                <label for="productValue" class="form-label">Valor do Produto</label>
                                <input type="number" step="0.01" class="form-control" id="productValue" name="productValue" placeholder="Digite o valor do produto" required>
                                <div class="invalid-feedback">
                                    Por favor, insira o valor do produto.
                                </div>
                            </div>

                            <!-- Campo: Código SKU do Produto -->
                            <div class="col-md-6">
                                <label for="productSKU" class="form-label">Código SKU do Produto</label>
                                <input type="text" class="form-control" id="productSKU" name="productSKU" placeholder="Digite o código SKU do produto">
                                <div class="invalid-feedback">
                                    Por favor, insira o código SKU do produto.
                                </div>
                            </div>

                            <!-- Campo: Quantidade do Produto -->
                            <div class="col-md-6">
                                <label for="productQuantity" class="form-label">Quantidade do Produto</label>
                                <input type="number" class="form-control" id="productQuantity" name="productQuantity" placeholder="Digite a quantidade do produto" required>
                                <div class="invalid-feedback">
                                    Por favor, insira a quantidade do produto.
                                </div>
                            </div>

                            <!-- Campo: Descrição do Produto -->
                            <div class="col-12">
                                <label for="productDescription" class="form-label">Descrição do Produto</label>
                                <textarea class="form-control" id="productDescription" name="productDescription" rows="3" placeholder="Digite uma descrição do produto"></textarea>
                                <div class="invalid-feedback">
                                    Por favor, insira a descrição do produto.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Botão de Submit -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Registrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- CSRF Token for AJAX Requests -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- JavaScript for Form Validation -->
<script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function () {
        'use strict';
        window.addEventListener('load', function () {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function (form) {
                form.addEventListener('submit', function (event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
</script>

<!-- jQuery for AJAX -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('#registerStockForm').submit(function(event) {
            event.preventDefault();

            var productName = $('#productName').val();
            var productTag = $('#productTag').val();
            var productValue = $('#productValue').val();
            var productSKU = $('#productSKU').val();
            var productQuantity = $('#productQuantity').val();
            var productDescription = $('#productDescription').val();

            // Console log para verificar os dados recuperados
            console.log('Nome do Produto:', productName);
            console.log('Tag do Produto:', productTag);
            console.log('Valor do Produto:', productValue);
            console.log('Código SKU do Produto:', productSKU);
            console.log('Quantidade do Produto:', productQuantity);
            console.log('Descrição do Produto:', productDescription);

            // Dados a serem enviados
            var formData = {
                user_id: 1, // Aqui você deve definir o user_id conforme a lógica da sua aplicação
                nome_produto: productName,
                tag_produto: productTag,
                valor_produto: productValue,
                codigo_sku: productSKU,
                quantidade: productQuantity,
                descricao: productDescription
            };

            // Requisição AJAX
            $.ajax({
                type: 'POST',
                url: "{{ route('estoque.create') }}", // Defina sua rota adequada aqui
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                encode: true,
                success: function(data) {
                    // Limpar campos do formulário após o sucesso
                    $('#productName').val('');
                    $('#productTag').val('');
                    $('#productValue').val('');
                    $('#productSKU').val('');
                    $('#productQuantity').val('');
                    $('#productDescription').val('');

                    // Fechar o modal após o sucesso
                    $('#registerStockModal').modal('hide');

                    // Feedback para o usuário
                    alert('Produto registrado com sucesso!');
                },
                error: function(xhr, status, error) {
                    console.error('Erro ao registrar o produto:', error);
                    alert('Erro ao registrar o produto. Verifique o console para mais detalhes.');
                }
            });
        });
    });
</script>
