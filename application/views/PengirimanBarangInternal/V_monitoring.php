<div class="content">
  <div class="row">
    <div class="col-lg-12">
      <div class="box box-primary box-solid">
        <div class="box-header with-border">
          <h4 style="font-weight:bold;"><i class="fa fa-newspaper-o"></i> Tabel Monitoring Pengiriman Barang Internal</h4>
        </div>
        <div class="box-body">
          <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover text-left " id="tblpbi" style="font-size:12px;">
              <thead>
                <tr class="bg-success">
                  <th><center>NO</center></th>
                  <th><center>Dokumen Number</center></th>
                  <th><center>User Tujuan</center></th>
                  <th><center>Seksi Tujuan</center></th>
                  <th><center>Tujuan</center></th>
                  <th><center>Status</center></th>
                  <th><center>Detail</center></th>
                </tr>
              </thead>
              <tbody>
                <?php $no = 1; foreach ($get as $key => $g): ?>
                  <tr>
                    <td><center><?php echo $no; ?></center></td>
                    <td><center><?php echo $g['DOC_NUMBER'] ?></center></td>
                    <td><center><?php echo $g['USER_TUJUAN'] ?></center></td>
                    <td><center><?php echo $seksi_tujuan[$key] ?></center></td>
                    <td><center><?php echo $g['TUJUAN'] ?></center></td>
                    <td><center><?php echo $g['STATUS2'] ?></center></td>
                    <td>
                      <center>
                        <a href="<?php echo base_url('PengirimanBarangInternal/Cetak/'.$g['DOC_NUMBER']) ?>" target="_blank" class="btn btn-danger"><i class="fa fa-file-pdf-o"></i></a>
                        <button type="button" class="btn btn-success" style="margin-left:5px;" name="button" style="font-weight:bold;" onclick="detailPBI('<?php echo $g['DOC_NUMBER'] ?>')" data-toggle="modal" data-target="#Mpbi">
                          <i class="fa fa-eye"></i>
                        </button>
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
