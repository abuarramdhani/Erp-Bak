<div class="content">
  <div class="row">
    <div class="col-lg-12">
      <div class="box box-primary box-solid">
        <div class="box-header with-border">
          <div class="row">
            <div class="col-md-4">
              <a class="btn btn-success" style="margin-top:2px;" target="_blank" href="<?php echo base_url('OrderPrototypePPIC/OrderIn/Create')?>"><i class="fa fa-plus-square"></i> Tambah</a>
            </div>
            <div class="col-md-4">
              <center><h4 style="font-weight:bold;"><i class="fa fa-cloud-upload"></i> Order Masuk Prototype</h4></center>
            </div>
            <div class="col-md-4">

            </div>
          </div>
        </div>
        <div class="box-body" style="background:#f0f0f0 !important;">
          <div class="row">
            <div class="col-md-12" style="margin-top:10px">
              <div class="box-body" style="background:#ffffff !important; border-radius:7px;margin-bottom:15px;">
                <div class="table-responsive">
                  <table class="table table-striped table-bordered table-hover text-left orderInOpp" style="font-size:11px;">
                    <thead>
                      <tr class="bg-primary">
                        <th class="text-center">NO</th>
                        <th class="text-center">KODE KOMPONEN</th>
                        <th class="text-center">TANGGAL INPUT</th>
                        <th class="text-center">NO ORDER</th>
                        <th class="text-center">QTY/ UNIT</th>
                        <th class="text-center">NEED</th>
                        <th class="text-center">PIC</th>
                        <th class="text-center">SEKSI</th>
                        <th class="text-center">PROSES</th>
                        <th class="text-center">ORDER</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($get as $key => $g): ?>
                        <tr row-id="<?php echo $key+1 ?>">
                          <td class="text-center"><?php echo $key+1 ?></td>
                          <td class="text-center"><?php echo $g['kode_komponen'] ?></td>
                          <td class="text-center"><?php echo  date("d-M-Y", strtotime(substr($g['created_date'], 0, 10)));  ?></td>
                          <td class="text-center"><?php echo $g['no_order'] ?></td>
                          <td class="text-center"><?php echo $g['qty'] ?></td>
                          <td class="text-center"><?php echo $g['need'] ?></td>
                          <td class="text-center"><?php echo $g['pic_pengorder'] ?></td>
                          <td class="text-center"><?php echo $g['seksi_pengorder'] ?></td>
                          <td class="text-center"> <button type="button" class="btn btn-success" name="button" onclick="opp_detail_proses('<?php echo $g['id'] ?>', '<?php echo $g['kode_komponen'] ?>')" data-toggle="modal" data-target="#opp_modaldetail"><i class="fa fa-question-circle"></i> Detail</button> </td>
                          <td class="text-center"> <button type="button" class="btn btn-primary" name="button" onclick="opp_in_detail('<?php echo $key+1 ?>',
                                                                                                                                      '<?php echo $g['material'] ?>',
                                                                                                                                      '<?php echo $g['dimensi_pot_t'] ?>',
                                                                                                                                      '<?php echo $g['dimensi_pot_p'] ?>',
                                                                                                                                      '<?php echo $g['dimensi_pot_l'] ?>',
                                                                                                                                      '<?php echo $g['gol'] ?>',
                                                                                                                                      '<?php echo $g['jenis'] ?>',
                                                                                                                                      '<?php echo $g['p_a'] ?>',
                                                                                                                                      '<?php echo $g['upper_level'] ?>',
                                                                                                                                      '<?php echo $g['cek_kode'] ?>',
                                                                                                                                      '<?php echo $g['cek_mon'] ?>',
                                                                                                                                      '<?php echo $g['cek_nama'] ?>',
                                                                                                                                      '<?php echo $g['produk'] ?>',
                                                                                                                                      '<?php echo $g['project'] ?>')"><i class="fa fa-question-circle"></i> Detail</button> </td>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade bd-example-modal-md" id="opp_modaldetail" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content" style="border-radius: 5px !important; background-color:transparent !important; box-shadow:none;">
      <div class="panel-body">
        <div class="row">
          <div class="col-lg-12">
            <div class="box box-success box-solid">
              <div class="box-header with-border">
                <div style="float:left">
                  <h4 style="font-weight:bold;">Detail Proses (<span id="detail_proses_opp"></span>) </h4>
                </div>
                <button type="button" class="btn btn-danger" style="float:right;font-weight:bold;float:right" data-dismiss="modal"> <i class="fa fa-close"></i> Tutup</button>
              </div>
              <div class="box-body">
                <div class="row">
                  <div class="col-md-12" style="margin-top:5px">
                    <!-- <button type="button" class="btn btn-success" name="button-done-jti-pembelian" style="font-weight:bold;margin-right:5px !important;text-align:center;float:right" onclick="donejti()" ><i class="fa fa-Done"> </i> Selesai</button> -->
                    <div class="area-proses-opp">

                    </div>
                  </div>
                </div>
              </div>
            </div>
      		</div>
      	</div>
      </div>
    </div>
  </div>
</div>
