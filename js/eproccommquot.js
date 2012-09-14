// JScript File


function GetTotal()
{
	var tot = 0;
	var totafterppn = 0;
	var tab = document.getElementById('ctl00_cph_gvItem');
	var i = 2;
	var j = 0;
	
	for(var i=2; i<= tab.rows.length; i++)
	{
		var qty = parseFloat(remChar(document.getElementById('ctl00_cph_gvItem_ctl'+ findJ(i) +'_txtQty').value, ','));
		var price = parseFloat(remChar(document.getElementById('ctl00_cph_gvItem_ctl'+ findJ(i) +'_txtUnitPrice').value, ','));
				
		tot += qty * price;
	}
	
	totafterppn = tot * 1.1;
    minbodbond = totafterppn * 1000;
	minbodbond = minbodbond / 1000 / 100;
    
    if(document.getElementById('ctl00_cph_lblCurrency').innerText == 'IDR')
    {
        if(totafterppn >= CNum(document.getElementById('ctl00_cph_txtBidBondMinIDR').value))
        {
            document.getElementById('ctl00_cph_lblBidbondMin').innerText = outputMoney(String(minbodbond));
	    }
	    else
	        document.getElementById('ctl00_cph_lblBidbondMin').innerText = '0';
	 }
	 else
     {
        if(totafterppn >= CNum(document.getElementById('ctl00_cph_txtBidBondMinUSD').value))
        {
            document.getElementById('ctl00_cph_lblBidbondMin').innerText = outputMoney(String(minbodbond));
	    }
	    else
	        document.getElementById('ctl00_cph_lblBidbondMin').innerText = '0';
	 }
	        
	document.getElementById('ctl00_cph_lblTotal').innerText = outputMoney(String(tot));
    document.getElementById('ctl00_cph_lblTotalAfterPPN').innerText = outputMoney(String(totafterppn));
    
}

function isAdminValid()
{

}
