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
                            <label for="" class="col-sm-2 control-label">Alamat</label>

                            <div class="col-sm-10">
                                <textarea class="form-control alamatDSP" placeholder="Alamat" style="width:550px; height:120px;" readonly></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Jenis DPB</label>

                            <div class="col-sm-10">
                                <select name="" id="" class="form-control select2 jenisDPS" style="width:250px; height:120px;">
                                    <option></option>
                                    <option value="URGENT">URGENT</option>
                                    <option value="BEST AGRO">BEST AGRO</option>
                                    <option value="NORMAL">NORMAL</option>
                                    <option value="ECERAN">ECERAN</option>
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
                                <select name="" id="" class="form-control select2 forwardDPS" style="width:250px;">
                                    <option></option>
                                    <option value="J1365">J1365 - MUHAMMAD REZA SHALAHUDDIN NOOR</option>
                                    <option value="B0892">B0892 - NANDA ILHAM</option>
                                    <option value="B0658">B0658 - NASHRUL HAKIM</option>
                                </select>
                            </div>
                        </div>
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