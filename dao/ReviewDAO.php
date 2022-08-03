<?php

require_once('models/Review.php');
require_once('models/Message.php');

class ReviewDAO implements ReviewDAOInterface
{
    private $conn;
    private $url;
    private $message;

    public function __construct(PDO $conn, $url)
    {
        $this->conn = $conn;
        $this->url = $url;
        $this->message = new Message($url);
    }

    public function buildReview($data)
    {
        $reviewObject = new Review();

        $reviewObject->id = $data['id'];
        $reviewObject->rating = $data['rating'];
        $reviewObject->review = $data['review'];
        $reviewObject->user_id = $data['user_id'];
        $reviewObject->movie_id = $data['movie_id'];

        return $reviewObject;
    }

    public function create(Review $review)
    {
        try {
            $stmt = $this->conn->prepare('INSERT INTO reviews (
                rating, review, movie_id, user_id
            ) VALUES (
                :rating, :review, :movie_id, :user_id
            )');
    
            $stmt->bindParam(':rating', $review->rating);
            $stmt->bindParam(':review', $review->review);
            $stmt->bindParam(':movie_id', $review->movie_id);
            $stmt->bindParam(':user_id', $review->user_id);
    
            $stmt->execute();
    
            $this->message->setMessage('Crítica adicionada com sucesso.', 'success', 'index.php');
        } catch(PDOException $e) {
            $error = $e->getMessage();

            $this->message->setMessage($error, 'error', 'index.php');
        }
    }

    public function getMoviesReview($id)
    {
        $reviews = [];

        try {
            $stmt = $this->conn->prepare('SELECT * FROM reviews WHERE movie_id = :movie_id');

            $stmt->bindParam(':movie_id', $id);

            $stmt->execute();

            if($stmt->rowCount() > 0) {
                $reviewsData = $stmt->fetchAll();

                $userDao = new UserDao($this->conn, $this->url);

                foreach ($reviewsData as $review) {
                    $reviewObject = $this->buildReview($review);
                    $user = $userDao->findById($reviewObject->user_id);

                    $reviewObject->user = $user;

                    $reviews[] = $reviewObject;
                }
            }

            return $reviews;
        } catch(PDOException $e) {
            $error = $e->getMessage();

            $this->message->setMessage($error, 'error', 'index.php');
        }
    }

    public function hasAlreadyReviewed($id, $userId)
    {
        try {
            $stmt = $this->conn->prepare('SELECT * FROM reviews WHERE movie_id = :movie_id AND user_id = :user_id');

            $stmt->bindParam(':movie_id', $id);
            $stmt->bindParam(':user_id', $userId);

            $stmt->execute();

            if($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch(PDOException $e) {
            $error = $e->getMessage();

            $this->message->setMessage($error, 'error', 'index.php');
        }
    }

    public function getRatings($id)
    {
        try {
            $stmt = $this->conn->prepare('SELECT * FROM reviews WHERE movie_id = :movie_id');

            $stmt->bindParam(':movie_id', $id);

            $stmt->execute();

            if($stmt->rowCount() > 0) {
                $rating = 0;

                $reviews = $stmt->fetchAll();

                foreach ($reviews as $review) {
                    $rating += $review["rating"];
                }

                $rating = $rating / count($reviews);
            } else {
                $rating = "Não avaliado";
            }

            return $rating;
        } catch(PDOException $e) {
            $error = $e->getMessage();

            $this->message->setMessage($error, 'error', 'index.php');
        }
    }
}
