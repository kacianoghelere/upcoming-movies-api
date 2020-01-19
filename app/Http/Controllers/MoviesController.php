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
        $searchText = $request->query('searchText', null);

        $page = $request->query('page', 1);

        if ($searchText) {
            return response()->json($this->tmdbService->fetchMovies(
                $searchText,
                $page
            ));
        }

        return response()->json($this->tmdbService->fetchUpcomingMovies($page));
    }

    public function showDetails($id) {
        $movieDetails = $this->tmdbService->fetchMovieDetails($id);

        return response()->json($movieDetails);
    }
}
