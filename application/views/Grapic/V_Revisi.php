<style type="text/css">html, body { scroll-behavior: smooth; } tbody tr td { /* height: auto; padding-top: 18px !important; */ } thead tr th { height: auto; } .fixed-column { position: absolute; background: white; width: 100px; left: 16px; margin-bottom: 2px; } .background-red { background-color: #FF5252; color: white; } .fadeIn { -webkit-animation: fadeIn 0.5s; -moz-animation: fadeIn 0.5s; -o-animation: fadeIn 0.5s; animation: fadeIn 0.5s; } .fadeOut { -webkit-animation: fadeOut 0.5s; -moz-animation: fadeOut 0.5s; -o-animation: fadeOut 0.5s; animation: fadeOut 0.5s; } table, canvas { transition: height 350ms ease-in-out; } </style>
<section class="content inner row">
    <div class="col-lg-12">
        <div class="row text-left" style="margin-top: -12px; margin-bottom: 8px;">
            <h1 id="title" style="font-weight: bold"><?= $Title ?></h1>
        </div>
        <div class="row">
            <div class="box box-primary box-solid">
                <div class="box-body">
                    <form id="form-filter-data" method="POST" enctype="multipart/form-data" class="form-horizontal">
                        <div class="panel-body">
                            <div class="col-lg-12"  style="padding: 0;">
                                <div class="col-lg-8 text-left" style="padding: 0">
                                    <div class="col-lg-2" style="padding: 0; padding-bottom: 6px; margin-right: 16px;"><label>Status Data :</label></div>
                                    <div class="col-lg-6" style="padding: 0; font-weight: bold; color: #3C8DBC;"><?= $dataTimeStamp ?></div>
                                </div>
                                <div class="col-lg-8 text-left" style="padding: 0">
                                    <div class="col-lg-2" style="padding: 0; margin-right: 16px;"><label class="control-label">Pilih Data :</label></div>
                                    <div class="col-lg-6" style="padding: 0;">
                                        <select disabled id="select-filter-data" name="select-filter-data" class="form-control" style="width: 100%;" required>
                                            <option id="select-filter-data-loading" value="0">Memuat data...</option>
                                            <?php foreach($dataFilterList as $key => $value): ?>
                                            <option value="<?= $key ?>"><?= $value ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 text-right" style="padding: 0">
                                    <button id="button-apply-filter" class="btn btn-primary" type="submit"><i class="fa fa-search" style="margin-right: 8px;"></i>Tampilkan</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div id="content" class="animated"></div>
    </div>
</section>
<script>
    document.addEventListener("DOMContentLoaded", async _ => {
        element('#select-filter-data-loading').setHTML('Semua Data')
        element('#select-filter-data').enable()
        document.getElementById('form-filter-data').addEventListener('submit', re.getData.bind(this))
        if(window.history.replaceState) window.history.replaceState(null, null, window.location.href)
    })

    const re = {
        getData: async form => {
            form.preventDefault()
            element('#button-apply-filter').animate.showLoading();
            fetch('<?= base_url('RevisiEfisiensi/getData') ?>', {
                method: 'POST',
                body: new FormData(form.target)
            }).then(response => response.json()).then(response => {
                if(response.view.isNotNullOrEmpty()) {
                    element('#content').animate.css('fadeOut', async _ =>{
                        await element('#content').setHTML(response.view)
                        await re.setTotal(response.titleList, response.monthList, true)
                        await re.setChart(response.titleList, response.monthList)
                        element('#content').animate.css('fadeIn', _ => {
                            element('#button-apply-filter').animate.hideLoading('fa-search')
                        })
                    })
                } else {
                    console.error('response.view is null & empty!')
                    $.toaster('Terjadi kesalahan saat memuat data', '', 'danger')
                    element('#button-apply-filter').animate.hideLoading('fa-search')
                }
            }).catch(e => {
                console.error(e)
                $.toaster('Terjadi kesalahan saat memuat data', '', 'danger')
                element('#button-apply-filter').animate.hideLoading('fa-search')
            })
        },

        exportPDF: async (buttonId, fileName, contentId, chartTitleId = null, chartId = null) => {
            try {
                element('#' + buttonId).animate.showLoading()
                element('#button-apply-filter').disable()
                const formData = new FormData()
                formData.append('fileName', fileName.replace('.pdf', ''))
                formData.append('content', element('#' + contentId).getHTML())
                new Promise(async resolve => {
                    if(chartTitleId && chartId) {
                        let i = 0, j = 0;
                        chartTitles = []
                        await chartTitleId.forEach(title => { chartTitles[i++] = element('#' + title).getHTML() })
                        formData.append('chartTitles', JSON.stringify(chartTitles))
                        chartBlobs = []
                        await chartId.forEach(async chart => { chartBlobs[j++] = await re.getCanvasBlob(chart) })
                        formData.append('chartBlobs', JSON.stringify(chartBlobs))
                    }
                    resolve()
                }).then( _ => {
                    fetch('<?= base_url('RevisiEfisiensi/exportPDF') ?>', {
                        method: 'POST',
                        body: formData
                    }).then(response => response.json()).then(response => {
                        if(response.filePath.isNotNullOrEmpty()) {
                            const a = document.createElement('a')
                            a.style.display = 'none'
                            a.href = response.filePath
                            a.download = response.fileName
                            document.body.appendChild(a)
                            a.click()
                        } else {
                            console.error('response.filePath is null & empty!')
                            $.toaster('Terjadi kesalahan saat menyimpan PDF', '', 'danger')
                        }
                        setTimeout( _ => {
                            element('#' + buttonId).animate.hideLoading('fa-floppy-o')
                            element('#button-apply-filter').enable()
                        }, 1000)
                    }).catch(e => {
                        console.error(e)
                        $.toaster('Terjadi kesalahan saat menyimpan PDF', '', 'danger')
                        element('#' + buttonId).animate.hideLoading('fa-floppy-o')
                        element('#button-apply-filter').enable()
                    })
                }).catch(e => {
                    console.error(e)
                    $.toaster('Terjadi kesalahan saat memproses grafik PDF', '', 'danger')
                    element('#' + buttonId).animate.hideLoading('fa-floppy-o')
                    element('#button-apply-filter').enable()
                })
            } catch(e) {
                console.error(e)
                $.toaster('Terjadi kesalahan saat menyimpan PDF', '', 'danger')
                element('#' + buttonId).animate.hideLoading('fa-floppy-o')
                element('#button-apply-filter').enable()
            }
        },

        printPDF: async (buttonId, fileName, contentId, chartTitleId = null, chartId = null) => {
            try {
                element('#' + buttonId).animate.showLoading()
                element('#button-apply-filter').disable()
                const formData = new FormData()
                formData.append('fileName', fileName.replace('.pdf', ''))
                formData.append('content', element('#' + contentId).getHTML())
                new Promise(async resolve => {
                    if(chartTitleId && chartId) {
                        let i = 0, j = 0;
                        chartTitles = []
                        await chartTitleId.forEach(title => { chartTitles[i++] = element('#' + title).getHTML() })
                        formData.append('chartTitles', JSON.stringify(chartTitles))
                        chartBlobs = []
                        await chartId.forEach(async chart => { chartBlobs[j++] = await re.getCanvasBlob(chart) })
                        formData.append('chartBlobs', JSON.stringify(chartBlobs))
                    }
                    resolve()
                }).then( _ => {
                    fetch('<?= base_url('RevisiEfisiensi/exportPDF') ?>', {
                        method: 'POST',
                        body: formData
                    }).then(response => response.json()).then(response => {
                        if(response.filePath.isNotNullOrEmpty()) {
                            printJS(response.filePath)
                        } else {
                            console.error('response.filePath is null & empty!')
                            $.toaster('Terjadi kesalahan saat mencetak dokumen', '', 'danger')
                        }
                        setTimeout( _ => {
                            element('#' + buttonId).animate.hideLoading('fa-print')
                            element('#button-apply-filter').enable()
                        }, 1000)
                    }).catch(e => {
                        console.error(e)
                        $.toaster('Terjadi kesalahan saat mencetak dokumen', '', 'danger')
                        element('#' + buttonId).animate.hideLoading('fa-print')
                        element('#button-apply-filter').enable()
                    })
                }).catch(e => {
                    console.error(e)
                    $.toaster('Terjadi kesalahan saat mencetak dokumen', '', 'danger')
                    element('#' + buttonId).animate.hideLoading('fa-print')
                    element('#button-apply-filter').enable()
                })
            } catch(e) {
                console.error(e)
                $.toaster('Terjadi kesalahan saat mencetak dokumen', '', 'danger')
                element('#' + buttonId).animate.hideLoading('fa-print')
                element('#button-apply-filter').enable()
            }
        },
        
        showFullscreen: async elementId => {
            try {
                const element = document.getElementById(elementId);
                if (element.requestFullscreen) {
                    element.requestFullscreen();
                } else if (element.mozRequestFullScreen) {
                    element.mozRequestFullScreen();
                } else if (element.webkitRequestFullscreen) {
                    element.webkitRequestFullscreen();
                } else if (element.msRequestFullscreen) {
                    element.msRequestFullscreen();
                }
            } catch(e) {
                console.error(e)
                $.toaster('Terjadi kesalahan saat memuat mode fullscreen', '', 'danger')
            }
        },

        getCanvasBlob: async canvasId => {
            const canvas = document.getElementById(canvasId)
            const newCanvas = canvas.cloneNode(true)
            let ctx = newCanvas.getContext('2d')
            ctx.fillStyle = '#ffffff'
            ctx.fillRect(0, 0, newCanvas.width, newCanvas.height)
            ctx.drawImage(canvas, 0, 0)
            return newCanvas.toDataURL('image/jpeg', 1.0)
        },

        setTotal: async (titleList, monthList, visible) => {
            if(titleList.length <= 1) return
            if(!visible) { element('#frame-total-khs-data').hide(); return }
            let totalDataAwal = 0; let totalTargetTurun = []; let totalTargetSisa = []; let totalAktualTurun = []; let totalAktualSisa = []; let calculateTotalTargetTurun = 0; let calculateTotalTargetSisa = 0; let calculateTotalAktualTurun = 0; let calculateTotalAktualSisa = 0;
            titleList.forEach(title => { document.querySelectorAll('.total-data-awal-' + title).forEach(td => { totalDataAwal += parseInt(td.innerHTML) }) })
            for(let i = 1; i < Object.keys(monthList).length; i++) {
                titleList.forEach(title => {
                    document.querySelectorAll('.total-target-turun-' + i + '-' + title).forEach(td => { calculateTotalTargetTurun += parseInt(td.innerHTML); totalTargetTurun[i - 1] = calculateTotalTargetTurun; });
                    document.querySelectorAll('.total-target-sisa-' + i + '-' + title).forEach(td => { calculateTotalTargetSisa += parseInt(td.innerHTML); totalTargetSisa[i - 1] = calculateTotalTargetSisa; });
                    document.querySelectorAll('.total-aktual-turun-' + i + '-' + title).forEach(td => { calculateTotalAktualTurun += parseInt(td.innerHTML); totalAktualTurun[i - 1] = calculateTotalAktualTurun; });
                    document.querySelectorAll('.total-aktual-sisa-' + i + '-' + title).forEach(td => { calculateTotalAktualSisa += parseInt(td.innerHTML); totalAktualSisa[i - 1] = calculateTotalAktualSisa; });
                })
                calculateTotalTargetTurun = 0; calculateTotalTargetSisa = 0; calculateTotalAktualTurun = 0; calculateTotalAktualSisa = 0;
            }
            element('#total-khs-data-awal').setHTML(totalDataAwal);
            element('#total-khs-data-awal2').setHTML(totalDataAwal);
            
            i = 0; document.querySelectorAll('.total-khs-target-turun').forEach(td => { td.innerHTML = (totalTargetTurun[i]) ? totalTargetTurun[i++] : '-'; });
            i = 0; document.querySelectorAll('.total-khs-target-sisa').forEach(td => { td.innerHTML = (totalTargetSisa[i]) ? totalTargetSisa[i++] : '-'; });
            i = 0; document.querySelectorAll('.total-khs-aktual-turun').forEach(td => { if(totalAktualTurun[i] < totalTargetTurun[i]) td.classList.add('background-red'); td.innerHTML = (totalAktualTurun[i]) ? totalAktualTurun[i++] : '-'; });
            i = 0; document.querySelectorAll('.total-khs-aktual-sisa').forEach(td => { td.innerHTML = (totalAktualSisa[i]) ? totalAktualSisa[i++] : '-'; });
            
            i = 0; document.querySelectorAll('.total-khs-target-turun2').forEach(td => { td.innerHTML = (totalTargetTurun[i]) ? totalTargetTurun[i++] : '-'; });
            i = 0; document.querySelectorAll('.total-khs-target-sisa2').forEach(td => { td.innerHTML = (totalTargetSisa[i]) ? totalTargetSisa[i++] : '-'; });
            i = 0; document.querySelectorAll('.total-khs-aktual-turun2').forEach(td => { if(totalAktualTurun[i] < totalTargetTurun[i]) td.style.cssText = 'background-color: #FF5252; color: white;'; td.innerHTML = (totalAktualTurun[i]) ? totalAktualTurun[i++] : '-'; });
            i = 0; document.querySelectorAll('.total-khs-aktual-sisa2').forEach(td => { td.innerHTML = (totalAktualSisa[i]) ? totalAktualSisa[i++] : '-'; });
        },

        setChart: async (titleList, monthList) => {
            switch(titleList.length) {
                case 1:
                    new Promise(resolve => {
                        let targetSisa1 = []; let targetSisa2 = []; let targetSisa3 = []; let targetSisa4 = []; let targetSisa5 = [];
                        let aktualSisa1 = []; let aktualSisa2 = []; let aktualSisa3 = []; let aktualSisa4 = []; let aktualSisa5 = [];
                        switch(titleList[0]) {
                            case 'Keuangan':
                            case 'Produksi':
                                i = 0; document.querySelectorAll('.row-1-target-sisa-' + titleList[0]).forEach(td => { targetSisa1[i++] = td.innerHTML; });
                                i = 0; document.querySelectorAll('.row-2-target-sisa-' + titleList[0]).forEach(td => { targetSisa2[i++] = td.innerHTML; });
                                i = 0; document.querySelectorAll('.row-3-target-sisa-' + titleList[0]).forEach(td => { targetSisa3[i++] = td.innerHTML; });
                                i = 0; document.querySelectorAll('.row-4-target-sisa-' + titleList[0]).forEach(td => { targetSisa4[i++] = td.innerHTML; });
                                i = 0; document.querySelectorAll('.row-1-aktual-sisa-' + titleList[0]).forEach(td => { aktualSisa1[i++] = td.innerHTML; });
                                i = 0; document.querySelectorAll('.row-2-aktual-sisa-' + titleList[0]).forEach(td => { aktualSisa2[i++] = td.innerHTML; });
                                i = 0; document.querySelectorAll('.row-3-aktual-sisa-' + titleList[0]).forEach(td => { aktualSisa3[i++] = td.innerHTML; });
                                i = 0; document.querySelectorAll('.row-4-aktual-sisa-' + titleList[0]).forEach(td => { aktualSisa4[i++] = td.innerHTML; });
                                var stepSize = (Number(Math.max.apply(Math, targetSisa1)) < 10) ? 'stepSize: 1' : '';
                                new Chart(element('#chart-1-' + titleList[0]).getContext('2d'), {
                                    type: 'line',
                                    data: {
                                        labels: Object.keys(monthList),
                                        datasets: [{
                                            label: 'Target Sisa',
                                            data: targetSisa1,
                                            backgroundColor: 'rgba(0, 0, 0, 0)',
                                            borderColor: 'rgba(54, 162, 225, 1)',
                                            borderWidth: 2
                                        }, {
                                            label: 'Aktual Sisa',
                                            data: aktualSisa1,
                                            backgroundColor: 'rgba(0, 0, 0, 0)',
                                            borderColor: 'rgba(251, 136, 60, 0.94)',
                                            borderWidth: 2
                                        }]
                                    },
                                    options: {
                                        responsive: true,
                                        scales: {
                                            yAxes: [{
                                                ticks: {
                                                    beginAtZero: true, stepSize,
                                                    suggestedMax: 10
                                                }
                                            }]
                                        }
                                    }
                                })
                                new Chart(element('#chart-2-' + titleList[0]).getContext('2d'), {
                                    type: 'line',
                                    data: {
                                        labels: Object.keys(monthList),
                                        datasets: [{
                                            label: 'Target Sisa',
                                            data: targetSisa2,
                                            backgroundColor: 'rgba(0, 0, 0, 0)',
                                            borderColor: 'rgba(54, 162, 225, 1)',
                                            borderWidth: 2
                                        }, {
                                            label: 'Aktual Sisa',
                                            data: aktualSisa2,
                                            backgroundColor: 'rgba(0, 0, 0, 0)',
                                            borderColor: 'rgba(251, 136, 60, 0.94)',
                                            borderWidth: 2
                                        }]
                                    },
                                    options: {
                                        responsive: true,
                                        scales: {
                                            yAxes: [{
                                                ticks: {
                                                    beginAtZero: true, stepSize,
                                                    suggestedMax: 10
                                                }
                                            }]
                                        }
                                    }
                                });
                                new Chart(element('#chart-3-' + titleList[0]).getContext('2d'), {
                                    type: 'line',
                                    data: {
                                        labels: Object.keys(monthList),
                                        datasets: [{
                                            label: 'Target Sisa',
                                            data: targetSisa3,
                                            backgroundColor: 'rgba(0, 0, 0, 0)',
                                            borderColor: 'rgba(54, 162, 225, 1)',
                                            borderWidth: 2
                                        }, {
                                            label: 'Aktual Sisa',
                                            data: aktualSisa3,
                                            backgroundColor: 'rgba(0, 0, 0, 0)',
                                            borderColor: 'rgba(251, 136, 60, 0.94)',
                                            borderWidth: 2
                                        }]
                                    },
                                    options: {
                                        responsive: true,
                                        scales: {
                                            yAxes: [{
                                                ticks: {
                                                    beginAtZero: true, stepSize,
                                                    suggestedMax: 10
                                                }
                                            }]
                                        }
                                    }
                                });
                                new Chart(element('#chart-4-' + titleList[0]).getContext('2d'), {
                                    type: 'line',
                                    data: {
                                        labels: Object.keys(monthList),
                                        datasets: [{
                                            label: 'Target Sisa',
                                            data: targetSisa4,
                                            backgroundColor: 'rgba(0, 0, 0, 0)',
                                            borderColor: 'rgba(54, 162, 225, 1)',
                                            borderWidth: 2
                                        }, {
                                            label: 'Aktual Sisa',
                                            data: aktualSisa4,
                                            backgroundColor: 'rgba(0, 0, 0, 0)',
                                            borderColor: 'rgba(251, 136, 60, 0.94)',
                                            borderWidth: 2
                                        }]
                                    },
                                    options: {
                                        responsive: true,
                                        scales: {
                                            yAxes: [{
                                                ticks: {
                                                    beginAtZero: true, stepSize,
                                                    suggestedMax: 10
                                                }
                                            }]
                                        }
                                    }
                                });
                                break;
                            case 'Pemasaran':
                            case 'Personalia':
                                var i = 0; document.querySelectorAll('.row-1-target-sisa-' + titleList[0]).forEach(td => { targetSisa1[i++] = td.innerHTML; });
                                i = 0; document.querySelectorAll('.row-2-target-sisa-' + titleList[0]).forEach(td => { targetSisa2[i++] = td.innerHTML; });
                                i = 0; document.querySelectorAll('.row-3-target-sisa-' + titleList[0]).forEach(td => { targetSisa3[i++] = td.innerHTML; });
                                i = 0; document.querySelectorAll('.row-4-target-sisa-' + titleList[0]).forEach(td => { targetSisa4[i++] = td.innerHTML; });
                                i = 0; document.querySelectorAll('.row-5-target-sisa-' + titleList[0]).forEach(td => { targetSisa5[i++] = td.innerHTML; });
                                i = 0; document.querySelectorAll('.row-1-aktual-sisa-' + titleList[0]).forEach(td => { aktualSisa1[i++] = td.innerHTML; });
                                i = 0; document.querySelectorAll('.row-2-aktual-sisa-' + titleList[0]).forEach(td => { aktualSisa2[i++] = td.innerHTML; });
                                i = 0; document.querySelectorAll('.row-3-aktual-sisa-' + titleList[0]).forEach(td => { aktualSisa3[i++] = td.innerHTML; });
                                i = 0; document.querySelectorAll('.row-4-aktual-sisa-' + titleList[0]).forEach(td => { aktualSisa4[i++] = td.innerHTML; });
                                i = 0; document.querySelectorAll('.row-5-aktual-sisa-' + titleList[0]).forEach(td => { aktualSisa5[i++] = td.innerHTML; });
                                var stepSize = (Number(Math.max.apply(Math, targetSisa1)) < 10) ? 'stepSize: 1' : '';
                                new Chart(element('#chart-1-' + titleList[0]).getContext('2d'), {
                                    type: 'line',
                                    data: {
                                        labels: Object.keys(monthList),
                                        datasets: [{
                                            label: 'Target Sisa',
                                            data: targetSisa1,
                                            backgroundColor: 'rgba(0, 0, 0, 0)',
                                            borderColor: 'rgba(54, 162, 225, 1)',
                                            borderWidth: 2
                                        }, {
                                            label: 'Aktual Sisa',
                                            data: aktualSisa1,
                                            backgroundColor: 'rgba(0, 0, 0, 0)',
                                            borderColor: 'rgba(251, 136, 60, 0.94)',
                                            borderWidth: 2
                                        }]
                                    },
                                    options: {
                                        responsive: true,
                                        scales: {
                                            yAxes: [{
                                                ticks: {
                                                    beginAtZero: true, stepSize,
                                                    suggestedMax: 10
                                                }
                                            }]
                                        }
                                    }
                                });
                                new Chart(element('#chart-2-' + titleList[0]).getContext('2d'), {
                                    type: 'line',
                                    data: {
                                        labels: Object.keys(monthList),
                                        datasets: [{
                                            label: 'Target Sisa',
                                            data: targetSisa2,
                                            backgroundColor: 'rgba(0, 0, 0, 0)',
                                            borderColor: 'rgba(54, 162, 225, 1)',
                                            borderWidth: 2
                                        }, {
                                            label: 'Aktual Sisa',
                                            data: aktualSisa2,
                                            backgroundColor: 'rgba(0, 0, 0, 0)',
                                            borderColor: 'rgba(251, 136, 60, 0.94)',
                                            borderWidth: 2
                                        }]
                                    },
                                    options: {
                                        responsive: true,
                                        scales: {
                                            yAxes: [{
                                                ticks: {
                                                    beginAtZero: true, stepSize,
                                                    suggestedMax: 10
                                                }
                                            }]
                                        }
                                    }
                                });
                                new Chart(element('#chart-3-' + titleList[0]).getContext('2d'), {
                                    type: 'line',
                                    data: {
                                        labels: Object.keys(monthList),
                                        datasets: [{
                                            label: 'Target Sisa',
                                            data: targetSisa3,
                                            backgroundColor: 'rgba(0, 0, 0, 0)',
                                            borderColor: 'rgba(54, 162, 225, 1)',
                                            borderWidth: 2
                                        }, {
                                            label: 'Aktual Sisa',
                                            data: aktualSisa3,
                                            backgroundColor: 'rgba(0, 0, 0, 0)',
                                            borderColor: 'rgba(251, 136, 60, 0.94)',
                                            borderWidth: 2
                                        }]
                                    },
                                    options: {
                                        responsive: true,
                                        scales: {
                                            yAxes: [{
                                                ticks: {
                                                    beginAtZero: true, stepSize,
                                                    suggestedMax: 10
                                                }
                                            }]
                                        }
                                    }
                                });
                                new Chart(element('#chart-4-' + titleList[0]).getContext('2d'), {
                                    type: 'line',
                                    data: {
                                        labels: Object.keys(monthList),
                                        datasets: [{
                                            label: 'Target Sisa',
                                            data: targetSisa4,
                                            backgroundColor: 'rgba(0, 0, 0, 0)',
                                            borderColor: 'rgba(54, 162, 225, 1)',
                                            borderWidth: 2
                                        }, {
                                            label: 'Aktual Sisa',
                                            data: aktualSisa4,
                                            backgroundColor: 'rgba(0, 0, 0, 0)',
                                            borderColor: 'rgba(251, 136, 60, 0.94)',
                                            borderWidth: 2
                                        }]
                                    },
                                    options: {
                                        responsive: true,
                                        scales: {
                                            yAxes: [{
                                                ticks: {
                                                    beginAtZero: true, stepSize,
                                                    suggestedMax: 10
                                                }
                                            }]
                                        }
                                    }
                                });
                                new Chart(element('#chart-5-' + titleList[0]).getContext('2d'), {
                                    type: 'line',
                                    data: {
                                        labels: Object.keys(monthList),
                                        datasets: [{
                                            label: 'Target Sisa',
                                            data: targetSisa5,
                                            backgroundColor: 'rgba(0, 0, 0, 0)',
                                            borderColor: 'rgba(54, 162, 225, 1)',
                                            borderWidth: 2
                                        }, {
                                            label: 'Aktual Sisa',
                                            data: aktualSisa5,
                                            backgroundColor: 'rgba(0, 0, 0, 0)',
                                            borderColor: 'rgba(251, 136, 60, 0.94)',
                                            borderWidth: 2
                                        }]
                                    },
                                    options: {
                                        responsive: true,
                                        scales: {
                                            yAxes: [{
                                                ticks: {
                                                    beginAtZero: true, stepSize,
                                                    suggestedMax: 10
                                                }
                                            }]
                                        }
                                    }
                                });
                                break;
                        }
                        resolve();
                    }).then( _ => {
                        element('#chart-loading-placeholder-' + titleList[0]).hide();
                        element('#chart-frame-' + titleList[0]).show();
                    }).catch(e => {
                        console.error(e);
                        element('#chart-loading-placeholder-' + titleList[0]).setColor('red').setHTML('Terjadi kesalahan saat memuat grafik');
                        $.toaster('Terjadi kesalahan saat memuat grafik', '', 'danger');
                    });
                    break;
                default:
                    titleList.forEach(title => { element('#chart-loading-placeholder-' + title).hide() })
                    break;
            }
        }
    }

    function element(selector) {
        try {
            let e;
            const object = {
                get(selector) {
                    if(e) return e;
                    return document.querySelector(selector);
                },
                getContext(type) {
                    return e.getContext(type);
                },
                setColor(color) {
                    e.style.color = color;
                    return this;
                },
                getHTML() {
                    return e.innerHTML;
                },
                setHTML(html = '') {
                    e.innerHTML = html;
                    return this;
                },
                enable() {
                    e.disabled = false;
                    return this;
                },
                disable() {
                    e.disabled = true;
                    return this;
                },
                show() {
                    e.style.display = 'block';
                    return this;
                },
                hide() {
                    e.style.display = 'none';
                    return this;
                },
                animate: {
                    css(animationName, callback) {
                        e.classList.add('animated', animationName)
                        const onAnimationEnd = _ => {
                            e.classList.remove('animated', animationName)
                            e.removeEventListener('animationend', onAnimationEnd)
                            if (typeof callback === 'function') callback()
                        }
                        e.addEventListener('animationend', onAnimationEnd)
                    },
                    showLoading() {
                        e.disabled = true;
                        e.childNodes[0].classList = '';
                        e.childNodes[0].classList.add('fa', 'fa-spin', 'fa-spinner');
                        return this;
                    },
                    hideLoading(icon) {
                        e.childNodes[0].classList = '';
                        if(icon) e.childNodes[0].classList.add('fa', icon);
                        if(!icon) e.childNodes[0].style.marginRight = '';
                        e.disabled = false;
                        return this;
                    }
                }
            }
            e = object.get(selector);
            return object;
        } catch(e) {
            console.error(e);
        }
    }

    String.prototype.isEmpty = function() { return this.toString() == ''; }

    String.prototype.isNotEmpty = function() { return this.toString() != ''; }

    String.prototype.isNull = function() { return this.toString() == null; }

    String.prototype.isNotNull = function() { return this.toString() != null; }

    String.prototype.isNullAndEmpty = function() { return this.toString() == null && this.toString() == ''; }

    String.prototype.isNullOrEmpty = function() { return this.toString() == null || this.toString() == ''; }

    String.prototype.isNotNullAndEmpty = function() { return this.toString() == null && this.toString() == ''; }

    String.prototype.isNotNullOrEmpty = function() { return this.toString() != null || this.toString() != ''; }
</script>