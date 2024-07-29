<!-- Modal "Adicionar Técnico" -->
<div class="modal fade" id="modalAdicionarTecnico" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Adicionar Técnico</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Formulário para adicionar técnico -->
                <form id="formAdicionarTecnico" class="needs-validation" novalidate>
                    @csrf
                    <!-- Campo de nome do técnico -->
                    <div class="form-group">
                        <label for="nomeTecnico" class="form-label">Nome do Técnico</label>
                        <input type="text" class="form-control" id="nomeTecnico" name="nomeTecnico" placeholder="Digite o nome do técnico" required>
                        <div class="invalid-feedback">
                            Por favor, insira o nome do técnico.
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <!-- Botão de adicionar técnico -->
                <button type="button" class="btn btn-primary" id="btnAdicionarTecnico">Adicionar</button>
            </div>
        </div>
    </div>
</div>

<!-- CSRF Token for AJAX Requests -->
<meta name="csrf-token" content="{{ csrf_token() }}">








<script>

document.addEventListener('DOMContentLoaded', function() {
    // Inicializa o modal utilizando o seletor correto para o Bootstrap 5
    var modal = new bootstrap.Modal(document.getElementById('modalAdicionarTecnico'));

    // Manipular a submissão do formulário de adicionar técnico
    document.getElementById('btnAdicionarTecnico').addEventListener('click', function() {
        // Recupera o nome do técnico do campo de entrada
        var nomeTecnico = document.getElementById('nomeTecnico').value;

        // Verifica se o nome do técnico não está vazio antes de enviar a solicitação
        if (nomeTecnico.trim() === '') {
            Swal.fire({
                title: 'Erro!',
                text: 'Por favor, insira o nome do técnico.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            return; // Interrompe a execução se o nome estiver vazio
        }

        fetch('adicionar-tecnico', { // Corrigido para corresponder à rota definida
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    },
    body: JSON.stringify({ nomeTecnico: nomeTecnico })
})
        .then(response => {
            if (!response.ok) {
                throw new Error('A resposta do servidor não foi OK');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Fecha o modal
                modal.hide();
                // Exibe um pop-up bonito com a mensagem de sucesso
                Swal.fire({
                    title: 'Sucesso!',
                    text: data.success,
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            } else if (data.error) {
                // Exibe um pop-up bonito com a mensagem de erro
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
            // Exibe um pop-up bonito com a mensagem de erro
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
