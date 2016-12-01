<section id="content">
	<div class="inner">
	<div style="padding-top: 10px">
		<div class="box-header with-border">
			<h3 style="text-align:center;"><strong>Central Approval Claims</strong></h3>
		</div>
		<div class="box-body">
		<?php foreach ($data as $d) { ?>
    		<div class="row">
        		<div class="col-lg-4 col-xs-6">
          			<div class="small-box bg-red">
            			<div class="inner">
              				<h3><?php echo $d['OVER']; ?></h3>
              				<p>New Claims</p>
            			</div>
            			<div class="icon">
              				<i class="fa fa-file-text"></i>
            			</div>
		            	<a href="#newClaims" id="over24Hour" class="small-box-footer">
		        	    	More info <i class="fa fa-arrow-circle-right"></i>
		            	</a>
          			</div>
        		</div>
		        <div class="col-lg-4 col-xs-6">
		          	<div class="small-box bg-green">
		            	<div class="inner">
		              		<h3><?php echo $d['APPROVED']; ?></h3>
		              		<p>Claims Approved</p>
		            	</div>
		            	<div class="icon">
		              		<i class="fa fa-check-circle-o"></i>
		            	</div>
		            	<a href="#centralApproved" id="centralApproved" class="small-box-footer">
		              		More info <i class="fa fa-arrow-circle-right"></i>
		            	</a>
		          	</div>
		        </div>
		        <div class="col-lg-4 col-xs-6">
		          	<div class="small-box bg-aqua">
		            	<div class="inner">
		              		<h3><?php echo $d['CLOSED']; ?></h3>
		              		<p>Claim Closed</p>
		            	</div>
		            	<div class="icon">
		              		<i class="fa fa-remove"></i>
		            	</div>
		            	<a href="#ClaimClosed" id="ClaimClosed" class="small-box-footer">
		              		More info <i class="fa fa-arrow-circle-right"></i>
		            	</a>
		          </div>
		        </div>
		    </div>
		    <?php } ?>
			<div style="padding-top: 10px"></div>
			<div class="box-body">
				<div id="showClaimsData"></div>
			</div>
		</div>
	</div>
	</div>
</section>
