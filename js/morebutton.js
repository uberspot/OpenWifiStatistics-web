var from = 30;

var morebut = document.getElementById('more');

function more(event) {

	event.preventDefault();
	
	order = document.getElementById('order').value;

	xmlhttp = new XMLHttpRequest();
	
	resulttable = document.getElementById('resulttable');	
		
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			if(xmlhttp.responseText != 'ERROR') {
				var response = eval('('+xmlhttp.responseText+')');

				if(response.results.length == 0) {
					morebut.innerHTML="NO MORE";
					morebut.disabled = true;
				} else {
					var newresults = '';
					var flag=true;
					for(var i=0;i<response.results.length;i++) {
						if(flag) {
							newresults += "<tr class='bg'>";
							flag = false;
						} else {
							newresults += '<tr>';
							flag = true;
						}

						newresults+='<td>'+response.results[i].date+'</td>'+
						'<td>'+response.results[i].bssid+'</td>'+
						'<td>'+response.results[i].ssid+'</td>'+
						'<td>'+response.results[i].capabilities+'</td>'+
						'<td>'+response.results[i].frequency+'</td>'+
						'<td>'+response.results[i].power+'</td>'+
						'<td>'+response.results[i].provider+'</td></tr>';
					}
					resulttable.innerHTML = resulttable.innerHTML + newresults;
				}
			}		
		}
	}
	
	
	xmlhttp.open("GET","getresults.php?order="+order+"&from="+from+"&count=30",true);
	
	xmlhttp.send();
	
	from = from+30;
	
}



morebut.addEventListener('click',more,false);
