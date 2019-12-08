<?php 

include_once "Game.php";
include_once "Price.php";
include_once "Store.php";
include_once "Requirements.php";
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
    private $recomendations; //string
    private $_id; //string
    

    public function __construct($game="", $prices="", $store="", $resources="", $detailed="", $short="", $languages="", $website="", $categories="", $metacritic="", $releaseDate="", $recomendations="") {
        $this->setGame($game);
        $this->setStore($store);
        $this->setPrice($prices);
        $this->setResources($resources);
        $this->setLanguages($languages);
        $this->setCategories($categories);
        $this->setWebsite($website);
        $this->setPubDate($releaseDate);
        $this->setMetacritic($metacritic);
        $this->setDetailedDescription($detailed);
        $this->setShortDescription($short);
        $this->setRecomendations($recomendations);
    }

    public function setGame($value) { $this->game = $value; }
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
    public function setRecomendations($value) { $this->recomendations = $value; }

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
    public function getRecomendations() { return $this->recomendations; }

    public function createInstance() {
        $publicationDao = new PublicationDao();
        $result = $publicationDao->add($this, $store->getStoreId());
        return $result;
    }

    public function findOne($_id) {
        $publicationDao = new PublicationDao();

        $result = $publicationDao->findOne($_id);
        if (count($result) == 1) {
            
            $keys = array_keys($result);
            $arr = $result[$keys[0]]; // get the incoming data
            $store = new Store();
            $storeId = $arr->storeId;
            $store->findOne($storeId);

            $reqs = [];

            if (isset($arr->PcRequirements) && count($arr->PcRequirements) > 0) {   
                array_push($reqs, new Requirements("Pc", $arr->PcRequirements->minimum, $arr->PcRequirements->recommended));
            }
            if (isset($arr->LinuxRequirements) && count($arr->LinuxRequirements) > 0) {
                array_push($reqs, new Requirements("Linux", $arr->LinuxRequirements->minimum, $arr->LinuxRequirements->recomended));
            }
            if (count(isset($arr->MacRequirements) && $arr->MacRequirements) > 0) {
                array_push($reqs, new Requirements("Mac", $arr->MacRequirements->minimum, $arr->MacRequiriments->recomended));                
            }
            
            $game = new Game($arr->Data[0], $arr->Data[1], $arr->Data[2], $arr->Data[2], $arr->Developers, $arr->Genres, $reqs, $arr->Platforms, $arr->AboutTheGame);
            
            $prices = [];
            if (isset($arr->Prices)) {
                if (count($arr->Prices) > 1) {
                    foreach ($arr->Prices as $element) {
                        $price = new Price($element->final, $element->currency, $element->formated);
                        array_push($prices, $price);
                    }
                } else {
                    $prices = new Price($arr->Prices->final, $arr->Prices->currency, $arr->Prices->final_formatted);
                }
            }

            $resources = [];
            
            $resoures["HeaderImage"] = isset($arr->HeaderImage) ? $arr->HeaderImage : "";
            $resources["Screenshots"] = isset($arr->Screenshot) ? $arr->Screenshot : "Não há screenshots cadastradas.";
            $resources["Movies"] = isset($arr->Movies) ? $arr->Movies : "";
            $releaseDate = "";
            if (isset($arr->ReleaseDate)) {
                $releaseDate = new ReleaseDate($arr->ReleaseDate->coming_soon, $arr->ReleaseDate->date);
            }

            $this->setGame($game);
            $this->setPrice($prices);
            $this->setResources($resources);
            $this->setPubDate($releaseDate);
            $this->setStore($store);
            $this->setWebsite($arr->Website);
            if (isset($arr->DetailedDescription))
                $this->setDetailedDescription($arr->DetailedDescription);
            if (isset($arr->ShortDescription))
                $this->setShortDescription($arr->ShortDescription);
            if (isset($arr->SupportedLanguages))
                $this->setLanguages($arr->SupportedLanguages);
            if (isset($arr->Metacritic))
                $this->setMetacritic($arr->Metacritic);
            if (isset($arr->Categories))
                $this->setCategories($arr->Categories);
            if (isset($arr->Recommendations))   
                $this->setRecomendations($arr->Recommendations);
            $this->_id = $_id;
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