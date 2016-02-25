<?php

mysql_connect("localhost", "root", "");
mysql_select_db("datagrid");

$limit 			= $_POST['limit'];
$offset 		= $_POST['offset'];
$order 			= $_POST['order'];
$sort 			= $_POST['sort'];
$year 			= $_POST['year'];
$where 			= $_POST['dataSearch'] != "" ? " WHERE " . $_POST['dataSearch']['field'] . " LIKE '%" . $_POST['dataSearch']['value'] . "%'" : "";
$where 			.= $where != "" ? " AND year = '" . $year . "'" : " WHERE year = '" . $year . "'";

$query 			= mysql_query("SELECT * FROM albums" . $where . " ORDER BY " . $sort . " " . $order . " LIMIT " . $limit . ", " . $offset);
$query_total 	= mysql_query("SELECT * FROM albums" . $where . " ORDER BY " . $sort . " " . $order);
$rowsTotal 		= mysql_num_rows($query_total);
$albums 		= [];

while ($row = mysql_fetch_array($query)) {
	array_push($albums, $row);
}

echo json_encode(array('total' => $rowsTotal, 'rows' => $albums));

?>