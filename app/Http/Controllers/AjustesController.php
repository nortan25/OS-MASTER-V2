<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Models\Controle;
use Illuminate\Support\Facades\Hash;
use App\Models\ModeloOrdem;


class AjustesController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }
    // Método para atualizar as configurações, incluindo nome e email
    public function update(Request $request, $id)
    {
        // Lógica para atualizar os dados do usuário, como nome e email
        $user = Auth::user();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->save();

       // Verifica se o e-mail foi alterado
       if ($user->wasChanged('email')) {
        // Marca o e-mail como não verificado novamente
        $user->email_verified_at = null;
        $user->save();

        // Envie novamente o e-mail de verificação
        $user->sendEmailVerificationNotification();

        return response()->json(['success' => 'Configurações atualizadas com sucesso. Um novo e-mail de verificação foi enviado para o seu novo endereço de e-mail.']);
    }

    return response()->json(['success' => 'Configurações atualizadas com sucesso.']);
}

    // Método para atualizar a logo
   

// Método para atualizar a logo
public function updateLogo(Request $request)
{
    // Validar e salvar a nova logo
    if ($request->hasFile('logoFile')) {
        $user = Auth::user();
        $extension = $request->file('logoFile')->getClientOriginalExtension();
        $fileName = 'logo_' . $user->id . '.' . $extension;

        // Salvar a imagem na pasta public/images
        $filePath = $request->file('logoFile')->move(public_path('images'), $fileName);

        // Verificar se a imagem foi salva corretamente
        if (!$filePath) {
            return response()->json(['error' => 'Falha ao salvar a imagem.'], 500);
        }

        return response()->json(['success' => 'Logo do sistema atualizada com sucesso.']);
    }

    return response()->json(['error' => 'Nenhum arquivo de imagem enviado.'], 400);
}


    // Método para carregar a página de ajustes
    public function ajustes(Request $request)
    {
        $user = Auth::user();

        // Verifica se o usuário está autenticado
        if (!$user) {
            return response()->json(['error' => 'Usuário não autenticado.'], 401);
        }

        // Obter controle do usuário usando o modelo
        $controle = Controle::where('user_id', $user->id)->first();

        // Verificar se o controle exige senha para ajustes
        if ($controle && $controle->ajustes == 1) {
            if ($request->isMethod('post') && $request->has('senha')) {
                // Verifica a senha fornecida
                $senha = $request->input('senha');
                // Comparar a senha fornecida com a armazenada na tabela controle
                if (Hash::check($senha, $controle->password)) {
                    // Senha correta, continua o carregamento da página de ajustes
                    return $this->carregarAjustes($user);
                } else {
                    // Senha incorreta
                    return response()->json(['error' => 'Senha incorreta.'], 403);
                }
            }

            // Se a senha não for fornecida, exibe o modal
            return view('modal.ajustes-senha-modal');
        }

        // Se não houver controle ou não é necessário senha, continua o carregamento da página de ajustes
        return $this->carregarAjustes($user);
    }

    /**
     * Carrega a página de ajustes com os dados do usuário e o logo codificado em base64.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\View\View
     */
    protected function carregarAjustes($user)
    {
        // Verifica se existe um arquivo de logo para o usuário na pasta public/images
        $logoPath = public_path('images/logo_' . $user->id . '.jpg');
        $logo_base64 = null;

        if (file_exists($logoPath)) {
            $logo_base64 = base64_encode(file_get_contents($logoPath));
        }

        // Retorna a view ajustes.blade.php com os dados do usuário e logo_base64
        return view('ajustes', [
            'user' => $user,
            'logo_base64' => $logo_base64,
        ])->withHeaders(['Content-Type' => 'application/json']);
    }
    
    
    
    
    
    
    
    
    
    
    
    public function registerControle(Request $request)
{
    $user = Auth::user();

    // Validação dos dados recebidos
    $request->validate([
        'password' => 'nullable|string',
        'ajustes' => 'nullable|boolean',
        'historico_de_caixa' => 'nullable|boolean',
        'relatorio_lucro' => 'nullable|boolean', // Adicionando validação para relatorio_lucro
        'relatorio_bruto' => 'nullable|boolean'  // Adicionando validação para relatorio_bruto
    ]);

    // Buscar o controle existente para o usuário logado
    $controle = Controle::where('user_id', $user->id)->first();

    if ($controle) {
        // Atualiza o controle existente
        $controle->ajustes = $request->input('ajustes');
        $controle->historico_de_caixa = $request->input('historico_de_caixa');
        $controle->relatorio_lucro = $request->input('relatorio_lucro'); // Atualiza relatorio_lucro
        $controle->relatorio_bruto = $request->input('relatorio_bruto'); // Atualiza relatorio_bruto
        
        // Atualiza a senha apenas se a nova senha for fornecida
        if ($request->has('password') && !empty($request->input('password'))) {
            $controle->password = bcrypt($request->input('password')); // Criptografa a nova senha
        }

        $controle->save();

        return response()->json(['success' => 'Controle atualizado com sucesso.']);
    } else {
        // Cria um novo registro de controle
        $controle = new Controle();
        $controle->user_id = $user->id;
        $controle->password = bcrypt($request->input('password')); // Criptografa a senha
        $controle->ajustes = $request->input('ajustes');
        $controle->historico_de_caixa = $request->input('historico_de_caixa');
        $controle->relatorio_lucro = $request->input('relatorio_lucro'); // Define relatorio_lucro
        $controle->relatorio_bruto = $request->input('relatorio_bruto'); // Define relatorio_bruto
        $controle->save();

        return response()->json(['success' => 'Controle registrado com sucesso.']);
    }
}


    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    /**
     * Atualiza ou cria um registro na tabela modelo_ordem com base nos dados do formulário.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function atualizarOuCriarModeloOrdem(Request $request)
    {
        // Validação dos dados do formulário
        $validatedData = $request->validate([
            'modelo_1' => 'required|boolean',
            'modelo_2' => 'required|boolean',
            'modelo_3' => 'required|boolean',
            'modelo_4' => 'required|boolean',
        ]);

        // Obtém o usuário logado
        $userId = Auth::id();

        // Tenta encontrar um registro existente para o usuário logado
        $modeloOrdem = ModeloOrdem::where('user_id', $userId)->first();

        if ($modeloOrdem) {
            // Se o registro existir, atualiza os campos com os valores do formulário
            $modeloOrdem->update([
                'modelo_1' => $validatedData['modelo_1'],
                'modelo_2' => $validatedData['modelo_2'],
                'modelo_3' => $validatedData['modelo_3'],
                'modelo_4' => $validatedData['modelo_4'],
            ]);
        } else {
            // Se o registro não existir, cria um novo com os valores do formulário
            ModeloOrdem::create([
                'modelo_1' => $validatedData['modelo_1'],
                'modelo_2' => $validatedData['modelo_2'],
                'modelo_3' => $validatedData['modelo_3'],
                'modelo_4' => $validatedData['modelo_4'],
                'user_id' => $userId,
            ]);
        }

        // Retorna uma resposta indicando que a operação foi bem-sucedida
        return response()->json(['message' => 'Modelo de ordem atualizado ou criado com sucesso.']);
    }
    
    
    
    
    
    
public function previewModel($model)
{
    // Defina a lista de modelos válidos
    $validModels = ['modelo_1', 'modelo_2', 'modelo_3', 'modelo_4'];

    // Verifique se o modelo é válido
    if (!in_array($model, $validModels)) {
        abort(404); // Exibe uma página 404 se o modelo não for válido
    }

    // Retorne a visualização correspondente no diretório 'modelos/previw'
    return view("modelos.previw.$model");
}


    
    
    
    
    
    
    
}


