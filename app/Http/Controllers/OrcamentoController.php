<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Orcamento;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PdfController;
use App\Models\Funcionario;
use Illuminate\View\View;

class OrcamentoController extends Controller

{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }
    /**
     * Exibe o formulário para adicionar um novo orçamento.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function orcamento()
    {
        // Aqui você pode buscar os técnicos e atendentes para preencher o select no formulário
        $tecnicos = Funcionario::where('tecnico', true)->get();
        $atendentes = Funcionario::where('atendente', true)->get();

        return view('add_orcamento', compact('tecnicos', 'atendentes'));
    }

   






/**
     * Armazena uma nova orcamento de serviço para o usuário autenticado.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createorcamento(Request $request)
    {
        // Criar uma nova orcamento
        $orcamento = new Orcamento();
        
        // Preencher os campos com os dados do request
        $orcamento->cliente = $request->cliente;
        $orcamento->cidade = $request->cidade;
        $orcamento->cep = $request->cep;
        $orcamento->rua = $request->rua;
        $orcamento->bairro = $request->bairro;
        $orcamento->modelo = $request->modelo;
        $orcamento->problema = $request->problema;
        $orcamento->observacoes = $request->observacoes;
        $orcamento->phone_number = $request->phone_number;
        $orcamento->state = $request->state;
        
        // Aqui, você pode obter os nomes do técnico e do atendente a partir dos seus IDs
        $tecnico = Funcionario::find($request->tecnico);
        $atendente = Funcionario::find($request->atendente);
        
        // Verifique se os técnicos e atendentes foram encontrados
        if ($tecnico && $atendente) {
            // Preencha os nomes do técnico e do atendente na orcamento
            $orcamento->tecnico = $tecnico->tecnico;
            $orcamento->atendente = $atendente->atendente;
            
            // Preencha os demais campos
            $orcamento->numero = $request->numero;

            // Associar a orcamento ao usuário autenticado
            $orcamento->user_id = Auth::id();

            // Salvar a orcamento de serviço
            $orcamento->save();

            // Redirecionar de volta à página de listagem de ordens de serviço com uma mensagem de sucesso
            return redirect()->route('gerarPDFUltimoOrcamento');
        } else {
            // Se um técnico ou atendente não foi encontrado, retorne um erro
            return redirect()->back()->with('error', 'Técnico ou atendente não encontrado.');
        }
    }









    /**
     * Exibe o histórico de orçamentos do usuário autenticado.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        // Obtém o ID do usuário autenticado
        $userId = Auth::id();

        $search = $request->input('search', '');

        // Filtra os orçamentos do usuário autenticado pelo cliente, se houver busca
        $ordens = Orcamento::where('user_id', $userId)
                           ->when($search, function ($query) use ($search) {
                               return $query->where('cliente', 'like', '%' . $search . '%');
                           })
                           ->get();

        return view('orcamentos', compact('ordens', 'search'));
    }

    /**
     * Armazena um novo orçamento no banco de dados.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Obtém o ID do usuário autenticado
        $userId = Auth::id();

        // Captura os dados do formulário
        $data = $request->all();

        // Adiciona o user_id aos dados do orçamento
        $data['user_id'] = $userId;

        // Cria um novo orçamento
        Orcamento::create($data);

        // Redireciona de volta à página de listagem de orçamentos com uma mensagem de sucesso
        return redirect()->route('orcamentos.index')->with('success', 'Orçamento criado com sucesso!');
    }

    /**
     * Pesquisa orçamentos do usuário autenticado com base no cliente.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        // Obtém o ID do usuário autenticado
        $userId = Auth::id();

        $query = $request->input('search');
        $orderBy = $request->input('order_by', 'cliente');
        $orderDirection = $request->input('order_direction', 'asc');

        // Pesquisa orçamentos do usuário autenticado pelo cliente
        $ordens = Orcamento::where('user_id', $userId)
                           ->where('cliente', 'like', '%' . $query . '%')
                           ->orderBy($orderBy, $orderDirection)
                           ->get();

        return response()->json($ordens);
    }
}
