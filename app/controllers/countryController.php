<?php

class countryController extends Controller
{

    public function index($pageId, $search = '', $sort = 'ASC', $success = '')
    {
        $data['title'] = 'Countries';

        $data['pageId'] = $pageId;

        $data['sort'] = $sort;

        $data['success'] = $success;

        $this->view('main', $data);
    }

    public function pager($pageId, $search, $sort, $from = '', $to = '')
    {
        $data['module'] = 'countryController';

        $data['search'] = $search;

        $data['sort'] = $sort;

        $data['date_from'] = $from;

        $data['date_to'] = $to;

        $data['paging'] = $this->paging($pageId, $search, $from, $to);

        if($data['paging']->totalRecords != 0)
        {
            $this->view('paging', $data);
        }

    }

    function paging($pageId, $search, $from = '', $to = '')
    {

        $paging = new paging(config::NUMBER_OF_ROWS_IN_PAGE);

        $country = $this->model('Country');

        if($search !== ''){ 
            if ($from !== '')
            {
                if ($to !== '')
                {
                    $count = $country->getCountryListCount($search, $from, $to);
                } else {
                    $count = $country->getCountryListCount($search, $from);
                }
                     
            } else if ($to !== '') {
                $count = $country->getCountryListCount($search, null, $to);
            } else {
                $count = $country->getCountryListCount($search);
            }
        } else {
            if ($from !== '')
            {
                if ($to !== '')
                {
                    $count = $country->getCountryListCount(null, $from, $to);
                } else {
                    $count = $country->getCountryListCount(null, $from);
                }
            } else if ($to !== '') {
                $count = $country->getCountryListCount(null, null, $to);
            } else {
                $count = $country->getCountryListCount();
            }
        }
        $paging->process($count, $pageId);

        return $paging;
    }

    public function list($pageId, $search, $sort, $from = '', $to = '')
    {

        $data['module'] = 'countryController';

        $data['pageId'] = $pageId;

        $data['search'] = $search;

        $data['sort'] = $sort;

        $data['date_from'] = $from;

        $data['date_to'] = $to;

        $data['nr'] = (((int)$pageId - 1) * 10) + 1;
        
        $country = $this->model('Country');

        $paging = $this->paging($pageId, $search);
        
        if($search !== ''){ 
            if ($from !== '')
            {
                if ($to !== '')
                {
                    $data['countries'] = $country->getCountryList($paging->size, $paging->first, $sort, $search, $from, $to);
                } else {
                    $data['countries'] = $country->getCountryList($paging->size, $paging->first, $sort, $search, $from);
                }
                     
            } else if ($to !== '') {
                $data['countries'] = $country->getCountryList($paging->size, $paging->first, $sort, $search, null, $to); 
            } else {
                $data['countries'] = $country->getCountryList($paging->size, $paging->first, $sort, $search);
            }
        } else {
            if ($from !== '')
            {
                if ($to !== '')
                {
                    $data['countries'] = $country->getCountryList($paging->size, $paging->first, $sort, null, $from, $to);
                } else {
                    $data['countries'] = $country->getCountryList($paging->size, $paging->first, $sort, null, $from);
                }
            } else if ($to !== '') {
                $data['countries'] = $country->getCountryList($paging->size, $paging->first, $sort, null, null, $to); 
            } else {
                $data['countries'] = $country->getCountryList($paging->size, $paging->first, $sort); 
            }
        }
        $this->view('countryList', $data);
    }   
    
    public function create($pageId, $values = [])
    {

        $country = $this->model('Country');

        $data['formErrors'] = null;

        $data['sqlError'] = null;

        $data['required'] = array('name','area', 'population');

        $data['maxLengths'] = array(
            'name' => 30,
            'area' => 11
        );
        if(isset($values['name']))
        {
    
            $validations = array (
                'name' => 'words',
                'area' => 'int',
                'population' => 'float'
                );
            
            $validator = $this->validator($validations, $data['required'], $data['maxLengths']);
            
            if($validator->validate($values)) {
                $dataPrepared = $validator->preparePostFieldsForSQL();

                $data['sqlError'] = $country->insertCountry($dataPrepared);
                if (($data['sqlError'] !== false) && (isset($data['sqlError']))){

                    $this->index(1, '', 'ASC', 'Country has been added!');

                    die();

                } else {
                    
                    $result = $country->getAutoIncrement();
                    foreach($result as $key => $val) {
                        $aIncrement = (int)$val['AUTO_INCREMENT'];
                    }

                    $aIncrement = $aIncrement - 1;
                    $country->setAutoIncrement($aIncrement);

                }

            } else {
                
                $data['formErrors'] = $validator->getErrorHTML();
            }
        }
        $this->view('countryForm', $data);
    }

    public function edit($id, $pageId, $values = [])
    {
        $country = $this->model('Country');

        $data['formErrors'] = null;

        $data['required'] = array('name','area', 'population');

        $data['maxLengths'] = array(
            'name' => 30,
            'area' => 11
        );

        if(!empty($_POST['submit']))
        {
            $values['id'] = (int)$id;
    
            $validations = array (
                'name' => 'words',
                'area' => 'int',
                'population' => 'float'
                );
            
            $validator = $this->validator($validations, $data['required'], $data['maxLengths']);
            
            if($validator->validate($values)) {
                $dataPrepared = $validator->preparePostFieldsForSQL();

                $country->updateCountry($dataPrepared);

                $this->index(1, '', 'ASC', 'Country has been modified!');

                die();

            } else {
                $data['formErrors'] = $validator->getErrorHTML();
            }
        }
        $data['country'] = $country->getCountry($id);
        $this->view('countryForm', $data);
    }

    public function delete($id, $pageId, $country)
    {
        $city = $this->model('City');

        if(!empty($id)) {

            $city->deleteCountryCities($country);

            $countryModel = $this->model('Country');

            $countryModel->deleteCountry($id);

            $this->index(1, '', 'ASC', 'Country has been deleted!');

            die();
        }
    }


}