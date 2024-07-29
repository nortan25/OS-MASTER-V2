<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ClienteController extends Controller
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

    // Método para exibir a lista de clientes com suporte a pesquisa, ordenação e paginação
    public function index(Request $request)
    {
        $query = $request->input('query');
        $orderBy = $request->input('order_by', 'name');
        $orderDirection = $request->input('order_direction', 'asc');

        // Utiliza um query builder para filtrar, ordenar e paginar os clientes
        $clients = Cliente::where('user_id', Auth::id())
                          ->when($query, function ($queryBuilder) use ($query) {
                              $queryBuilder->where('name', 'like', '%' . $query . '%')
                                           ->orWhere('email', 'like', '%' . $query . '%')
                                           ->orWhere('phone_number', 'like', '%' . $query . '%');
                          })
                          ->orderBy($orderBy, $orderDirection)
                          ->paginate(10);

        return view('clientes.index', compact('clients'));
    }

    // Método para criar um novo cliente associado ao usuário autenticado
    public function store(Request $request)
    {
        // Valida os dados recebidos
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:clientes,email,NULL,id,user_id,' . Auth::id(),
            'phone_number' => 'required|string|max:20',
            'cep' => 'required|string|max:10',
            'state' => 'required|string|max:255',
            'cpf_cnpj' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'neighborhood' => 'required|string|max:255',
            'street' => 'required|string|max:255',
            'house_number' => 'required|string|max:10',
        ], [
            'name.required' => 'O campo nome é obrigatório.',
            // Adicione mensagens personalizadas para outros campos conforme necessário
        ]);

        // Se a validação falhar, redirecione de volta com os erros
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            // Cria um novo cliente associado ao usuário autenticado
            $cliente = new Cliente($validator->validated());
            $cliente->user_id = Auth::id(); // Associa o usuário autenticado ao cliente
            $cliente->save();

            // Retorna uma resposta JSON de sucesso
            return response()->json(['message' => 'Cliente criado com sucesso!'], 200);
        } catch (\Exception $e) {
            // Trata exceções durante a criação do cliente
            return response()->json(['error' => 'Erro ao criar o cliente: ' . $e->getMessage()], 500);
        }
    }

    // Método para atualizar um cliente associado ao usuário autenticado
    public function update(Request $request, $id)
    {
        // Encontra o cliente no banco de dados
        $cliente = Cliente::where('user_id', Auth::id())->findOrFail($id);

        // Valida os dados recebidos
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:clientes,email,' . $cliente->id . ',id,user_id,' . Auth::id(),
            'phone_number' => 'required|string|max:20',
            'cep' => 'required|string|max:10',
            'city' => 'required|string|max:255',
            'neighborhood' => 'required|string|max:255',
            'street' => 'required|string|max:255',
            'house_number' => 'required|string|max:10',
            'state' => '',
        ]);

        // Se a validação falhar, redirecione de volta com os erros
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            // Atualiza os dados do cliente associado ao usuário autenticado
            $cliente->update($validator->validated());

            // Retorna uma resposta JSON de sucesso
            return response()->json(['message' => 'Cliente atualizado com sucesso!'], 200);
        } catch (\Exception $e) {
            // Trata exceções durante a atualização do cliente
            return response()->json(['error' => 'Erro ao atualizar o cliente: ' . $e->getMessage()], 500);
        }
    }

    // Método para excluir um cliente
    public function destroy($id)
    {
        try {
            $cliente = Cliente::where('user_id', Auth::id())->findOrFail($id);
            $cliente->delete();
            return response()->json(['success' => 'Cliente excluído com sucesso!']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocorreu um erro ao excluir o cliente.'], 500);
        }
    }

    // Método para buscar clientes com base na query, ordenação e paginação
    public function search(Request $request)
    {
        $query = $request->input('query');
        $orderBy = $request->input('order_by', 'name');
        $orderDirection = $request->input('order_direction', 'asc');

        $clients = Cliente::where('user_id', Auth::id())
                          ->where(function ($queryBuilder) use ($query) {
                              $queryBuilder->where('name', 'like', '%' . $query . '%')
                                           ->orWhere('email', 'like', '%' . $query . '%')
                                           ->orWhere('phone_number', 'like', '%' . $query . '%');
                          })
                          ->orderBy($orderBy, $orderDirection)
                          ->paginate(10);

        return response()->json($clients);
    }

    // Método para buscar clientes por nome
    public function buscar(Request $request)
    {
        $query = $request->input('query');
        $clientes = Cliente::where('user_id', Auth::id())
                           ->where('name', 'like', '%' . $query . '%')
                           ->get();
        return response()->json($clientes);
    }
}
