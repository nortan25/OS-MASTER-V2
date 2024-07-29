<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Assistência Técnica Especializada</title>
    <style>
        @page {
            size: A4;
            margin: 20mm;
        }
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            margin: auto;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header img {
            max-width: 200px;
            max-height: 100px;
        }
        .header h1 {
            font-size: 20px;
            margin: 10px 0;
        }
        .section {
            margin-bottom: 20px;
        }
        .section-title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .form-group {
            margin-bottom: 10px;
        }
        .form-group label {
            font-weight: bold;
        }
        .form-group span, .form-group input {
            display: block;
            margin-top: 5px;
        }
        .form-group input {
            width: 100%;
            box-sizing: border-box;
        }
        .checklist-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .checklist-table th, .checklist-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .checklist-table th {
            background-color: #f2f2f2;
        }
        .checklist-table input {
            width: 100%;
            box-sizing: border-box;
        }
        .table-container {
            display: flex;
            justify-content: space-between;
        }
        .table-container > div {
            width: 48%;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="logo.png" alt="Logo">
            <h1>ASSISTÊNCIA TÉCNICA ESPECIALIZADA</h1>
        </div>

        <div class="section">
            <div class="section-title">DADOS DO CLIENTE</div>
            <div class="form-group">
                <label for="clienteNome">Nome:</label>
                <span>[Nome do Cliente]</span>
            </div>
            <div class="form-group">
                <label for="clienteEndereco">Endereço:</label>
                <span>[Endereço do Cliente]</span>
            </div>
            <div class="form-group">
                <label for="clienteCep">CEP:</label>
                <span>[CEP do Cliente]</span>
            </div>
            <div class="form-group">
                <label for="clienteCidade">Cidade:</label>
                <span>[Cidade do Cliente]</span>
            </div>
            <div class="form-group">
                <label for="clienteEstado">Estado:</label>
                <input type="text" id="clienteEstado" name="clienteEstado">
            </div>
            <div class="form-group">
                <label for="clienteTelefone">Telefone:</label>
                <span>[Telefone do Cliente]</span>
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
                <span>[Descrição do Serviço]</span>
            </div>
            <div class="form-group">
                <p class="section-title">ORDEM DE SERVIÇO Nº [ID]</p>
            </div>
            <div class="form-group">
                <p>DATA: [Data]</p>
            </div>
        </div>

        <div class="section">
            <div class="section-title">Checklist Realizado</div>
            <div class="table-container">
                <div>
                    <table class="checklist-table">
                        <thead>
                            <tr>
                                <th>Item</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><td>Autoriza outra pessoa retirar celular?</td></tr>
                            <tr><td>Qual nome?</td></tr>
                            <tr><td>Aparelho reserva?</td></tr>
                            <tr><td>Aparelho tem chip/cartão sd?</td></tr>
                            <tr><td>Tem capa de proteção?</td></tr>
                        </tbody>
                    </table>
                </div>
                <div>
                    <table class="checklist-table">
                        <thead>
                            <tr>
                                <th>Resposta</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><td><input type="text" name="resposta1"></td></tr>
                            <tr><td><input type="text" name="resposta2"></td></tr>
                            <tr><td><input type="text" name="resposta3"></td></tr>
                            <tr><td><input type="text" name="resposta4"></td></tr>
                            <tr><td><input type="text" name="resposta5"></td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
