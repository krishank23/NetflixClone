<?php

class Account
{
    private $dbh;
    private $errorArray = array();


    public function __construct(&$dbh){
        $this->dbh = $dbh;
    }

    public function registerNewUser($fn , $ln , $un , $em , $em2 , $pw , $pw2 ){

        $this->validateFirstName($fn);
        $this->validateLastName($ln);
        $this->validateUserName($un);
        $this->validateEmails($em , $em2);
        $this->validatePasswords($pw , $pw2);

        if( empty($this->errorArray) ){
            return  $this->insertUserDetails($fn , $ln , $un , $em , $pw);
        }

        return false ;

    }

    private function insertUserDetails($fn , $ln , $un , $em  , $pw ){

        $pw = hash("sha512" , $pw);

        $query = $this->dbh->prepare("INSERT INTO tbl_users (firstName , lastName , username , email , password ) 
                                          VALUES ( :fn , :ln , :un , :em  , :pw) ");
        $query->bindValue(":fn",$fn );
        $query->bindValue(":ln",$ln );
        $query->bindValue(":un",$un );
        $query->bindValue(":em",$em );
        $query->bindValue(":pw",$pw );

        return $query->execute() ;

    }

    public function login( $email , $pw ){

        $pw = hash("sha512" , $pw);

        $query = $this->dbh->prepare("SELECT * FROM tbl_users WHERE email=:email AND password=:pw ");

        $query->bindValue(":un",$email );
        $query->bindValue(":pw",$pw );

        $query->execute() ;

        if($query->rowCount() == 1){
            return true ;
        }

        array_push($this->errorArray , "Your Username or Password was incorrect" ) ;
        return false ;

    }

    private function validateFirstName($fn){

        if( strlen($fn) < 2 || strlen($fn) >25 ){
            array_push($this->errorArray , "Your first name must be between 2 and 25 characters") ;
        }
    }

    private function validateLastName($ln){

        if( strlen($ln) < 2 || strlen($ln) >25 ){
            array_push($this->errorArray , "Your last name must be between 2 and 25 characters") ;
        }
    }

    private function validateUserName($un){

        if( strlen($un) < 2 || strlen($un) >25 ){
            array_push($this->errorArray , "Your UserName must be between 2 and 25 characters") ;
            return;
        }


        $query = $this->dbh->prepare("SELECT * FROM tbl_users WHERE username=:un");
        $query->bindValue(":un",$un);

        $query->execute();

        if($query->rowCount() != 0){
            array_push($this->errorArray , "This username is already taken") ;

        }


    }


    private function validateEmails($em , $em2){

        if( $em != $em2 ){
            array_push($this->errorArray ,"Your emails don't match") ;
            return;
        }

        if(!filter_var($em , FILTER_VALIDATE_EMAIL)){
            array_push($this->errorArray ,"Email Invalid" ) ;
            return;
        }

        $query = $this->dbh->prepare("SELECT * FROM tbl_users WHERE email=:em");
        $query->bindValue(":em",$em);

        $query->execute();

        if($query->rowCount() != 0){
            array_push($this->errorArray , "Email already in use") ;
            return;
        }

    }


    private function validatePasswords($pw , $pw2){

        if( $pw != $pw2 ){
            array_push($this->errorArray , "passwords don't match") ;
            return;
        }

        if( strlen($pw) < 2 || strlen($pw) >25 ){
            array_push($this->errorArray , "Your password must be between 2 and 25 characters");
            return;
        }


    }



}