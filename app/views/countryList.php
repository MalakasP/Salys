<ul id="pagePath" class="float-left">
                    <li><a href="index.php">Countries</a></li>
</ul>	
<div id="actions" >
	<a class="bttn" style="padding:5" href='index.php?module=<?php echo $data['module']; ?>&action=create'>New country</a>
</div>
<div class="float-clear"></div>

<?php
if ($data['countries'] != null){
?>
	<table class="listTable">
		<tr>
			<th>Nr</th>
			<th>Name
				<a href='index.php?module=countryController&action=index&sort=ASC'>^</a>
				<a href='index.php?module=countryController&action=index&sort=DESC'>˅</a>
			</th>
			<th>Area (Km<sup style="font-size: 70%;vertical-align: super;">2</sup>)</th>
			<th>Population (Mill.)</th>
			<th>Added date</th>
			<th></th>
		</tr>
		<?php
			$nr = $data['nr'];
			foreach($data['countries'] as $key => $val) {
				echo
					"<tr>"
						. "<td>{$nr}</td>"
						. "<td>"
						. "<a href='index.php?module=cityController&action=index&country={$val['name']}' title=''>{$val['name']}</a>"
						. "</td>"
						. "<td>{$val['area']}</td>"
						. "<td>{$val['population']}</td>"
						. "<td>{$val['timestamp']}</td>"
						. "<td>"
							. "<a href='#' onclick='showConfirmDialog(\"{$data['module']}\", \"{$val['id']}\" , \"{$val['name']}\"); return false;' title=''>delete</a>&nbsp;"
							. "<a href='index.php?module={$data['module']}&action=edit&id={$val['id']}' title=''>edit</a>"
						. "</td>"
					. "</tr>";
				$nr = $nr + 1;
			}
} else if ($data['countries'] == null && ($data['date_from'] !== null || $data['date_to'] !== null)) {
	echo "<tr>Could not find any countries.</tr>";
} else{
	echo "<tr>There are no countries yet. Add a country. </tr>";
}	?>
</table>
<div id="paging"></div>
</div>

<script type="text/javascript">
	var queryString = window.location.search;
	var urlParams = new URLSearchParams(queryString);
	var sort = "<?php Print($data['sort']); ?>";
	var search = "<?php Print($data['search']); ?>";
	var date_from = "<?php Print($data['date_from']); ?>";
	var date_to = "<?php Print($data['date_to']); ?>";
	if (urlParams.get('page') != null)
	{
		var page = urlParams.get('page')
	} else 
	{
		var page = "<?php Print($data['pageId']); ?>";
	}
	$('#paging').load('index.php?module=countryController&action=pager&page=' + page + '&search=' + search + '&sort=' + sort + '&from=' + date_from + '&to=' + date_to);

	
</script>
