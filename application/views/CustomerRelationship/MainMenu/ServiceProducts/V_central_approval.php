<form method="post" action="<?php echo site_url('CustomerRelationship/ServiceProducts/Approval/'.$id)?>">
<?php foreach ($ServiceProducts as $ServiceProducts_item){ ?>
	<input type="hidden" name="status" value="CENTRAL APPROVAL" />
	<input type="hidden" value="<?php echo $this->session->userid; ?>" name="hdnUser" />
	<input type="hidden" value="<?php echo date("Y-m-d H:i:s")?>" name="hdnDate" />
	<input type="hidden" name="ServiceProductId" value="<?php echo $ServiceProducts_item['service_product_id']?>"/>
	<div class="modal fade" id="approve" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
	    	<div class="modal-content">
	      		<div class="modal-header">
	        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        		<h4 class="modal-title" id="myModalLabel">Approval Confirmation</h4>
	      		</div>
	      		<div class="modal-body">
	        		<h3>Central Approvall?</h3>
	      		</div>
	      		<div class="modal-footer">
	        		<button type="button" class="btn btn-default" data-dismiss="modal">No</button>
	        		<button type="submit" class="btn btn-danger">Yes</a>
	      		</div>
	    	</div>
	  	</div>
	</div>
<?php } ?>
</form>