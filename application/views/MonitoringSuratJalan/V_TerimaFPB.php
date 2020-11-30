<style media="screen">
tr.disabled {
  background-color: rgba(161, 161, 161, 0.63) !important;
}
tr.disabled:hover {
  background-color: rgba(161, 161, 161, 0.63) !important;
}
::-webkit-scrollbar {
    width: 5px;
}
::-webkit-scrollbar-thumb {
    -webkit-border-radius: 7px;
    border-radius: 7px;
    background: rgba(192,192,192,0.3);
    -webkit-box-shadow: inset 0 0 6px rgba(49, 139, 233, 0.7);
}
</style>
<div class="content">
  <div class="row">
    <div class="col-lg-12">
      <div class="box box-primary box-solid">
        <div class="box-header with-border">
          <h4 style="font-weight:bold;"><i class="fa fa-cloud-upload"></i> Monitoring Surat Jalan (Terima FPB)</h4>
        </div>
        <div class="box-body">
          <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover text-left " id="tblmsj" style="font-size:12px;">
              <thead>
                <tr class="bg-info" data="msj_header">
                  <th><center>No</center></th>
                  <!-- <th class="checked_msj"><input type="checkbox" id="check-all-msj" onchange="checked_msj()"></th> -->
                  <th class="checked_msj" style="width: 5%"></th>
                  <th>Dokumen Number</th>
                  <th><center>Pengirim</center></th>
                  <th><center>Seksi Pengirim</center></th>
                  <th><center>Tujuan</center></th>
                  <th><center>Penerima</center></th>
                  <th><center>Tanggal</center></th>
                  <th><center>Detail</center></th>
                </tr>
              </thead>
              <tbody>
                <?php $no = 1; foreach ($get as $key => $g): ?>
                  <tr row-id="<?php echo $no ?>">
                    <td><?php echo $no; ?></td>
                    <td></td>
                    <td><?php echo $g['DOC_NUMBER'] ?></td>
                    <td><center><?php echo $g['CREATED_BY'] ?></center></td>
                    <td><center><?php echo $g['SEKSI_KIRIM'] ?></center></td>
                    <td><center><?php echo $g['TUJUAN'] ?></center></td>
                    <td><center><?php echo $g['USER_TUJUAN'] ?></center></td>
                    <td><center><?php echo date('d-M-Y H:i:s',strtotime($g['CREATION_DATE'])) ?></center></td>
                    <td>
                      <center>
                        <button type="button" class="btn bg-navy" style="margin-left:5px;" name="button" style="font-weight:bold;" onclick="detailMSJ('<?php echo $g['DOC_NUMBER'] ?>')" data-toggle="modal" data-target="#Mmsj">
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
          <center> <button type="button" class="btn btn-lg btn-primary" onclick="setMSJ2()" id="btnInputMSJ" disabled="disabled" name="button"><i class="fa fa-retweet"></i> <b>Terima</b></button> </center>
          <br>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade bd-example-modal-xl" id="Mmsj" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content" style="border-radius: 5px !important; background-color:transparent !important; box-shadow:none;">
      <div class="panel-body">
        <div class="row">
          <div class="col-lg-12">
            <div class="box box-primary box-solid">
              <div class="box-header with-border">
                <div style="float:left">
                  <h4 style="font-weight:bold;">DETAIL (<span id="nodoc_msj"></span>) </h4>
                </div>
                <button type="button" class="btn btn-danger" style="float:right;font-weight:bold" data-dismiss="modal">Close</button>
              </div>
              <div class="box-body">
                <div class="table-responsive">
                  <center>
                    <div id="loading-msj" style="display:none;">
                      <center><img style="width: 5%" src="<?php echo base_url('assets/img/gif/loading5.gif') ?>"></center>
                    </div>
                  </center>
                  <div id="table-msj-area">

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
