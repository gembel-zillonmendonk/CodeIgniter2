function openWindow(sURL, sHeight, sWidth, sName, sScrollbars) //open new window with option enable or disable scrollbar
{
    if(sScrollbars == null) sScrollbars = 'yes';
	if(sName == null || sName == '') sName = 'NewWindow';
	LeftPosition = (screen.width) ? (screen.width-sWidth)/2 : 0;
	TopPosition = (screen.height) ? (screen.height-sHeight)/2 : 0;
	window.open(sURL, sName, "toolbar=no scrollbars="+ sScrollbars +" height=" + sHeight + " width=" + sWidth + " top=" + TopPosition + " left=" + LeftPosition);
	
	return(false);
}
