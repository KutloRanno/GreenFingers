<?php
require_once './DataAccess.php';
require_once './helpers.php';
class AuthController
{

    public function home(): void
    {
        require 'views/homeView.php';
    }

    public function logout()
    {
        if(isset($_SESSION)) session_destroy();
        header('Location: views/homeView.php');
    }

    public function register(){
        try
        {
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
            ":emailaddress"=>$emailaddress,":password"=>$cryptpassword,":gender"=>$gender,":country"=>$country,":dateregistered"=>$dateregistered);

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

        $da = new DataAccess();

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

            print("User Logged successfully !!");

            $_SESSION['userType'] = $arrUser[0]['userType'];

            //regex to get name part of a logged in user's email
            preg_match('/^([a-zA-Z]+)@/', $username, $matches);
            $currentUsername=$matches[1]??'User101';
            $_SESSION["currentUsername"]=$currentUsername;
            $_SESSION["fullUsername"]=$username;

            if(strtolower($_SESSION['userType'])==='customer')$_SESSION['cusId']=$arrUser[0]['cusId'];

            header("Location: router.php?route=home&current_username={$currentUsername}&fullUsername={$username}");

    }catch(Exception $ex){
            throw $ex;
        }
    }
}