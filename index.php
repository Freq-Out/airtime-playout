<?php

// Connecting, selecting database
$dbconn = pg_connect("host=localhost dbname=airtime user=airtime password=airtime")
    or die('Could not connect: ' . pg_last_error());

// http://www.w3resource.com/PostgreSQL/postgresql-join.php
$query = 'SELECT cc_schedule.starts,cc_files.track_title,cc_files.artist_name,cc_files.album_title
FROM cc_files
INNER JOIN cc_schedule 
ON cc_files.id=cc_schedule.file_id
WHERE
cc_schedule.media_item_played = \'t\' ORDER BY cc_schedule.starts DESC 
LIMIT 10';
$result = pg_query($query) or die('Query failed: ' . pg_last_error());

// Printing results in HTML
echo "<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="styles.css" type="text/css" />
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
  <script src="fix-header.js" type="text/javascript"></script>
</head>
<body>
  <div class="container">
<h1>HISTORIQUE ANTENNE</h1>
  
  <table class="blue">\n";
  <thead>
    <tr>
      <th>Colonne 1</th>
      <th>Colonne 2</th>
      <th>Colonne 3</th>
      <th>Colonne 4</th>
    </tr>
  </thead>
  <tbody>
while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {
    echo "\t<tr>\n";
    foreach ($line as $col_value) {
        echo "\t\t<td>$col_value</td>\n";
    }
    echo "\t</tr>\n";
}
echo "</tbody> </table>\n";
echo "</div>
</body>
</html>";

// Free resultset
pg_free_result($result);

// Closing connection
pg_close($dbconn);
?>
