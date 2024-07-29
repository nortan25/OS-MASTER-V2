
    <style>
        .model-description {
            font-size: 12px;
            color: #666;
            margin-top: 5px;
        }
        .model-preview-button {
            margin-top: 5px;
        }
        @media (max-width: 576px) {
            .form-group {
                margin-bottom: 1rem;
            }
        }
    </style>
</head>
<body>
   
       
            <div class="card-header">Controle de Modelos</div>
            <div class="card-body">
                <!-- Formulário de Controle de Modelos -->
                <form id="modeloForm" method="POST" action="{{ route('atualizar.modelo.ordem') }}">
                    @csrf
                    <!-- Campos ocultos para garantir que campos não marcados enviem 0 -->
                    <input type="hidden" name="modelo_1" value="0">
                    <input type="hidden" name="modelo_2" value="0">
                    <input type="hidden" name="modelo_3" value="0">
                    <input type="hidden" name="modelo_4" value="0">

                    <div class="row">
                        <!-- Caixa de seleção para Modelo 1 -->
                        <div class="col-12 col-md-6 col-lg-3">
                            <div class="form-group">
                                <input type="radio" name="modelo" id="modelo_1" class="form-check-input" value="1">
                                <label for="modelo_1" class="form-check-label">Modelo 1</label>
                                <div class="model-description">Modelo econômico 2 vias em 1 folha</div>
                                <button type="button" class="btn btn-info btn-sm model-preview-button" onclick="openPreview('modelo_1')">Pré-visualizar</button>
                            </div>
                        </div>

                        <!-- Caixa de seleção para Modelo 2 -->
                        <div class="col-12 col-md-6 col-lg-3">
                            <div class="form-group">
                                <input type="radio" name="modelo" id="modelo_2" class="form-check-input" value="2">
                                <label for="modelo_2" class="form-check-label">Modelo 2</label>
                                <div class="model-description">Descrição do Modelo 2</div>
                                <button type="button" class="btn btn-info btn-sm model-preview-button" onclick="openPreview('modelo_2')">Pré-visualizar</button>
                            </div>
                        </div>

                        <!-- Caixa de seleção para Modelo 3 -->
                        <div class="col-12 col-md-6 col-lg-3">
                            <div class="form-group">
                                <input type="radio" name="modelo" id="modelo_3" class="form-check-input" value="3">
                                <label for="modelo_3" class="form-check-label">Modelo 3</label>
                                <div class="model-description">Descrição do Modelo 3</div>
                                <button type="button" class="btn btn-info btn-sm model-preview-button" onclick="openPreview('modelo_3')">Pré-visualizar</button>
                            </div>
                        </div>

                        <!-- Caixa de seleção para Modelo 4 -->
                        <div class="col-12 col-md-6 col-lg-3">
                            <div class="form-group">
                                <input type="radio" name="modelo" id="modelo_4" class="form-check-input" value="4">
                                <label for="modelo_4" class="form-check-label">Modelo 4</label>
                                <div class="model-description">Descrição do Modelo 4</div>
                                <button type="button" class="btn btn-info btn-sm model-preview-button" onclick="openPreview('modelo_4')">Pré-visualizar</button>
                            </div>
                        </div>
                    </div>

                    <!-- Botão de envio -->
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Inclui o script de SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.getElementById('modeloForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Evita o envio padrão do formulário

            // Cria o FormData para enviar os dados
            const formData = new FormData(this);

            // Adiciona valores dos campos selecionados
            const selectedModel = document.querySelector('input[name="modelo"]:checked');
            if (selectedModel) {
                formData.set('modelo_' + selectedModel.value, 1);
            }

            // Envia os dados via AJAX
            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                // Exibe o alerta de sucesso
                Swal.fire({
                    title: 'Sucesso!',
                    text: data.message || 'Modelos atualizados com sucesso!',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            })
            .catch(error => {
                // Exibe o alerta de erro
                Swal.fire({
                    title: 'Erro!',
                    text: 'Houve um erro ao atualizar os modelos.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            });
        });

        function openPreview(model) {
            // Cria um formulário para enviar a requisição de pré-visualização
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `preview/${model}`;
            
            // Adiciona um campo CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const csrfField = document.createElement('input');
            csrfField.type = 'hidden';
            csrfField.name = '_token';
            csrfField.value = csrfToken;
            form.appendChild(csrfField);

            // Adiciona o campo do modelo
            const modelField = document.createElement('input');
            modelField.type = 'hidden';
            modelField.name = 'model';
            modelField.value = model;
            form.appendChild(modelField);

            // Adiciona o formulário ao body e o envia
            document.body.appendChild(form);
            form.submit();
        }
    </script>
</body>
</html>
