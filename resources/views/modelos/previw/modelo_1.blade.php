<!DOCTYPE html>
<html>
<head>
  <style>
    @page {
      size: A4; /* Tamanho do papel */
      margin: 15mm; /* Margens ao redor da página */
    }

    body {
      font-family: Arial, sans-serif;
      font-size: 10px; /* Tamanho de fonte ajustado */
      line-height: 1.4; /* Espaçamento entre linhas ajustado */
      margin: 0;
      padding: 0;
    }

    .container {
      padding: 15mm; /* Adiciona padding para garantir margens internas */
      box-sizing: border-box; /* Inclui o padding na largura total */
    }

    .header {
      display: flex;
      align-items: center; /* Alinha os itens verticalmente */
      justify-content: space-between; /* Distribui os itens horizontalmente */
      margin-bottom: 10px; /* Espaço abaixo do cabeçalho */
    }

    .logo-container {
      display: flex; /* Garante o layout flexível das logos */
      justify-content: space-between; /* Distribui as logos horizontalmente */
      width: 100%; /* Garante que as logos ocupem o espaço disponível */
    }

    .client-logo, .company-logo {
      max-width: 150px; /* Largura máxima das logos */
      max-height: 50px; /* Altura máxima das logos */
    }

    .title {
      text-align: center;
      font-size: 14px;
      margin: 10px 0;
      font-weight: bold;
    }

    .section {
      margin-bottom: 10px;
      border: 1px solid #ccc;
      padding: 10px;
    }

    .section-title {
      font-size: 12px;
      font-weight: bold;
      margin-bottom: 5px;
    }

    .client-table {
      width: 100%;
      border-collapse: collapse;
    }

    .client-table th, .client-table td {
      border: 1px solid #ccc;
      padding: 5px;
      text-align: left;
      font-size: 10px; /* Tamanho de fonte ajustado */
    }

    .signature-block {
      margin-top: 20px;
      text-align: center;
    }

    .signature-line {
      border-bottom: 1px solid #ccc;
      padding-bottom: 5px;
      margin-bottom: 10px;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="header">
      <div class="logo-container">
        <!-- Logo do Cliente -->
        <img src="path/to/client-logo.png" alt="Logo Cliente" class="client-logo">
        <!-- Logo da Empresa -->
       
      </div>
    </div>

    <p class="title">ASSISTÊNCIA TÉCNICA ESPECIALIZADA</p>
    <p class="title">----------------ORDEM DE SERVIÇO----------------</p>

    <div class="section">
      <h2 class="section-title">DADOS DO CLIENTE</h2>
      <table class="client-table">
        <tbody>
          <tr>
            <th>Nome:</th>
            <td>Nome do Cliente</td>
          </tr>
          <tr>
            <th>Endereço:</th>
            <td>Rua do Cliente, Bairro do Cliente</td>
          </tr>
          <tr>
            <th>CEP:</th>
            <td>12345-678</td>
          </tr>
          <tr>
            <th>Cidade:</th>
            <td>Cidade do Cliente</td>
          </tr>
          <tr>
            <th>Estado:</th>
            <td>Estado do Cliente</td>
          </tr>
          <tr>
            <th>Telefone:</th>
            <td>(12) 34567-8901</td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="section">
      <h2 class="section-title">EQUIPAMENTO</h2>
      <div class="field">
        <label>Marca:</label>
        <span>Marca do Equipamento</span>
      </div>
      <div class="field">
        <label>Modelo:</label>
        <span>Modelo do Equipamento</span>
      </div>
      <div class="field">
        <label>Serviço a ser realizado:</label>
        <span>Descrição do Serviço</span>
      </div>
    </div>

    <div class="section">
      <h2 class="section-title">OBSERVAÇÕES</h2>
      <p>Observações adicionais sobre o serviço.</p>
    </div>

    <div class="signature-block">
      <p>__________________________________________________________________________________</p>
      <p class="signature-line">Assinatura do Cliente</p>
    </div>

    <div class="section">
      <p class="section-title">ORDEM DE SERVIÇO Nº 123</p>
      <p>DATA: 01/01/2024</p>
    </div>
  </div>
  ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
  </head>
<body>
  <div class="container">
    <div class="header">
      <div class="logo-container">
        <!-- Logo do Cliente -->
        <img src="path/to/client-logo.png" alt="Logo Cliente" class="client-logo">
        <!-- Logo da Empresa -->
       
      </div>
    </div>

    <p class="title">ASSISTÊNCIA TÉCNICA ESPECIALIZADA</p>
    <p class="title">----------------ORDEM DE SERVIÇO----------------</p>

    <div class="section">
      <h2 class="section-title">DADOS DO CLIENTE</h2>
      <table class="client-table">
        <tbody>
          <tr>
            <th>Nome:</th>
            <td>Nome do Cliente</td>
          </tr>
          <tr>
            <th>Endereço:</th>
            <td>Rua do Cliente, Bairro do Cliente</td>
          </tr>
          <tr>
            <th>CEP:</th>
            <td>12345-678</td>
          </tr>
          <tr>
            <th>Cidade:</th>
            <td>Cidade do Cliente</td>
          </tr>
          <tr>
            <th>Estado:</th>
            <td>Estado do Cliente</td>
          </tr>
          <tr>
            <th>Telefone:</th>
            <td>(12) 34567-8901</td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="section">
      <h2 class="section-title">EQUIPAMENTO</h2>
      <div class="field">
        <label>Marca:</label>
        <span>Marca do Equipamento</span>
      </div>
      <div class="field">
        <label>Modelo:</label>
        <span>Modelo do Equipamento</span>
      </div>
      <div class="field">
        <label>Serviço a ser realizado:</label>
        <span>Descrição do Serviço</span>
      </div>
    </div>

    <div class="section">
      <h2 class="section-title">OBSERVAÇÕES</h2>
      <p>Observações adicionais sobre o serviço.</p>
    </div>

    <div class="signature-block">
      <p>__________________________________________________________________________________</p>
      <p class="signature-line">Assinatura do Cliente</p>
    </div>

    <div class="section">
      <p class="section-title">ORDEM DE SERVIÇO Nº 123</p>
      <p>DATA: 01/01/2024</p>
    </div>
  </div>
</body>
</html>
