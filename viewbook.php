<?php
require "header.php";
?>
<?php
if (isset($_GET['id'])) {
    require 'includes/dbh.inc.php';

    $id = $_GET['id'];
    $sql = "SELECT * from books WHERE id=?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo "SQL statement failed";
    } else {
        mysqli_stmt_bind_param($stmt, "s", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $book = mysqli_fetch_assoc($result);
    }
}
?>

<?php
require 'includes/dbh.inc.php';
$book_id = $_GET['id'];

if(isset($_SESSION['userId'])) {
  $user_id = $_SESSION['userId'];
  $sql = "SELECT rating from book_ratings WHERE user_id=? AND book_id=?;";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sql)) {
      echo "SQL statement failed";
  } else {
      mysqli_stmt_bind_param($stmt, "ss", $user_id, $book_id);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      $rating = mysqli_fetch_assoc($result);
  }
}

$sql = "SELECT AVG(rating) from book_ratings WHERE book_id=?;";
$stmt = mysqli_stmt_init($conn);
if (!mysqli_stmt_prepare($stmt, $sql)) {
    echo "SQL statement failed";
} else {
    mysqli_stmt_bind_param($stmt, "s", $book_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $avg_rating = mysqli_fetch_assoc($result);
}

$sql = "SELECT * from book_lists WHERE user_id=?;";
$stmt = mysqli_stmt_init($conn);
if (!mysqli_stmt_prepare($stmt, $sql)) {
    echo "SQL statement failed";
} else {
    mysqli_stmt_bind_param($stmt, "s", $user_id);
    mysqli_stmt_execute($stmt);
    $result_lists = mysqli_stmt_get_result($stmt);
}

while ($_list = mysqli_fetch_assoc($result_lists)) {
  $listsTmp[] = array(
    "id" => $_list["id"],
    "name" => $_list["name"]
  );
}

$lists = array();
foreach ($listsTmp as $list_info) {
  $sql = "SELECT * from book_lists_books
          WHERE book_id=? AND list_id=?;";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sql)) {
      echo "SQL statement failed";
  } else {
      mysqli_stmt_bind_param($stmt, "ss", $book_id, $list_info["id"]);
      mysqli_stmt_execute($stmt);
      $resultsadd = mysqli_stmt_get_result($stmt);
      
      $list_info["numOfRows"] = mysqli_num_rows($resultsadd);
      $lists[] = $list_info;
  }
}
?>
<?php if(isset($_SESSION['msg_type']) && isset($_SESSION['message'])): ?>
    <div class="msg <?php echo $_SESSION['msg_type']; ?>-msg">
      <div class="center">
        <?php if($_SESSION['msg_type'] == 'error'): ?>
          <i class="fas fa-exclamation-circle"></i>
        <?php else: ?>
          <i class="far fa-check-circle"></i>
        <?php endif; ?>
        <?php foreach($_SESSION['message'] as $message):?>
          <span><?php echo $message; ?></span>
        <?php endforeach; ?>
      </div>
    </div>
    <?php
      endif; 
      unset($_SESSION['msg_type']);
      unset($_SESSION['message']);
    ?>
<div class="row">
  <div class="side">
    <div class="viewcard">
      <img src="<?php echo $book['image']; ?>" alt="<?php echo $book['title']; ?> cover">
      <p>Author: <?php echo $book['author']; ?></p>
      <h3>Title: <?php echo $book['title']; ?></h3>
    </div>
  </div>
  <div class="main">
      <div class="book-info">
      <h2 class="book-title">Book info:</h2>
      <div class="book-info-content">
        <p>Year of release: </p>
        <p>Genre: </p>
        <p>Num of pages: </p>
        <p>ISBN: <span class="book-info-value"><?php echo $book['isbn']; ?><span></p>
        <p>Avg. rating: <?php echo number_format((float)$avg_rating['AVG(rating)'], 2, '.', ''); ?></p>
      </div>
    </div>
    <br>
    <div class="book-actions">
      <a href="http://baza.gskos.hr/cgi-bin/wero.cgi?q=<?php echo $book['isbn'] ?>" target="_blank" class="btn" id="library-btn">Find in library</a>
      <?php
        if (isset($_SESSION['userId'])):
      ?>
      <div class="dropdown">
        <a class="btn">Add to list</a>
        <div class="dropdown-content">
          <?php
            foreach ($lists as $list): ?>
            <a href="includes/<?php echo $list["numOfRows"] > 0 ? 'RemoveFromList' : 'AddToList' ?>.inc.php?listid=<?php echo $list["id"]; ?>&bookid=<?php echo $book['id']; ?>">
              <?php echo $list["name"]; ?>
              <?php if($list["numOfRows"] > 0): ?>
                <i class="fas fa-check"></i>
              <?php endif; ?>
            </a>
          <?php endforeach;?>
        </div>
      </div>
      <?php endif; ?>
      <?php
        if (isset($_SESSION['userId'])) {
          echo '
          <div class="rating-box">
            <span>Rating</span>
            <form action="includes/BookRating.inc.php?bookid='. $book['id'] . '" method="post">
              <input type="text" name="rating" placeholder="Rating (1-5)" value="'.$rating['rating'].'">
              <input type="submit" name="rate-book" value="Submit">
            </form>
          </div>';
        }
      ?>
    </div>
    <div class="book-synopsis">
      <h2>Synopsis:</h2>
      <p><?php echo $book['synopsis']; ?> </p>
    </div>
  </div>
  
  
</div>
</div>
</body>

</html>