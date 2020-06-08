<!DOCTYPE html PUBLIC>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="robots" content="noindex">
        <link rel="stylesheet" type="text/css" href="../app/style/main.css" media="screen" />
        <script type="text/javascript" src="../app/scripts/jquery-2.1.1.min.js"></script>
		<script type="text/javascript" src="../app/scripts/main.js"></script>
	</head>
	<body>
		<div id="body">
			<div id="header">
				<h3 id="slogan">
					<?php
					if (isset($data['country']))
					{ 
						echo $data['country'] . ' '. $data['title'];
					} else {
						echo $data['title'];
					}
					?>
				</h3>
			</div>
			<div id="content">	

				<div class="float-left">
					<button style="float: right; padding: 3" class="bttn" onclick="date_filter();" type="submit">Filter</button>
					<label for="tp_from" style="float: left; padding: 5">Date from:</label>
					<input id="date_from" style="float: left;" class="bttn" type="date" name="tp_from" value="">
					<label for="tp_to" style="float: left; padding: 5">Date to:</label>
					<input id="date_to" style="float: left;" class="bttn" type="date" name="tp_to" value="">
					
				</div>
				<div class="float-right">
					<button style="float: right;" class="bttn" onclick="lookFor();" type="submit">Search</button>
					<input id="search" style="float: right;" class="bttn" type="text" name="search" value="">
					<br>
				</div>
				
				<div id="contentMain">
					<div class="float-clear"></div>
				</div>
			</div>
			<div id="footer">
			</div>
        </div>
         
		<script type="text/javascript">
		var sort = "<?php if(isset($data['sort'])) Print($data['sort']); ?>";

		var success = "<?php if(isset($data['success'])) Print($data['success']); ?>";
		console.log(success);
		if (success)
		{
			alert(success);
		}

		var urlParams = getUrlParams();
		if (urlParams.get('page') != null)
		{
			var page = urlParams.get('page')
		} else 
		{
			var page = "<?php if (isset($data['pageId'])) { Print($data['pageId']); }?>";
		}
        if (window.location.href.indexOf("cityController") > -1)
        {
			var country = getCountry();
			
            $('#contentMain').load('index.php?module=cityController&action=list&country=' + country + '&page=' + page + '&sort=' + sort );
        } else 
		{
            $('#contentMain').load('index.php?module=countryController&action=list&page=' + page + '&sort=' + sort);
		}
		
        </script>
	</body>
</html>

