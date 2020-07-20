<div class="content">
  <div class="row">
    <div class="col-lg-12">
      <div class="box box-primary box-solid">
        <div class="box-header with-border">
          <h4 style="font-weight:bold;"><i class="fa fa-newspaper-o"></i> Approval Pengiriman Barang Internal</h4>
        </div>
        <div class="box-body">
          <p><b>NB </b> : Proses approval berada didalam detail item FPB</p>
          <div class="table-responsive" style="margin-top:30px;">
            <table class="table table-striped table-bordered table-hover text-left " id="tblpbiApproval" style="font-size:12px;">
              <thead>
                <tr class="bg-success">
                  <th><center>No</center></th>
                  <th><center>Dokumen Number</center></th>
                  <th><center>Penerima</center></th>
                  <th><center>Seksi Penerima</center></th>
                  <th><center>Tujuan</center></th>
                  <th><center>Tanggal Input</center></th>
                  <th><center>No Transfer Asset</center></th>
                  <th><center>Status Approval</center></th>
                  <th><center>Detail</center></th>
                </tr>
              </thead>
              <tbody>
                <?php $no = 1; foreach ($get as $key => $g): ?>
                  <tr row-pbi="<?php echo $key+1 ?>">
                    <td><center><?php echo $no; ?></center></td>
                    <td><center><?php echo $g['DOC_NUMBER'] ?></center></td>
                    <td><center><?php echo $g['USER_TUJUAN'] ?></center></td>
                    <td><center><?php echo $g['SEKSI_TUJUAN'] ?></center></td>
                    <td><center><?php echo $g['TUJUAN'] ?></center></td>
                    <td><center><?php echo date('d-M-Y H:i:s',strtotime($g['CREATION_DATE'])) ?></center></td>
                    <td><center><?php echo $g['NO_TRANSFER_ASET'] ?></center></td>
                    <td><center class="status_area_pbi_<?php echo $g['DOC_NUMBER'] ?>">
                      <?php
                        if ($g['FLAG_APPROVE_ASET'] == 'N') {
                          echo '<span class="label label-default" style="font-size:12px;">Pending</span>';
                        }elseif ($g['FLAG_APPROVE_ASET'] == 'R') {
                          echo '<span class="label label-danger" style="font-size:12px;">Rejected &nbsp;<b class="fa fa-times-circle"></b></span>';
                        }else{
                          echo '<span class="label label-success" style="font-size:12px;">Approved &nbsp;<b class="fa fa-check-circle"></b></span>';
                        }
                      ?>
                       </center></td>
                    <td>
                      <center>
                        <button type="button" class="btn btn-sm btn-primary" style="font-weight:bold;" name="button" onclick="detailItemApproval('<?php echo $g['DOC_NUMBER'] ?>', <?php echo $key+1 ?>)">
                          <b class="fa fa-eye"></b>
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
