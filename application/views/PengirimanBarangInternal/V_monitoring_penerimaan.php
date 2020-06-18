<div class="content">
  <div class="row">
    <div class="col-lg-12">
      <div class="box box-primary box-solid">
        <div class="box-header with-border">
          <h4 style="font-weight:bold;"><i class="fa fa-newspaper-o"></i> Monitoring Penerimaan Barang Internal</h4>
        </div>
        <div class="box-body">
          <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover text-left " id="tblpbi" style="font-size:12px;">
              <thead>
                <tr class="bg-success">
                  <th><center>NO</center></th>
                  <th><center>Dokumen Number</center></th>
                  <th><center>Pengirim</center></th>
                  <th><center>Seksi Pengirim</center></th>
                  <th><center>Tujuan</center></th>
                  <th><center>Penerima</center></th>
                  <th><center>Tanggal Input</center></th>
                  <th><center>Status</center></th>
                  <th style="width:150px !important;"><center>Detail</center></th>
                </tr>
              </thead>
              <tbody>
                <?php $no = 1; foreach ($get as $key => $g): ?>
                  <tr row-id="<?php echo $no ?>">
                    <td><center><?php echo $no; ?></center></td>
                    <td><center><?php echo $g['DOC_NUMBER'] ?></center></td>
                    <td><center><?php echo $g['CREATED_BY'] ?></center></td>
                    <td><center><?php echo $g['SEKSI_KIRIM'] ?></center></td>
                    <td><center><?php echo $g['TUJUAN'] ?></center></td>
                    <td><center><?php echo $g['USER_TUJUAN'] ?></center></td>
                    <td><center><?php echo date('d-M-Y H:i:s',strtotime($g['CREATION_DATE'])) ?></center></td>
                    <td><center id="status"><?php echo $g['STATUS2'] ?></center></td>
                    <td>
                      <center>
                        <!-- <a href="<?php echo base_url('PengirimanBarangInternal/Cetak/'.$g['DOC_NUMBER']) ?>" target="_blank" class="btn btn-danger"><i class="fa fa-file-pdf-o"></i></a> -->
                        <button type="button" class="btn btn-success" style="margin-left:5px;" name="button" style="font-weight:bold;" onclick="detailPBI('<?php echo $g['DOC_NUMBER'] ?>')" data-toggle="modal" data-target="#Mpbi">
                          <i class="fa fa-eye"></i>
                        </button>
                        <?php if($g['STATUS'] == 5){ ?>
                          <button type="button" class="btn btn-primary" id="diterima" style="margin-left:5px;" style="font-weight:bold;" onclick="updatePBI('<?php echo $g['DOC_NUMBER'] ?>', '<?php echo $no ?>')">
                            <i class="fa fa-ship"></i> Diterima
                          </button>
                        <?php }else { ?>
                          <div class="btn bg-green" style="border-radius:5px;">
                            <i class="fa fa-check-square"></i> Done
                          </div>
                        <?php } ?>
                      </center>
                    </td>

                  </tr>
                <?php $no++; endforeach; ?>
              </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">

</script>
<div class="modal fade bd-example-modal-xl" id="Mpbi" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content" style="border-radius: 5px !important; background-color:transparent !important; box-shadow:none;">
      <div class="panel-body">
        <div class="row">
          <div class="col-lg-12">
            <div class="box box-primary box-solid">
              <div class="box-header with-border">
                <div style="float:left">
                  <h4 style="font-weight:bold;">DETAIL (<span id="nodoc"></span>) </h4>
                </div>
                <button type="button" class="btn btn-danger" style="float:right;font-weight:bold" data-dismiss="modal">Close</button>
              </div>
              <div class="box-body">
                <div class="table-responsive">
                  <center>
                    <div id="loading-pbi" style="display:none;">
                      <center><img style="width: 5%" src="<?php echo base_url('assets/img/gif/loading5.gif') ?>"></center>
                    </div>
                  </center>
                  <div id="table-pbi-area">

                  </div>
                </div>
                <!-- <center><button type="button" class="btn btn-success" name="button" id="rootbutton" onclick="rootsubmit()" style="font-weight:bold;display:none;margin-top:10px">ROOT APPROVE</button> -->
              </div>
            </div>
      		</div>
      	</div>
      </div>
    </div>
  </div>
</div>
