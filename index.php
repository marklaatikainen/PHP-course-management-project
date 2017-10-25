<?php require_once "top.php" ?>
<script type="text/javascript">
function script() {
	var d = document.getElementById("index");
	d.className += "active";
}
</script>

<?php 
	if (isset($_COOKIE["user"])) {
		$name = $_COOKIE["user"]["name"];
		echo "<div class=\"col-md-8\"><h4>Welcome ".$name."</h4><br>";
	} else {
		echo "<div class=\"col-md-8\"><h4>Welcome</h4><br>";
	}
	echo "This is course management web-program, with mysql-connection.<br><br><br></div>";
?>
<?php require_once "bottom.php" ?>