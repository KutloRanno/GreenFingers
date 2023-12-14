<?php

//will contain methods that will be reused throughout project to show error and success messages

class Helpers
{
    public function LoadHtmlTable($arrData, $tableName = "tbl"): void
    {
        try {
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

    public function ShowMessage($message):void {

    }

    //function to get array key matching | get attached key to selected button
    function GetSelectedRowKeyFromPost($postarray, $pattern, $separator="|"){
        $pattern = "/{$pattern}/"; //  '/$pattern(.*)/';
        $keys = array_keys($postarray);
        $resultarray = preg_grep($pattern, $keys);
        $resultarray = array_values($resultarray); //re-index
        //found??
        if( count($resultarray) > 0){
            $selectedkey = explode($separator, $resultarray[0])[1];
        }
        return $selectedkey ?? 0;
    }

    function FilterArrayData($arrdata, $usemainkey=false, $mainkey=null, $datakey=null, $datavalue=null){
        try{
            $matches=array();
            if( $usemainkey == true ) {
                $matches = array_filter($arrdata, function($key) use($mainkey){
                    return $key == $mainkey;
                }, ARRAY_FILTER_USE_KEY); // search by key.
            } else {
                $matches = array_filter($arrdata, function($value) use( $datakey, $datavalue ) {
                    return $value[$datakey] == $datavalue;
                }, ARRAY_FILTER_USE_BOTH); // search by value.
            }
            return $matches;
        } catch (Exception $ex){
            throw $ex;
        }
    }

    function GetCurrentTime(){
        try{
            return date("H:i:s"); //Hours:minutes:seconds
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    function GetCurrentDate(){
        try{
            $dateformat  = "Y-m-d";
            $currentdate = (new DateTime())->format($dateformat);
            $currentdate = date($dateformat);
            return $currentdate;
        } catch (Exception $ex) {
            throw ex;
        }
    }
}