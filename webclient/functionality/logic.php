<html>
	<script>
		var i=0;
		function change()
		{
			if(i==0)
			{
				document.getElementById("b1").src="blue.jpg";
				i++;
			}
			else
			{
				document.getElementById("b1").src="red.jpg";
				i--;
			}
		}
	</script>
	<body>
	<img id="b1" src="red.jpg" alt="Boc" height="42" width="42" style="position:absolute;TOP:200px;LEFT:300px" onclick="change()"> 
	</body>
</html>