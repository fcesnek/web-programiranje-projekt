<?php
require "header.php";
?>
<form class="form-box" action="includes/Login.inc.php" method="post">
  <h1>Login</h1>
  <input type="text" name="username" placeholder="Username">
  <input type="password" name="password" placeholder="Password">
  <input type="submit" name="login-submit" value="Login">
</form>
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
</body>

</html>