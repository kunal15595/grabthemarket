<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	</head>
	<body>
		<div id="content"></div>
        <script type="text/javascript">
			var temp = JSON.parse(sessionStorage.list);
			var list = temp.companies;
			for (var i = 1; i < list.length; i++) {
				var item = document.createElement("div");
				item.setAttribute('class', 'list');
				item.setAttribute('id', list[i].id);
				item.setAttribute('name', list[i].name);
				item.setAttribute('show', list[i].show);
				item.appendChild(document.createTextNode(list[i].show));
				document.getElementById("content").appendChild(item);
			}
				
        </script>
	</body>
</html>
