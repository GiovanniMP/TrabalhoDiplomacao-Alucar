<?php

namespace App\Http\Controllers;

use App\Models\Avaliacao;
use App\Http\Requests\StoreAvaliacaoRequest;
use App\Http\Requests\UpdateAvaliacaoRequest;
use Illuminate\Support\Facades\Auth;
use App\Repositories\AvaliacaoRepository;

class AvaliacaoController extends Controller
{

    public function __construct(Avaliacao $avaliacao)
    {
        $this->avaliacao = $avaliacao;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $avaliacaoRepository = new AvaliacaoRepository($this->avaliacao);
        $avaliacaoRepository->selectAtributosRegistrosRelacionados('user');
        return response()->json($avaliacaoRepository->getResultadoPaginado(20), 200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAvaliacaoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAvaliacaoRequest $request)
    {
        $request->validated();
        return response()->json($this->avaliacao->create([
            'avaliacao' => $request->avaliacao,
            'user_id' => Auth::user()->id,
            'veiculo_id' => $request->veiculo_id,
            'comentario' => $request->comentario,
        ]), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Avaliacao  $avaliacao
     * @return \Illuminate\Http\Response
     */
    public function show(Avaliacao $avaliacao)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAvaliacaoRequest  $request
     * @param  \App\Models\Avaliacao  $avaliacao
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAvaliacaoRequest $request, Avaliacao $avaliacao)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Avaliacao  $avaliacao
     * @return \Illuminate\Http\Response
     */
    public function destroy(Avaliacao $avaliacao)
    {
        //
    }
}
