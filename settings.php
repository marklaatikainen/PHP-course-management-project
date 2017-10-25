<?php require_once "top.php" ?>
<script type="text/javascript">
function script() {
	var d = document.getElementById("settings");
	d.className += "active";
}
</script>
<?php
	if (isset($_POST["edit"])) {
		setcookie("user[name]", $_POST["firstName"], time() + 60*60*24*7);
		header("location: index.php");
		exit;
	}
	echo "<h4>Settings</h4>";

	if (isset($_SESSION["course"])) {
		$course = $_SESSION["course"];
	} else {
		$course = new Course();
	}
?>
	<form method="post">
	<div class="col-md-6">
	<br><br>
        <label class="control-label">Your name</label>
        <input class="form-control" type="text" name="firstName" value="<?php echo $_COOKIE["user"]["name"]; ?>">
		<br>
		<input type="submit" name="edit" value="Change name" class="btn btn-warning">
		<br><br>
    </div>
	</form>
<?php require_once "bottom.php" ?>