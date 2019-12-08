<?php 

include_once "Game.php";
include_once "Price.php";
include_once "PublicationDao.php"; 

class Publication implements JsonSerializable {
    private $game; // game object
    private $resources; // string array
    private $languages; // string array
    private $price; // price object
    private $pub_date; // string (date)
    private $comments; // comments object array
    private $metacritic; // string
    private $storeId; // string

    public function __construct($name, $type, $genres, $developer, $requirements, $platforms, $resources, $languages, $currency, $value, $formated, $pub_date, $metacritic, $storeId) {
        $game = new Game($name, $developer, $genres, $requirements, $platforms, $type);
        $price = new Price($value, $currency, $formated);
        $this->setGame($game);
        $this->setStore($store);
        $this->setResources($resources);
        $this->setLanguages($languages);
        $this->setPrice($price);
        $this->setPubDate($pub_date);
        $this->setMetacritic($metacritic);
    }

    public function setGame($value) { $this->gameName = $value; }
    public function setStore($value) { $this->store = $value; }
 //   public function setEvaluation($value) { $this->evaluation = $value; }
    public function setResources($value) { $this->resources = $value; }
    public function setLanguages($value) { $this->languages = $value; }
    public function setPrice($value) { $this->price = $value; }
    public function setPubDate($value) { $this->pub_date = $value; }
    public function setComments($value) { $this->comments = $value; }
    public function setMetacritic($value) { $this->metacritic = $value; }

    public function getGame() { return $this->game; }
    public function getStore() { return $this->store; }
//    public function getEvaluation() { return $this->evaluation; }
    public function getResources() { return $this->resources; }
    public function getLanguages() { return $this->languages; }
    public function getPrice() { return $this->price; }
    public function getPubDate() { return $this->pub_date; }
    public function getComments() { return $this->comments; }
    public function getMetacritic() { return $this->metacritic; }

    public function createInstance() {
        $publicationDao = new PublicationDao();
        $result = $publicationDao->add($this, $store->getStoreId());
        return $result;
    }

    public function deleteInstance() {
        $publicationDao = new PublicationDao();
        $result = $publicationDao->remove();
    }

    public function jsonSerialize() {
        $arr_comments = [];
        for ($i = 0; $i < count($this->comments); $i++) {
            $arr_comments.push($this->comments[$i]->jsonSerialize());
        }
        
        return [
            'game' => $this->game != null ? $this->game->jsonSerialize() : "",
            'evaluation' => $this->getEvaluation(),
            'languages' => $this->getLanguages(),
            'price' => $this->getPrice(),
            'pub_date' => $this->getPubDate(),
            'metacritic' => $this->getMetacritic(),
            'comments' => $this->comments != null ? $arr_comments : "",
        ];
    }
}

?>