<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Estoque;
use Illuminate\Support\Facades\Auth;

class EstoqueController extends Controller
{



    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }


    public function index(Request $request)
    {
        // Verificar se o usuário está autenticado
        if (!Auth::check()) {
            return response()->json(['error' => 'Usuário não autenticado.'], 401);
        }
    
        // Obter o ID do usuário autenticado
        $userId = Auth::id();
    
        // Query inicial com filtro por user_id
        $query = Estoque::where('user_id', $userId);
    
        // Filtros adicionais
        if ($request->has('name')) {
            $query->where('nome_produto', 'like', '%' . $request->input('name') . '%');
        }
    
        if ($request->has('tag')) {
            $query->where('tag_produto', $request->input('tag'));
        }
    
        if ($request->has('sku')) {
            $query->where('codigo_sku', 'like', '%' . $request->input('sku') . '%');
        }
    
        // Filtrar tags disponíveis apenas para o user_id específico
        $tags = Estoque::where('user_id', $userId)
                        ->distinct()
                        ->pluck('tag_produto');
    
        // Aplicar os filtros e obter os resultados
        $estoque = $query->get();
    
        return view('Estoque.index', compact('estoque', 'tags'));
    }
    



    public function store(Request $request)
    {
        // Adicione um log para verificar os dados recebidos
        \Log::info('Dados recebidos:', $request->all());

        // Valide os dados recebidos do formulário
        $request->validate([
            'nome_produto' => 'required|string|max:255',
            'tag_produto' => 'nullable|string|max:100',
            'valor_produto' => 'required|numeric',
            'codigo_sku' => 'nullable|string|max:50',
            'quantidade' => 'required|integer',
            'descricao' => 'nullable|string',
        ]);

        try {
            // Crie um novo item de estoque
            $estoque = Estoque::create([
                'user_id' => auth()->id(), // Exemplo: assume que o usuário está autenticado
                'nome_produto' => $request->input('nome_produto'),
                'tag_produto' => $request->input('tag_produto'),
                'valor_produto' => $request->input('valor_produto'),
                'codigo_sku' => $request->input('codigo_sku'),
                'quantidade' => $request->input('quantidade'),
                'descricao' => $request->input('descricao'),
            ]);

            // Retorne uma resposta JSON de sucesso
            return response()->json(['message' => 'Produto registrado com sucesso', 'estoque' => $estoque]);
        } catch (\Exception $e) {
            // Log de erro para depuração
            \Log::error('Erro ao registrar o produto:', ['exception' => $e]);

            // Retorne uma resposta de erro
            return response()->json(['error' => 'Erro ao registrar o produto. Verifique os logs para mais detalhes.'], 500);
        }
    }


    /**
     * Exibe o recurso de estoque especificado.
     *
     * @param  \App\Models\Estoque  $estoque
     * @return \Illuminate\Http\Response
     */
    public function show(Estoque $estoque)
    {
        return response()->json(['estoque' => $estoque]);
    }

    public function update(Request $request, $id)
{
    // Validação dos dados recebidos
    $request->validate([
        'nome_produto' => 'required|string|max:255',
        'tag_produto' => 'nullable|string|max:255',
        'valor_produto' => 'required|numeric',
        'codigo_sku' => 'required|string|max:50',
        'quantidade' => 'required|integer',
        'descricao' => 'nullable|string',
    ]);

    // Atualização do produto
    try {
        $produto = Estoque::findOrFail($id);
        $produto->update($request->all());
        return response()->json(['message' => 'Produto atualizado com sucesso'], 200);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Erro ao atualizar produto: ' . $e->getMessage()], 500);
    }
}

   /**
 * Remove o recurso de estoque especificado do armazenamento.
 *
 * @param  int  $id
 * @return \Illuminate\Http\Response
 */
public function destroy($id)
{
    try {
        $estoque = Estoque::findOrFail($id);
        $estoque->delete();
        return response()->json(['message' => 'Produto excluído com sucesso.'], 204);
    } catch (\Exception $e) {
        return response()->json(['message' => 'Erro ao excluir o produto.', 'error' => $e->getMessage()], 500);
    }
}

















    
        


        


        

public function darBaixa(Request $request)
    {
        $request->validate([
            'produto_id' => 'required|integer',
            'quantidade' => 'required|integer|min:1',
        ]);

        // Verificar se o usuário está autenticado
        if (!Auth::check()) {
            return response()->json(['error' => 'Usuário não autenticado.'], 401);
        }

        // Obter o produto do estoque do usuário autenticado
        $produto = Estoque::where('id', $request->input('produto_id'))
                          ->where('user_id', Auth::id())
                          ->first();

        if ($produto) {
            if ($produto->quantidade >= $request->input('quantidade')) {
                // Atualizar a quantidade do produto no estoque
                $produto->quantidade -= $request->input('quantidade');
                $produto->save();

                return response()->json(['success' => 'Baixa no estoque realizada com sucesso!']);
            } else {
                return response()->json(['error' => 'Quantidade insuficiente no estoque.'], 400);
            }
        }

        return response()->json(['error' => 'Produto não encontrado no estoque.'], 404);
    }


    public function darEntrada(Request $request)
{
    $request->validate([
        'produto_id' => 'required|integer',
        'quantidade' => 'required|integer|min:1',
    ]);

    // Verificar se o usuário está autenticado
    if (!Auth::check()) {
        return response()->json(['error' => 'Usuário não autenticado.'], 401);
    }

    // Obter o produto do estoque do usuário autenticado
    $produto = Estoque::where('id', $request->input('produto_id'))
                      ->where('user_id', Auth::id())
                      ->first();

    if ($produto) {
        // Incrementar a quantidade do produto no estoque
        $produto->quantidade += $request->input('quantidade');
        $produto->save();

        return response()->json(['success' => 'Entrada no estoque realizada com sucesso!']);
    }

    return response()->json(['error' => 'Produto não encontrado no estoque.'], 404);
}





    public function todos(Request $request)
{
    $searchTerm = $request->query('search');

    $produtos = Estoque::where('user_id', Auth::id())
                       ->where(function ($query) use ($searchTerm) {
                           $query->where('nome_produto', 'like', '%' . $searchTerm . '%')
                                 ->orWhere('tag_produto', 'like', '%' . $searchTerm . '%')
                                 ->orWhere('codigo_sku', 'like', '%' . $searchTerm . '%');
                       })
                       ->get(['id', 'nome_produto', 'valor_produto']); // Adiciona 'valor_produto' ao resultado

    return response()->json($produtos);
}

    






}



