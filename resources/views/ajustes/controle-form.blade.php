<div class="card-header">Controle de Acesso</div>
<div class="card-body">
    <!-- Formulário de Controle de Acesso -->
    <form id="registerControleForm" method="POST" action="{{ route('register.controle') }}">
        @csrf
        <div class="form-group"> 
            <label for="password">Senha:</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>
        <div class="form-group form-check">
            <input type="checkbox" name="ajustes" id="ajustes" class="form-check-input" value="1">
            <label for="ajustes" class="form-check-label">Ajustes</label>
        </div>
        <div class="form-group form-check">
            <input type="checkbox" name="historico_de_caixa" id="historico_de_caixa" class="form-check-input" value="1">
            <label for="historico_de_caixa" class="form-check-label">Histórico de Caixa</label>
        </div>
        <div class="form-group form-check">
            <input type="checkbox" name="relatorio_lucro" id="relatorio_lucro" class="form-check-input" value="1">
            <label for="relatorio_lucro" class="form-check-label">Relatório de Lucro</label>
        </div>
        <div class="form-group form-check">
            <input type="checkbox" name="relatorio_bruto" id="relatorio_bruto" class="form-check-input" value="1">
            <label for="relatorio_bruto" class="form-check-label">Relatório Bruto</label>
        </div>
        <button type="submit" class="btn btn-primary">Registrar Controle</button>
    </form>
</div>

<!-- Inclui o script de SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('registerControleForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Evita o envio padrão do formulário

        // Cria o FormData para enviar os dados
        const formData = new FormData(this);

        // Adiciona valores dos checkboxes desmarcados
        if (!document.getElementById('ajustes').checked) {
            formData.append('ajustes', 0);
        }
        if (!document.getElementById('historico_de_caixa').checked) {
            formData.append('historico_de_caixa', 0);
        }
        if (!document.getElementById('relatorio_lucro').checked) {
            formData.append('relatorio_lucro', 0);
        }
        if (!document.getElementById('relatorio_bruto').checked) {
            formData.append('relatorio_bruto', 0);
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
                text: data.message || 'Controle registrado com sucesso!',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        })
        .catch(error => {
            // Exibe o alerta de erro
            Swal.fire({
                title: 'Erro!',
                text: 'Houve um erro ao registrar o controle.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        });
    });
</script>
