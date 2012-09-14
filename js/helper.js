var d = document.all;

function getPopUp(saddress)
{
	openWindow(saddress, 150, 150);
}

function FillOpener(sFieldCode, sFieldDesc, sValueCode, sValueDesc)
{
    window.opener.document.all(sFieldCode).value = sValueCode;
    window.opener.document.all(sFieldDesc).value = sValueDesc;
    window.close();
}

function FillOpenerItem(sFieldCode, sFieldDesc, sFieldPrice, sValueCode, sValueDesc, sPrice)
{
    window.opener.document.all(sFieldCode).value = sValueCode;
    window.opener.document.all(sFieldDesc).value = sValueDesc;
    if(sFieldPrice != "")
        window.opener.document.all(sFieldPrice).value = sPrice;

    window.close();
}

function FillOpenerDO(sFieldCode, sFieldDesc, sValueCode, sValueDesc)
{
    window.opener.document.all(sFieldCode).value = sValueCode;
    window.opener.document.all(sFieldDesc).value = sValueDesc;
    window.opener.document.all('ctl00_ContentPlaceHolder1_btnLoadDO').click();
    window.close();
}

function FillOpener6(sf1, sf2, sf3, sf4, sf5,sf6, sv1, sv2, sv3, sv4, sv5, sv6)
{
    window.opener.document.all(sf1).value = sv1;
    window.opener.document.all(sf2).value = sv2;
    window.opener.document.all(sf3).value = sv3;
    window.opener.document.all(sf4).value = sv4;
    window.opener.document.all(sf5).value = sv5;
    window.opener.document.all(sf6).value = sv6;
    window.close();
}

function messageAlert(obj)
{
	if(event.keyCode >=32 || event.keyCode <=126)
	{
		alert("Click browse button!");
		document.all[obj.id].focus();
	}
}

function openWindow(sURL, sHeight, sWidth, sName) //open new window
{
	if(sName == null || sName == '') sName = 'NewWindow';
	LeftPosition = (screen.width) ? (screen.width-sWidth)/2 : 0;
	TopPosition = (screen.height) ? (screen.height-sHeight)/2 : 0;
	window.open(sURL, sName, "toolbar=no scrollbars=no height=" + sHeight + " width=" + sWidth + " top=" + TopPosition + " left=" + LeftPosition);
	
	return(false);
}

function openWindow1(sURL, sHeight, sWidth, sName) //open new window
{
	if(sHeight == null) sHeight = screen.height;
	if(sWidth == null) sWidth = screen.width;
	
	if(sName == null || sName == '') sName = 'NewWindow';
	LeftPosition = (screen.width) ? (screen.width-sWidth)/2 : 0;
	TopPosition = (screen.height) ? (screen.height-sHeight)/2 : 0;
	window.open(sURL) //, sName, "toolbar=no scrollbars=yes")// height=" + sHeight + " width=" + sWidth + " top=" + TopPosition + " left=" + LeftPosition);
	
	return(false);
}

function openWindow2(sURL, sHeight, sWidth, sName, sScrollbars) //open new window with option enable or disable scrollbar
{
	if(sName == null || sName == '') sName = 'NewWindow';
	LeftPosition = (screen.width) ? (screen.width-sWidth)/2 : 0;
	TopPosition = (screen.height) ? (screen.height-sHeight)/2 : 0;
	window.open(sURL, sName, "toolbar=no scrollbars="+ sScrollbars +" height=" + sHeight + " width=" + sWidth + " top=" + TopPosition + " left=" + LeftPosition);
	
	return(false);
}

function openWindow2(sURL, sHeight, sWidth, sName) //open new window with option enable or disable scrollbar
{
	if(sName == null || sName == '') sName = 'NewWindow';
	LeftPosition = (screen.width) ? (screen.width-sWidth)/2 : 0;
	TopPosition = (screen.height) ? (screen.height-sHeight)/2 : 0;
	window.open(sURL, sName, "toolbar=no scrollbars=yes height=" + sHeight + " width=" + sWidth + " top=" + TopPosition + " left=" + LeftPosition);
	
	return(false);
}

function openWindow3(sURL, sQS, sHeight, sWidth, sName) //open new window with option enable or disable scrollbar
{
	if(sName == null || sName == '') sName = 'NewWindow';
	LeftPosition = (screen.width) ? (screen.width-sWidth)/2 : 0;
	TopPosition = (screen.height) ? (screen.height-sHeight)/2 : 0;
	window.open(sURL + '?' + sQS, sName, "toolbar=no scrollbars=yes height=" + sHeight + " width=" + sWidth + " top=" + TopPosition + " left=" + LeftPosition);
	
	return(false);
}

function openDialog2(path, w, h, args, name) {        
    var qString = path;    
    
    if(args != null && args.trim() != "") {
        qString += '?' + args;
    }    
    if(name == null || name == '') name = 'DialogWindow2';
    	
	LeftPosition = (screen.width) ? (screen.width-800)/2 : 0;
	TopPosition = (screen.height) ? (screen.height-600)/2 : 0;
	window.open(qString, name, "toolbar=no scrollbars=yes height=600 width=800 resizable=yes top=" + TopPosition + " left=" + LeftPosition);	
}

function resizeWindow(sHeight, sWidth) //resize window
{
	LeftPosition = (screen.width-sWidth)/2;
	TopPosition = (screen.height-sHeight)/2;
	top.window.moveTo(LeftPosition,TopPosition);
	if (document.all) {
		top.window.resizeTo(sWidth,sHeight);
	}
	else if (document.layers||document.getElementById) {
			top.window.outerHeight = sHeight;
			top.window.outerWidth = sWidth;
	}
	window.focus();
}

function maximizeWindow() {
	top.window.moveTo(0,0);
	if (document.all) {
		top.window.resizeTo(screen.availWidth,screen.availHeight);
	}
	else if (document.layers||document.getElementById) {
		if (top.window.outerHeight<screen.availHeight||top.window.outerWidth<screen.availWidth){
			top.window.outerHeight = screen.availHeight;
			top.window.outerWidth = screen.availWidth;
		}
	}
	window.focus();
}

function CNum(sNumber)
{
    return parseFloat(remChar(sNumber, ','));
}

function getSubTotal(x, a, b)
{
    var total = CNum(document.getElementById(a).value) * CNum(document.getElementById(b).value);
    document.getElementById(x).value = outputMoney(String(total));
    document.getElementById(a).value = outputMoney(document.getElementById(a).value);
    document.getElementById(b).value = outputMoney(document.getElementById(b).value);
}

function remChar(s, chr) //remove certain character : var tes = remChar('ABCDE', 'A')
{
	var sNew = '';
	for(var i=0;i<s.length;i++)
		if(s.charAt(i) != chr)
			sNew += s.charAt(i);
	return sNew;
}

function IsNumeric(obj) //validate field value, numeric or not, obj = field object :: Form1.txtPrice
{
	var d = document.all;
	number = remChar(obj.value, ',');
	
	if (((number / number) != 1) && (number != 0)) 
	{
		alert('Please enter only a number into this field!');
		obj.value = '0';
		obj.focus();
		return false;
	}
	else //reformat numeric	
	{
		obj.value = outputMoney(number);
		return true;
	}
}

function IsNumericNoDecimal(obj) //validate field value, numeric or not, obj = field object :: Form1.txtPrice
{
	var d = document.all;
	number = remChar(obj.value, ',');
	
	if (((number / number) != 1) && (number != 0)) 
	{
		alert('Please enter only a number into this field!');
		obj.value = '0';
		obj.focus();
		return false;
	}
	else //reformat numeric	
	{
		obj.value = outputMoney(number);
		return true;
	}
}

function outputMoney(snumber)
{	
	var snumber = remChar(snumber, ',');
	return outputDollars(Math.floor(snumber-0) + '') + outputCents(snumber - 0);
}

function outputDollars(number) //used in outputMoney function
{
	if (number.length <= 3)
		return (number == '' ? '0' : number);
	else {
		var mod = number.length%3;
		var output = (mod == 0 ? '' : (number.substring(0,mod)));
		for (i=0 ; i < Math.floor(number.length/3) ; i++)
		{
			if ((mod ==0) && (i ==0))
				output+= number.substring(mod+3*i,mod+3*i+3);
			else
				output+= ',' + number.substring(mod+3*i,mod+3*i+3);
		}
		return (output);
	}
}

function outputCents(amount) //used in outputMoney function
{
	amount = Math.round( ( (amount) - Math.floor(amount) ) *100);
	return (amount < 10 ? '.0' + amount : '.' + amount);
}

function IsNumericInt(obj) //validate field value, numeric or not, obj = field object :: Form1.txtQty
{
	var d = document.all;
	number = remChar(obj.value, ',');
	
	if (((number / number) != 1) && (number != 0)) 
	{
		alert('Masukkan angka!');
		obj.value = '0';
		obj.focus();
		return false;
	}
}

function outputInt(snumber)
{	
	var snumber = remChar(snumber, ',');
	
	return outputAbs(Math.floor(snumber-0) + '');
}

function IsNumericQty(obj) //validate field value, numeric or not, obj = field object :: Form1.txtQty
{
	var d = document.all;
	number = remChar(obj.value, ',');
	
	if (((number / number) != 1) && (number != 0)) 
	{
		alert('Please enter only a number into this field!');
		obj.value = '0';
		obj.focus();
		return false;
	}
	else //reformat numeric	
	{
		obj.value = outputQty(number);
		return true;
	}
}

function outputQty(snumber)
{	
	var snumber = remChar(snumber, ',');
	
	return outputAbs(Math.floor(snumber-0) + '') + outputDec(snumber - 0);
}

function outputAbs(number) //used in outputQty function
{
	if (number.length <= 3)
		return (number == '' ? '0' : number);
	else {
		var mod = number.length%3;
		var output = (mod == 0 ? '' : (number.substring(0,mod)));
		for (i=0 ; i < Math.floor(number.length/3) ; i++)
		{
			if ((mod ==0) && (i ==0))
				output+= number.substring(mod+3*i,mod+3*i+3);
			else
				output+= ',' + number.substring(mod+3*i,mod+3*i+3);
		}
		return (output);
	}
}

function outputDec(amount) //used in outputQty function, show 3 digit decimal
{
	amount = Math.round( ( (amount) - Math.floor(amount) ) *1000);
	if(amount >= 100)
		return '.' + amount;
	else if(amount < 100 && amount >= 10)
		return '.0' + amount;
	else if(amount < 10)
		return '.00' + amount;
}

function AltTableColor(sTableName) //coloring table rows
{
	var d = document.all[sTableName];
	
	d.rows[0].className = 'clsTabHeader';
	
	for(i=1; i<d.rows.length; i++)
	{
		if(i % 2 == 0)
			d.rows[i].className = 'clsTabEven';
		else
			d.rows[i].className = 'clsTabOdd';
	}
}

function custTable(sTableName) //need more customizations
{
	var myTable = document.all[sTableName];
	var myRow;
	for(var i=1; i<MyTable.rows.length; i++) //i=1, 0=header
	{
		myRow = MyTable.rows[i];
		myRow.style.backgroundColor = 'Bisque';
		myRow.style.fontWeight = 'bold';
	}
}

function CDate(sDate) //sDate = dd/MM/yyyy
{
    var arr = new Array();
    arr = sDate.split('/');
    
    var myDate = new Date(arr[1] + '/' + arr[0] + '/' + arr[2]);
    
    return myDate;
}

function amountOnFocus(obj)
{
    if(ConvertToNumeric(obj.value) == 0)
    {
        obj.value = '';
    }
}
function SetBackground(obj,idx)
{
	if(idx % 2 == 0)
		obj.className = 'clsMouseOutTabEven';
	else
		obj.className = 'clsMouseOutTabOdd';
}

function Logout()
{
    if(!confirm('Anda yakin mau keluar?'))
        return false;
    else
        location = '/jstextranet/login.aspx';
}

function onSave()
{
    document.getElementById('tabActionWait').style.display = '';
    document.getElementById('tabAction').style.display = 'none';
}

function getSubTotal(x, a, b)
{
    document.getElementById(a).value = outputMoney(document.getElementById(a).value);
    document.getElementById(b).value = outputMoney(document.getElementById(b).value);

    var total = CNum(document.getElementById(a).value) * CNum(document.getElementById(b).value);
    document.getElementById(x).value = outputMoney(String(total));
}

function findJ(i)
{
    var j = '';
    if(i<10)
        j = '0' + i;
    else
	    j = i;
	    
	return j;
}

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
            document.getElementById('ctl00_cph_txtBidbondMin').value = outputMoney(String(minbodbond));
        }
        else
            document.getElementById('ctl00_cph_txtBidbondMin').value = '0';
     }
     else
     {
        if(totafterppn >= CNum(document.getElementById('ctl00_cph_txtBidBondMinUSD').value))
        {
            document.getElementById('ctl00_cph_txtBidbondMin').value = outputMoney(String(minbodbond));
        }
        else
            document.getElementById('ctl00_cph_txtBidbondMin').value = '0';
     }

	document.getElementById('ctl00_cph_txtTotal').value = outputMoney(String(tot));
    if(document.getElementById('ctl00_cph_txtIsPKP').value == '1')
        document.getElementById('ctl00_cph_txtTotalAfterPPN').value = outputMoney(String(totafterppn));
    else
        document.getElementById('ctl00_cph_txtTotalAfterPPN').value = document.getElementById('ctl00_cph_txtTotal').value;
    
}
  