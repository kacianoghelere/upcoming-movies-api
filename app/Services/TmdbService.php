<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class TmdbService {

    public function fetchUpcomingMovies($query = '') {
        return $this->fetchApiResponse('/movie/upcoming');
    }

    public function fetchMovieDetails($movieId) {
        return $this->fetchApiResponse("/movie/{$movieId}");
    }

    private function fetchApiResponse($urlAppend = '') {
        $curl = curl_init();

        $tmdbToken = env('TMDB_TOKEN', '');

        $url = "https://api.themoviedb.org/3{$urlAppend}?api_key={$tmdbToken}";

        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json;charset=utf-8'
            ],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_TIMEOUT => 30000,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        ]);

        $response = curl_exec($curl);

        $error = curl_error($curl);

        curl_close($curl);

        if ($error) {
            throw new HttpException(Response::HTTP_INTERNAL_SERVER_ERROR, $error);
        }

        return json_decode($response);
    }
}
