<style>
/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content/Box */
.modal-content {
  background-color: #fefefe;
  margin: 15% auto; /* 15% from the top and centered */
  padding: 20px;
  border: 1px solid #888;
  width: 80%; /* Could be more or less, depending on screen size */
}

/* The Close Button */
.close {
  color: #aaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: black;
  text-decoration: none;
  cursor: pointer;
}

.radiusBox{
    border-radius: 10px;
}

/* .select2-container{
    width: 100% !important;
} */
</style>
<section class="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <div class="col-lg-11 text-right"><h1>Kalender Database QTW</h1></div>
                <div class="col-lg-1" style="margin-top: 10px;"><span class="fa fa-2x fa-database" style="color: red; position: absolute; margin-left: -10px; margin-top: 15px;"></span><span class="fa fa-3x fa-calendar"></span></div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-body no-padding">
                        <div class="col-lg-12">
                            <div id="calendar_QTW">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div id="body_detailQtw" class="modal fade" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="width: 1500px; padding-right: 150px; margin-top: -150px;">
        <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close hover" data-dismiss="modal">&times;</button>
                <h3><b>DETAIL KEGIATAN</b></h3>
            </div>
            <div class="modal-body">
                <div class="col-lg-12" id="makeLoading"></div>
                <div class="col-lg-2 trueValue" hidden>
                    <center>
                        <div class="row">
                            <img src="" style="height: 4cm; width: 3cm;" id="makePhoto">
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-lg-12">
                                <label>Pemandu</label>
                            </div>
                            <br>
                            <div class="col-lg-12 hide" id="unHideEdit">
                                <select class="select select2 form-control" id="slcPemanduQtw">
                                    <option id="isianOption"></option>
                                </select>
                            </div>
                            <div class="col-lg-12" id="HideEdit">
                                <label id="labelingPemandu"></label>
                            </div>
                            <br>
                            <div class="col-lg-12">
                                <button type="button" class="btn btn-flat" id="hapus_disable"><span class="fa fa-pencil"></span></button>
                                <button type="button" class="btn btn-flat btn-success hide" id="save_edit_pic"><span class="fa fa-check"></span></button>
                                <button type="button" class="btn btn-flat btn-danger hide" id="batal_edit_pic"><span class="fa fa-close"></span></button>
                            </div>
                        </div>
                    </center>
                </div>
                <div class="col-lg-5 trueValue" hidden>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-4">
                                <label>Tanggal :</label>
                            </div>
                            <div class="col-lg-8">
                                <input type="text" id="inp_tgl_detail" class="form-control radiusBox" readonly>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-4">
                                <label>Waktu :</label>
                            </div>
                            <div class="col-lg-8">
                                <input type="text" id="inp_wkt_detail" class="form-control radiusBox" readonly>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-4">
                                <label>Tujuan :</label>
                            </div>
                            <div class="col-lg-8">
                                <input type="text" id="inp_tjn_detail" class="form-control radiusBox" readonly>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-4">
                                <label>PIC :</label>
                            </div>
                            <div class="col-lg-8">
                                <input type="text" id="inp_pic_detail" class="form-control radiusBox" readonly>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-4">
                                <label>No.HP PIC :</label>
                            </div>
                            <div class="col-lg-8">
                                <input type="text" id="inp_nohp_detail" class="form-control radiusBox" readonly>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-4">
                                <label>Alamat :</label>
                            </div>
                            <div class="col-lg-8">
                                <input type="text" id="inp_alamat_detail" class="form-control radiusBox" readonly>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-4">
                                <label>Desa :</label>
                            </div>
                            <div class="col-lg-8">
                                <input type="text" id="inp_desa_detail" class="form-control radiusBox" readonly>
                            </div>
                        </div>
                    </div>
                    
                    
                </div>
                <div class="col-lg-5 trueValue" hidden>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-4">
                                <label>Kecamatan :</label>
                            </div>
                            <div class="col-lg-8">
                                <input type="text" id="inp_kec_detail" class="form-control radiusBox" readonly>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-4">
                                <label>Kabupaten :</label>
                            </div>
                            <div class="col-lg-8">
                                <input type="text" id="inp_kab_detail" class="form-control radiusBox" readonly>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-4">
                                <label>Provinsi :</label>
                            </div>
                            <div class="col-lg-8">
                                <input type="text" id="inp_prop_detail" class="form-control radiusBox" readonly>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-12">
                                <label>Peserta:</label>
                            </div>
                        </div>
                        <div class="col-lg-1"></div>
                        <div class="col-lg-11" id="inp_peserta_detail"></div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-12">
                                <label>Kendaraan :</label>
                            </div>
                        </div>
                        <div class="col-lg-1"></div>
                        <div class="col-lg-11" id="inp_kdrn_detail"></div>
                    </div>
                    <br>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" align="right" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>