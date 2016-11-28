<head>
	<!-- GLOBAL SCRIPTS -->
	 <script>
	
	$( document ).ready(function() {
       
	  // document.getElementById("search").focus();
	   $(window).keydown(function(event){
			if(event.keyCode == 13) {
			  event.preventDefault();
			  getData('<?php echo base_url();?>');
			  $( "#search" ).focus();
			}else{
				$( "#search" ).focus();
			}
			
		});
	});	
	
	function getData(base){
		var id = $('#search').val();
		if(id == ''){
			$( "#result" ).html('');
		}else{
			//$( "#result" ).html(id);
			
			$.post(base+"ajax/ResultEmployee", {id:id}, function(data){
				$("#result").html(data);	
			});
			
		}
		$( "#search" ).focus();
	}
	
	$( "#search" ).focus();
	</script>
</head>
<div style="background:#FFF;width:900px;margin-left:auto;margin-right:auto;margin-top: 5%;">
 <div class="modal-header" >
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h4 class="modal-title" id="H1">Employee Search</h4>
</div>
<div class="modal-body">
	<form class="form-horizontal">
	<table class="table">
		<tr>
			<td width="5%" style="border:none;"><label style="margin-top:20%;">Search</label></td>
			<td width="95%" style="border:none;"> <input type="text" class="form-control" name="search" id="search" value="%" placeholder="Search employee code or name here" autofocus/></td>
			<!--
			<td width="10%"><a class="btn btn-primary" onclick="getData('<?php echo base_url();?>');">Search</a></td>
			-->
		</tr>
	</table>
	<div id="result">
	
	</div>
	</form>
</div>

</div>