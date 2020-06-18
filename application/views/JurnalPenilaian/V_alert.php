<?php
	if($this->session->userdata('success_insert')){ 
?>
	<div class="alert alert-success alert-dismissable"  style="width:100%;" >
					 <li class="fa fa-warning"> </li> Success Add New Period !!!
			</div>
<?php
	}
?>
<?php
	if($this->session->userdata('success_delete')){ 
?>
	<div class="alert alert-danger alert-dismissable"  style="width:100%;" >
					 <li class="fa fa-warning"> </li> Success Remove Period !!!
			</div>
<?php
	}
?>