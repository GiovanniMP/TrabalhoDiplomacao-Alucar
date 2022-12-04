<?php

namespace App\Http\Controllers;

use App\Models\Alugado;
use App\Repositories\AlugadoRepository;
use App\Http\Requests\StoreAlugadoRequest;
use App\Http\Requests\UpdateAlugadoRequest;
use Illuminate\Support\Facades\Auth;

class AlugadoController extends Controller
{
    public function __construct(Alugado $alugado)
    {
        $this->alugado = $alugado;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $alugadoRepository = new AlugadoRepository($this->alugado);
        $alugadoRepository->selectAtributosRegistrosRelacionados('veiculo');
        
        return response()->json($alugadoRepository->getResultadoPaginado(20), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAlugadoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAlugadoRequest $request)
    {
        $request->validated();
        return response()->json($this->alugado->create([
            'veiculo_id' => $request->veiculo_id,
            'preco' => $request->preco,
            'data' => $request->data,
            'user_id' => Auth::user()->id,
        ]), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Alugado  $alugado
     * @return \Illuminate\Http\Response
     */
    public function show(Alugado $alugado)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAlugadoRequest  $request
     * @param  \App\Models\Alugado  $alugado
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAlugadoRequest $request, Alugado $alugado)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Alugado  $alugado
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $alugado = $this->alugado->find($id);
        if($alugado === null) {
            return response()->json(['erro' => 'Recurso pesquisado não existe'], 404);
        }
        
        $alugado->delete();
        return response()->json(['msg' => 'O veiculo foi removido com sucesso!'], 200);
    }
}
