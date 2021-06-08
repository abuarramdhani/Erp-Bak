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
          <input type="text" class="form-control pull-right" id="yearpicker" value="<?= date('Y') ?>">
        </div>
        <button class="btn btn-primary btn-md" id="CariKaizenKategoriPerSatuTahun">CARI</button>
      </div>
      <div class="text-right">
        <button class="btn btn-success btn-md" id="excelButton">
          <i class="fa fa-file-excel-o"></i>
          EXCEL
        </button>
      </div>
      <table id="tableKategoriKaizenPeriodeSatuTahun" class="table table-bordered table-striped" cellspacing="0" width="100%">
        <thead class="bg-primary">
          <tr>
            <th style="width: 5%;" class="bg-primary" rowspan="2">No</th>
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
        <tbody>

        </tbody>
      </table>
    </div>
  </div>
</section>

<script>
  $(document).ready(() => {
    const loading = baseurl + "assets/img/gif/loadingquick.gif";

    /**
     * @param String keyname
     * @param String Month, 01-12
     */
    const currentYearMonth = moment().format('YYYY-MM');
    const getYear = () => $('#yearpicker').val();
    const renderHoveredColumn = (keyName, category, month) => {

      return (data, type, row) => {
        const isFutureMonth = moment(`${getYear()}-${month}`).isAfter(currentYearMonth)
        if (isFutureMonth) return '';

        return `
          <span class="${row[keyName] > 0 && 'text-bold'}" data-section="${row.section_code}" data-category="${category}" data-year="${getYear()}" data-month="${month}">  
            ${row[keyName]}
          </span>
        `;
      }
    }

    const initColumnHovered = (row) => {
      let timeout;
      let popupIsActive = false;

      $(row).find('td.js-hover-kaizen-detail').hover(function() {
        $this = $(this)
        let $span = $(this).find('span')
        $(this).css('cursor', 'pointer')

        const class_alreadyFetched = 'already-fetched';

        // if already fetch, then show cache
        if ($this.hasClass(class_alreadyFetched)) return $this.popover('show');

        timeout = setTimeout(() => {
          popupIsActive = true;

          const year = $span.data('year')
          const month = $span.data('month')
          const category = $span.data('category')
          const section_code = $span.data('section')

          if (!year) return;

          $.ajax({
            url: baseurl + 'SystemIntegration/KaizenPekerjaTks/TeamKaizen/HoverCard/KaizenList',
            method: 'GET',
            data: {
              year,
              month,
              category,
              section_code
            },
            dataType: 'html',
            success(response) {
              if (!popupIsActive) return;
              $this.addClass(class_alreadyFetched);
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

    let tabelkuKategoriKaizen = $("#tableKategoriKaizenPeriodeSatuTahun").DataTable({
      dom: 'lfrtip',
      scrollCollapse: true,
      scrollX: true,
      fixedColumns: {
        leftColumns: 3
      },
      createdRow(rowNode) {
        initColumnHovered(rowNode)
      },
      columns: [{
          className: 'text-center',
          render: (data, type, full, meta) => meta.row + 1
        }, {
          data: 'section_name'
        }, {
          data: 'unit_name'
        }, {
          className: 'hover-gray js-hover-kaizen-detail text-center',
          render: renderHoveredColumn('p_jan', 'Process', '01')
        }, {
          className: 'hover-gray js-hover-kaizen-detail text-center',
          render: renderHoveredColumn('q_jan', 'Quality', '01')
        }, {
          className: 'hover-gray js-hover-kaizen-detail text-center',
          render: renderHoveredColumn('h_jan', 'Handling', '01')
        }, {
          className: 'hover-gray js-hover-kaizen-detail text-center',
          render: renderHoveredColumn('s5_jan', '5S', '01')
        }, {
          className: 'hover-gray js-hover-kaizen-detail text-center',
          render: renderHoveredColumn('s_jan', 'Safety', '01')
        }, {
          className: 'hover-gray js-hover-kaizen-detail text-center',
          render: renderHoveredColumn('y_jan', 'Yokoten', '01')
        }, {
          className: 'hover-gray js-hover-kaizen-detail text-center',
          render: renderHoveredColumn('p_feb', 'Process', '02')
        }, {
          className: 'hover-gray js-hover-kaizen-detail text-center',
          render: renderHoveredColumn('q_feb', 'Quality', '02')
        }, {
          className: 'hover-gray js-hover-kaizen-detail text-center',
          render: renderHoveredColumn('h_feb', 'Handling', '02')
        }, {
          className: 'hover-gray js-hover-kaizen-detail text-center',
          render: renderHoveredColumn('s5_feb', '5S', '02')
        }, {
          className: 'hover-gray js-hover-kaizen-detail text-center',
          render: renderHoveredColumn('s_feb', 'Safety', '02')
        }, {
          className: 'hover-gray js-hover-kaizen-detail text-center',
          render: renderHoveredColumn('y_feb', 'Yokoten', '02')
        }, {
          className: 'hover-gray js-hover-kaizen-detail text-center',
          render: renderHoveredColumn('p_mar', 'Process', '03')
        }, {
          className: 'hover-gray js-hover-kaizen-detail text-center',
          render: renderHoveredColumn('q_mar', 'Quality', '03')
        }, {
          className: 'hover-gray js-hover-kaizen-detail text-center',
          render: renderHoveredColumn('h_mar', 'Handling', '03')
        }, {
          className: 'hover-gray js-hover-kaizen-detail text-center',
          render: renderHoveredColumn('s5_mar', '5S', '03')
        }, {
          className: 'hover-gray js-hover-kaizen-detail text-center',
          render: renderHoveredColumn('s_mar', 'Safety', '03')
        }, {
          className: 'hover-gray js-hover-kaizen-detail text-center',
          render: renderHoveredColumn('y_mar', 'Yokoten', '03')
        }, {
          className: 'hover-gray js-hover-kaizen-detail text-center',
          render: renderHoveredColumn('p_apr', 'Process', '04')
        }, {
          className: 'hover-gray js-hover-kaizen-detail text-center',
          render: renderHoveredColumn('q_apr', 'Quality', '04')
        }, {
          className: 'hover-gray js-hover-kaizen-detail text-center',
          render: renderHoveredColumn('h_apr', 'Handling', '04')
        }, {
          className: 'hover-gray js-hover-kaizen-detail text-center',
          render: renderHoveredColumn('s5_apr', '5S', '04')
        },
        {
          className: 'hover-gray js-hover-kaizen-detail text-center',
          render: renderHoveredColumn('s_apr', 'Safety', '04')
        },
        {
          className: 'hover-gray js-hover-kaizen-detail text-center',
          render: renderHoveredColumn('y_apr', 'Yokoten', '04')
        },
        {
          className: 'hover-gray js-hover-kaizen-detail text-center',
          render: renderHoveredColumn('p_mei', 'Process', '05')
        },
        {
          className: 'hover-gray js-hover-kaizen-detail text-center',
          render: renderHoveredColumn('q_mei', 'Quality', '05')
        },
        {
          className: 'hover-gray js-hover-kaizen-detail text-center',
          render: renderHoveredColumn('h_mei', 'Handling', '05')
        },
        {
          className: 'hover-gray js-hover-kaizen-detail text-center',
          render: renderHoveredColumn('s5_mei', '5S', '05')
        },
        {
          className: 'hover-gray js-hover-kaizen-detail text-center',
          render: renderHoveredColumn('s_mei', 'Safety', '05')
        },
        {
          className: 'hover-gray js-hover-kaizen-detail text-center',
          render: renderHoveredColumn('y_mei', 'Yokoten', '05')
        },
        {
          className: 'hover-gray js-hover-kaizen-detail text-center',
          render: renderHoveredColumn('p_jun', 'Process', '06')
        },
        {
          className: 'hover-gray js-hover-kaizen-detail text-center',
          render: renderHoveredColumn('q_jun', 'Quality', '06')
        },
        {
          className: 'hover-gray js-hover-kaizen-detail text-center',
          render: renderHoveredColumn('h_jun', 'Handling', '06')
        },
        {
          className: 'hover-gray js-hover-kaizen-detail text-center',
          render: renderHoveredColumn('s5_jun', '5S', '06')
        },
        {
          className: 'hover-gray js-hover-kaizen-detail text-center',
          render: renderHoveredColumn('s_jun', 'Safety', '06')
        },
        {
          className: 'hover-gray js-hover-kaizen-detail text-center',
          render: renderHoveredColumn('y_jun', 'Yokoten', '06')
        },
        {
          className: 'hover-gray js-hover-kaizen-detail text-center',
          render: renderHoveredColumn('p_jul', 'Process', '07')
        },
        {
          className: 'hover-gray js-hover-kaizen-detail text-center',
          render: renderHoveredColumn('q_jul', 'Quality', '07')
        },
        {
          className: 'hover-gray js-hover-kaizen-detail text-center',
          render: renderHoveredColumn('h_jul', 'Handling', '07')
        },
        {
          className: 'hover-gray js-hover-kaizen-detail text-center',
          render: renderHoveredColumn('s5_jul', '5S', '07')
        },
        {
          className: 'hover-gray js-hover-kaizen-detail text-center',
          render: renderHoveredColumn('s_jul', 'Safety', '07')
        },
        {
          className: 'hover-gray js-hover-kaizen-detail text-center',
          render: renderHoveredColumn('y_jul', 'Yokoten', '07')
        },
        {
          className: 'hover-gray js-hover-kaizen-detail text-center',
          render: renderHoveredColumn('p_aug', 'Process', '08')
        },
        {
          className: 'hover-gray js-hover-kaizen-detail text-center',
          render: renderHoveredColumn('q_aug', 'Quality', '08')
        },
        {
          className: 'hover-gray js-hover-kaizen-detail text-center',
          render: renderHoveredColumn('h_aug', 'Handling', '08')
        },
        {
          className: 'hover-gray js-hover-kaizen-detail text-center',
          render: renderHoveredColumn('s5_aug', '5S', '08')
        },
        {
          className: 'hover-gray js-hover-kaizen-detail text-center',
          render: renderHoveredColumn('s_aug', 'Safety', '08')
        },
        {
          className: 'hover-gray js-hover-kaizen-detail text-center',
          render: renderHoveredColumn('y_aug', 'Yokoten', '08')
        },
        {
          className: 'hover-gray js-hover-kaizen-detail text-center',
          render: renderHoveredColumn('p_sep', 'Process', '09')
        },
        {
          className: 'hover-gray js-hover-kaizen-detail text-center',
          render: renderHoveredColumn('q_sep', 'Quality', '09')
        },
        {
          className: 'hover-gray js-hover-kaizen-detail text-center',
          render: renderHoveredColumn('h_sep', 'Handling', '09')
        },
        {
          className: 'hover-gray js-hover-kaizen-detail text-center',
          render: renderHoveredColumn('s5_sep', '5S', '09')
        },
        {
          className: 'hover-gray js-hover-kaizen-detail text-center',
          render: renderHoveredColumn('s_sep', 'Safety', '09')
        },
        {
          className: 'hover-gray js-hover-kaizen-detail text-center',
          render: renderHoveredColumn('y_sep', 'Yokoten', '09')
        },
        {
          className: 'hover-gray js-hover-kaizen-detail text-center',
          render: renderHoveredColumn('p_okt', 'Process', '10')
        },
        {
          className: 'hover-gray js-hover-kaizen-detail text-center',
          render: renderHoveredColumn('q_okt', 'Quality', '10')
        },
        {
          className: 'hover-gray js-hover-kaizen-detail text-center',
          render: renderHoveredColumn('h_okt', 'Handling', '10')
        },
        {
          className: 'hover-gray js-hover-kaizen-detail text-center',
          render: renderHoveredColumn('s5_okt', '5S', '10')
        },
        {
          className: 'hover-gray js-hover-kaizen-detail text-center',
          render: renderHoveredColumn('s_okt', 'Safety', '10')
        },
        {
          className: 'hover-gray js-hover-kaizen-detail text-center',
          render: renderHoveredColumn('y_okt', 'Yokoten', '10')
        },
        {
          className: 'hover-gray js-hover-kaizen-detail text-center',
          render: renderHoveredColumn('p_nov', 'Process', '11')
        },
        {
          className: 'hover-gray js-hover-kaizen-detail text-center',
          render: renderHoveredColumn('q_nov', 'Quality', '11')
        },
        {
          className: 'hover-gray js-hover-kaizen-detail text-center',
          render: renderHoveredColumn('h_nov', 'Handling', '11')
        },
        {
          className: 'hover-gray js-hover-kaizen-detail text-center',
          render: renderHoveredColumn('s5_nov', '5S', '11')
        },
        {
          className: 'hover-gray js-hover-kaizen-detail text-center',
          render: renderHoveredColumn('s_nov', 'Safety', '11')
        },
        {
          className: 'hover-gray js-hover-kaizen-detail text-center',
          render: renderHoveredColumn('y_nov', 'Yokoten', '11')
        },
        {
          className: 'hover-gray js-hover-kaizen-detail text-center',
          render: renderHoveredColumn('p_des', 'Process', '12')
        },
        {
          className: 'hover-gray js-hover-kaizen-detail text-center',
          render: renderHoveredColumn('q_des', 'Quality', '12')
        },
        {
          className: 'hover-gray js-hover-kaizen-detail text-center',
          render: renderHoveredColumn('h_des', 'Handling', '12')
        },
        {
          className: 'hover-gray js-hover-kaizen-detail text-center',
          render: renderHoveredColumn('s5_des', '5S', '12')
        },
        {
          className: 'hover-gray js-hover-kaizen-detail text-center',
          render: renderHoveredColumn('s_des', 'Safety', '12')
        },
        {
          className: 'hover-gray js-hover-kaizen-detail text-center',
          render: renderHoveredColumn('y_des', 'Yokoten', '12')
        }
      ],
      ajax: {
        url: baseurl + "SystemIntegration/KaizenPekerjaTks/TeamKaizen/get_data_kaizen_kategori_kaizen_bulanan",
        type: "GET",
        dataType: "JSON",
        dataSrc(response) {
          $('#tahunnih').text(response.year)
          return response.data;
        }
      },
    })

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
            $('#tahunnih').text(response.year)

            tabelkuKategoriKaizen.clear()
            tabelkuKategoriKaizen.rows.add(response.data)
            tabelkuKategoriKaizen.draw()
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