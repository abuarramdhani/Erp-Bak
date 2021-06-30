<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title with-border">INPUT DPB SPAREPART</h3>
                </div>
                <form class="form-horizontal">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">No DO / SPB</label>

                            <div class="col-sm-10" style="display:inline-flex;">
                                <input type="text" class="form-control noDODSP" id="" placeholder="no DO / SPB" style="width:250px;">
                                <img class="loadingSearchDODSP" style="display:none" src="<?= base_url('assets/img/gif/loading5.gif') ?>" alt="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Alamat SO</label>

                            <div class="col-sm-10">
                                <textarea class="form-control alamatDSP" placeholder="Alamat" style="width:550px; height:90px;" readonly></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Alamat Kirim</label>

                            <div class="col-sm-10">
                                <textarea class="form-control alamatkirimDSP" placeholder="Alamat Kirim" style="width:550px; height:90px;"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Deskripsi</label>

                            <div class="col-sm-10">
                                <!-- <textarea class="form-control deskripsiDSP" placeholder="Deskripsi" style="width:550px; height:10px;" readonly></textarea> -->
                                <input type="text" class="form-control deskripsiDSP" style="width:550px;" placeholder="Deskripsi" readonly></input>

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Tanggal Kirim</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control tanggalDSP" style="width:550px;" placeholder="Tanggal kirim" readonly></input>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Ekspedisi</label>

                            <div class="col-sm-10">
                                <!-- <input type="text" class="form-control ekspedisiDSP" style="width:550px;" placeholder="Ekspedisi" readonly></input> -->
                                <select class="ekspedisiDSP form-control select2" data-placeholder="Select" style="width:550px;"></select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">SO</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control inputSODSP" style="width:550px;" placeholder="SO" readonly></input>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">OPK</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control inputOPKDSP" style="width:550px;" placeholder="OPK" readonly></input>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Jenis DPB</label>

                            <div class="col-sm-10">
                                <select name="" id="" class="form-control select2 jenisDPS" data-placeholder="Jenis DPB" style="width:250px; height:120px;">
                                    <option></option>
                                    <option value="URGENT">URGENT</option>
                                    <option value="BEST AGRO">BEST AGRO</option>
                                    <option value="NORMAL">NORMAL</option>
                                    <option value="ECERAN">ECERAN</option>
                                    <option value="E-COMMERCE">E-COMMERCE</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Keterangan Tambahan</label>

                            <div class="col-sm-10">
                                <textarea class="form-control keteranganDPS" placeholder="Keterangan Tambahan" style="width:550px;"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Forward To</label>

                            <div class="col-sm-10">
                                <select name="" id="" data-placeholder="Forward To" class="form-control select2 forwardDPS" style="width:250px;">
                                    <option></option>
                                    <option value="J1365">J1365 - MUHAMMAD REZA SHALAHUDDIN NOOR</option>
                                    <option value="B0892">B0892 - NANDA ILHAM</option>
                                    <option value="B0658">B0658 - NASHRUL HAKIM</option>
                                    <option value="B0701">B0701 - ADKHA JIHAD SETYAWAN</option>
                                    <option value="B0809">B0809 - YUSRINA KARTIKA RISTANTI</option>
                                    <option value="B0906">B0906 - FAJRI PARMI</option>
                                    <option value="B0854">B0854 - AJI CAHYARUBIN</option>

                                </select>
                            </div>

                        </div>
                        <input type="hidden" class="org_idd">
                        <input type="hidden" class="subinvv">
                        <br />
                        <div class="tempatTabelDPS">

                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="button" class="btnCrateDPBDPS btn btn-primary pull-right" style="display:none">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>