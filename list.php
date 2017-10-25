<?php require_once "top.php" ?>
<script type="text/javascript">
function script() {
	var d = document.getElementById("list");
	d.className += "active";
}
</script>
<?php
	if(isset($_POST['update'])) {
		try {
			require_once "coursePDO.php";
			$db = new coursePDO();
			$show = $db->findCourse($_POST["id"]);
			$_SESSION["course"] = $show[0];
			header("location: add.php");
			exit;
		} catch (PDOException $err) {
			print($err->getMessage());			
		}
	}


	echo "<br><br>";
	
	if (isset($_SESSION["course"])) {
		$course = $_SESSION["course"];
		echo "First name: ".$course->getFirstName()."<br>";
		echo "Last name: ".$course->getLastName()."<br>";
		echo "Course name: ".$course->getCourseName()."<br>";
		echo "Course ID: ".$course->getCourseId()."<br>";
		echo "Ects: ".$course->getEcts()."<br>";
		if($course->getCompleted() == 1) {
			$suor = "Yes";
			echo "Course completed: ".$suor."<br>";
			echo "Completed date: ".$course->getCompletedDate()."<br>";
			
			if ($course->getGrade() == "H"){
				$grade = "Passed";
			} else if($course->getGrade() == "X") {
				$grade = "Failed";
			} else if($course->getGrade() == "V"){
				$grade = "Excemption";
			} else {
				$grade = $course->getGrade();
			}
			
			echo "Grade: ".$grade."<br>";
		} else if($course->getCompleted() == 0) {
			$suor = "No";
			echo "Course completed: ".$suor."<br>";
		}
		echo "Additional information: ".$course->getTextField()."<br><br><br>";
		
		
		if(isset($_POST["clear"])) {
			unset($_SESSION["course"]);
			header("location: index.php");
			exit;
		} elseif (isset($_POST["edit"])) {
			header("location: add.php");
			exit;
		} else if (isset($_POST["submit"])) {
			unset($_SESSION["course"]);
			try{
				require_once "coursePDO.php";
				$db = new coursePDO();
				$id = $db->addCourse($course);
			} catch (PDOException $err) {
				print($err->getMessage());
			}
			header("location: saved.php");
			exit;				
		} else {
			?>
		<?php } 
			if($course->getCompleted() == 1) {
				$required = true;
			} else {
				$required = false;
			}

		
		$firstNameError = $course->checkFirstName();
		$lastNameError = $course->checkLastName();
		$courseNameError = $course->checkCourseName();
		$courseIdError = $course->checkCourseId($required);
		$completedDateError = $course->checkCompletedDate($required);
		$ectsError = $course->checkEcts();
		$gradeError = $course->checkGrade($required);
		$textFieldError = $course->checkTextField();

		if($firstNameError != "" || $lastNameError != "" || $courseNameError != "" || $courseIdError != "" || $completedDateError != "" || $ectsError != "" || $gradeError != "" || $textFieldError != "") { ?>
		<p class="err">There were errors in form data. Please correct them before saving to database.</p>
		<form method="post">
		<input type="submit" name="edit" value="Edit" class="btn btn-warning">
		<input type="submit" name="submit" value="Save" id="save" class="btn btn-success" disabled>
		<input type="submit" name="clear" value="Cancel" class="btn btn-danger">
		</form>
		<?php
		} else {
		?>	
		<form method="post">
		<input type="submit" name="edit" value="Edit" class="btn btn-warning">
		<input type="submit" name="submit" value="Save" id="save" class="btn btn-success">
		<input type="submit" name="clear" value="Cancel" class="btn btn-danger">
		</form>
		<?php 
		}

		} else {
	
		try{
		require_once "coursePDO.php";
		$db = new coursePDO();
		$rows = $db->getAllCourses();
		$count = 0;

		echo "<table>";
		if(isset($_POST["show"])) {
			// tulosta kurssin tiedot
			try{
				require_once "coursePDO.php";
				$db = new coursePDO();
				$show = $db->findCourse($_POST["id"]);
				echo "<tr><td class=\"col-md-6\">Name: ".$show[0]->getFirstName()." ".$show[0]->getLastName()."</td></tr>";
				echo "<tr><td class=\"col-md-6\">Course: ".$show[0]->getCourseId()." ".$show[0]->getCourseName()."</td></tr>";
				echo "<tr><td class=\"col-md-6\">Ects: ".$show[0]->getEcts()."</td></tr>";

				if($show[0]->getCompleted() != "" && $show[0]->getCompleted() == "1") {
					echo "<tr><td class=\"col-md-6\">Completed date: ".$show[0]->getCompletedDate()."</td></tr>";
					
					if ($show[0]->getGrade() == "H"){
						$grade = "Passed";
					} else if($show[0]->getGrade() == "X") {
						$grade = "<span class='err'>Failed</span>";
					} else if($show[0]->getGrade() == "V"){
						$grade = "<span class='gr'>Excemption</span>";
					} else {
						$grade = $show[0]->getGrade();
					}
					
					echo "<tr><td class=\"col-md-6\">Grade: ".$grade."</td></tr>";				
				} else {
					echo "<tr><td class=\"col-md-6\">Course completed: no</td></tr>";
				}
				echo "<tr><td class=\"col-md-6\">Info: ".$show[0]->getTextField()."</td></tr>";
				
				echo "
				<tr>
				<td class=\"col-md-6\"><br>
				<form method='post'>
				<input type='hidden' name='id' value='".$show[0]->getId()."'>
				<input type='submit' class='btn btn-info' name='back' value='Back'>&nbsp;
				<input type='submit' name='update' value='Edit' class='btn btn-warning'>
				
				</form></td></tr>";

				} catch (PDOException $err) {
					print($err->getMessage());
				}
		} elseif(isset($_POST["remove"])) {
			// remove course
			try{
				require_once "coursePDO.php";
				$db = new coursePDO();
				$db->deleteCourse($_POST["id"]);
				header("location: list.php");
				exit;				
			} catch (PDOException $err) {
				print($err->getMessage());
			}
		} else {
			foreach ($rows as $row) {
				$count++;
				echo "<tr class=\"col-md-12 row\"><td><b>Name: </b><i>".$row->getFirstName()." ".$row->getLastName()."</i></td><td class=\"col-md-8\"><b>Course: </b><i>".$row->getCourseId()." ".$row->getCourseName()."</i></td><td><form method='post'><input type='hidden' name='id' value='".$row->getId()."'><input type='submit' class='btn btn-info' name='show' value='View'>&nbsp;<input type='submit' class='btn btn-danger' name='remove' value='Delete'></form></td></tr>";
			}
		}
		echo "</table>";
		
	} catch (PDOException $err) {
		print($err->getMessage());
	}

	
} ?>

<?php require_once "bottom.php" ?>