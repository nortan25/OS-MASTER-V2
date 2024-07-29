<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Ordem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Funcionario;

class OrdensController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    /**
     * Método para exibir o histórico de ordens de serviço do usuário autenticado.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $userId = Auth::id();
        $search = $request->input('search', '');

        if (!empty($search)) {
            $ordens = Ordem::where('user_id', $userId)
                           ->where('cliente', 'like', '%' . $search . '%')
                           ->get();
        } else {
            $ordens = Ordem::where('user_id', $userId)->get();
        }

        return view('ordens_servico', compact('ordens'));
    }

    /**
     * Exibe o formulário para criar uma nova ordem de serviço.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('add_ordem');
    }

    /**
     * Armazena uma nova ordem de serviço para o usuário autenticado.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Criar uma nova ordem
        $ordem = new Ordem();
        
        // Preencher os campos com os dados do request
        $ordem->cliente = $request->cliente;
        $ordem->cidade = $request->cidade;
        $ordem->cep = $request->cep;
        $ordem->rua = $request->rua;
        $ordem->bairro = $request->bairro;
        $ordem->modelo = $request->modelo;
        $ordem->problema = $request->problema;
        $ordem->observacoes = $request->observacoes;
        $ordem->phone_number = $request->phone_number;
        $ordem->state = $request->state;
        
        // Aqui, você pode obter os nomes do técnico e do atendente a partir dos seus IDs
        $tecnico = Funcionario::find($request->tecnico);
        $atendente = Funcionario::find($request->atendente);
        
        // Verifique se os técnicos e atendentes foram encontrados
        if ($tecnico && $atendente) {
            // Preencha os nomes do técnico e do atendente na ordem
            $ordem->tecnico = $tecnico->tecnico;
            $ordem->atendente = $atendente->atendente;
            
            // Preencha os demais campos
            $ordem->numero = $request->numero;

            // Associar a ordem ao usuário autenticado
            $ordem->user_id = Auth::id();

            // Salvar a ordem de serviço
            $ordem->save();

            // Redirecionar de volta à página de listagem de ordens de serviço com uma mensagem de sucesso
            return redirect()->route('gerarPDFUltima');
        } else {
            // Se um técnico ou atendente não foi encontrado, retorne um erro
            return redirect()->back()->with('error', 'Técnico ou atendente não encontrado.');
        }
    }

    /**
     * Busca clientes com base no termo fornecido para o usuário autenticado.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function buscarCliente(Request $request)
    {
        $query = $request->input('query', '');
        $userId = Auth::id();

        $clients = Cliente::where('user_id', $userId)
                          ->where(function ($queryBuilder) use ($query) {
                              $queryBuilder->where('name', 'like', '%' . $query . '%')
                                           ->orWhere('email', 'like', '%' . $query . '%')
                                           ->orWhere('phone_number', 'like', '%' . $query . '%');

                          })
                          ->get();

        return response()->json($clients);
    }

    /**
     * Exibe detalhes de um cliente específico para o usuário autenticado.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $userId = Auth::id();
        $client = Cliente::where('user_id', $userId)->find($id);

        if (!$client) {
            return response()->json(['error' => 'Cliente não encontrado'], 404);
        }

        return response()->json($client);
    }
}
