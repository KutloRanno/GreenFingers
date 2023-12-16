<?php
include_once '../DataAccess.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Management</title>
    <meta charset="utf-8"/>
    <link href="css/style.css" rel="stylesheet" type="text/css"/>
</head>

<form name="customers" id="customers" method="POST" >
    <fieldset id="fldsetcontrols" name="fldsetcontrols">

        <label for="email">Email :</label>
        <input type="email" name="email" id="email" required="true" placeholder="email"/>
        <br/>

        <label for="password">Password :</label>
        <input type="password" name="password" id="surname" required="true" placeholder="password"/>
        <br/>

        

        <hr/>
        <input type="submit" name="btnregister" id="btnregister" value="Register"/>
        <input type="reset" name="btnclear" id="btnclear" value="Clear"/>

        <br/>
    </fieldset>
</form>

<?php
try{
    if(isset($_POST['btnregister']))
    {
        $da =new DataAccess();
        $email = $_POST['email']??'';
        $password=$_POST['password']??'';

        $cryptpassword =password_hash($password, PASSWORD_DEFAULT); // encrypt password

        $sql = "insert into Management (manEmailAddress,manPassword) values(:email, :password) ";

        $arrParams= array(":email"=>$email,":password"=>$cryptpassword);
        $count = $da->ExecuteCommand($sql,$arrParams);

        if($count>0) print ('Account added.');
            else throw new Exception('failed to add account');
    }
}catch(Exception $ex){
    print($ex->getMessage());
}

?>