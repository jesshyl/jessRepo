<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<div id="d1" style="width:500px;height:30px;border:2px solid #004080"></div>
	<script type="text/javascript">
		var div1 = document.getElementById("d1");
		
			var received = 0;
			var xhr = new XMLHttpRequest();
			xhr.onreadystatechange = function(){
				if(xhr.readyState == 3){
					var r = xhr.responseText;
					var result = xhr.responseText.slice(received);
					received = xhr.responseText.length;
					var resultjson = JSON.parse(result);
					//console.log(resultjson['title']);
					div1.innerHTML = resultjson;
				}else if(xhr.readyState == 4){
					alert("finished");
				}

			}
			
		xhr.open("get","http.php",true);
		xhr.send(null);
	</script>
</body>
</html>