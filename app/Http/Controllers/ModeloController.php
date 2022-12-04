<?php

namespace App\Http\Controllers;

use App\Models\Modelo;
use App\Http\Requests\StoreModeloRequest;
use App\Http\Requests\UpdateModeloRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Repositories\ModeloRepository;

class ModeloController extends Controller
{
    public function __construct(Modelo $modelo)
    {   
        $this->modelo = $modelo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $modeloRepository = new ModeloRepository($this->modelo);
        
        if($request->has('atributos_marca')){
            $atributos_marca = 'marcas:id,'.$request->atributos_marca;
            $modeloRepository->selectAtributosRegistrosRelacionados($atributos_marca);
        }else {
            $modeloRepository->selectAtributosRegistrosRelacionados('marca');
        }

        if($request->has('filtro')){
            $modeloRepository->filtro($request->filtro);
        }

        if($request->has('atributos')){
            $modeloRepository->selectAtributos($request->atributos);
        }

        return response()->json($modeloRepository->getResultadoPaginado(10), 200);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreModeloRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreModeloRequest $request)
    {
        $request->validated();
        $imagem = $request->file('imagem');
        $imagem_urn = $imagem->store('imagens/modelos', 'public');
        return response()->json($this->modelo->create([
            'marca_id'  => $request->marca_id,
            'nome' => $request->nome,
            'imagem' => $imagem_urn,
            'numero_portas' => $request->numero_portas,
            'lugares' => $request->lugares,
            'air_bag' => $request->air_bag,
            'abs' => $request->abs,
            'motor' => $request->motor,
            'transmissao' => $request->transmissao
        ]), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  UInteger $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $modelo = $this->modelo->with('marca')->find($id);
        if($modelo === null) {
            return response()->json(['erro' => 'Recurso pesquisado não existe'], 404);
        } 
        return response()->json($modelo, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateModeloRequest  $request
     * @param  Integer  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateModeloRequest $request,$id)
    {
        $modelo = $this->modelo->find($id);
        if($modelo === null) {
            return response()->json(['erro' => 'Recurso pesquisado não existe'], 404);
        } 

        if($request->file('imagem')){
            Storage::disk('public')->delete($modelo->imagem);
        }

        $imagem = $request->file('imagem');
        $imagem_urn = $imagem->store('imagens/modelos', 'public');

        $modelo->fill($request->all());
        $modelo->imagem = $imagem_urn;
        $modelo->save();
        
        return response()->json($modelo, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Integer  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $modelo = $this->modelo->find($id);
        if($modelo === null) {
            return response()->json(['erro' => 'Recurso pesquisado não existe'], 404);
        }

        Storage::disk('public')->delete($modelo->imagem);

        $modelo->delete();
        return response()->json(['msg' => 'O modelo foi removido com sucesso!'], 200);
    }
}
