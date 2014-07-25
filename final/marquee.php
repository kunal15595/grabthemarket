<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <script src="news/ticker/jquery.newsTicker.js" type="text/javascript"></script>
        
		<script type="text/javascript" src= "news/news.js"></script>
		<link href="css/news.css" rel="stylesheet" type="text/css" />
		
	</head>
	<body>

		<div id="news_bar">
			<div id="news" class="scroll-text">
				<ul id="js-news" class="newsticker"></ul>
			</div>
		</div>
		
		<script>
			var news = JSON.parse(sessionStorage.news);
			var active_news = JSON.parse(sessionStorage.active_news);
			// console.log(active_news.length);

			setInterval(function() {
				shuffle(news);
				active_news.push(news.pop());
				sessionStorage.active_news = JSON.stringify(active_news);
				sessionStorage.news = JSON.stringify(news);
			}, 30*1000);
			
			var ul = document.getElementById("js-news");
			for (var i = 0; i < active_news.length; i++) {
				var li = document.createElement("li");
				// var a = document.createElement("a");
				// a.setAttribute('href', '#');
				// li.appendChild(a);
				// li.setAttribute('class', 'news-item');

				li.appendChild(document.createTextNode(' Market \u00A0 News \u00A0: \u00A0\u00A0\u00A0\u00A0\u00A0\u00A0\u00A0\u00A0\u00A0\u00A0'+active_news[i]));
				ul.appendChild(li);
			}

			$('#news_bar').hide();
			setTimeout(function() {
				$('#news_bar').css({height:'0px'});
				$('#news_bar').show();
				$('#news_bar').animate({height:'20px'}, 1000);
			}, 6*1000);

			$(document).ready(function () {
			    $('.newsticker').newsTicker({
			        row_height: 19,
			        max_rows: 1,
			        speed: 1000,
			        direction: 'up',
			        duration: 30*1000,
			        autostart: 1,
			        pauseOnHover: 0
			    });
			});

				
		</script>
	</body>
</html>