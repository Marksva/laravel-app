<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Pokemon;


class PokemonController extends Controller
{
    public function capturarAleatorio(Request $request)
    {

        $randomId = rand(1, 151); // Geração 1

        $response = Http::withOptions([
            'verify' => storage_path('cacert.pem'),
        ])->get("https://pokeapi.co/api/v2/pokemon/{$randomId}");

        if (!$response->successful()) {
            return response()->json(['error' => 'Erro ao buscar Pokémon.'], 500);
        }

        $data = $response->json();

        $pokemon = Pokemon::create([
            'user_id' => auth()->id(),
            'pokeapi_id' => $data['id'],
            'name' => $data['name'],
            'type' => collect($data['types'])->pluck('type.name')->join(', '),
            'sprite' => $data['sprites']['front_default'] ?? null,
            'hp' => collect($data['stats'])->firstWhere('stat.name', 'hp')['base_stat'],
            'attack' => collect($data['stats'])->firstWhere('stat.name', 'attack')['base_stat'],
            'defense' => collect($data['stats'])->firstWhere('stat.name', 'defense')['base_stat'],
            'speed' => collect($data['stats'])->firstWhere('stat.name', 'speed')['base_stat'],
        ]);

        return response()->json([
            'message' => "{$pokemon->name} capturado com sucesso!",
            'pokemon' => $pokemon
        ]);
    }
}
