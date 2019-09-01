<?php
require "header.php";
if (!isset($_SERVER['HTTP_REFERER'])) {
    header('location: ./index.php');
    exit;
}
?>

<?php
require 'includes/dbh.inc.php';

$user_id = $_SESSION['userId'];
$list_id = $_GET['listid'];

$listNameQuery = "SELECT name
                  FROM book_lists
                  WHERE id = ?;";
$stmt = mysqli_stmt_init($conn);

if (!mysqli_stmt_prepare($stmt, $listNameQuery)) {
    echo "SQL statement failed";
} else {
    mysqli_stmt_bind_param($stmt, "s", $list_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $listName = mysqli_fetch_assoc($result);
}

$sql = "SELECT *
        FROM book_lists_books blb
        INNER JOIN books b ON b.id = blb.book_id
        WHERE blb.list_id = ?;";
$stmt = mysqli_stmt_init($conn);
if (!mysqli_stmt_prepare($stmt, $sql)) {
    echo "SQL statement failed";
} else {
    mysqli_stmt_bind_param($stmt, "s", $list_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
}
?>
<div style="margin-left: 8%; margin-top: 2%;">
  <h2 style="font-weight: 100;">Viewing list: <span style="font-weight: bold;"><?php echo $listName["name"]; ?></span>
  </h2>
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
      <a href="viewbook.php?id=<?php echo $row['id']; ?>" class="btn">View</a>
    </div>
  </article>
  <?php endwhile;?>
</main>