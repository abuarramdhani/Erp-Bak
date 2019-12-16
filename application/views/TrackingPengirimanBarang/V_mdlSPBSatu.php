<style>
    tr.danger td{
      background-color: #eb3d34;
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
				<div class="col-md-12 pull-right">
					<!----- Tabel ----->
          <div class="col-md-6 pull-right">
          <?php
              if ($map) {
                ?>
                <div id="mapTracking" style="margin-top:40px;width: 500px;z-index: 999; height: 300px;"></div>
                <?php
              }
               ?>
            </div>
          <div class="col-md-4 pull-left">
					<table id="filter" class="tblResponsive" style="margin-bottom: 20px;margin-top: 50px">
						<tr>
							<td style="width: 15%" >
								<span><b>No SPB</b></span>
							</td>
						     <td style="width:15%; padding: 5px 550px 5px 40px;">
								<input class="form-control capital" style="width: 300px;" type="text" id="txtNoSPB" name="txtNOSPB" value="<?php echo $spb[0]['NO_SPB'] ?>"></input>
							</td>
						</tr>

						<tr>
							<td style="width: 15%">
								<span><b>No SO</b></span>
							</td>
							<td style="width: 15%; padding: 5px 550px 5px 40px;">
								<input class="form-control capital" style="width: 300px" type="text" id="txtNoSO" name="txtNoSO" value="<?php echo $spb[0]['SO'] ?>" ></input>
							</td>
						</tr>

						<tr>
							<td style="width: 15%">
								<span><b>Customer</b></span>
							</td>
							<td style="width: 15%; padding: 5px 550px 5px  40px;">
								<input class="form-control capital" style="width: 300px" type="text" id="txtSPBCustomer" name="txtSPBCustomer" value="<?php echo $spb[0]['CUST'] ?>" ></input>
							</td>
						</tr>

                              <tr>
                                   <td style="width: 15%">
                                        <span><b>Alamat</b></span>
                                   </td>
                                   <td style="width: 15%;padding: 5px 550px 5px 40px;">
                                        <input class="form-control capital kendaraanTPB" style="width: 300px" type="text" id="txtSPBAlamat" name="txtSPBAlamat" value="<?php echo $spb[0]['ALAMAT']?>" ></input>
                                   </td>
                              </tr>

                              <tr>
                                   <td style="width: 15%">
                                        <span><b>Status</b></span>
                                   </td>
                                   <td style="width: 15%;padding: 5px 550px 5px 40px;">
                                        <input readonly class="form-control capital kendaraanTPB" style="width: 300px;font-weight: bold;" type="text" id="txtSPBAlamat" name="txtSPBAlamat" value="Diterima : <?php echo $yyy[0]['count_Y']?> Ditolak : <?php echo $nnn[0]['count_N']?>"></input>
                                   </td>
                              </tr>

                              <tr>
                                   <td style="width: 15%">
                                        <span><b>Info</b></span>
                                   </td>
                                   <td  style="width: 15%;padding: 5px 550px 5px 40px;">
                                        <textarea class="form-control capital note" style="width: 300px" type="text" id="noteTPB" name="noteTPB" ><?php echo $spb[0]['NOTE'] ?></textarea>
                                   </td>
                              </tr>
					</table>
                    </div>
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
                                                       <th style="width: 10%;" class="text-center">Y/N</th>
										</tr>
			  </thead>
									<tbody>
										<?php $no=1; foreach($spb as $k) { ?>
                                                       <?php if ($k['CON_ID'] == 'N' || $k['CON_ID'] == '') { ?>
                                                            <tr class ="danger" data-toggle="tooltip" data-placement="top" title="Item Ditolak">
                                                       <?php }else{ ?> 
                                                            <tr data-toggle="tooltip" data-placement="top" title="Item Diterima">
                                                       <?php }?>
											<td><?php echo $no ?> </td>
											<td><?php echo  $k['KODE_ITEM'] ?></td>
											<td><?php echo  $k['NAMA_ITEM'] ?></td>
											<td><?php echo  $k['QTY'] ?></td>
											<td><?php echo  $k['UOM'] ?></td>
                                                       <td><?php echo  $k['CON_ID'] ?></td>
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
<script type="text/javascript">
  function initMap(lat = <?= !empty($lat) ? $lat : '0';?>, long= <?= !empty($long) ? $long : '0';?> ) {
    // The location of Uluru
    var place = {
      lat: Number(lat),
      lng: Number(long)
    };
    // The map, centered at Uluru
    var map = new google.maps.Map(
      document.getElementById('mapTracking'), {
        zoom: 18,
        center: place
      });
    // The marker, positioned at Uluru
    var marker = new google.maps.Marker({
      position: place,
      map: map
    });
  }
</script>
<!--Load the API from the specified URL
    * The async attribute allows the browser to render the page while the API loads
    * The key parameter will contain your own API key (which is not needed for this tutorial)
    * The callback parameter executes the initMap() function
    -->
<script async defer src="https://maps.googleapis.com/maps/api/js?key=&callback=initMap">
</script>
