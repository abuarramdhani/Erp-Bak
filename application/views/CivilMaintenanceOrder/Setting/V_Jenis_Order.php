<section class="content">
    <div class="inner" >
        <div class="row">
            <div class="col-lg-12">
                <div class="col-lg-11">
                    <div class="text-right">
                        <h1><b><?= $Title ?></b></h1>
                    </div>
                </div>
                <div class="col-lg-1">
                    <div class="text-right hidden-md hidden-sm hidden-xs">

                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-11"></div>
                        <div class="col-lg-1 "></div>
                    </div>
                </div>
                <br />
                <div class="">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border"></div>
                            <div class="box-body">
                                <div class="col-md-12 text-right">
                                    <button data-toggle="modal" data-target="#cmojenisorder" class="btn btn-success"><i class="fa fa-plus"></i> Tambah</button>
                                </div>
                                <div class="col-md-12" style="margin-top: 20px;" id="CMO_tblJnsOrder">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="modal fade" id="cmojenisorder" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <form id="frm_addJnsOrder">
                <div class="modal-header">
                    <label class="modal-title" id="exampleModalLabel">Tambah Jenis Order</label>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <label>Jenis Order</label>
                    <input placeholder="Masukan Jenis Order" class="form-control" name="jenisOrder">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success" id="cmo_addJnsOrder">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="cmoupjenisorder" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <form id="frm_upJnsOrder">
                <div class="modal-header">
                    <label class="modal-title" id="exampleModalLabel">Edit Jenis Order</label>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <label>Jenis Order</label>
                    <input placeholder="Masukan Jenis Order" class="form-control" name="upjenisOrder">
                    <input hidden="" name="idJnsOrder">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success" id="cmoupJnsOrder">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    window.addEventListener('load', function () {
        loadTableCMOjnsOrder();
    });
    $(document).keypress(
        function(event){
            if (event.which == '13') {
                event.preventDefault();
            }
        });
</script>