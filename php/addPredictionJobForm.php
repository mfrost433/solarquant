<!DOCTYPE public "-//w3c//dtd html 4.01 transitional//en" 
		"http://www.w3.org/TR/html4/loose.dtd">

<html>
<head>
<title>solarquant.Admin</title>
<link href='../css/solarStyle.css' type='text/css' rel='stylesheet'>
<link href='../css/bootstrap.min.css' type='text/css' rel='stylesheet'>
<link href='../css/bootstrap-theme.min.css' type='text/css'
	rel='stylesheet'>
<script src='../js/bootstrap.min.js'></script>
<script language="javascript" src="../includes/calendar.js"></script>
<script
	src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script
	src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.1.1.js"></script>
</head>

<body bgcolor='#ffffff'>
	<script
		src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script
		src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script src="https://code.jquery.com/jquery-3.1.1.js"></script>
	<script>
		function getDropdown(obj){

			$.ajax({
				type: "POST",
				url: "predictionScreen/dropdownData.php",
				data:"value="+obj.value,
				success: function(data){
					$(sourceId).html(data);
					}
				});
	    }
	    
</script>

	<span class='solar4'>Add a new PatternSet</span>
	<br>
	<br>

	<!--- add Entity --->
	<form method=POST action="./predictionJobAdded.php">

<?php
// get class into the page
require_once ('../classes/tc_calendar.php');

// TODO make this reflect the patternset
$defaultEngineId = 2;

$nodeId = $_REQUEST['nodeId'];
if (isset($nodeId)) {
    $defaultNodeId = $nodeId;
    
    // determine if actual
    if ($defaultNodeId <= 1000) {
        $theNodeType = "actual";
    } else // or virtual
{
        $theNodeType = "virtual";
    }
} else {
    $defaultNodeId = - 1;
    // only show actual nodes for now
    $theNodeType = "actual";
}

?>
<table cellpadding='15' width='700' cellspacing='15'
			class='table table-striped' border='0'>

			<tr>
				<td><span class="solar4">Analysis Engine</span></td>

				<td><select class="solar4" name="analysisEngine" id="analysisEngine">
						<option value="Tensorflow">Tensorflow</option>
						<option value="Emergent">Emergent</option>
				</select></td>

			</tr>

			<tr>
				<td><span class="solar4">Node and Source</span></td>
				<td><select name="nodeId" id="nodeId" onChange="getDropdown(this)"
					required>
            <?php
            $servername = "localhost";
            $username = "solarquant";
            $password = "solarquant";
            $dbname = "solarquant";
            
            $conn = new mysqli($servername, $username, $password, $dbname);
            
            $query = "SELECT node_id FROM registered_nodes";
            $result = $conn->query($query);
            
            $select = '<option value="">None</option>';
            while ($row = $result->fetch_assoc()) {
                $select .= '<option value="' . $row['node_id'] . '">' . $row['node_id'] . '</option>';
            }
            echo $select;
            
            ?>
            </select> <select name="sourceId" id="sourceId" required>
				</select></td>


			</tr>
			<tr class='solar4'>
				<td><span class="solar4">Start Date</span></td>
				<td>
<select>
<?php
$day = date("d");
for($i=1; $i<=31; $i++){
	echo("<option value='".$i."'>$i</option>");
	if($day != $i){
		echo("<option value='".$i."'>$i</option>");
	}else{
		echo("<option selected='selected' value='".$i."'>$i</option>");
		
	}
}
?>
</select>

<select>
<?php
$month = date("m");

for($i=1; $i<=12; $i++){
	
	$dateObj   = DateTime::createFromFormat('!m', $i);
	$monthName = $dateObj->format('F'); // March

	if($month != $i){
		echo("<option value='".$i."'>$monthName</option>");
	}else{
		echo("<option selected='selected' value='".$i."'>$monthName</option>");
		
	}
}
?>
</select>

<select>
<?php
$year = date("Y");
for($i=1990; $i<=$year; $i++){
	
	if($i != $year-1){
		echo("<option value='".$i."'>$i</option>");
	}else{
		echo("<option selected='selected' value='".$i."'>$i</option>");
	}	
}

?>
</select>
	</td>

			</tr>
			<tr class='solar4'>
				<td><span class="solar4">End Date</span></td>
				<td>
<select>
<?php
$day = date("d");
for($i=1; $i<=31; $i++){
	echo("<option value='".$i."'>$i</option>");
	if($day != $i){
		echo("<option value='".$i."'>$i</option>");
	}else{
		echo("<option selected='selected' value='".$i."'>$i</option>");
		
	}
}
?>
</select>

<select>
<?php
$month = date("m");

for($i=1; $i<=12; $i++){
	
	$dateObj   = DateTime::createFromFormat('!m', $i);
	$monthName = $dateObj->format('F'); // March

	if($month != $i){
		echo("<option value='".$i."'>$monthName</option>");
	}else{
		echo("<option selected='selected' value='".$i."'>$monthName</option>");
		
	}
}
?>
</select>

<select>
<?php
$year = date("Y");
for($i=1990; $i<=$year; $i++){
	
	if($i != $year){
		echo("<option value='".$i."'>$i</option>");
	}else{
		echo("<option selected='selected' value='".$i."'>$i</option>");
	}	
}

?>
</select>
    Dynamic Refresh <label class="switch">
  <input type="checkbox" name="endDateToggle">
  <span class="slider round"></span>
</label>
	</td>

			</tr>
			<tr>
				<td><span class="solar4">Name</span></td>
				<td><input class="solar4" type="text" name="name" value=""
					size="40"></td>

			</tr>
			<tr>
				<td><span class="solar4">PatternSet Status Id <br>(0 = not processed
						queued for processing)
				</span></td>
				<td><input class="solar4" type="text" name="statusId" value="0"
					size="4"></td>

			</tr>
			<tr>
				<td><span class="solar4">PatternSet Type Id <br>(1 = consumption, 2
						= generation, 3 = both consumption and generation, 4 = forecast)
				</span></td>
				<td><select class="solar4" name="patternSetTypeId"
					id="patternSetTypeId">
						<option value="1">Consumption</option>
						<option value="2">Generation</option>
						<option value="3">Not Used</option>
						<option value="4">Forecast</option>
				</select></td>

			</tr>
			<tr>
				<td><span class="solar4">Notes:</span></td>
				<td><textarea cols="70" rows="5" name="notes"></textarea></td>
			</tr>

		</table>


		<button type='submit' class='btn btn-success'">Add</button>
		<br> <br>



	</form>

</body>
</html>
