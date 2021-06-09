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
        <h1>Rekap Data Kaizen - Kategori Kaizen - Periode 1 Tahun</h1>
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
      <div>
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
            <th class="text-center" colspan="6" id="tahunnih"></th>
          </tr>
          <tr>
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
  let mytable = null;
  $(document).ready(() => {
    const loading = baseurl + "assets/img/gif/loadingquick.gif";
    const getYear = () => $('#yearpicker').val();

    /**
     * @param String keyname
     * @param String Month, 01-12
     */
    const renderHoveredColumn = (keyName, category) => {
      return (data, type, row) => {
        return `
          <span data-section="${row.section_code}" data-category="${category}" data-year="${getYear()}">  
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
          const category = $span.data('category')
          const section_code = $span.data('section')

          if (!year) return;

          $.ajax({
            url: baseurl + 'SystemIntegration/KaizenPekerjaTks/TeamKaizen/HoverCard/KaizenList',
            method: 'GET',
            data: {
              year,
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
        render: (data, type, full, meta) => meta.row + 1
      }, {
        data: 'section_name'
      }, {
        data: 'unit_name'
      }, {
        className: 'hover-gray js-hover-kaizen-detail text-center',
        render: renderHoveredColumn('p', 'Process')
      }, {
        className: 'hover-gray js-hover-kaizen-detail text-center',
        render: renderHoveredColumn('q', 'Quality')
      }, {
        className: 'hover-gray js-hover-kaizen-detail text-center',
        render: renderHoveredColumn('h', 'Handling')
      }, {
        className: 'hover-gray js-hover-kaizen-detail text-center',
        render: renderHoveredColumn('s5', '5S')
      }, {
        className: 'hover-gray js-hover-kaizen-detail text-center',
        render: renderHoveredColumn('s', 'Safety')
      }, {
        className: 'hover-gray js-hover-kaizen-detail text-center',
        render: renderHoveredColumn('y', 'Yokoten')
      }],
      ajax: {
        url: baseurl + "SystemIntegration/KaizenPekerjaTks/TeamKaizen/get_data_kaizen_kategori_kaizen_satu_tahun",
        type: "GET",
        dataType: "JSON",
        dataSrc(response) {
          $('#tahunnih').text(response.year)
          return response.data
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
          url: baseurl + 'SystemIntegration/KaizenPekerjaTks/TeamKaizen/get_data_kaizen_kategori_kaizen_satu_tahun',
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
          filename: `Rekap Data Kaizen Kategori 1 Tahun ${gal}.xls`
        });
    });
  })
</script>