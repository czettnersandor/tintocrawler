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

function showOlder() {
    lineSize = windLine.scale.xLabels.length;
    lineData['labels'] = origData.labels.slice(-10 - lineSize, -lineSize).concat(lineData['labels']);
    lineData['datasets'][0].data = origData['datasets'][0].data.slice(-10 - lineSize, -lineSize).concat(lineData['datasets'][0].data);
    lineData['datasets'][1].data = origData['datasets'][1].data.slice(-10 - lineSize, -lineSize).concat(lineData['datasets'][1].data);
    lineData['datasets'][2].data = origData['datasets'][2].data.slice(-10 - lineSize, -lineSize).concat(lineData['datasets'][2].data);
    
    windLine.destroy();
    ctx = document.getElementById("canvas").getContext("2d");
    window.windLine = new Chart(ctx).Line(lineData, {
        responsive: true,
        animation: false,
        datasetFill: false
    });
}

// this requests the file and executes a callback with the parsed result once
//   it is available
window.onload = function(){
        
    fetchJSONFile('data/windstrength.json', function(data){
        origData = data;
        lineData = JSON.parse(JSON.stringify(data));
        lineData['labels'] = lineData['labels'].slice(-20);
        lineData['datasets'][0].data = lineData['datasets'][0].data.slice(-20);
        lineData['datasets'][1].data = lineData['datasets'][1].data.slice(-20);
        lineData['datasets'][2].data = lineData['datasets'][2].data.slice(-20);
        ctx = document.getElementById("canvas").getContext("2d");
        window.windLine = new Chart(ctx).Line(lineData, {
            responsive: true,
            datasetFill: false
        });
    });

    document.getElementById('older').onclick = showOlder;
}

