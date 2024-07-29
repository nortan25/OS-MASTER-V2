<!-- Modal "Registrar Atendente" -->
<div class="modal fade" id="modalRegistrarAtendente" tabindex="-1" aria-labelledby="modalRegistrarAtendenteLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalRegistrarAtendenteLabel">Registrar Atendente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Formulário para adicionar atendente  -->
                <form id="formRegistrarAtendente" class="needs-validation" novalidate>
                    @csrf
                    <!-- Campo de nome do atendente -->
                    <div class="form-group">
                        <label for="nomeAtendente" class="form-label">Nome do Atendente</label>
                        <input type="text" class="form-control" id="nomeAtendente" name="nomeAtendente" placeholder="Digite o nome do atendente" required>
                        <div class="invalid-feedback">
                            Por favor, insira o nome do atendente.
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <!-- Botão de adicionar atendente -->
                <button type="submit" id="btnRegistrarAtendente" class="btn btn-primary">Salvar</button>
            </div>
        </div>
    </div>
</div>

<!-- CSRF Token for AJAX Requests -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Script para carregar e remover técnicos -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var modalRegistrarAtendente = new bootstrap.Modal(document.getElementById('modalRegistrarAtendente'));

    document.getElementById('btnRegistrarAtendente').addEventListener('click', function() {
        var nomeAtendente = document.getElementById('nomeAtendente').value;

        if (nomeAtendente.trim() === '') {
            Swal.fire({
                title: 'Erro!',
                text: 'Por favor, insira o nome do atendente.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            return;
        }

        fetch('registrar-atendente', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ nomeAtendente: nomeAtendente })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('A resposta do servidor não foi OK');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                modalRegistrarAtendente.hide();
                Swal.fire({
                    title: 'Sucesso!',
                    text: data.success,
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            } else if (data.error) {
                Swal.fire({
                    title: 'Erro!',
                    text: data.error,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        })
        .catch(error => {
            console.error('Ocorreu um erro:', error);
            Swal.fire({
                title: 'Erro!',
                text: 'Não foi possível processar a sua solicitação.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        });
    });
});
</script>
