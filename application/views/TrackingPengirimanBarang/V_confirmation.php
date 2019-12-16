<style>
     /* thead.toscahead tr th {
        background-color: #9e9e9e;
      }*/
      /*thead.haha tr th {
        background-color: #026337;
      }
      .itsfun1 {
        border-top-color: #026337;
      }
      .buttoncute {
      	background-color: #026337;
      }*/
      .capital{
    text-transform: uppercase;
}
</style>
    <section class="content-header">
      <h1>
        Confirmation Form
      </h1>
    </section>
    <!-- Main content -->
<section class="content">
  	<div class="row">
    	<div class="col-md-12">
      	<div class="box box-primary">
	   		<div class="box-header with-border" style="text-align: left;">
					<h3 class="box-title" style="font-family: sans-serif;">
                	<b> CONFIRM </b><br>
              	</h3><br>
            </div>
         <div class="box-body">
				<div class="col-md-12 pull-right">
					<!----- Tabel ----->
         <!--  <div class="col-md-6 pull-right">
          <?php
              if ($map) {
                ?>
                <div id="mapTracking" style="width: 500px;z-index: 999; height: 300px;"></div>
                <?php
              }
               ?>
            </div>
          <div class="col-md-6 pull-left"> -->
					<table  id="filter" class="tblResponsive" style="margin-bottom: 20px;margin-top: 50px">
						<tr>
							<td style="width: 25%;padding-left: 200px">
								<span><b>No SPB</b></span>
							</td>
							<td style="width:25%; padding: 5px 550px 5px 50px;">
								<input class="form-control capital" style="width: 300px;" type="text" id="txtNoSPB" name="txtNOSPB" value="<?php echo $spb[0]['NO_SPB'] ?>"></input>
							</td>
						</tr>
						<tr>
							<td style="width: 25%;padding-left: 200px">
								<span><b>No SO</b></span>
							</td>
								<td style="width:25%; padding: 5px 550px 5px 50px;">
									<input class="form-control capital" style="width: 300px" type="text" id="txtNoSO" name="txtNoSO" value="<?php echo $spb[0]['SO'] ?>" ></input>
								</td>
						</tr>
						<tr>
							<td style="width: 25%;padding-left: 200px">
								<span><b>Customer</b></span>
							</td>
							<td style="width:25%; padding: 5px 550px 5px 50px;">
								<input class="form-control capital" style="width: 300px" type="text" id="txtSPBCustomer" name="txtSPBCustomer" value="<?php echo $spb[0]['CUST'] ?>" ></input>
							</td>
						</tr>
            <tr>
              <td style="width: 25%;padding-left: 200px">
                <span><b>Alamat</b></span>
              </td>
                <td style="width: 25%;padding: 5px 550px 5px 50px;">
                  <input class="form-control capital kendaraanTPB" style="width: 300px" type="text" id="txtSPBAlamat" name="txtSPBAlamat" value="<?php echo $spb[0]['ALAMAT']?>" ></input>
            </tr>
            <tr>
              <td style="width: 25%;padding-left: 200px">
                <span><b>Status</b></span>
              </td>
                <td style="width: 25%;padding: 5px 550px 5px 50px;">
                  <input disabled class="form-control capital conclusion" style="width: 300px" type="text" id="conclusionTPB" name="conclusionTPB" ></input>
            </tr>
            <tr>
              <td style="width: 25%;padding-left: 200px">
                <span><b>Info</b></span>
              </td>
                <td style="width: 25%;padding: 5px 550px 5px 50px;">
                  <textarea class="form-control capital note" style="width: 300px" type="text" id="noteTPB" name="noteTPB" ></textarea>
            </tr>
					</table>
          <br>
          <br>
            <!-- <div class="box-body"> -->
					<table align="center" style="width: 100%;" class="table table-striped table-bordered table-hover text-center">
                 <thead>
										<tr class="bg-primary">
											<th style="width: 5%;" class="text-center">No</th>
											<th style="width: 15%;" class="text-center">Kode Item</th>
											<th style="width: 30%;" class="text-center">Nama Item</th>
											<th style="width: 10%;" class="text-center">QTY</th>
											<th style="width: 10%;" class="text-center">UOM</th>
                      <th style="width: 15%;" class="text-center">Cek</th>
                      <th style="width: 15%;display: none" class="text-center">Hasil</th>
                      <th style="width: 20%;display: none" class="text-center">Line ID</th>
                      <!-- <th style="width: 5%;" class="text-center">Alasan</th> -->
										</tr>
									</thead>
									<tbody id="tbodyTPB">
										<?php $no=1; foreach($spb as $k) { ?>
										<tr id="coba">
											<td><?php echo $no ?> </td>
											<td><?php echo  $k['KODE_ITEM'] ?></td>
											<td><?php echo  $k['NAMA_ITEM'] ?></td>
											<td><?php echo  $k['QTY'] ?></td>
											<td><?php echo  $k['UOM'] ?></td>
                      <td id="coba"><div class="inidiv"><button value="Y" type="button" onclick="buttonConYes(this)" class="btn btn-sm btn-success" name="btnYes"><i class="fa fa-check"></i></button>
                        <button type="button" value="N" class="btn btn-sm btn-danger" onclick="buttonConNo(this)" name="btnNO"><i class="fa fa-remove"></i></button></div></td>
                      <td style="display: none"><input id="hasilConfirm" name="hasilConfirm[]" type="text" class="form-control"></td>
                      <td style="display: none"><input id="line_id" name="line_id[]" type="text" class="form-control" value="<?php echo $k['LINE_ID'] ?>"></td>
                      <!-- <td><input disabled type="text" name="inputAlasan" class="form-control"></td> -->
										</tr>
										<?php $no++; } ?>
									</tbody>
               </table>
               <br>
               <div class="col-md-6 pull-right">
                <button class="btn btn-success btn-sm pull-right" id="btnConfirm" onclick="submitConfirmation(<?php echo $spb[0]['NO_SPB'] ?>)" name="btnConfirm"><i class="fa fa-check"></i> Submit</button>
               </div>
               <br>
               <br>
               </center>
          </div>
        </div>
      </div>
    </div>
 </div>
 </section>
<!-- <script type="text/javascript">
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
Load the API from the specified URL
    * The async attribute allows the browser to render the page while the API loads
    * The key parameter will contain your own API key (which is not needed for this tutorial)
    * The callback parameter executes the initMap() function
    -->
<!-- <script async defer src="https://maps.googleapis.com/maps/api/js?key=&callback=initMap">
</script> -->
