<!DOCTYPE html>
<html>
<head>
  <style>
    @page {
      size: A4; /* Tamanho do papel */
      margin: 3mm; /* Margens further reduced */
    }

    body {
      font-family: Arial, sans-serif;
      font-size: 9px; /* Smaller font size */
      line-height: 1.2; /* Reduced line spacing */
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
    left: 80; /* Posiciona a logo do cliente à esquerda */
}

.company-logo {
    right: 80; /* Posiciona a logo da empresa à direita */
}


    .content { /* Assuming this is your form container class */
      flex: 1; /* Makes content fill remaining space */
    }

    .title {
      margin-left: 250px; /* Adjust as needed */
      font-size: 13px;
      margin-top:30px;
    }

    .section {
      margin-bottom: 5px;
      border: 1px solid #ccc;
      padding: 2px;
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
      padding: 2px;
      text-align: left;
      font-size: 9px; /* Smaller text for client data */
      
    }

    .signature-block {
      margin-top: 10px;
      text-align: center;
    }

    .signature-line {
      border-bottom: 1px solid #ccc;
      padding-bottom: 2px;
      margin-bottom: 5px;
    }
  </style>
</head>
<body>
<div class="header">
    <div class="logo-container">
        <img src="{{ $imageBase64 }}" alt="Logo Cliente" class="client-logo">
    </div>
    <p class="title">ASSISTÊNCIA TÉCNICA ESPECIALIZADA</p>
    <p class="title">----------------ORDEM DE SERVICO----------------</p>

  <div class="section">
    <h2 class="section-title">DADOS DO CLIENTE</h2>
    <table class="client-table">
      <tbody>
        <tr>
          <th>Nome:</th>
          <td>{{ $ordem->cliente }}</td>
        </tr>
        <tr>
          <th>Endereço:</th>
          <td>{{ $ordem->rua }}, {{ $ordem->bairro }}</td>
        </tr>
        <tr>
          <th>CEP:</th>
          <td>{{ $ordem->cep }}</td>
        </tr>
        <tr>
          <th>Cidade:</th>
          <td>{{ $ordem->cidade }}</td>
        </tr>
        <tr>
          <th>Estado:</th>
          <td>{{ $ordem->state }}</td>
        </tr>
        <tr>
          <th>Telefone:</th>
          <td>{{ $ordem->phone_number }}</td>
        </tr>
       
      </tbody>
    </table>
  </div>

  <div class="section">
    <h2 class="section-title">EQUIPAMENTO</h2>
    <div class="field">
      <label for="equipamentoMarca">Marca:</label>
      <span>{{ $ordem->marca }}</span>
    </div>
    <div class="field">
      <label for="equipamentoModelo">Modelo:</label>
      <span>{{ $ordem->modelo }}</span>
    </div>
    
    <div class="field">
      <label for="servico">Serviço a ser realizado:</label>
      <span>{{ $ordem->problema }}</span>
    </div>
  </div>

  <div class="section">
    <h2 class="section-title">OBSERVAÇÕES</h2>
    <p>{{ $ordem->observacoes }}</p>
  </div>

  <div class="signature-block">
    <p>__________________________________________________________________________________</p>
    <p class="signature-line">Assinatura do Cliente</p>

    
  </div>

  <div class="section">
    <p class="section-title">ORDEM DE SERVIÇO Nº {{ $ordem->id }}</p>
    <p>DATA: {{ $ordem->created_at->format('d/m/Y') }}</p>
  </div>
---------------------  ---------------------  ------------------------------  ------------------  ------------------------  ------------------------ --------------------------- ---------------  ----------------------------- -----------------
<div class="logo-container">
        <img src="{{ $imageBase64 }}" alt="Logo Empresa" class="company-logo">
    </div>
    <p class="title">ASSISTÊNCIA TÉCNICA ESPECIALIZADA</p>
    <p class="title">---------------ORDEM DE SERVICO----------------</p>
</header>

  <div class="section">
    <h2 class="section-title">DADOS DO CLIENTE</h2>
    <table class="client-table">
      <tbody>
        <tr>
          <th>Nome:</th>
          <td>{{ $ordem->cliente }}</td>
        </tr>
        <tr>
          <th>Endereço:</th>
          <td>{{ $ordem->rua }}, {{ $ordem->bairro }}</td>
        </tr>
        <tr>
          <th>CEP:</th>
          <td>{{ $ordem->cep }}</td>
        </tr>
        <tr>
          <th>Cidade:</th>
          <td>{{ $ordem->cidade }}</td>
        </tr>
        <tr>
          <th>Estado:</th>
          <td>{{ $ordem->state }}</td>
        </tr>
        <tr>
          <th>Telefone:</th>
          <td>{{ $ordem->phone_number }}</td>
        </tr>
        <tr>
          
        </tr>
      </tbody>
    </table>
  </div>

  <div class="section">
    <h2 class="section-title">EQUIPAMENTO</h2>
    <div class="field">
      <label for="equipamentoMarca">Marca:</h2>
   <div>
  <div class="section">
    <h2 class="section-title">EQUIPAMENTO</h2>
    <div class="field">
      <label for="equipamentoMarca">Marca:</label>
      <span>{{ $ordem->marca }}</span>
    </div>
    <div class="field">
      <label for="equipamentoModelo">Modelo:</label>
      <span>{{ $ordem->modelo }}</span>
    </div>
    
    <div class="field">
      <label for="servico">Serviço a ser realizado:</label>
      <span>{{ $ordem->problema }}</span>
    </div>
  </div>

  <div class="section">
    <h2 class="section-title">OBSERVAÇÕES</h2>
    <p>{{ $ordem->observacoes }}</p>
  </div>

  <div class="signature-block">
    <p>__________________________________________________________________________________</p>
    <p class="signature-line">Assinatura do Cliente</p>

    </div>

  <div class="section">
    <p class="section-title">ORDEM DE SERVIÇO Nº {{ $ordem->id }}</p>
    <p>DATA: {{ $ordem->created_at->format('d/m/Y') }}</p>
  </div>
</body>
</html>