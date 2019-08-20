var MBKSplitURL = window.location.href.split('/')

if (MBKSplitURL[3] == 'MonitoringBiayaKeuangan'){
    CustomMBK()
}

function CustomMBK() {  
    $(document).ready(function(){

        let MBKGetDate =  new Date(),
            MBKGetYear = MBKGetDate.getFullYear(),
            MBKGetMonth = MBKGetDate.getMonth() + 1,
            MBKGetDay = MBKGetDate.getDate(),
            MBKMonth = ('0 Januari Februari Maret April Mei Juni Juli Agustus September Oktober November Desember'),
            MBKDateMonth = MBKMonth.split(' '),
            MBKDateNow = '1 Januari '+(MBKGetYear-1)+' - '+MBKGetDay+' '+MBKDateMonth[MBKGetMonth]+' '+ MBKGetYear

        if (MBKSplitURL[3]+'/'+MBKSplitURL[4] == 'MonitoringBiayaKeuangan/Dashboard') {
            AjaxGetFinanceCost()
        }

        $('.pMBKDate').html(MBKGetDay+'/'+MBKGetMonth+'/'+ MBKGetYear)

        $('.pMBKDateNow').html(MBKDateNow)
        
        $('.btnMBKShowChart').on('click', function(){
            let AccName = $('.slcMBKAccountName').val(),
                AccNameTitle   = $('option:selected', $('.slcMBKAccountName')).attr('title')
            if (AccNameTitle != null){
                $('.spnMBKAccountNameTitle').html('Akun '+AccNameTitle)
            }
            if(AccName != null){
                $('.slcMBKAccountName').select2({ disabled : true })
                $('.btnMBKShowChart').attr('disabled','disabled')
                $('.divMBKWarnAccount').fadeOut()
                $('.spnMBKWarnAccount').siblings('i').attr('class','fa fa-remove')
                $('.spnMBKWarnAccountColor').attr('class','bg-red spnMBKWarnAccountColor')
                AjaxGetFinanceCostByAccountName(AccName)
            } else {
                $('.spnMBKWarnAccount').siblings('i').attr('class','fa fa-warning')
                $('.spnMBKWarnAccountColor').attr('class','bg-yellow spnMBKWarnAccountColor')
                $('.spnMBKWarnAccount').html(' Anda belum memilih akun biaya. ')
                $('.divMBKWarnAccount').fadeIn()
            }
        })

        $('.aMBKExportExcel').on('click', function(){
            let AccName = $('.slcMBKAccountName').val()
            if (AccName != null){
                $('.aMBKExportExcel').attr('href',baseurl+'MonitoringBiayaKeuangan/Detail/ExportReportToExcel/'+AccName)
            }else {
                $('.aMBKExportExcel').attr('href','#')
                $('.divMBKWarnExport').fadeIn()
                setTimeout(function() {
                    $('.divMBKWarnExport').fadeOut()
                }, 3000)
            }
        })

        $('.aMBKDetailExportExcel').on('click', function(){
            let AccName = $('.slcMBKAccountName').val()
            if (AccName != null){
                $('.aMBKDetailExportExcel').attr('href',baseurl+'MonitoringBiayaKeuangan/Detail/ExportDetailReportToExcel/'+AccName)
            }else {
                $('.aMBKDetailExportExcel').attr('href','#')
                $('.divMBKWarnExport').fadeIn()
                setTimeout(function() {
                    $('.divMBKWarnExport').fadeOut()
                }, 3000)
            }
        })

        function AjaxGetFinanceCost() { 
            $.ajax({
                type: 'post',
                url: baseurl + 'MonitoringBiayaKeuangan/Dashboard/AjaxGetFinanceCost',
                dataType: 'json',
                success: function (resp) {
                    MBKChartDashboard(resp.label, resp.tahun1, resp.tahun2)
                }
            })
        }

        function AjaxGetFinanceCostByAccountName(AccName) { 
            $('.divMBKWarnAccount').hide()
            $('.divMBKimgLoad').fadeIn()
            $.ajax({
                type: 'post',
                data: {AccName : AccName},
                url: baseurl + 'MonitoringBiayaKeuangan/Detail/AjaxGetFinanceCostByAccountName',
                dataType: 'json',
                success: function (resp) {
                    $('.divMBKimgLoad').hide()
                    let tahun1 = resp.tahun1.map(Number),
                        tahun2 = resp.tahun2.map(Number),
                        totaltahun1 = tahun1.reduce(function(acc, val) { return acc + val; }, 0),
                        totaltahun2 = tahun2.reduce(function(acc, val) { return acc + val; }, 0)
                    if ( (totaltahun1+totaltahun2) > 0 ) {
                        MBKChartDestroy()
                        MBKChartDetail(resp.label, resp.tahun1, resp.tahun2)
                        $('.btnMBKShowChart').removeAttr('disabled','disabled')
                        $('.slcMBKAccountName').select2({ disabled : false })
                    } else {
                        $('.spnMBKWarnAccount').html(' Tidak ditemukan data pada akun '+AccName+'. ')
                        $('.divMBKWarnAccount').fadeIn()
                        MBKChartDestroy()
                        $('.btnMBKShowChart').removeAttr('disabled','disabled')
                        $('.slcMBKAccountName').select2({ disabled : false })
                    }
                }
            })
        }
        
        function MBKChartDestroy() {
            $('.cnvMBKChart').remove()
            $('.divMBKChart').append('<canvas class="cnvMBKChart" style="height:350px"></canvas>')
            $('.chartjs-hidden-iframe').remove()
        }

        function MBKChartDashboard(label,tahun1,tahun2) {
            var MBKChart = $('.cnvMBKChart')
            var newMBKChart = new Chart(MBKChart, {
                type: 'bar',
                data: {
                    labels: label,
                    datasets: [ {
                        label: 'Tahun '+(MBKGetYear-1),
                        fill: false,
                        data: tahun1,
                        backgroundColor: '#ffffff',
                        borderColor: 'rgb(0, 0, 0)',
                        borderWidth: 1
                    },
                    
                    {
                        label: 'Tahun '+MBKGetYear,
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
                            callback: function(t) {
                                return t[0]
                            }
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
                        text: MBKDateNow
                    },
                    responsive: true, 
                    tooltips: {
                            callbacks: {
                                labelColor: function(tooltipItem, chart) {
                                    return {
                                        borderColor: 'rgb(0, 0, 0)',
                                        backgroundColor: '#ffff',
                                    }
                                },
                                title: function(t, d) {
                                    return d.labels[t[0].index]
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

        function MBKChartDetail(label,tahun1,tahun2) {
            MBKChartDestroy()
            var MBKChart = $('.cnvMBKChart')
            var newMBKChart = new Chart(MBKChart, {
                type: 'bar',
                data: {
                    labels: label,
                    datasets: [ {
                        label: 'Tahun '+(MBKGetYear-1),
                        fill:false,
                        legend: false,
                        data: tahun1,
                        backgroundColor: '#ffffff',
                        borderColor: 'rgb(0, 0, 0)',
                        borderWidth: 1
                    },
                    
                    {
                        label: 'Tahun '+MBKGetYear,
                        fill:false,
                        data: tahun2,
                        backgroundColor: 
                            '#00bbff'
                        ,
                        borderColor: 'rgb(0, 0, 0)',
                        borderWidth: 1
                    },
                    ]
                },
                options: {
                    scales: {
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
                        text: MBKDateNow
                    },
                    responsive: true, 
                    tooltips: {
                            callbacks: {
                                labelColor: function(tooltipItem, chart) {
                                    return {
                                        borderColor: 'rgb(0, 0, 0)',
                                        backgroundColor: '#ffff',
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