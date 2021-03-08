<style>
  #excelButton {
    margin-bottom: 5px;
  }

  #tableKategoriKaizenPeriodeSatuTahun_length {
    float: left;
    width: 200px;
  }

  #tableKategoriKaizenPeriodeSatuTahun_filter {
    float: right;
    width: 500px;
  }
</style>
<section class="content">
  <div class="panel panel-primary">
    <div class="panel-heading">
      <div style="display: flex; justify-content: flex-end;">
        <h1>Rekap Data Kaizen - Kategori Kaizen - Bulanan</h1>
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
        <button class="btn btn-primary btn-md" id="CariKaizenKategoriPerSatuTahun">CARI</button>
      </div>
      <div>
        <button class="btn btn-success btn-md" id="excelButton">EXCEL</button>
      </div>
      <table id="tableKategoriKaizenPeriodeSatuTahun" class="table table-bordered table-striped" cellspacing="0" width="100%">
        <thead class="bg-primary">
          <tr>
            <th style="width: 5%;" class="bg-primary" rowspan="2">No</th>
            <th style="width: 5%;" class="bg-primary" rowspan="2">Section</th>
            <th style="width: 30%;" class="bg-primary" rowspan="2">Seksi</th>
            <th style="width: 30%;" class="bg-primary" rowspan="2">Unit</th>
            <th colspan="6">Januari <span id="tahunnih"></span></th>
            <th colspan="6">Februari <span id="tahunnih"></span></th>
            <th colspan="6">Maret <span id="tahunnih"></span></th>
            <th colspan="6">April <span id="tahunnih"></span></th>
            <th colspan="6">Mei <span id="tahunnih"></span></th>
            <th colspan="6">Juni <span id="tahunnih"></span></th>
            <th colspan="6">Juli <span id="tahunnih"></span></th>
            <th colspan="6">Agustus <span id="tahunnih"></span></th>
            <th colspan="6">September <span id="tahunnih"></span></th>
            <th colspan="6">Oktober <span id="tahunnih"></span></th>
            <th colspan="6">November <span id="tahunnih"></span></th>
            <th colspan="6">Desember <span id="tahunnih"></span></th>
          </tr>
          <tr>
            <th>P</th>
            <th>Q</th>
            <th>H</th>

            <th>5S</th>
            <th>S</th>
            <th>Y</th>

            <th>P</th>
            <th>Q</th>
            <th>H</th>

            <th>5S</th>
            <th>S</th>
            <th>Y</th>

            <th>P</th>
            <th>Q</th>
            <th>H</th>

            <th>5S</th>
            <th>S</th>
            <th>Y</th>

            <th>P</th>
            <th>Q</th>
            <th>H</th>

            <th>5S</th>
            <th>S</th>
            <th>Y</th>

            <th>P</th>
            <th>Q</th>
            <th>H</th>

            <th>5S</th>
            <th>S</th>
            <th>Y</th>

            <th>P</th>
            <th>Q</th>
            <th>H</th>

            <th>5S</th>
            <th>S</th>
            <th>Y</th>

            <th>P</th>
            <th>Q</th>
            <th>H</th>

            <th>5S</th>
            <th>S</th>
            <th>Y</th>

            <th>P</th>
            <th>Q</th>
            <th>H</th>

            <th>5S</th>
            <th>S</th>
            <th>Y</th>

            <th>P</th>
            <th>Q</th>
            <th>H</th>

            <th>5S</th>
            <th>S</th>
            <th>Y</th>

            <th>P</th>
            <th>Q</th>
            <th>H</th>

            <th>5S</th>
            <th>S</th>
            <th>Y</th>

            <th>P</th>
            <th>Q</th>
            <th>H</th>

            <th>5S</th>
            <th>S</th>
            <th>Y</th>

            <th>P</th>
            <th>Q</th>
            <th>H</th>

            <th>5S</th>
            <th>S</th>
            <th>Y</th>
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
    let tabelkuKategoriKaizen = $("#tableKategoriKaizenPeriodeSatuTahun").DataTable({
      dom: 'lfrtip',
      scrollCollapse: true,
      scrollX: true,
      fixedColumns: {
        leftColumns: 3
      },
      columnDefs: [{
        targets: [1],
        visible: false,
        searchable: false
      }],
      ajax: {
        url: baseurl + "SystemIntegration/KaizenPekerjaTks/TeamKaizen/get_data_kaizen_kategori_kaizen_bulanan",
        type: "GET",
        dataType: "JSON",
        success(response) {
          $('#tahunnih').text(response.year)
          console.log(response.year)
          const mapArray = response.data.map((item, index) => {
            let it = Object.values(item)
            it.unshift(index + 1)
            return it
          })
          tabelkuKategoriKaizen.clear()
          tabelkuKategoriKaizen.rows.add(mapArray)
          tabelkuKategoriKaizen.draw()
        }
      },
    })

    mytable = tabelkuKategoriKaizen;
    $('#yearpicker').datepicker({
      autoclose: true,
      format: "yyyy",
      viewMode: "years",
      minViewMode: "years",
    })

    $('button#CariKaizenKategoriPerSatuTahun').on('click', () => {
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
          url: baseurl + 'SystemIntegration/KaizenPekerjaTks/TeamKaizen/get_data_kaizen_kategori_kaizen_bulanan',
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
            $('#tahunnih').text(response.year)
            console.log(response.year)
            const mapArray = response.data.map((item, index) => {
              let it = Object.values(item)
              it.unshift(index + 1)
              return it
            })
            tabelkuKategoriKaizen.clear()
            tabelkuKategoriKaizen.rows.add(mapArray)
            tabelkuKategoriKaizen.draw()
          }
        })
      }
    })
    $("#excelButton").click(function() {
      let tag = new Date();
      let gal = tag.getFullYear() + "-" + (tag.getMonth() + 1) + "-" + tag.getDate();
      $('<table>')
        .append(
          $("#tableKategoriKaizenPeriodeSatuTahun thead").html()
        )
        .append(
          $("#tableKategoriKaizenPeriodeSatuTahun").DataTable().$('tr').clone()
        )
        .table2excel({
          exclude: "",
          name: "casting",
          filename: `Rekap Data Kaizen Kategori Bulanan ${gal}.xls`
        });
    });
  })
</script>