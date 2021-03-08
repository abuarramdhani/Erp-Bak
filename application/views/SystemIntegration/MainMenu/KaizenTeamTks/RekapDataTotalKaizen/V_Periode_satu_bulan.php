<style>
  #excelButton {
    margin-bottom: 5px;
  }

  th,
  td {
    font: 13px Verdana;
  }

  #tableTotalKaizenPeriodeSatuBulan_length {
    float: left;
    width: 200px;
  }

  #tableTotalKaizenPeriodeSatuBulan_filter {
    float: right;
    width: 500px;
  }
</style>
<section class="content">
  <div class="panel panel-primary">
    <div class="panel-heading">
      <div style="display: flex; justify-content: flex-end;">
        <h1>Rekap Data Kaizen - Total Pekerja - Periode 1 Bulan</h1>
      </div>
    </div>
    <div class="panel-body col-12">
      <div class="form-group form-inline" style="width: 100%;">
        <label>Tanggal:</label>
        <div class="input-group date" style="width: 20%;margin-right:10px;">
          <div class="input-group-addon">
            <i class="fa fa-calendar"></i>
          </div>
          <input type="text" class="form-control pull-right" id="yearMonthPicker">
        </div>
        <button class="btn btn-primary btn-md" id="btnCariTotalPekerjaPerSatuBulan">CARI</button>
      </div>
      <div>
        <button class="btn btn-success btn-md" id="excelButton">EXCEL</button>
      </div>
      <table id="tableTotalKaizenPeriodeSatuBulan" class="table table-bordered table-striped" cellspacing="0" width="100%">
        <thead class="bg-primary">
          <tr>
            <th style="width: 5%;" class="bg-primary" rowspan="2">No</th>
            <th style="width: 5%;" rowspan="2">section_code</th>
            <th style="width: 30%;" class="bg-primary" rowspan="2">Seksi</th>
            <th style="width: 30%;" class="bg-primary" rowspan="2">Unit</th>
            <th colspan="31" id="judulBulan"></th>
          </tr>
          <tr>
            <?php for ($x = 1; $x <= 30; $x++) {
              echo "<th>$x</th>";
            } ?>
            <th>Total</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</section>

<script>
  $(document).ready(() => {
    const loading = baseurl + "assets/img/gif/loadingquick.gif";
    let tabelkuSatuBulan = $('#tableTotalKaizenPeriodeSatuBulan').DataTable({
      dom: 'lfrtip',
      columnDefs: [{
        targets: [1],
        visible: false,
        searchable: false
      }],
      scrollCollapse: true,
      scrollX: true,
      fixedColumns: {
        leftColumns: 3
      },
      ajax: {
        url: baseurl + "SystemIntegration/KaizenPekerjaTks/TeamKaizen/get_data_kaizen_total_kaizen_satu_bulan",
        type: "GET",
        dataType: "JSON",
        success(response) {
          $('#judulBulan').text(response.bulan)
          const mapArray = response.data.map((item, index) => {
            let it = Object.values(item)
            it.unshift(index + 1)
            return it
          })
          tabelkuSatuBulan.clear()
          tabelkuSatuBulan.rows.add(mapArray)
          tabelkuSatuBulan.draw()
        }
      },
    })

    $('#yearMonthPicker').datepicker({
      autoclose: true,
      format: "yyyy-mm",
      viewMode: "months",
      minViewMode: "months"
    })

    let bulan = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember']
    $('button#btnCariTotalPekerjaPerSatuBulan').on('click', () => {
      let data = $('#yearMonthPicker').val();
      let pisah = data.split('-');
      let year = pisah[0]
      let month = parseInt(pisah[1])
      let gabung = `${bulan[month]} ${year}`
      $('#judulBulan').text(gabung)
      if (data == null || data == '') {
        return swal.fire({
          title: "Peringatan",
          text: "Anda Belum Melilih tahun",
          type: "warning",
          allowOutsideClick: false
        })
      } else {
        $.ajax({
          method: 'GET',
          url: baseurl + 'SystemIntegration/KaizenPekerjaTks/TeamKaizen/get_data_kaizen_total_kaizen_satu_bulan',
          beforeSend: function() {
            swal.fire({
              html: "<div><img style='width: 220px; height:auto;'src='" + loading + "'><br> <p>Sedang Mencari....</p></div>",
              customClass: "swal-wide",
              showConfirmButton: false,
              allowOutsideClick: false
            })
          },
          dataType: 'json',
          data: {
            date: data
          },
          success(response) {
            swal.close()
            const mapArray = response.data.map((item, index) => {
              let it = Object.values(item)
              it.unshift(index + 1)
              return it
            })
            tabelkuSatuBulan.clear()
            tabelkuSatuBulan.rows.add(mapArray)
            tabelkuSatuBulan.draw()
          }
        })
      }
    })

    $("#excelButton").click(function() {
      let tag = $('#judulBulan').text()
      $('<table>')
        .append(
          $("#tableTotalKaizenPeriodeSatuBulan thead").html()
        )
        .append(
          $("#tableTotalKaizenPeriodeSatuBulan").DataTable().$('tr').clone()
        )
        .table2excel({
          exclude: "",
          name: "casting",
          filename: `Rekap Data Kaizen Total Kaizen periode 1 bulan ${tag}.xls`
        });
    });

  })
</script>