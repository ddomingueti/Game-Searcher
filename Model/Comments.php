<?php
include_once "CommentsDao.php";

class Comments implements JsonSerializable {

    private $username;
    private $userId;
    private $recommentation;
    private $date;
    private $avatar;
    private $hours;
    private $responses;
    private $_id;
    private $pub_id;
    private $review;

    public function __construct($username="", $userId="", $recommendation="", $date="", $avatar="", $hours="", $review="", $pub_id="") {
        $this->setUsername($username);
        $this->setUserId($userId);
        $this->setRecommendation($recommendation);
        $this->setDate($date);
        $this->setAvatar($avatar);
        $this->setHours($hours);
        $this->setReview($review);
        $this->setPubId($pub_id);
        
    }

    public function setUsername($value) { $this->username = $value; }
    public function setUserId($value) { $this->userId = $value; }
    public function setReview($value) { $this->review = $value; }
    public function setRecommendation($value) { $this->recommentation = $value; }
    public function setResponses($value) { $this->responses = $value; }
    public function setAvatar($value) { $this->avatar = $value; }
    public function setHours($value) { $this->hours = $value; }
    public function setDate($value) {$this->date = $value; }
    public function setPubId($value) {$this->pub_id = $value; }
    public function setStorageId($value) { $this->_id = $value; }

    public function getUsername($value) { return $this->username; }
    public function getUserId($value) { return $this->userId; }
    public function getReview($value) { return $this->review; }
    public function getRecomendation($value) { return $this->recomentation; }
    public function getDate($value) { return $this->date; }
    public function getAvatar($value) { return $this->avatar; }
    public function getHours($value) { return $this->hours; }
    public function getStorageId($value) {return $this->__id; }
    public function getPubId($value) {return $this->pub_id; }
    public function getResponses($value) { return $this->responses; }

    public function createInstance($pubId) {
        $commentsDao = new CommentsDao();
        $this->setPubId((string) new MongoDB\BSON\ObjectID($pubId));
        $result = $commentsDao->add($this);
        return $result;
    }

    public function findOne($_id) {
        $commentsDao = new CommentsDao();
        $result = $commentsDao->findOne($_id);
        if (count($result) == 1) {
            $this->setUsername($result[0]->user);
            $this->setUserId($result[0]->steam_id);
            $this->setAvatar($result[0]->avatar);
            $this->setHours($result[0]->hours);
            $this->setRecommendation($result[0]->recommendation);
            $this->setDate($result[0]->date);
            $this->setReview($result[0]->review);
            $this->setStorageId((string)$result[0]->_id);
            return true;
        } else {
            return false;
        }
    }

    public function findByPubId() {
        $commentsDao = new CommentsDao();
        $result = $commentsDao->findByPubId($this->getPubId());
        return $result;
    }

    public function jsonSerialize() {
        return [
            'user' => $this->username,
            'steam_id' => $this->userId,
            'avatar' => $this->avatar,
            'hours' => $this->hours,
            'recommendation' => $this->recomentation,
            'date' => $this->date,
            'review' => $this->review,
            'pub_id' => $this->pub_id,
        ];
    }
}