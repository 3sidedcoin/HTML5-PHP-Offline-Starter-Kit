<!doctype html> 
<html manifest="country.appcache">
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
<meta name="description" content="html5 offlineapp with javascript and php"/>
<meta name="author" content="3sided coin"/>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script type="text/javacsript" src="js/json.js"></script>
<script type="text/javascript" src="js/modernizr.min.js"></script>
<head>
  <title>offline app with html5, javascript and php</title>
<script type="text/javascript">
$(document).ready(function()
{

	/*** check browser support localstorage and offline features or not ***/
	if(Modernizr.localstorage)
		$('#localstorage').html("support localstorage");
	else
		$('#localstorage').html("not support  localstorage");
	
	if(Modernizr.applicationcache)	
		$('#offline').html("support offline");	
	else	
		$('#offline').html("not support  offline");
		
	/*** check results of countrylist store in localstorage or not 
		if not then send ajax request to server and store results in localstorage because when application is offline 
				at that time we use this results to display 	on the screen 				
		if yes then retrive results from localstorage 	and display on the screen ***/	
	
	if( ! localStorage['countrylist'] )		
			getResponesFromServer();	
	else
	{
		var items = [];
		var country=JSON.parse(localStorage['countrylist']);		
		
		for(var i=0;i<country.length;i++)
			items.push('<li >' +country[i].code+"  " + country[i].name + '</li>');
		
		$('#countrylist').html('<br/>Country Information List	<br/>');
		$('<ul/>', {
				'class': 'my-new-list',
				html: items.join('')
		 }).appendTo('#countrylist');	
	}	
});

/** store new country (name and code) enter by user on clinet side ****/
function save()
{
	var country=JSON.parse(localStorage['countrylist']);
	
	var name=$('#name').val();
	var code=$('#code').val();
	if(name == '' && code == '')
	{
		alert('enter country name and code ');
		return;
	}
	else if(name == '')
	{
		alert('enter country name ');
		return;
	}
	else if(code == '')
	{
		alert('enter country code ');
		return;
	}
	else
	{
		var length=country.length;	
		var newcountrylist= new Object;
		newcountrylist.name=name;
		newcountrylist.code=code;
		
		country[length] = newcountrylist; /** add new country information in client localstorage ***/
			
		JSONstring = JSON.stringify(country);
		localStorage['countrylist']=JSONstring;
		/** new localstorage variable for  maintain new country information  list ****/
		if(localStorage['newcountry'])
		{
			var newcountry=JSON.parse(localStorage['newcountry']); 
			newcountry[newcountry.length] = newcountrylist;
			localStorage['newcountry'] = JSON.stringify(newcountry);
		}
		else
		{
			var newcountry=Array();
			newcountry[0]=newcountrylist;
			localStorage['newcountry'] = JSON.stringify(newcountry);
		}	
		
		var items = [];
			var country=JSON.parse(localStorage['newcountry']);		
			
			for(var i=0;i<country.length;i++)
				items.push('<li >'+country[i].code +" "+ country[i].name + '</li>');
				
			$('#newcountrylist').html('<br/>New Added Country Information List	<br/>');
			$('<ul/>', {
						'class': 'my-new-list',
						html: items.join('')
					 }).appendTo('#newcountrylist');	
			
	}
	
}
/*** add new country (name and code ) to database ****/
function sync()
{
	if(localStorage['newcountry'])
	{
	var datastring="data="+localStorage['newcountry'];
		$.ajax(
			{
				url:'include/syncCountryData.php',
				data:datastring,
				type:'post',
				success:function(html)
								{
									localStorage.removeItem("newcountry"); 
									var countrydata=JSON.parse(html);
									var country=countrydata.country;
									var items = [];
									localStorage['countrylist']=JSON.stringify(country);
									for(var i=0;i<country.length;i++)
									 	items.push('<li >'+ country[i].code+"  " + country[i].name + '</li>');
										$('#msg').html('');
									$('#countrylist').html('<br/>New Country Information store successfully into database<br/>');
									$('<ul/>', {
											'class': 'my-new-list',
											html: items.join('')
									 }).appendTo('#countrylist');	
									
								},
				error:function ()
								{
									alert('Unable to connect to the Internet'); 
								}				
				
			});
		}
		else		
		{
			//alert('enter new country information before sync');
			/** update local storage information 
				if  anyother user add new country ***/
				
			getResponesFromServer(true);
		}
}

function getResponesFromServer(sync)
{
	$.ajax(
			{
				url:'include/generateJsonCountryList.php',
				data:'',
				type:'post',
				success:function(html)
								{
									
									var countrydata=JSON.parse(html);
									var country=countrydata.country;
									var items = [];
									localStorage['countrylist']=JSON.stringify(country);
									for(var i=0;i<country.length;i++)
									 	items.push('<li >'+ country[i].code+"  " + country[i].name + '</li>');
									 
									$('#countrylist').html('<br/>Country Information List	<br/>');
									$('<ul/>', {
											'class': 'my-new-list',
											html: items.join('')
									 }).appendTo('#countrylist');
									 
								if(sync) // display confirmation msg for sync button click event
									$('#msg').html('Update County Information List successfully');									
									
								},
				error:function ()
								{
									/** if internate connection is not avaliable then display error msg ***/
									alert('Unable to connect to the Internet'); 
								}					
				
			});
}
</script>
</head>
<body>
<div id="status">
<span id="localstorage"></span><br/>
<span id="offline"></span><br/>

</div>
Country Name<input type="text" id="name" name="name"/>
Country Code<input type="text" id="code" name="code"/>
<button id="add"  onclick="save()">Submit</button>
<button onclick="sync()" >Sync</button>
<br/><br/>
<div id="msg"></div>
<div id="countrylist"></div>
<div id="newcountrylist"></div>
</body>
</html>