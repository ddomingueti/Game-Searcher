<?php 

include_once "Game.php";
include_once "Price.php";
include_once "Store.php";
include_once "ReleaseDate.php";
include_once "PublicationDao.php";


class Publication implements JsonSerializable {
    private $game; // game object
    private $detailedDescription; //string
    private $shortDescription; //string
    private $resources; // string array ["Header" => 'blablabla', "Movies" => ['....'], "Screenshots => ['....']]
    private $languages; // string array
    private $price; // price object
    private $pub_date; // release-data object
    private $comments; // comments object array
    private $metacritic; // string
    private $store; // store object
    private $website; // string
    private $categories; //string array
    private $__id; //string
    

    public function __construct($game="", $prices="", $store="", $resources="", $detailed="", $short="", $languages="", $website="", $categories="", $metacritic="", $releaseData="") {
        $this->setGame($game);
        $this->setStore($store);
        $this->setPrice($price);
        $this->setResources($resources);
        $this->setLanguages($languages);
        $this->setCategories($categories);
        $this->setWebsite($website);
        $this->setPubDate($date);
        $this->setMetacritic($metacritic);
        $this->setDetailedDescription($detailed);
        $this->setShortDescription($short);
    }

    public function setGame($value) { $this->gameName = $value; }
    public function setStore($value) { $this->store = $value; }
    public function setResources($value) { $this->resources = $value; }
    public function setLanguages($value) { $this->languages = $value; }
    public function setPrice($value) { $this->price = $value; }
    public function setPubDate($value) { $this->pub_date = $value; }
    public function setComments($value) { $this->comments = $value; }
    public function setMetacritic($value) { $this->metacritic = $value; }
    public function setShortDescription($value) { $this->shortDescription = $value; }
    public function setDetailedDescription($value) { $this->detailedDescription = $value; }
    public function setCategories($value) { $this->categories = $value; }
    public function setWebsite($value) { $this->website = $value; }

    public function getGame() { return $this->game; }
    public function getStore() { return $this->store; }
    public function getResources() { return $this->resources; }
    public function getLanguages() { return $this->languages; }
    public function getPrice() { return $this->price; }
    public function getPubDate() { return $this->pub_date; }
    public function getComments() { return $this->comments; }
    public function getMetacritic() { return $this->metacritic; }
    public function getShortDescription() { return $this->shortDescription; }
    public function getDetailedDescription() { return $this->detailedDescription; }
    public function getWebsite() { return $this->website; }
    public function getCategories() { return $this->categories; }

    public function createInstance() {
        $publicationDao = new PublicationDao();
        $result = $publicationDao->add($this, $store->getStoreId());
        return $result;
    }

    public function findOne($__id) {
        $publicationDao = new PublicationDao();

        $result = $publicationDao()->findOne($__id);
        if (count($result) == 1) {

            $keys = array_keys($result);
            $arr = $result[$keys[0]]; // get the incoming data
           
            $store = new Store();
            $store->findOne($arr["storeId"]);

            $reqs = [];
            if (count($arr["PcRequirements"]) > 0) {   
                array_push($reqs, new Requirements("Pc", $arr["PcRequirements"]["minimum"], $arr["PcRequirements"]["recomended"]));
            }
            if (count($arr["LinuxRequirements"]) > 0) {
                array_push($reqs, new Requirements("Linux", $arr["LinuxRequirements"]["minimum"], $arr["LinuxRequirements"]["recomended"]));
            }
            if (count($arr["MacRequirements"]) > 0) {
                array_push($reqs, new Requirements("Mac", $arr["MacRequirements"]["minimum"], $arr["MacRequiriments"]["recomended"]));                
            }

            $game = new Game($arr["Data"][0], $arr["Data"][1], $arr["Data"][2], $arr["Data"][2], $arr["Developers"], $arr["Genres"], $reqs, $arr["Platforms"], $arr["AboutTheGame"]);
            $prices = [];
            foreach ($arr["Prices"] as $element) {
                $price = new Price($element["final"], $element["currency"], $element["formated"]);
                array_push($prices, $price);
            }

            $resources = [];
            $resoures["HeaderImage"] = $arr["HeaderImage"];
            $resources["Screenshots"] = $arr["Screenshots"];
            $resources["Movies"] = $arr["Movies"];

            $releateDate = new ReleaseDate($arr["coming_soon"], $arr["date"]);
            $this->setGame($game);
            $this->setPrice($prices);
            $this->setResources($resources);
            $this->setPubDate($releaseDate);
            $this->setStore($store);
            $this->setWebsite($arr["Website"]);
            $this->setDetailedDescription($arr["DetailedDescription"]);
            $this->setShortDescription($arr["ShortDescription"]);
            $this->setLanguages($arr["SupportedLanguages"]);
            $this->setMetacritic($arr["Metacritic"]);
            $this->setCategories($arr["Categories"]);
            return true;
        } else {
            return false;
        }
    }

    public function jsonSerialize() {
        
        $gameData = $this->getGame()->jsonSerialize();
        $priceData = $this->getPrice()->jsonSerialize();
        $dateData = $this->getPubDate()->jsonSerialize();

        $pubData = [
            "DetailedDescription" => $this->getDetailedDescription(),
            "ShortDescription" => $this->getShortDescription(),
            "SupportedLanguages" => $this->getLanguages(),
            "HeaderImage" => $this->getResources()["HeaderImage"] != null ? $this->getResources()["HeaderImage"] : "",
            "Website" => $this->getWebsite(),
            "Categories" => $this->getCategories(),
            "Recommendations" => $this->getRecommendations(),
            "Movies" => $this->getResources()["Movies"] != null ? $this->getResources["Movies"] : [],
            "Screenshots" => $this->getResources["Screenshots"] != null ? $this->getResources["Screenshots"] : [],
            "storeId" => $this->getStore()->getStoreId(),
        ];

        return array_merge($gameData, $pubData, $dateData);
    }
}

?>