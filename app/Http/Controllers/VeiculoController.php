<?php

namespace App\Http\Controllers;

use App\Models\Veiculo;
use App\Repositories\GrupoRepository;
use Illuminate\Http\Request;
use App\Http\Requests\StoreVeiculoRequest;
use App\Http\Requests\UpdateVeiculoRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class VeiculoController extends Controller
{

    public function __construct(Veiculo $veiculo)
    {   
        $this->veiculo = $veiculo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $veiculoRepository = new GrupoRepository($this->veiculo);
        
        if($request->has('atributos_user')){
            $atributos_user = 'users:id,'.$request->atributos_user;
            $veiculoRepository->selectAtributosRegistrosRelacionados($atributos_user);
        }else {
            $veiculoRepository->selectAtributosRegistrosRelacionados('user');
        }

        if($request->has('filtro')){
            $veiculoRepository->filtro($request->filtro);
        }

        if($request->has('atributos')){
            $veiculoRepository->selectAtributos($request->atributos);
        }

        return response()->json($veiculoRepository->getResultadoPaginado(10), 200);
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreModeloRequest    $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreVeiculoRequest $request)
    {
        $request->validated();
        $imagem = $request->file('imagem');
        $imagem_urn = $imagem->store('imagens/veiculo', 'public');
        return response()->json($this->veiculo->create([
            'user_id'  => Auth::user()->id,
            'ano' => $request->ano,
            'marca' => $request->marca,
            'modelo' => $request->modelo,
            'imagem_marca' => $request->imagem_marca,
            'imagem_modelo' => $request->imagem_modelo,
            'contato' => $request->contato,
            'numero_portas' => $request->numero_portas,
            'air_bag' => $request->air_bag,
            'abs' => $request->abs,
            'lugares' => $request->lugares,
            'motor' => $request->motor,
            'transmissao' => $request->transmissao,
            'grupo' => $request->grupo,
            'chassi' => $request->chassi,
            'placa' => $request->placa,
            'cor' => $request->cor,
            'imagem' => $imagem_urn,
        ]), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Veiculo  $veiculo
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $veiculo = $this->veiculo->with('user')->with('avaliacoes')->find($id);
        if($veiculo === null){
            return response()->json(['erro' => 'Recurso pesquisado não existe'], 404);
        }
        return response()->json($veiculo, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateVeiculoRequest $request
     * @param  \App\Models\Veiculo  $veiculo
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateVeiculoRequest $request, $id)
    {
        $veiculo = $this->veiculo->find($id);
        if($veiculo === null) {
            return response()->json(['erro' => 'Recurso pesquisado não existe'], 404);
        } 


        if($request->file('imagem')){
            Storage::disk('public')->delete($veiculo->imagem);
        }

        $imagem = $request->file('imagem');
        $imagem_urn = $imagem->store('imagens/veiculo', 'public');

        $veiculo->fill($request->all());
        $veiculo->imagem = $imagem_urn;
        $veiculo->save();

        return response()->json($veiculo, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Veiculo  $veiculo
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $veiculo = $this->veiculo->find($id);
        if($veiculo === null) {
            return response()->json(['erro' => 'Recurso pesquisado não existe'], 404);
        }

        Storage::disk('public')->delete($veiculo->imagem);
        $veiculo->delete();
        return response()->json(['msg' => 'O veiculo foi removido com sucesso!'], 200);
    }
}
