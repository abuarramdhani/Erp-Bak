<section class="content">
    <div class="inner" >
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-3">
                        </div>
                        <div class="col-lg-3"></div>
                        <div class="col-lg-5">
                            <div class="text-right"><h1><b>Laporan Kunjungan</b></h1></div>
                        </div>
                        <div class="col-lg-1">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <!-- Ganti yang di dalam site url dengan alamat main menu yang diinginkan -->
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('MasterPekerja/LaporanKunjungan/addLaporanKunjungan');?>">
                                    <i class="icon-wrench icon-2x"></i>
                                    <br/>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <br/>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">
                                <a href="<?php echo site_url('MasterPekerja/LaporanKunjungan/addLaporanKunjungan') ?>" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Add New" title="Add New" >
                                    <button type="button" class="btn btn-default btn-sm"><i class="icon-plus icon-2x"></i></button>
                                </a>
                            </div>
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover text-left" id="tbl_lapkun" style="font-size:12px;">
                                        <thead class="bg-primary">
                                            <tr>
                                                <th style="text-align:center;">No</th>
                                                <th style="text-align:center;" data-sortable="false">Action</th>
                                                <th style="text-align:center;">Tanggal Pembuatan</th>
                                                <th style="text-align:center;">Nomor Surat</th>
                                                <th style="text-align:center;">Nomor Induk</th>
                                                <th style="text-align:center;">Nama</th>
                                                <th style="text-align:center;">Seksi</th>
                                                <th style="text-align:center;">Pembuat / Petugas</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no=0;
                                            foreach ($lapkun as $key => $value):
                                                $no++;
                                            ?>
                                            <tr>
                                                <td><?= $no; ?></td>
                                                <td style="text-align: center;">
                                                <a target="_blank" style="margin-right:4px" href="<?php echo base_url('MasterPekerja/LaporanKunjungan/cetakPDF/'.$value['id_laporan'].''); ?>" data-toggle="tooltip" data-placement="bottom" title="Preview Cetak"><span class="fa fa-file-pdf-o fa-2x"></span></a>

                                                <a style="margin-right:4px" href="<?php echo base_url('MasterPekerja/LaporanKunjungan/editLaporan/'.$value['id_laporan'].''); ?>" data-toggle="tooltip" data-placement="bottom" title="Edit Laporan"><span class="fa fa-edit fa-2x"></span></a>

                                                <a class="a_hapus" data-id="<?=$value['id_laporan']?>" style="margin-right:4px" data-toggle="tooltip" data-placement="bottom" title="Hapus Laporan"><span class="fa fa-times fa-2x"></span></a>


                                                </td>


                                                <td style="text-align: center;"><?= date('d F Y',strtotime($value['tanggal_laporan'])); ?></td>
                                                <td style="text-align: center;"><?= $value['no_surat']; ?></td>
                                                <td style="text-align: center;"><?= $value['noinduk_pekerja']; ?></td>
                                                <td><?= $value['nama_pekerja']; ?></td>
                                                <td><?= $value['seksi_pekerja']; ?></td>
                                                <td><?= $value['petugas']; ?></td>
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
</section>

<!-- Modal -->
<div id="excelModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Rekap Data</h4>
      </div>
      <div class="modal-body">
      <form method="get" action="<?php echo base_url('MasterPekerja/LaporanKunjungan/cetakExcel'); ?>">
      <div class="form-group">
          <label for="dateFilter">Periode</label>
          <input id="dateFilter" type="text" name="periode" value="" class="form-control" />
      </div>
      </div>
      <div class="modal-footer">
      <button type="submit" class="btn btn-success">Submit</button>
      </form>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<script type="text/javascript">
$(document).ready(function(){

  $('#tbl_lapkun').on('click','.a_hapus',function(e){
    e.preventDefault();
    var id_laporan = $(this).attr('data-id');
    var status     = confirm('Yakin Ingin Menghapus?');
    if(status){
     $.ajax({
      url: '<?php echo base_url(); ?>MasterPekerja/LaporanKunjungan/hapusLaporan',
      type: 'POST',
      data: {id_laporan:id_laporan},
      success: function(e){
        Swal.fire({
          icon: 'success',
          title: 'Sukses',
          text: 'Berhasil Menghapus Data!',
          confirmButtonColor: '#3085d6',
          confirmButtonText: 'Ok'
        }).then((result) => {
          if (result.value) {
            location.reload();
          }
        })
      }
    })
    }


  })

}) //end-script

</script>
