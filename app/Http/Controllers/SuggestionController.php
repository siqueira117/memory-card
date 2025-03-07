<?php

namespace App\Http\Controllers;

use App\Models\Suggestion;
use Illuminate\Http\Request;

class SuggestionController extends Controller
{
    public function index()
    {
        return view('sugestoes');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required|max:255',
            'email'     => 'required|email',
            'type'      => 'required|max:255',
            'message'   => 'required|min:10',
        ]);

        Suggestion::create($request->all());    

        return redirect()->route('suggestion.index')->with('success', 'Sua sugestão foi enviada com sucesso!');
    }
}
