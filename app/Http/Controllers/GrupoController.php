<?php

namespace App\Http\Controllers;

use App\Models\Grupo;
use Illuminate\Http\Request;
use App\Repositories\GrupoRepository;
use App\Http\Requests\StoreGrupoRequest;
use App\Http\Requests\UpdateGrupoRequest;

class GrupoController extends Controller
{
    public function __construct(Grupo $grupo)
    {   
        $this->grupo = $grupo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $grupoRepository = new GrupoRepository($this->grupo);
        

        if($request->has('filtro')){
            $grupoRepository->filtro($request->filtro);
        }

        if($request->has('atributos')){
            $grupoRepository->selectAtributos($request->atributos);
        }

        return response()->json($grupoRepository->getResultadoPaginado(10), 200);
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreModeloRequest    $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGrupoRequest $request)
    {
        $request->validated();
        return response()->json($this->grupo->create([
            'grupo' => $request->grupo,
            'domingo' => $request->domingo,
            'segunda' => $request->segunda,
            'terca' => $request->terca,
            'quarta' => $request->quarta,
            'quinta' => $request->quinta,
            'sexta' => $request->sexta,
            'sabado' => $request->sabado,
            'madrugada' => $request->madrugada,
            'dia' => $request->dia,
            'noite' => $request->noite
        ]), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\grupo  $grupo
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $grupo = $this->grupo->find($id);
        if($grupo === null){
            return response()->json(['erro' => 'Recurso pesquisado não existe'], 404);
        }
        return response()->json($grupo, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateGrupoRequest $request
     * @param  \App\Models\Grupo  $grupo
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGrupoRequest $request, $id)
    {
        $grupo = $this->grupo->find($id);
        if($grupo === null) {
            return response()->json(['erro' => 'Recurso pesquisado não existe'], 404);
        } 

        $grupo->fill($request->all());
        $grupo->save();

        return response()->json($grupo, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\grupo  $grupo
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $grupo = $this->grupo->find($id);
        if($grupo === null) {
            return response()->json(['erro' => 'Recurso pesquisado não existe'], 404);
        }

        $grupo->delete();
        return response()->json(['msg' => 'O grupo foi removido com sucesso!'], 200);
    }
}
