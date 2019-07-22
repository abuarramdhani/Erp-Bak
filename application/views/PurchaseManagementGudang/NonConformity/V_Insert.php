<section class="content">
    <div class="box box-default color-palette-box">
        <div class="box-body">
            <form class="form-horizontal" id="form-simpan"  enctype="multipart/form-data" method="post" action="<?php echo site_url('PurchaseManagementGudang/NonConformity/submitSource');?>">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs pull-left">
                        <li class="active"><a href="#photo" data-toggle="tab" class="photo tep-nonconformity"><b>Photo</b></a></li>
                        <li><a href="#remark" class="remark tep-nonconformity" data-toggle="tab"><b>Remark</b></a></li>
                        <li disabled><a href="#review" class="review tep-nonconformity" data-toggle="tab"><b>Review</b></a></li>
                    </ul>  
                </div>

                <div class="tab-content">
                    <div class="tab-pane active" id="photo">
                        <br>
                        <br>
                        <div>
                            <label></label>
                        </div>
                        <div class="col-lg-12" style="text-align:center;">
                            <label class="btn bg-navy btn-file">
                               <i class="glyphicon glyphicon-camera"></i> TAKE PICTURES<input type="file" name="photo[]" class='nonconfPhoto' multiple style="display: block;">
                            </label>
                        </div>
                        <div class="col-lg-12">
                            <span>Photo : </span>
                        </div>
                        <div class="col-md-12 photoNonConformity" style="text-align:left;">
                   
                        </div>
                        <div class="col-lg-12">
                            <span>Preview :</span>
                        </div>
                        <div class="col-md-12 previewImageNonConformity" style="text-align:center;">
                            <!-- <img src="#" class="previewImageSrcNonConformity" alt="your image" style="max-height: 300px; max-width: 300px;"/> -->
                        </div>
                    </div>

                    <div class="tab-pane" id="remark">
                        <br>
                        <br>
                        <br>
                        <div class="col-lg-12">
                            <span>Select Remark :</span>
                        </div>
                        <div class="col-lg-12">
                            <select class="form-control select2 slcRemarkNonConformity" name="remark[]" style="width:100%" multiple>
                            <?php foreach ($case as $key => $cases) :?>
                                <option value="<?= $cases['case_id']?>" namaCase="<?= $cases['case_name']?>"><?= $cases['case_name']?></option>
                             <? endforeach; ?>
                            </select>
                        </div><br>
                        <!-- <div class="col-lg-12">
                            <span>Selected Remark :</span>
                            
                        </div>
                        <div class="col-lg-12 selectedRemarkNonConformity">
                            
                        </div> -->
                        <div class="col-lg-12">
                            <span>Description :</span>
                        </div>
                        <div class="col-lg-12">
                            <textarea class="form-control descriptionRemarkNonConformity" name="txtDescription"></textarea>
                        </div>
                    </div>

                    <div class="tab-pane" id="review">
                        <br>
                        <br>
                        <br>
                         <div class="col-lg-12">
                            <span>Photo :</span>
                        </div>
                        <div class="col-md-12 photoNonConformity" style="text-align:left;">

                        </div>
                        <br>

                        <div class="col-lg-12">
                            <span>Info :</span>
                        </div>
                        <div class="col-lg-12 remarkReviewNonConformity">
                        </div>
                        <br>
                        <div class="col-lg-12">
                            <span>Description :</span>
                        </div>
                        <div class="col-lg-12 descriptionReviewNonConformity">
                        </div>
                        <!-- <div class="col-lg-12 submitNonConformity" style="text-align: center;">
                        </div> -->
                    </div>

                </div>
            
        </div>
    </div>
    <!-- <div class="col-lg-12"> -->
 
                <button type="button" class="btn btn-primary btnNextNonConformity pull-right" tab-now="#photo" style="width: 170px;">NEXT</button>
                <button type="button" class="btn btn-success submitNonConformity pull-right" data-toggle ="modal" data-target="#modal-submitNonconformity" tab-now="#photo" style="width: 170px; display: none;">SUBMIT</button>
            
                <button type="button" class="btn btn-warning btnBackNonConformity pull-left" tab-now="#photo" style="width: 170px;" disabled>BACK</button>

                <div class="modal fade" id="modal-submitNonconformity">
                    <div class="modal-dialog" style="width: 350px;">
                        <div class="modal-content">
                        <!-- <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title"></h4>
                        </div> -->
                            <div class="modal-body">
                                <p class="text-center">Apakah Anda yakin untuk submit data?</p>
                                <button type="button" class="btn btn-default pull-left">NO</button>
                                <button type="submit" class="btn btn-success pull-right">YES</button>
                            </div>
                            <div class="modal-footer">
                                <!-- <button type="button" class="btn btn-primary" data-dismiss="modal">Ok</button> -->
                                
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                <!-- /.modal -->
            </form>


    <!-- </div>  -->
</section>