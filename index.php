<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Simple PHP Blog</title>
</head>
<body>
  <header>
    <h1>Simple PHP Blog</h1>
  </header>
  <?php
    // Let's connect to MySQL with PDO
    try{
      $dbh = new PDO('mysql:host=localhost;dbname=simple_php_blog', "root", "");
      // Main loop to retrieve articles from database
      foreach($dbh->query('SELECT * FROM posts') as $post){
        print $post['article'] . "<br>";
        print "Written on: " . $post['created_on'] . "<br>";
        print "<hr>";
      }
    } catch (PDOException $e){
      print "Error: " . $e->getMessage() . "<br>";
      die();
    }
    // Done with database connection
    $dbh = null;
 ?>
</body>
</html>
