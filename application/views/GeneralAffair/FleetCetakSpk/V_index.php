<!-- <style media="screen">
  #pdf:hover{
    background-color: red;
  }
  #excel:hover{
    background-color: green;
  }
</style> -->
<section class="content">
  <div class="inner">
    <div class="row">
      <div class="col-lg-12">
        <div class="row">
          <div class="col-lg-12">
            <div class="col-lg-11">
              <div class="text-right">
                <h1><b><?= $Title ?></b></h1>
              </div>
            </div>
            <div class="col-lg-1">
              <div class="text-right hidden-md hidden-sm hidden-xs">
                <a class="btn btn-default btn-lg" href="<?php echo site_url('GeneralAffair/FleetCetakSpk');?>">
                  <i class="icon-wrench icon-2x"></i>
                  <br />
                </a>
              </div>
            </div>
          </div>
        </div>
        <br />

        <div class="row">
          <div class="col-lg-12">
            <div class="box box-primary box-solid">
              <div class="box-header with-border">
                <a href="<?php echo site_url('GeneralAffair/FleetCetakSpk/create/') ?>" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Add New" title="Add New">
                  <button type="button" class="btn btn-default btn-sm"><i class="icon-plus icon-2x"></i></button>
                </a>
              </div>
              <div class="box-body">
                <div>
                  <table class="table-striped table-bordered table-hover text-left" id="data_table_excel" style="font-size:12px;">
                    <thead class="bg-primary">
                      <tr>
                        <th style="text-align:center; width:30px">No</th>
                        <th style="text-align:center; min-width:80px">Action</th>
                        <th>No Kendaraan</th>
                        <th>Lokasi Kerja</th>
                        <th>Tanggal Maintenance</th>
                        <th>Maintenance Kategori</th>
                        <th>Jenis Maintenance</th>
                        <th>Nama Bengkel</th>
                        <th style="text-align:center;">No Surat</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                                            	$no = count($FleetCetakSpk);
                                            	foreach($FleetCetakSpk as $row):
                                            	$encrypted_string = $this->encrypt->encode($row['surat_id']);
												$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
											?>
                      <tr>
                        <td align='center'><?php echo $no--;?></td>
                        <td align='center'>
                          <a style="margin-right:4px" href="<?php echo base_url('GeneralAffair/FleetCetakSpk/read/'.$encrypted_string.''); ?>" data-toggle="tooltip" data-placement="bottom" title="Read Data"><span
                              class="fa fa-list-alt fa-2x"></span></a>
                          <a style="margin-right:4px" href="<?php echo base_url('GeneralAffair/FleetCetakSpk/update/'.$encrypted_string.''); ?>" data-toggle="tooltip" data-placement="bottom" title="Edit Data"><span
                              class="fa fa-pencil-square-o fa-2x"></span></a>
                          <a href="<?php echo base_url('GeneralAffair/FleetCetakSpk/delete/'.$encrypted_string.''); ?>" data-toggle="tooltip" data-placement="bottom" title="Hapus Data"
                            onclick="return confirm('Are you sure you want to delete this item?');"><span class="fa fa-trash fa-2x"></span></a>
                          <a href="<?php echo base_url('GeneralAffair/FleetCetakSpk/cetakFleetSPK/'.$encrypted_string.''); ?>" data-toggle="tooltip" data-placement="bottom" title="Cetak Pdf" target="_blank" id="pdf"><span
                              class="fa fa-file-pdf-o fa-2x"></span></a>
                        </td>
                        <td><?php echo $row['no_pol'] ?></td>
                        <td><?php echo $row['lokasi'] ?></td>
                        <td data-order="<?= date('Y-m-d', strtotime($row['tanggal_maintenance']))?>"><?php echo date('d-m-Y H:i:s', strtotime($row['tanggal_maintenance'])) ?></td>
                        <td><?php echo $row['maintenance_kategori'] ?></td>
                        <td><?= strtoupper($row['jenis_mtc'])  ?></td>
                        <td><?php echo $row['nama_bengkel'] ?></td>
                        <td align="center"><?php echo $row['no_surat'] ?></td>
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
<script type="text/javascript">
//TABLE Spk
$(document).ready(function(){
  $("#data_table_excel").DataTable({
    "lengthChange": true,
    "order": [[ 4, "desc" ]],
    dom: 'Bfrtip',
    buttons: [
    		{
          extend: 'excelHtml5',
          messageTop: 'Fleet Cetak Spk',
          filename: 'fleet_cetak_spk_'+ '<?=$today;?>',
          title: '',
          className: 'btn btn-success',
          text: '<i class="fa fa-file-excel-o"> Export<i>',
          exportOptions: {
                    columns: [ 0, 2, 3, 4, 5, 6, 7, 8 ],
                }
        }
    ]
  });
  $('div.dt-buttons > button').removeClass('btn-default');
  $('div.dt-buttons').appendTo('#data_table_excel_filter').css('float','left');
})
</script>
