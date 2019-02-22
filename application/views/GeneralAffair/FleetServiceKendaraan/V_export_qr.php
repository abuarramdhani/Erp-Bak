<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
		<style>
		* {
		    box-sizing: border-box;
		}

		.column {
		    float: left;
		    width: 29%;
		    padding: 1%;
		    height: 300px; 
		    border: 3px solid double;
		}

		.row:after {
		    content: "";
		    display: table;
		    clear: both;
		}
		</style>
</head>
<body>
	<?php 
		$j = 0;
		$k = 0;
		foreach ($FleetKendaraan as $row) {
		$k++;
		$j++;
		if($k==1){
			echo "<div class='row'>";
		}
	?>
		  <div class="column">
		  <img src="<?php echo base_url('/assets/img/id_card.png'); ?>" width="325px" height="55px">
		  	<div>
		  		<img src="<?php echo base_url('assets/upload/qrcodeGA/'.$row['nomor_polisi'].'.png') ?>" width="100%" height="100%">
		  	</div>
		    <h1 style="text-align: center;border: 3px solid black;"><?php echo $row['nomor_polisi'] ?></h1>
		  </div>
	<?php 
		if($k==3){
			echo "</div>";
			$k=0;
		}
	} ?>
</body>
</html>
