function gotoStock(){
    
}

function test() {          
    var symbol = document.getElementsByName("symbol")[0].value;
    var qty = document.getElementsByName("qty")[0].value;
    var tradePrice = document.getElementsByName("tradePrice")[0].value;
    var openDate = document.getElementsByName("openDate")[0].value;
    // if (tradePrice == null) {
    //     tradePrice = yahooStockPrices.getCurrentData(symbol);
    // }
    document.write("Symbol: ", symbol);
    document.write("<br>Quantiy: ", qty);
    document.write("<br>Trade Price: ", tradePrice);
    document.write("<br>Dated Opened: ", openDate);
    
    
}
