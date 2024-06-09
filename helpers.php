<?php

//will contain methods that will be reused throughout project to show error and success messages

class Helpers
{
    public function LoadHtmlTable($arrData, $tableName = "tbl"): void
    {
        try {
//            var_dump($arrData);exit;
            echo "<table border='1' name='$tableName'>";
            $columns = array_keys(array_change_key_case($arrData[0], CASE_UPPER));
            print("<tr><td>" . implode("</td><td>", $columns) . "</td></tr>");

            foreach ($arrData as $row) {
                print("<tr><td>" . implode("</td><td>", $row) . "</td></tr>");
            }
            echo "</table>";
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    /**
     * @throws Exception
     */
    public function LoadDropDown($arrdata, $keycolpos = 0, $valcolpos = 1): void
    {
        try{

            print("<option value='0'>Select .... </option>");
            $arrkeys = array_keys($arrdata[0]);
            foreach($arrdata as $row){
                //get column names for column positions
                $key=$row[ $arrkeys[$keycolpos] ];
                $value=$row[ $arrkeys[$valcolpos] ];
                print("<option value='$key'>$value </option>");
            }
        } catch (Exception $ex) {
            throw $ex;
        }
    }

   public function GetCurrentDate(): string
    {
        try{
            $dateformat  = "Y-m-d";
            $currentdate = (new DateTime())->format($dateformat);
            $currentdate = date($dateformat);
            return $currentdate;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function SetSuccessorOrErrorState($msg,$type,$marker):void
    {
        try
        {
            $_SESSION['message']=$msg;
            $_SESSION['resultType']=$type;
            $_SESSION['marker']=$marker;

        }
        catch(Exception $ex)
        {
            throw $ex;
        }
    }

    public function ShowMessage($msg)
    {
        echo "<fieldset>
                    <legend>USER MESSAGE</legend>
                    <h4>$msg</h4>
                </fieldset>";

    }


}