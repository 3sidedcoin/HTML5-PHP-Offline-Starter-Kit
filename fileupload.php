
<!doctype html> 
<html manifest="country.appcache">
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
<meta name="description" content="html5 offline File upload"/>
<meta name="author" content="3sided coin"/>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>

<head>
  <title>File Upload </title>
<script type="text/javascript">


$(document).ready(function()
{	
	if(localStorage['fileupload'])
			document.getElementById("uploadPreview").src = localStorage['fileupload'];
			
/*** file reader is javascript api for reading file on client side ***/		
	oFReader = new FileReader(), rFilter = /^(image\/bmp|image\/cis-cod|image\/gif|image\/ief|image\/jpeg|image\/jpeg|image\/jpeg|image\/pipeg|image\/png|image\/svg\+xml|image\/tiff|image\/x-cmu-raster|image\/x-cmx|image\/x-icon|image\/x-portable-anymap|image\/x-portable-bitmap|image\/x-portable-graymap|image\/x-portable-pixmap|image\/x-rgb|image\/x-xbitmap|image\/x-xpixmap|image\/x-xwindowdump)$/i;

	oFReader.onload = function (oFREvent)
	{	
			document.getElementById("uploadPreview").src = oFREvent.target.result;
			localStorage['fileupload']=oFREvent.target.result;//dataUrls of image store in localStorage 
		
	};

	$('#fileupload').change(function()
	{								
		if (document.getElementById("fileupload").files.length === 0) { return; }
			var oFile = document.getElementById("fileupload").files[0];
		if (!rFilter.test(oFile.type)) 
			{ alert("You must select a valid image file!"); return; }
		oFReader.readAsDataURL(oFile);
	});
							
});
</script>
</head>
<body>

<input type="file" id="fileupload" name="fileupload"  /><br/>
Display  Uploaded image<br/>
<img id="uploadPreview" style="width: 100px; height: 100px;" />
</body>
</html>