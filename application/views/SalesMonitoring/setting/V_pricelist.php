<script src="<?php echo base_url('assets/js/ajaxSearch.js');?>"></script>
<section class="content">
	<div class="inner" >
	<div class="row">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-lg-12">
				<div class="box box-info">
				<div class="box-header with-border" style=" background:#FFFFFF; color:#22aadd;">
					<div class="col-md-6">
						<a href='<?php echo site_url('SalesMonitoring/pricelist/create/') ?>'class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> New </a>
						
						<div class="btn-group">
						  <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<span class="glyphicon glyphicon-save" aria-hidden="true"></span> Export <span class="caret"></span>
						  </button>
						  <ul class="dropdown-menu">
							<li><a href="<?php echo site_URL('SalesMonitoring/pricelist/download/csv') ?>">CSV</a></li>
							<li><a href="<?php echo site_URL('SalesMonitoring/pricelist/download/xml') ?>">XML</a></li>
							<li><a href="<?php echo site_URL('SalesMonitoring/pricelist/download/pdf') ?>">PDF</a></li>
						  </ul>
						</div>
					</div>
				</div>
				<div class="box-body">
						<div class="table-responsive">						
							<fieldset class="row2" style="background:#FFFFFF;">
								</br>
								<table  class="table table-hover table-striped table-bordered text-center" id="pricelisttab" style="font-size:12px;">
									<thead style="background:#22aadd; color:#FFFFFF;">
										<tr>
											<th>NO</th>
											<th>ITEM CODE</th>
											<th>PRODUCT NAME</th>
											<th>PRICE</th>
											<th>ACTION</th>
										</tr>
									</thead>
									<tbody id="name-list">
										<?php $no = 0; foreach($pricelist as $pricelist_item) { $no++ ?>
											<tr>
												<td><?php echo $no; ?></td>
												<td><?php echo $pricelist_item['item_code'] ?></td>
												<td><?php echo $pricelist_item['item_name'] ?></td>
												<td align="right"><?php echo number_format($pricelist_item['price'], 2 , ',' , '.' ); ?></td>
												<td>
													<a href='<?php echo site_URL() ?>SalesMonitoring/pricelist/update/<?php echo $pricelist_item['pricelist_index_id'] ?>'class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Update</a>
													<a href='<?php echo site_URL() ?>SalesMonitoring/pricelist/delete/<?php echo $pricelist_item['pricelist_index_id'] ?>'class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Delete</a>
												</td>
											</tr>
										<?php } ?>
									</tbody>																			
								</table>
								<div class="clear"></div>
							</fieldset>
						</div>
					<div class="box">
						<?php $link = $this->uri->segment(2); ?>
					</div>
				</div>
			</div>
				</div>
			</div>
		</div>
	</div>
	</div>
</section>
