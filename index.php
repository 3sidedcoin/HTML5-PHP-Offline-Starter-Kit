<!doctype html> 
<html manifest="country.appcache">
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
<meta name="description" content="html5 offlineapp with javascript and php"/>
<meta name="author" content="3sided coin"/>
<head>
  <title>offline app with html5, javascript and php</title>  
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script type="text/javacsript" src="js/json.js"></script>
<script type="text/javascript" src="js/modernizr.min.js"></script>
  <script type="text/javascript" >
  $(document).ready(function()
	{
		getResponesFromServer();
	});
  /*** this function store country list in client side localstorage **/
	function getResponesFromServer()
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
									
									
								},
				error:function ()
								{
									/** if internate connection is not avaliable then display error msg ***/
									//alert('Unable to connect to the Internet'); 
								}					
				
			});
	}
  </script>
</head>
<body>
	<h1>Index</h1>
	<ul>
		<li>
			<a href="countryname.php" >Country List</a>
		</li>
		<li>
			<a href="fileupload.php" >File Upload</a>
		</li>
	</ul>
	
</body>
</html>