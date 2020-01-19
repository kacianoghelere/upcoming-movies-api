<?php

namespace App\Http\Controllers;

use App\Services\TmdbService;
use Illuminate\Http\Request;

class MoviesController extends Controller {

    private $tmdbService;

    public function __construct() {
        $this->tmdbService = new TmdbService();
    }

    public function list(Request $request, $page = 1) {
        $searchParameter = $request->query('search', null);

        $page = $request->query('page', 1);

        if ($searchParameter) {
            $moviesList = $this->tmdbService->fetchMovies($searchParameter, $page);
        } else {
            $moviesList = $this->tmdbService->fetchUpcomingMovies($page);
        }

        return response()->json($moviesList);
    }

    public function showDetails($id) {
        $movieDetails = $this->tmdbService->fetchMovieDetails($id);

        return response()->json($movieDetails);
    }
}
