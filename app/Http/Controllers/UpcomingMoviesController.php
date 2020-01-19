<?php

namespace App\Http\Controllers;

use App\Services\TmdbService;
use Illuminate\Http\Request;

class UpcomingMoviesController extends Controller {

    private $tmdbService;

    public function __construct() {
        $this->tmdbService = new TmdbService();
    }

    public function index(Request $request) {
        $moviesList = $this->tmdbService->fetchUpcomingMovies($request->query);

        return response()->json($moviesList);
    }

    public function show($id) {
        $movieDetails = $this->tmdbService->fetchMovieDetails($id);

        return response()->json($movieDetails);
    }
}
