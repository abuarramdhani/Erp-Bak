<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <form action="<?= base_url('PerhitunganBiayaImpor/Laporan/search');?>" method="post">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title"><b>Data History</b> Laporan Perhitungan Biaya Impor</h3>
                    </div>
                    <div class="box-body">
                        <!-- <div>
                            <select class="form-control slcHistoryPBI" style="width:300px;" name="reqid">
                                <option></option>
                                <?php foreach ($dataHistory as $key => $history) { ?>
                                    <option value="<?= $history['REQUEST_ID'];?>"><?= $history['REQUEST_ID'];?></option>
                                <?php } ?>
                            </select>
                            <button type="submit" class="btn btn-success">Show</button>
                        </div><br> -->
                        <div>
                            <table class="table table-hover table-striped" id="tblHistoryPBI">
                                <thead>
                                    <tr class="bg-primary">
                                        <th>No urut perhitungan</th>
                                        <th>Tahun</th>
                                        <th>Vendor</th>
                                        <th>No BL</th>
                                        <th>No PO</th>
                                        <th>Tanggal Perhitungan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($dataHistory as $key => $history) {?>
                                        <tr>
                                            <td><?= $history['NO_URUT_PERHITUNGAN'];?></td>
                                            <td></td>
                                            <td><?= $history['VENDOR_NAME'];?></td>
                                            <td><a href="<?= base_url('PerhitunganBiayaImpor/Laporan/Perhitungan/'.$history['REQUEST_ID']) ;?>" target="_blank"><?= $history['NO_BL'];?></a></td>
                                            <td><?= $history['NO_PO'];?></td>
                                            <td></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>