<style>
  .dataTables_filter{
    float: right;
  }
  .dataTables_info{
    float: left;
  }
  .dataTables_length{
    float: left;
  }
  .dataTables_info{
    margin-left: 20%;
  }
  .buttons-excel{
    font-weight: bold;
    background-color: #55b055;
    color: #fff;
  }
</style>
<section class="content">
  <div class="box box-default color-palette-box">
    <div class="box-body">
      <section class="content">
        <div class="row">
          <div class="col-xs-12"> <h3 id="delet_this">Please Wait ...</h3>
            <div id="show_me_the_money" class="table-responsive" hidden="">
              <table class="table" id="tbl_sweeping" style="width: 100%; font-size: 12px;">
                <thead>
                  <tr class="bg-primary">
                    <th class="text-center">No</th>
                    <th class="text-center">No Asset</th>
                    <th class="text-center">No Induk</th>
                    <th class="text-center">Nama</th>
                    <th class="text-center">Seksi</th>
                    <th class="text-center">IP Address</th>
                    <th class="text-center">Sistem Operasi</th>
                    <th class="text-center">Windows Key</th>
                    <th class="text-center">Tanggal Input</th>
                    <th class="text-center">Verifikasi</th>
                    <th class="text-center" style="width: 55px;">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $petugas = $user; ?>
                  <?php $no = 0; foreach ($listdata as $key => $data):; $no++ ?>
                  <tr class="data-row text-center">
                    <td class="text-center"><?php echo $no; ?></td>
                    <td><?php echo $data['no_asset']?></td>
                    <td><?php echo $data['no_ind']?></td>
                    <td><?php echo $data['nama']?></td>
                    <td><?php echo $data['seksi']?></td>
                    <td><?php echo $data['ip_address']?></td>
                    <td><?php echo $data['sistem_operasi']?></td>
                    <td><?php echo $data['windows_key']?></td>
                    <?php $data['tgl_input'] = substr($data['tgl_input'], 0,19);?>
                    <td><?php echo $data['tgl_input']?></td>
                    <td data-order="<?= ($data['remark'] == 1) ? 1:0 ?>">
                      <?php if ($data['remark'] == 1): ?>
                        <label style="color: #55b055"><i data-or class="fa fa-check fa-2x" title="Sudah di Verifikasi"></i></label>
                        <p hidden="">Sudah</p>
                      <?php else: ?>
                        <i data-or class="fa fa-remove fa-2x" title="Belum di Verifikasi"></i>
                        <p hidden="">Belum</p>
                      <?php endif ?>
                    </td>
                    <td>
                      <a target="_blank" href="<?= base_url('hardware/view-data/viewDetailData/'.$data['check_id']); ?>" class="btn btn-xs btn-success" title="view data"><i class="fa fa-eye"></i></a>
                      <a href="<?= base_url('hardware/view-data/editData/'.$data['check_id']); ?>" class="btn btn-xs btn-primary" title="edit data"><i class="fa fa-edit"></i></a>
                      <a href="<?= base_url('hardware/view-data/deleteKey/'.$data['check_id']); ?>" class="btn btn-xs btn-danger" title="hapus data" onclick="if (! confirm('Yakin Mas Mau Hapus Key???')) { return false; }"><i class="fa fa-remove"></i></a>
                    </td>
                  </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
</section>
<script>
  window.addEventListener('load', function () {
    $('#show_me_the_money').show();
    $('#delet_this').remove();
    <?php if ($this->session->userdata('saved_hardware')): ?>
    notif_save_hardware('edit');
   <?php endif ?>
  });
</script>