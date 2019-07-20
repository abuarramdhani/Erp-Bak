<section class="content">
    <div class="inner" >
        <div class="row">
            <div class="col-lg-12">
                <div class="col-lg-11">
                    <div class="text-right">
                        <h1><b>Edit Riwayat Kebutuhan Standar</b></h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-11"></div>
                        <div class="col-lg-1 "></div>
                    </div>
                </div>
                <br />
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border"></div>
                            <div class="box-body">
                                <div class="panel-body" style="overflow-x: scroll;">
                                 <div style="margin-top: 20px;" class="col-md-12 text-center">
                                    <h4 style="color: #000; font-weight: bold;">
                                        <?php  if (!empty($seksi) || !isset($seksi)) {
                                           echo $seksi[0]['section_name'];
                                       } ?>
                                   </h4>
                               </div>
                               <form method="post" action="<?php echo site_url('p2k3adm_V2/Admin/SaveEditRiwayatKebutuhan'); ?>">
                                   <table class="table table-striped table-bordered table-hover text-center" style="font-size:12px; overflow-x: scroll;">
                                    <thead class="bg-primary">
                                        <tr>
                                            <th>Nama APD</th>
                                            <th>Kode Barang</th>
                                            <th>Kebutuhan Umum</th>
                                            <th>STAFF</th>
                                            <?php foreach ($daftar_pekerjaan as $key) { ?>
                                            <th><?php echo $key['pekerjaan'];?></th>
                                            <?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $a=1; foreach ($inputStandar as $key) { 
                                            $status = $key['status'];
                                            if ($status == '0') {
                                                $status = 'Pending';
                                            }else if ($status == '1') {
                                                $status = 'Approved Atasan';
                                            }else if ($status == '2'){
                                                $status = 'Reject Atasan';
                                            }else if ($status == '3'){
                                                $status = 'Approved TIM';
                                            }else{
                                                $status = 'Reject TIM';
                                            }
                                            ?>
                                            <tr style="color: #000;">
                                                <td>
                                                    <select readonly class="form-control">
                                                        <option value="<?php echo $key['item']; ?>" selected><?php echo $key['item']; ?></option>
                                                    </select>
                                                </td>
                                                <td><input class="form-control" readonly="" value="<?php echo $key['kode_item']; ?>"></td>
                                                <td><input name="jmlUmum" type="number" min="0" class="form-control" value="<?php echo $key['jml_kebutuhan_umum']; ?>"></td>
                                                <td><input name="staffJumlah" type="number" min="0" class="form-control" value="<?php echo $key['jml_kebutuhan_staff']; ?>"></td>
                                                <?php $jml = explode(',', $key['jml_item']);
                                                foreach ($jml as $row) { ?>
                                                <td><input name="pkjJumlah[]" type="number" min="0" class="form-control" value="<?php echo $row; ?>"></td>
                                                <?php  } ?>
                                            </tr>
                                            <?php $a++; } ?>
                                        </tbody>
                                    </table>
                                    <input hidden="" value="<?php echo $id; ?>" name="id">
                                    <input hidden="" value="<?php echo $ks; ?>" name="ks">
                                    <div class="col-md-12 text-right">
                                        <button class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</section>