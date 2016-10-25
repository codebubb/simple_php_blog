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
    // Check to see if a new post has been added
    if(isset($_POST['save'])){
      try{
        $dbh = new PDO('mysql:host=localhost;dbname=simple_php_blog', "root", "");
        $stmt = $dbh->prepare('INSERT INTO posts (article) VALUES (:article)');
        $stmt->bindParam(':article', $article);
        $article = $_POST['article'];
        $stmt->execute();
      } catch(PDOException $e){
        print "Error: " . $e->getMessage() . "<br>";
      }
    }

    // Check if a post has been deleted
    if(isset($_POST['delete'])){
      try{
        $dbh = new PDO('mysql:host=localhost;dbname=simple_php_blog', "root", "");
        $stmt = $dbh->prepare('DELETE FROM posts WHERE id = :id');
        $stmt->bindParam(':id', $articleId);
        $articleId = $_POST['articleId'];
        $stmt->execute();
      } catch(PDOException $e){
        print "Error: " . $e->getMessage() . "<br>";
      }
    }

    // Let's connect to MySQL with PDO to retrieve posts
    try{
      $dbh = new PDO('mysql:host=localhost;dbname=simple_php_blog', "root", "");
      // Main loop to retrieve articles from database
      foreach($dbh->query('SELECT * FROM posts') as $post){
        print "<div>{$post['article']}" . "<br>";
        print "Written on: " . $post['created_on'] . "<br></div>";
        print "<form action='index.php' method='POST'><input type='hidden' value='{$post['id']}' name='articleId'><input type='submit' value='Delete' name='delete'></form>";
        print "<hr>";
      }
    } catch (PDOException $e){
      print "Error: " . $e->getMessage() . "<br>";
      die();
    }
    // Done with database connection
    $dbh = null;
 ?>
    <form action="index.php" method="POST">
      <textarea name="article" id="" cols="30" rows="10"></textarea>
      <input type="submit" value="Save" name="save">
    </form>
</body>
</html>
