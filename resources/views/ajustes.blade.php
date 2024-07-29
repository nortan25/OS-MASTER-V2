@extends('layouts.bar')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Configurações do Cliente</div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <!-- Formulário para atualizar nome e e-mail -->
                            <form id="updateNameEmailForm" method="POST" action="{{ route('config.update', Auth::user()->id) }}">
                                @csrf
                                @method('PUT')

                                <div class="form-group">
                                    <label for="name">Nome</label>
                                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name', Auth::user()->name) }}" required autofocus>
                                    <span class="invalid-feedback" role="alert" id="nameError"></span>
                                </div>

                                <div class="form-group">
                                    <label for="email">Endereço de E-Mail</label>
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email', Auth::user()->email) }}" required>
                                    <span class="invalid-feedback" role="alert" id="emailError"></span>
                                </div>

                                <!-- Botões para salvar nome e e-mail -->
                                <div class="form-group text-right">
                                    <button type="button" class="btn btn-primary" id="updateNameEmailBtn">Salvar Nome e E-Mail</button>
                                </div>
                            </form>
                        </div>

                        <div class="col-md-6">
                            <!-- Formulário para redefinir senha -->
                            <form id="resetPasswordForm" method="POST" action="{{ route('password.update') }}">
                                @csrf

                                <div class="form-group">
                                    <label for="current_password">Senha Atual</label>
                                    <input id="current_password" type="password" class="form-control" name="current_password" required>
                                    <span class="invalid-feedback" role="alert" id="currentPasswordError"></span>
                                </div>

                                <div class="form-group">
                                    <label for="password">Nova Senha</label>
                                    <input id="password" type="password" class="form-control" name="password" required>
                                    <span class="invalid-feedback" role="alert" id="passwordError"></span>
                                </div>

                                <div class="form-group">
                                    <label for="password_confirmation">Confirme a Nova Senha</label>
                                    <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required>
                                </div>

                                <!-- Botão para salvar senha -->
                                <div class="form-group text-right">
                                    <button type="button" class="btn btn-primary" id="resetPasswordBtn">Salvar Senha</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <hr>

                    <!-- Visualização e edição da logo -->
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="logo">Logo do Sistema</label>
            <div class="mb-3">
                @if($logo_base64)
                    <img id="logoPreview" src="data:image/jpeg;base64,{{ $logo_base64 }}" alt="Logo do Sistema" style="max-width: 200px;">
                @else
                    <img id="logoPreview" src="{{ asset('images/logo_default.jpg') }}" alt="Logo do Sistema" style="max-width: 200px;">
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group mt-4 mt-md-0 text-md-right">
            <!-- Botão para abrir o modal -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editLogoModal">
                Editar Logo
            </button>
            <!-- Informação de conversão de imagens -->
            <div class="mt-3">
                <p class="text-muted" style="font-size: 0.9em;">
                    Nosso sistema só aceita formatos JPG. Utilize este <a href="https://imagem.online-convert.com/pt/converter-para-jpg" target="_blank" class="text-primary">site de conversão de imagens online</a> para converter sua logo facilmente! Essa logo sera impresa na garantia e na Ordem de serviço 🎨🚀
                </p>
            </div>
        </div>
       
    </div>
     @include('ajustes.controle-form')
</div>
@include('ajustes.modelo-form')

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Edição da Logo -->
<div class="modal fade" id="editLogoModal" tabindex="-1" aria-labelledby="editLogoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editLogoModalLabel">Editar Logo do Sistema</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Formulário para editar a logo -->
                <form id="editLogoForm" action="{{ route('config.updateLogo') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="logoFile">Selecione um arquivo de imagem (apenas JPG)</label>
                        <input type="file" class="form-control-file" id="logoFile" name="logoFile" accept=".jpg,.jpeg">
                        <span class="invalid-feedback" role="alert" id="logoFileError"></span>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="updateLogoBtn">Salvar Logo</button>
            </div>
        </div>
    </div>
</div>

<!-- Inclui o formulário de controle -->
    


@endsection





<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
    $(document).ready(function() {
        // Função genérica para lidar com envio de formulário via AJAX
        function handleFormSubmit(formSelector, successMessage) {
            $(formSelector).on('submit', function(event) {
                event.preventDefault();

                var form = $(this);
                var formData = new FormData(form[0]);

                $.ajax({
                    url: form.attr('action'),
                    method: form.attr('method'),
                    data: formData,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(response) {
                        if (response && response.success) {
                            showSuccessAlert(response.success); // Exibe a mensagem de sucesso do JSON
                            form[0].reset(); // Limpa o formulário após sucesso
                            clearErrorMessages(form); // Limpa mensagens de erro
                        } else {
                            showErrorAlert(response.error || 'Ocorreu um erro ao processar a solicitação.');
                            displayErrorMessages(response.errors || {}, form); // Exibe mensagens de erro, se houver
                        }
                    },
                    error: function(xhr) {
                        showErrorAlert('Ocorreu um erro ao processar a solicitação.');
                    }
                });
            });
        }

        // Função para limpar mensagens de erro
        function clearErrorMessages(formSelector) {
            $(formSelector).find('.invalid-feedback').text('');
        }

        // Função para exibir mensagens de erro
        function displayErrorMessages(errors, formSelector) {
            $.each(errors, function(key, value) {
                $(formSelector).find('#' + key + 'Error').text(value[0]);
            });
        }

        // Função para mostrar alerta de sucesso
        function showSuccessAlert(message) {
            Swal.fire({
                icon: 'success',
                title: 'Sucesso!',
                text: message,
                showConfirmButton: false,
                timer: 2000 // Fecha automaticamente após 2 segundos
            });
        }

        // Função para mostrar alerta de erro
        function showErrorAlert(message) {
            Swal.fire({
                icon: 'error',
                title: 'Erro!',
                html: message
            });
        }

        // Inicialização dos formulários
        handleFormSubmit('#updateNameEmailForm', 'Nome e e-mail atualizados com sucesso.');
        handleFormSubmit('#resetPasswordForm', 'Senha atualizada com sucesso.');

       $(document).ready(function() {
    // Tratamento do formulário de edição de logo
    $('#updateLogoBtn').on('click', function() {
        var form = $('#editLogoForm')[0];
        var formData = new FormData(form);

        $.ajax({
            url: $('#editLogoForm').attr('action'),
            method: $('#editLogoForm').attr('method'),
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
                if (response && response.success) {
                    showSuccessAlert(response.success); // Exibe a mensagem de sucesso do JSON
                    $('#editLogoModal').modal('hide'); // Fecha o modal após sucesso
                    clearErrorMessages(form); // Limpa mensagens de erro
                } else {
                    showErrorAlert(response.error || 'Ocorreu um erro ao processar a solicitação.');
                    displayErrorMessages(response.errors || {}, form); // Exibe mensagens de erro, se houver
                }
            },
            error: function(xhr) {
                showErrorAlert('Ocorreu um erro ao processar a solicitação.');
            }
        });
    });

    // Função para limpar mensagens de erro
    function clearErrorMessages(formSelector) {
        $(formSelector).find('.invalid-feedback').text('');
    }

    // Função para exibir mensagens de erro
    function displayErrorMessages(errors, formSelector) {
        $.each(errors, function(key, value) {
            $(formSelector).find('#' + key + 'Error').text(value[0]);
        });
    }

    // Função para mostrar alerta de sucesso
    function showSuccessAlert(message) {
        Swal.fire({
            icon: 'success',
            title: 'Sucesso!',
            text: message,
            showConfirmButton: false,
            timer: 2000 // Fecha automaticamente após 2 segundos
        });
    }

    // Função para mostrar alerta de erro
    function showErrorAlert(message) {
        Swal.fire({
            icon: 'error',
            title: 'Erro!',
            html: message
        });
    }
});

        // Ao selecionar um arquivo de imagem para a logo, atualiza a pré-visualização
        $('#logoFile').on('change', function() {
            var input = this;

            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#logoPreview').attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
        });

        // Limpar mensagens de erro ao focar nos campos
        $('input').on('focus', function() {
            $(this).siblings('.invalid-feedback').text('');
        });

        // Evento para enviar o formulário de atualização de nome e e-mail via AJAX
        $('#updateNameEmailBtn').on('click', function() {
            var form = $('#updateNameEmailForm');
            var formData = new FormData(form[0]);

            $.ajax({
                url: form.attr('action'),
                method: form.attr('method'),
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    if (response && response.success) {
                        showSuccessAlert(response.success); // Exibe a mensagem de sucesso do JSON
                        clearErrorMessages(form); // Limpa mensagens de erro
                    } else {
                        showErrorAlert(response.error || 'Ocorreu um erro ao processar a solicitação.');
                        displayErrorMessages(response.errors || {}, form); // Exibe mensagens de erro, se houver
                    }
                },
                error: function(xhr) {
                    showErrorAlert('Ocorreu um erro ao processar a solicitação.');
                }
            });
        });

        // Evento para enviar o formulário de redefinição de senha via AJAX
        $('#resetPasswordBtn').on('click', function() {
            var form = $('#resetPasswordForm');
            var formData = new FormData(form[0]);

            $.ajax({
                url: form.attr('action'),
                method: form.attr('method'),
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    if (response && response.success) {
                        showSuccessAlert(response.success); // Exibe a mensagem de sucesso do JSON
                        form[5].reset(); // Limpa o formulário após sucesso
                        clearErrorMessages(form); // Limpa mensagens de erro
                    } else {
                        showErrorAlert(response.error || 'Ocorreu um erro ao processar a solicitação.');
                        displayErrorMessages(response.errors || {}, form); // Exibe mensagens de erro, se houver
                    }
                },
                error: function(xhr) {
                    showErrorAlert('Ocorreu um erro ao processar a solicitação.');
                }
            });
        });
    });
</script>



