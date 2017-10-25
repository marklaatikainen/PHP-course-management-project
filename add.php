<?php require_once "top.php" ?>

<script type="text/javascript">
function script() {
	var d = document.getElementById("add");
	d.className += "active";
	onToggle();
}
</script>
<?php
	if(isset($_POST["clear"])) {
		unset($_SESSION["course"]);
		header("location: index.php");
		exit;
	} elseif (!isset($_POST["submit"])) {		
		if (isset($_SESSION["course"])) {
			$firstNameError = 0;
			$lastNameError = 0;
			$courseNameError = 0;
			$courseIdError = 0;
			$completedDateError = 0;
			$ectsError = 0;
			$gradeError = 0;
			$textFieldError = 0;
			$course = $_SESSION["course"];
		} else {
			$course = new Course();
			$firstNameError = 0;
			$lastNameError = 0;
			$courseNameError = 0;
			$courseIdError = 0;
			$completedDateError = 0;
			$ectsError = 0;
			$gradeError = 0;
			$textFieldError = 0;
		}
	} else {
		$cmpltd = null;
		$cmpltdDate = null;
		$grd = null;
		
		if ($_POST["id"] != null) {
			$id = $_POST["id"];
		}
		
		if($_POST["firstName"] != null) {
			$firstName = $_POST["firstName"];
		}
		if ($_POST["lastName"] != null) {
			$lastName = $_POST["lastName"];
		}
		if ($_POST["courseName"] != null){
			$courseName = $_POST["courseName"];
		}
		if ($_POST["courseId"] != null) {
			$courseId = $_POST["courseId"];
		}
		if($_POST["ects"] != null) {
			$ects = ($_POST["ects"]);
		}
		if (isset($_POST["completed"]) && $_POST["completed"] == "true") {
			$cmpltd = "1";
		}
		if (isset($_POST["completedDate"])) {
			$cmpltdDate = $_POST["completedDate"];
		}
		if (isset($_POST["grade"])) {
			$grd = $_POST["grade"];
		}
		
		if ($_POST["textField"] != null) {
			$textField = $_POST["textField"];				
		}
		// työnnetään oliolle tiedot lomakkeelta
		$course = new Course($_POST["id"],$_POST["firstName"],$_POST["lastName"],$_POST["courseName"],$_POST["courseId"],$_POST["ects"],$cmpltd,$cmpltdDate,$grd,$_POST["textField"]);
		
		if (isset($_SESSION["course"])) {
			if($course->getCompleted() == 1) {
				$required = true;
			} else {
				$required = false;
			}

			$firstNameError = $course->checkFirstName();
			$lastNameError = $course->checkLastName();
			$courseNameError = $course->checkCourseName();
			$courseIdError = $course->checkCourseId();
			$completedDateError = $course->checkCompletedDate($required);
			$ectsError = $course->checkEcts();
			$gradeError = $course->checkGrade($required);
			$textFieldError = $course->checkTextField();

			if($course->getId() != null && $course->getId() != "" && $firstNameError == "" && $lastNameError == "" && $courseNameError == "" && $courseIdError == "" && $completedDateError == "" && $ectsError == "" && $gradeError == "" && $textFieldError == "") {
				unset($_SESSION["kurssi"]);
				try {
					require_once "coursePDO.php";
					$db = new coursePDO();
					$show = $db->updateCourse($course, $course->getId());
					header("location: saved.php");
					exit;
				} catch (PDOException $err) {
					print($err->getMessage());			
				}
			}
		}
		
		$_SESSION["course"] = $course; 
		session_write_close();
		if($course->getCompleted() == 1) {
			$required = true;
		} else {
			$required = false;
		}
		$firstNameError = $course->checkFirstName();
		$lastNameError = $course->checkLastName();
		$courseNameError = $course->checkCourseName();
		$courseIdError = $course->checkCourseId();
		$completedDateError = $course->checkCompletedDate($required);
		$ectsError = $course->checkEcts();
		$gradeError = $course->checkGrade($required);
		$textFieldError = $course->checkTextField();
		
		if($firstNameError == "" && $lastNameError == "" && $courseNameError == "" && $courseIdError == "" && $completedDateError == "" && $ectsError == "" && $gradeError == "" && $textFieldError == "") { 
			header("location: list.php");
			exit;
		}
	}
?>
<script type="text/javascript">
	// autoselect previous value
	function setOption(selectElement, value) {
		var options = selectElement.options;
			for (var i = 0, optionsLength = options.length; i < optionsLength; i++) {
				if (options[i].value == value) {
					selectElement.selectedIndex = i;
					return true;
				}
			}
		return false;
	}


	// disable input fields
	function onToggle() {
		var inputs=document.getElementsByClassName('disable');
   
		if (document.querySelector('#checkbox').checked) {
			for(i=0;i<inputs.length;i++){
				inputs[i].disabled=false;
			}
		} else {
			for(i=0;i<inputs.length;i++){
				inputs[i].disabled=true;
			}
		}
	}
</script>
<form method="post">
<div>

        <div>
                <div class="form-group">
                    <div class="col-md-6">
                        <label class="control-label">First name </label>
						<input type="hidden" name="id" value="<?php print($course->getId()) ?>">
                        <input class="form-control" type="text" name="firstName" value="<?php print($course->getFirstName()) ?>" autocomplete="on">
						<?php print("<span class='err'>".$course->getError($firstNameError)."</span>"); ?><br>
                    </div>
                    <div class="col-md-6">
                        <label class="control-label">Last name </label>
                        <input class="form-control" type="text" name="lastName" value="<?php print($course->getLastName()) ?>" autocomplete="on">
						<?php print("<span class='err'>".$course->getError($lastNameError)."</span>"); ?><br>
                    </div>
                    <div class="col-md-6">
                        <label class="control-label">Course name</label>
                        <input class="form-control" type="text" name="courseName" value="<?php print($course->getCourseName()) ?>" autocomplete="off">
						<?php print("<span class='err'>".$course->getError($courseNameError)."</span>"); ?><br>
                    </div>
                    <div class="col-md-6">
                        <label class="control-label">Course ID</label>
                        <input class="form-control" type="text" name="courseId" value="<?php print($course->getCourseId()) ?>" autocomplete="off">
						<?php print("<span class='err'>".$course->getError($courseIdError)."</span>"); ?><br>
					</div>
					<div class="col-md-1"></div>
                    <div class="col-md-2">
                        <label class="control-label">Ects</label>
                        <input class="form-control" type="text" value="<?php print($course->getEcts()) ?>" name="ects">
						<?php print("<span class='err'>".$course->getError($ectsError)."</span>"); ?><br>
					</div>
                    <div class="col-md-2">
						<label class="control-label">Completed</label>
                        <input class="form-control" type="checkbox" id="checkbox" name="completed" value="true" <?php if($course->getCompleted() == 1) echo "checked"; ?> onclick="onToggle()"><br>
                    </div>

                    <div class="col-md-4">
                        <label class="control-label">Completed date (pp.kk.vvvv)</label>
						<?php
						if($course->getCompletedDate() == "01.01.1970") {
							$date = "";
						} else {
							$date = $course->getCompletedDate();
						}
						?>
                        <input class="form-control disable" type="text" value="<?php print($date) ?>" name="completedDate" autocomplete="off">
						<?php print("<span class='err'>".$course->getError($completedDateError)."</span>"); ?><br>
					</div>
                    <div class="col-md-2">
                        <label class="control-label">Grade</label>
                        <select class="form-control disable" id="grade" name="grade">
						<option disabled selected value = "0">-- select --</option>
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
						<option value="5">5</option>
						<option value="H">H</option>
						<option value="V">exemption</option>
						<option value="X">failed</option>
						</select>
						<?php print("<span class='err'>".$course->getError($gradeError)."</span>"); ?><br>
						<br><br>
					</div>
					<script type="text/javascript">					
						setOption(document.getElementById('grade'), '<?php print($course->getGrade()) ?>');
					</script>

                    <div class="col-md-12">
                        <label class="control-label">Info</label>
                        <textarea class="form-control" name="textField"><?php print($course->getTextField()) ?></textarea>
						<?php print("<span class='err'>".$course->getError($textFieldError)."</span>"); ?>
					</div>
					<div class = col-md-6><br><br>
										
						<input type="submit" name="submit" value="Save" class="btn btn-success">
						<input type="submit" name="clear" value="Cancel" class="btn btn-danger">
						<br><br><br><br>
					</div>
				</div>
        </div>
</div>
</form>

<?php require_once "bottom.php" ?>