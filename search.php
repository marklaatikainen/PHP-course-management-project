<?php require_once "top.php" ?>
<script type="text/javascript">
function script() {
	var d = document.getElementById("search");
	d.className += "active";
}
</script>
<script type="text/javascript">
function find(str) {
	$.ajax({
	    type: 'GET',
	    url: 'getjson.php',
	    contentType: "json",
	    data: "q="+str,
        success: function(data){
			data = JSON.parse(data);
			$('#result').html("");
			if(data.length < 1) {
				$('#result').append("No results!");
			}
			for(var i = 0; i < data.length; i++) {
					var completed = "";
					var grade = data[i].grade;
					if (grade == "H"){
						grade = "Passed";
					} else if(grade == "X") {
						grade = "<span class='err'>Failed</span>";
					} else if(grade == "V"){
						grade = "<span class='gr'>Excemption</span>";
					} else {
						grade = data[i].grade;
					}
					
					if(data[i].completed == "0") {
						completed = "<i>Not yet completed</i><br>";
					} else {
						completed = "Completed: <i>" + data[i].completeddate + "</i><br>Grade: <i>" + grade + "</i><br>";
					}
					$('#result').append("<br>Name: <i>" + data[i].firstname + " " + data[i].lastname + "</i><br>Course: <i>" + data[i].courseid + " " + data[i].coursename + "</i><br>Ects: <i>" + data[i].ects + "</i><br>" + completed + "Info: <i>" + data[i].info + "</i><br>");		
			}
			$('#result').append("<br><br>");
        }
	});     
}
</script>
<?php echo "<h4>Search (JSON)</h4>"; ?>
<form method="GET">
	<br>
	<div class="col-md-5">
	<input class="form-control" type="text" id="input" placeholder="keyword" onkeyup="find(this.value)">
</div>
</form>
<br>
<div class="col-md-12" id="result"></div>
<?php require_once "bottom.php" ?>