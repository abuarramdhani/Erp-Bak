<style media="screen">
  body{
    padding-right: 0 !important;
  }
</style>
<div class="content" style="max-width:100%;">
  <div class="row">
    <div class="col-lg-12">
      <div class="box box-primary box-solid">
        <div class="box-header with-border">
          <div class="row">
            <div class="col-md-4">
              <a class="btn btn-success" style="margin-top:2px;font-weight:bold;" target="_blank" href="<?php echo base_url('OrderPrototypePPIC/OrderIn/Create')?>"><i class="fa fa-plus-square"></i> Input Order Masuk PPIC Prototype</a>
            </div>
            <div class="col-md-4">
              <center><h4 style="font-weight:bold;"><i class="fa fa-cloud-upload"></i> Order Masuk Prototype</h4></center>
            </div>
            <div class="col-md-4">
              <button type="button"  data-toggle="modal" data-target="#opp_modal_set_order_out" onclick="opp_add_to_order_out()" class="btn btn-success" style="float: right;padding:5px 7px;font-weight:bold;" name="button">
                <i class="fa fa-shopping-cart"></i> Order Out (<span id="jumlahitem_opp">0</span>)
              </button>
            </div>
          </div>
        </div>
        <div class="box-body" style="background:#f0f0f0;">
          <div class="row">
            <div class="col-md-12" style="margin-top:10px">
              <div class="box-body" style="background:#ffffff; border-radius:7px;margin-bottom:15px;">
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
                          <td class="text-center"><?php echo date("d-M-Y", strtotime(substr($g['created_date'], 0, 10))); ?></td>
                          <td class="text-center"><?php echo $g['no_order'] ?></td>
                          <td class="text-center"><?php echo $g['qty'] ?></td>
                          <td class="text-center"><?php echo $g['need'] ?></td>
                          <td class="text-center"><?php echo $g['pic_pengorder'] ?></td>
                          <td class="text-center"><?php echo $g['seksi_pengorder'] ?></td>
                          <td class="text-center">
                            <button type="button" class="btn btn-success" name="button" onclick="opp_detail_proses('<?php echo $g['id'] ?>', '<?php echo $g['kode_komponen'] ?>', <?php echo $key+1 ?>)" data-toggle="modal" data-target="#opp_modaldetail"><i class="fa fa-question-circle"></i> Select</button>
                          </td>
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
                <textarea hidden id="opp_keranjang" rows="8" cols="80"></textarea>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade bd-example-modal-md" id="opp_modal_set_order_out" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content" style="border-radius: 5px !important; background-color:transparent !important; box-shadow:none;">
      <div class="panel-body">
        <div class="row">
          <div class="col-lg-12">
            <div class="box box-success box-solid">
              <div class="box-header with-border">
                <div style="float:left">
                  <h4 style="font-weight:bold;">Setting Order Keluar Prototype </h4>
                </div>
                <button type="button" class="btn btn-danger" style="float:right;font-weight:bold;float:right" data-dismiss="modal"> <i class="fa fa-close"></i> Tutup</button>
              </div>
              <div class="box-body">
                <div class="row">
                  <div class="col-md-12" style="margin-top:5px">
                    <b>Penerima Order</b>
                    <b style="float:right">No Order Out: <span id="opp_next_no_order_out"></span> </b>
                    <hr style="padding:0 !important">
                    <table style="width:100%">
                      <tr>
                        <td style="width:5%;">Seksi</td>
                        <td style="width:2%;text-align:left;">:</td>
                        <td style="width:67%;" id="seksi_penerima"></td>
                      </tr>
                      <tr>
                        <td>Unit</td>
                        <td>:</td>
                        <td id="opp_unit"></td>
                      </tr>
                      <tr>
                        <td>Departemen</td>
                        <td>:</td>
                        <td id="opp_dept"></td>
                      </tr>
                    </table>
                    <br>
                    <b>Komponen Item</b>
                    <hr style="padding:0 !important">
                    <div class="table-responsive">
                      <table class="table table-striped table-bordered table-hover text-left" style="font-size:11px;">
                        <thead class="bg-success">
                          <tr>
                            <th style="text-align:center">No</th>
                            <th>Jenis Order</th>
                            <th>Qty</th>
                            <!-- <th>Satuan</th> -->
                            <th>Kode Komponen</th>
                            <th>Proses</th>
                          </tr>
                        </thead>
                        <tbody id="opp_order_out_tampung">

                        </tbody>
                      </table>
                      <center class="opp_area_loading"></center>
                    </div>
                    <br>
                    <center><button type="button" name="button" onclick="oppSaveOrderOut()" style="width:30%;margin-bottom:10px" class="btn btn-success opp_save_order_out"> <b class="fa fa-floppy-o"></b> <b>Save</b> </button></center>
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


<div class="modal fade bd-example-modal-md" id="opp_modaldetail" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content" style="border-radius: 5px !important; background-color:transparent !important; box-shadow:none;">
      <div class="panel-body">
        <div class="row">
          <div class="col-lg-12">
            <div class="box box-success box-solid">
              <div class="box-header with-border">
                <div style="float:left">
                  <h4 style="font-weight:bold;">Detail Proses (<span id="detail_proses_opp"></span>)</h4>
                  <input type="hidden" class="opp_get_param" value="">
                </div>
                <button type="button" class="btn btn-danger" style="float:right;font-weight:bold" data-dismiss="modal"> <i class="fa fa-close"></i> </button>
                <button type="button" class="btn btn-default" onclick="opp_modal_edit()" style="font-weight:bold;float:right;margin-right:13px;" name="button"> <i class="fa fa-edit"></i> <u>Edit</u></button>
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

<div class="modal fade bd-example-modal-md" id="opp_edit_proses" style="overflow-y:auto;" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document" >
		<div class="modal-content" style="border-radius: 5px !important; background-color:transparent !important; box-shadow:none;">
      <div class="panel-body">
        <div class="row">
          <div class="col-lg-12">
            <div class="box box-success box-solid">
              <div class="box-header with-border">
                <div style="float:left">
                  <h4 style="font-weight:bold;">Edit Proses (<span id="edit_proses_opp"></span>)</h4>
                </div>
                <button type="button" class="btn btn-default" onclick="opp_close_proses()" style="float:right;font-weight:bold" data-dismiss="modal"> <i class="fa fa-mail-reply"></i> Kembali</button>
              </div>
              <div class="box-body">
                <div class="row">
                  <div class="col-md-12" style="margin-top:5px">
                    <div class="area-edit-proses-opp">

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
