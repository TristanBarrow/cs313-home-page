<?php
    $dbUrl = getenv('DATABASE_URL');

    $dbopts = parse_url($dbUrl);
    
    $dbHost = $dbopts["host"];
    $dbPort = $dbopts["port"];
    $dbUser = $dbopts["user"];
    $dbPassword = $dbopts["pass"];
    $dbName = ltrim($dbopts["path"],'/');
    
    $db = new PDO("pgsql:host=$dbHost;port=$dbPort;dbname=$dbName", $dbUser, $dbPassword);
    
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    function get_scripts($db) {
      $statement = $db->query('SELECT * FROM scriptures');
      $statement->execute();
      return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
</head>
<body>
<h1>Scripture Resources</h1>
<?php 
  $scripts = get_scripts($db);
  foreach($scripts as $script) {
    $book = $script['book'];
    $chapter = $script['chapter'];
    $verse = $script['verse'];
    $content = $script['content'];
    require('./scripture.php');
  }
?>
</body>
</html>

