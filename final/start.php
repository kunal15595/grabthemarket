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
        var brokers_name = ['Angel Broking', 'Investopedia', 'Motilal Oswal', 'Indus Invest', 'InvestMentor Securites',
            'Aracade Stock brokers', 'Karvy group', 'Investsmart', 'Dalmia Securities', 'SMC Group', 'Share Khan',
            'Advani Share Brokers', 'Toss financial services', 'India Infoline', 'Kotak Securities Ltd.'];
        var companies_name = ['BHEL', 'Airtel', 'Cipla', 'NTPC', 'DLF', 'HDFC Bank', 'Infosys', 'ONGC', 'TCS', 'Reliance',
            'Sun Pharma', 'PNB', 'HPCL', 'HCL Tech.', 'Indian Oil', 'Yes Bank', 'Siemens', 'Ranbaxy', 'SAIL', 'Indiabulls',
            'Vodafone', 'Hero Honda', 'Apollo', 'TVS Motors', 'Ashok Leyland', 'Axis Bank', 'SBI','Omaxe', 'JK Tyres',
            'Dabur', 'Canara Bank', 'Eicher Motors', 'L & T', 'Nestle', 'Wipro', 'Tata Power', 'GAIL', 'Cairn', 'Air India',
            'Flipkart', 'Nivea', 'Prestige', 'Snapdeal', 'Zomato', 'Asian Paints', 'Bajaj Auto', 'Idea', 'Dr. Reddy\'s'];
        
        brokers_name = shuffle(brokers_name);
        companies_name = shuffle(companies_name);
        var ns = [];
        for (var i = 0; i < (news.list).length; i++) {
            ns.push(news.list[i].txt);
        }
        
        var list = {
            "companies": [
                {"name": '', "show": '', "id": 0},
                {"name": 'ARTL', "show": companies_name[1], "id": 1},
                {"name": 'CIPLA', "show": companies_name[2], "id": 2},
                {"name": 'DLF', "show": companies_name[3], "id": 3},
                {"name": 'INFY', "show": companies_name[4], "id": 4},
                {"name": 'ONGC', "show": companies_name[5], "id": 5},
                {"name": 'NTPC', "show": companies_name[6], "id": 6},
                {"name": 'HDB', "show": companies_name[7], "id": 7},
                {"name": 'TCS', "show": companies_name[8], "id": 8},
                {"name": 'RIL', "show": companies_name[9], "id": 9},
                {"name": 'SI', "show": companies_name[10], "id": 10},
                {"name": 'RAN', "show": companies_name[11], "id": 11},
                {"name": 'SAIL', "show": companies_name[12], "id": 12},
                {"name": 'IB', "show": companies_name[13], "id": 13},
                {"name": 'VOD', "show": companies_name[14], "id": 14},
                {"name": 'HMC', "show": companies_name[15], "id": 15},
                {"name": 'AC', "show": companies_name[16], "id": 16},
                {"name": 'NES', "show": companies_name[17], "id": 17},
                {"name": 'IBN', "show": companies_name[18], "id": 18},
                {"name": 'LT', "show": companies_name[19], "id": 19},
                {"name": 'WIT', "show": companies_name[20], "id": 20},
                {"name": 'TTM', "show": companies_name[21], "id": 21}
                
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
        sessionStorage.broker = JSON.stringify({"opted": false, "random": Math.random(), "type": "good", });
        sessionStorage.active_news = JSON.stringify([ns[Math.floor(Math.random()*ns.length)], ns[Math.floor(Math.random()*ns.length)]]);
        var shares = [];
        for (var i = list.companies.length - 1; i > 0; i--) {
            shares.push({"company": list.companies[i].name, "price": parseFloat(past_price(list.companies[i].name)),
                "quantity": Math.round((Math.random() * 1000)/past_price(list.companies[i].name)), "tag": 'buy', "id": list.companies[i].id});
        }
        sessionStorage.shares = JSON.stringify(shares);
        // console.log(shares);
        window.location = 'index.php';
    </script>

</body>
</html>