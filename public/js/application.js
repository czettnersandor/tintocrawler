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

// this requests the file and executes a callback with the parsed result once
//   it is available
window.onload = function(){
        
    fetchJSONFile('data/windstrength.json', function(data){
        // do something with your data
        console.log(data);
        var ctx = document.getElementById("canvas").getContext("2d");
	    window.myLine = new Chart(ctx).Line(data, {
		    responsive: true
	    });
    });
}

