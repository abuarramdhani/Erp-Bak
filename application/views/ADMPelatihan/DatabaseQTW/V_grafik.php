<section class="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <div class="col-lg-11 text-right"><h1>Grafik Database QTW</h1></div>
                <div class="col-lg-1" style="margin-top: 10px;"><span class="fa fa-3x fa-bar-chart"></span></div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-solid box-primary">
                            <div class="box-header">
                                <div class="col-lg-1">
                                    <label for="">Tahun :</label>
                                </div>
                                <div class="col-lg-2">
                                    <input type="text" class="form-control" id="paramGrafik" value="<?= date('Y')?>">
                                </div>
                                <div class="col-lg-1">
                                    <button class="btn btn-info" id="findGrafikQtw"><span class="fa fa-search">&emsp;Find</span></button>
                                </div>
                                <div class="btn-group pull-right" style="padding-right: 10px;">
                                    <button class="btn btn-info" onclick="javascript:showFullscreen();"><i style="margin-right: 8px;" class="fa fa-desktop"></i>Show in Fullscreen</button>
                                    <button class="btn btn-success" onclick="javascript:save(<?= date('Y')?>);"><i id="btn-save-qtw" style="margin-right: 8px;" class="fa fa-floppy-o"></i>Save</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="box-body" id="box-qtw">
                                        <div class="col-lg-12 chart">
                                            <center><h3 class="gantiTahun" style="font-family: helvetica"><u><b>GRAFIK DATABASE QTW TAHUN <?= date('Y')?></b></u></h3></center>
                                            <canvas id="areaChart" style="padding-top: 15px;"></canvas>
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

<!-- Modal -->
<div id="detailGrafikQTW" class="modal fade" role="dialog">
  <div class="modal-dialog" style="width: 90%;">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Detail Rekap Bulanan Database QTW</h4>
      </div>
      <div class="modal-body">
        <table id="detailQtw" class="table table-striped table-bordered table-hovered">
        	<thead>
        		<tr id="rowQtw">
        			<th>No</th>
        			<th>Tanggal</th>
        			<th>Waktu</th>
        			<th>Instansi</th>
        			<th>Tujuan</th>
        			<th>PIC Quick</th>
        			<th>PIC Peserta</th>
        			<th>Jumlah Pendamping</th>
        			<th>Jumlah Peserta</th>
        		</tr>
        	</thead>
        	<tbody id="bodyTab_QTW">
        		
        	</tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<script>

const save = async (tahun) => {
  const element = document.getElementById('box-qtw');
  const buttonSave = document.getElementById('btn-save-qtw');
  let title = 'Grafik Database QTW Tahun ' + tahun;
  loading.showInButton(buttonSave, 'fa-floppy-o');
  html2canvas(element, {
    scale: 1,
    height: 600
  }).then((canvas) => {
    setTimeout(_ => {
      let doc = new jsPDF('L', 'mm', 'a4'),
      margins = {
        bottom: 90
      }
      doc.addImage(canvas.toDataURL('image/jpeg'), 'JPEG', 20, 10, 280, 160)
      doc.save(title + '.pdf', {
        returnPromise: true
      }, margins).then(_ => {
        setTimeout(_ => {
          loading.hideInButton(buttonSave, 'fa-floppy-o');
        }, 2500);
      });
    }, 500);
  });
};
</script>