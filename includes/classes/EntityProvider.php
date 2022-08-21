<?php

class EntityProvider {


    public static function getEntities(&$dbh , $categoryId , $limit ){

        $sql = "SELECT * FROM tbl_entities ";

        if( $categoryId != NULL ){

            $sql .="WHERE categoryId=:categoryId ";

        }

        $sql .= "ORDER BY RAND() LIMIT :limit";

        $query = $dbh->prepare($sql);

        if( $categoryId != NULL ){
            $query->bindValue(":categoryId" , $categoryId );
        }

        $query->bindValue(":limit", $limit , PDO::PARAM_INT );
        $query->execute();



        $result = array();
        while( $row = $query->fetch(PDO::FETCH_ASSOC) ){

            $result[] = new Entity($dbh , $row );

        }

        return $result ;


    }
    
    public static function getTVShowEntities(&$dbh , $categoryId , $limit ){

        $sql = "SELECT DISTINCT(e.id) FROM tbl_entities as e
                  INNER JOIN videos as v
                  ON e.id = v.entityId
                  WHERE v.isMovie = 0 ";

        if($categoryId != NULL ){

            $sql .="AND categoryId=:categoryId ";

        }

        $sql .= "ORDER BY RAND() LIMIT :limit";

        $query = $dbh->prepare($sql);

        if( $categoryId != NULL ){
            $query->bindValue(":categoryId" , $categoryId );
        }

        $query->bindValue(":limit", $limit , PDO::PARAM_INT );
        $query->execute();



        $result = array();
        while( $row = $query->fetch(PDO::FETCH_ASSOC) ){

            $result[] = new Entity($dbh , $row["id"] );

        }

        return $result ;


    }

    public static function getMovieEntities(&$dbh , $categoryId , $limit ){

        $sql = "SELECT DISTINCT(e.id) FROM `tbl_entities` as e
                  INNER JOIN videos as v
                  ON e.id = v.entityId
                  WHERE v.isMovie = 1 ";

        if( $categoryId != NULL ){

            $sql .="AND categoryId=:categoryId ";

        }

        $sql .= "ORDER BY RAND() LIMIT :limit";

        $query = $dbh->prepare($sql);

        if( $categoryId != NULL ){
            $query->bindValue(":categoryId" , $categoryId );
        }

        $query->bindValue(":limit", $limit , PDO::PARAM_INT );
        $query->execute();



        $result = array();
        while( $row = $query->fetch(PDO::FETCH_ASSOC) ){

            $result[] = new Entity($dbh , $row["id"] );

        }

        return $result ;


    }

}