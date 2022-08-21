<?php
require_once ("includes/classes/EntityProvider.php");
class PreviewProvider
{
    private $dbh, $username;
    private $errorArray = array();

    public function __construct($dbh,$userName){
        $this->dbh = $dbh;
        $this->username = $userName;
    }

    public function creatTVShowPreviewVideo(){

        $entitiesArray = EntityProvider::getTVShowEntities($this->dbh , null, 1);

        if(sizeof($entitiesArray) == 0 ){
            ErrorMessage::show("No TV shows to display");
        }

        return $this->createPreviewVideo($entitiesArray[0]) ;

    }
    public function creatMoviePreviewVideo(){

        $entitiesArray = EntityProvider::getMovieEntities($this->dbh , null, 1);

        if(sizeof($entitiesArray) == 0 ){
            ErrorMessage::show("No Movies to display");
        }

        return $this->createPreviewVideo($entitiesArray[0]) ;

    }

    public function creatCategoryPreviewVideo($categoryId){

        $entitiesArray = EntityProvider::getEntities($this->dbh , $categoryId  , 1);

        if(sizeof($entitiesArray) == 0 ){
            ErrorMessage::show("No TV shows to display");
        }

        return $this->createPreviewVideo($entitiesArray[0]) ;

    }
    public function createPreviewVideo($entity){

        if($entity == NULL){

            $entity = $this->getRandomEntity();

        }

        $id = $entity->getId();
        $name = $entity->getName();
        $preview = $entity->getPreview();
        $thumbnail  = $entity->getThumbnail();



        $videoId = VideoProvider::getEntityVideoForUser($this->dbh , $id , $this->username );
        $video = new Video($this->dbh , $videoId );

        $isInProgress = $video->isInProgress($this->username);
        $plaButtonText = $isInProgress ? "Continue watching" : "play";

        $seasonEpisode = $video->getSeasonAndEpisode();
        $subHeading = $video->isMovie() ? "" : "<h4>$seasonEpisode</h4>";

        return    " <div class = 'previewContainer'> 
          
                        <img src='$thumbnail' class='previewImage'  hidden>  
                        <video autoplay muted class='previewVideo'  onended='previewEnded()' > 
                          <source src='$preview' type='video/mp4' >
                        </video>
                        <div class='previewOverlay'>
                            <div class='mainDetails'>
                                <h3>$name</h3>
                                  $subHeading
                                <div class='buttons' >
                                  <button  onclick='watchVideo($videoId)'><i class='fas fa-play'></i> $plaButtonText </button>
                                  <button  onclick='volumeToggle(this)' ><i class='fas fa-volume-mute'></i></button>
                                </div>
                                
                            </div>
                        </div>
                  
                      </div>";

    }

    private function getRandomEntity(){

        $entity =  EntityProvider::getEntities($this->dbh , NULL , 1 );
        return $entity[0];
    }




    public function createEntityPreviewSquare($entity){

        $id= $entity->getId();
        $thumbnail= $entity->getThumbnail();
        $name= $entity->getName();

        return "<a href='entity.php?id=$id'>
                  <div class ='previewContaner small'>
                     <img src='$thumbnail' title='$name' >
                  </div>
               </a>";

    }


}



