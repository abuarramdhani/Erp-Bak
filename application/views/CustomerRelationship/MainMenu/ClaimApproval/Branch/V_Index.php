<section id="content">
	<div class="inner">
	<div style="padding-top: 10px"></div>
		<div class="box-header with-border">
			<h3 style="text-align:center;"><strong>Claims Approval of Branch CV. Karya Hidup Sentosa</strong></h3>
		</div>
		<div class="box-body">
		<?php foreach ($countData as $cd) { ?>
    		<div class="row">
        		<div class="col-lg-4 col-xs-6">
          			<div class="small-box bg-red">
            			<div class="inner">
              				<h3><?php echo $cd['NEW']; ?></h3>
              				<p>New Claims</p>
            			</div>
            			<div class="icon">
              				<i class="fa fa-file-text"></i>
            			</div>
            			<a class="small-box-footer" id="newClaims" href="#newClaims">
              				More info <i class="fa fa-arrow-circle-right"></i>
            			</a>
          			</div>
        		</div>
		        <div class="col-lg-4 col-xs-6">
		          	<div class="small-box bg-green">
		            	<div class="inner">
		              		<h3><?php echo $cd['APPROVED']; ?></h3>		
		              		<p>Claims Approved</p>
		            	</div>
		            	<div class="icon">
		              		<i class="fa fa-check-circle-o"></i>
		            	</div>
		            	<a href="#claimApproved" id="claimApproved" class="small-box-footer">
		              		More info <i class="fa fa-arrow-circle-right"></i>
		            	</a>
		          	</div>
		        </div>
		        <div class="col-lg-4 col-xs-6">
		          	<div class="small-box bg-aqua">
		            	<div class="inner">
		              		<h3><?php echo $cd['CLOSED']; ?></h3>
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
</section>