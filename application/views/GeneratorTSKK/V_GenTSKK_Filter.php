<div class="table-responsive" style="padding-top:13px;">
  <table class="datatable table table-striped table-bordered table-hover tabel_daftarTSKK_filter" id="tabel_daftarTSKK" style="width: 100%;">
    <thead class="bg-primary">
      <tr>
        <th width="5%" class="text-center">NO</th>
        <th class="text-center" style="display: none;">ID</th>
        <th width="15%" class="text-center">ACTION</th>
        <th width="15%" class="text-center">JUDUL</th>
        <th width="10%" class="text-center">PEMBUAT</th>
        <th width="10%" class="text-center">TANGGAL OBSERVASI</th>
        <th width="10%" class="text-center">TYPE</th>
        <th width="15%" class="text-center">NAMA PART</th>
        <th width="10%" class="text-center">SEKSI</th>
        <th width="10%" class="text-center">PROSES</th>
        <th style="display:none">ID</th>
      </tr>
    </thead>
    <tbody>

      <?php $no = 1; ?>

      <?php
        if (empty($lihat_header)) {
        }else{
          $no=1;
          foreach ($lihat_header as $key) {
            $id = $key['id_tskk'];
            $judul_tskk = $key['judul_tskk'];
            $tipe = $key['tipe'];
            $kode_part = $key['kode_part'];
            $nama_part = $key['nama_part'];
            $seksi = $key['seksi'];
            $proses = $key['proses'];
            $kode_proses = $key['kode_proses'];
            $mesin = $key['mesin'];
            $proses_ke = $key['proses_ke'];
            $proses_dari = $key['proses_dari'];
            $tanggal = $key['tanggal'];
            $newDate = date("d-M-Y", strtotime($tanggal));
            $qty = $key['qty'];
            $operator = $key['operator'];
            $pembuat = $key['nama_pembuat'];
            $status_observasi = $key['status_observasi'];
            $pembuat_ = explode(' - ', $pembuat);
      ?>
        <tr <?php echo $status_observasi == 'draft' ? 'style="background:#ffcccc"' : '' ?>>
          <td style="width: 5%; text-align:center;"><?php echo $no; ?></td>
          <td style="display: none;"></td>
          <?php if ($fun == 1){ ?>
            <td style="width: 20%; text-align:center;">
              <?php if ($pembuat_[0] == $this->session->user): ?>
                <a class="btn btn-warning btn-md" title="Edit Lembar Observasi" href="<?=base_url('GeneratorTSKK/C_GenTSKK/EditObservasi/'.$id)?>"><span class="fa fa-pencil-square-o"></span></a>
              <?php endif; ?>
            <a class="btn btn-info btn-md" title="Create TSKK" href="<?=base_url('GeneratorTSKK/C_GenTSKK/CreateBegin/'.$id)?>"><span class="fa fa-pencil-square-o"></span> </a>

            <?php if ($status_observasi == 'publish'){ ?>
              <a class="btn btn-success btn-md" title="Export Lembar Observasi" href="<?=base_url('GeneratorTSKK/C_Observation/exportObservation/'.$id)?>"><span class="fa fa-print"> </span></a>
            <?php } ?>

            <!-- <a class="btn btn-warning btn-md" title="Export TSKK" href="<?=base_url('GeneratorTSKK/C_Regenerate/exportAgain/'.$id)?>"><span class="fa fa-print"></span></a>                                        -->
            <?php if ($pembuat_[0] == $this->session->user): ?>
              <a class="btn btn-danger btn-md idViewLembarObservasi" at="<?php echo $id;?>" title="Delete Lembar Observasi" onclick="AreYouSureWantToDelete(<?= $id ?>)"><span class="fa fa-trash"></span></a>
            <?php endif; ?>
            <!-- href="<?=base_url('GeneratorTSKK/C_GenTSKK/deleteData/'.$id)?>" -->

            <?php if ($pembuat_[0] == $this->session->user): ?>
              <br>
              <a class="btn btn-primary btn-md mt-3" style="" title="Duplicate Lembar Observasi" href="<?=base_url('GeneratorTSKK/C_GenTSKK/save_as/'.$id)?>"><span class="fa fa-copy"></span> Duplicate</a>
            <?php endif; ?>
            </td>
          <?php }else{ ?>
            <td style="text-align:center; width:10%">
            <?php if ($pembuat_[0] == $this->session->user): ?>
              <!-- <a class="btn btn-warning btn-md" title="Edit TSKK" href="<? // ECHO base_url('GeneratorTSKK/C_GenTSKK/EditTSKK/'.$id)?>"><span class="fa fa-pencil-square-o"></span></a> -->
              <a class="btn btn-warning btn-md" title="Edit TSKK" href="<?=base_url('GeneratorTSKK/C_GenTSKK/CreateBegin/'.$id)?>"><span class="fa fa-pencil-square-o"></span></a>
            <?php endif; ?>
            <?php if ($status_observasi == 'publish'){ ?>
              <a class="btn btn-success btn-md" title="Export TSKK" href="<?=base_url('GeneratorTSKK/C_GenTSKK/exportExcel/'.$id)?>"><span class="fa fa-print"></span></a>
            <?php } ?>
            <!-- <a class="btn btn-danger btn-md" title="Delete TSKK" href="<?=base_url('GeneratorTSKK/C_GenTSKK/deleteData/'.$id)?>"><span class="fa fa-user-times"></span></a>  -->
            </td>
          <?php } ?>
          <td><?php echo $judul_tskk; ?></td>
          <td><?php echo $pembuat; ?></td>
          <td style="text-align:center;" data-order="<?php echo date("Ymd", strtotime($newDate)); ?>"><?php echo $newDate; ?></td>
          <td><?php echo $tipe; ?></td>
          <td><?php echo $nama_part; ?></td>
          <td><?php echo $seksi; ?></td>
          <td><?php echo $proses; ?></td>
          <td style="display:none"><input class="form-control idViewLembarObservasi" value="<?php echo $id;?>"></td>
        </tr>
        <?php
        $no++;
      }
    }
      ?>
    </tbody>
  </table>
</div>
<script type="text/javascript">
$('.tabel_daftarTSKK_filter').DataTable();
</script>
