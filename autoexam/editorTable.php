<?php

$cols = isset($_POST['cols']) ? $_POST['cols'] : '';
$rows = isset($_POST['rows']) ? $_POST['rows'] : '';
$caption = isset($_POST['caption']) ? $_POST['caption'] : '';
$header = isset($_POST['header']) ? $_POST['header'] : '';

$cols = intval($cols);
$rowCount = intval($rows);

if($header == 'yes')
{
    $rowCount = $rows-1;
}

$data = '';

$data.= "<table class=\"editable-table\">";

$data .= "<caption>$caption</caption>";
    
    if($header == 'yes')
    {
        $data.= "<thead>";
        
            $data .= "<tr>";

                $heading = "<th>Heading</th>";

                $data.= str_repeat($heading, $cols);

            $data .= "</tr>";
        
        $data.= "</thead>";
    }

    $data.= "<tbody>";

        $columns = "<td>Content</td>";

        $displayColumns = str_repeat($columns, $cols);

        $rowss = "<tr>$displayColumns</tr>";

        $displyRows = str_repeat($rowss, $rowCount);

        $data .= $displyRows;
       
    $data.= "</tbody>";
$data.= "</table>";


echo $data;
