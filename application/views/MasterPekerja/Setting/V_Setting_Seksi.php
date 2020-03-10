<style>
    .dataTables_filter{
        float: right;
    }
    .dataTables_info{
        float: left;
    }
</style>
<section class="content">
    <div class="inner" >
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-11">
                            <div class="text-right"><h1><b><?php echo $Title;?></b></h1></div>
                        </div>
                        <div class="col-lg-1">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                            </div>
                        </div>
                    </div>
                </div>
                <br/>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">
                            </div>
                            <div class="box-body">
                                <h3 class="mpkrm">Please Wait......</h3>
                                <div class="col-md-12" id="mpkhide" hidden>
                                    <table class="table table-bordered table-striped text-center" id="tbl_mpkSt">
                                        <thead>
                                            <th>No</th>
                                            <th>Kodesie</th>
                                            <th>Seksi</th>
                                            <th>Status</th>
                                            <th>Alasan</th>
                                            <th>Action</th>
                                        </thead>
                                        <tbody>
                                            <?php $x = 1; foreach ($seksi as $key): ?>
                                            <tr>
                                                <td><?= $x ?></td>
                                                <td id="tdmpkks"><?= $key['kodesie'] ?></td>
                                                <td id="tdmpksk" style="text-align: left;"><?= rtrim($key['seksi']) ?></td>
                                                <td>
                                                    <?php
                                                    if ($key['flag'] == 1) {
                                                        echo '<span class="label label-success label-md">Aktif</span>';
                                                    }else{
                                                        echo '<span class="label label-danger">Tidak Aktif</span>';
                                                    }
                                                    ?>
                                                    <input id="tdmpkst" hidden="" value="<?= $key['flag'] ?>">
                                                </td>
                                                <td id="tdmpkalsn"><?= $key['alasan'] ?></td>
                                                <td>
                                                    <button class="btn btn-primary btnmpkmdlsk">Edit <i class="fa fa-edit"></i></button>
                                                </td>
                                            </tr>
                                            <?php $x++; endforeach ?>
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

<div class="modal fade" id="mdlmpksk" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
    <form method="post" action="<?= base_url('MasterPekerja/Setting/saveSeksi') ?>">
        <div class="modal-content">
            <div class="modal-header">
                <label class="modal-title" id="exampleModalLongTitle">Edit Data</label>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class=" text-center" id="mdmpkodesi" style="font-weight: bold;">Kodesie - Nama Seksi</div>
                <div class="text-center" style="font-weight: bold; margin-top: 20px;">Status :</div>
                <div style="text-align: center;" id="mdmpkradio">
                <div style="margin: auto; width: 300px;">
                    <label style="width: 100px; color: #00a65a;">
                        <input id="mpkst1" style="" type="radio" name="status" value="1"> Aktif
                    </label>
                    <label style="width: 100px; color: red;">
                        <input id="mpkst0" style="" type="radio" name="status" value="0"> Tidak Aktif
                    </label>
                </div>
                </div>
                <div class="text-center" style="margin-top: 20px;"><label>Alasan :</label></div>
                <div class="" id="mdmpkalasan">
                    <textarea name="alasan" class="form-control"></textarea>
                </div>
                <input hidden="" name="kodesie" id="mpkkds">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
    </form>
        </div>
    </div>
</div>
<script>
    window.addEventListener('load', function () {
        $('.mpkrm').remove();
        $('#mpkhide').show();
        <?php if ($this->session->userdata('sukses_mpk')): ?>
            notif_save_hardware('update');
        <?php endif ?>
    });
</script>            