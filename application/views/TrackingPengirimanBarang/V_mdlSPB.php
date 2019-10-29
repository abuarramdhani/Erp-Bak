<style>
     /* thead.toscahead tr th {
        background-color: #9e9e9e;
      }*/
 /*     thead.haha tr th {
        background-color: #026337;
      }
      .itsfun1 {
        border-top-color: #026337;
      }
      .buttoncute {
      	background-color: #026337;
      }
      .capital{
    text-transform: uppercase;*/
}
</style>
    <section class="content-header">
      <h1>
        Detail SPB
      </h1>
    </section>
    <!-- Main content -->
<section class="content">
  	<div class="row">
    	<div class="col-md-12">
      	<div class="box box-primary">
	   		<div class="box-header with-border" style="text-align: left;">
					<h3 class="box-title" style="font-family: sans-serif;">
                	<b> CEK NOMOR SPB</b><br>
              	</h3><br>
            </div>
         <div class="box-body">
				<div class="col-md-12">
					<!----- Tabel ----->
					<table  id="filter" class="col-md-12 tblResponsive" style="margin-bottom: 20px">
						<tr>
							<td style="width: 25%;padding-left: 350px;">
								<span><b>No SPB</b></span>
							</td>
							<td style="width:25%; padding: 5px 250px 5px 50px;">
								<input class="form-control capital" style="width: 300px;" type="text" id="txtNoSPB" name="txtNOSPB" value="<?php echo $spb[0]['NO_SPB'] ?>"></input>
							</td>
						</tr>
						<tr>
							<td style="width: 25%;padding-left: 350px;">
								<span><b>No SO</b></span>
							</td>
								<td style="width:25%; padding: 5px 250px 5px 50px;">
									<input class="form-control capital" style="width: 300px" type="text" id="txtNoSO" name="txtNoSO" value="<?php echo $spb[0]['SO'] ?>" ></input>
								</td>
						</tr>
						<tr>
							<td style="width: 25%;padding-left: 350px;">
								<span><b>Customer</b></span>
							</td>
							<td style="width:25%; padding: 5px 250px 5px 50px;">
								<input class="form-control capital" style="width: 300px" type="text" id="txtSPBCustomer" name="txtSPBCustomer" value="<?php echo $spb[0]['CUST'] ?>" ></input>
							</td>
						</tr>
            <tr>
              <td style="width: 25%;padding-left: 350px;">
                <span><b>Alamat</b></span>
              </td>
                <td style="width: 25%;padding: 5px 250px 5px 50px;">
                  <input class="form-control capital kendaraanTPB" style="width: 300px" type="text" id="txtSPBAlamat" name="txtSPBAlamat" value="<?php echo $spb[0]['ALAMAT']?>" ></input>
            </tr>
					</table>
				</div>
			</div>
            <div class="box-body">
					<table align="center" style="width: 100%;" id="tblTPB" class="tb_dash_unit table table-striped table-bordered table-hover text-center">
                 <thead>
										<tr class="bg-primary">
											<th style="width: 3%;" class="text-center">No</th>
											<th style="width: 10%;" class="text-center">Kode Item</th>
											<th style="width: 30%;" class="text-center">Nama Item</th>
											<th style="width: 5%;" class="text-center">QTY</th>
											<th style="width: 10%;" class="text-center">UOM</th>
										</tr>
									</thead>
									<tbody>
										<?php $no=1; foreach($spb as $k) { ?>
										<tr>
											<td><?php echo $no ?> </td>
											<td><?php echo  $k['KODE_ITEM'] ?></td>
											<td><?php echo  $k['NAMA_ITEM'] ?></td>
											<td><?php echo  $k['QTY'] ?></td>
											<td><?php echo  $k['UOM'] ?></td>
										</tr>
										<?php $no++; } ?>
									</tbody>
               </table>
               </center>
          </div>
        </div>
      </div>
    </div>
 </div>
 </section>
