<?php

mysql_connect("localhost", "root", "");
mysql_select_db("datagrid");

$limit 			= $_POST['limit'];
$offset 		= $_POST['offset'];
$order 			= $_POST['order'];
$sort 			= $_POST['sort'];
$album_id 		= $_POST['album_id'];
$where 			= $_POST['dataSearch'] != "" ? " WHERE " . $_POST['dataSearch']['field'] . " LIKE '%" . $_POST['dataSearch']['value'] . "%' AND album_id = " . $album_id : " WHERE album_id = " . $album_id;

$query 			= mysql_query("SELECT * FROM songs" . $where . " ORDER BY " . $sort . " " . $order . " LIMIT " . $limit . ", " . $offset);
$query_total 	= mysql_query("SELECT * FROM songs" . $where . " ORDER BY " . $sort . " " . $order);
$rowsTotal 		= mysql_num_rows($query_total);
$songs 			= [];

while ($row = mysql_fetch_array($query)) {
	array_push($songs, $row);
}

echo json_encode(array('total' => $rowsTotal, 'rows' => $songs));

?>