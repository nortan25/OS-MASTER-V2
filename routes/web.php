<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\OrdensController;
use App\Http\Controllers\FuncionarioController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\GarantiaController;
use App\Http\Controllers\OrcamentoController;
use App\Http\Controllers\AjustesController;
use App\Http\Controllers\Auth\ResetPasswordController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\CaixaController;
use App\Http\Controllers\EstoqueController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RelatoriosController;


Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify' => true]);


Route::group(['middleware' => ['auth', 'admin']], function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
});

// Rota para exibir o modal de notificação geral
Route::get('/admin/modal-notificacao-geral', function () {
    return view('admin.modal_notificacao_geral');
})->name('admin.modal.notificacao-geral');

// Rota para enviar notificação
Route::post('/admin/enviar-notificacao', [UserController::class, 'enviarNotificacaoGeral'])
    ->name('admin.enviar.notificacao');

// Rota para buscar usuários por ID ou nome
Route::get('/admin/buscar-usuarios', [UserController::class, 'buscarUsuarios'])
    ->name('admin.buscar.usuarios');


// Rota para o controlador de registro
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Rotas para o controlador de verificação de e-mail
Route::get('/email/verify', [VerificationController::class, 'show'])->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify');
Route::post('/email/resend', [VerificationController::class, 'resend'])->name('verification.resend');



Route::get('/home', [HomeController::class, 'index'])->middleware('verified');
Route::get('/clientes', [ClienteController::class, 'index'])->name('clientes.index');
Route::get('/clientes/adicionar', [ClienteController::class, 'create'])->name('clientes.create');
Route::post('/clientes', [ClienteController::class, 'store'])->name('clientes.store');
Route::get('/clientes/{id}/edit', [ClienteController::class, 'edit'])->name('clientes.edit');
Route::put('clientes/{id}', [ClienteController::class, 'update'])->name('clientes.update');
Route::get('/clientes/search', [ClienteController::class, 'search'])->name('clientes.search');
Route::delete('/clientes/{cliente}', [ClienteController::class, 'destroy'])->name('clientes.destroy');
Route::post('/ordens', [OrdensController::class, 'store'])->name('ordens.store');
Route::get('/adicionar-ordem', [OrdensController::class, 'create'])->name('adicionar_ordem');
Route::get('/buscar-cliente', [OrdensController::class, 'buscarCliente'])->name('buscar_cliente');
Route::get('/clientes/{id}', [OrdensController::class, 'show'])->name('clientes.show');
Route::post('/adicionar-tecnico', [FuncionarioController::class, 'store'])->name('adicionar_tecnico');
Route::post('/registrar-atendente', [FuncionarioController::class, 'create'])->name('registrar-atendente');
Route::delete('/remover-atendente/{id}', [FuncionarioController::class, 'destroy'])->name('remover-atendente');
Route::get('/atendentes', [FuncionarioController::class, 'getAtendentes']);
Route::delete('/remover-tecnico/{id}', [FuncionarioController::class, 'destroyTecnico'])->name('remover-tecnico');
Route::get('/tecnicos', [FuncionarioController::class, 'getTecnicos'])->name('tecnicos');


Route::any('/ajustes', [AjustesController::class, 'ajustes'])->name('ajustes');


Route::any('/preview/{model}', [AjustesController::class, 'previewModel']);




Route::post('/register-controle', [AjustesController::class, 'registerControle'])->name('register.controle');


Route::get('/get-tecnicos', [FuncionarioController::class, 'getTecnicos'])->name('tecnicos');
Route::get('/get-atendentes', [FuncionarioController::class, 'getAtendentes']);
Route::get('/pdf', [PdfController::class, 'gerarPDF'])->name('pdf');
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/pdf/{id}', [PdfController::class, 'gerarPDF'])->name('pdf');
Route::get('/ordens', [OrdensController::class, 'index'])->name('ordens.index');
Route::get('/gerarPDFUltima', [PdfController::class, 'gerarPDFUltima'])->name('gerarPDFUltima');


Route::post('/garantias', [GarantiaController::class, 'store'])->name('garantias.store');

Route::any('/garantias/create', [GarantiaController::class, 'store'])->name('garantias.create');
Route::get('/gerar-pdf-ultima-garantia', [PdfController::class, 'gerarPDFUltimaGarantia'])->name('gerar_pdf_ultima_garantia');
Route::get('/historico_garantias', [GarantiaController::class, 'historicoGarantias'])->name('historico_garantias');
Route::get('gerar-pdf-garantia/{id}', [pdfController::class, 'gerarPDFGarantia'])->name('gerar_pdf_garantia');
Route::get('/busca_garantias', [GarantiaController::class, 'search'])->name('busca_garantias');
Route::get('/adicionar-Orcamento', [OrcamentoController::class, 'orcamento'])->name('adicionar_orcamento');
Route::any('/adicionarOrcamento', [OrcamentoController::class, 'createorcamento'])->name('adicionarorcamento');



Route::get('/gerar-pdf-ultimo-orcamento', [PdfController::class, 'gerarPDFUltimoOrcamento'])->name('gerarPDFUltimoOrcamento');
    
Route::get('/orcamentos', [OrcamentoController::class, 'index'])->name('orcamentos.index');
Route::get('/orcamentos/{id}', [PdfController::class, 'gerarPDFOrcamento'])->name('orcamentos.gerar-pdf');
Route::post('/config/logo', [AjustesController::class, 'updateLogo'])->name('config.updateLogo');
Route::put('/config/{id}', [AjustesController::class, 'update'])->name('config.update');

Route::get('/configuracoes', [AjustesController::class, 'showSettings'])->name('config.show');
Route::put('/configuracoes/{id}', [AjustesController::class, 'update'])->name('config.update');
Route::post('/configuracoes/logo', [AjustesController::class, 'updateLogo'])->name('config.updateLogo');





// Rota para exibir o formulário de esqueci minha senha
Route::get('/forgot-password', [ResetPasswordController::class, 'showLinkRequestForm'])->name('password.request');

// Rota para enviar o email de reset de senha
Route::post('/forgot-password', [ResetPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

// Rota para exibir o formulário de reset de senha
Route::get('reset-password/{token}/{email}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');

// Rota para processar o reset de senha
Route::post('reset-password', [ResetPasswordController::class, 'resetPassword'])->name('password.update');



Route::get('/iniciar-caixa', [CaixaController::class, 'iniciarCaixa'])->name('caixa.iniciar');



// Rota para salvar o valor inicial do caixa
Route::post('/caixa/salvar-valor-inicial', [CaixaController::class, 'salvarValorInicial'])->name('caixa.salvar-valor-inicial');
Route::get('/caixas', [CaixaController::class, 'getCaixas'])->name('caixas.get');
Route::post('/registrar-venda', [CaixaController::class, 'registrarVenda'])->name('registrar.venda');
Route::post('/registrar-saida', [CaixaController::class, 'registrarSaida'])->name('registrar.saida');

Route::post('/registrar-despesa-fixa', [CaixaController::class, 'registrar'])->name('registrar.despesa');
Route::post('/registrar-valor-total-dia', [CaixaController::class, 'registrarValorTotalDia'])->name('registrar.valor.total.dia');


Route::any('/historico-caixa', [CaixaController::class, 'historicoCaixa'])->name('historico.caixa');



Route::post('/estoque', [EstoqueController::class, 'store'])->name('estoque.create');
Route::get('/estoque', [EstoqueController::class, 'index'])->name('estoque.index');

// Rota para atualizar um produto específico
Route::put('/estoque/{produto}', [EstoqueController::class, 'update'])->name('estoque.update');

// Rota para excluir um produto específico
Route::delete('/delete/{produto}', [EstoqueController::class, 'destroy'])->name('estoque.destroy');

Route::get('/usuario/verificar-notificacoes', [UserController::class, 'verificarNotificacoes'])->name('usuario.verificar.notificacoes');




Route::post('estoque/baixa', [EstoqueController::class, 'darBaixa'])->name('estoque.baixa');

Route::post('/atualizar-modelo-ordem', [AjustesController::class, 'atualizarOuCriarModeloOrdem'])->name('atualizar.modelo.ordem');


Route::post('estoque/entrada', [EstoqueController::class, 'darEntrada'])->name('estoque.entrada');

Route::get('estoque/todos', [EstoqueController::class, 'todos'])->name('estoque.todos');
Route::get('caixa/status', [CaixaController::class, 'getCaixaStatus'])->name('caixa.status');











Route::get('/relatorios', [RelatoriosController::class, 'index'])->name('relatorios');
Route::post('/relatorios/data', [RelatoriosController::class, 'getReportData'])->name('relatorios.getReportData');
Route::post('/relatorios/get-profit-report-data', [RelatoriosController::class, 'getProfitReportData'])->name('relatorios.getProfitReportData');
Route::get('/lucro', [RelatoriosController::class, 'lucro'])->name('lucro.relatorios');


