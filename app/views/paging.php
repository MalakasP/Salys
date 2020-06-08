<div id="pagingLabel">
	Pages:
</div>
<ul id="paging">
	<?php 
	foreach ($data['paging']->data as $key => $value) {
		$activeClass = "";
		if($value['isActive'] == 1) {
			$activeClass = " class='active'";
		}
		if (isset($data['country'])){
			if (isset($data['sort'])){
				echo "<li{$activeClass}><a href='index.php?module={$data['module']}&action=index&page={$value['page']}&country={$data['country']}&sort={$data['sort']}'>{$value['page']}</a></li>";
			} else {
				echo "<li{$activeClass}><a href='index.php?module={$data['module']}&action=index&page={$value['page']}&country={$data['country']}'>{$value['page']}</a></li>";
			}
		} else {
			if (isset($data['sort'])){
				echo "<li{$activeClass}><a href='index.php?module={$data['module']}&action=index&page={$value['page']}&sort={$data['sort']}'>{$value['page']}</a></li>";
			} else {
				echo "<li{$activeClass}><a href='index.php?module={$data['module']}&action=index&page={$value['page']}'>{$value['page']}</a></li>";
			}
		}
	} ?>
</ul>