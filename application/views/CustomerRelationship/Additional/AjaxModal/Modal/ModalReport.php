<head>
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
		var responsibility = $('input#hdnResponsibilityId').val();
		if(id == ''){
			$( "#result" ).html('');
		}else{
			//$( "#result" ).html(id);
			
			$.post(base+"ajax/ResultReport", {id:id,responsibility:responsibility}, function(data){
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
	<h4 class="modal-title" id="H1">Report Search</h4>
</div>
<div class="modal-body">
	<form class="form-horizontal">
	<table class="table">
		<tr>
			<td width="5%" style="border:none;"><label style="margin-top:20%;">Search</label></td>
			<td width="95%" style="border:none;"> <input type="text" class="form-control" name="search" id="search" value="%" placeholder="Search Report here" autofocus/>
			<input type="hidden" name="hdnResponsibilityId" id="hdnResponsibilityId" value="<?= $responsibility_id ?>" />
			</td>
			
		</tr>
	</table>
	<div id="result">
	
	</div>
	</form>
</div>

</div>