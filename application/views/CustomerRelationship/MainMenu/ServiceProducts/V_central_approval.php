<form method="post" action="<?php echo site_url('CustomerRelationship/ServiceProducts/Approval/'.$id)?>">
<?php foreach ($ServiceProducts as $ServiceProducts_item){ ?>
	<input id="status" type="hidden" name="status" value="CENTRAL APPROVAL" />
	<input id="hdnUser" type="hidden" value="<?php echo $this->session->userid; ?>" name="hdnUser" />
	<input id="hdnDate" type="hidden" value="<?php echo date("Y-m-d H:i:s")?>" name="hdnDate" />
	<input id="ServiceProductId" type="hidden" name="ServiceProductId" value="<?php echo $ServiceProducts_item['service_product_id']?>"/>
	<div class="modal fade" id="approve" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
	    	<div class="modal-content">
	      		<div class="modal-header">
	        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        		<h4 class="modal-title" id="myModalLabel">Central Approval Confirmation</h4>
	      		</div>
	      		<div class="modal-body">
	        		<h3>Are you sure will approve this external claims?</h3>
	        		<input type="radio" name="approveval" value="Y" id="approvevaly" required> YES
	        		<input type="radio" name="approveval" value="N" id="approvevaln"> NO
	        		<div id="reasonnotapprove"></div>
	      		</div>
	      		<div class="modal-footer">
	        		<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
	        		<button type="submit" class="btn btn-danger">Submit</a>
	      		</div>
	    	</div>
	  	</div>
	</div>
<?php } ?>
</form>