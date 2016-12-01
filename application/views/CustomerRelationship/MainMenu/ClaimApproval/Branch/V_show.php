<!-- Modal -->
<?php $no=1; foreach ($header as $h) { ?>
<div class="modal fade" id="show<?php echo $h['HEADER_ID']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  	<div class="modal-dialog  modal-lg" role="document">
    	<div class="modal-content">
      		<div class="modal-header">
        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        		<h4 class="modal-title" id="myModalLabel">Data Claims No <?php echo $h['HEADER_ID']; ?></h4>
      		</div>
      		<div class="modal-body">
      			<div class="row">
      				<div class="col-md-2">
      					<strong>NO. CLAIM</strong>
      				</div>
      				<div class="col-md-4">: 123456ASA00001 </div>
      				<div class="col-md-2">
      					<strong>CLAIM TYPE</strong>
      				</div>
      				<div class="col-md-4">
      					: <?php echo $h['CLAIM_TYPE']; ?>
      				</div>
      			</div>
      			<div class="row">
      				<div class="col-md-12"><br><div class="box box-danger"></div></div>
      			</div>
      			<?php $no=1; foreach ($lines as $l) { 
      				if ($l['HEADER_ID']==$h['HEADER_ID']) { ?>
      					<div class="row">
      						<div class="col-md-2"><strong>PRODUCT TYPE <?php echo $no; ?></strong></div>
      						<div class="col-md-4"><strong>:</strong> <?php echo $l['PRODUCT_TYPE']; ?></div>
      						<div class="col-md-2"><strong>NO. PRODUCTION <?php echo $no++; ?></strong></div>
      						<div class="col-md-4"><strong>:</strong> <?php echo $l['PRODUCTION_CODE']; ?></div>
      					</div>
      					<div class="row">
      						<div class="col-md-2"><strong>PART NAME <?php echo $no; ?></strong></div>
      						<div class="col-md-4"><strong>:</strong> <?php echo $l['ITEM_DESCRIPTION']; ?></div>
      						<div class="col-md-2"><strong>PART CODE <?php echo $no++; ?></strong></div>
      						<div class="col-md-4"><strong>:</strong> <?php echo $l['ITEM_CODE']; ?></div>
      					</div>
      					<div class="row">
      						<div class="col-md-2"><strong>QUANTITY<?php echo $no; ?></strong></div>
      						<div class="col-md-4"><strong>:</strong> <?php echo $l['QUANTITY']; ?></div>
      						<div class="col-md-2"><strong>COR CODE <?php echo $no++; ?></strong></div>
                  <?php if ($l['CAST_CODE']==NULL) {
                    $cor = '--';
                  }else{
                    $cor = $l['CAST_CODE'];
                  } ?>
      						<div class="col-md-4"><strong>:</strong> <?php echo $cor; ?></div>
      					</div>
      					<div class="row">
      						<div class="col-md-10 col-md-offset-1"><hr></div>
      					</div>
      				<?php } else {
      					//do nothing!
      				} ?>
      			<?php } ?>
      			<div class="row">
      				<div class="col-md-12"><div class="box box-danger"></div></div>
      			</div>
            <div class="row">
              <div class="col-md-2"><strong>CUSTOMER NAME</strong></div>
              <div class="col-md-4"><strong>:</strong> <?php echo $h['PARTY_NAME']; ?></div>
            </div>
      			<div class="row">
      				<div class="col-md-2"><strong>OWNER NAME</strong></div>
                <?php if ($h['OWNER_NAME']==NULL) {
                  $ownerName = '--';
                }else{
                  $ownerName = $h['OWNER_NAME'];
                } ?>
              <div class="col-md-4"><strong>:</strong> <?php echo $ownerName; ?></div>
      				<div class="col-md-2"><strong>OWNER ADDRESS</strong></div>
      				<div class="col-md-4"><strong>:</strong> <?php echo $h['OWNER_ADDRESS']; ?></div>
      			</div>
      			<div class="row">
              <div class="col-md-2"><strong>PHONE NUMBER</strong></div>
              <div class="col-md-4"><strong>:</strong> <?php echo $h['OWNER_PHONE_NUMBER']; ?></div>
              <div class="col-md-2"><strong>DURATION OF USE</strong></div>
              <div class="col-md-4"><strong>:</strong> <?php echo $h['DURATION_OF_USE']; ?></div>
            </div>
            <div class="row">
              <div class="col-md-12"><br><div class="box box-danger"></div></div>
            </div>
            <div class="row">
              <div class="col-md-2"><strong>ADDRESS</strong></div>
              <div class="col-md-4"><strong>:</strong> <?php echo $h['LOCATION_ADDRESS']; ?></div>
              <div class="col-md-2"><strong>VILLAGE</strong></div>
              <div class="col-md-4"><strong>:</strong> <?php echo $h['LOCATION_VILLAGE']; ?></div>
            </div>
            <div class="row">
              <div class="col-md-2"><strong>DISTRICT</strong></div>
              <div class="col-md-4"><strong>:</strong> <?php echo $h['LOCATION_DISTRICT']; ?></div>
              <div class="col-md-2"><strong>CITY / REGENCY</strong></div>
              <div class="col-md-4"><strong>:</strong> <?php echo $h['LOCATION_CITY']; ?></div>
            </div>
            <div class="row">
              <div class="col-md-2"><strong>PROVINCE</strong></div>
              <div class="col-md-4"><strong>:</strong> <?php echo $h['LOCATION_PROVINCE']; ?></div>
            </div>
            <div class="row">
              <div class="col-md-12"><br><div class="box box-danger"></div></div>
            </div>
            <div class="row">
              <div class="col-md-2"><strong>LAND CATEGORY</strong></div>
              <div class="col-md-4"><strong>:</strong> <?php echo $h['LAND_CATEGORY']; ?></div>
              <div class="col-md-2"><strong>SOIL</strong></div>
              <div class="col-md-4"><strong>:</strong> <?php echo $h['TYPE_OF_SOIL']; ?></div>
            </div>
            <div class="row">
              <div class="col-md-2"><strong>LAND DEPTH</strong></div>
              <div class="col-md-4"><strong>:</strong> <?php echo $h['LAND_DEPTH']; ?></div>
              <div class="col-md-2"><strong>WEEDS</strong></div>
              <div class="col-md-4"><strong>:</strong> <?php echo $h['WEEDS']; ?></div>
            </div>
            <div class="row">
              <div class="col-md-2"><strong>TOPOGRAPHY</strong></div>
              <div class="col-md-4"><strong>:</strong> <?php echo $h['TOPOGRAPHY']; ?></div>
            </div>
            <div class="row">
              <div class="col-md-12"><br><div class="box box-danger"></div></div>
            </div>
            <div class="row">
              <div class="col-md-3"><strong>EVENT CHRONOLOGY</strong></div>
              <div class="col-md-9"><strong>:</strong> <?php echo $h['EVENT_CHRONOLOGY']; ?></div>
            </div>
            <div class="row">
              <div class="col-md-3"><strong>A Preliminary Investigation and Remediation</strong></div>
              <div class="col-md-9"><strong>:</strong> <?php echo $h['NOTE']; ?></div>
            </div>
      			<div class="row"></div>
	    	</div>
      		<div class="modal-footer">
        		<button type="button" class="btn btn-default" data-dismiss="modal">CLOSE</button>
      		</div>
    	</div>
  	</div>
</div>
<?php } ?>