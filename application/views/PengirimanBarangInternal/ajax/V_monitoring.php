<div class="table-responsive" style="margin-top:30px;">
  <table class="table table-striped table-bordered table-hover text-left " id="tblpbi" style="font-size:12px;">
    <thead>
      <tr class="bg-success">
        <th><center>No</center></th>
        <th><center>Dokumen Number</center></th>
        <!-- <th><center>No MO</center></th> -->
        <th><center>Penerima</center></th>
        <th><center>Seksi Penerima</center></th>
        <th><center>Tujuan</center></th>
        <th><center>Tanggal Input</center></th>
        <th><center>Status</center></th>
        <th style="width: 9%"><center>Detail</center></th>
        <th style="width: 9%"><center>Aksi</center></th>
      </tr>
    </thead>
    <tbody>
      <?php $no = 1; foreach ($get as $key => $g): ?>
        <tr>
          <td><center><?php echo $no; ?></center></td>
          <td><center><?php echo $g['DOC_NUMBER'] ?></center></td>
          <!-- <td><center><?php echo empty($g['NO_MOVE_ORDER'])?'-':$g['NO_MOVE_ORDER'] ?></center></td> -->
          <td><center><?php echo $g['USER_TUJUAN'] ?></center></td>
          <td><center><?php echo $g['SEKSI_TUJUAN'] ?></center></td>
          <td><center><?php echo $g['TUJUAN'] ?></center></td>
          <td><center><?php echo date('d-M-Y H:i:s',strtotime($g['CREATION_DATE'])) ?></center></td>
          <td><center><?php echo $g['STATUS2'] ?></center></td>
          <td>
            <center>
              <a href="<?php echo base_url('PengirimanBarangInternal/Cetak/'.$g['DOC_NUMBER']) ?>" target="_blank" style="padding:5px 7px" class="btn btn-danger"><i class="fa fa-file-pdf-o"></i></a>
              <button type="button" class="btn btn-success" style="margin-left:1px;padding:5px 7px;font-weight:bold;" name="button" onclick="detailPBI('<?php echo $g['DOC_NUMBER'] ?>')" data-toggle="modal" data-target="#Mpbi">
                <i class="fa fa-eye"></i>
              </button>
            </center>
          </td>
          <!-- <?php echo $g['KETERANGAN'] ?> <?php echo $g['TYPE'] ?> -->
          <?php if (($g['TYPE'] == '3' && $g['FLAG_APPROVE_ASET'] == 'N' && $g['STATUS'] == '1') || ($g['TYPE'] == '2' && $g['STATUS'] == '1')) { ?>
            <td>
              <center>
                <button type="button" class="btn btn-primary" style="margin-left:1px;padding:5px 7px;font-weight:bold;" name="button" onclick="edit_pbi('<?php echo $g['DOC_NUMBER'] ?>', '<?php echo $g['KETERANGAN'] ?>', '<?php echo $g['USER_TUJUAN'] ?>', '<?php echo $g['SEKSI_TUJUAN'] ?>', '<?php echo $g['TYPE'] ?>', '<?php echo $g['NO_TRANSFER_ASET'] ?>')" data-toggle="modal" data-target="#edit_pbi">
                  <i class="fa fa-pencil"></i>
                </button>
                <button type="button" class="btn btn-danger" style="margin-left:1px;padding:5px 7px;font-weight:bold;" name="button" onclick="hapus_pbi('<?php echo $g['DOC_NUMBER'] ?>')">
                  <i class="fa fa-trash"></i>
                </button>
              </center>
            </td>
          <?php }else { ?>
            <td>
              <center>
                <button disabled type="button" class="btn btn-primary" style="margin-left:1px;padding:5px 7px;font-weight:bold;" name="button">
                  <i class="fa fa-pencil"></i>
                </button>
                <button disabled type="button" class="btn btn-danger" style="margin-left:1px;padding:5px 7px;font-weight:bold;" name="button">
                  <i class="fa fa-trash"></i>
                </button>
              </center>
            </td>
          <?php } ?>

        </tr>
      <?php $no++; endforeach; ?>
    </tr>
    </tbody>
  </table>
</div>

<script type="text/javascript">
$('#tblpbi').DataTable({
  "pageLength": 10,
});
</script>
