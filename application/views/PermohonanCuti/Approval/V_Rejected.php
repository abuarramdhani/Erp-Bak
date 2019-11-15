<style media="screen">
@media screen and (max-width: 767px) {
  div.dataTables_length {
    display: none !important;
  }
  div.dataTables_wrapper div.dataTables_filter{
    float:right !important;
  }
  .personal{
    display:none;
  }
}
</style>

<section class="content">
  <div class="panel-body">
  	<div class="row">
      <div class="box box-primary box-solid">
    		<div style="height: 5em" class="box-header with-border">
    			<h2 align="center"><strong><?=$Menu ?></strong></h2>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse">
              <i class="fa fa-minus"></i>
            </button>
          </div>
    		</div>
        <div class="box-body personal bg-info">
          <div class="row">
        		<div class="col-lg-12">
        			<div class="row">
        				<div class="col-lg-1 col-md-2 col-sm-2 col-xs-3">
        					<text>Nama 			  </text><br>
        					<text>No Induk	  </text><br>
        					<text>Seksi 		  </text><br>
        					<text>Unit			  </text><br>
        					<text>Departemen  </text>
        				</div>
        				<div class="col-lg-11 col-md-10 col-sm-10 col-xs-9">
        					<?php foreach ($Info as $key): ?>
        						<text>: <?=$key['nama']?>    </text> <br>
        						<text>: <?=$key['noind']?>   </text><br>
        						<text>: <?=$key['seksi']?>   </text><br>
        						<text>: <?=$key['unit']?>    </text><br>
        						<text>: <?=$key['dept']?>    </text>
        					<?php endforeach; ?>
        				</div>
        			</div>
        		</div>
          </div>
        </div>
    	</div>
  	</div>
    <div class="row">
      <div class="box box-danger box-solid">
        <div class="box-header with-border">
           <h4><strong>Cuti di Tolak <i class="fa fa-close"></i></strong></h4>
        </div>
        <div class="box-body">
          <div class="table-responsive">
            <table class="table table-bordered text-left datatable-cuti" style="font-size:12px; width: 100%">
              <thead>
                <tr class="bg-primary">
                  <th class="text-center" style="width:5%;">No</th>
                  <th class="text-center" style="width:10%;">Tanggal Pengajuan</th>
                  <!-- <th class="text-center">Id Cuti</th> -->
                  <th class="text-center">Noind</th>
                  <th class="text-center">Nama</th>
                  <th class="text-center">Tipe Cuti</th>
                  <th class="text-center">Jenis Cuti</th>
                  <th class="text-center">Alasan</th>
                  <th class="text-center">Keterangan</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  $no = 1;
                  foreach ($Rejected as $key) {
                    $encrypted_string = $this->encrypt->encode($key['id_cuti']);
                    $encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
                    $detail = base_url('PermohonanCuti/Approval/Rejected/Detail/'.$encrypted_string);
                    ?>
                    <tr>
                      <td class="text-center"><?php echo $no ?></td>
                      <td><?php echo date("d/m/Y",strtotime($key['tgl'])) ?></td>
                      <!-- <td><?php echo $key['id_cuti'] ?></td> -->
                      <td><?php echo $key['noind'] ?></td>
                      <td><?php echo $key['name'] ?></td>
                      <td><?php echo $key['tipe'] ?></td>
                      <td><?php echo $key['jenis_cuti']?></td>
                      <td><?php echo $key['alasan']?></td>
                      <td class="text-center"><a class="btn btn-info btn-sm" href="<?php echo $detail ?>"><span class="fa fa-info" title="Detail">Detail</span></a></td>
                    </tr>
                  <?php $no++; } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
