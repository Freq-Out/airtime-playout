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
LIMIT 50';
$result = pg_query($query) or die('Query failed: ' . pg_last_error());

// Printing results in HTML
echo "<!doctype html>
<html lang=\"en\">
<head>
  <meta charset=\"utf-8\">
  <link rel=\"stylesheet\" href=\"styles.css\" type=\"text/css\" />
  <link href='http://fonts.googleapis.com/css?family=Voltaire' rel='stylesheet' type='text/css'>
  <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
  <script src=\"http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js\"></script>
  <script src=\"fix-header.js\" type=\"text/javascript\"></script>
</head>
<body>

  <div class=\"container\">
  <a href=\"http://phauneradio.com/\" target=\"_blank\"> alt=\"Phaune Radio\" src=\"http://phauneradio.com/wp-content/uploads/www-logo-phaune.png\" width=\"850\" height=\"120\" /></a>

<h1>HISTORIQUE ANTENNE</h1>
  
  <table class=\"green\">\n
  <thead>
    <tr>
      <th>Date</th>
      <th>Titre</th>
      <th>Artiste</th>
      <th>Album</th>
    </tr>
  </thead>
  <tbody>
  ";
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
