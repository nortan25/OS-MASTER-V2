<div class="container">
    <div class="header">
        <img src="{{ $imageBase64 }}" alt="Logo" style="max-width: 200px; max-height: 100px;">
        <h1>ASSISTÊNCIA TÉCNICA ESPECIALIZADA</h1>
    </div>

    <div class="section">
        <div class="section-title">DADOS DO CLIENTE</div>
        <div class="form-group">
            <label for="clienteNome">Nome:</label>
            <span>{{ $ordem->cliente }}</span>
        </div>
        
        <div class="form-group">
            <label for="clienteEndereco">Endereço:</label>
            <span>{{ $ordem->rua }}, {{ $ordem->bairro }}</span>
        </div>
        <div class="form-group">
            <label for="clienteCep">CEP:</label>
            <span>{{ $ordem->cep }}</span>
        </div>
        <div class="form-group">
            <label for="clienteCidade">Cidade:</label>
            <span>{{ $ordem->cidade }}</span>
        </div>
        <div class="form-group">
            <label for="clienteEstado">Estado:</label>
            <input type="text" id="clienteEstado" name="clienteEstado">
        </div>
        <div class="form-group">
            <label for="clienteTelefone">Telefone:</label>
            <span>{{ $ordem->phone_number }}</span>
        </div>
        <div class="form-group">
            <label for="clienteEmail">E-mail:</label>
            <input type="email" id="clienteEmail" name="clienteEmail">
        </div>
    </div>

    <div class="section">
        <div class="section-title">EQUIPAMENTO</div>
        <div class="form-group">
            <label for="equipamentoMarca">Marca:</label>
            <input type="text" id="equipamentoMarca" name="equipamentoMarca">
        </div>
        <div class="form-group">
            <label for="equipamentoModelo">Modelo:</label>
            <input type="text" id="equipamentoModelo" name="equipamentoModelo">
        </div>
        <div class="form-group">
            <label for="equipamentoImei">IMEI:</label>
            <input type="text" id="equipamentoImei" name="equipamentoImei">
        </div>
        <div class="form-group">
            <label for="servico">Serviço a ser realizado:</label>
            <span>{{ $ordem->problema }}</span>
        </div>
        <div class="form-group">
            <p class="section-title">ORDEM DE SERVIÇO Nº {{ $ordem->id }}</p>
        </div>
        <div class="form-group">
            <p>DATA: {{ $ordem->created_at->format('d/m/Y') }}</p>
        </div>
    </div>

    <div class="section">
        <div class="section-title">Checklist Realizado</div>
        <div class="form-group" style="display: flex;">
            <div style="width: 50%;">
                <table class="checklist-table">
                    <thead>
                        <tr>
                            <th>Item</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $checklistItems = [
                                "Autoriza outra pessoa retirar celular?",
                                "Qual nome?",
                                "Aparelho reserva?",
                                "Aparelho tem chip/cartão sd?",
                                "Tem capa de proteção?",
                                "Aparelho ligado?",
                                "Aparelho tem imagem?",
                                "Toque na tela funciona?",
                                "Vidro trincado?",
                                "Carcaça/Aro com marcas de uso?",
                                "Chassi amassado ou torto?",
                                "Botões externos funcionam?",
                            ];
                        @endphp
                        @foreach($checklistItems as $item)
                            <tr>
                                <td>{{ $item }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div style="width: 50%;">
                <table class="checklist-table">
                    <thead>
                        <tr>
                            <th>Resposta</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($checklistItems as $item)
                            <tr>
                                <td><input type="text" name="{{ strtolower(str_replace(' ', '', $item)) }}" style="width: 100%;"></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

</body>
</html>
