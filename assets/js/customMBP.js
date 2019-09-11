var MBPSplitURL = window.location.href.split('/')

if ( MBPSplitURL[3] == 'MonitoringBiayaProduksi' ){
    $(document).ready(function(){

    // Universal Settings
        let MBPGetDate      =  new Date(),
            MBPGetYear      = MBPGetDate.getFullYear(),
            MBPGetMonth     = MBPGetDate.getMonth() + 1,
            MBPGetDay       = MBPGetDate.getDate(),
            MBPMonth        = ('0 Januari Februari Maret April Mei Juni Juli Agustus September Oktober November Desember'),
            MBPDateMonth    = MBPMonth.split(' '),
            MBPDateLastYear = 'Januari '+ (MBPGetYear-1) +' - '+ MBPDateMonth[MBPGetMonth] +' '+ (MBPGetYear-1),
            MBPDateYearNow  = 'Januari '+ MBPGetYear +' - '+ MBPDateMonth[MBPGetMonth] +' '+ MBPGetYear

        $('.pMBPDate').html(MBPGetDay+'/'+MBPGetMonth+'/'+ MBPGetYear)

        $('.pMBPDateNow').html(MBPDateLastYear+'<br>'+MBPDateYearNow)

        $('.chartAreaWrapper').on('scroll', function () {
            $('.cnvMBPChartAxis').css('z-index','1').fadeIn()
            if ($(this).scrollLeft() < 70 ) {
                $('.cnvMBPChartAxis').css('z-index','-1').hide()
            }
        })

    // Dashboard
        if ( MBPSplitURL[3]+'/'+MBPSplitURL[4] == 'MonitoringBiayaProduksi/Dashboard' ) {
         
            AjaxGetFinanceCostDashboard()

            function AjaxGetFinanceCostDashboard() {
                Swal.fire({
                    allowOutsideClick: false,
                    title: 'Mohon menunggu',
                    html: 'Sedang memproses ...',
                    onBeforeOpen: () => {
                        Swal.showLoading()
                    },    
                })
                $.ajax({
                    type: 'post',
                    url: baseurl + 'MonitoringBiayaProduksi/Dashboard/AjaxGetFinanceCostDashboard/',
                    dataType: 'json',
                    success: function (resp) {
                        let menu  = 'dashboard',
                            width = resp.label.length*7
                        MBPChartDestroy(width)
                        MBPChart(resp.label, resp.tahun1, resp.tahun2, menu)
                        Swal.close()
                    }
                })
            }

        }
        
    // Detail
        if ( MBPSplitURL[3]+'/'+MBPSplitURL[4] == 'MonitoringBiayaProduksi/Detail' ) {

            $('.btnMBPShowChartDetail').on('click', function(){
                let GroupName      = $('option:selected', $('.slcMBPGroupName')).attr('Group'),
                    GroupNameTitle = $('.slcMBPGroupName').val()
                if( GroupName != null ){
                    $('.spnMBPGroupNameTitle').html(' GOLONGAN '+GroupNameTitle.toUpperCase())
                    $('.divMBPWarnGroup').fadeOut()
                    $('.spnMBPWarnGroup').siblings('i').attr('class','fa fa-remove')
                    $('.spnMBPWarnGroupColor').attr('class','bg-red spnMBPWarnGroupColor')
                    $('.slcMBPGroupName').select2({ disabled : true })
                    $('.btnMBPShowChartDetail').attr('disabled','disabled')
                    $('.divMBPWarnGroup').hide()
                    $('.divMBPimgLoad').fadeIn()
                    AjaxGetFinanceCostByGroupName(GroupName)
                } else {
                    $('.spnMBPWarnGroup').siblings('i').attr('class','fa fa-warning')
                    $('.spnMBPWarnGroupColor').attr('class','bg-yellow spnMBPWarnGroupColor')
                    $('.spnMBPWarnGroup').html(' Anda belum memilih golongan. ')
                    $('.divMBPWarnGroup').fadeIn()
                }
            })
            
            $('.btnMBPDetailExportExcel').on('click', function(){
                let GroupName = $('option:selected', $('.slcMBPGroupName')).attr('Group'),                
                    GroupNameTitle = $('.slcMBPGroupName').val()
                if ( GroupName != null ){
                    $(this).parent().attr('action',baseurl+'MonitoringBiayaProduksi/Detail/ExportDetailReportToExcel/'+GroupName)
                    $(this).siblings('input').attr('value',GroupNameTitle)
                    $(this).siblings('button').click()
                }else {
                    $(this).parent().removeAttr('action')
                    $('.divMBPWarnExport').fadeIn()
                    setTimeout(function() {
                        $('.divMBPWarnExport').fadeOut()
                    }, 3000)
                }
            })

            $('.btnMBPExportExcel').on('click', function(){
                let GroupName = $('option:selected', $('.slcMBPGroupName')).attr('Group'),                
                    GroupNameTitle = $('.slcMBPGroupName').val()
                if ( GroupName != null ){
                    $(this).parent().attr('action',baseurl+'MonitoringBiayaProduksi/Detail/ExportReportToExcel/'+GroupName)
                    $(this).siblings('input').attr('value',GroupNameTitle)
                    $(this).siblings('button').click()
                } else {
                    $(this).parent().removeAttr('action')
                    $('.divMBPWarnExport').fadeIn()
                    setTimeout(function() {
                        $('.divMBPWarnExport').fadeOut()
                    }, 3000)
                }
            })

            function AjaxGetFinanceCostByGroupName(GroupName) { 
                GroupNameTitle = $('.slcMBPGroupName').val()
                $.ajax({
                    type: 'post',
                    data: { 
                            GroupName : GroupName,
                        },
                    url: baseurl + 'MonitoringBiayaProduksi/Detail/AjaxGetFinanceCostByGroupName',
                    dataType: 'json',
                    success: function (resp) {
                        let menu   = 'detail',
                            tahun1 = resp.tahun1.map(Number),
                            tahun2 = resp.tahun2.map(Number),
                            totaltahun1 = tahun1.reduce(function(acc, val) { return acc + val }, 0),
                            totaltahun2 = tahun2.reduce(function(acc, val) { return acc + val }, 0)
                        $('.divMBPimgLoad').hide()
                        $('.btnMBPShowChartDetail').removeAttr('disabled','disabled')
                        $('.slcMBPGroupName').select2({ disabled : false })
                        if ( (totaltahun1+totaltahun2) > 0 ) {
                            MBPChartDestroy(width=100,height=375)
                            MBPChart(resp.label, resp.tahun1, resp.tahun2, menu)
                        } else {
                            MBPChartDestroy()
                            $('.spnMBPWarnGroup').html(' Tidak ditemukan data pada golongan "'+GroupNameTitle+'". ')
                            $('.divMBPWarnGroup').fadeIn()
                        }
                    }
                })
            }

        }

        function MBPChartDestroy(width = 100, height = 525) {
            if ( width < 100 ){
                width = 100
            }
            $('.cnvMBPChart').remove()
            $('.chartAreaWrapper2').css({'width': width+'%','height': height+'px'}).append('<canvas class="cnvMBPChart"></canvas>')
            $('.cnvMBPChartAxis').attr('height',height)
            $('.chartjs-hidden-iframe').remove()
        }

        function MBPChart(label,tahun1,tahun2,menu) {
            if ( menu != 'detail'){
                var autoSkip = false,
                    maxRot =  90,
                    minRot = 90
            } else {
                var autoSkip = false,
                    maxRot =  0,
                    minRot = 0
            }
            var MBPChart = $('.cnvMBPChart')
            var newMBPChart = new Chart(MBPChart, {
                type: 'bar',
                data: {
                    labels: label,
                    datasets: [ {
                        label: 'Tahun '+(MBPGetYear-1),
                        fill: false,
                        data: tahun1,
                        backgroundColor: '#ffffff',
                        borderColor: 'rgb(0, 0, 0)',
                        borderWidth: 1
                    },
                    
                    {
                        label: 'Tahun '+MBPGetYear,
                        fill:false,
                        data: tahun2,
                        backgroundColor: '#00bbff',
                        borderColor: 'rgb(0, 0, 0)',
                        borderWidth: 1
                    },
                    ]
                },
                options: {
                    scales: {
                        xAxes: [{
                            ticks: {
                                autoSkip: autoSkip,
                                maxRotation: maxRot,
                                minRotation: minRot,
                                callback: function(t) {
                                    if ( menu == 'dashboard' || menu == 'biaya seksi' ) {
                                        if ( t != null){
                                            t = t.slice(0,17)
                                        }
                                        return t
                                    } else if ( menu == 'detail' ) {
                                        return t
                                    }
                                },
                            }
                        }],
                        yAxes: [{
                            ticks: {
                                beginAtZero:true,
                                callback: function(value, index, values) {
                                    value = value.toString()
                                    value = value.replace('.', ',')
                                    value = value.split(/(?=(?:...)*$)/)
                                    value = value.join('.')
                                    return value
                                }
                            }
                            
                        }]
                    },
                    title: {
                        display: false,
                    },
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: {
                        onComplete: function(animation) {
                                let sourceCanvas = newMBPChart.chart.canvas,
                                    copyWidth = newMBPChart.scales['y-axis-0'].width - 10,
                                    copyHeight = newMBPChart.scales['y-axis-0'].height + newMBPChart.scales['y-axis-0'].top + 10,
                                    targetCtx = $('.cnvMBPChartAxis')[0].getContext('2d')
                                targetCtx.canvas.width = copyWidth
                                targetCtx.drawImage(sourceCanvas, 0, 0, copyWidth, copyHeight, 0, 0, copyWidth, copyHeight)
                            }
                        },
                    tooltips: {
                            callbacks: {
                                labelColor: function() {
                                    return {
                                        borderColor: 'rgb(0, 0, 0)',
                                        backgroundColor: '#ffff',
                                    }
                                },
                                title: function(t, d) {
                                    if ( menu == 'dashboard' || menu == 'biaya seksi' ){
                                       return d.labels[t[0].index]
                                    }
                                }
                            }
                        },
                    legend: {
                        display: false,
                        labels: {
                            fontColor: 'black',
                        }
                    }
                }
            })
        }
    })
}