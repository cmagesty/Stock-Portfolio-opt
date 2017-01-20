<?PHP

class Stock_fetcher {

    private $symbol;
    private $exchange;
    private $name;
    private $spot_price;
    private $us_price;
    private $foreign_price;
    private $traded;
    private $currency;
    private $is_foreign;
    private $domestics = array( 'NASDAQ', 'NYSE' );
    private $foreigns = array( "NSE", '"SES"' );

    public function __construct($symbol, $traded) {
        $this -> traded = $traded;
        $this -> symbol = $symbol;
        $this -> fetch_from_api();
        $this -> set_is_foreign( $this -> exchange );
        $this -> set_currency( $this -> exchange );
        $this -> set_real_price( $this -> spot_price );
    }

    private function fetch_from_api() {
        $fetched_price = 0;
        try{
            if ( $this -> traded == false ) {
                switch ($this->symbol) {
                    //--------------------Start of Dow--------------------
                    case "AAPL":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=aapl&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        //have to manually input exchange and name because historical api only fetches price
                        $this->exchange = 'NASDAQ';
                        $this->name = 'APPLE';
                        //creates an array data where each value is a section from the csv file #this is needed or it picks it up 1 char 
                        //at a time#
                        $data = explode(',', $stock_url_9_12);
                        //set unknown_price to the data in the array corresponding to september closing price
                        $fetched_price = $data[10];
                        //echo $this -> price; //Test to see if price gets saved
                        break;
                    case "AXP":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=AXP&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $this->exchange = 'NYSE';
                        $this->name = 'AMERICAN EXPRESS';
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        break;
                    case "BA":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=BA&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $this->exchange = 'NYSE';
                        $this->name = 'BOEING';
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        break;
                    case "CAT":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=CAT&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $this->exchange = 'NYSE';
                        $this->name = 'CATERPILLAR';
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        break;
                    case "CSCO":
                        $this->exchange = 'NASDAQ';
                        $this->name = 'CISCO SYSTEMS';
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=CSCO&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[11];
                        //echo $this -> price;
                        break;
                    case "CVX":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=CVX&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NYSE';
                        $this->name = 'CHEVRON';
                        break;
                    case "KO":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=KO&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NYSE';
                        $this->name = 'COCA-COLA';
                        break;
                    case "DD":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=DD&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NYSE';
                        $this->name = 'DUPONT';
                        break;
                    case "XOM":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=XOM&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NYSE';
                        $this->name = 'EXXONMOBILE';
                        break;
                    case "GE":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=GE&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NYSE';
                        $this->name = 'GENERAL ELECTRIC';
                        break;
                    case "GS":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=GS&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NYSE';
                        $this->name = 'GOLDMAN SACHS';
                        break;
                    case "HD":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=HD&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NYSE';
                        $this->name = 'HOME DEPOT';
                        break;
                    case "IBM":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=IBM&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NYSE';
                        $this->name = 'IBM';
                        break;
                    case "INTC":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=INTC&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NASDAQ';
                        $this->name = 'INTEL';
                        break;
                    case "JNJ":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=JNJ&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NYSE';
                        $this->name = 'JOHNSON & JOHNSON';
                        break;
                    case "JPM":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=JPM&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NYSE';
                        $this->name = 'JPMORGAN CHASE';
                        break;
                    case "MCD":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=MCD&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NYSE';
                        $this->name = 'MCDONALDS';
                        break;
                    case "MMM":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=MMM&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NYSE';
                        $this->name = '3M COMPANY';
                        break;
                    case "MRK":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=MRK&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        echo $fetched_price;
                        $this->exchange = 'NYSE';
                        $this->name = 'MERCK';
                        break;
                    case "MSFT":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=MSFT&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        echo $fetched_price;
                        $this->exchange = 'NASDAQ';
                        $this->name = 'MICROSOFT';
                        break;
                    case "NKE":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=NKE&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NYSE';
                        $this->name = 'NIKE';
                        break;
                    case "PFE":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=PFE&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NYSE';
                        $this->name = 'PFIZER';
                        break;
                    case "PG":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=PG&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NYSE';
                        $this->name = 'PROCTER & GAMBLE';
                        break;
                    case "TRV":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=TRV&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NYSE';
                        $this->name = 'THE TRAVELERS';
                        break;
                    case "UNH":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=UNH&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NYSE';
                        $this->name = 'UNITEDHEALTH';
                        break;
                    case "UTX":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=UTX&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NYSE';
                        $this->name = 'UNITED TECHNOLOGIES';
                        break;
                    case "V":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=V&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NYSE';
                        $this->name = 'VISA';
                        break;
                    case "VZ":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=VZ&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        echo $fetched_price;
                        $this->exchange = 'NYSE';
                        $this->name = 'VERIZON';
                        break;
                    case "WMT":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=WMT&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NYSE';
                        $this->name = 'WAL-MART';
                        break;
                    case "DIS":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=DIS&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        echo $fetched_price;
                        $this->exchange = 'NYSE';
                        $this->name = 'WALT DISNEY';
                        break;
                    //-----------------------------End of Dow Start of Nifty50--------------------------------------
                    case "TATAPOWER":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=TATAPOWER.NS&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        echo $fetched_price;
                        $this->exchange = 'NSE';
                        $this->name = 'Tata Power Company';
                        break;
                    case "HDFC":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=HDFC.NS&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NSE';
                        $this->name = 'Housing Development Finance Corporation';
                        break;
                    case "IDEA":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=IDEA.NS&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NSE';
                        $this->name = 'Idea Cellular';
                        break;
                    case "BPCL":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=BPCL.NS&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NSE';
                        $this->name = 'BPCL';
                        break;
                    case "ADANIPORTS":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=ADANIPORTS.NS&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NSE';
                        $this->name = 'Bharat Petroleum Corporation Limited';
                        break;
                    case "ONGC":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=ONGC.NS&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NSE';
                        $this->name = 'Oil & Natural Gas Corporation';
                        break;
                    case "TATASTEEL":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=TATASTEEL.NS&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        echo $fetched_price;
                        $this->exchange = 'NSE';
                        $this->name = 'Tata Steel';
                        break;
                    case "SBIN":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=SBIN.NS&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NSE';
                        $this->name = 'State Bank of India';
                        break;
                    case "RELIANCE":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=RELIANCE.NS&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NSE';
                        $this->name = 'Reliance Industries';
                        break;
                    case "DRREDDY":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=DRREDDY.NS&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NSE';
                        $this->name = 'Dr. Reddys Laboratories';
                        break;
                    case "AUROPHARMA":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=AUROPHARMA.NS&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NSE';
                        $this->name = 'Aurobindo Pharma';
                        break;
                    case "ACC":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=ACC.NS&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NSE';
                        $this->name = 'ACC Limited';
                        break;
                    case "HINDALCO":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=HINDALCO.NS&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NSE';
                        $this->name = 'Hindalco Industries';
                        break;
                    case "GAIL":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=GAIL.NS&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NSE';
                        $this->name = 'GAIL';
                        break;
                    case "GRASIM":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=GRASIM.NS&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NSE';
                        $this->name = 'Grasim Industries';
                        break;
                    case "INFY":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=INFY.NS&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NSE';
                        $this->name = 'Infosys';
                        break;
                    case "KOTAKBANK":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=KOTAKBANK.NS&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NSE';
                        $this->name = 'Kotak Mahindra Bank';
                        break;
                    case "TECHM":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=TECHM.NS&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NSE';
                        $this->name = 'Tech Mahindra ';
                        break;
                    case "YESBANK":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=YESBANK.NS&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NSE';
                        $this->name = 'Yes Bank';
                        break;
                    case "ZEEL":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=ZEEL.NS&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NSE';
                        $this->name = 'Zee Entertainment Enterprises Limited';
                        break;
                    case "ULTRACEMCO":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=ULTRACEMCO.NS&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NSE';
                        $this->name = 'UltraTech Cement Limited';
                        break;
                    case "LT":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=LT.NS&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        echo $fetched_price;
                        $this->exchange = 'NSE';
                        $this->name = 'Larsen & Toubro Limited';
                        break;
                    case "CIPLA":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=CIPLA.NS&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NSE';
                        $this->name = 'Cipla';
                        break;
                    case "NTPC":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=NTPC.NS&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NSE';
                        $this->name = 'NTPC';
                        break;
                    case "AMBUJACEM":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=AMBUJACEM.NS&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NSE';
                        $this->name = 'AMBUJACEM';
                        break;
                    case "TATAMTRDVR":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=TATAMTRDVR.NS&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NSE';
                        $this->name = 'TATAMTRDVR';
                        break;
                    case "INDUSINDBK":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=INDUSINDBK.NS&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NSE';
                        $this->name = 'INDUSINDBK';
                        break;
                    case "TATAMOTORS":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=TATAMOTORS.NS&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        echo $fetched_price;
                        $this->exchange = 'NSE';
                        $this->name = 'TATA MOTORS';
                        break;
                    case "WIPRO":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=WIPRO.NS&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NSE';
                        $this->name = 'WIPRO';
                        break;
                    case "COALINDIA":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=COALINDIA.NS&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NSE';
                        $this->name = 'COAL INDIA';
                        break;
                    case "HDFCBANK":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=HDFCBANK.NS&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NSE';
                        $this->name = 'HDFC BANK';
                        break;
                    case "BANKBARODA":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=BANKBARODA.NS&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        echo $fetched_price;
                        $this->exchange = 'NSE';
                        $this->name = 'BANKBARODA';
                        break;
                    case "BHARTIARTL":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=BHARTIARTL.NS&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NSE';
                        $this->name = 'Bharti Airtel';
                        break;
                    case "ICICIBANK":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=ICICIBANK.NS&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        echo $fetched_price;
                        $this->exchange = 'NSE';
                        $this->name = 'ICICI BANK';
                        break;
                    /*
                     *  THIS LINK DOES NOT EXIST IF THIS GETS UNCOMMENTED THE REST OF THE LINKS FAIL
                     *             case "BAJAJ-AUTO":
                      $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=BAJAJ-AUTO.NS&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                      $data = explode( ',', $stock_url_9_12);
                      $this -> price = $data[10];
                      echo $this -> price;
                      $this -> exchange = 'NSE';
                      $this -> name = 'BAJAJ AUTO';
                      break; */
                    case "ASIANPAINT":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=ASIANPAINT.NS&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        echo $fetched_price;
                        $this->exchange = 'NSE';
                        $this->name = 'ASIAN PAINT';
                        break;
                    case "BHEL":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=BHEL.NS&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NSE';
                        $this->name = 'Bharat Heavy Electricals';
                        break;
                    case "HEROMOTOCO":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=HEROMOTOCO.NS&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NSE';
                        $this->name = 'Hero MotoCorp';
                        break;
                    case "LUPIN":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=LUPIN.NS&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NSE';
                        $this->name = 'LUPIN';
                        break;
                    case "TCS":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=TCS.NS&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        echo $fetched_price;
                        $this->exchange = 'NSE';
                        $this->name = 'Tata Consultancy Service';
                        break;
                    case "M & M":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=M&M.NS&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NSE';
                        $this->name = 'Mahindra & Mahindra';
                        break;
                    case "SUNPHARMA":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=SUNPHARMA.NS&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NSE';
                        $this->name = 'SUN PHARMA';
                        break;
                    case "ITC":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=ITC.NS&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NSE';
                        $this->name = 'ITC';
                        break;
                    case "EICHERMOT":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=EICHERMOT.NS&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NSE';
                        $this->name = 'EICHERMOT';
                        break;
                    case "HINDUNILVR":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=HINDUNILVR.NS&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        echo $fetched_price;
                        $this->exchange = 'NSE';
                        $this->name = 'HINDUNILVR';
                        break;
                    case "AXISBANK":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=AXISBANK.NS&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        echo $fetched_price;
                        $this->exchange = 'NSE';
                        $this->name = 'AXIS BANK';
                        break;
                    case "POWERGRID":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=POWERGRID.NS&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        echo $fetched_price;
                        $this->exchange = 'NSE';
                        $this->name = 'POWER GRID';
                        break;
                    case "MARUTI":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=MARUTI.NS&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NSE';
                        $this->name = 'MARUTI';
                        break;
                    case "HCLTECH":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=HCLTECH.NS&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NSE';
                        $this->name = 'HCL TECH';
                        break;
                    case "BOSCHLTD":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=BOSCHLTD.NS&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NSE';
                        $this->name = 'BOSCH';
                        break;
                    case "INFRATEL":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=INFRATEL.NS&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NSE';
                        $this->name = 'INFRATEL';
                        break;
                    //-------------------------End of Nifty50 Start of SES-------------------------
                    case "A17U":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=A17U.SI&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        echo $fetched_price;
                        $this->exchange = 'SES';
                        $this->name = 'Ascendas Real Estate Inv Trust';
                        break;
                    case "BN4":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=BN4.SI&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'SES';
                        $this->name = 'Keppel Corp';
                        break;
                    case "BS6":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=BS6.SI&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'SES';
                        $this->name = 'Yangzijiang Shipbuilding';
                        break;
                    case "C07":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=C07.SI&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'SES';
                        $this->name = 'Jardine Cycle & Carriage';
                        break;
                    case "C09":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=C09.SI&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'SES';
                        $this->name = 'City Developments';
                        break;
                    case "C31":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=C31.SI&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'SES';
                        $this->name = 'CapitaLand';
                        break;
                    case "C38U":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=C38U.SI&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'SES';
                        $this->name = 'Capitamall Trust';
                        break;
                    case "C52":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=C52.SI&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'SES';
                        $this->name = 'ComfortDelGro';
                        break;
                    case "C61U":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=C61U.SI&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'SES';
                        $this->name = 'CapitaCommercial';
                        break;
                    case "C6L":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=C6L.SI&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'SES';
                        $this->name = 'Singapore Airlines';
                        break;
                    case "CC3":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=CC3.SI&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'SES';
                        $this->name = 'StarHub';
                        break;
                    case "D05":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=D05.SI&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'SES';
                        $this->name = 'DBS Group Holdings';
                        break;
                    case "E5H":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=E5H.SI&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'SES';
                        $this->name = 'Golden Agri-Resources';
                        break;
                    case "F34":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=F34.SI&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'SES';
                        $this->name = 'Wilmar International';
                        break;
                    case "G13":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=G13.SI&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'SES';
                        $this->name = 'Genting SingaporE';
                        break;
                    case "H78":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=H78.SI&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'SES';
                        $this->name = 'Hongkong Land Holdings';
                        break;
                    case "MC0":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=MC0.SI&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'SES';
                        $this->name = 'Global Logistic Properties';
                        break;
                    case "NS8U":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=NS8U.SI&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'SES';
                        $this->name = 'Hutchison Port Holdings';
                        break;
                    case "O39":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=O39.SI&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'SES';
                        $this->name = '�?�僑銀行有�?公�?�';
                        break;
                    case "S51":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=S51.SI&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'SES';
                        $this->name = 'SembCorp Marine';
                        break;
                    case "S58":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=S58.SI&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'SES';
                        $this->name = 'SATS';
                        break;
                    case "S59":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=S59.SI&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'SES';
                        $this->name = 'SIA Engineering';
                        break;
                    case "S63":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=S63.SI&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'SES';
                        $this->name = '新加�?�技術動力有�?公�?�';
                        break;
                    case "S68":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=S68.SI&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'SES';
                        $this->name = 'Singapore Exchange';
                        break;
                    case "T39":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=T39.SI&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'SES';
                        $this->name = '新加�?�報業控股有�?公�?�';
                        break;
                    case "U11":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=U11.SI&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'SES';
                        $this->name = 'United Overseas Bank';
                        break;
                    case "U14":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=U14.SI&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'SES';
                        $this->name = 'UOL Group ';
                        break;
                    case "U96":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=U96.SI&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'SES';
                        $this->name = 'SEMBCorp Industries';
                        break;
                    case "Y92":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=Y92.SI&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'SES';
                        $this->name = 'Thai Beverage ';
                        break;
                    case "Z74":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=Z74.SI&a=8&b=12&c=2016&d=8&e=12&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        echo $fetched_price;
                        $this->exchange = 'SES';
                        $this->name = 'Singapore Telecommunications';
                        break;
                    default:
                        throw new Exception( "Could not add stock, could not find symbol" );
                        break;
                    //end of Stock list for september dates
                }
            }
            else if ( $this -> traded == true ) {
                switch ($this -> symbol) {
                    //--------------------Start of Dow--------------------
                    case "AAPL":
                        $stock_url_9_12 = file_get_contents("http://finance.yahoo.com/d/quotes.csv?s=aapl&f=snl1x&e=.csv");
                        $data = explode(',', $stock_url_9_12);
                        //these values from the data array are diffrent from the historical one because it fecthes the price,name, & exchange
                        $fetched_price = $data[2];
                        $this->exchange = $data[3];
                        $this->name = $data[1];
                        break;
                    case "AXP":
                        $stock_url_9_12 = file_get_contents("http://finance.yahoo.com/d/quotes.csv?s=AXP&f=snl1x&e=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[2];
                        $this->exchange = $data[3];
                        $this->name = $data[1];
                        break;
                    case "BA":
                        $stock_url_9_12 = file_get_contents("http://finance.yahoo.com/d/quotes.csv?s=BA&f=snl1x&e=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[2];
                        $this->exchange = $data[3];
                        $this->name = $data[1];
                        break;
                    case "CAT":
                        $stock_url_9_12 = file_get_contents("http://finance.yahoo.com/d/quotes.csv?s=CAT&f=snl1x&e=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[3];
                        $this->exchange = $data[4];
                        $this->name = $data[1];
                        break;
                    case "CSCO":
                        $stock_url_9_12 = file_get_contents("http://finance.yahoo.com/d/quotes.csv?s=CSCO&f=snl1x&e=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[3];
                        $this->exchange = $data[4];
                        $this->name = $data[1];
                        break;
                    case "CVX":
                        $stock_url_9_12 = file_get_contents("http://finance.yahoo.com/d/quotes.csv?s=CVX&f=snl1x&e=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[2];
                        $this->exchange = $data[3];
                        $this->name = $data[1];
                        break;
                    case "KO":
                        $stock_url_9_12 = file_get_contents("http://finance.yahoo.com/d/quotes.csv?s=KO&f=snl1x&e=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[2];
                        $this->exchange = $data[3];
                        $this->name = $data[1];
                        break;
                    case "DD":
                        $stock_url_9_12 = file_get_contents("http://finance.yahoo.com/d/quotes.csv?s=DD&f=snl1x&e=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[2];
                        $this->exchange = $data[3];
                        $this->name = $data[1];
                        break;
                    case "XOM":
                        $stock_url_9_12 = file_get_contents("http://finance.yahoo.com/d/quotes.csv?s=XOM&f=snl1x&e=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[2];
                        $this->exchange = $data[3];
                        $this->name = $data[1];
                        break;
                    case "GE":
                        $stock_url_9_12 = file_get_contents("http://finance.yahoo.com/d/quotes.csv?s=GE&f=snl1x&e=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[2];
                        $this->exchange = $data[3];
                        $this->name = $data[1];
                        break;
                    case "GS":
                        $stock_url_9_12 = file_get_contents("http://finance.yahoo.com/d/quotes.csv?s=GS&f=snl1x&e=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[3];
                        $this->exchange = $data[4];
                        $this->name = $data[1];
                        break;
                    case "HD":
                        $stock_url_9_12 = file_get_contents("http://finance.yahoo.com/d/quotes.csv?s=HD&f=snl1x&e=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[2];
                        $this->exchange = $data[3];
                        $this->name = $data[1];
                        break;
                    case "IBM":
                        $stock_url_9_12 = file_get_contents("http://finance.yahoo.com/d/quotes.csv?s=IBM&f=snl1x&e=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[2];
                        $this->exchange = $data[3];
                        $this->name = $data[1];
                        break;
                    case "INTC":
                        $stock_url_9_12 = file_get_contents("http://finance.yahoo.com/d/quotes.csv?s=INTC&f=snl1x&e=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[2];
                        $this->exchange = $data[3];
                        $this->name = $data[1];
                        break;
                    case "JNJ":
                        $stock_url_9_12 = file_get_contents("http://finance.yahoo.com/d/quotes.csv?s=JNJ&f=snl1x&e=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[2];
                        $this->exchange = $data[3];
                        $this->name = $data[1];
                        break;
                    case "JPM":
                        $stock_url_9_12 = file_get_contents("http://finance.yahoo.com/d/quotes.csv?s=JPM&f=snl1x&e=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[2];
                        $this->exchange = $data[3];
                        $this->name = $data[1];
                        break;
                    case "MCD":
                        $stock_url_9_12 = file_get_contents("http://finance.yahoo.com/d/quotes.csv?s=MCD&f=snl1x&e=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[2];
                        $this->exchange = $data[3];
                        $this->name = $data[1];
                        break;
                    case "MMM":
                        $stock_url_9_12 = file_get_contents("http://finance.yahoo.com/d/quotes.csv?s=MMM&f=snl1x&e=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[2];
                        $this->exchange = $data[3];
                        $this->name = $data[1];
                        break;
                    case "MRK":
                        $stock_url_9_12 = file_get_contents("http://finance.yahoo.com/d/quotes.csv?s=MRK&f=snl1x&e=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[2];
                        $this->exchange = $data[3];
                        $this->name = $data[1];
                        break;
                    case "MSFT":
                        $stock_url_9_12 = file_get_contents("http://finance.yahoo.com/d/quotes.csv?s=MSFT&f=snl1x&e=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[2];
                        $this->exchange = $data[3];
                        $this->name = $data[1];
                        break;
                    case "NKE":
                        $stock_url_9_12 = file_get_contents("http://finance.yahoo.com/d/quotes.csv?s=NKE&f=snl1x&e=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[2];
                        $this->exchange = $data[3];
                        $this->name = $data[1];
                        break;
                    case "PFE":
                        $stock_url_9_12 = file_get_contents("http://finance.yahoo.com/d/quotes.csv?s=PFE&f=snl1x&e=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[2];
                        $this->exchange = $data[3];
                        $this->name = $data[1];
                        break;
                    case "PG":
                        $stock_url_9_12 = file_get_contents("http://finance.yahoo.com/d/quotes.csv?s=PG&f=snl1x&e=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[2];
                        $this->exchange = $data[3];
                        $this->name = $data[1];
                        break;
                    case "TRV":
                        $stock_url_9_12 = file_get_contents("http://finance.yahoo.com/d/quotes.csv?s=TRV&f=snl1x&e=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[2];
                        $this->exchange = $data[3];
                        $this->name = $data[1];
                        break;
                    case "UNH":
                        $stock_url_9_12 = file_get_contents("http://finance.yahoo.com/d/quotes.csv?s=UNH&f=snl1x&e=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[2];
                        $this->exchange = $data[3];
                        $this->name = $data[1];
                        break;
                    case "UTX":
                        $stock_url_9_12 = file_get_contents("http://finance.yahoo.com/d/quotes.csv?s=UTX&f=snl1x&e=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[2];
                        $this->exchange = $data[3];
                        $this->name = $data[1];
                        break;
                    case "V":
                        $stock_url_9_12 = file_get_contents("http://finance.yahoo.com/d/quotes.csv?s=V&f=snl1x&e=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[2];
                        $this->exchange = $data[3];
                        $this->name = $data[1];
                        break;
                    case "VZ":
                        $stock_url_9_12 = file_get_contents("http://finance.yahoo.com/d/quotes.csv?s=VZ&f=snl1x&e=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[2];
                        $this->exchange = $data[3];
                        $this->name = $data[1];
                        break;
                    case "WMT":
                        $stock_url_9_12 = file_get_contents("http://finance.yahoo.com/d/quotes.csv?s=WMT&f=snl1x&e=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[2];
                        $this->exchange = $data[3];
                        $this->name = $data[1];
                        break;
                    case "DIS":
                        $stock_url_9_12 = file_get_contents("http://finance.yahoo.com/d/quotes.csv?s=DIS&f=snl1x&e=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[2];
                        $this->exchange = $data[3];
                        $this->name = $data[1];
                        break;
                    //-----------------------------End of Dow Start of Nifty50--------------------------------------
                    //the only way to fetch these are from historical data
                    case "TATAPOWER":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=TATAPOWER.NS&a=11&b=14&c=2016&d=11&e=14&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NSE';
                        $this->name = 'TATA POWER';
                        break;
                    case "HDFC":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=HDFC.NS&a=11&b=14&c=2016&d=11&e=14&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NSE';
                        $this->name = 'Housing Development Finance Corporation';
                        break;
                    case "IDEA":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=IDEA.NS&a=11&b=14&c=2016&d=11&e=14&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NSE';
                        $this->name = 'Idea Cellular';
                        break;
                    case "BPCL":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=BPCL.NS&a=11&b=14&c=2016&d=11&e=14&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NSE';
                        $this->name = 'BPCL';
                        break;
                    case "ADANIPORTS":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=ADANIPORTS.NS&a=11&b=14&c=2016&d=11&e=14&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NSE';
                        $this->name = 'Bharat Petroleum Corporation';
                        break;
                    case "ONGC":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=ONGC.NS&a=11&b=14&c=2016&d=11&e=14&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NSE';
                        $this->name = 'ONGC';
                        break;
                    case "TATASTEEL":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=TATASTEEL.NS&a=11&b=14&c=2016&d=11&e=14&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NSE';
                        $this->name = 'TATA STEEL';
                        break;
                    case "SBIN":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=SBIN.NS&a=11&b=14&c=2016&d=11&e=14&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NSE';
                        $this->name = 'SBIN';
                        break;
                    case "RELIANCE":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=RELIANCE.NS&a=11&b=14&c=2016&d=11&e=14&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NSE';
                        $this->name = 'RELIANCE';
                        break;
                    case "DRREDDY":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=DRREDDY.NS&a=11&b=14&c=2016&d=11&e=14&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NSE';
                        $this->name = 'DREDDY';
                        break;
                    case "AUROPHARMA":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=AUROPHARMA.NS&a=11&b=14&c=2016&d=11&e=14&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NSE';
                        $this->name = 'AUROPHARMA';
                        break;
                    case "ACC":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=ACC.NS&a=11&b=14&c=2016&d=11&e=14&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NSE';
                        $this->name = "ACC";
                        break;
                    case "HINDALCO":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=HINDALCO.NS&a=11&b=14&c=2016&d=11&e=14&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NSE';
                        $this->name = "HINDALCO";
                        break;
                    case "GAIL":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=GAIL.NS&a=11&b=14&c=2016&d=11&e=14&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NSE';
                        $this->name = "GAIL";
                        break;
                    case "GRASIM":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=GRASIM.NS&a=11&b=14&c=2016&d=11&e=14&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NSE';
                        $this->name = "GRASIM";
                        break;
                    case "INFY":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=INFY.NS&a=11&b=14&c=2016&d=11&e=14&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NSE';
                        $this->name = "INFY";
                        break;
                    case "KOTAKBANK":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=KOTAKBANK.NS&a=11&b=14&c=2016&d=11&e=14&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NSE';
                        $this->name = "KOTAKBANK";
                        break;
                    case "TECHM":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=TECHM.NS&a=11&b=14&c=2016&d=11&e=14&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NSE';
                        $this->name = "TECHM";
                        break;
                    case "YESBANK":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=YESBANK.NS&a=11&b=14&c=2016&d=11&e=14&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NSE';
                        $this->name = "YES BANK";
                        break;
                    case "ZEEL":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=ZEEL.NS&a=11&b=14&c=2016&d=11&e=14&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NSE';
                        $this->name = "ZEEL";
                        break;
                    case "ULTRACEMCO":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=ULTRACEMCO.NS&a=11&b=14&c=2016&d=11&e=14&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NSE';
                        $this->name = "ULTRACEMCO";
                        break;
                    case "LT":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=LT.NS&a=11&b=14&c=2016&d=11&e=14&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NSE';
                        $this->name = "LT";
                        break;
                    case "CIPLA":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=CIPLA.NS&a=11&b=14&c=2016&d=11&e=14&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NSE';
                        $this->name = "CIPLA";
                        break;
                    case "NTPC":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=NTPC.NS&a=11&b=14&c=2016&d=11&e=14&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NSE';
                        $this->name = "NTPC";
                        break;
                    case "AMBUJACEM":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=AMBUJACEM.NS&a=11&b=14&c=2016&d=11&e=14&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NSE';
                        $this->name = "AMBUJACEM";
                        break;
                    case "TATAMTRDVR":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=TATAMTRDVR.NS&a=11&b=14&c=2016&d=11&e=14&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NSE';
                        $this->name = "TATAMTDVR";
                        break;
                    case "INDUSINDBK":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=INDUSINDBK.NS&a=11&b=14&c=2016&d=11&e=14&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NSE';
                        $this->name = "INDUSINDBK";
                        break;
                    case "TATAMOTORS":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=TATAMOTORS.NS&a=11&b=14&c=2016&d=11&e=14&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NSE';
                        $this->name = "TATA MOTORS";
                        break;
                    case "WIPRO":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=WIPRO.NS&a=11&b=14&c=2016&d=11&e=14&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NSE';
                        $this->name = "WIPRO";
                        break;
                    case "COALINDIA":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=COALINDIA.NS&a=11&b=14&c=2016&d=11&e=14&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NSE';
                        $this->name = "COAL INDIA";
                        break;
                    case "HDFCBANK":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=HDFCBANK.NS&a=11&b=14&c=2016&d=11&e=14&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NSE';
                        $this->name = "HDFC BANK";
                        break;
                    case "BANKBARODA":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=BANKBARODA.NS&a=11&b=14&c=2016&d=11&e=14&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NSE';
                        $this->name = "BANKBARODA";
                        break;
                    case "BHARTIARTL":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=BHARTIARTL.NS&a=11&b=14&c=2016&d=11&e=14&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NSE';
                        $this->name = "BHARTIARTL";
                        break;
                    case "ICICIBANK":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=ICICIBANK.NS&a=11&b=14&c=2016&d=11&e=14&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NSE';
                        $this->name = "ICICI BANK";
                        break;
                    case "BAJAJ - AUTO":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=BAJAJ-AUTO.NS&a=11&b=14&c=2016&d=11&e=14&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NSE';
                        $this->name = "BAJAJ AUTO";
                        break;
                    case "ASIANPAINT":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=ASIANPAINT.NS&a=11&b=14&c=2016&d=11&e=14&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NSE';
                        $this->name = "ASIAN PAINT";
                        break;
                    case "BHEL":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=BHEL.NS&a=11&b=14&c=2016&d=11&e=14&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NSE';
                        $this->name = "BHEL";
                        break;
                    case "HEROMOTOCO":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=HEROMOTOCO.NS&a=11&b=14&c=2016&d=11&e=14&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NSE';
                        $this->name = "HEROMOTOCO";
                        break;
                    case "LUPIN":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=LUPIN.NS&a=11&b=14&c=2016&d=11&e=14&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NSE';
                        $this->name = "LUPIN";
                        break;
                    case "TCS":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=TCS.NS&a=11&b=14&c=2016&d=11&e=14&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NSE';
                        $this->name = "TCS";
                        break;
                    case "M & M":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=M&M.NS&a=11&b=14&c=2016&d=11&e=14&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NSE';
                        $this->name = "M&M";
                        break;
                    case "SUNPHARMA":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=SUNPHARMA.NS&a=11&b=14&c=2016&d=11&e=14&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NSE';
                        $this->name = "SUN PHARMA";
                        break;
                    case "ITC":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=ITC.NS&a=11&b=14&c=2016&d=11&e=14&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NSE';
                        $this->name = "ITC";
                        break;
                    case "EICHERMOT":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=EICHERMOT.NS&a=11&b=14&c=2016&d=11&e=14&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NSE';
                        $this->name = "EICHERMOT";
                        break;
                    case "HINDUNILVR":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=HINDUNILVR.NS&a=11&b=14&c=2016&d=11&e=14&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NSE';
                        $this->name = "HINDUNILVR";
                        break;
                    case "AXISBANK":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=AXISBANK.NS&a=11&b=14&c=2016&d=11&e=14&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NSE';
                        $this->name = "AXIS BANK";
                        break;
                    case "POWERGRID":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=POWERGRID.NS&a=11&b=14&c=2016&d=11&e=14&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NSE';
                        $this->name = "POWER GRID";
                        break;
                    case "MARUTI":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=MARUTI.NS&a=11&b=14&c=2016&d=11&e=14&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NSE';
                        $this->name = "MARUTI";
                        break;
                    case "HCLTECH":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=HCLTECH.NS&a=11&b=14&c=2016&d=11&e=14&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NSE';
                        $this->name = "HCLTECH";
                        break;
                    case "BOSCHLTD":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=BOSCHLTD.NS&a=11&b=14&c=2016&d=11&e=14&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NSE';
                        $this->name = "BOSCHLTD";
                        break;
                    case "INFRATEL":
                        $stock_url_9_12 = file_get_contents("http://chart.finance.yahoo.com/table.csv?s=INFRATEL.NS&a=11&b=14&c=2016&d=11&e=14&f=2016&g=d&ignore=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[10];
                        //echo $this -> price;
                        $this->exchange = 'NSE';
                        $this->name = "INFRATEL";
                        break;
                    //-------------------------End of Nifty50 Start of SI-------------------------
                    case "A17U":
                        $stock_url_9_12 = file_get_contents("http://finance.yahoo.com/d/quotes.csv?s=A17U.SI&f=snl1x&e=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[2];
                        $this->exchange = $data[3];
                        $this->name = $data[1];
                        break;
                    case "BN4":
                        $stock_url_9_12 = file_get_contents("http://finance.yahoo.com/d/quotes.csv?s=BN4.SI&f=snl1x&e=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[2];
                        $this->exchange = $data[3];
                        $this->name = $data[1];
                        break;
                    case "BS6":
                        $stock_url_9_12 = file_get_contents("http://finance.yahoo.com/d/quotes.csv?s=BS6.SI&f=snl1x&e=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[2];
                        $this->exchange = $data[3];
                        $this->name = $data[1];
                        break;
                    case "C07":
                        $stock_url_9_12 = file_get_contents("http://finance.yahoo.com/d/quotes.csv?s=C07.SI&f=snl1x&e=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[2];
                        $this->exchange = $data[3];
                        $this->name = $data[1];
                        break;
                    case "C09":
                        $stock_url_9_12 = file_get_contents("http://finance.yahoo.com/d/quotes.csv?s=C09.SI&f=snl1x&e=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[2];
                        $this->exchange = $data[3];
                        $this->name = $data[1];
                        break;
                    case "C31":
                        $stock_url_9_12 = file_get_contents("http://finance.yahoo.com/d/quotes.csv?s=C31.SI&f=snl1x&e=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[2];
                        $this->exchange = $data[3];
                        $this->name = $data[1];
                        break;
                    case "C38U":
                        $stock_url_9_12 = file_get_contents("http://finance.yahoo.com/d/quotes.csv?s=C38U.SI&f=snl1x&e=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[2];
                        $this->exchange = $data[3];
                        $this->name = $data[1];
                        break;
                    case "C52":
                        $stock_url_9_12 = file_get_contents("http://finance.yahoo.com/d/quotes.csv?s=C52.SI&f=snl1x&e=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[2];
                        $this->exchange = $data[3];
                        $this->name = $data[1];
                        break;
                    case "C61U":
                        $stock_url_9_12 = file_get_contents("http://finance.yahoo.com/d/quotes.csv?s=C61U.SI&f=snl1x&e=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[2];
                        $this->exchange = $data[3];
                        $this->name = $data[1];
                        break;
                    case "C6L":
                        $stock_url_9_12 = file_get_contents("http://finance.yahoo.com/d/quotes.csv?s=C6L.SI&f=snl1x&e=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[2];
                        $this->exchange = $data[3];
                        $this->name = $data[1];
                        break;
                    case "CC3":
                        $stock_url_9_12 = file_get_contents("http://finance.yahoo.com/d/quotes.csv?s=CC3.SI&f=snl1x&e=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[2];
                        $this->exchange = $data[3];
                        $this->name = $data[1];
                        break;
                    case "D05":
                        $stock_url_9_12 = file_get_contents("http://finance.yahoo.com/d/quotes.csv?s=D05.SI&f=snl1x&e=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[2];
                        $this->exchange = $data[3];
                        $this->name = $data[1];
                        break;
                    case "E5H":
                        $stock_url_9_12 = file_get_contents("http://finance.yahoo.com/d/quotes.csv?s=E5H.SI&f=snl1x&e=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[2];
                        $this->exchange = $data[3];
                        $this->name = $data[1];
                        break;
                    case "F34":
                        $stock_url_9_12 = file_get_contents("http://finance.yahoo.com/d/quotes.csv?s=F34.SI&f=snl1x&e=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[2];
                        $this->exchange = $data[3];
                        $this->name = $data[1];
                        break;
                    case "G13":
                        $stock_url_9_12 = file_get_contents("http://finance.yahoo.com/d/quotes.csv?s=G13.SI&f=snl1x&e=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[2];
                        $this->exchange = $data[3];
                        $this->name = $data[1];
                        break;
                    case "H78":
                        $stock_url_9_12 = file_get_contents("http://finance.yahoo.com/d/quotes.csv?s=H78.SI&f=snl1x&e=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[2];
                        $this->exchange = $data[3];
                        $this->name = $data[1];
                        break;
                    case "MC0":
                        $stock_url_9_12 = file_get_contents("http://finance.yahoo.com/d/quotes.csv?s=MC0.SI&f=snl1x&e=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[2];
                        $this->exchange = $data[3];
                        $this->name = $data[1];
                        break;
                    case "NS8U":
                        $stock_url_9_12 = file_get_contents("http://finance.yahoo.com/d/quotes.csv?s=NS8U.SI&f=snl1x&e=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[2];
                        $this->exchange = $data[3];
                        $this->name = $data[1];
                        break;
                    case "O39":
                        $stock_url_9_12 = file_get_contents("http://finance.yahoo.com/d/quotes.csv?s=O39.SI&f=snl1x&e=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[2];
                        $this->exchange = $data[3];
                        $this->name = $data[1];
                        break;
                    case "S51":
                        $stock_url_9_12 = file_get_contents("http://finance.yahoo.com/d/quotes.csv?s=S51.SI&f=snl1x&e=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[2];
                        $this->exchange = $data[3];
                        $this->name = $data[1];
                        break;
                    case "S58":
                        $stock_url_9_12 = file_get_contents("http://finance.yahoo.com/d/quotes.csv?s=S58.SI&f=snl1x&e=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[2];
                        $this->exchange = $data[3];
                        $this->name = $data[1];
                        break;
                    case "S59":
                        $stock_url_9_12 = file_get_contents("http://finance.yahoo.com/d/quotes.csv?s=S59.SI&f=snl1x&e=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[2];
                        $this->exchange = $data[3];
                        $this->name = $data[1];
                        break;
                    case "S63":
                        $stock_url_9_12 = file_get_contents("http://finance.yahoo.com/d/quotes.csv?s=S63.SI&f=snl1x&e=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[2];
                        $this->exchange = $data[3];
                        $this->name = $data[1];
                        break;
                    case "S68":
                        $stock_url_9_12 = file_get_contents("http://finance.yahoo.com/d/quotes.csv?s=S68.SI&f=snl1x&e=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[2];
                        $this->exchange = $data[3];
                        $this->name = $data[1];
                        break;
                    case "T39":
                        $stock_url_9_12 = file_get_contents("http://finance.yahoo.com/d/quotes.csv?s=T39.SI&f=snl1x&e=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[2];
                        $this->exchange = $data[3];
                        $this->name = $data[1];
                        break;
                    case "U11":
                        $stock_url_9_12 = file_get_contents("http://finance.yahoo.com/d/quotes.csv?s=U11.SI&f=snl1x&e=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[2];
                        $this->exchange = $data[3];
                        $this->name = $data[1];
                        break;
                    case "U14":
                        $stock_url_9_12 = file_get_contents("http://finance.yahoo.com/d/quotes.csv?s=U14.SI&f=snl1x&e=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[2];
                        $this->exchange = $data[3];
                        $this->name = $data[1];
                        break;
                    case "U96":
                        $stock_url_9_12 = file_get_contents("http://finance.yahoo.com/d/quotes.csv?s=U96.SI&f=snl1x&e=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[2];
                        $this->exchange = $data[3];
                        $this->name = $data[1];
                        break;
                    case "Y92":
                        $stock_url_9_12 = file_get_contents("http://finance.yahoo.com/d/quotes.csv?s=Y92.SI&f=snl1x&e=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[2];
                        $this->exchange = $data[3];
                        $this->name = $data[1];
                        break;
                    case "Z74":
                        $stock_url_9_12 = file_get_contents("http://finance.yahoo.com/d/quotes.csv?s=Z74.SI&f=snl1x&e=.csv");
                        $data = explode(',', $stock_url_9_12);
                        $fetched_price = $data[2];
                        $this->exchange = $data[3];
                        $this->name = $data[1];
                        break;
                    default: 
                        throw new Exception( "Could not add stock, could not find symbol" );
                    //end of Stock 
                }
            }
        }
        catch ( Exception $e ) {
            throw $e;
        }
        //$this -> exchange = $this -> strip_quotes( $this -> exchange );
        $formatted_price = $fetched_price;
        $this -> spot_price = $formatted_price;
    }

    private function set_is_foreign($exchange) {
        //horrible work around for a php encoding issue --> long story
        if($exchange[0] == '"' ){
        if ( ( $exchange[1] == "N" AND $exchange[2] == "S" AND $exchange[3] == "E" ) OR ( $exchange[1] == "S" AND $exchange[2] == "E" AND $exchange[3] == "S" ) ) {
            $this->is_foreign = true;
        } 
        else {
            $this->is_foreign = false;
        }
        if( $exchange == 'NSE' OR $exchange == 'SES')
            $this -> is_foreign = true;
        }
    else{
        $this -> is_foreign = false;
    }
    }

    private function set_currency($exchange) {  
        $currency = "";
        if($exchange[0] == '"' ){
        if ( ( $exchange[1] == "N" AND $exchange[2] == "S" AND $exchange[3] == "E" ) OR ( $exchange[1] == "S" AND $exchange[2] == "E" AND $exchange[3] == "S" ) ) {
            $currency = "SGD";
        } 
        else {
            $currency = "USD";
        }
        if( $exchange == 'NSE' OR $exchange == 'SES')
            $currency = "SGD";
        }
    else{
        $currency = "USD";
    }
            $this->currency = $currency;
    }
    
    private function strip_quotes( $string ){
        $result = "";
        if( $string[0] == "\"" ){
            $result = str_replace( '"', '', $string ); 
            return $result;
        }
        else{
            return $string;
        }
        
    }
    private function set_real_price( $spot_price ){
        $us_price = 0.00;
        $foreign_price = 0.00;
        if( $this -> is_foreign ){
            $us_price = $this -> convert_to_usd( $spot_price, $this -> currency );
            $foreign_price = $spot_price;
        }
        else if( ! $this -> is_foreign ){
            $us_price = $spot_price;
            $foreign_price = "n/a";
        }
        $this -> us_price = $us_price;
        $this -> foreign_price = $foreign_price;
    }
    
    private function convert_to_usd( $foreign_amount, $currency ){
        $conversion_rate = 0.00;
        switch( $currency ){
            case "INR":
                $conversion_rate = .015;
                break;
            case "SGD":
                $conversion_rate = .70;
                break;
            default: 
                $conversion_rate = 1.00;
        }
        $raw_conversion = $foreign_amount * $conversion_rate;
        $formatted_conversion = number_format( $raw_conversion, 2 );
        return $formatted_conversion;
    }
    
    function get_us_price() {
        return $this->us_price;
    }

    function get_foreign_price() {
        return $this->foreign_price;
    }

    function get_exchange() {
        return $this->exchange;
    }

    function get_name() {
        return $this->name;
    }

    function get_currency() {
        return $this->currency;
    }

    function get_is_foreign() {
        return $this->is_foreign;
    }
}