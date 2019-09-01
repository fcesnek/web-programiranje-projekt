<?php
  require "header.php";
?>
<?php

  if(!isset($_SERVER['HTTP_REFERER'])){
    header('location: ./index.php');
    exit;
  }
  require 'includes/dbh.inc.php';
  $sql = "SELECT * from books;";
  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt, $sql)) {
    echo "SQL statement failed";
  } else {
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
  }
?>

<div class="row">
  <div class="content">
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
    <a href="createbook.php" id="createbook-btn" class="btn"><i class="icon fas fa-plus-circle"></i>Add book</a>

    <table class="custom-table books-table">
      <tr>
        <th>Title</th>
        <th>Author</th>
        <th>ISBN</th>
        <th>Actions</th>
      </tr>

      <?php
        while ($row = mysqli_fetch_assoc($result)): ?>
      <tr>
        <td><?php echo $row['title']; ?></td>
        <td><?php echo $row['author']; ?></td>
        <td><?php echo $row['isbn']; ?></td>
        <td>
          <div class="table-btn-group">
            <a class="action-btn action-btn-edit btn" href="updatebook.php?edit=<?php echo $row['id']; ?>"><i
                class="icon fas fa-pen"></i>EDIT</a>
            <a class="action-btn action-btn-delete btn" href="includes/Book.inc.php?delete=<?php echo $row['id']; ?>"><i
                class="icon fas fa-trash-alt"></i>DELETE</a>
          </div>
        </td>
      </tr>
      <?php endwhile;?>
    </table>
  </div>
  <div>
    </body>

    </html>