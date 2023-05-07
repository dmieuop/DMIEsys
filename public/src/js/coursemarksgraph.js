let lbs = [];
for (let i = 1; i < 101; i++) {
    lbs[i] = i;
}


var ctx1 = document.getElementById('lochart');
var lochart
var ctx2 = document.getElementById('mapchart');
var mapchart

function drawchart(type, a, b = 1.0) {
    lochart = new Chart(ctx1, {
        type: type,
        data: {
            labels: lbs,
            datasets: [{
                data: allmarks,
                fill: true,
                backgroundColor: 'rgba(255, 99, 132,' + a + ')',
                borderColor: 'rgba(255, 99, 132,' + b + ')',
                borderWidth: 1,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: false,
                    display: true,
                    // min: 1,
                    ticks: {
                        display: false
                    },
                    grid: {
                        display: false,
                        borderColor: 'black',
                        z: -1
                    }
                },
                x: {
                    ticks: {
                        display: true
                    },
                    grid: {
                        display: false,
                        borderColor: 'black',
                        z: -1,
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }

        }
    });
}

window.onload = drawchart('line', 0.5);

function changetype(type) {
    let a = 1.0
    let b = 1.0
    let ctype
    let areabtn = document.getElementById('areabtn');
    let linebtn = document.getElementById('linebtn');
    let barbtn = document.getElementById('barbtn');
    if (type == 'area') {
        areabtn.classList.add('bg-green-100', 'text-green-800', 'dark:bg-green-500', 'dark:text-black')
        areabtn.classList.remove('bg-gray-100', 'text-gray-800', 'dark:bg-gray-800', 'dark:text-gray-300')
        barbtn.classList.add('bg-gray-100', 'text-gray-800', 'dark:bg-gray-800', 'dark:text-gray-300')
        barbtn.classList.remove('bg-green-100', 'text-green-800', 'dark:bg-green-500', 'dark:text-black')
        linebtn.classList.add('bg-gray-100', 'text-gray-800', 'dark:bg-gray-800', 'dark:text-gray-300')
        linebtn.classList.remove('bg-green-100', 'text-green-800', 'dark:bg-green-500', 'dark:text-black')
        a = 0.5
        ctype = 'line'
    }
    if (type == 'bar') {
        barbtn.classList.add('bg-green-100', 'text-green-800', 'dark:bg-green-500', 'dark:text-black')
        barbtn.classList.remove('bg-gray-100', 'text-gray-800', 'dark:bg-gray-800', 'dark:text-gray-300')
        areabtn.classList.add('bg-gray-100', 'text-gray-800', 'dark:bg-gray-800', 'dark:text-gray-300')
        areabtn.classList.remove('bg-green-100', 'text-green-800', 'dark:bg-green-500', 'dark:text-black')
        linebtn.classList.add('bg-gray-100', 'text-gray-800', 'dark:bg-gray-800', 'dark:text-gray-300')
        linebtn.classList.remove('bg-green-100', 'text-green-800', 'dark:bg-green-500', 'dark:text-black')
        a = 1.0
        b = 0.0
        ctype = 'bar'
    }
    if (type == 'line') {
        areabtn.classList.remove('bg-green-100', 'text-green-800', 'dark:bg-green-500', 'dark:text-black')
        areabtn.classList.add('bg-gray-100', 'text-gray-800', 'dark:bg-gray-800', 'dark:text-gray-300')
        barbtn.classList.add('bg-gray-100', 'text-gray-800', 'dark:bg-gray-800', 'dark:text-gray-300')
        barbtn.classList.remove('bg-green-100', 'text-green-800', 'dark:bg-green-500', 'dark:text-black')
        linebtn.classList.remove('bg-gray-100', 'text-gray-800', 'dark:bg-gray-800', 'dark:text-gray-300')
        linebtn.classList.add('bg-green-100', 'text-green-800', 'dark:bg-green-500', 'dark:text-black')
        a = 0.0
        ctype = 'line'
    }
    lochart.destroy();
    drawchart(ctype, a, b)
}
// ===============================================

mapchart = new Chart(ctx2, {
    type: 'radar',
    data: {
        labels: lomaplbl,
        datasets: [{
            data: lomap,
            fill: true,
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            borderColor: 'rgb(54, 162, 235)',
            pointBackgroundColor: 'rgb(54, 162, 235)',
            pointBorderColor: '#fff',
            pointHoverBackgroundColor: '#fff',
            pointHoverBorderColor: 'rgb(54, 162, 235)'
        }]
    },
    options: {
        responsive: true,
        plugins: {
            title: {
                display: false,
            },
            legend: {
                display: false
            }
        },
        scales: {
            r: {
                beginAtZero: false,
                suggestedMin: 25,
                ticks: {
                    display: false
                },
            }
        }
    },
});
