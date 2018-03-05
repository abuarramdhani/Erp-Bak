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
                                        Bppbg Control Account
                                    </b>
                                </h1>
                            </div>
                        </div>
                        <div class="col-lg-1 ">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('ProductCost/BppbgAccount');?>">
                                    <i aria-hidden="true" class="fa fa-user fa-2x">
                                    </i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">
                                <a class="pull-right" alt="Add New" href="<?php echo site_url('ProductCost/BppbgAccount/create') ?>" title="Add New">
                                    <button class="btn btn-default btn-sm" type="button">
                                        <i class="fa fa-plus">
                                        </i>
                                    </button>
                                </a>
                                Bppbg Account List
                            </div>
                            <div class="panel-body">
                                <form id="searchBppbgAccountArea" method="post">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <input type="text" name="using_category_code" class="form-control toupper" placeholder="Using Category Code" data-toggle="tooltip" data-placement="top" title="Search by Category Code">
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" name="account_number" class="form-control toupper" placeholder="Account Number" data-toggle="tooltip" data-placement="top" title="Search by Account Number">
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" name="cost_center" class="form-control toupper" placeholder="Cost Center" data-toggle="tooltip" data-placement="top" title="Search by Cost Center">
                                        </div>
                                        <div class="col-md-2">
                                            <input type="number" name="limit" class="form-control toupper" placeholder="Limit Data" data-toggle="tooltip" data-placement="top" title="Set Limit data to show">
                                        </div>
                                        <div class="col-md-1">
                                            <button type="submit" class="btn btn-primary btn-block">
                                                <i class="fa fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                                <div class="row">
                                    <div id="loadingArea"></div>
                                	<div class="col-md-12 table-responsive" id="tblBppbgAccountArea">
    	                            	<table class="table table-bordered table-striped table-hover" id="tblBppbgAccount">
    	                            		<thead class="bg-primary">
    	                            			<td>No</td>
    	                            			<td style="width: 90px;">Action</td>
    	                            			<td>Using Category Code</td>
    	                            			<td>Using Category</td>
    	                            			<td>Cost Center</td>
    	                            			<td>Cost Center Description</td>
    	                            			<td>Account Number</td>
    	                            			<td>Attribute</td>
    	                            		</thead>
    	                            		<tbody>
    	                            			<?php
    	                            				foreach ($account as $value) {
    	                            					// $encrypted_string = $this->encrypt->encode($value['ACCOUNT_ID']);
    	                            					// $encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
    	                            			?>
    	                            				<tr>
    	                            					<td><?php echo $no++; ?></td>
    	                            					<td>
    	                            						<div class="btn-group-justified">
    		                            						<a class="btn btn-default" href="<?php echo base_url('ProductCost/BppbgAccount/edit/'.$value['ACCOUNT_ID']) ?>">
    		                            							<i class="fa fa-edit"></i>
    		                            						</a>
    		                            						<a class="btn btn-danger" href="javascript:void(0)" data-id="<?php echo $value['ACCOUNT_ID']; ?>">
    		                            							<i class="fa fa-trash"></i>
    		                            						</a>
    		                            					</div>
    	                            					</td>
    	                            					<td><?php echo $value['USING_CATEGORY_CODE']; ?></td>
    	                            					<td><?php echo $value['USING_CATEGORY']; ?></td>
    	                            					<td><?php echo $value['COST_CENTER']; ?></td>
    	                            					<td><?php echo $value['COST_CENTER_DESCRIPTION']; ?></td>
    	                            					<td><?php echo $value['ACCOUNT_NUMBER']; ?></td>
    	                            					<td><?php echo $value['ACCOUNT_ATTRIBUTE']; ?></td>
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
    </div>
</section>