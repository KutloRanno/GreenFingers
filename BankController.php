<?php
include_once 'DataAccess.php';
include_once 'helpers.php';
class BankController
{
    public function addBankAccount()
    {
        $helpers =new Helpers();
        $da = new DataAccess();
        try
        {

            $sequel = "insert into Customer_Bank (cusId, bankSortCode, accountNumber) values (:cusId,:bankSortCode,:accno);";
            $arrParams=array(":cusId"=>$_SESSION['cusId'],":bankSortCode"=>$_POST['bankid'],":accno"=>$_POST['accno']);

            $count = $da->ExecuteCommand($sequel,$arrParams);

            if(!$count>0)throw new Exception('failed to add account');

            $helpers->SetSuccessorOrErrorState("Account banking number added!","info","bnkv");
            header("Location: bankingDetailsView.php");
            exit();
        }
        catch(Exception $ex){
            $helpers->SetSuccessorOrErrorState($ex->getMessage(),"error","bnkv");
            header("Location: bankingDetailsView.php");
            exit();
        }
    }
}
