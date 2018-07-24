<form id="formExportExcelItemEcatalog" action="<?php echo base_url('ECommerce/SearchItem/exportExcelDataItem') ?>" method="POST" >
<section class="content">
	<div class="inner" >
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11">
							<div class="text-right">
								<h1><b>E-COMMERCE</b></h1>
							</div>
						</div>
					</div>
				</div>
				<br />
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border">
								Parameter Pencarian
							</div>
							<div class="box-body">
								<div class="form-group col-lg-12" id="divOrganization">
									<label for="slcOrganization" class="control-label col-lg-2">ORGANIZATION :</label>
									<div class="col-lg-4">
										<select name="slcOrganization" id="slcEcommerceOrganization" style="width:100%;">
											<option></option>
											<?php foreach ($organization as $org) {?>
											<option value="<?= $org['ORGANIZATION_ID'] ?>">
												<?= $org['NAME'] ?>
											</option>
											<?php } ?>
										</select>
									</div>
								</div>
								<div class="form-group col-lg-12" id="divSubInventory">
									<label for="slcSubInventory" class="control-label col-lg-2">SUB INVENTORY :</label>
									<div class="col-lg-4">
										<select name="slcSubInventory" id="slcEcommerceSubInventory" style="width:100%;" disabled>
											<option></option>
										</select>
									</div>
								</div>
							 	<div class="col-lg-12">
									<button class="btn btn-md btn-success" type="button" id="btnSearchEcommerceItem" disabled>Search</button>
									<button class="btn btn-md btn-info pull-right" type="submit" id="submitExportExcelItemEcatalog" disabled>EXPORT</button>
								</div><br><br><br>
								<div id="searchResultTableItemBySubInventory" class="col-lg-12"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
</form>


		