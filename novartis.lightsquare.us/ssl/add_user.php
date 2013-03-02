<?php
include("includes/php/general.php");
include("includes/php/users.php");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<link rel="stylesheet" type="text/css" href="includes/css/default.css" />
<link rel="stylesheet" type="text/css" href="/includes/css/menu_styles.css">
<link rel="stylesheet" type="text/css" href="/includes/css/jquery.gritter.css">
<script type="text/javascript" src="includes/js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="includes/js/jquery.gritter.min.js"></script>
<script type="text/javascript" src="includes/js/users.js"></script>

<title>Novartis RMD - Add User</title>
</head>
<body onLoad="document.login.username.focus();">
<div id="outer">
  <table width="100%">
    <tr>
      <td>
  <a href="/index.php"><img src="images/logo.jpg"></a>
      </td>
      <td align="right"><img src="images/Yotta-logo-medium.jpg"></td>
    </tr>
  </table>
  <?php print_menu_list(); ?>
  <div id="content">
    <form method="post" name="login" action="<?php echo $_SERVER['PHP_SELF']; ?>">
      <font size=6><i>Add New User</i></font>
      <?php if($_POST["username"]) {
           add_user();
         }
      ?>
      <br>
      <table width="100%">
        <tr>
          <td width="200px">Username <font color="red">*</font></td>
          <td><input type="text" name="username" size="30" /></td>
        </tr>
        <tr>
          <td>Email <font color="red">*</font></td>
          <td><input type="text" name="email" size="30" /></td>
        </tr>
        <tr>
          <td>First Name</td>
          <td><input type="text" name="firstname" size="30" /></td>
        </tr>
        <tr>
          <td>Last Name</td>
          <td><input type="text" name="lastname" size="30" /></td>
        </tr>
        <tr>
          <td>Password <font color="red">*</font> <font color="grey">(Twice)</font></td>
          <td><input id="password" type="password" name="password" size="30" /></td>
        </tr>
        <tr>
          <td></td>
          <td><input id="password_confirmed" type="password" name="password_confirmed" size="30" /></td>
        </tr>
	<tr>
          <td>Role</td>
          <td><?php print_role_select(); ?></td>
        </tr>
      </table>
      <br><br>
      <input id="usersubmit" type="submit" value="Add User" />
    </form>
  </div>
  <br>
</div>
</body>
</html>
