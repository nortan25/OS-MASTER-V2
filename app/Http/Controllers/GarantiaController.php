<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Garantia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class GarantiaController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }
    /**
     * Mostra o histórico de garantias associadas ao usuário autenticado.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\View\View
     */
    public function historicoGarantias(Request $request)
    {
        $user_id = Auth::id(); // Obtém o ID do usuário autenticado
        $search = $request->input('search', '');

        if (!empty($search)) {
            $garantias = Garantia::where('user_id', $user_id)
                                ->where(function ($query) use ($search) {
                                    $query->where('nomeProduto', 'like', '%' . $search . '%')
                                          ->orWhere('tipoGarantia', 'like', '%' . $search . '%')
                                          ->orWhere('modeloAparelho', 'like', '%' . $search . '%');
                                })
                                ->get();
        } else {
            $garantias = Garantia::where('user_id', $user_id)->get();
        }

        return view('historicoGarantias', compact('garantias', 'search'));
    }

    /**
     * Armazena uma nova garantia no banco de dados.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Valida os dados recebidos
        $validator = Validator::make($request->all(), [
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|max:255',
            'cep' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'neighborhood' => 'nullable|string|max:255',
            'street' => 'nullable|string|max:255',
            'house_number' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'tipoGarantia' => 'nullable|string|max:255',
            'nomeProduto' => 'nullable|string|max:255',
            'tempoGarantiaProduto' => 'nullable|string|max:255',
            'servicoRealizado' => 'nullable|string|max:255',
            'modeloAparelho' => 'nullable|string|max:255',
            'tempoGarantiaServico' => 'nullable|string|max:255',
            'observacoes' => 'nullable|string|max:255',
        ]);

        // Se a validação falhar, retorna os erros
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            // Adiciona o user_id aos dados antes de criar a garantia
            $data = $validator->validated();
            $data['user_id'] = Auth::id();

            // Cria uma nova garantia com os dados validados
            Garantia::create($data);

            // Redireciona de volta à página de listagem de garantias com uma mensagem de sucesso
            return redirect()->route('gerar_pdf_ultima_garantia');
        } catch (\Exception $e) {
            // Retorna uma resposta de erro em caso de falha na criação da garantia
            return response()->json(['error' => 'Erro ao criar a garantia: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Busca garantias com base em um termo de pesquisa.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        $user_id = Auth::id(); // Obtém o ID do usuário autenticado
        $query = $request->input('search');
        $orderBy = $request->input('order_by', 'nomeProduto');
        $orderDirection = $request->input('order_direction', 'asc');

        $garantias = Garantia::where('user_id', $user_id)
                             ->where(function ($queryBuilder) use ($query) {
                                 $queryBuilder->where('nomeProduto', 'like', '%' . $query . '%')
                                              ->orWhere('tipoGarantia', 'like', '%' . $query . '%')
                                              ->orWhere('modeloAparelho', 'like', '%' . $query . '%');
                             })
                             ->orderBy($orderBy, $orderDirection)
                             ->get();

        return response()->json($garantias);
    }
}
