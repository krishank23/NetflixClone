<?php

class Entity
{

    private $dbh, $sqlData;
    private $errorArray = array();

    public function __construct($dbh,$input){
        $this->dbh = $dbh;
        if(is_array($input)){
            $this ->sqlData = $input;
        }
        else{
            $query = $this->dbh->prepare("SELECT * FROM tbl_entities where id=:id LIMIT 1");
            $query->bindValue(':id',$input);
            $query->execute();
            $this->sqlData = $query->fetch(PDO::FETCH_ASSOC);
        }
    }
    public function getId(){
        return $this->sqlData['id'];
    }
    public function getName(){
        return $this->sqlData['name'];
    }
    public function getThumbnail(){
        return $this->sqlData['thumbnail'];
    }
    public function getPreview(){
        return $this->sqlData['preview'];
    }
    public function getCategoryId(){
        return $this->sqlData['categoryId'];
    }
    public function getSeasons() {
        $query = $this->dbh->prepare("SELECT * FROM tbl_videos WHERE entityId=:id
                                AND isMovie=0 ORDER BY season, episode ASC");
        $query->bindValue(":id", $this->getId());
        $query->execute();

        $seasons = array();
        $videos = array();
        $currentSeason = null;
        while($row = $query->fetch(PDO::FETCH_ASSOC)) {

            if($currentSeason != null && $currentSeason != $row["season"]) {
                $seasons[] = new Season($currentSeason, $videos);
                $videos = array();
            }

            $currentSeason = $row["season"];
            $videos[] = new Video($this->dbh, $row);

        }

        if(sizeof($videos) != 0) {
            $seasons[] = new Season($currentSeason, $videos);
        }

        return $seasons;
    }


}