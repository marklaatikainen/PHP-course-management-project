<?php
	class coursePDO{
		private $db;
		private $count;


		function __construct($dsn="mysql:host=localhost;dbname=<db>", $user="<root>", $password="<password>") {		
			$this->db  = new PDO($dsn, $user, $password);
			$this->db ->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
			$this->db ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
			$this->count = 0;
		}


		function addCourse($course) {
			$sql = "INSERT INTO courses(opFirstName,opLastName,courseName,courseId,ects,completed,completedDate,grade,info) values(:firstName, :lastName, :courseName, :courseId, :ects, :completed, :completedDate, :grade, :textField)";

			if (! $stmt = $this->db->prepare($sql)) {
				$error = $this->db->errorInfo(); 
				throw new PDOException($error[2], $error[1]);
			}
			$cDate = date('Y-m-d',strtotime($course->getCompletedDate()));
			$stmt->bindValue(":firstName", utf8_decode($course->getFirstName()), PDO::PARAM_STR);
			$stmt->bindValue(":lastName", utf8_decode($course->getLastName()), PDO::PARAM_STR);
			$stmt->bindValue(":courseName", utf8_decode($course->getCourseName()), PDO::PARAM_STR);
			$stmt->bindValue(":courseId", utf8_decode($course->getCourseId()), PDO::PARAM_STR);
			$stmt->bindValue(":ects", utf8_decode($course->getEcts()), PDO::PARAM_INT);
			$stmt->bindValue(":completed", utf8_decode($course->getCompleted()), PDO::PARAM_BOOL);
			$stmt->bindValue(":completedDate", $cDate, PDO::PARAM_STR);
			$stmt->bindValue(":grade", utf8_decode($course->getGrade()), PDO::PARAM_STR);
			$stmt->bindValue(":textField", utf8_decode($course->getTextField()), PDO::PARAM_STR);


			if (! $stmt->execute()) {
				$error = $stmt->errorInfo(); 
				
				if ($error[0] == "HY093") {
					$error[2] = "Invalid parameter"; 
				}
				
				throw new PDOException($error[2], $error[1]);
			}
			
			$this->count = 1;
			return $this->db->lastInsertId();
		}

		function getAllCourses() {
			$sql = "SELECT id,opFirstName,opLastName,courseName,courseId,ects,completed,completedDate,grade,info FROM course";

			if (!$stmt= $this->db->prepare($sql)) {
				$error = $this->db->errorInfo(); 
				throw new PDOException($error[2], $error[1]);
			} 
			
			if (! $stmt->execute()) {
				$error = $stmt->errorInfo(); 
				throw new PDOException($error[2], $error[1]);
			}

			$result = array();

			while ($row = $stmt->fetchObject()) {
				$course = new Course();
				$course->setId(utf8_encode($row->id));
				$course->setFirstName(utf8_encode($row->opFirstName));
				$course->setLastName(utf8_encode($row->opLastName));
				$course->setCourseName(utf8_encode($row->courseName));
				$course->setCourseId(utf8_encode($row->courseId));
				$course->setEcts(utf8_encode($row->ects));
				$course->setCompleted(utf8_encode($row->completed));
				$course->setCompletedDate(utf8_encode($row->completedDate));
				$course->setGrade(utf8_encode($row->grade));
				$course->setTextField(utf8_encode($row->info));

				$result[] = $course;
			}

			$this->count = $stmt->rowCount();
			return $result;
		}

		function findCourse($id) {
			$sql = "SELECT id,opFirstName,opLastName,courseName,courseId,ects,completed,completedDate,grade,info FROM course WHERE id = '$id'";

			if (!$stmt= $this->db->prepare($sql)) {
				$error = $this->db->errorInfo(); 
				throw new PDOException($error[2], $error[1]);
			} 
			
			if (! $stmt->execute()) {
				$error = $stmt->errorInfo(); 
				throw new PDOException($error[2], $error[1]);
			}

			$result = array();

			while ($row = $stmt->fetchObject()) {
				$course = new Kurssi();
				$course->setId(utf8_encode($row->id));
				$course->setFirstName(utf8_encode($row->opFirstName));
				$course->setLastName(utf8_encode($row->opLastName));
				$course->setCourseName(utf8_encode($row->courseName));
				$course->setCourseId(utf8_encode($row->courseId));
				$course->setEcts(utf8_encode($row->ects));
				$course->setCompleted(utf8_encode($row->completed));
				$course->setCompletedDate(utf8_encode($row->completedDate));
				$course->setGrade(utf8_encode($row->grade));
				$course->setTextField(utf8_encode($row->info));

				$result[] = $course;
			}

			return $result;
		}

		function findLike($str) {
			$sql = "SELECT id,opFirstName,opLastName,courseName,courseId,ects,completed,completedDate,grade,info FROM course WHERE opFirstName LIKE '%$str%' OR opLastName LIKE '%$str%' OR courseName LIKE '%$str%' OR courseId LIKE '%$str%' OR ects LIKE '%$str%' OR completed LIKE '%$str%' OR completedDate LIKE '%$str%' OR grade LIKE '%$str%' OR info LIKE '%$str%'";

			if (!$stmt= $this->db->prepare($sql)) {
				$error = $this->db->errorInfo(); 
				throw new PDOException($error[2], $error[1]);
			} 
			
			if (! $stmt->execute()) {
				$error = $stmt->errorInfo(); 
				throw new PDOException($error[2], $error[1]);
			}

			$result = array();

			while ($row = $stmt->fetchObject()) {
				$course = new Course();
				$course->setId(utf8_encode($row->id));
				$course->setFirstName(utf8_encode($row->opFirstName));
				$course->setLastName(utf8_encode($row->opLastName));
				$course->setCourseName(utf8_encode($row->courseName));
				$course->setCourseId(utf8_encode($row->courseId));
				$course->setEcts(utf8_encode($row->ects));
				$course->setCompleted(utf8_encode($row->completed));
				$course->setCompletedDate(utf8_encode($row->completedDate));
				$course->setGrade(utf8_encode($row->grade));
				$course->setTextField(utf8_encode($row->info));

				$result[] = $course;
			}

			$this->count = $stmt->rowCount();
			return json_encode($result);
		}

		function deleteCourse($id) {
			$sql = "DELETE FROM course WHERE id ='$id'";

			if (!$stmt= $this->db->prepare($sql)) {
				$error = $this->db->errorInfo(); 
				throw new PDOException($error[2], $error[1]);
			}

			if (! $stmt->execute()) {
				$error = $stmt->errorInfo(); 
				throw new PDOException($error[2], $error[1]);
			}
		}

		function updateCourse($c, $id) {
			$sql = "UPDATE `course` 
					SET 	opFirstName = :firstName
						,	opLastName = :lastName
						,	courseName = :courseName
						,	courseId = :courseId
						,	ects = :ects
						,	completed = :completed
						,	completedDate = :completedDate
						,	grade = :grade
						,	info = :textField 
					WHERE 	id = :id";


			if (! $stmt = $this->db->prepare($sql)) {
				$error = $this->db->errorInfo(); 
				throw new PDOException($error[2], $error[1]);
			}
			$cDate = date('Y-m-d',strtotime($c->getCompletedDate()));
			$stmt->bindValue(":firstName", utf8_decode($c->getFirstName()), PDO::PARAM_STR);
			$stmt->bindValue(":lastName", utf8_decode($c->getLastName()), PDO::PARAM_STR);
			$stmt->bindValue(":courseName", utf8_decode($c->getCourseName()), PDO::PARAM_STR);
			$stmt->bindValue(":courseId", utf8_decode($c->getCourseId()), PDO::PARAM_STR);
			$stmt->bindValue(":ects", utf8_decode($c->getEcts()), PDO::PARAM_INT);
			$stmt->bindValue(":completed", utf8_decode($c->getCompleted()), PDO::PARAM_BOOL);
			$stmt->bindValue(":completedDate", $cDate, PDO::PARAM_STR);
			$stmt->bindValue(":grade", utf8_decode($c->getGrade()), PDO::PARAM_STR);
			$stmt->bindValue(":textField", utf8_decode($c->getTextField()), PDO::PARAM_STR);
			$stmt->bindValue(":id", $id, PDO::PARAM_INT);


			if (! $stmt->execute()) {
				$error = $stmt->errorInfo(); 
				
				if ($error[0] == "HY093") {
					$error[2] = "Invalid parameter"; 
				}
				
				throw new PDOException($error[2], $error[1]);
			}
			
			$this->count = 1;
			return $this->db->lastInsertId();
		}
	}



?>