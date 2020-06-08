<ul id="pagePath">
	<li><a href="index.php">Countries</a></li>
	<li><a href='index.php?module=<?php echo $data['module'] ?>&action=index&country=<?php echo $data['country'] ?>'><?php echo $data['country'] ?></a></li>
</ul>
<div id="actions">
	<a class="bttn" style="padding:5" href='index.php?module=<?php echo $data['module']; ?>&action=create&country=<?php echo $data['country']; ?>'>New city</a>
</div>
<div class="float-clear"></div>
<?php
if ($data['cities'] != null){
?>
	<table class="listTable">
		<tr>
			<th>Nr</th>
			<th>Name
				<a href='index.php?module=cityController&action=index&country=<?php echo $data['country'];?>&sort=ASC'>^</a>
				<a href='index.php?module=cityController&action=index&country=<?php echo $data['country'];?>&sort=DESC'>˅</a>
			</th>
			<th>Area (Km<sup style="font-size: 70%;vertical-align: super;">2</sup>)</th>
			<th>Population</th>
			<th>Postal Code</th>
			<th>Added date</th>
			<th></th>
		</tr>
		<?php
			// suformuojame lentelę
				$nr = $data['nr'];
				foreach($data['cities'] as $key => $val) {
					echo
						"<tr>"
							. "<td>{$nr}</td>"
							. "<td>{$val['name']}</td>"
							. "<td>{$val['area']}</td>"
							. "<td>{$val['population']}</td>"
							. "<td>{$val['postal_code']}</td>"
							. "<td>{$val['timestamp']}</td>"
							. "<td>"
								. "<a href='#' onclick='showConfirmDialog(\"{$data['module']}\", \"{$val['id']}\", \"{$val['fk_country']}\"); return false;' title=''>delete</a>&nbsp;"
								. "<a href='index.php?module={$data['module']}&action=edit&id={$val['id']}&country={$val['fk_country']}' title=''>edit</a>"
							. "</td>"
						. "</tr>";
					$nr = $nr + 1;
				}
} else if ($data['cities'] == null && ($data['date_from'] !== null || $data['date_to'] !== null)) {
	echo "<div>Could not find any cities.</div>";
} else {
	echo "<tr>There are no cities in this country yet. Add a city.</tr>";
}	?>
	</table>
	<div id="paging"></div>

<script type="text/javascript">
	var queryString = window.location.search;
	var urlParams = new URLSearchParams(queryString);
	var country = urlParams.get('country');
	var sort = "<?php Print($data['sort']); ?>";
	var search = "<?php Print($data['search']); ?>";
	var date_from = "<?php Print($data['date_from']); ?>";
	var date_to = "<?php Print($data['date_to']); ?>";
	if (urlParams.get('page') != null)
	{
		var page = urlParams.get('page')
	} else 
	{
		var page = "<?php if(isset($data['pageId'])) { Print($data['pageId']); } ?>";
	}
	$('#paging').load('index.php?module=cityController&action=pager&country=' + country + '&page=' + page + '&search=' + search + '&sort=' + sort + '&from=' + date_from + '&to=' + date_to);  
	
</script>