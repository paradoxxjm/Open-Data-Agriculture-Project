<?php
class CropsController extends AppController {

	var $name = 'Crops';
	var $helpers = array ('Html', 'Form');
    var $components = array('RequestHandler', 'Webservice.Webservice');     //Components to manage exportation to xml & json
	var $vegCrops = array();
	var $frucrops = array();
	var $perCrops = array();
	var $v, $f, $p;
	var $a;
	var $n;
	/*This variable is used to manage the amount and ordering of data that is passed 
    to view (See http://book.cakephp.org/view/1231/Pagination for details  */
    //var $paginate = array( 'conditions'=>array("Parish" => "ST.ANN"),'limit' => 30);
	var $paginate = array(
            'limit' => 1000
        );
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	
	//=====================================================================================================================
	/*Function: queryString
    *Input: Array of URL posted parameters
    *Output: SQL query string
    *=====================================
    *

    function queryString($urlParams) {
        print_r($urlParams);
        //echo count($urlParams);
        $query = "";
        $arrCount = 2;
        if (count($urlParams) > 2) {
            foreach ( $urlParams as $column=>$param) { 
                if ($column != 'ext' && $column != 'url') {
                    $arrCount++;
                    $query .= (($arrCount < count($urlParams) ? ("Farm.$column='$param' AND ") :  ("Farm.$column='$param'") ));
                }
            }
        }
        return $query;
    }
	//*///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function index() {
	function queryString($urlParams) {
        //print_r($urlParams);
        //echo count($urlParams);
        $query = "";
        $arrCount = 2;
        if (count($urlParams) > 2) {
            foreach ( $urlParams as $column=>$param) { 
                if ($column != 'ext' && $column != 'url') {
                    $arrCount++;
                    $query .= (($arrCount < count($urlParams) ? ("Crop.$column='$param' AND ") :  ("Crop.$column='$param'") ));
                }
            }
        }
        return $query;
    }
		
		$this->View = 'Webservice.Webservice';
		$url = $this->params['url'];
		//$url['ext']= "xml";
        //print_r($url);
        
                
		if ($url['ext']=="html"){
			$query = queryString($url);
			$this->paginate = array('fields'=>array('CropGroup','CropType','COUNT(Crop.PropertyID)'),'group'=>array('CropType'), 'conditions'=>$query, 'limit'=>1000);
			$table = $this->paginate('Crop');
			$this->set('crops', $table);
			$this->View = 'Webservice.Webservice';
		}
		else{
			$query = queryString($url);
			$returndata= false;
			$this->View = 'Webservice.Webservice';
			//$data = $this->paginate('Crop');
			if ($query == ""){
				$returndata= false;
				$data = $this->Crop->find('all', array('fields'=>array('CropGroup','CropType','COUNT(Crop.PropertyID)'),'group'=>array('CropType'), 'conditions'=>$query));//,'limit'=>100)); 
			}
			else {
				$returndata=true;
				$data = $this->Crop->find('all', array('fields'=>array('CropGroup','CropType','COUNT(Crop.PropertyID)'),'group'=>array('CropType'), 'conditions'=>$query));//,'limit'=>100)); 
				
				
			}

			//loop through data passed in to reformat based on xml output specifications
			
			$v = 0; $f = 0; $p = 0;
			
			foreach($data as $index){
				if ($index['Crop']['CropGroup']=="Vegetables"){
					for ($n=0; $n<$v; $n++){
						if ($v==0){
							$vegCrops[$v]= array('Name'=>$index['Crop']['CropType'],'Count'=>$index['0']['COUNT(`Crop`.`PropertyID`)']);
							$v++;
							break;
						}
						else if ($index['Crop']['CropType'] == $vegCrops[$n]['Name']){
							$vegCrops[$n]['Count']+=1;
							
							break;
						}
					}
					if($n >= $v) {
						$vegCrops[$v]= array('Name'=>$index['Crop']['CropType'],'Count'=>$index['0']['COUNT(`Crop`.`PropertyID`)']);
						
						$v++;
					}
				}
				else if ($index['Crop']['CropGroup']=="Fruits"){
					for ($n=0; $n<$f; $n++){
						if ($f==0){
							$fruCrops[$f]= array('Name'=>$index['Crop']['CropType'],'Count'=>$index['0']['COUNT(`Crop`.`PropertyID`)']);
							$f++;
							break;
						}
						else if ($index['Crop']['CropType'] == $fruCrops[$n]['Name']){
							
							$fruCrops[$n]['Count']+=1;
							
							break;
						}
					}
					if($n >= $f) {
						$fruCrops[$f]= array('Name'=>$index['Crop']['CropType'],'Count'=>$index['0']['COUNT(`Crop`.`PropertyID`)']);
						$f++;
					}
				}
				else if ($index['Crop']['CropGroup']=="Permanent Crop"){
					for ($n=0; $n<$p; $n++){
						if ($p==0){
							$perCrops[$p]= array('Name'=>$index['Crop']['CropType'],'Count'=>$index['0']['COUNT(`Crop`.`PropertyID`)']);
							$p++;
							break;
						}
						else if ($index['Crop']['CropType'] == $perCrops[$n]['Name']){
							
							$perCrops[$n]['Count']+=1;
							
							break;
						}
					}
					if($n >= $p) {
						$perCrops[$p]= array('Name'=>$index['Crop']['CropType'],'Count'=>$index['0']['COUNT(`Crop`.`PropertyID`)']);
						$p++;
					}
				}
				//foreach(&index as $subindex =>$subvalue){

				//}
			}
			if ($v == 0){
				$vegCrops[0]= array('Name'=>"NONE", 'Count'=>0);
			}
			if ($f == 0){
				$fruCrops[0]= array('Name'=>"NONE", 'Count'=>0);
			}
			if ($p == 0){
				$perCrops[0]= array('Name'=>"NONE", 'Count'=>0);
			}
			
			$veg = array('name'=>"Vegetables",'count'=>$v, 'Crop Types'=>array('Crop Type'=>$vegCrops));
			$fru = array('name'=>"Fruits",'count'=>$f, 'Crop Types'=>array('Crop Type'=>$fruCrops));
			$per = array('name'=>"Permanent",'count'=>$p, 'Crop Types'=>array('Crop Type'=>$perCrops));
			
			$CropGroups = array('0'=>$veg,'1'=>$fru ,'2'=>$per);
			$data = array('0'=>array('Crop Group'=>$CropGroups));
		
			$this->set('crops', $data);
		}
		
    }
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function croptype() {
	function queryString($urlParams) {
        //print_r($urlParams);
        //echo count($urlParams);
        $query = "";
        $arrCount = 2;
        if (count($urlParams) > 2) {
            foreach ( $urlParams as $column=>$param) { 
                if ($column != 'ext' && $column != 'url') {
                    $arrCount++;
                    $query .= (($arrCount < count($urlParams) ? ("Crop.$column='$param' AND ") :  ("Crop.$column='$param'") ));
                }
            }
        }
        return $query;
    }
		
		$paginate = array(
            'limit' => 1000
        );
		$this->View = 'Webservice.Webservice';
		$url = $this->params['url'];
		//$url['ext']= "xml";
        //print_r($url);
        
                
		if ($url['ext']=="html"){
			$query = queryString($url);
			$this->paginate= array('fields'=>array('CropGroup','CropType','COUNT(Crop.PropertyID)'),'group'=>array('CropType'), 'conditions'=>$query, 'limit'=>1000);
			$table = $this->paginate('Crop');
			$this->set('crops', $table);
			$this->View = 'Webservice.Webservice';
		}
		else{
			$query = queryString($url);
			$returndata= false;
			$this->View = 'Webservice.Webservice';
			//$data = $this->paginate('Crop');
			if ($query == ""){
				$returndata= false;
				$data = $this->Crop->find('all', array('fields'=>array('CropGroup','CropType','COUNT(Crop.PropertyID)'),'group'=>array('CropType'), 'conditions'=>$query));//,'limit'=>100)); 
			}
			else {
				$returndata=true;
				$data = $this->paginate('Crop', $query);
				
			}

			//loop through data passed in to reformat based on xml output specifications
			
			$v = 0; $f = 0; $p = 0;
			
			foreach($data as $index){
				if ($returndata == true){
					$count = 1;
					if ($index['Crop']['CropGroup']=="Vegetables"){
						//go through the crop types
						for ($n=0; $n<$v; $n++){
							if ($index['Crop']['CropType'] == $vegCrops[$n]['Name']){
								// go through the parishes
								for ($m=0; $m < $vegCrops[$n]['parishes']['Count']; $m++){
								
									if ($index['Crop']['Parish'] == $vegCrops[$n]['parishes']['parish'][$m]['name']){
										// go through the extensions
										for($o =0;$o < $vegCrops[$n]['parishes']['parish'][$m]['extensions']['count'];$o++){
											if ($index['Crop']['Extension'] == $vegCrops[$n]['parishes']['parish'][$m]['extensions']['extension'][$o]['name'] ){
												//go through districts
												for ($d=0;$d < $vegCrops[$n]['parishes']['parish'][$m]['extensions']['extension'][$o]['districts']['count'];$d++){
													if ($index['Crop']['District'] == $vegCrops[$n]['parishes']['parish'][$m]['extensions']['extension'][$o]['districts']['district'][$d]['name']){
														//go through farms
														for($x=0; $x < $vegCrops[$n]['parishes']['parish'][$m]['extensions']['extension'][$o]['districts']['district'][$d]['farms']['count'];$x++){
															if ($index['Crop']['PropertyID'] ==  $vegCrops[$n]['parishes']['parish'][$m]['extensions']['extension'][$o]['districts']['district'][$d]['farms']['farm'][$x]['farmID']){
																//$vegCrops[$n]['parishes']['parish'][$m]['extensions']['extension'][$o]['districts']['district'][$d]['farms']['farm'][$x]['count']+=1;
																break;
															}
															
														}
														if ($x >= $vegCrops[$n]['parishes']['parish'][$m]['extensions']['extension'][$o]['districts']['district'][$d]['farms']['count']){
															$vegCrops[$n]['parishes']['parish'][$m]['extensions']['extension'][$o]['districts']['district'][$d]['farms']['farm'][$vegCrops[$n]['parishes']['parish'][$m]['extensions']['extension'][$o]['districts']['district'][$d]['farms']['count']]= array('farmID'=>$index['Crop']['PropertyID'],'groupNum'=>$index['Crop']['Group'],'CropArea'=>$index['Crop']['CropArea'], 'cropCount'=>$index['Crop']['CropCount'], 'cropDate'=>$index['Crop']['CropDate'],'coords'=>array('X-coord'=>$index['Crop']['Xcoord'],'Y-coord'=>$index['Crop']['Ycoord']));//,'count'=>1);
															$vegCrops[$n]['parishes']['parish'][$m]['extensions']['extension'][$o]['districts']['district'][$d]['farms']['count']+=1;
														}
														
														break;
													}
												}
												if ($d >= $vegCrops[$n]['parishes']['parish'][$m]['extensions']['extension'][$o]['districts']['count']){
													$vegCrops[$n]['parishes']['parish'][$m]['extensions']['extension'][$o]['districts']['district'][$vegCrops[$n]['parishes']['parish'][$m]['extensions']['extension'][$o]['districts']['count']]= array('name'=>$index['Crop']['District'],
																	'farms'=>array('count'=>$count, 'farm'=>array('0'=>array('farmID'=>$index['Crop']['PropertyID'],'groupNum'=>$index['Crop']['Group'],'CropArea'=>$index['Crop']['CropArea'], 'cropCount'=>$index['Crop']['CropCount'], 'cropDate'=>$index['Crop']['CropDate'],'coords'=>array('X-coord'=>$index['Crop']['Xcoord'],'Y-coord'=>$index['Crop']['Ycoord'])))));
													$vegCrops[$n]['parishes']['parish'][$m]['extensions']['extension'][$o]['districts']['count']+=1;
												}
												break;
											}
										}
										if ($o >= $vegCrops[$n]['parishes']['parish'][$m]['extensions']['count']){
											$vegCrops[$n]['parishes']['parish'][$m]['extensions']['extension'][$vegCrops[$n]['parishes']['parish'][$m]['extensions']['count']] = array('name'=>$index['Crop']['Extension'], 'districts'=>array('count'=>$count, 'district'=>array('0'=>array('name'=>$index['Crop']['District'], 
															'farms'=>array('count'=>$count, 'farm'=>array('0'=>array('farmID'=>$index['Crop']['PropertyID'],'groupNum'=>$index['Crop']['Group'],'CropArea'=>$index['Crop']['CropArea'], 'cropCount'=>$index['Crop']['CropCount'], 'cropDate'=>$index['Crop']['CropDate'],'coords'=>array('X-coord'=>$index['Crop']['Xcoord'],'Y-coord'=>$index['Crop']['Ycoord']))))))));
											$vegCrops[$n]['parishes']['parish'][$m]['extensions']['count']+=1;
										}									
										
										break;
										
									}
								}
								if($m >= $vegCrops[$n]['parishes']['Count']) {
									$vegCrops[$n]['parishes']['parish'][''.$vegCrops[$n]['parishes']['Count']] = array('name'=>$index['Crop']['Parish'], 'extensions'=>array('count'=>$count,'extension'=>array('0'=>array('name'=>$index['Crop']['Extension'], 'districts'=>array('count'=>$count, 'district'=>array('0'=>array('name'=>$index['Crop']['District'],
													'farms'=>array('count'=>$count, 'farm'=>array('0'=>array('farmID'=>$index['Crop']['PropertyID'],'groupNum'=>$index['Crop']['Group'],'CropArea'=>$index['Crop']['CropArea'], 'cropCount'=>$index['Crop']['CropCount'], 'cropDate'=>$index['Crop']['CropDate'],'coords'=>array('X-coord'=>$index['Crop']['Xcoord'],'Y-coord'=>$index['Crop']['Ycoord'])))))))))));
									$vegCrops[$n]['parishes']['Count']+=1;
									
								}
								break;
							}
						}
						if($n >= $v) {
							$vegCrops[$v]= array('Name'=>$index['Crop']['CropType'],'parishes'=>array('Count'=>$count,'parish'=>array('0'=>array('name'=>$index['Crop']['Parish'], 'extensions'=>array('count'=>$count,'extension'=>array('0'=>array('name'=>$index['Crop']['Extension'], 'districts'=>array('count'=>$count, 'district'=>array('0'=>array('name'=>$index['Crop']['District'],
													'farms'=>array('count'=>$count, 'farm'=>array('0'=>array('farmID'=>$index['Crop']['PropertyID'],'groupNum'=>$index['Crop']['Group'],'CropArea'=>$index['Crop']['CropArea'], 'cropCount'=>$index['Crop']['CropCount'], 'cropDate'=>$index['Crop']['CropDate'],'coords'=>array('X-coord'=>$index['Crop']['Xcoord'],'Y-coord'=>$index['Crop']['Ycoord']))))))))))))));
							
							$v++;
						}
					}
					else if ($index['Crop']['CropGroup']=="Fruits"){
						//go through the crop types
						for ($n=0; $n<$f; $n++){
							if ($index['Crop']['CropType'] == $fruCrops[$n]['Name']){
								// go through the parishes
								for ($m=0; $m < $fruCrops[$n]['parishes']['Count']; $m++){
								
									if ($index['Crop']['Parish'] == $fruCrops[$n]['parishes']['parish'][$m]['name']){
										// go through the extensions
										for($o =0;$o < $fruCrops[$n]['parishes']['parish'][$m]['extensions']['count'];$o++){
											if ($index['Crop']['Extension'] == $fruCrops[$n]['parishes']['parish'][$m]['extensions']['extension'][$o]['name'] ){
												//go through districts
												for ($d=0;$d < $fruCrops[$n]['parishes']['parish'][$m]['extensions']['extension'][$o]['districts']['count'];$d++){
													if ($index['Crop']['District'] == $fruCrops[$n]['parishes']['parish'][$m]['extensions']['extension'][$o]['districts']['district'][$d]['name']){
														//go through farms
														for($x=0; $x < $fruCrops[$n]['parishes']['parish'][$m]['extensions']['extension'][$o]['districts']['district'][$d]['farms']['count'];$x++){
															if ($index['Crop']['PropertyID'] ==  $fruCrops[$n]['parishes']['parish'][$m]['extensions']['extension'][$o]['districts']['district'][$d]['farms']['farm'][$x]['farmID']){
																//$fruCrops[$n]['parishes']['parish'][$m]['extensions']['extension'][$o]['districts']['district'][$d]['farms']['farm'][$x]['count']+=1;
																break;
															}
															
														}
														if ($x >= $fruCrops[$n]['parishes']['parish'][$m]['extensions']['extension'][$o]['districts']['district'][$d]['farms']['count']){
															$fruCrops[$n]['parishes']['parish'][$m]['extensions']['extension'][$o]['districts']['district'][$d]['farms']['farm'][$fruCrops[$n]['parishes']['parish'][$m]['extensions']['extension'][$o]['districts']['district'][$d]['farms']['count']]= array('farmID'=>$index['Crop']['PropertyID'],'groupNum'=>$index['Crop']['Group'],'CropArea'=>$index['Crop']['CropArea'], 'cropCount'=>$index['Crop']['CropCount'], 'cropDate'=>$index['Crop']['CropDate'],'coords'=>array('X-coord'=>$index['Crop']['Xcoord'],'Y-coord'=>$index['Crop']['Ycoord']));//,'count'=>1);
															$fruCrops[$n]['parishes']['parish'][$m]['extensions']['extension'][$o]['districts']['district'][$d]['farms']['count']+=1;
														}
														
														break;
													}
												}
												if ($d >= $fruCrops[$n]['parishes']['parish'][$m]['extensions']['extension'][$o]['districts']['count']){
													$fruCrops[$n]['parishes']['parish'][$m]['extensions']['extension'][$o]['districts']['district'][$fruCrops[$n]['parishes']['parish'][$m]['extensions']['extension'][$o]['districts']['count']]= array('name'=>$index['Crop']['District'],
																	'farms'=>array('count'=>$count, 'farm'=>array('0'=>array('farmID'=>$index['Crop']['PropertyID'],'groupNum'=>$index['Crop']['Group'],'CropArea'=>$index['Crop']['CropArea'], 'cropCount'=>$index['Crop']['CropCount'], 'cropDate'=>$index['Crop']['CropDate'],'coords'=>array('X-coord'=>$index['Crop']['Xcoord'],'Y-coord'=>$index['Crop']['Ycoord'])))));
													$fruCrops[$n]['parishes']['parish'][$m]['extensions']['extension'][$o]['districts']['count']+=1;
												}
												break;
											}
										}
										if ($o >= $fruCrops[$n]['parishes']['parish'][$m]['extensions']['count']){
											$fruCrops[$n]['parishes']['parish'][$m]['extensions']['extension'][$fruCrops[$n]['parishes']['parish'][$m]['extensions']['count']] = array('name'=>$index['Crop']['Extension'], 'districts'=>array('count'=>$count, 'district'=>array('0'=>array('name'=>$index['Crop']['District'], 
															'farms'=>array('count'=>$count, 'farm'=>array('0'=>array('farmID'=>$index['Crop']['PropertyID'],'groupNum'=>$index['Crop']['Group'],'CropArea'=>$index['Crop']['CropArea'], 'cropCount'=>$index['Crop']['CropCount'], 'cropDate'=>$index['Crop']['CropDate'],'coords'=>array('X-coord'=>$index['Crop']['Xcoord'],'Y-coord'=>$index['Crop']['Ycoord']))))))));
											$fruCrops[$n]['parishes']['parish'][$m]['extensions']['count']+=1;
										}									
										
										break;
										
									}
								}
								if($m >= $fruCrops[$n]['parishes']['Count']) {
									$fruCrops[$n]['parishes']['parish'][''.$fruCrops[$n]['parishes']['Count']] = array('name'=>$index['Crop']['Parish'], 'extensions'=>array('count'=>$count,'extension'=>array('0'=>array('name'=>$index['Crop']['Extension'], 'districts'=>array('count'=>$count, 'district'=>array('0'=>array('name'=>$index['Crop']['District'],
													'farms'=>array('count'=>$count, 'farm'=>array('0'=>array('farmID'=>$index['Crop']['PropertyID'],'groupNum'=>$index['Crop']['Group'],'CropArea'=>$index['Crop']['CropArea'], 'cropCount'=>$index['Crop']['CropCount'], 'cropDate'=>$index['Crop']['CropDate'],'coords'=>array('X-coord'=>$index['Crop']['Xcoord'],'Y-coord'=>$index['Crop']['Ycoord'])))))))))));
									$fruCrops[$n]['parishes']['Count']+=1;
									
								}
								break;
							}
						}
						if($n >= $f) {
							$fruCrops[$f]= array('Name'=>$index['Crop']['CropType'],'parishes'=>array('Count'=>$count,'parish'=>array('0'=>array('name'=>$index['Crop']['Parish'], 'extensions'=>array('count'=>$count,'extension'=>array('0'=>array('name'=>$index['Crop']['Extension'], 'districts'=>array('count'=>$count, 'district'=>array('0'=>array('name'=>$index['Crop']['District'],
													'farms'=>array('count'=>$count, 'farm'=>array('0'=>array('farmID'=>$index['Crop']['PropertyID'],'groupNum'=>$index['Crop']['Group'],'CropArea'=>$index['Crop']['CropArea'], 'cropCount'=>$index['Crop']['CropCount'], 'cropDate'=>$index['Crop']['CropDate'],'coords'=>array('X-coord'=>$index['Crop']['Xcoord'],'Y-coord'=>$index['Crop']['Ycoord']))))))))))))));
							
							$f++;
						}					
					}
					else if ($index['Crop']['CropGroup']=="Permanent Crop"){
						//go through the crop types
						for ($n=0; $n<$p; $n++){
							if ($index['Crop']['CropType'] == $perCrops[$n]['Name']){
								// go through the parishes
								for ($m=0; $m < $perCrops[$n]['parishes']['Count']; $m++){
								
									if ($index['Crop']['Parish'] == $perCrops[$n]['parishes']['parish'][$m]['name']){
										// go through the extensions
										for($o =0;$o < $perCrops[$n]['parishes']['parish'][$m]['extensions']['count'];$o++){
											if ($index['Crop']['Extension'] == $perCrops[$n]['parishes']['parish'][$m]['extensions']['extension'][$o]['name'] ){
												//go through districts
												for ($d=0;$d < $perCrops[$n]['parishes']['parish'][$m]['extensions']['extension'][$o]['districts']['count'];$d++){
													if ($index['Crop']['District'] == $perCrops[$n]['parishes']['parish'][$m]['extensions']['extension'][$o]['districts']['district'][$d]['name']){
														//go through farms
														for($x=0; $x < $perCrops[$n]['parishes']['parish'][$m]['extensions']['extension'][$o]['districts']['district'][$d]['farms']['count'];$x++){
															if ($index['Crop']['PropertyID'] ==  $perCrops[$n]['parishes']['parish'][$m]['extensions']['extension'][$o]['districts']['district'][$d]['farms']['farm'][$x]['farmID']){
																//$perCrops[$n]['parishes']['parish'][$m]['extensions']['extension'][$o]['districts']['district'][$d]['farms']['farm'][$x]['count']+=1;
																break;
															}
															
														}
														if ($x >= $perCrops[$n]['parishes']['parish'][$m]['extensions']['extension'][$o]['districts']['district'][$d]['farms']['count']){
															$perCrops[$n]['parishes']['parish'][$m]['extensions']['extension'][$o]['districts']['district'][$d]['farms']['farm'][$perCrops[$n]['parishes']['parish'][$m]['extensions']['extension'][$o]['districts']['district'][$d]['farms']['count']]= array('farmID'=>$index['Crop']['PropertyID'],'groupNum'=>$index['Crop']['Group'],'CropArea'=>$index['Crop']['CropArea'], 'cropCount'=>$index['Crop']['CropCount'], 'cropDate'=>$index['Crop']['CropDate'],'coords'=>array('X-coord'=>$index['Crop']['Xcoord'],'Y-coord'=>$index['Crop']['Ycoord']));//,'count'=>1);
															$perCrops[$n]['parishes']['parish'][$m]['extensions']['extension'][$o]['districts']['district'][$d]['farms']['count']+=1;
														}
														
														break;
													}
												}
												if ($d >= $perCrops[$n]['parishes']['parish'][$m]['extensions']['extension'][$o]['districts']['count']){
													$perCrops[$n]['parishes']['parish'][$m]['extensions']['extension'][$o]['districts']['district'][$perCrops[$n]['parishes']['parish'][$m]['extensions']['extension'][$o]['districts']['count']]= array('name'=>$index['Crop']['District'],
																	'farms'=>array('count'=>$count, 'farm'=>array('0'=>array('farmID'=>$index['Crop']['PropertyID'],'groupNum'=>$index['Crop']['Group'],'CropArea'=>$index['Crop']['CropArea'], 'cropCount'=>$index['Crop']['CropCount'], 'cropDate'=>$index['Crop']['CropDate'],'coords'=>array('X-coord'=>$index['Crop']['Xcoord'],'Y-coord'=>$index['Crop']['Ycoord'])))));
													$perCrops[$n]['parishes']['parish'][$m]['extensions']['extension'][$o]['districts']['count']+=1;
												}
												break;
											}
										}
										if ($o >= $perCrops[$n]['parishes']['parish'][$m]['extensions']['count']){
											$perCrops[$n]['parishes']['parish'][$m]['extensions']['extension'][$perCrops[$n]['parishes']['parish'][$m]['extensions']['count']] = array('name'=>$index['Crop']['Extension'], 'districts'=>array('count'=>$count, 'district'=>array('0'=>array('name'=>$index['Crop']['District'], 
															'farms'=>array('count'=>$count, 'farm'=>array('0'=>array('farmID'=>$index['Crop']['PropertyID'],'groupNum'=>$index['Crop']['Group'],'CropArea'=>$index['Crop']['CropArea'], 'cropCount'=>$index['Crop']['CropCount'], 'cropDate'=>$index['Crop']['CropDate'],'coords'=>array('X-coord'=>$index['Crop']['Xcoord'],'Y-coord'=>$index['Crop']['Ycoord']))))))));
											$perCrops[$n]['parishes']['parish'][$m]['extensions']['count']+=1;
										}									
										
										break;
										
									}
								}
								if($m >= $perCrops[$n]['parishes']['Count']) {
									$perCrops[$n]['parishes']['parish'][''.$perCrops[$n]['parishes']['Count']] = array('name'=>$index['Crop']['Parish'], 'extensions'=>array('count'=>$count,'extension'=>array('0'=>array('name'=>$index['Crop']['Extension'], 'districts'=>array('count'=>$count, 'district'=>array('0'=>array('name'=>$index['Crop']['District'],
													'farms'=>array('count'=>$count, 'farm'=>array('0'=>array('farmID'=>$index['Crop']['PropertyID'],'groupNum'=>$index['Crop']['Group'],'CropArea'=>$index['Crop']['CropArea'], 'cropCount'=>$index['Crop']['CropCount'], 'cropDate'=>$index['Crop']['CropDate'],'coords'=>array('X-coord'=>$index['Crop']['Xcoord'],'Y-coord'=>$index['Crop']['Ycoord'])))))))))));
									$perCrops[$n]['parishes']['Count']+=1;
									
								}
								break;
							}
						}
						if($n >= $p) {
							$perCrops[$p]= array('Name'=>$index['Crop']['CropType'],'parishes'=>array('Count'=>$count,'parish'=>array('0'=>array('name'=>$index['Crop']['Parish'], 'extensions'=>array('count'=>$count,'extension'=>array('0'=>array('name'=>$index['Crop']['Extension'], 'districts'=>array('count'=>$count, 'district'=>array('0'=>array('name'=>$index['Crop']['District'],
													'farms'=>array('count'=>$count, 'farm'=>array('0'=>array('farmID'=>$index['Crop']['PropertyID'],'groupNum'=>$index['Crop']['Group'],'CropArea'=>$index['Crop']['CropArea'], 'cropCount'=>$index['Crop']['CropCount'], 'cropDate'=>$index['Crop']['CropDate'],'coords'=>array('X-coord'=>$index['Crop']['Xcoord'],'Y-coord'=>$index['Crop']['Ycoord']))))))))))))));
							
							$p++;
						}
					}
				}
				else {
					if ($index['Crop']['CropGroup']=="Vegetables"){
						for ($n=0; $n<$v; $n++){
							if ($v==0){
								$vegCrops[$v]= array('Name'=>$index['Crop']['CropType'],'Count'=>$index['0']['COUNT(`Crop`.`PropertyID`)']);
								$v++;
								break;
							}
							else if ($index['Crop']['CropType'] == $vegCrops[$n]['Name']){
								$vegCrops[$n]['Count']+=1;
								
								break;
							}
						}
						if($n >= $v) {
							$vegCrops[$v]= array('Name'=>$index['Crop']['CropType'],'Count'=>$index['0']['COUNT(`Crop`.`PropertyID`)']);
							
							$v++;
						}
					}
					else if ($index['Crop']['CropGroup']=="Fruits"){
						for ($n=0; $n<$f; $n++){
							if ($f==0){
								$fruCrops[$f]= array('Name'=>$index['Crop']['CropType'],'Count'=>$index['0']['COUNT(`Crop`.`PropertyID`)']);
								$f++;
								break;
							}
							else if ($index['Crop']['CropType'] == $fruCrops[$n]['Name']){
								
								$fruCrops[$n]['Count']+=1;
								
								break;
							}
						}
						if($n >= $f) {
							$fruCrops[$f]= array('Name'=>$index['Crop']['CropType'],'Count'=>$index['0']['COUNT(`Crop`.`PropertyID`)']);
							$f++;
						}
					}
					else if ($index['Crop']['CropGroup']=="Permanent Crop"){
						for ($n=0; $n<$p; $n++){
							if ($p==0){
								$perCrops[$p]= array('Name'=>$index['Crop']['CropType'],'Count'=>$index['0']['COUNT(`Crop`.`PropertyID`)']);
								$p++;
								break;
							}
							else if ($index['Crop']['CropType'] == $perCrops[$n]['Name']){
								
								$perCrops[$n]['Count']+=1;
								
								break;
							}
						}
						if($n >= $p) {
							$perCrops[$p]= array('Name'=>$index['Crop']['CropType'],'Count'=>$index['0']['COUNT(`Crop`.`PropertyID`)']);
							$p++;
						}
					}
				}
			}
			if ($v == 0){
				$vegCrops[0]= array('Name'=>"NONE", 'Count'=>0);
			}
			if ($f == 0){
				$fruCrops[0]= array('Name'=>"NONE", 'Count'=>0);
			}
			if ($p == 0){
				$perCrops[0]= array('Name'=>"NONE", 'Count'=>0);
			}
			
			$veg = array('name'=>"Vegetables",'count'=>$v, 'Crop Types'=>array('Crop Type'=>$vegCrops));
			$fru = array('name'=>"Fruits",'count'=>$f, 'Crop Types'=>array('Crop Type'=>$fruCrops));
			$per = array('name'=>"Permanent",'count'=>$p, 'Crop Types'=>array('Crop Type'=>$perCrops));
			
			$CropGroups = array('0'=>$veg,'1'=>$fru ,'2'=>$per);
			$data = array('0'=>array('Crop Group'=>$CropGroups));
		
			$this->set('crops', $data);
		}
		
    }
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function parish(){
	function queryString($urlParams) {
        //print_r($urlParams);
        //echo count($urlParams);
        $query = "";
        $arrCount = 2;
        if (count($urlParams) > 2) {
            foreach ( $urlParams as $column=>$param) { 
                if ($column != 'ext' && $column != 'url') {
                    $arrCount++;
                    $query .= (($arrCount < count($urlParams) ? ("Crop.$column='$param' AND ") :  ("Crop.$column='$param'") ));
                }
            }
        }
		//echo $query;
        return $query;
    }
		$paginate = array(
            'limit' => 1000
        );
		
		$this->View = 'Webservice.Webservice';
		$url = $this->params['url'];
		//$url['ext']= "xml";
        //print_r($url);
        
        
		if ($url['ext']=="html"){
		
			$query = queryString($url);
			
			$this->paginate = array('fields'=>array('Parish','CropType','COUNT(Crop.CropType)'),'group'=>array('Parish','CropType'), 'conditions'=>$query,'limit' => 1000);
			
			$table = $this->paginate('Crop');
			$this->set('crops', $table);
			$this->View = 'Webservice.Webservice';
		}
		else{
			$query = queryString($url);
			$returndata= false;
			//$data = $this->paginate('Crop');
			if ($query == ""){
				$returndata= false;
				 
				$data = $this->Crop->find('all', array('fields'=>array('Parish','CropType','COUNT(Crop.CropType)'),'group'=>array('Parish','CropType'), 'conditions'=>$query));
			}
			else {
				$returndata=true;
				$data = $this->paginate('Crop', $query);
				
			}
			
			//loop through data passed in to reformat based on xml output specifications
		
			$clarC  = 0; $hanoC = 0; $kingC = 0; $mancC = 0; $portC = 0; $standC = 0;
			$stannC = 0; $stcaC = 0; $stelC = 0; $stjaC = 0; $stmaC = 0; $stthC  = 0;
			$trelC  = 0; $westC = 0;
		
			foreach($data as $index){
				if ($returndata == true){
					$count = 1;
					if ($index['Crop']['Parish']=="CLARENDON"){
						for ($n=0; $n<$clarC; $n++){
							if ($index['Crop']['CropType'] == $clar[$n]['Name']){
								
								$clar[$n]['farm'][''.$clar[$n]['Count']] = array('farmID#'=>$index['Crop']['PropertyID'],'propertySize'=>$index['Crop']['PropertySize'],'farmSize'=>$index['Crop']['Farmsize'], 'cropArea'=>$index['Crop']['CropArea'],'cropCount'=>$index['Crop']['CropCount'],'cropDate'=>$index['Crop']['CropDate'], 'coords'=>array('Y-coord'=>$index['Crop']['Ycoord'],'X-coord'=>$index['Crop']['Xcoord']));
								$clar[$n]['Count']+=1;
								break;
							}
						}
						if($n >= $clarC) {
							$clar[$clarC]= array('Name'=>$index['Crop']['CropType'],'group#'=>$index['Crop']['Group'],'Count'=>$count,'farm'=>array(0=>array('farmID#'=>$index['Crop']['PropertyID'],'propertySize'=>$index['Crop']['PropertySize'],'farmSize'=>$index['Crop']['Farmsize'], 'cropArea'=>$index['Crop']['CropArea'],'cropCount'=>$index['Crop']['CropCount'],'cropDate'=>$index['Crop']['CropDate'], 'coords'=>array('Y-coord'=>$index['Crop']['Ycoord'],'X-coord'=>$index['Crop']['Xcoord']))));
							
							$clarC++;
						}
					}
					else if ($index['Crop']['Parish']=="HANOVER"){
						for ($n=0; $n<$hanoC; $n++){
							if ($index['Crop']['CropType'] == $hano[$n]['Name']){
								$hano[$n]['farm'][''.$hano[$n]['Count']] = array('farmID#'=>$index['Crop']['PropertyID'],'propertySize'=>$index['Crop']['PropertySize'],'farmSize'=>$index['Crop']['Farmsize'], 'cropArea'=>$index['Crop']['CropArea'],'cropCount'=>$index['Crop']['CropCount'],'cropDate'=>$index['Crop']['CropDate'], 'coords'=>array('Y-coord'=>$index['Crop']['Ycoord'],'X-coord'=>$index['Crop']['Xcoord']));
								$hano[$n]['Count']+=1;
							
								break;
							}
						}
						if($n >= $hanoC) {
							$hano[$hanoC]= array('Name'=>$index['Crop']['CropType'],'group#'=>$index['Crop']['Group'],'Count'=>$count,'farm'=>array(0=>array('farmID#'=>$index['Crop']['PropertyID'],'propertySize'=>$index['Crop']['PropertySize'],'farmSize'=>$index['Crop']['Farmsize'], 'cropArea'=>$index['Crop']['CropArea'],'cropCount'=>$index['Crop']['CropCount'],'cropDate'=>$index['Crop']['CropDate'], 'coords'=>array('Y-coord'=>$index['Crop']['Ycoord'],'X-coord'=>$index['Crop']['Xcoord']))));
							$hanoC++;
						}
					}
					else if ($index['Crop']['Parish']=="KINGSTON"){
						for ($n=0; $n<$kingC; $n++){
							if ($index['Crop']['CropType'] == $king[$n]['Name']){
								$king[$n]['farm'][''.$king[$n]['Count']] = array('farmID#'=>$index['Crop']['PropertyID'],'propertySize'=>$index['Crop']['PropertySize'],'farmSize'=>$index['Crop']['Farmsize'], 'cropArea'=>$index['Crop']['CropArea'],'cropCount'=>$index['Crop']['CropCount'],'cropDate'=>$index['Crop']['CropDate'], 'coords'=>array('Y-coord'=>$index['Crop']['Ycoord'],'X-coord'=>$index['Crop']['Xcoord']));
								$king[$n]['Count']+=1;
							
								break;
							}
						}
						if($n >= $kingC) {
							$king[$kingC]= array('Name'=>$index['Crop']['CropType'],'group#'=>$index['Crop']['Group'],'Count'=>$count,'farm'=>array(0=>array('farmID#'=>$index['Crop']['PropertyID'],'propertySize'=>$index['Crop']['PropertySize'],'farmSize'=>$index['Crop']['Farmsize'], 'cropArea'=>$index['Crop']['CropArea'],'cropCount'=>$index['Crop']['CropCount'],'cropDate'=>$index['Crop']['CropDate'], 'coords'=>array('Y-coord'=>$index['Crop']['Ycoord'],'X-coord'=>$index['Crop']['Xcoord']))));
							$kingC++;
						}
					}
					else if ($index['Crop']['Parish']=="MANCHESTER"){
						for ($n=0; $n<$mancC; $n++){
							if ($index['Crop']['CropType'] == $manc[$n]['Name']){
								$manc[$n]['farm'][''.$manc[$n]['Count']] = array('farmID#'=>$index['Crop']['PropertyID'],'propertySize'=>$index['Crop']['PropertySize'],'farmSize'=>$index['Crop']['Farmsize'], 'cropArea'=>$index['Crop']['CropArea'],'cropCount'=>$index['Crop']['CropCount'],'cropDate'=>$index['Crop']['CropDate'], 'coords'=>array('Y-coord'=>$index['Crop']['Ycoord'],'X-coord'=>$index['Crop']['Xcoord']));
								$manc[$n]['Count']+=1;
							
								break;
							}
						}
						if($n >= $mancC) {
							$manc[$mancC]= array('Name'=>$index['Crop']['CropType'],'group#'=>$index['Crop']['Group'],'Count'=>$count,'farm'=>array(0=>array('farmID#'=>$index['Crop']['PropertyID'],'propertySize'=>$index['Crop']['PropertySize'],'farmSize'=>$index['Crop']['Farmsize'], 'cropArea'=>$index['Crop']['CropArea'],'cropCount'=>$index['Crop']['CropCount'],'cropDate'=>$index['Crop']['CropDate'], 'coords'=>array('Y-coord'=>$index['Crop']['Ycoord'],'X-coord'=>$index['Crop']['Xcoord']))));
							$mancC++;
						}
					}
					else if ($index['Crop']['Parish']=="PORTLAND"){
						for ($n=0; $n<$portC; $n++){
							if ($index['Crop']['CropType'] == $port[$n]['Name']){
								$port[$n]['farm'][''.$port[$n]['Count']] = array('farmID#'=>$index['Crop']['PropertyID'],'propertySize'=>$index['Crop']['PropertySize'],'farmSize'=>$index['Crop']['Farmsize'], 'cropArea'=>$index['Crop']['CropArea'],'cropCount'=>$index['Crop']['CropCount'],'cropDate'=>$index['Crop']['CropDate'], 'coords'=>array('Y-coord'=>$index['Crop']['Ycoord'],'X-coord'=>$index['Crop']['Xcoord']));
								$port[$n]['Count']+=1;
							
								break;
							}
						}
						if($n >= $portC) {
							$port[$portC]= array('Name'=>$index['Crop']['CropType'],'group#'=>$index['Crop']['Group'],'Count'=>$count,'farm'=>array(0=>array('farmID#'=>$index['Crop']['PropertyID'],'propertySize'=>$index['Crop']['PropertySize'],'farmSize'=>$index['Crop']['Farmsize'], 'cropArea'=>$index['Crop']['CropArea'],'cropCount'=>$index['Crop']['CropCount'],'cropDate'=>$index['Crop']['CropDate'], 'coords'=>array('Y-coord'=>$index['Crop']['Ycoord'],'X-coord'=>$index['Crop']['Xcoord']))));
							$portC++;
						}
					}
					else if ($index['Crop']['Parish']=="ST.ANDREW"){
						for ($n=0; $n<$standC; $n++){
							if ($index['Crop']['CropType'] == $stand[$n]['Name']){
								$stand[$n]['farm'][''.$stand[$n]['Count']] = array('farmID#'=>$index['Crop']['PropertyID'],'propertySize'=>$index['Crop']['PropertySize'],'farmSize'=>$index['Crop']['Farmsize'], 'cropArea'=>$index['Crop']['CropArea'],'cropCount'=>$index['Crop']['CropCount'],'cropDate'=>$index['Crop']['CropDate'], 'coords'=>array('Y-coord'=>$index['Crop']['Ycoord'],'X-coord'=>$index['Crop']['Xcoord']));
								$stand[$n]['Count']+=1;
							
								break;
							}
						}
						if($n >= $standC) {
							$stand[$standC]= array('Name'=>$index['Crop']['CropType'],'group#'=>$index['Crop']['Group'],'Count'=>$count,'farm'=>array(0=>array('farmID#'=>$index['Crop']['PropertyID'],'propertySize'=>$index['Crop']['PropertySize'],'farmSize'=>$index['Crop']['Farmsize'], 'cropArea'=>$index['Crop']['CropArea'],'cropCount'=>$index['Crop']['CropCount'],'cropDate'=>$index['Crop']['CropDate'], 'coords'=>array('Y-coord'=>$index['Crop']['Ycoord'],'X-coord'=>$index['Crop']['Xcoord']))));
							$standC++;
						}
					}
					else if ($index['Crop']['Parish']=="ST.ANN"){
						for ($n=0; $n<$stannC; $n++){
							if ($index['Crop']['CropType'] == $stann[$n]['Name']){
								$stann[$n]['farm'][''.$stann[$n]['Count']] = array('farmID#'=>$index['Crop']['PropertyID'],'propertySize'=>$index['Crop']['PropertySize'],'farmSize'=>$index['Crop']['Farmsize'], 'cropArea'=>$index['Crop']['CropArea'],'cropCount'=>$index['Crop']['CropCount'],'cropDate'=>$index['Crop']['CropDate'], 'coords'=>array('Y-coord'=>$index['Crop']['Ycoord'],'X-coord'=>$index['Crop']['Xcoord']));
								$stann[$n]['Count']+=1;
							
								break;
							}
						}
						if($n >= $stannC) {
							$stann[$stannC]= array('Name'=>$index['Crop']['CropType'],'group#'=>$index['Crop']['Group'],'Count'=>$count,'farm'=>array(0=>array('farmID#'=>$index['Crop']['PropertyID'],'propertySize'=>$index['Crop']['PropertySize'],'farmSize'=>$index['Crop']['Farmsize'], 'cropArea'=>$index['Crop']['CropArea'],'cropCount'=>$index['Crop']['CropCount'],'cropDate'=>$index['Crop']['CropDate'], 'coords'=>array('Y-coord'=>$index['Crop']['Ycoord'],'X-coord'=>$index['Crop']['Xcoord']))));
							$stannC++;
						}
					}
					else if ($index['Crop']['Parish']=="ST.CATHERINE"){
						for ($n=0; $n<$stcaC; $n++){
							if ($index['Crop']['CropType'] == $stca[$n]['Name']){
								$stca[$n]['farm'][''.$stca[$n]['Count']] = array('farmID#'=>$index['Crop']['PropertyID'],'propertySize'=>$index['Crop']['PropertySize'],'farmSize'=>$index['Crop']['Farmsize'], 'cropArea'=>$index['Crop']['CropArea'],'cropCount'=>$index['Crop']['CropCount'],'cropDate'=>$index['Crop']['CropDate'], 'coords'=>array('Y-coord'=>$index['Crop']['Ycoord'],'X-coord'=>$index['Crop']['Xcoord']));
								$stca[$n]['Count']+=1;
							
								break;
							}
						}
						if($n >= $stcaC) {
							$stca[$stcaC]= array('Name'=>$index['Crop']['CropType'],'group#'=>$index['Crop']['Group'],'Count'=>$count,'farm'=>array(0=>array('farmID#'=>$index['Crop']['PropertyID'],'propertySize'=>$index['Crop']['PropertySize'],'farmSize'=>$index['Crop']['Farmsize'], 'cropArea'=>$index['Crop']['CropArea'],'cropCount'=>$index['Crop']['CropCount'],'cropDate'=>$index['Crop']['CropDate'], 'coords'=>array('Y-coord'=>$index['Crop']['Ycoord'],'X-coord'=>$index['Crop']['Xcoord']))));
							$stcaC++;
						}
					}
					else if ($index['Crop']['Parish']=="ST.ELIZABETH"){
						for ($n=0; $n<$stelC; $n++){
							if ($index['Crop']['CropType'] == $stel[$n]['Name']){
								$stel[$n]['farm'][''.$stel[$n]['Count']] = array('farmID#'=>$index['Crop']['PropertyID'],'propertySize'=>$index['Crop']['PropertySize'],'farmSize'=>$index['Crop']['Farmsize'], 'cropArea'=>$index['Crop']['CropArea'],'cropCount'=>$index['Crop']['CropCount'],'cropDate'=>$index['Crop']['CropDate'], 'coords'=>array('Y-coord'=>$index['Crop']['Ycoord'],'X-coord'=>$index['Crop']['Xcoord']));
								$stel[$n]['Count']+=1;
							
								break;
							}
						}
						if($n >= $stelC) {
							$stel[$stelC]= array('Name'=>$index['Crop']['CropType'],'group#'=>$index['Crop']['Group'],'Count'=>$count,'farm'=>array(0=>array('farmID#'=>$index['Crop']['PropertyID'],'propertySize'=>$index['Crop']['PropertySize'],'farmSize'=>$index['Crop']['Farmsize'], 'cropArea'=>$index['Crop']['CropArea'],'cropCount'=>$index['Crop']['CropCount'],'cropDate'=>$index['Crop']['CropDate'], 'coords'=>array('Y-coord'=>$index['Crop']['Ycoord'],'X-coord'=>$index['Crop']['Xcoord']))));
							$stelC++;
						}
					}
					else if ($index['Crop']['Parish']=="ST.JAMES"){
						for ($n=0; $n<$stjaC; $n++){
							if ($index['Crop']['CropType'] == $stja[$n]['Name']){
								$stja[$n]['farm'][''.$stja[$n]['Count']] = array('farmID#'=>$index['Crop']['PropertyID'],'propertySize'=>$index['Crop']['PropertySize'],'farmSize'=>$index['Crop']['Farmsize'], 'cropArea'=>$index['Crop']['CropArea'],'cropCount'=>$index['Crop']['CropCount'],'cropDate'=>$index['Crop']['CropDate'], 'coords'=>array('Y-coord'=>$index['Crop']['Ycoord'],'X-coord'=>$index['Crop']['Xcoord']));
								$stja[$n]['Count']+=1;
								
								break;
							}
						}	
						if($n >= $stjaC) {
							$stja[$stjaC]= array('Name'=>$index['Crop']['CropType'],'group#'=>$index['Crop']['Group'],'Count'=>$count,'farm'=>array(0=>array('farmID#'=>$index['Crop']['PropertyID'],'propertySize'=>$index['Crop']['PropertySize'],'farmSize'=>$index['Crop']['Farmsize'], 'cropArea'=>$index['Crop']['CropArea'],'cropCount'=>$index['Crop']['CropCount'],'cropDate'=>$index['Crop']['CropDate'], 'coords'=>array('Y-coord'=>$index['Crop']['Ycoord'],'X-coord'=>$index['Crop']['Xcoord']))));
							$stjaC++;
						}
					}
					else if ($index['Crop']['Parish']=="ST.MARY"){
						for ($n=0; $n<$stmaC; $n++){
							if ($index['Crop']['CropType'] == $stma[$n]['Name']){
								$stma[$n]['farm'][''.$stma[$n]['Count']] = array('farmID#'=>$index['Crop']['PropertyID'],'propertySize'=>$index['Crop']['PropertySize'],'farmSize'=>$index['Crop']['Farmsize'], 'cropArea'=>$index['Crop']['CropArea'],'cropCount'=>$index['Crop']['CropCount'],'cropDate'=>$index['Crop']['CropDate'], 'coords'=>array('Y-coord'=>$index['Crop']['Ycoord'],'X-coord'=>$index['Crop']['Xcoord']));
								$stma[$n]['Count']+=1;
							
								break;
							}
						}
						if($n >= $stmaC) {
							$stma[$stmaC]= array('Name'=>$index['Crop']['CropType'],'group#'=>$index['Crop']['Group'],'Count'=>$count,'farm'=>array(0=>array('farmID#'=>$index['Crop']['PropertyID'],'propertySize'=>$index['Crop']['PropertySize'],'farmSize'=>$index['Crop']['Farmsize'], 'cropArea'=>$index['Crop']['CropArea'],'cropCount'=>$index['Crop']['CropCount'],'cropDate'=>$index['Crop']['CropDate'], 'coords'=>array('Y-coord'=>$index['Crop']['Ycoord'],'X-coord'=>$index['Crop']['Xcoord']))));
							$stmaC++;
						}
					}
					else if ($index['Crop']['Parish']=="ST.THOMAS"){
						for ($n=0; $n<$stthC; $n++){
							if ($index['Crop']['CropType'] == $stth[$n]['Name']){
								$atth[$n]['farm'][''.$stth[$n]['Count']] = array('farmID#'=>$index['Crop']['PropertyID'],'propertySize'=>$index['Crop']['PropertySize'],'farmSize'=>$index['Crop']['Farmsize'], 'cropArea'=>$index['Crop']['CropArea'],'cropCount'=>$index['Crop']['CropCount'],'cropDate'=>$index['Crop']['CropDate'], 'coords'=>array('Y-coord'=>$index['Crop']['Ycoord'],'X-coord'=>$index['Crop']['Xcoord']));
								$stth[$n]['Count']+=1;
							
								break;
							}
						}
						if($n >= $stthC) {
							$stth[$stthC]= array('Name'=>$index['Crop']['CropType'],'group#'=>$index['Crop']['Group'],'Count'=>$count,'farm'=>array(0=>array('farmID#'=>$index['Crop']['PropertyID'],'propertySize'=>$index['Crop']['PropertySize'],'farmSize'=>$index['Crop']['Farmsize'], 'cropArea'=>$index['Crop']['CropArea'],'cropCount'=>$index['Crop']['CropCount'],'cropDate'=>$index['Crop']['CropDate'], 'coords'=>array('Y-coord'=>$index['Crop']['Ycoord'],'X-coord'=>$index['Crop']['Xcoord']))));
							$stthC++;
						}
					}
					else if ($index['Crop']['Parish']=="TRELAWNY"){
						for ($n=0; $n<$trelC; $n++){
							if ($index['Crop']['CropType'] == $trel[$n]['Name']){
								$trel[$n]['farm'][''.$trel[$n]['Count']] = array('farmID#'=>$index['Crop']['PropertyID'],'propertySize'=>$index['Crop']['PropertySize'],'farmSize'=>$index['Crop']['Farmsize'], 'cropArea'=>$index['Crop']['CropArea'],'cropCount'=>$index['Crop']['CropCount'],'cropDate'=>$index['Crop']['CropDate'], 'coords'=>array('Y-coord'=>$index['Crop']['Ycoord'],'X-coord'=>$index['Crop']['Xcoord']));
								$trel[$n]['Count']+=1;
							
								break;
							}
						}
						if($n >= $trelC) {
							$trel[$trelC]= array('Name'=>$index['Crop']['CropType'],'group#'=>$index['Crop']['Group'],'Count'=>$count,'farm'=>array(0=>array('farmID#'=>$index['Crop']['PropertyID'],'propertySize'=>$index['Crop']['PropertySize'],'farmSize'=>$index['Crop']['Farmsize'], 'cropArea'=>$index['Crop']['CropArea'],'cropCount'=>$index['Crop']['CropCount'],'cropDate'=>$index['Crop']['CropDate'], 'coords'=>array('Y-coord'=>$index['Crop']['Ycoord'],'X-coord'=>$index['Crop']['Xcoord']))));
							$trelC++;
						}
					}
					else if ($index['Crop']['Parish']=="WESTMORELAND"){
						for ($n=0; $n<$westC; $n++){
							if ($index['Crop']['CropType'] == $west[$n]['Name']){
								$west[$n]['farm'][''.$west[$n]['Count']] = array('farmID#'=>$index['Crop']['PropertyID'],'propertySize'=>$index['Crop']['PropertySize'],'farmSize'=>$index['Crop']['Farmsize'], 'cropArea'=>$index['Crop']['CropArea'],'cropCount'=>$index['Crop']['CropCount'],'cropDate'=>$index['Crop']['CropDate'], 'coords'=>array('Y-coord'=>$index['Crop']['Ycoord'],'X-coord'=>$index['Crop']['Xcoord']));
								$west[$n]['Count']+=1;
							
								break;
							}
						}
						if($n >= $westC) {
							$west[$westC]= array('Name'=>$index['Crop']['CropType'],'group#'=>$index['Crop']['Group'],'Count'=>$count,'farm'=>array(0=>array('farmID#'=>$index['Crop']['PropertyID'],'propertySize'=>$index['Crop']['PropertySize'],'farmSize'=>$index['Crop']['Farmsize'], 'cropArea'=>$index['Crop']['CropArea'],'cropCount'=>$index['Crop']['CropCount'],'cropDate'=>$index['Crop']['CropDate'], 'coords'=>array('Y-coord'=>$index['Crop']['Ycoord'],'X-coord'=>$index['Crop']['Xcoord']))));
							$westC++;
						}
					}
				}
				else{
					$count = $index['0']['COUNT(`Crop`.`CropType`)'];
					if ($index['Crop']['Parish']=="CLARENDON"){
						for ($n=0; $n<$clarC; $n++){
							if ($index['Crop']['CropType'] == $clar[$n]['Name']){
								$clar[$n]['Count']+=1;
								break;
							}
						}
						if($n >= $clarC) {
							$clar[$clarC]= array('Name'=>$index['Crop']['CropType'],'Count'=>$count);
							
							$clarC++;
						}
					}
					else if ($index['Crop']['Parish']=="HANOVER"){
						for ($n=0; $n<$hanoC; $n++){
							 if ($index['Crop']['CropType'] == $hano[$n]['Name']){
								$hano[$n]['Count']+=1;
							
								break;
							}
						}
						if($n >= $hanoC) {
							$hano[$hanoC]= array('Name'=>$index['Crop']['CropType'],'Count'=>$count);
							$hanoC++;
						}
					}
					else if ($index['Crop']['Parish']=="KINGSTON"){
						for ($n=0; $n<$kingC; $n++){
							if ($index['Crop']['CropType'] == $king[$n]['Name']){
								$king[$n]['Count']+=1;
							
								break;
							}
						}
						if($n >= $kingC) {
							$king[$kingC]= array('Name'=>$index['Crop']['CropType'],'Count'=>$count);
							$kingC++;
						}
					}
					else if ($index['Crop']['Parish']=="MANCHESTER"){
						for ($n=0; $n<$mancC; $n++){
							if ($index['Crop']['CropType'] == $manc[$n]['Name']){
								$manc[$n]['Count']+=1;
							
								break;
							}
						}
						if($n >= $mancC) {
							$manc[$mancC]= array('Name'=>$index['Crop']['CropType'],'Count'=>$count);
							$mancC++;
						}
					}
					else if ($index['Crop']['Parish']=="PORTLAND"){
						for ($n=0; $n<$portC; $n++){
							if ($index['Crop']['CropType'] == $port[$n]['Name']){
								$port[$n]['Count']+=1;
							
								break;
							}
						}
						if($n >= $portC) {
							$port[$portC]= array('Name'=>$index['Crop']['CropType'],'Count'=>$count);
							$portC++;
						}
					}
					else if ($index['Crop']['Parish']=="ST.ANDREW"){
						for ($n=0; $n<$standC; $n++){
							if ($index['Crop']['CropType'] == $stand[$n]['Name']){
								$stand[$n]['Count']+=1;
							
								break;
							}
						}
						if($n >= $standC) {
							$stand[$standC]= array('Name'=>$index['Crop']['CropType'],'Count'=>$count);
							$standC++;
						}
					}
					else if ($index['Crop']['Parish']=="ST.ANN"){
						for ($n=0; $n<$stannC; $n++){
							if ($index['Crop']['CropType'] == $stann[$n]['Name']){
								$stann[$n]['Count']+=1;
							
								break;
							}
						}
						if($n >= $stannC) {
							$stann[$stannC]= array('Name'=>$index['Crop']['CropType'],'Count'=>$count);
							$stannC++;
						}
					}
					else if ($index['Crop']['Parish']=="ST.CATHERINE"){
						for ($n=0; $n<$stcaC; $n++){
							if ($index['Crop']['CropType'] == $stca[$n]['Name']){
								$stca[$n]['Count']+=1;
							
								break;
							}
						}
						if($n >= $stcaC) {
							$stca[$stcaC]= array('Name'=>$index['Crop']['CropType'],'Count'=>$count);
							$stcaC++;
						}
					}
					else if ($index['Crop']['Parish']=="ST.ELIZABETH"){
						for ($n=0; $n<$stelC; $n++){
							if ($index['Crop']['CropType'] == $stel[$n]['Name']){
								$stel[$n]['Count']+=1;
							
								break;
							}
						}
						if($n >= $stelC) {
							$stel[$stelC]= array('Name'=>$index['Crop']['CropType'],'Count'=>$count);
							$stelC++;
						}
					}
					else if ($index['Crop']['Parish']=="ST.JAMES"){
						for ($n=0; $n<$stjaC; $n++){
							if ($index['Crop']['CropType'] == $stja[$n]['Name']){
								$stja[$n]['Count']+=1;
								
								break;
							}
						}	
						if($n >= $stjaC) {
							$stja[$stjaC]= array('Name'=>$index['Crop']['CropType'],'Count'=>$count);
							$stjaC++;
						}
					}
					else if ($index['Crop']['Parish']=="ST.MARY"){
						for ($n=0; $n<$stmaC; $n++){
							if ($index['Crop']['CropType'] == $stma[$n]['Name']){
								$stma[$n]['Count']+=1;
							
								break;
							}
						}
						if($n >= $stmaC) {
							$stma[$stmaC]= array('Name'=>$index['Crop']['CropType'],'Count'=>$count);
							$stmaC++;
						}
					}
					else if ($index['Crop']['Parish']=="ST.THOMAS"){
						for ($n=0; $n<$stthC; $n++){
							if ($index['Crop']['CropType'] == $stth[$n]['Name']){
								$stth[$n]['Count']+=1;
							
								break;
							}
						}
						if($n >= $stthC) {
							$stth[$stthC]= array('Name'=>$index['Crop']['CropType'],'Count'=>$count);
							$stthC++;
						}
					}
					else if ($index['Crop']['Parish']=="TRELAWNY"){
						for ($n=0; $n<$trelC; $n++){
							if ($index['Crop']['CropType'] == $trel[$n]['Name']){
								$trel[$n]['Count']+=1;
							
								break;
							}
						}
						if($n >= $trelC) {
							$trel[$trelC]= array('Name'=>$index['Crop']['CropType'],'Count'=>$count);
							$trelC++;
						}
					}
					else if ($index['Crop']['Parish']=="WESTMORELAND"){
						for ($n=0; $n<$westC; $n++){
							if ($index['Crop']['CropType'] == $west[$n]['Name']){
								$west[$n]['Count']+=1;
							
								break;
							}
						}
						if($n >= $westC) {
							$west[$westC]= array('Name'=>$index['Crop']['CropType'],'Count'=>$count);
							$westC++;
						}
					}
				}
			}
			if ($clarC  == 0){
				$clar[0]= array('Name'=>"NONE", 'Count'=>0);
			}
			if ($hanoC  == 0){
				$hano[0]= array('Name'=>"NONE", 'Count'=>0);
			}
			if ($kingC  == 0){
				$king[0]= array('Name'=>"NONE", 'Count'=>0);
			}
			if ($mancC  == 0){
				$manc[0]= array('Name'=>"NONE", 'Count'=>0);
			}
			if ($portC  == 0){
				$port[0]= array('Name'=>"NONE", 'Count'=>0);
			}
			if ($standC == 0){
				$stand[0]= array('Name'=>"NONE", 'Count'=>0);
			}
			if ($stannC == 0){
				$stann[0]= array('Name'=>"NONE", 'Count'=>0);
			}
			if ($stcaC  == 0){
				$stca[0]= array('Name'=>"NONE", 'Count'=>0);
			}
			if ($stelC  == 0){
				$stel[0]= array('Name'=>"NONE", 'Count'=>0);
			}
			if ($stjaC == 0){
				$stja[0]= array('Name'=>"NONE", 'Count'=>0);
			}
			if ($stmaC == 0){
				$stma[0]= array('Name'=>"NONE", 'Count'=>0);
			}
			if ($stthC == 0){
				$stth[0]= array('Name'=>"NONE", 'Count'=>0);
			}
			if ($trelC == 0){
				$trel[0]= array('Name'=>"NONE", 'Count'=>0);
			}
			if ($westC == 0){
				$west[0]= array('Name'=>"NONE", 'Count'=>0);
			}
		
		
			$CLAR = array('name'=>"Clarendon",'count'=>$clarC, 'Crops'=>array('Crop'=>$clar));
			$HANO = array('name'=>"Hanover", 'count'=>$hanoC, 'Crops'=>array('Crop'=>$hano));
			$KING = array('name'=>"Kingston", 'count'=>$kingC, 'Crops'=>array('Crop'=>$king));
			$MANC = array('name'=>"Manchester", 'count'=>$mancC, 'Crops'=>array('Crop'=>$manc));
			$PORT = array('name'=>"Portland", 'count'=>$portC, 'Crops'=>array('Crop'=>$port));
			$STAND= array('name'=>"St. Andrew", 'count'=>$standC, 'Crops'=>array('Crop'=>$stand));
			$STANN= array('name'=>"St. Ann", 'count'=>$stannC, 'Crops'=>array('Crop'=>$stann));
			$STCA = array('name'=>"St. Cathrine", 'count'=>$stcaC, 'Crops'=>array('Crop'=>$stca));
			$STEL = array('name'=>"St. Elizabeth", 'count'=>$stelC, 'Crops'=>array('Crop'=>$stel));
			$STJA = array('name'=>"St. James", 'count'=>$stjaC, 'Crops'=>array('Crop'=>$stja));
			$STMA = array('name'=>"St. Mary", 'count'=>$stmaC, 'Crops'=>array('Crop'=>$stma));
			$STTH = array('name'=>"St. Thomas", 'count'=>$stthC, 'Crops'=>array('Crop'=>$stth));
			$TREL = array('name'=>"Trelawny", 'count'=>$trelC, 'Crops'=>array('Crop'=>$trel));
			$WEST = array('name'=>"Westmoreland", 'count'=>$westC, 'Crops'=>array('Crop'=>$west));
			$parishes = array('0'=>$CLAR,'1'=>$HANO ,'2'=>$KING ,'3'=>$MANC ,'4'=>$PORT, '5'=>$STANN,'6'=>$STAND, '7'=>$STCA, '8'=>$STEL ,'9'=>$STJA ,'10'=>$STMA ,'11'=>$STTH ,'12'=>$TREL ,'13'=>$WEST);
		
			$data = array('0'=>array('Parishes'=>$parishes));
		
		
		
			$this->set('crops', $data);
			$this->View = 'Webservice.Webservice';
		}
		
	}
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function xml(){
		$xmlData = array(
			'person' => array(
				'name' => 'Stephen',
				'age' => 22,
				'hair' => array(
					'length' => 'medium',
					'colour' => 'dark brown'
				)
			)
		);
 
		App::import('Helper', 'Xml');
		$xml = new XmlHelper();
	
		$file = $xml->header(); // We need the XML header before our data.
		$file .= $xml->serialize($xmlData, array('whitespace' => true));
 
		// Write the file.
		$xmlFile = fopen('c:/wamp/www/test.xml', 'a');
		fwrite($xmlFile, $file);
		fclose($xmlFile);
	}
}
?>
