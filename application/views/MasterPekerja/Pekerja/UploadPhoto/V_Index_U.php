<style>
    @media only screen and (max-width: 600px) {
        .thismaxwidth{
            width: 100% !important;
        }
    }
    @media only screen and (min-width: 600px) {
        .thismaxwidth{
            width: 500px !important;
        }
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
                                <div id="show_when_full" class="table-responsive" hidden="">
                                    <div class="col-md-12" style="margin-bottom: 50px;">
                                        <button class="btn btn-success" data-target="#MPKmodalUploadPhoto" data-toggle="modal">
                                            <i class="fa fa-plus"></i> Upload Photo
                                        </button>
                                    </div>
                                    <table class="table table-striped table-bordered table-hover text-left" id="dataTable_ipoto" style="font-size:14px;">
                                        <thead class="bg-primary">
                                            <tr>
                                                <th>No</th>
                                                <th>Noind</th>
                                                <th>Nama</th>
                                                <th>Path Photo</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no=0; foreach($getInfo as $gi){ $no++ ?>
                                            <tr>
                                                <td><?php echo $no ?></td>
                                                <td><?php echo $gi['noind'] ?></td>
                                                <td><?php echo $gi['nama'] ?></td>
                                                <td><?php echo '<a href="'.$gi['photo'].'" target="_blank">'.$gi['photo'].'</a>' ?></td>
                                            </tr>
                                            <?php } ?>
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
<div class="modal fade" id="MPKmodalUploadPhoto" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form method="post" action="<?= base_url('MasterPekerja/upload-photo/doUpload') ?>" enctype="multipart/form-data">
                <div class="modal-header">
                    <label class="modal-title" id="exampleModalLongTitle">Add / Replace Photo</label>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div style="width: 100%; text-align: center;">
                        <label>Pekerja</label><br>
                        <div style="width: 500px; margin: auto;" class="thismaxwidth">
                            <select style="width: 100%;" class="form-control select-nama" id="mpk_cek_file" name="txtNoInd">
                                <option></option>
                            </select>
                        </div>
                        <label hidden="" id="mpk_warn_rtxt" style="color: red">*File pekerja Tersebut Sudah Ada. MengUpload File ini akan mereplace File sebelumnya!</label>
                        <br>
                        <label style="margin-top: 10px;">File Photo</label>
                        <div style="width: 500px; margin: auto;" class="thismaxwidth">
                            <input type="file" name="txtPhoto" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    <button id="mpk_warn_rbtxt" type="submit" class="btn btn-success">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    window.addEventListener('load', function () {
        $('#show_when_full').show();
    });
</script>