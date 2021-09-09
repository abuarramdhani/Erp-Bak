<div>
  <b id="atas"></b>
</div>
<div id="loading">Sedang Memuat Data...</div>
<div class="table-responsive">
  <table class="table table-striped table-bordered table-hover text-left dataTable-MGC" style="font-size:11px;">
    <thead>
      <tr class="bg-info">
        <th class="text-center">NO</th>
        <th class="text-center">KODE</th>
        <th class="text-center">DESKRIPSI ITEM</th>
        <th class="text-center">MIN STOCK</th>
        <th class="text-center">MAX STOCK</th>
        <th class="text-center">STOCK</th>
        <th class="text-center">KEBUTUHAN SESUAI MPS</th>
        <th class="text-center">OUT</th>
        <th class="text-center">IN</th>
        <th class="text-center">OUTSTANDING PP</th>
        <th class="text-center">OUTSTANDING PO</th>
        <th class="text-center" hidden></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($get as $key => $g): ?>
        <tr>
          <td style="text-align:center"><?php echo $key+1 ?></td>
          <td style="text-align:center"><?php echo $g['KODE'] ?></td>
          <td style="text-align:center"><?php echo $g['DESCRIPTION'] ?></td>
          <td style="text-align:center"><?php echo $g['MIN_STOK'] ?></td>
          <td style="text-align:center"><?php echo $g['MAX_STOK'] ?></td>
          <td style="text-align:center"><?php echo $g['STOK'] ?></td>
          <td style="text-align:center" id="pod_<?php echo $g['INVENTORY_ITEM_ID'] ?>"></td>
          <td style="text-align:center" id="out_<?php echo $g['INVENTORY_ITEM_ID'] ?>"></td>
          <td style="text-align:center" id="in_<?php echo $g['INVENTORY_ITEM_ID'] ?>"></td>
          <td style="text-align:center"><?php echo $g['OUTSTANDING_PP'] ?></td>
          <td style="text-align:center"><?php echo $g['OUTSTANDING_PO'] ?></td>
          <td style="text-align:center" hidden class="inv_id"><?php echo $g['INVENTORY_ITEM_ID'] ?></td>
        </tr>
      <?php endforeach;?>
    </tbody>
  </table>
  </div>
  <script type="text/javascript">
  $('.dataTable-MGC').DataTable( {
    // "pagingType": "scrolling";
    paging: false,
    scrollY: 300,
    // scroller: true,
    // deferRender: true
  });

  let tampung = [];

  $(document).ready(function () {
    let plan_id =  <?php echo $plan ?>;
    function syncFunction (item, cb, id) {
      // Get pod
      pod = $.ajax({
          url: baseurl + 'MonitoringGudangCustomable/Monitoring/getpod',
          type: 'POST',
          dataType: 'JSON',
          data: {
            plan_id : plan_id,
            organization_id : 102,
            inventory_item_id : item
          },
          cache:false,
          beforeSend: function() {
            // swalLoadingMGC('Sedang Memproses Data...');
            // $('.load').html(`<div>Sedang memuat data...</div>`);
          },
          success: function(result) {
            // console.log(item);
            // console.log(tampung);
            $(`#pod_${item}`).text(result.POD);
            // if (tampung[(tampung.length)-1] == item) {
            // $('#loading').text("Data Selesai Dimuat");
            // }
            cb();
          },
          error: function(XMLHttpRequest, textStatus, errorThrown) {
          // swalMGCLarge('error', textStatus)
           console.error();
          }
        })

        // Get out
        aktual_out = $.ajax({
            url: baseurl + 'MonitoringGudangCustomable/Monitoring/getout',
            type: 'POST',
            dataType: 'JSON',
            data: {
              organization_id : 102,
              inventory_item_id : item
            },
            cache:false,
            beforeSend: function() {
              // swalLoadingCKMB('Sedang Memproses Data...');

            },
            success: function(result) {
              // console.log(result);
              $(`#out_${item}`).text(result.AKTUAL_OUT);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
            // swalMGCLarge('error', textStatus)
             console.error();
            }
          })

        // Get in
        aktual_in = $.ajax({
          url: baseurl + 'MonitoringGudangCustomable/Monitoring/getin',
          type: 'POST',
          dataType: 'JSON',
          data: {
            organization_id : 102,
            inventory_item_id : item
          },
          cache : false,
          beforeSend: function(){

          },
          success: function(result){
            // console.log(result);
            $(`#in_${item}`).text(result.AKTUAL_IN);
          },
          error: function(XMLHttpRequest, textStatus, errorThrown){
            console.error();
          }
        })
  }

    $('.inv_id').each((i,v)=>{
      tampung.push($(v).text());
    })
    let requests = tampung.reduce((promiseChain, item, i) => {
      return promiseChain.then(() => new Promise((resolve) => {
        syncFunction(item, resolve, i);
      }));
  }, Promise.resolve());

  requests.then(() => console.log('done'))
  requests.then(() => $('#loading').text("Data Selesai Dimuat"))

  // document.getElementById("atas").innerHTML="Menampilkan Data "+document.getElementById("planid").text;
  $('#atas').text("Menampilkan Data "+ $('#planid option:selected').text());
  })

  // $(document).ready(function () {
  //   let plan_id =  <?php echo $plan ?>;
  //   $('.inv_id').each((i,v)=>{
  //     let inv_id = $(v).text();

    // })
  //
  // })
  //
  // $(document).ready(function () {
  //   let plan_id =  <?php echo $plan ?>;
  //   $('.inv_id').each((i,v)=>{
  //     let inv_id = $(v).text();
  //     console.log(inv_id);

  //   })
  //
  // })
  //
  // $(document).ready(function(){
  //   let plan_id = <?php echo $plan ?>;
  //   $('.inv_id').each((i,v)=>{
  //     let inv_id = $(v).text();
  //     console.log(inv_id);

  //   })
  // })
    // console.log(planid);
  </script>
