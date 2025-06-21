
const labels =  $labels
const dataTahunLaluUP =  $dataTahunLaluUP
const dataTahunIniUP =  $dataTahunIniUP

const dataTahunLaluVOL =  $dataTahunLaluVOL
const dataTahunIniVOL =  $dataTahunIniVOL

const dataTahunLaluMAS =  $dataTahunLaluMAS
const dataTahunIniMAS =  $dataTahunIniMAS

const tahunLalu = $tahunLalu
const tahunSekarang = $tahunSekarang

new Chart(document.getElementById('barChart'), {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [
            {
                label: 'UP - ' + tahunLalu,
                data: dataTahunLaluUP,
                backgroundColor: 'rgba(255, 165, 0, 0.7)' // orange
            },
            {
                label: 'UP - ' + tahunSekarang,
                data: dataTahunIniUP,
                backgroundColor: 'rgba(255, 165, 0, 0.3)'
            },
            {
                label: 'VOL - ' + tahunLalu,
                data: dataTahunLaluVOL,
                backgroundColor: 'rgba(100, 149, 237, 0.7)' // cornflowerblue
            },
            {
                label: 'VOL - ' + tahunSekarang,
                data: dataTahunIniVOL,
                backgroundColor: 'rgba(100, 149, 237, 0.3)'
            },
            {
                label: 'MAS - ' + tahunLalu,
                data: dataTahunLaluMAS,
                backgroundColor: 'rgba(60, 179, 113, 0.7)' // mediumseagreen
            },
            {
                label: 'MAS - ' + tahunSekarang,
                data: dataTahunIniMAS,
                backgroundColor: 'rgba(60, 179, 113, 0.3)'
            }
        ]
    },
    options: {
        responsive: true,
        plugins: {
            title: {
                display: true,
                text: 'Jumlah Alat Berdasarkan Jenis per Bulan (UP / VOL / MAS)'
            },
            tooltip: {
                mode: 'index',
                intersect: false
            },
            legend: {
                position: 'bottom'
            }
        },
        scales: {
            x: {
                stacked: false
            },
            y: {
                beginAtZero: true
            }
        }
    }
})