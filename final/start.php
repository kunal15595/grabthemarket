<!DOCTYPE html>
<html style="background-color: #111111; background-image: url(../images/pattern_40.gif);">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <script type="text/javascript" src= "news/news.js"></script>
    <script type="text/javascript" src= "../js/jq.js"></script>
    <script type="text/javascript" src= "js/common.js"></script>
</head>
<body>
    <?php 
        session_start();
        $_SESSION['game_visit'] = microtime(true)*1000*10000;
        $_SESSION['game_start'] = $_SESSION['game_visit'] + 5*60*1000*10000;
        $_SESSION['game_stop'] = $_SESSION['game_visit'] + 25*60*1000*10000;
        
        $_SESSION['net_credit'] = 5000;
        $_SESSION['net_profit'] = 0;
        $_SESSION['status'] = 'visit';
        $_SESSION['bonus_count'] = 0;
        
        $_SESSION['growlmessage'] = 'hello !';
        $_SESSION['growlpending'] = 'true';
        
    ?>
    
    <script type="text/javascript">
        
        var ns = [];
        for (var i = 0; i < (news.list).length; i++) {
            ns.push(news.list[i].txt);
        }
        
        var list = {
            "companies": [
                {"name": '', "show": '', "id": '0'},
                {"name": 'ARTL', "show": 'Airtel', "id": '3'},
                {"name": 'CIPLA', "show": 'Cipla', "id": '5'},
                {"name": 'DLF', "show": 'DLF', "id": '7'},
                {"name": 'INFY', "show": 'Infosys', "id": '12'},
                {"name": 'ONGC', "show": 'ONGC', "id": '13'},
                {"name": 'NTPC', "show": 'NTPC', "id": '14'},
                {"name": 'HDB', "show": 'HDFC Bank', "id": '2'},
                {"name": 'TCS', "show": 'TCS', "id": '21'},
                {"name": 'RIL', "show": 'Reliance', "id": '16'},
                {"name": 'SI', "show": 'Siemens', "id": '15'},
                {"name": 'RAN', "show": 'Ranbaxy', "id": '9'},
                {"name": 'SAIL', "show": 'SAIL', "id": '10'},
                {"name": 'IB', "show": 'Indiabulls', "id": '4'},
                {"name": 'VOD', "show": 'Vodafone', "id": '18'},
                {"name": 'HMC', "show": 'Hero Honda', "id": '6'},
                {"name": 'AC', "show": 'Ambuja Cement', "id": '11'},
                {"name": 'NES', "show": 'Nestle', "id": '17'},
                {"name": 'IBN', "show": 'ICICI Bank', "id": '8'},
                {"name": 'LT', "show": 'Larsen & Toubro', "id": '1'},
                {"name": 'WIT', "show": 'Wipro', "id": '20'},
                {"name": 'TTM', "show": 'Tata', "id": '19'}
                
            ]
        };
        
        var compare = [
            {"selected": false}, {"selected": false}, {"selected": false},
            {"selected": false}, {"selected": false}, {"selected": false},
            {"selected": false}, {"selected": false}, {"selected": false}, 
            {"selected": false}, {"selected": false}, {"selected": false}, 
            {"selected": false}, {"selected": false}, {"selected": false},
            {"selected": false}, {"selected": false}, {"selected": false}, 
            {"selected": false}, {"selected": false}, {"selected": false}
        ];
        var now = (new Date()).getTime();

        sessionStorage.list = JSON.stringify(list);
        sessionStorage.compare = JSON.stringify(compare);
        sessionStorage.bonus = JSON.stringify([]);
        sessionStorage.bonus_submitted = JSON.stringify({"submitted": false, "count": 0});
        sessionStorage.game = JSON.stringify({"game_visit": now, "game_start": now + 5*60*1000,"game_stop": now + 25*60*1000});
        sessionStorage.money = JSON.stringify({"credit": 5000, "profit": 0});
        sessionStorage.growl = JSON.stringify({"pending": true,"message": 'Hello !&nbsp;&nbsp;&nbsp;&nbsp;Market opens in 5 min.' });
        sessionStorage.stat = JSON.stringify({"status": 'visit'});
        sessionStorage.timeline = JSON.stringify([]);
        sessionStorage.portfolio = JSON.stringify([]);
        sessionStorage.news = JSON.stringify(ns);
        sessionStorage.active_news = JSON.stringify([ns[Math.floor(Math.random()*ns.length)], ns[Math.floor(Math.random()*ns.length)]]);
        var shares = [];
        for (var i = list.companies.length - 1; i > 0; i--) {
            shares.push({"company": list.companies[i].name, "price": parseFloat(past_price(list.companies[i].name)), "quantity": Math.round((Math.random() * 1000)/past_price(list.companies[i].name)), "tag": 'buy', "id": list.companies[i].id});
        }
        sessionStorage.shares = JSON.stringify(shares);
        // console.log(shares);
        window.location = 'index.php';
    </script>

</body>
</html>