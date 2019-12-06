<?php 

class Publication implements JsonSerializable {

    private $game; // game object
    private $store; // store object
    private $evaluation; // string
    private $resources; // string array
    private $languages; // string array
    private $price; // string
    private $pub_date; // string (date)
    private $comments; // comments object array

    public function __construct($game, $store, $evaluation, $resources, $languages, $price, $pub_date, $coments) {
        $this->setGame($game);
        $this->setStore($store);
        $this->setResources($resources);
        $this->setEvaluation($evaluation);
        $this->setLanguages($languages);
        $this->setPrice($price);
        $this->setPubDate($pub_date);
        $this->setComments($comments);
    }

    public function setGame($value) { $this->gameName = $value; }
    public function setStore($value) { $this->store = $value; }
    public function setEvaluation($value) { $this->evaluation = $value; }
    public function setResources($value) { $this->resources = $value; }
    public function setLanguages($value) { $this->languages = $value; }
    public function setPrice($value) { $this->price = $value; }
    public function setPubDate($value) { $this->pub_date = $value; }
    public function setComments($value) { $this->comments = $value; }

    public function getGame($value) { return $this->game; }
    public function getStore($value) { return $this->store; }
    public function getEvaluation($value) { return $this->evaluation; }
    public function getResources($value) { return $this->resources; }
    public function getLanguages($value) { return $this->languages; }
    public function getPrice($value) { return $this->price; }
    public function getPubDate($value) { return $this->pub_date; }
    public function getComments($value) { return $this->comments; }


    public function jsonSerialize() {
        $arr_comments = [];
        for ($i = 0; $i < count($this->comments); $i++) {
            $arr_comments.push($this->comments[$i]->jsonSerialize());
        }
        
        return [
            'game' => $this->game != null ? $this->game->jsonSerialize() : "",
            'store' => $this->store != null ? $this->store->jsonSerialize() : "",
            'evaluation' => $this->getEvaluation(),
            'languages' => $this->getLanguages(),
            'price' => $this->getPrice(),
            'pub_date' => $this->getPubDate(),
            'comments' => $this->comments != null ? $arr_comments : "",
        ];
    }
}

?>