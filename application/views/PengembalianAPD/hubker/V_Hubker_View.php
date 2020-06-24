<style>
    .select2-search__field{
        text-transform: uppercase;
    }
    .div_kotak{
        height: 150px;
        border-radius: 10px;
        background-color: blue;
    }
</style>
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
                            <div class="box-header with-border">
                            </div>
                            <div class="box-body">
                                <div class="panel-body">
                                    <div class="col-md-4">
                                        <div class="small-box bg-blue">
                                            <div class="inner">
                                                <p>New</p>
                                                <h2 class=""><?=$new?> Data</h2>
                                            </div>
                                            <div class="icon">
                                                <i class="fa fa-clock-o"></i>
                                            </div>
                                            <a href="<?=base_url('pengembalian-apd/hubker/view_data?stat=0')?>" class="small-box-footer">Info Lengkap <i class="fa fa-arrow-circle-right"></i></a>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="small-box bg-green">
                                            <div class="inner">
                                                <p>Approved</p>
                                                <h2 class=""><?=$app?> Data</h2>
                                            </div>
                                            <div class="icon">
                                                <i class="fa fa-check"></i>
                                            </div>
                                            <a href="<?=base_url('pengembalian-apd/hubker/view_data?stat=1')?>" class="small-box-footer">Info Lengkap <i class="fa fa-arrow-circle-right"></i></a>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="small-box bg-red">
                                            <div class="inner">
                                                <p>Rejected</p>
                                                <h2 class=""><?=$rej?> Data</h2>
                                            </div>
                                            <div class="icon">
                                                <i class="fa fa-times"></i>
                                            </div>
                                            <a href="<?=base_url('pengembalian-apd/hubker/view_data?stat=2')?>" class="small-box-footer">Info Lengkap <i class="fa fa-arrow-circle-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</section>