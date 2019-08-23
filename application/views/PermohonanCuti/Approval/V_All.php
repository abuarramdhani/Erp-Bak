<section class="content">
  <div class="panel-body">
  	<div class="row">
      <div class="box box-primary box-solid">
    		<div class="box-header with-border">
    			<h2 align="center"><strong><?=$Menu ?></strong></h2>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse">
              <i class="fa fa-minus"></i>
            </button>
          </div>
    		</div>
        <div class="box-body  bg-info">
          <div class="row">
        		<div class="col-lg-12">
        			<div class="row">
        				<div class="col-lg-1">
        					<text>Nama 			  </text><br>
        					<text>No Induk	  </text><br>
        					<text>Seksi 		  </text><br>
        					<text>Unit			  </text><br>
        					<text>Departemen  </text>
        				</div>
        				<div class="col-lg-11">
        					<?php foreach ($Info as $key): ?>
        						<text>: <?=$key['nama']?></text> <br>
        						<text>: <?=$key['noind']?> </text><br>
        						<text>: <?=$key['seksi']?> </text><br>
        						<text>: <?=$key['unit']?> </text><br>
        						<text>: <?=$key['dept']?> </text>
        					<?php endforeach; ?>
        				</div>
        			</div>
        		</div>
          </div>
        </div>
    	</div>
  	</div>
    <div class="row">
      <div class="box box-primary box-solid">
          <div class="box-header with-border">
             <h4><strong>Semua Approval   <i class="fa fa-reorder"></i></strong></h4>
          </div>
          <div class="box-body">
            <table class="table table-bordered table-striped text-left" style="font-size:12px; width: 100%">
              <div class="row"></div>
                </div>
                <thead>
                  <tr class="bg-primary">
                    <th>No</th>
                    <th>Noind</th>
                    <th>Nama</th>
                    <th>Jenis Cuti</th>
                    <th>Status</th>
                    <th>Keterangan</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $no = 1;
                    foreach ($All as $key) {
                      $encrypted_string = $this->encrypt->encode($key['id_cuti']);
                      $encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
                      $detail = base_url('PermohonanCuti/Approval/Approved/Detail/'.$encrypted_string);
                      ?>
                      <tr>
                        <td><?php echo $no ?></td>
                        <td><?php echo $key['noind'] ?></td>
                        <td><?php echo $key['name'] ?></td>
                        <td><?php echo $key['jenis_cuti'] ?></td>
                        <td><?php if ($key['status'] == '0'){ ?>
      											<span class='label label-warning'> Belum request</span>
      										<?php }elseif ($key['status'] == '1') {
      											echo "<span class='label label-warning'><i class='fa fa-clock-o'> </i>  Menunggu Approval</span>";
      										}elseif ($key['status'] == '2') {
      											echo "<span class='label label-success'><i class='fa fa-check'> </i>  Approved</span>";
      										}else{
      											echo "<span class='label label-danger'><i class='fa fa-close'> </i>  Rejected</span>";
      										}
      									 ?></td>
                        <td><a href="<?php echo $detail ?>"><span class="fa fa-info" title="Detail">Detail</span></a></td>
                      </tr>
                    <?php $no++; } ?>
                </tbody>
            </table>
      </div>
    </div>
  </div>
</section>
