<?php

require_once('globals.php');
require_once('db.php');
require_once('models/Movie.php');
require_once('models/Review.php');
require_once('models/Message.php');
require_once('dao/UserDAO.php');
require_once('dao/MovieDAO.php');
require_once('dao/ReviewDAO.php');

$message = new Message($BASE_URL);
$userDao = new UserDAO($conn, $BASE_URL);
$movieDao = new MovieDAO($conn, $BASE_URL);
$reviewDao = new ReviewDAO($conn, $BASE_URL);

$type = filter_input(INPUT_POST, 'type');

$userData = $userDao->verifyToken();

if($type === 'create') {
    $rating = filter_input(INPUT_POST, 'rating');
    $review = filter_input(INPUT_POST, 'review');
    $movie_id = filter_input(INPUT_POST, 'movie_id');
    $user_id = $userData->id;

    $reviewObject = new Review();

    $movieData = $movieDao->findById($movie_id);

    if($movieData) {
        if(!empty($rating) && !empty($review) && !empty($movie_id)) {
            $reviewObject->rating = $rating;
            $reviewObject->review = $review;
            $reviewObject->movie_id = $movie_id;
            $reviewObject->user_id = $user_id;

            $reviewDao->create($reviewObject);
        } else {
            $message->setMessage('Você precisa inserir a nota e o comentário.', 'error', 'back');
        }
    } else {
        $message->setMessage('Informações inválidas.', 'error', 'index.php');
    }
} else {
    $message->setMessage('Informações inválidas.', 'error', 'index.php');
}
