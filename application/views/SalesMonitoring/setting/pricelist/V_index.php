<script src="<?php echo base_url('assets/js/ajaxSearch.js');?>"></script>

<section class="content">
	<div class="inner" >
	<div class="row">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-lg-12">
					<div class="col-lg-11">
						<div class="text-right">
						<h1><b>Setup Pricelist Index</b></h1>
						</div>
					</div>
					<div class="col-lg-1">
						<div class="text-right hidden-md hidden-sm hidden-xs">
                            <a class="btn btn-default btn-lg" href="<?php echo site_url('SalesMonitoring/pricelist');?>">
                                <i class="icon-wrench icon-2x"></i>
                                <span ><br /></span>	
                            </a>
						</div>
					</div>
				</div>
			</div>
			<br />
			
			<div class="row">
				<div class="col-lg-12">
				<div class="box box-primary box-solid">
					<div class="box-header with-border">
						<a href="<?php echo site_url('SalesMonitoring/pricelist/Create/') ?>" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Add New" title="Add New" >
							<button type="button" class="btn btn-default btn-sm">
							  <i class="icon-plus icon-2x"></i>
							</button>
						</a>
						Pricelist Index
					</div>
					<div class="box-body">

						<div class="table-responsive" style="overflow:hidden;">
							<table class="table">
								<tr>
									<td><div class="btn-group">
										<button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										<span class="glyphicon glyphicon-save" aria-hidden="true"></span> Export <span class="caret"></span>
										</button><br>
										<ul class="dropdown-menu">
											<li><a href="<?php echo site_URL('SalesMonitoring/pricelist/Download/csv') ?>">CSV</a></li>
											<li><a href="<?php echo site_URL('SalesMonitoring/pricelist/Download/xml') ?>">XML</a></li>
											<li><a href="<?php echo site_URL('SalesMonitoring/pricelist/Download/pdf') ?>">PDF</a></li>
										</ul>
									</div></td>
								</tr>
							</table>
							<table class="table">
								<form method="post" action="<?php echo base_url('SalesMonitoring/pricelist/Filter')?>">
									<tr>
										<td width="18%">
											<select class="form-control select4" name="txt_profilter_itemcode" required>
												<option value="%">ANY</option>
												<?php foreach($source_itemcode as $source_itemcode_item) { ?>
												<?php echo '<option>'.$source_itemcode_item['item_code'].'</option>' ?>
												<?php } ?>
											</select>
										</td>
										<td width="30%">
											<select class="form-control select4" name="txt_profilter_productname" required>
												<option value="%">ANY</option>
												<?php foreach($source_itemname as $source_itemname_item) { ?>
												<?php echo '<option>'.$source_itemname_item['item_name'].'</option>' ?>
												<?php } ?>
											</select>
										</td>
										<td width="20%">
											<input type="text" class="form-control" onkeypress="return isNumberKeyAndComma(event)" placeholder="minimum price" name="txt_profilter_pricelow"></input>
										</td>
										<td align="center" width="2%">
											<b>-</b>
										</td>
										<td width="20%">
											<input type="text" class="form-control" onkeypress="return isNumberKeyAndComma(event)" placeholder="maximum price" name="txt_profilter_pricehigh"></input>
										</td>
										<td width="10%">
											<button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-filter" aria-hidden="true"></span> Filter</button>
										</td>
									</tr>
								</form>
							</table>
							<table  class="table table-striped table-bordered table-hover text-left" id="dataTables-customer" style="font-size:12px;">
								<thead>
									<tr class="bg-primary">
										<th width="5%" >NO</th>
										<th width="20%">ITEM CODE</th>
										<th width="40%">PRODUCT NAME</th>
										<th width="15%">PRICE</th>
										<th width="20%">ACTION</th>
									</tr>
								</thead>
								<tbody>
									<?php $no = 0; foreach($pricelist as $pricelist_item) { $no++ ?>
										<tr>
											<td><?php echo $no; ?></td>
											<td><?php echo $pricelist_item['item_code'] ?></td>
											<td><?php echo $pricelist_item['item_name'] ?></td>
											<td align="right"><?php echo number_format($pricelist_item['price'], 2 , ',' , '.' ); ?></td>
											<td>
												<a href='<?php echo site_URL() ?>SalesMonitoring/pricelist/Update/<?php echo $pricelist_item['pricelist_index_id'] ?>'class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Edit</a>
												<a href='<?php echo site_URL() ?>SalesMonitoring/Pricelist/Delete/<?php echo $pricelist_item['pricelist_index_id'] ?>'class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Delete</a>
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
	</div>
</section>			
			
				
