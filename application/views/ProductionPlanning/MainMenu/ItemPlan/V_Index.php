<section class="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-11">
                            <div class="text-right">
                                <h1>
                                    <b>
                                        Item Plan Detail
                                    </b>
                                </h1>
                            </div>
                        </div>
                        <div class="col-lg-1 ">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('ProductionPlanning/ItemPlan');?>">
                                    <i aria-hidden="true" class="fa fa-list-alt  fa-2x">
                                    </i>
                                    <span>
                                        <br/>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <br/>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">
                                <a alt="Add New" href="<?php echo site_url('ProductionPlanning/ItemPlan/Create') ?>" style="float:right;margin-right:1%;margin-top:-0.5%;" title="Add New">
                                    <button class="btn btn-default btn-sm" type="button">
                                        <i class="icon-plus icon-2x">
                                        </i>
                                    </button>
                                </a>
                                Item List
                            </div>
                            <div class="panel-body">
                                <table class="table table-bordered table-hover table-striped" id="tbitemData">
                                    <thead class="bg-primary">
                                        <tr>
                                            <td>No</td>
                                            <td>Item Code</td>
                                            <td>Description</td>
                                            <td>Section</td>
                                            <td>From Inventory</td>
                                            <td>To Inventory</td>
                                            <td>Action</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($itemData as $dt) { ?>
                                        <tr>
                                            <td><?php echo $no++; ?></td>
                                            <td><?php echo $dt['item_code']; ?></td>
                                            <td><?php echo $dt['item_description']; ?></td>
                                            <td><?php echo $dt['section_name']; ?></td>
                                            <td><?php echo $dt['from_inventory']; ?></td>
                                            <td><?php echo $dt['to_inventory']; ?></td>
                                            <td>
                                                <a href="javascript:alert('fitur ini belum tersedia')" class="btn btn-default">EDIT</a>
                                            </td>
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
</section>