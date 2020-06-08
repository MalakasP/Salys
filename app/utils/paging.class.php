<?php

class Paging {
	private $pageRange;
	
	public $first;
	public $size;
	
	public $totalRecords;
	public $totalPages;
	
	public $data = array();
	
	public function __construct($rowsPerPage) {
		$this->size = $rowsPerPage;
		$this->pageRange = 5;
	}
	
	public function process($total, $currentPage) {

		$pageCount = ceil($total / $this->size);
		
		$this->totalRecords = (int) $total;
		$this->totalPages = (int) ($pageCount) ? $pageCount : 1;
		$this->first = ($currentPage - 1) * $this->size;

		for($i = 1; $i <= $pageCount; $i++) {
			$row['isActive'] = ($i == $currentPage) ? 1 : 0;
			$row['page'] = $i;
			
			$this->data[] = $row;
		}		
	}
}

?>