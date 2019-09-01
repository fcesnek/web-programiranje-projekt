<?php
require "header.php";
if(!isset($_SERVER['HTTP_REFERER'])){
  header('location: ./index.php');
  exit;
}
?>

<main class="form-box">

  <h1><span class="form-title">Add a book</span></h1>
  <form action="includes/Book.inc.php" method="post" enctype="multipart/form-data">
    <input type="text" name="booktitle" placeholder="Title">
    <input type="text" name="author" placeholder="Author">
    <input type="text" name="isbn" placeholder="ISBN">
    <input type="text" name="genre" placeholder="Genre">
    <input type="text" name="numPages" placeholder="Number of pages">
    <input type="text" name="year" placeholder="Year of release">
    <textarea name="synopsis" placeholder="Synopsis" rows="10" cols="70"></textarea>
    <input type="file" name="bookcover" id="bookcover" class="inputfile" />
    <label for="bookcover"><span class="chooseImgText">Choose book image&hellip;</span></label>
    <input type="submit" name="add-book" value="Submit">
  </form>
</main>
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