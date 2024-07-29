<!DOCTYPE html>
<html>
<head>
  <style>
    @page {
      size: A4;
      margin: 5mm; /* Margens ajustadas para economizar espaço */
    }

    body {
      font-family: Arial, sans-serif;
      font-size: 12px; /* Tamanho de fonte reduzido */
      line-height: 1.6; /* Espaçamento de linha reduzido */
      margin: 0;
      padding: 0;
    }

    .container {
      display: flex;
      flex-direction: column; /* Alterado para coluna para melhor ajuste */
      width: 100%;
      height: 100vh; /* Ajustado para ocupar a altura total da página */
    }

    .form-container {
      width: 100%;
      display: flex;
      flex-direction: column;
      margin: 0;
    }

    .form {
      border: 1px solid #ddd;
      border-radius: 4px;
      padding: 3px; /* Padding reduzido */
      box-sizing: border-box;
      margin-bottom: 0;
      width: calc(100% - 6mm); /* Largura ajustada para caber na página */
    }

    .header {
      display: flex;
      justify-content: center;
      align-items: center;
      border-bottom: 1px solid #ddd;
      padding: 3px 0; /* Padding reduzido */
    }

    .logo-container {
      display: flex;
      align-items: center;
      justify-content: center;
      width: 100%;
    }

    .logo-container img {
      max-width: 300px; /* Largura máxima ajustada */
      max-height: 50px; /* Altura máxima ajustada */
    }

    .title {
      text-align: center;
      font-size: 10px; /* Tamanho da fonte ajustado */
      font-weight: bold;
      margin: 0;
      padding: 0 5px; /* Padding reduzido */
    }

    .section {
      margin: 3px 0; /* Margens ajustadas */
      padding: 3px; /* Padding reduzido */
      border: 1px solid #ddd;
      border-radius: 4px;
    }

    .section-title {
      font-size: 9px; /* Tamanho da fonte ajustado */
      font-weight: bold;
      margin: 0;
      border-bottom: 1px solid #ddd;
      padding: 2px 0; /* Padding reduzido */
    }

    .client-table {
      width: 100%;
      border-collapse: collapse;
    }

    .client-table th, .client-table td {
      border: 1px solid #ddd;
      padding: 2px; /* Padding reduzido */
      text-align: left;
      font-size: 8px; /* Tamanho da fonte ajustado */
    }

    .client-table th {
      background-color: #f9f9f9;
    }

    .signature-block {
      margin: 5px 0;
      text-align: center;
    }

    .signature-line {
      border-bottom: 1px solid #ddd;
      width: 150px; /* Largura ajustada */
      margin: 0 auto;
      padding: 3px;
    }

    .footer {
      border-top: 1px solid #ddd;
      padding: 3px 0; /* Padding reduzido */
      text-align: center;
    }

    .footer p {
      margin: 2px 0;
    }

    .cut-here {
      border-top: 2px dashed #000;
      text-align: center;
      margin: 5px 0; /* Margem reduzida */
      padding: 3px 0; /* Padding reduzido */
      font-size: 10px; /* Tamanho da fonte ajustado */
    }

    .cut-here::before {
      content: "Corte Aqui";
      display: block;
      font-weight: bold;
      margin-bottom: 2px;
    }

    .cut-here .icon {
      font-family: 'Font Awesome 6 Free';
      font-weight: 900;
      font-size: 14px; /* Tamanho do ícone ajustado */
      display: inline-block;
      vertical-align: middle;
      margin-left: 5px;
      margin-right: 5px;
    }

    @media print {
      .container {
        page-break-inside: avoid;
      }
    }
  </style>
  <!-- Link to Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
  <div class="container">
    <div class="form-container">
      <div class="form">
        <div class="header">
          <div class="logo-container">
            <img src="{{ $imageBase64 }}" alt="Logo Cliente" class="client-logo">
            <div class="title">
              ASSISTÊNCIA TÉCNICA ESPECIALIZADA<br>
              ----------------ORDEM DE SERVIÇO----------------
            </div>
          </div>
        </div>

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
          <div>
            <strong>Marca:</strong> {{ $ordem->marca }}
          </div>
          <div>
            <strong>Modelo:</strong> {{ $ordem->modelo }}
          </div>
          <div>
            <strong>Serviço a ser realizado:</strong> {{ $ordem->problema }}
          </div>
        </div>

        <div class="section">
          <h2 class="section-title">OBSERVAÇÕES</h2>
          <p>{{ $ordem->observacoes }}</p>
        </div>

        <div class="signature-block">
          <div class="signature-line">Assinatura do Cliente</div>
        </div>

        <div class="footer">
          <p>ORDEM DE SERVIÇO Nº {{ $ordem->id }}</p>
          <p>DATA: {{ $ordem->created_at->format('d/m/Y') }}</p>
        </div>
      </div>
      <div class="cut-here">
        <span class="icon"><i class="fa-solid fa-cut"></i></span>
      </div>
      <div class="form">
        <div class="header">
          <div class="logo-container">
            <img src="{{ $imageBase64 }}" alt="Logo Cliente" class="client-logo">
            <div class="title">
              ASSISTÊNCIA TÉCNICA ESPECIALIZADA<br>
              ----------------ORDEM DE SERVIÇO----------------
            </div>
          </div>
        </div>

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
          <div>
            <strong>Marca:</strong> {{ $ordem->marca }}
          </div>
          <div>
            <strong>Modelo:</strong> {{ $ordem->modelo }}
          </div>
          <div>
            <strong>Serviço a ser realizado:</strong> {{ $ordem->problema }}
          </div>
        </div>

        <div class="section">
          <h2 class="section-title">OBSERVAÇÕES</h2>
          <p>{{ $ordem->observacoes }}</p>
        </div>

        <div class="signature-block">
          <div class="signature-line">Assinatura do Cliente</div>
        </div>

        <div class="footer">
          <p>ORDEM DE SERVIÇO Nº {{ $ordem->id }}</p>
          <p>DATA: {{ $ordem->created_at->format('d/m/Y') }}</p>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
