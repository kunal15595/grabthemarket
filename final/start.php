<!DOCTYPE html>
<html style="background-color: #111111; background-image: url(../images/pattern_40.gif);">
<head>

    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="css/progress.css">
    <link rel="stylesheet" type="text/css" href="css/load.css">
    <script type="text/javascript" src= "news/news.js"></script>
    <script type="text/javascript" src= "../js/jq.js"></script>
    <script type="text/javascript" src= "js/common.js"></script>
</head>
<body>
    <h1>Grab the market !</h1>
    <a class="triggerFull" id="instructions" href="instructions.php">Instructions</a>
    <a class="triggerFull" id="highscores" href="highscores.php">Highscores</a>
    <a class="triggerFull" id="startgame" href="#">Start Game</a>
    <div id="content">
        <span class="expand"></span>
    </div>
    <?php 
        session_start();
        $_SESSION['game_visit'] = microtime(true)*1000*10000;
        $_SESSION['game_start'] = $_SESSION['game_visit'] + 15*60*1000*10000;
        $_SESSION['game_stop'] = $_SESSION['game_visit'] + 2.5*60*60*1000*10000;
        
        $_SESSION['net_credit'] = 10*1000;
        $_SESSION['net_profit'] = 0;
        $_SESSION['status'] = 'visit';
        $_SESSION['bonus_count'] = 0;
        
        $_SESSION['growlmessage'] = 'hello !';
        $_SESSION['growlpending'] = 'true';
        
    ?>
    <script>        

        $(document).ready(function() {
            $('#content').removeClass('fullwidth');     
            $('#startgame').click(function(e) {
                e.preventDefault();
                $('#content').removeClass('fullwidth').delay(10).queue(function(next){
                    $(this).addClass('fullwidth');
                    next();
                });
                setTimeout(function() {
                window.location = 'index.php';  
                }, 1000*10);
                
                return false;
            });
        });

    </script>
    <script type="text/javascript">
        var brokers_name = ['Angel Broking', 'Investopedia', 'Motilal Oswal', 'Indus Invest', 'InvestMentor Securites',
            'Aracade Stock brokers', 'Karvy group', 'Investsmart', 'Dalmia Securities', 'SMC Group', 'Share Khan',
            'Advani Share Brokers', 'Toss financial services', 'India Infoline', 'Kotak Securities Ltd.'];

        var brokers_types = ['Average', 'Good', 'Very Good', 'Excellent', 'Average', 'Good', 'Very Good', 'Excellent'];
        var brokers_repute = [1,2,3,4,1,2,3,4];
        var companies_name = ['BHEL', 'Airtel', 'Cipla', 'NTPC', 'DLF', 'HDFC Bank', 'Infosys', 'ONGC', 'TCS', 'Reliance',
            'Sun Pharma', 'PNB', 'HPCL', 'HCL Tech.', 'Indian Oil', 'Yes Bank', 'Siemens', 'Ranbaxy', 'SAIL', 'Indiabulls',
            'Vodafone', 'Hero Honda', 'Apollo', 'TVS Motors', 'Ashok Leyland', 'Axis Bank', 'SBI','Omaxe', 'JK Tyres',
            'Dabur', 'Canara Bank', 'Eicher Motors', 'L & T', 'Nestle', 'Wipro', 'Tata Power', 'GAIL', 'Cairn', 'Air India',
            'Flipkart', 'Nivea', 'Prestige', 'Snapdeal', 'Zomato', 'Asian Paints', 'Bajaj Auto', 'Idea', 'Dr. Reddy\'s'];
        
        brokers_name = shuffle(brokers_name);
        brokers_types = shuffle(brokers_types);
        brokers_repute = shuffle(brokers_repute);
        
        companies_name = shuffle(companies_name);
        var ns = [];
        for (var i = 0; i < (news.list).length; i++) {
            ns.push(news.list[i].txt);
        }
        
        var list = {
            "companies": [
                {"name": '', "show": '', "id": 0},
                {"name": 'ARTL', "show": companies_name[1], "id": 1, "starting_price": 100},
                {"name": 'CIPLA', "show": companies_name[2], "id": 2, "starting_price": 100},
                {"name": 'DLF', "show": companies_name[3], "id": 3, "starting_price": 100},
                {"name": 'INFY', "show": companies_name[4], "id": 4, "starting_price": 100},
                {"name": 'ONGC', "show": companies_name[5], "id": 5, "starting_price": 100},
                {"name": 'NTPC', "show": companies_name[6], "id": 6, "starting_price": 100},
                {"name": 'HDB', "show": companies_name[7], "id": 7, "starting_price": 100},
                {"name": 'TCS', "show": companies_name[8], "id": 8, "starting_price": 100},
                {"name": 'RIL', "show": companies_name[9], "id": 9, "starting_price": 100},
                {"name": 'SI', "show": companies_name[10], "id": 10, "starting_price": 100},
                {"name": 'RAN', "show": companies_name[11], "id": 11, "starting_price": 100},
                {"name": 'SAIL', "show": companies_name[12], "id": 12, "starting_price": 100},
                {"name": 'IB', "show": companies_name[13], "id": 13, "starting_price": 100},
                {"name": 'VOD', "show": companies_name[14], "id": 14, "starting_price": 100},
                {"name": 'HMC', "show": companies_name[15], "id": 15, "starting_price": 100},
                {"name": 'AC', "show": companies_name[16], "id": 16, "starting_price": 100},
                {"name": 'NES', "show": companies_name[17], "id": 17, "starting_price": 100},
                {"name": 'IBN', "show": companies_name[18], "id": 18, "starting_price": 100},
                {"name": 'LT', "show": companies_name[19], "id": 19, "starting_price": 100},
                {"name": 'WIT', "show": companies_name[20], "id": 20, "starting_price": 100},
                {"name": 'TTM', "show": companies_name[21], "id": 21, "starting_price": 100}
                
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

        sessionStorage.compare = JSON.stringify(compare);
        sessionStorage.bonus = JSON.stringify([]);
        sessionStorage.bonus_submitted = JSON.stringify({"submitted": false, "count": 0});
        sessionStorage.game = JSON.stringify({"game_visit": now, "game_start": now + 15*60*1000,"game_stop": now + 2.5*60*60*1000});
        sessionStorage.money = JSON.stringify({"credit": 5000, "profit": 0});
        sessionStorage.growl = JSON.stringify({"pending": true,"message": 'Hello !&nbsp;&nbsp;&nbsp;&nbsp;Market opens in 15 min.' });
        sessionStorage.stat = JSON.stringify({"status": 'visit'});
        sessionStorage.timeline = JSON.stringify([]);
        sessionStorage.portfolio = JSON.stringify([]);
        sessionStorage.news = JSON.stringify(ns);
        sessionStorage.broker = JSON.stringify({"name": "xyz", "volume": 0, "opted": false, "random": Math.random(), "cat": "good", "tag": 0, "names": brokers_name, "types": brokers_types, "repute": brokers_repute});
        sessionStorage.active_news = JSON.stringify([ns[Math.floor(Math.random()*ns.length)], ns[Math.floor(Math.random()*ns.length)]]);
        var shares = [];
        for (var i = list.companies.length - 1; i > 0; i--) {
            var start_price = past_price(list.companies[i].name);
            list.companies[i].starting_price = start_price;
            shares.push({"company": list.companies[i].name, "price": parseFloat(start_price),
                "quantity": Math.round(((new Date()).getDate()/30*i*600)/start_price), "tag": 'buy', "id": list.companies[i].id});
        }
        sessionStorage.shares = JSON.stringify(shares);
        sessionStorage.list = JSON.stringify(list);
        // console.log(shares);
        // window.location = 'index.php';
    </script>

</body>
</html>