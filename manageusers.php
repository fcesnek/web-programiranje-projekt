<?php
  require "header.php";
?>
<?php
  if(!isset($_SERVER['HTTP_REFERER'])){
    header('location: ./index.php');
    exit;
  }

  require 'includes/dbh.inc.php';
  $sql = "SELECT * from users;";
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
    <h2 class="table-title">Users list</h2>
    <table class="custom-table">
      <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Admin</th>
        <th>Actions</th>
      </tr>

      <?php
    while ($row = mysqli_fetch_assoc($result)): ?>
      <tr>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo $row['username']; ?></td>
        <td><?php echo $row['admin'] == '1' ? "Yes": "No"; ?></td>
        <td>
          <?php
            if($row['id'] != $_SESSION['userId'] || $_SESSION['adminstatus'] == 0): ?>
              <a class="action-btn action-btn-delete btn" href="includes/Users.inc.php?delete=<?php echo $row['id']; ?>">DELETE</a>
            <?php endif; ?>
        </td>
      </tr>
      <?php endwhile;?>
    </table>
    </body>
  </div>
</div>

</html>