<?php
require "header.php";
?>

<?php
require 'includes/dbh.inc.php';

if (!isset($_GET['query'])) {
    $sql = "SELECT * from books;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        session_start();
        $_SESSION['msg_type'] = "error";
        $_SESSION['message'][] = "Database error, try again later.";
    } else {
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
    }
} else {
    $search_query = "%".$_GET['query']."%";
    $sql = "SELECT * from books WHERE title LIKE ? OR author LIKE ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo "SQL statement failed";
    } else {
        mysqli_stmt_bind_param($stmt, "ss", $search_query, $search_query);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
    }
}
?>

<div class="search-div">
  <form action="index.php" method="get">
    <input type="text" name="query" placeholder="Search by title or author" id="searchField">
    <button type="submit" class="search-btn"><i class="fas fa-search"></i></button>
  </form>
</div>
<div class="separator">
  <hr>
</div>


<main class="cards">
  <?php while ($row = mysqli_fetch_assoc($result)): ?>
  <article class="card">
    <a href="viewbook.php?id=<?php echo $row['id']; ?>">
      <div class="img-container">
        <img src="<?php echo $row['image']; ?>" alt="<?php echo $row['title']; ?> cover">
      </div>
    </a>
    <div class="text">
      <h3><?php echo $row['title']; ?></h3>
      <p><?php echo $row['author']; ?></p>
      <a href="viewbook.php?id=<?php echo $row['id']; ?>" class="btn view-btn">View</a>
    </div>
  </article>
  <?php endwhile;?>
</main>
</body>

</html>