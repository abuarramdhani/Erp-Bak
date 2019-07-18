<section class="content">
    <div class="inner" >
        <div class="row">
            <form method="post" class="form-horizontal" action="<?php echo site_url('p2k3adm_V2/datamasuk/ApproveTIM');?>" enctype="multipart/form-data">
                <div class="col-lg-12">
                    <div class="col-lg-11">
                        <div class="text-right">
                            <h1><b>Approve Standar</b></h1>
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
                                <div class="box-header with-border">Approval</div>
                                <div class="box-body">
                                    <div class="panel-body" style="overflow-x: scroll;">
                                        <table id="tb_InputKebutuhanAPD" class="table table-striped table-bordered table-hover text-center">
                                            <caption style="color: #000; font-weight: bold;"><?php echo $seksi[0]['section_name']; ?></caption>
                                            <thead>
                                                <tr class="bg-info">
                                                    <th><input type="checkbox" class="p2k3_chkAll"></th>
                                                    <th>No</th>
                                                    <th style="min-width: 200px;">Nama APD</th>
                                                    <th>Kode Barang</th>
                                                    <th>Kebutuhan Umum</th>
                                                    <th>Staff</th>
                                                    <?php foreach ($daftar_pekerjaan as $key) { ?>
                                                    <th><?php echo $key['pekerjaan'];?></th>
                                                    <?php } ?>
                                                </tr>
                                            </thead>
                                            <tbody id="DetailInputKebutuhanAPD">
                                                <?php $a=1; foreach ($listToApprove as $key) { ?>
                                                <tr style="color: #000;">
                                                    <td id="nomor"><input type="checkbox" class="p2k3_chk" name="id[]" value="<?php echo $key['id']; ?>"></td>
                                                    <td id="nomor"><?php echo $a; ?></td>
                                                    <td><?php echo $key['item']; ?></td>
                                                    <td><?php echo $key['kode_item']; ?></td>
                                                    <td><?php echo $key['jml_kebutuhan_umum']; ?></td>
                                                    <td><?php echo $key['jml_kebutuhan_staff']; ?></td>
                                                    <?php $jml = explode(',', $key['jml_item']);
                                                    foreach ($jml as $row) { ?>
                                                    <td><?php echo $row; ?></td>
                                                    <?php  } ?>
                                                    <!-- <input name="id[]" hidden value="<?php echo $key['id']; ?>"> -->
                                                </tr>
                                                <?php $a++; } ?>
                                            </tbody>
                                        </table>
                                        <div class="panel-footer">
                                            <div class="row text-right" style="margin-right: 12px">
                                                <button onclick="return confirm('Apa anda yakin ingin Reject Data ini?')" class="btn btn-danger" type="submit" name="p2k3_action" value="reject">Reject</button>
                                                <button onclick="return confirm('Apa anda yakin ingin Approve Data ini?')" class="btn btn-success" type="submit" name="p2k3_action" value="approve">Approve</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>