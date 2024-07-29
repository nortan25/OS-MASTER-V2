<!DOCTYPE html>
<html>
<head>
  <style>
    @page {
      size: A4; /* Tamanho do papel */
      margin: 3mm; /* Margens reduzidas */
    }

    body {
      font-family: Arial, sans-serif;
      font-size: 9px; /* Tamanho de fonte menor */
      line-height: 1.2; /* Espaçamento entre linhas reduzido */
    }

    .header {
      display: flex;
      align-items: center; /* Alinha os itens verticalmente */
      justify-content: space-between; /* Distribui os itens horizontalmente */
    }

    .logo-container {
      position: relative; /* Garante que o posicionamento absoluto funcione corretamente */
    }

    .client-logo, .company-logo {
      max-width: 300px; /* Largura máxima das logos */
      max-height: 90px; /* Altura máxima das logos */
      position: absolute; /* Posicionamento absoluto dentro do container pai */
      top: 0; /* Alinha as logos no topo do container */
    }

    .client-logo {
      left: 80px; /* Posiciona a logo do cliente à esquerda */
    }

    .company-logo {
      right: 80px; /* Posiciona a logo da empresa à direita */
    }

    .title {
      font-size: 13px;
      margin-top: 30px;
      text-align: center; /* Centraliza o título */
    }

    .section {
      margin-bottom: 5px;
      border: 1px solid #ccc;
      padding: 5px; /* Aumenta o padding para melhor visualização */
    }

    .section-title {
      font-size: 11px;
      font-weight: bold;
      margin-bottom: 2px;
    }

    .client-table {
      width: 100%;
      border-collapse: collapse;
    }

    .client-table th, .client-table td {
      border: 1px solid #ccc;
      padding: 5px; /* Aumenta o padding para melhor visualização */
      text-align: left;
      font-size: 9px; /* Tamanho de texto menor para dados do cliente */
    }

    .signature-block {
      margin-top: 10px;
      text-align: center;
    }

    .signature-line {
      border-bottom: 1px solid #ccc;
      padding-bottom: 5px; /* Aumenta o padding para melhor visualização */
      margin-bottom: 5px;
    }
  </style>
</head>
<body>
<div class="header">
    <div class="logo-container">
        <img src="{{ $imageBase64 }}" alt="Logo Cliente" class="client-logo">
    </div>
    <p class="title">GARANTIA DE PRODUTO</p>
    <p class="title">----------------FORMULÁRIO DE GARANTIA----------------</p>
</div>

<div class="section">
    <h2 class="section-title">DADOS DO CLIENTE</h2>
    <table class="client-table">
        <tbody>
            <tr>
                <th>Nome:</th>
                <td>{{ $garantia->name }}</td>
            </tr>
            <tr>
                <th>Endereço:</th>
                <td>{{ $garantia->street }}, {{ $garantia->neighborhood }}</td>
            </tr>
            <tr>
                <th>CEP:</th>
                <td>{{ $garantia->cep }}</td>
            </tr>
            <tr>
                <th>Cidade:</th>
                <td>{{ $garantia->city }}</td>
            </tr>
            <tr>
                <th>Estado:</th>
                <td>{{ $garantia->state }}</td>
            </tr>
            <tr>
                <th>Telefone:</th>
                <td>{{ $garantia->phone_number }}</td>
            </tr>
        </tbody>
    </table>
</div>

<div class="section">
    <h2 class="section-title">DETALHES DA GARANTIA</h2>
    <div class="field">
        <label>Tipo de Garantia:</label>
        <span>{{ $garantia->tipoGarantia }}</span>
    </div>
    <div class="field">
        <label>Nome do Produto:</label>
        <span>{{ $garantia->nomeProduto }}</span>
    </div>
    <div class="field">
        <label>Tempo de Garantia do Produto:</label>
        <span>{{ $garantia->tempoGarantiaProduto }}</span>
    </div>
    <div class="field">
        <label>Serviço Realizado:</label>
        <span>{{ $garantia->servicoRealizado }}</span>
    </div>
    <div class="field">
        <label>Modelo do Aparelho:</label>
        <span>{{ $garantia->modeloAparelho }}</span>
    </div>
    <div class="field">
        <label>Dias de Garantia do Serviço:</label>
        <span>{{ $garantia->tempoGarantiaServico }}</span>
    </div>
</div>

<div class="section">
    <h2 class="section-title">OBSERVAÇÕES</h2>
    <p>{{ $garantia->observacoes }}</p>
</div>

<div class="signature-block">
    <p>__________________________________________________________________________________</p>
    <p class="signature-line">Assinatura do Cliente</p>

    </div>

<div class="section">
    <p class="section-title">FORMULÁRIO DE GARANTIA Nº {{ $garantia->id }}</p>
    <p>DATA: {{ $garantia->created_at->format('d/m/Y') }}</p>
</div>

</body>
</html>
