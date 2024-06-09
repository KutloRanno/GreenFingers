<?php

use JetBrains\PhpStorm\NoReturn;

require_once './DataAccess.php';
require_once './helpers.php';
class AuthController
{

    public function home(): void
    {
        require 'homeView.php';
    }

     public function logout(): void
    {
        try
        {
            var_dump($_SESSION);
        // Destroy the session if it's active
        if (session_status() == PHP_SESSION_ACTIVE) {
            session_destroy();
            $_SESSION=array();
        }

        // Redirect to a different URL
        header("Location: homeView.php");
        exit();
        }catch(Exception $ex){
            throw $ex;
        }
    }


    public function register(){
        try
        {
            //create instances of DataAccess and Helper classes
            $da = new DataAccess();
            $helpers = new Helpers();

            // collect info from post array
            $firstname = $_POST['firstname']??"";
            $lastname = $_POST['surname']??"";
            $dateofbirth =$_POST['dob'];
            $cellno = $_POST['cellno'];
            $physicaladdress = $_POST['address'];
            $emailaddress = $_POST['email'];
            $password =  $_REQUEST['password'];
            $cryptpassword = password_hash($password, PASSWORD_DEFAULT); // encrypt password
            $gender = $_POST['gender'];
            $country=$_POST['country'];
            $dateregistered=$helpers->GetCurrentDate();

            //validate input
            if( $firstname=="" || $lastname=="" || $gender=="" || $physicaladdress=="" ){
                throw new Exception("Please enter missing data values !!");
            }

            //create insertion statement
            $sql = "
                INSERT INTO Customer (cusFirstname, cusLastName, cusDateOfBirth,cusCellNo, cusPhysicalAddress,cusEmailAddress, cusPassword, cusGender,countryId,cusDateRegistered)
                VALUES (:firstname, :lastname, :dateofbirth, :cellno, :physicaladdress, :emailaddress, :password, :gender,:country,:dateregistered)
                    ";

            // Prepare and execute the query
            $arrParams = array(":firstname"=>$firstname,":lastname"=>$lastname,":dateofbirth"=>$dateofbirth,":cellno"=>$cellno,":physicaladdress"=>$physicaladdress,
            ":emailaddress"=>$emailaddress,":password"=>$cryptpassword,":gender"=>$gender,":country"=>$country,":dateregistered"=>$dateregistered);

            $count = $da->ExecuteCommand($sql, $arrParams);//checks if sql executed sucessfully

            //check registration success
            if (!$count>0) throw new Exception("Customer registration failed !!");

            $helpers->SetSuccessorOrErrorState("Customer registered successfully You will be redirected to a log in page now !!","info","rgsv");
            header('Location: loginView.php');
            exit();
        }
        catch(Exception $ex)
        {
            $helpers->SetSuccessorOrErrorState($ex->getMessage(),"error",'rgsv');

            //redirect to same page again
            header("Location: customerRegistrationView.php");exit();
        }
    }

    public static function login(): void
    {
        try{



            $da = new DataAccess();
            $helpers = new Helpers();

            $username= $_POST["username"]??"";
            $password= $_REQUEST["password"]??""; //raw password

                $sequel ="SELECT 'management' as userType, manEmailAddress as userEmail, manPassword as userPassword, null as cusId
            FROM Management
            WHERE manEmailAddress = ?
            UNION
            SELECT 'customer' as userType, cusEmailAddress as userEmail, cusPassword as userPassword, cusId
            FROM Customer
            WHERE cusEmailAddress = ?;";

            $arrParams=array($username,$username);

            $arrUser = $da->GetData($sequel,$arrParams);

        //confirm success
            if(!count($arrUser)) throw new Exception('User not found try typing in your email again');

            $passTrue=password_verify($password, $arrUser[0]['userPassword']);

            if(!$passTrue) throw new Exception('Wrong password! Try again!');

            $helpers->SetSuccessorOrErrorState("User logged in successfully !!","info",'lgnv');

            $_SESSION['userType'] = $arrUser[0]['userTsype'];

            //regex to get name part of a logged-in user's email
            preg_match('/^([a-zA-Z]+)@/', $username, $matches);
            $currentUsername=$matches[1]??'User101';
            $_SESSION["currentUsername"]=$currentUsername;
            $_SESSION["fullUsername"]=$username;

            if(strtolower($_SESSION['userType'])==='customer')$_SESSION['cusId']=$arrUser[0]['cusId'];

            header("Location: router.php?route=home&current_username={$currentUsername}&fullUsername={$username}");
            exit();
    }catch(Exception $ex){
            $helpers->SetSuccessorOrErrorState($ex->getMessage(),"error",'lgnv');

            //redirect to same page again
            header("Location: loginView.php");
        }
    }
}