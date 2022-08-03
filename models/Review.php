<?php

class Review
{
    public $id;
    public $rating;
    public $review;
    public $email;
    public $user_id;
    public $movie_id;
}

interface ReviewDAOInterface
{
    public function buildReview($data);
    public function create(Review $Review);
    public function getMoviesReview($id);
    public function hasAlreadyReviewed($id, $userId);
    public function getRatings($id);
}
