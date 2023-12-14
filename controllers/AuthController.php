<?php
require_once 'DataAccess.php';
require_once './helpers.php';



class AuthController
{

    public function home() {
        require 'views/homeView.php';
        print("We only speak to break the silence of the sea");
        print ($_SESSION["current_username"]);
        print(strtoupper($_GET['current_username']).'fortunate son');
    }

    public function register(){
        try
        {

            print("Wild horses");

            $da = new DataAccess();
            $helpers = new Helpers();

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

            if( $firstname=="" || $lastname=="" || $gender=="" || $physicaladdress=="" ){
                throw new Exception("Please enter missing data values !!");
            }

            $sql = "
                INSERT INTO Customer (cusFirstname, cusLastName, cusDateOfBirth,cusCellNo, cusPhysicalAddress,cusEmailAddress, cusPassword, cusGender,countryId,cusDateRegistered)
                VALUES (:firstname, :lastname, :dateofbirth, :cellno, :physicaladdress, :emailaddress, :password, :gender,:country,:dateregistered)
                    ";

            // Prepare and execute the query
            $arrParams = array(":firstname"=>$firstname,":lastname"=>$lastname,":dateofbirth"=>$dateofbirth,":cellno"=>$cellno,":physicaladdress"=>$physicaladdress,
            ":emailaddress"=>$emailaddress,":password"=>$password,":gender"=>$gender,":country"=>$country,":dateregistered"=>$dateregistered);

            $count = $da->ExecuteCommand($sql, $arrParams);

            if ($count>0)
            {
                print("Customer registered successfully You will be redirected to a log in page now !!");
                header('Location: views/loginView.php');
            }else
            {
                throw new ErrorException("Customer registration failed !!");
            }



        }
        catch(Exception $ex)
        {
            throw $ex;
        }
    }

    public static function login(): void
    {
        try{
        // Handle login logic if needed
        // For simplicity, let's just redirect to the home page
//        header('Location: index.php?route=

        $da = new DataAccess();

        $username      = $_POST["username"]??"";
        $password      = $_REQUEST["password"]??""; //raw password
        $cryptpassword = password_hash($password, PASSWORD_DEFAULT); // encrypt password


            $sql = "
        SELECT 'customer' AS user_type, cusId AS user_id, cusEmailAddress, cusPassword
        FROM Customer
        WHERE cusEmailAddress = :username AND cusPassword = :password
        UNION
        SELECT 'management' AS user_type, NULL AS user_id, manEmailAddress, manPassword
        FROM Management
        WHERE manEmailAddress = :username AND manPassword = :password
            ";

            $arrParams= array(':username' => $username, ':password' => $password);
            $arrUser=$da->GetData($sql,$arrParams);

        //confirm success
        if(count($arrUser) > 0){

            print("User Logged successfully !!");

            $_SESSION['user_id'] = $arrUser['user_id'];
            $_SESSION['user_type'] = $arrUser['user_type'];

            //regex to get name part of a logged in user's email
            preg_match('/^([a-zA-Z]+)@/', $username, $matches);
            $current_username=$matches[1]??'User101';
            $_SESSION["current_username"]=$current_username;

            header("Location: router.php?route=home&current_username={$current_username}");
        }else{
            throw new Exception("Invalid username or password !!");
        }
    }catch(Exception $ex){
            print($ex->getMessage());//will be corrected to use the showMessage method that I will create.
            throw $ex;
        }
    }
}