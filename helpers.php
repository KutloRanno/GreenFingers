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
    public function LoadDropDown($cboName, $arrData, $keyColumnPosition = 0, $valueColumnPosition = 1): void
    {
        try {
            $keys = array_keys($arrData[0]);
            foreach ($arrData as $row) {
                $keyColName = $keys[$keyColumnPosition];
                $keyValName = $keys[$valueColumnPosition];
                $keyColData = $row[$keyColName];
                $keyValData = $row[$keyValName];

                print("<option value='$keyColData'>$keyValData</option>");
            }
        } catch (Exception $ex) {
            throw ($ex);
        }
    }

    public function ShowMessage($message):void {

    }
}