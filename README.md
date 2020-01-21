# Upcoming Movies API

## Architecture
Is this repository, i've implemented the API layer of the application. This means that all the requests made to the TMDB API were made with cURL and the responses were treated before sent to the front-end application.

The React app connects with this API to request the upcoming movies list, search for movies and acquire more details for a movie.

I've sent this API to the Heroku remote server, but got stuck with the Cross Origin Policy (CORS) and couldn't connect with the React app, that was also on Heroku, but in another app.

## List of third-party libraries
I've used the Laravel framework to build the API, so i didn't needed any external lib for this layer. I almost added a CORS external middleware though a dependency, but that does not solved my issues.
