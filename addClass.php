<?php
	class Course implements JsonSerializable {

		 private static $errorList = array(
		     -1 => "Data error",
		      0 => "",
		      // first name
		      1 => "First name cannot be empty",
		      2 => "First name is too short",
		      3 => "First name is too long",
		      4 => "There are forbidden characters in first name",
		      // last name
		      5 => "Last name cannot be empty",
		      6 => "Last name is too short",
		      7 => "Last name is too long",
		      8 => "There are forbidden characters in last name",
		      // course name
		      9 => "Course name cannot be empty",
		      10 => "Course name is too short",
		      11 => "Course name is too long",
		      12 => "There are forbidden characters in course name",
		      // course id
		      13 => "Course id cannot be empty",
		      14 => "Course id is too short",
		      15 => "Course id is too long",
		      16 => "Course id is in wrong format (ABC1DE234 / ABC1DE234-567)",
		      // ects
		      17 => "Ects cannot be empty",
		      18 => "Ects is not a number",
		      19 => "Too big number",
		      20 => "Ects is wrong",
		      // date
		      21 => "Date has wrong length",
		      22 => "Date cannot be in future",
		      23 => "Date cannot be older than 01.01.2015",
		      24 => "Date is in wrong format",
		      // grade
		      25 => "Select grade!",
		      26 => "Grade should be selected from the list",
		      // text field
		      27 => "Text field cannot be empty",
		      28 => "Text is too short (min 5 chars)",
		      29 => "Text is too long (max 150 chars)",
		      30 => "There are forbidden characters in text field!"
		  );

  		public static function getError($errorCode) {
		    if (isset(self::$errorList[$errorCode]))
		  		return self::$errorList[$errorCode];

		    return self::$errorList[-1];
   		}

		// attribuutit
		private $id;
		private $firstName;
		private $lastName;
		private $courseName;
		private $courseId;
		private $ects;
		private $completed;
		private $completedDate;
		private $grade;
		private $textField;

		private $newFirstName;
		private $newLastName;
		private $newCourseName;
		private $newCourseId;
		private $newEcts;
		private $newCompleted;
		private $newCompletedDate;
		private $newGrade;
		private $newTextField;

		// constructor

		function __construct ($id="",$newFirstName="", $newLastName="", $newCourseName="", $newCourseId="", $newEcts="", $newCompleted="", $newCompletedDate="", $newGrade="", $newTextField="") {
			$this->id = $id;
			$this->firstName = trim(ucfirst($newFirstName));
			$this->lastName = trim(ucfirst($newLastName));
			$this->courseName = trim($newCourseName);
			$this->courseId = trim(strtoupper($newCourseId));
			$this->ects = trim($newEcts);
			$this->completed = $newCompleted;
			$this->completedDate = trim($newCompletedDate);
			$this->grade = $newGrade;
			$this->textField = trim($newTextField);
		}


		public function jsonSerialize() {
			return array(
				"id" => $this->id,
				"firstname" => $this->firstName,
				"lastname" => $this->lastName,
				"coursename" => $this->courseName,
				"courseid" => $this->courseId,
				"ects" => $this->ects,
				"completed" => $this->completed,
				"completeddate" => $this->completedDate,
				"grade" => $this->grade,
				"info" => $this->textField
			);
		}

		public function setId($id) {
			$this->id = $id;
		}

		public function setFirstName($newFirstName) {
     		$this->firstName = $newFirstName;
  		}

  		public function setLastName($newLastName) {
  			$this->lastName = $newLastName;
  		}

		public function setCourseName($newCourseName) {
  			$this->courseName = $newCourseName;
  		}

  		public function setCourseId($newCourseId) {

  			$this->courseId = $newCourseId;
  		}

  		public function setEcts($newEcts) {
  			$this->ects = $newEcts;
  		}

  		public function setCompleted($newCompleted) {
  			$this->completed = $newCompleted;
  		}

  		public function setCompletedDate($newCompletedDate) {
  			$newCompletedDate = strtotime($newCompletedDate);
	  		$this->completedDate = date('d.m.Y', $newCompletedDate);
  		}

  		public function setGrade($newGrade) {
  			$this->grade = $newGrade;
  		}

  		public function setTextField($newTextField) {
  			$this->textField = $newTextField;
  		}

  		public function getId() {
  			return $this->id;
  		}

  		public function getFirstName() {
		    return $this->firstName;
  		}

  		public function getLastName() {
		    return $this->lastName;
  		}

 		public function getCourseName() {
		    return $this->courseName;
  		}

  		public function getCourseId() {
		    return $this->courseId;
  		}

  		public function getEcts() {
		    return $this->ects;
  		}

  		public function getCompleted() {
		    return $this->completed;
  		}

  		public function getCompletedDate() {
			return $this->completedDate;
  		}

  		public function getGrade() {
		    return $this->grade;
  		}

  		public function getTextField() {
		    return $this->textField;
  		}

  	// check firt name
	public function checkFirstName($min=2, $max=15) {

	    if (strlen($this->firstName) == 0)
		    return 1;

	    if (strlen($this->firstName) < $min)
	    	return 2;
	    
	    if(strlen($this->firstName) > $max)
	      return 3;

	    if (preg_match("/^[A-ZÅÄÖ]{1}'?[- a-zåäöA-ZÅÄÖ]( [a-zåäöA-ZÅÄÖ])*$/", $this->firstName))
	      return 4;

	    return 0;
  	}

  	// check last name
	public function checkLastName($min=2, $max=15) {

	    if (strlen($this->lastName) == 0)
		    return 5;

	    if (strlen($this->lastName) < $min)
	    	return 6;

	    if (strlen($this->lastName) > $max)
	      return 7;

	    if (preg_match("/^[A-ZÅÄÖ]{1}'?[- a-zåäöA-ZÅÄÖ]( [a-zåäöA-ZÅÄÖ])*$/", $this->lastName))
	      return 8;

	    return 0;
  	}

  	// check course name
	public function checkCourseName($min=5, $max=70) {

	    if (strlen($this->courseName) == 0)
		    return 9;

	    if (strlen($this->courseName) < $min)
	    	return 10;

	    if(strlen($this->courseName) > $max)
	      return 11;

	    if (preg_match("/[^0-9a-zåäöA-ZÅÄÖ: \-]/", $this->courseName))
	      return 12;

	    return 0;
  	}

  	// check course ID
	public function checkCourseID($min=5, $max=15) {

	    if (strlen($this->courseId) == 0)
		    return 13;

	    if (strlen($this->courseId) < $min)
	    	return 14;

	    if(strlen($this->courseId) > $max)
	      return 15;

	    if (!preg_match("/^([A-Za-z]{3}[0-9]{1}[A-Za-z]{2}[0-9]{3}$)|([A-Za-z]{3}[0-9]{1}[A-Za-z]{2}[0-9]{3}-[0-9]{1,3}$)/", $this->courseId))
	      return 16;

	    return 0;
  	}

  	// check for ects
	public function checkEcts() {

	  	if ($this->ects == null)
		    return 17;

		if($this->ects != null && !is_numeric($this->ects))
			return 18;

		if ($this->ects > 30)
	    	return 19;

	    if(!preg_match("/^([0-2]?[0-9]|30)$/", $this->ects))
	    	return 20;


	    return 0;
	  	}

  		// check if date is valid
  		public function checkCompletedDate($req, $min=8, $max=10) {
	    $current = time();
		$old = strtotime('01.01.2015');

	  	if ($req == false && strlen($this->completedDate) == 0)
		    return 0;

		if (strlen($this->completedDate) < $min || strlen($this->completedDate) > $max)
	      return 21;

	    // is date in the future?	    
	    if(strtotime($this->completedDate) > $current)
	    	return 22;

	    // is date too small?
		if(strtotime($this->completedDate) < $old)
			return 23;


	    if (preg_match("/^[0-3][0-9].[0-1][0-9].[0-9]{4}$/",$this->completedDate)) {
		    return 0;
	    } else {
	    	return 24;
	    }


	    return 0;
	  	}

  		public function checkGrade($req, $min=1, $max=1) {

	  	if ($req == false && strlen($this->grade) == 0)
		    return 0;

	    if (strlen($this->grade) < $min || strlen($this->grade) > $max)
	      return 25;

	    if (preg_match("/^[^1-5HVX]$/", $this->grade))
	      return 26;

	    return 0;
  	}

  		public function checkTextField($min=5, $max=150) {

	    if (strlen($this->textField) == 0)
		    return 27;

	    if (strlen($this->textField) < $min)
	    	return 28;

	    if (strlen($this->textField) > $max)
	      return 29;

	    if (!preg_match("/^[a-zåäöA-ZÅÄÖ0-9?$@#()'!,+\-=_:.&€£*%\s]+$/", $this->textField))
	      return 30;

	    return 0;
  	}
}

?>