<style>
  #excelButton {
    margin-bottom: 5px;
  }

  th,
  td {
    font: 13px Verdana;
  }

  .swal-small {
    max-width: 200px;
  }

  #tableTotalPekerjaPeriodeSatuBulan_length {
    float: left;
    width: 200px;
  }

  #tableTotalPekerjaPeriodeSatuBulan_filter {
    float: right;
    width: 500px;
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
        <h1>Rekap Data Kaizen - Total Pekerja - Periode 1 Bulan</h1>
      </div>
    </div>
    <div class="panel-body col-12">
      <div class="form-group form-inline" style="width: 100%;">
        <label>Bulan:</label>
        <div class="input-group date" style="width: 20%;margin-right:10px;">
          <div class="input-group-addon">
            <i class="fa fa-calendar"></i>
          </div>
          <input type="text" class="form-control pull-right" value="<?= date('Y-m') ?>" id="yearMonthPicker">
        </div>
        <button class="btn btn-primary btn-md" id="btnCariTotalPekerjaPerSatuBulan">CARI</button>
      </div>
      <div>
        <button class="btn btn-success btn-md" id="excelButton">
          <i class="fa fa-file-excel-o"></i>
          EXCEL
        </button>
      </div>
      <table id="tableTotalPekerjaPeriodeSatuBulan" class="table table-bordered table-striped" cellspacing="0" width="100%">
        <thead class="bg-primary">
          <tr>
            <th style="width: 5%;" class="bg-primary" rowspan="2">No</th>
            <th style="width: 30%;" class="bg-primary" rowspan="2">Seksi</th>
            <th style="width: 30%;" class="bg-primary" rowspan="2">Unit</th>
            <th colspan="32" id="judulBulan"></th>
          </tr>
          <tr>
            <?php for ($x = 1; $x <= 31; $x++) {
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

    const currentYearMonthDate = moment().format('YYYY-MM-DD');
    const getDateMonthValue = () => {
      const date = $('#yearMonthPicker').val()
      const [year, month] = date.split('-')

      return {
        year,
        month
      }
    }

    /**
     * @param String keyname
     * @param String Month, 01-12
     */
    const renderHoveredColumn = (keyName, dayNumber = "") => {
      return (data, type, row) => {
        const isFutureDate = moment(`${getDateMonthValue().year}-${getDateMonthValue().month}-${dayNumber}`).isAfter(currentYearMonthDate)
        if (isFutureDate) return '';

        return `
          <span data-section="${row.section_code}" data-day="${dayNumber}" data-month="${getDateMonthValue().month}" data-year="${getDateMonthValue().year}">  
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

          const day = $span.data('day')
          const month = $span.data('month')
          const year = $span.data('year')
          const section_code = $span.data('section')

          if (!year) return;

          $.ajax({
            url: baseurl + 'SystemIntegration/KaizenPekerjaTks/TeamKaizen/HoverCard/KaizenList',
            method: 'GET',
            data: {
              year,
              month,
              day,
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

    let tabelkuSatuBulan = $('#tableTotalPekerjaPeriodeSatuBulan').DataTable({
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
          render: (data, type, full, meta) => meta.row + 1
        },
        {
          data: 'section_name'
        }, {
          data: 'unit_name'
        }, {
          className: "js-hover-kaizen-detail hover-gray text-center",
          render: renderHoveredColumn('a', 1)
        }, {
          className: "js-hover-kaizen-detail hover-gray text-center",
          render: renderHoveredColumn('b', 2)
        }, {
          className: "js-hover-kaizen-detail hover-gray text-center",
          render: renderHoveredColumn('c', 3)
        }, {
          className: "js-hover-kaizen-detail hover-gray text-center",
          render: renderHoveredColumn('d', 4)
        }, {
          className: "js-hover-kaizen-detail hover-gray text-center",
          render: renderHoveredColumn('e', 5)
        }, {
          className: "js-hover-kaizen-detail hover-gray text-center",
          render: renderHoveredColumn('f', 6)
        }, {
          className: "js-hover-kaizen-detail hover-gray text-center",
          render: renderHoveredColumn('g', 7)
        }, {
          className: "js-hover-kaizen-detail hover-gray text-center",
          render: renderHoveredColumn('h', 8)
        }, {
          className: "js-hover-kaizen-detail hover-gray text-center",
          render: renderHoveredColumn('i', 9)
        }, {
          className: "js-hover-kaizen-detail hover-gray text-center",
          render: renderHoveredColumn('j', 10)
        }, {
          className: "js-hover-kaizen-detail hover-gray text-center",
          render: renderHoveredColumn('k', 11)
        }, {
          className: "js-hover-kaizen-detail hover-gray text-center",
          render: renderHoveredColumn('l', 12)
        }, {
          className: "js-hover-kaizen-detail hover-gray text-center",
          render: renderHoveredColumn('m', 13)
        }, {
          className: "js-hover-kaizen-detail hover-gray text-center",
          render: renderHoveredColumn('n', 14)
        }, {
          className: "js-hover-kaizen-detail hover-gray text-center",
          render: renderHoveredColumn('o', 15)
        }, {
          className: "js-hover-kaizen-detail hover-gray text-center",
          render: renderHoveredColumn('p', 16)
        }, {
          className: "js-hover-kaizen-detail hover-gray text-center",
          render: renderHoveredColumn('q', 17)
        }, {
          className: "js-hover-kaizen-detail hover-gray text-center",
          render: renderHoveredColumn('r', 18)
        }, {
          className: "js-hover-kaizen-detail hover-gray text-center",
          render: renderHoveredColumn('s', 19)
        }, {
          className: "js-hover-kaizen-detail hover-gray text-center",
          render: renderHoveredColumn('t', 20)
        }, {
          className: "js-hover-kaizen-detail hover-gray text-center",
          render: renderHoveredColumn('u', 21)
        }, {
          className: "js-hover-kaizen-detail hover-gray text-center",
          render: renderHoveredColumn('v', 22)
        }, {
          className: "js-hover-kaizen-detail hover-gray text-center",
          render: renderHoveredColumn('w', 23)
        }, {
          className: "js-hover-kaizen-detail hover-gray text-center",
          render: renderHoveredColumn('x', 24)
        }, {
          className: "js-hover-kaizen-detail hover-gray text-center",
          render: renderHoveredColumn('y', 25)
        }, {
          className: "js-hover-kaizen-detail hover-gray text-center",
          render: renderHoveredColumn('z', 26)
        }, {
          className: "js-hover-kaizen-detail hover-gray text-center",
          render: renderHoveredColumn('ab', 27)
        }, {
          className: "js-hover-kaizen-detail hover-gray text-center",
          render: renderHoveredColumn('cd', 28)
        }, {
          className: "js-hover-kaizen-detail hover-gray text-center",
          render: renderHoveredColumn('ef', 29)
        }, {
          className: "js-hover-kaizen-detail hover-gray text-center",
          render: renderHoveredColumn('gh', 30)
        }, {
          className: "js-hover-kaizen-detail hover-gray text-center",
          render: renderHoveredColumn('ij', 31)
        }, {
          className: "js-hover-kaizen-detail hover-gray text-center",
          render: renderHoveredColumn('total')
        }
      ],
      ajax: {
        url: baseurl + "SystemIntegration/KaizenPekerjaTks/TeamKaizen/get_data_kaizen_total_pekerja_satu_bulan",
        type: "GET",
        dataType: "JSON",
        dataSrc(json) {
          $('#judulBulan').text(json.bulan)
          return json.data
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
          url: baseurl + 'SystemIntegration/KaizenPekerjaTks/TeamKaizen/get_data_kaizen_total_pekerja_satu_bulan',
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
            date: data
          },
          success(response) {
            swal.close()
            tabelkuSatuBulan.clear()
            tabelkuSatuBulan.rows.add(response.data)
            tabelkuSatuBulan.draw()
          },
          error() {
            swal.close()
          }
        })
      }
    })

    $("#excelButton").click(function() {
      let tag = $('#judulBulan').text()
      $('<table>')
        .append(
          $("#tableTotalPekerjaPeriodeSatuBulan thead").html()
        )
        .append(
          $("#tableTotalPekerjaPeriodeSatuBulan").DataTable().$('tr').clone()
        )
        .table2excel({
          exclude: "",
          name: "casting",
          filename: `Rekap Data Kaizen Total Pekerja periode 1 bulan ${tag}.xls`
        });
    });

  })
</script>