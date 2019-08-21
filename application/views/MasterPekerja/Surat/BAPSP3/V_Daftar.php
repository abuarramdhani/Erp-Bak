<style type="text/css">.dataTables_wrapper .dataTables_processing{position:absolute;text-align:center;font-size:1.2em;z-index:999}#datepicker,#filterPeriode{cursor:pointer}.dataTable_Button{width:350px;float:left;margin-left:1px;margin-bottom:2px}.dataTable_Filter{width:450px;float:right;margin-right:1px;margin-bottom:2px}.dataTable_Information{width:350px;float:left;margin-left:1px;margin-top:7px}.dataTable_Pagination{width:450px;float:right;margin-right:1px;margin-top:14px}.dataTable_Processing{z-index:999}.fade-transition{-webkit-transition:background-color 250ms linear;-moz-transition:background-color 250ms linear;-o-transition:background-color 250ms linear;-ms-transition:background-color 250ms linear;transition:background-color 250ms linear}</style>
<section class="content inner row">
    <div class="col-lg-12">
        <div class="row text-left" style="margin-top: -14px; margin-bottom: 8px;">
            <h1 id="title" style="font-weight: bold"><?= $Title ?></h1>
        </div>
        <div class="row">
            <div class="box box-primary box-solid">
                <div class="box-header with-border">
                    <div class="col-lg-12" style="padding: 0px;">
                        <div class="col-lg-6" style="padding: 0px;">
                            <h4 style="margin-top: 6px; margin-bottom: 0;">Daftar Surat</h4>
                        </div>
                        <div class="col-lg-6" style="padding: 0px;">
                            <div class="btn-group pull-right">
                                <button id="btn-refresh" class="btn btn-primary"><i style="margin-right: 8px;" class="fa fa-refresh"></i>Refresh</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="datatable table table-striped table-bordered table-hover text-left" id="tblLkhPekerjaListData" style="width: 100%;">
                                <thead class="bg-primary">
                                    <tr>
                                        <th style="text-align: center; width: 40px;">No</th>
                                        <th style="text-align: center; width: 90px;">Aksi</th>
                                        <th class="text-center">Pekerja</th>
                                        <th class="text-center">Record Pekerjaan</th>
                                        <th class="text-center">Record Kondite</th>
                                        <th style="text-align: center; width: 120px;">Status</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>