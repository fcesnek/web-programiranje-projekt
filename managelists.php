<?php
  require "header.php";
?>

<?php
  if(!isset($_SERVER['HTTP_REFERER'])){
    header('location: ./index.php');
    exit;
  }
  require 'includes/dbh.inc.php';
  $user_id = $_SESSION['userId'];
  $sql = "SELECT * from book_lists WHERE user_id=?;";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sql)) {
      echo "SQL statement failed";
  } else {
      mysqli_stmt_bind_param($stmt, "s", $user_id);
      mysqli_stmt_execute($stmt);
      $result_lists = mysqli_stmt_get_result($stmt);
  }
?>

<div class="row">
  <div class="content">
    <h2 class="table-title">Lists: </h2>
    <div class="lists">
      <?php
    while ($list = mysqli_fetch_assoc($result_lists)): ?>
      <a href="listview.php?listid=<?php echo $list['id']; ?>">
        <h3 class="list-name">
          <i class="icon"></i>
          <span><?php echo $list['name']; ?></span>
        </h3>
      </a>
      <?php endwhile;?>
    </div>
  </div>
</div>

<script>
let icons = document.querySelectorAll(".list-name .icon");
let lists = document.querySelectorAll(".list-name");

console.log(lists);
// Favorites
icons[0].classList.add("fa");
icons[0].classList.add("fa-heart");
lists[0].classList.add("list-color-cyan");
// Currently reading
icons[1].classList.add("fa");
icons[1].classList.add("fa-book-reader");
lists[1].classList.add("list-color-purple");
// Plan to read
icons[2].classList.add("fa");
icons[2].classList.add("fa-list");
lists[2].classList.add("list-color-yellow");
// Read
icons[3].classList.add("fa");
icons[3].classList.add("fa-tasks");
lists[3].classList.add("list-color-grey");
</script>