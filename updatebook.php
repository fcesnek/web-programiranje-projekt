<?php
require "header.php";
if(!isset($_SERVER['HTTP_REFERER'])){
  header('location: ./index.php');
  exit;
}
?>
<?php
  if(isset($_GET['edit'])) {
      require 'includes/dbh.inc.php';

      $id = $_GET['edit'];
      $sql = "SELECT * from books WHERE id=?;";
      $stmt = mysqli_stmt_init($conn);
      if(!mysqli_stmt_prepare($stmt, $sql)) {
          echo "SQL statement failed";
      } else {
          mysqli_stmt_bind_param($stmt, "s", $id);
          mysqli_stmt_execute($stmt);
          $result = mysqli_stmt_get_result($stmt);
          $book = mysqli_fetch_assoc($result);
      }
  }
?>
<div class="form-box">
  <h1>Update a book</h1>
  <form action="includes/Book.inc.php?bookid=<?php echo $book['id']; ?>" method="post" enctype="multipart/form-data">
    <input type="text" name="booktitle" placeholder="Title" value="<?php echo $book['title']; ?>">
    <input type="text" name="author" placeholder="Author" value="<?php echo $book['author']; ?>">
    <input type="text" name="isbn" placeholder="ISBN" value="<?php echo $book['isbn']; ?>">
    <input type="text" name="genre" placeholder="Genre" value="<?php echo $book['genre']; ?>">
    <input type="text" name="numPages" placeholder="Number of pages" value="<?php echo $book['numPages']; ?>">
    <input type="text" name="year" placeholder="Year of release" value="<?php echo $book['year']; ?>">
    <textarea name="synopsis" placeholder="Synopsis" rows="10" cols="70" > <?php echo $book['synopsis']; ?></textarea>
    <input type="file" name="bookcover" id="bookcover" class="inputfile" />
    <label for="bookcover"><span class="chooseImgText">Choose book image&hellip;</span></label>
    <input type="submit" name="update-book" value="Update">
  </form>
  <div>
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

    <script>
    var input = document.querySelector('.inputfile');
    var label = input.nextElementSibling,
      labelVal = label.innerHTML;

    input.addEventListener('change', function(e) {
      var fileName = '';
      fileName = e.target.value.split('\\').pop();

      if (fileName)
        label.querySelector('span').innerHTML = fileName;
      else
        label.innerHTML = labelVal;
    });
    </script>
    </body>

    </html>