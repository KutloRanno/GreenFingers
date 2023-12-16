<?php
include_once 'DataAccess.php';
class BankController
{
    public function addBankAccount()
    {
        try
        {
            $da = new DataAccess();
            print($_SESSION['fullUsername']);
            print($_SESSION['cusId']);
            print_r($_POST);

            $sequel = "insert into Customer_Bank (cusId, bankSortCode, accountNumber) values (:cusId,:bankSortCode,:accno);";
            $arrParams=array(":cusId"=>$_SESSION['cusId'],":bankSortCode"=>$_POST['bankid'],":accno"=>$_POST['accno']);

            $count = $da->ExecuteCommand($sequel,$arrParams);

            if($count>0) print ('Account added.');
                else throw new Exception('failed to add account');
        }
        catch(Exception $ex){
            throw $ex;
        }




    }
}
