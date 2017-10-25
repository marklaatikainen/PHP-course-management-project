<?php require_once "addClass.php" ?>
<?php 
	if(isset($_GET["q"])) {
		if ($_GET["q"] != "") {
			try{
				require_once "coursePDO.php";
				$db = new coursePDO();
				$result = $db->findLike($_GET["q"]);
				echo $result;
			} catch (PDOException $err) {
				print($err->getMessage());
			}		
		} else {
			return;
		}
	}
?>