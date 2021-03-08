<style>
  #excelButton {
    margin-bottom: 5px;
  }

  #tableTotalKaizenPeriodeSatuTahun_length {
    float: left;
    width: 200px;
  }

  #tableTotalKaizenPeriodeSatuTahun_filter {
    float: right;
    width: 500px;
  }
</style>
<section class="content">
  <div class="panel panel-primary">
    <div class="panel-heading">
      <div style="display: flex; justify-content: flex-end;">
        <h1>Rekap Data Kaizen - Total Kaizen - Periode 1 Tahun</h1>
      </div>
    </div>
    <div class="panel-body col-12">
      <div class="form-group form-inline" style="width: 100%;">
        <label>Tahun:</label>
        <div class="input-group date" style="width: 20%;margin-right:10px;">
          <div class="input-group-addon">
            <i class="fa fa-calendar"></i>
          </div>
          <input type="text" class="form-control pull-right" id="yearpicker">
        </div>
        <button class="btn btn-primary btn-md" id="btnCariTotalPekerjaPerSatuTahun">CARI</button>
      </div>
      <div>
        <button class="btn btn-success btn-md" id="excelButton">EXCEL</button>
      </div>
      <table id="tableTotalKaizenPeriodeSatuTahun" class="table table-bordered table-striped" cellspacing="0" width="100%">
        <thead class="bg-primary">
          <tr>
            <th style="width: 5%;" class="bg-primary" rowspan="2">No</th>
            <th style="width: 30%;" class="bg-primary" rowspan="2">Seksi</th>
            <th style="width: 30%;" class="bg-primary" rowspan="2">Unit</th>
            <th colspan="3">Januari</th>
            <th colspan="3">Februari</th>
            <th colspan="3">Maret</th>
            <th colspan="3">April</th>
            <th colspan="3">Mei</th>
            <th colspan="3">Juni</th>
            <th colspan="3">Juli</th>
            <th colspan="3">Agustus</th>
            <th colspan="3">September</th>
            <th colspan="3">Oktober</th>
            <th colspan="3">November</th>
            <th colspan="3">Desember</th>
          </tr>
          <tr>
            <th>Plan</th>
            <th>Actual</th>
            <th>%</th>

            <th>Plan</th>
            <th>Actual</th>
            <th>%</th>

            <th>Plan</th>
            <th>Actual</th>
            <th>%</th>

            <th>Plan</th>
            <th>Actual</th>
            <th>%</th>

            <th>Plan</th>
            <th>Actual</th>
            <th>%</th>

            <th>Plan</th>
            <th>Actual</th>
            <th>%</th>

            <th>Plan</th>
            <th>Actual</th>
            <th>%</th>

            <th>Plan</th>
            <th>Actual</th>
            <th>%</th>

            <th>Plan</th>
            <th>Actual</th>
            <th>%</th>

            <th>Plan</th>
            <th>Actual</th>
            <th>%</th>

            <th>Plan</th>
            <th>Actual</th>
            <th>%</th>

            <th>Plan</th>
            <th>Actual</th>
            <th>%</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</section>

<script>
  let mytable = null;
  $(document).ready(() => {
    const loading = baseurl + "assets/img/gif/loadingquick.gif";
    let tabelku = $("#tableTotalKaizenPeriodeSatuTahun").DataTable({
      dom: 'lfrtip',
      scrollCollapse: true,
      scrollX: true,
      fixedColumns: {
        leftColumns: 3
      },
      ajax: {
        url: baseurl + "SystemIntegration/KaizenPekerjaTks/TeamKaizen/get_data_kaizen_total_kaizen_satu_tahun",
        type: "GET",
        dataType: "JSON",
      },
      columns: [{
          data: "no",
        },
        {
          data: "section_name",
        },
        {
          data: "unit_name",
        },
        {
          data: "plan_januari",
        },
        {
          data: "actual_januari",
        },
        {
          data: "persen_januari",
        },
        {
          data: "plan_februari",
        },
        {
          data: "actual_februari",
        },
        {
          data: "persen_februari",
        },
        {
          data: "plan_maret",
        },
        {
          data: "actual_maret",
        },
        {
          data: "persen_maret",
        },
        {
          data: "plan_april",
        },
        {
          data: "actual_april",
        },
        {
          data: "persen_april",
        },
        {
          data: "plan_mei",
        },
        {
          data: "actual_mei",
        },
        {
          data: "persen_mei",
        },
        {
          data: "plan_juni",
        },
        {
          data: "actual_juni",
        },
        {
          data: "persen_juni",
        },
        {
          data: "plan_juli",
        },
        {
          data: "actual_juli",
        },
        {
          data: "persen_juli",
        },
        {
          data: "plan_agustus",
        },
        {
          data: "actual_agustus",
        },
        {
          data: "persen_agustus",
        },
        {
          data: "plan_september",
        },
        {
          data: "actual_september",
        },
        {
          data: "persen_september",
        },
        {
          data: "plan_oktober",
        },
        {
          data: "actual_oktober",
        },
        {
          data: "persen_oktober",
        },
        {
          data: "plan_november",
        },
        {
          data: "actual_november",
        },
        {
          data: "persen_november",
        },
        {
          data: "plan_desember",
        },
        {
          data: "actual_desember",
        },
        {
          data: "persen_desember",
        },
      ],
    })

    mytable = tabelku;
    $('#yearpicker').datepicker({
      autoclose: true,
      format: "yyyy",
      viewMode: "years",
      minViewMode: "years",
    })

    $('button#btnCariTotalPekerjaPerSatuTahun').on('click', () => {
      let data = $('#yearpicker').val()
      console.log(data)
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
          url: baseurl + 'SystemIntegration/KaizenPekerjaTks/TeamKaizen/get_data_kaizen_total_kaizen_satu_tahun',
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
            year: data
          },
          success(response) {
            swal.close()
            tabelku.clear()
            tabelku.rows.add(response.data)
            tabelku.draw()
          }
        })
      }
    })
    $("#excelButton").click(function() {
      let tag = new Date();
      let gal = tag.getFullYear() + "-" + (tag.getMonth() + 1) + "-" + tag.getDate();
      $('<table>')
        .append(
          $("#tableTotalKaizenPeriodeSatuTahun thead").html()
        )
        .append(
          $("#tableTotalKaizenPeriodeSatuTahun").DataTable().$('tr').clone()
        )
        .table2excel({
          exclude: "",
          name: "casting",
          filename: `Rekap Data Kaizen Total Kaizen periode 1 Tahun ${gal}.xls`
        });
    });
  })
</script>