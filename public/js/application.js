function fetchJSONFile(path, callback) {
    var httpRequest = new XMLHttpRequest();
    httpRequest.onreadystatechange = function() {
        if (httpRequest.readyState === 4) {
            if (httpRequest.status === 200) {
                var data = JSON.parse(httpRequest.responseText);
                if (callback) callback(data);
            }
        }
    };
    httpRequest.open('GET', path);
    httpRequest.send(); 
}

function loadChart(chart) {
    origData = [];
    lineData = [];
    currentChart = chart;
    fetchJSONFile('data/'+chart+'.json', function(data){
        window.origData = data;
        lineData = JSON.parse(JSON.stringify(data));
        lineData['labels'] = lineData['labels'].slice(-20);
        lineData['datasets'][0].data = lineData['datasets'][0].data.slice(-20);
        if (lineData['datasets'][1]) {
            lineData['datasets'][1].data = lineData['datasets'][1].data.slice(-20);
        }
        if (lineData['datasets'][2]) {
            lineData['datasets'][2].data = lineData['datasets'][2].data.slice(-20);
        }
        ctx = document.getElementById("canvas").getContext("2d");
        window.chart = new Chart(ctx).Line(lineData, {
            responsive: true,
            datasetFill: false
        });
    });
}

function showOlder() {
    lineSize = chart.scale.xLabels.length;
    lineData['labels'] = origData.labels.slice(-10 - lineSize, -lineSize).concat(lineData['labels']);
    lineData['datasets'][0].data = origData.datasets[0].data.slice(-10 - lineSize, -lineSize).concat(lineData['datasets'][0].data);
    if (lineData['datasets'][1]) {
        lineData['datasets'][1].data = origData.datasets[1].data.slice(-10 - lineSize, -lineSize).concat(lineData['datasets'][1].data);
    }
    if (lineData['datasets'][2]) {
        lineData['datasets'][2].data = origData.datasets[2].data.slice(-10 - lineSize, -lineSize).concat(lineData['datasets'][2].data);
    }

    chart.destroy();
    ctx = document.getElementById("canvas").getContext("2d");
    window.chart = new Chart(ctx).Line(lineData, {
        responsive: true,
        animation: false,
        datasetFill: false
    });
}

function chartChange() {
    var select = document.getElementById('charttype');
    var selection = select.options[select.selectedIndex].value;

    chart.destroy();

    switch (selection) {
    case 'windstrength':
        loadChart('windstrength');
        break;
    case 'winddirection':
        loadChart('winddirection');
        break;
    case 'temperature':
        loadChart('temperature');
        break;
    case 'humidity':
        loadChart('humidity');
        break;
    case 'brightness':
        loadChart('brightness');
        break;
    case 'pressure':
        loadChart('pressure');
        break;
    default:
        alert('Invalid selection');
    }
}

// this requests the file and executes a callback with the parsed result once
//   it is available
window.onload = function(){

    loadChart('windstrength');

    document.getElementById('older').onclick = showOlder;
    document.getElementById('charttype').onchange = chartChange;
}

