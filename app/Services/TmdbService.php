<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class TmdbService {

    private $allowedVideoSources = ['YouTube'];

    public function fetchMovies($query, $page = 1) {
        return $this->fetchApiResponse('/search/movie', compact('page', 'query'));
    }

    public function fetchUpcomingMovies($page = 1) {
        return $this->fetchApiResponse('/movie/upcoming', compact('page'));
    }

    public function fetchMovieDetails($movieId) {
        $parameters = [
            'append_to_response' => 'credits,videos'
        ];

        $movie = $this->fetchApiResponse("/movie/{$movieId}", $parameters);
        $movie['main_cast'] = $this->handleMovieCastMembers($movie['credits']);
        $movie['directors'] = $this->handleMovieDirectors($movie['credits']);
        $movie['videos'] = $this->handleMovieVideos($movie['videos']);

        unset($movie['credits']);

        return $movie;
    }

    private function handleMovieCastMembers($movieCredits) {
        $maxCastMembersCount = 8;

        return array_slice($movieCredits['cast'], 0, $maxCastMembersCount);
    }

    private function handleMovieDirectors($movieCredits) {
        $directors = [];

        foreach ($movieCredits['crew'] as $member) {
            if ($member['job'] === 'Director') {
                $directors[] = $member;
            }
        }

        $maxDirectorsCount = 3;

        return array_slice($directors, 0, $maxDirectorsCount);
    }

    private function handleMovieVideos($movieVideos) {
        $videos = [];

        foreach ($movieVideos['results'] as $video) {
            if (in_array($video['site'], $this->allowedVideoSources)) {
                $videos[] = $video;
            }
        }

        return $videos;
    }

    private function fetchApiResponse($urlAppend = '', $params = []) {
        $curl = curl_init();

        $parameters = http_build_query(array_merge([
            'api_key' => env('TMDB_TOKEN', '')
        ], $params));

        $url = "https://api.themoviedb.org/3{$urlAppend}?{$parameters}";

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

        return json_decode($response, true);
    }
}
