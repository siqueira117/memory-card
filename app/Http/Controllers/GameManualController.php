<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\GameManual;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;

class GameManualController extends Controller
{
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'manualUrl'         => 'required',
                'manualPlatform'    => 'required',
                'manualLanguage'    => 'required',
                'manualGame'        => 'required'
            ]);
            
            if (!$validator->passes()) {
                return Redirect::back()->withErrors($validator);
            }
    
            DB::beginTransaction();

            $gameResult = Game::where('game_id', $request->manualGame)->get();
            if (!count($gameResult)) {
                throw new \Exception("Game não encontrado!");
            }
    
            $gameModel = GameManual::create([
                'url'           => $request->manualUrl,
                'game_id'       => $request->manualGame,
                'language_id'   => $request->manualLanguage,
                'platform_id'   => $request->manualPlatform
            ]);
    
            if (!$gameModel) throw new \Exception("Não foi possível adicionar o jogo!");
    
            DB::commit();

            $request->session()->flash('successMsg',"Manual adicionado com sucesso!"); 
            return Redirect::back();
        } catch (\Exception $e) {
            DB::rollBack();
            $request->session()->flash('errorMsg', $e->getMessage()); 
            return Redirect::back();
        }
    }
}
