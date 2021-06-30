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

  .swal-small {
    max-width: 200px;
  }

  td.hover-gray:hover {
    background-color: #d4d4d4;
  }

  .popover.custom-hover-kaizen {
    max-width: 100% !important;
    border-radius: 10px;
  }

  .popover.custom-hover-kaizen>.popover-content {
    padding: 0;
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
          <input type="text" class="form-control pull-right" id="yearpicker" value="<?= date('Y') ?>">
        </div>
        <button class="btn btn-primary btn-md" id="btnCariTotalPekerjaPerSatuTahun">CARI</button>
      </div>
      <div>
        <button class="btn btn-success btn-md" id="excelButton">
          <i class="fa fa-file-excel-o"></i>
          EXCEL
        </button>
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
  /**
   * @param String keyname
   * @param String Month, 01-12
   */
  const renderHoveredColumn = (keyName, monthNumber) => {
    const year = $('#yearpicker').val()
    return (data, type, row) => {
      return `
          <span data-section="${row.section_code}" data-month="${monthNumber}" data-year="${year}">  
            ${row[keyName]}
          </span>
        `;
    }
  }

  const initColumnHovered = (row) => {
    let timeout;
    let popupIsActive = false;

    $(row).find('td.js-actual, td.js-plan').hover(function() {
      $this = $(this)
      let $span = $(this).find('span')
      $(this).css('cursor', 'pointer')

      timeout = setTimeout(() => {
        popupIsActive = true;

        const month = $span.data('month')
        const year = $span.data('year')
        const section_code = $span.data('section')

        if (!year) return;

        let url = '';

        if ($(this).hasClass('js-actual')) {
          url = baseurl + 'SystemIntegration/KaizenPekerjaTks/TeamKaizen/HoverCard/KaizenList'
        } else if ($(this).hasClass('js-plan')) {
          url = baseurl + 'SystemIntegration/KaizenPekerjaTks/TeamKaizen/HoverCard/EmployeeList'
        }

        $.ajax({
          url,
          method: 'GET',
          data: {
            year,
            month,
            section_code,
            withAttachment: true
          },
          dataType: 'html',
          success(response) {
            if (!popupIsActive) return;
            $this.popover({
              html: true,
              // responsive placement
              placement(context, source) {
                var position = $(source).position();

                if (position.left > 515) {
                  return "left";
                }

                if (position.left < 515) {
                  return "right";
                }

                if (position.top < 110) {
                  return "bottom";
                }

                return "top";
              },
              container: 'body',
              content: response
            })

            $this.popover('show')

            $('.popover').addClass('custom-hover-kaizen')
          },
          error() {
            $this.popover({
              content: "<span class='text-danger'>Gagal untuk mengambil data</span>"
            })

            $this.popover('show')
            $('.popover').addClass('custom-hover-kaizen')
          },
          complete() {
            //
          }
        })
      }, 500)
    }, function() {
      clearTimeout(timeout)
      const _this = this
      $(`.popover`).on('mouseleave', function() {
        $(_this).popover('hide')
      })

      setTimeout(function() {
        if (!$(`.popover:hover`).length) {
          $(_this).popover("hide");
        }
      }, 300)
      popupIsActive = false;
    })
  }

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
      // when each row is init
      createdRow(rowNode) {
        initColumnHovered(rowNode)
      },
      drawCallback(e) {},
      initComplete() {
        swal.close()
      },
      ajax: {
        url: baseurl + "SystemIntegration/KaizenPekerjaTks/TeamKaizen/get_data_kaizen_total_kaizen_satu_tahun",
        type: "GET",
        dataType: "JSON",
        beforeSend() {
          swal.fire({
            html: "<div><img style='width: 120px; height:auto;'src='" + loading + "'><br> <p>Sedang Mencari....</p></div>",
            customClass: "swal-small",
            showConfirmButton: false,
            allowOutsideClick: false
          })
        }
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
          className: "js-plan hover-gray text-center",
          render: renderHoveredColumn("plan_januari", '01')
        },
        {
          className: "js-actual hover-gray text-center",
          render: renderHoveredColumn("actual_januari", '01')
        },
        {
          data: "persen_januari",
        },
        {
          data: "plan_februari",
          className: "js-plan hover-gray text-center",
          render: renderHoveredColumn("plan_februari", '02')
        },
        {
          className: "js-actual hover-gray text-center",
          render: renderHoveredColumn("actual_februari", '02')
        },
        {
          data: "persen_februari",
        },
        {
          data: "plan_maret",
          className: "js-plan hover-gray text-center",
          render: renderHoveredColumn("plan_maret", '03')
        },
        {
          className: "js-actual hover-gray text-center",
          render: renderHoveredColumn("actual_maret", '03')
        },
        {
          data: "persen_maret",
        },
        {
          data: "plan_april",
          className: "js-plan hover-gray text-center",
          render: renderHoveredColumn("plan_april", '04')
        },
        {
          className: "js-actual hover-gray text-center",
          render: renderHoveredColumn("actual_april", '04')
        },
        {
          data: "persen_april",
        },
        {
          data: "plan_mei",
          className: "js-plan hover-gray text-center",
          render: renderHoveredColumn("plan_mei", '05')
        },
        {
          className: "js-actual hover-gray text-center",
          render: renderHoveredColumn("actual_mei", '05')
        },
        {
          data: "persen_mei",
        },
        {
          data: "plan_juni",
          className: "js-plan hover-gray text-center",
          render: renderHoveredColumn("plan_juni", '06')
        },
        {
          className: "js-actual hover-gray text-center",
          render: renderHoveredColumn("actual_juni", '06')
        },
        {
          data: "persen_juni",
        },
        {
          data: "plan_juli",
          className: "js-plan hover-gray text-center",
          render: renderHoveredColumn("plan_juli", '07')
        },
        {
          className: "js-actual hover-gray text-center",
          render: renderHoveredColumn("actual_juli", '07')
        },
        {
          data: "persen_juli",
        },
        {
          data: "plan_agustus",
          className: "js-plan hover-gray text-center",
          render: renderHoveredColumn("plan_agustus", '08')
        },
        {
          className: "js-actual hover-gray text-center",
          render: renderHoveredColumn("actual_agustus", '08')
        },
        {
          data: "persen_agustus",
        },
        {
          data: "plan_september",
          className: "js-plan hover-gray text-center",
          render: renderHoveredColumn("plan_september", '09')
        },
        {
          className: "js-actual hover-gray text-center",
          render: renderHoveredColumn("actual_september", '09')
        },
        {
          data: "persen_september",
        },
        {
          data: "plan_oktober",
          className: "js-plan hover-gray text-center",
          render: renderHoveredColumn("plan_oktober", '10')
        },
        {
          className: "js-actual hover-gray text-center",
          render: renderHoveredColumn("actual_oktober", '10')
        },
        {
          data: "persen_oktober",
        },
        {
          data: "plan_november",
          className: "js-plan hover-gray text-center",
          render: renderHoveredColumn("plan_november", '11')
        },
        {
          className: "js-actual hover-gray text-center",
          render: renderHoveredColumn("actual_november", '11')
        },
        {
          data: "persen_november",
        },
        {
          data: "plan_desember",
          className: "js-plan hover-gray text-center",
          render: renderHoveredColumn("plan_desember", '12')
        },
        {
          className: "js-actual hover-gray text-center",
          render: renderHoveredColumn("actual_desember", '12')
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
        window.ajaxRequest = $.ajax({
          method: 'GET',
          url: baseurl + 'SystemIntegration/KaizenPekerjaTks/TeamKaizen/get_data_kaizen_total_kaizen_satu_tahun',
          beforeSend: function() {
            swal.fire({
              html: "<div><img style='width: 120px; height:auto;'src='" + loading + "'><br> <p>Sedang Mencari....</p></div>",
              customClass: "swal-small",
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
          },
          error() {
            swal.close()
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