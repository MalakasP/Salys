<?php

class cityController extends Controller
{
    public function index($pageId, $country, $search = '', $sort = 'ASC', $success = '')
    {       
        $data['title'] = 'Cities';

        $data['pageId'] = $pageId;

        $data['sort'] = $sort;

        $data['success'] = $success;

        $data['country'] = $country;

        $this->view('main', $data);
    }

    public function pager($pageId, $country, $search, $sort, $from = '', $to = '')
    {
        $data['module'] = 'cityController';

        $data['country'] = $country;

        $data['search'] = $search;

        $data['sort'] = $sort;

        $data['date_from'] = $from;

        $data['date_to'] = $to;

        $data['paging'] = $this->paging($pageId, $country, $search);

        if($data['paging']->totalRecords != 0)
        {
            $this->view('paging', $data);
        }

    }

    public function paging($pageId, $country, $search, $from = '', $to = '')
    {

        $paging = new paging(config::NUMBER_OF_ROWS_IN_PAGE);

        $city = $this->model('City');

        if ($search !== '') {
            $count = $city->getCountryCityListCount($country, $search);
        } else {
            $count = $city->getCountryCityListCount($country);
        }

        if($search !== ''){ 
            if ($from !== '')
            {
                if ($to !== '')
                {
                    $count = $city->getCountryCityListCount($country, $search, $from, $to);
                } else {
                    $count = $city->getCountryCityListCount($country, $search, $from);                }
                     
            } else if ($to !== '') {

                $count = $city->getCountryCityListCount($country, $search, null, $to);   
            } else {
                $count = $city->getCountryCityListCount($country, $search);  
            }
        } else {
            if ($from !== '')
            {
                if ($to !== '')
                {
                    $count = $city->getCountryCityListCount($country, null, $from, $to);  
                } else {
                    $count = $city->getCountryCityListCount($country, null, $from);  
                }
            } else if ($to !== '') {
                $count = $city->getCountryCityListCount($country, null, null, $to);  
            } else {
                $count = $city->getCountryCityListCount($country);  
            }
        }

        $paging->process($count, $pageId);

        return $paging;
    }

    public function list($pageId, $country, $search, $sort, $from = '', $to = '')
    {
        $data['module'] = 'cityController';

        $data['country'] = $country;

        $data['search'] = $search;

        $data['sort'] = $sort;

        $data['date_from'] = $from;

        $data['date_to'] = $to;

        $data['nr'] = (((int)$pageId - 1) * 10) + 1;

        $city = $this->model('City');

        $paging = $this->paging($pageId, $country, $search);

        if($search !== ''){ 
            if ($from !== '')
            {
                if ($to !== '')
                {
                    $data['cities'] = $city->getCountryCityList($paging->size, $paging->first, $country, $sort, $search, $from, $to);
                } else {
                    $data['cities'] = $city->getCountryCityList($paging->size, $paging->first, $country, $sort, $search, $from);
                }
                     
            } else if ($to !== '') {
                $data['cities'] = $city->getCountryCityList($paging->size, $paging->first, $country, $sort, $search, null, $to); 
            } else {
                $data['cities'] = $city->getCountryCityList($paging->size, $paging->first, $country, $sort, $search);
            }
        } else {
            if ($from !== '')
            {
                if ($to !== '')
                {
                    $data['cities'] = $city->getCountryCityList($paging->size, $paging->first, $country, $sort, null, $from, $to);
                } else {
                    $data['cities'] = $city->getCountryCityList($paging->size, $paging->first, $country, $sort, null, $from);
                }
            } else if ($to !== '') {
                $data['cities'] = $city->getCountryCityList($paging->size, $paging->first, $country, $sort, null, null, $to); 
            } else {
                $data['cities'] = $city->getCountryCityList($paging->size, $paging->first, $country, $sort); 
            }
        }
        $this->view('cityList', $data);
    }

    public function create($pageId, $country, $values = [])
    {

        $data['country'] = $country;

        $data['module'] = 'cityController';

        $city = $this->model('City');

        $data['formErrors'] = null;

        $data['sqlError'] = null;

        $data['required'] = array('name','area', 'population', 'postal_code');

        $data['maxLengths'] = array(
            'name' => 30,
            'population' => 11,
            'postal_code' => 15         
        );

        if(isset($values['name']))
        {
            $values['country'] = $country;

            $validations = array (
                'name' => 'words',
                'area' => 'float',
                'population' => 'int',
                'postal_code' => 'anything'
                );
            
            $validator = $this->validator($validations, $data['required'], $data['maxLengths']);
            
            if($validator->validate($values)) {
                $dataPrepared = $validator->preparePostFieldsForSQL();
        
                $data['sqlError'] = $city->insertCity($dataPrepared);
                if (($data['sqlError'] !== false) && (isset($data['sqlError']))){
                    $this->index(1, $country, '', 'ASC', 'City has been added to the country!');
                    die();
                } else{
                    $result = $city->getAutoIncrement();
                    foreach($result as $key => $val) {
                        $aIncrement = (int)$val['AUTO_INCREMENT'];
                    }
                    $aIncrement = $aIncrement - 1;
                    $city->setAutoIncrement($aIncrement);
                }
            } else {
                
                $data['formErrors'] = $validator->getErrorHTML();

            }
        }
        $this->view('cityForm', $data);
    }

    public function edit($id, $pageId, $country, $values = [])
    {
        $city = $this->model('City');

        $data['country'] = $country;

        $data['module'] = 'cityController';

        $data['formErrors'] = null;

        $data['required'] = array('name','area', 'population', 'postal_code');

        $data['maxLengths'] = array(
            'name' => 30,
            'population' => 11,
            'postal_code' => 15      
        );

        if(!empty($_POST['submit']))
        {
            $values['id'] = (int)$id;
    
            $validations = array (
                'name' => 'words',
                'area' => 'float',
                'population' => 'int',
                'postal_code' => 'anything'
                );
            
            $validator = $this->validator($validations, $data['required'], $data['maxLengths']);
            
            if($validator->validate($values)) {
                $dataPrepared = $validator->preparePostFieldsForSQL();

                $city->updateCity($dataPrepared);

                $this->index(1, $country, '', 'ASC', 'City has been modified!');
                die();

            } else {               
                $data['formErrors'] = $validator->getErrorHTML();
            }
        }
        $data['city'] = $city->getCity($id); 
        $this->view('cityForm', $data);
    }

    public function delete($id, $pageId, $country)
    {
        $city = $this->model('City');

        if(!empty($id)) {
            
            $city->deleteCity($id);
 
            $this->index(1, $country, '', 'ASC', 'City has been deleted!');

            die();
        }
    }
}