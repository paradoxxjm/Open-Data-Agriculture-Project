<?php
    /**
     * 
     */
    class FarmsController extends AppController {
		
        var $helpers = array ('Html', 'Form');
        var $components = array('RequestHandler', 'Webservice.Webservice');     //Components to manage exportation to xml & json
        var $name = 'Farms';
        
        /*This variable is used to manage the amount and ordering of data that is passed 
            to view (See http://book.cakephp.org/view/1231/Pagination for details  */
        var $paginate = array(
            'limit' => 1000,
            'order' => array(
                'Farm.FarmerID' => 'asc'
                )
        );

        function index() {
            /*Function: queryString
             *Input: Array of URL posted parameters
             *Output: SQL query string
             *=====================================
            */    
            function queryString($urlParams) {
//                print_r($urlParams);
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
            ///////////////////////////////////////////////////////

			$url = $this->params['url'];
 //           print_r($url);
			if ($url['ext']=="html"){
				$query = queryString($url);
				$table = $this->paginate('Farm', $query);
				$this->set('farms', $table);
				$this->View = 'Webservice.Webservice';
			}
			else{
				$query = queryString($url);
				//$returndata= false;
				//$this->View = 'Webservice.Webservice';
				$data = $this->paginate('Farm',$query);
				$count=1;
				//if ($query == "1"){
				//}
				//else{
				//$countpar=1;
				$clarC  = 0; $hanoC = 0; $kingC = 0; $mancC = 0; $portC = 0; $standC = 0;
				$stannC = 0; $stcaC = 0; $stelC = 0; $stjaC = 0; $stmaC = 0; $stthC  = 0;
				$trelC  = 0; $westC = 0;
				foreach($data as $index){
					
					if ($index['Farm']['Parish']=="CLARENDON"){
						for ($n=0; $n<$clarC; $n++){
							if ($index['Farm']['Extension'] == $clar[$n]['Name']){
								//go through districts
								for ($m=0; $m <$clar[$n]['districts']['count']; $m++){
									if ($index['Farm']['District'] == $clar[$n]['districts']['district'][$m]['name']){
										//go through farmerss
										for ($p = 0; $p < $clar[$n]['districts']['district'][$m]['farmers']['count']; $p++){
											if ($index['Farm']['FarmerID']== $clar[$n]['districts']['district'][$m]['farmers']['farmer'][$p]['farmerID']){
												// go through farms
												for($q=0;$q < $clar[$n]['districts']['district'][$m]['farmers']['farmer'][$p]['farms']['count']; $q++){
													if ($index['Farm']['PropertyID'] == $clar[$n]['districts']['district'][$m]['farmers']['farmer'][$p]['farms']['farm'][$q]['farmID']){
														
														break;
													}
													
												}
												if($q >= $clar[$n]['districts']['district'][$m]['farmers']['farmer'][$p]['farms']['count']){
													$clar[$n]['districts']['district'][$m]['farmers']['farmer'][$p]['farms']['farm'][$q]=array('farmID'=>$index['Farm']['PropertyID'],'propertySize'=>$index['Farm']['PropertySize'],'coords'=>array('X-coord'=>$index['Farm']['Xcoord'],'Y-coord'=>$index['Farm']['Ycoord']));
													$clar[$n]['districts']['district'][$m]['farmers']['farmer'][$p]['farms']['count']+=1;
												}
												break;
											}
										}
										if ($p < $clar[$n]['districts']['district'][$m]['farmers']['count']){
											$clar[$n]['districts']['district'][$m]['farmers']['farmer'][$clar[$n]['districts']['district'][$m]['farmers']['count']]= array('name'=>array('firstName'=>$index['Farm']['firstname'], 'lastName'=>$index['Farm']['lastname']),'farmerSize'=>$index['Farm']['Farmersize'],'farmerID'=>$index['Farm']['FarmerID'], 'farms'=>array('count'=>1,
																		'farm'=>array('0'=>array('farmID'=>$index['Farm']['PropertyID'],'propertySize'=>$index['Farm']['PropertySize'],'coords'=>array('X-coord'=>$index['Farm']['Xcoord'],'Y-coord'=>$index['Farm']['Ycoord'])))));
											$clar[$n]['districts']['district'][$m]['farmers']['count']+=1;
										}
										break;
									}
								}
								if ($m >= $clar[$n]['districts']['count']){
									$clar[$n]['districts']['district'][$clar[$n]['districts']['count']] = array('name'=>$index['Farm']['District'],'farmers'=>array('count'=>1,
														'farmer'=>array('0'=>array('name'=>array('firstName'=>$index['Farm']['firstname'], 'lastName'=>$index['Farm']['lastname']),'farmerSize'=>$index['Farm']['Farmersize'],'farmerID'=>$index['Farm']['FarmerID'], 'farms'=>array('count'=>1,
																		'farm'=>array('0'=>array('farmID'=>$index['Farm']['PropertyID'],'propertySize'=>$index['Farm']['PropertySize'],'coords'=>array('X-coord'=>$index['Farm']['Xcoord'],'Y-coord'=>$index['Farm']['Ycoord']))))))));
									$clar[$n]['districts']['count']+=1;
								}
								
								break;
							}
						}
						if($n >= $clarC) {
							$clar[$clarC]= array('Name'=>$index['Farm']['Extension'],'districts'=>array('count'=>$count, 'district'=>array('0'=>array('name'=>$index['Farm']['District'],'farmers'=>array('count'=>1,
														'farmer'=>array('0'=>array('name'=>array('firstName'=>$index['Farm']['firstname'], 'lastName'=>$index['Farm']['lastname']),'farmerSize'=>$index['Farm']['Farmersize'],'farmerID'=>$index['Farm']['FarmerID'], 'farms'=>array('count'=>1,
																		'farm'=>array('0'=>array('farmID'=>$index['Farm']['PropertyID'],'propertySize'=>$index['Farm']['PropertySize'],'coords'=>array('X-coord'=>$index['Farm']['Xcoord'],'Y-coord'=>$index['Farm']['Ycoord'])))))))))));
							
							$clarC++;
						}
					}
					else if ($index['Farm']['Parish']=="HANOVER"){
						for ($n=0; $n<$hanoC; $n++){
							if ($index['Farm']['Extension'] == $hano[$n]['Name']){
								//go through districts
								for ($m=0; $m <$hano[$n]['districts']['count']; $m++){
									if ($index['Farm']['District'] == $hano[$n]['districts']['district'][$m]['name']){
										//go through farmerss
										for ($p = 0; $p < $hano[$n]['districts']['district'][$m]['farmers']['count']; $p++){
											if ($index['Farm']['FarmerID']== $hano[$n]['districts']['district'][$m]['farmers']['farmer'][$p]['farmerID']){
												// go through farms
												for($q=0;$q < $hano[$n]['districts']['district'][$m]['farmers']['farmer'][$p]['farms']['count']; $q++){
													if ($index['Farm']['PropertyID'] == $hano[$n]['districts']['district'][$m]['farmers']['farmer'][$p]['farms']['farm'][$q]['farmID']){
														
														break;
													}
													
												}
												if($q >= $hano[$n]['districts']['district'][$m]['farmers']['farmer'][$p]['farms']['count']){
													$hano[$n]['districts']['district'][$m]['farmers']['farmer'][$p]['farms']['farm'][$q]=array('farmID'=>$index['Farm']['PropertyID'],'propertySize'=>$index['Farm']['PropertySize'],'coords'=>array('X-coord'=>$index['Farm']['Xcoord'],'Y-coord'=>$index['Farm']['Ycoord']));
													$hano[$n]['districts']['district'][$m]['farmers']['farmer'][$p]['farms']['count']+=1;
												}
												break;
											}
										}
										if ($p < $hano[$n]['districts']['district'][$m]['farmers']['count']){
											$hano[$n]['districts']['district'][$m]['farmers']['farmer'][$hano[$n]['districts']['district'][$m]['farmers']['count']]= array('name'=>array('firstName'=>$index['Farm']['firstname'], 'lastName'=>$index['Farm']['lastname']),'farmerSize'=>$index['Farm']['Farmersize'],'farmerID'=>$index['Farm']['FarmerID'], 'farms'=>array('count'=>1,
																		'farm'=>array('0'=>array('farmID'=>$index['Farm']['PropertyID'],'propertySize'=>$index['Farm']['PropertySize'],'coords'=>array('X-coord'=>$index['Farm']['Xcoord'],'Y-coord'=>$index['Farm']['Ycoord'])))));
											$hano[$n]['districts']['district'][$m]['farmers']['count']+=1;
										}
										break;
									}
								}
								if ($m >= $hano[$n]['districts']['count']){
									$hano[$n]['districts']['district'][$hano[$n]['districts']['count']] = array('name'=>$index['Farm']['District'],'farmers'=>array('count'=>1,
														'farmer'=>array('0'=>array('name'=>array('firstName'=>$index['Farm']['firstname'], 'lastname'=>$index['Farm']['lastname']),'farmerSize'=>$index['Farm']['Farmersize'],'farmerID'=>$index['Farm']['FarmerID'], 'farms'=>array('count'=>1,
																		'farm'=>array('0'=>array('farmID'=>$index['Farm']['PropertyID'],'propertySize'=>$index['Farm']['PropertySize'],'coords'=>array('X-coord'=>$index['Farm']['Xcoord'],'Y-coord'=>$index['Farm']['Ycoord']))))))));
									$hano[$n]['districts']['count']+=1;
								}
								
								break;
							}
						}
						if($n >= $hanoC) {
							$hano[$hanoC]= array('Name'=>$index['Farm']['Extension'],'districts'=>array('count'=>$count, 'district'=>array('0'=>array('name'=>$index['Farm']['District'],'farmers'=>array('count'=>1,
														'farmer'=>array('0'=>array('name'=>array('firstName'=>$index['Farm']['firstname'], 'lastName'=>$index['Farm']['lastname']),'farmerSize'=>$index['Farm']['Farmersize'],'farmerID'=>$index['Farm']['FarmerID'], 'farms'=>array('count'=>1,
																		'farm'=>array('0'=>array('farmID'=>$index['Farm']['PropertyID'],'propertySize'=>$index['Farm']['PropertySize'],'coords'=>array('X-coord'=>$index['Farm']['Xcoord'],'Y-coord'=>$index['Farm']['Ycoord'])))))))))));
							
							$hanoC++;
						}
					}
					else if ($index['Farm']['Parish']=="KINGSTO"){
						for ($n=0; $n<$kingC; $n++){
							if ($index['Farm']['Extension'] == $king[$n]['Name']){
								//go through districts
								for ($m=0; $m <$king[$n]['districts']['count']; $m++){
									if ($index['Farm']['District'] == $king[$n]['districts']['district'][$m]['name']){
										//go through farmerss
										for ($p = 0; $p < $king[$n]['districts']['district'][$m]['farmers']['count']; $p++){
											if ($index['Farm']['FarmerID']== $king[$n]['districts']['district'][$m]['farmers']['farmer'][$p]['farmerID']){
												// go through farms
												for($q=0;$q < $king[$n]['districts']['district'][$m]['farmers']['farmer'][$p]['farms']['count']; $q++){
													if ($index['Farm']['PropertyID'] == $king[$n]['districts']['district'][$m]['farmers']['farmer'][$p]['farms']['farm'][$q]['farmID']){
														
														break;
													}
													
												}
												if($q >= $king[$n]['districts']['district'][$m]['farmers']['farmer'][$p]['farms']['count']){
													$king[$n]['districts']['district'][$m]['farmers']['farmer'][$p]['farms']['farm'][$q]=array('farmID'=>$index['Farm']['PropertyID'],'propertySize'=>$index['Farm']['PropertySize'],'coords'=>array('X-coord'=>$index['Farm']['Xcoord'],'Y-coord'=>$index['Farm']['Ycoord']));
													$king[$n]['districts']['district'][$m]['farmers']['farmer'][$p]['farms']['count']+=1;
												}
												break;
											}
										}
										if ($p < $king[$n]['districts']['district'][$m]['farmers']['count']){
											$king[$n]['districts']['district'][$m]['farmers']['farmer'][$king[$n]['districts']['district'][$m]['farmers']['count']]= array('name'=>array('firstName'=>$index['Farm']['firstname'], 'lastName'=>$index['Farm']['lastname']),'farmerSize'=>$index['Farm']['Farmersize'],'farmerID'=>$index['Farm']['FarmerID'], 'farms'=>array('count'=>1,
																		'farm'=>array('0'=>array('farmID'=>$index['Farm']['PropertyID'],'propertySize'=>$index['Farm']['PropertySize'],'coords'=>array('X-coord'=>$index['Farm']['Xcoord'],'Y-coord'=>$index['Farm']['Ycoord'])))));
											$king[$n]['districts']['district'][$m]['farmers']['count']+=1;
										}
										break;
									}
								}
								if ($m >= $king[$n]['districts']['count']){
									$king[$n]['districts']['district'][$king[$n]['districts']['count']] = array('name'=>$index['Farm']['District'],'farmers'=>array('count'=>1,
														'farmer'=>array('0'=>array('name'=>array('firstName'=>$index['Farm']['firstname'], 'lastName'=>$index['Farm']['lastname']),'farmerSize'=>$index['Farm']['Farmersize'],'farmerID'=>$index['Farm']['FarmerID'], 'farms'=>array('count'=>1,
																		'farm'=>array('0'=>array('farmID'=>$index['Farm']['PropertyID'],'propertySize'=>$index['Farm']['PropertySize'],'coords'=>array('X-coord'=>$index['Farm']['Xcoord'],'Y-coord'=>$index['Farm']['Ycoord']))))))));
									$king[$n]['districts']['count']+=1;
								}
								
								break;
							}
						}
						if($n >= $kingC) {
							$king[$kingC]= array('Name'=>$index['Farm']['Extension'],'districts'=>array('count'=>$count, 'district'=>array('0'=>array('name'=>$index['Farm']['District'],'farmers'=>array('count'=>1,
														'farmer'=>array('0'=>array('name'=>array('firstName'=>$index['Farm']['firstname'], 'lastName'=>$index['Farm']['lastname']),'farmerSize'=>$index['Farm']['Farmersize'],'farmerID'=>$index['Farm']['FarmerID'], 'farms'=>array('count'=>1,
																		'farm'=>array('0'=>array('farmID'=>$index['Farm']['PropertyID'],'propertySize'=>$index['Farm']['PropertySize'],'coords'=>array('X-coord'=>$index['Farm']['Xcoord'],'Y-coord'=>$index['Farm']['Ycoord'])))))))))));
							
							$kingC++;
						}
					}
					else if ($index['Farm']['Parish']=="MANCHESTER"){
						for ($n=0; $n<$mancC; $n++){
							if ($index['Farm']['Extension'] == $manc[$n]['Name']){
								//go through districts
								for ($m=0; $m <$manc[$n]['districts']['count']; $m++){
									if ($index['Farm']['District'] == $manc[$n]['districts']['district'][$m]['name']){
										//go through farmerss
										for ($p = 0; $p < $manc[$n]['districts']['district'][$m]['farmers']['count']; $p++){
											if ($index['Farm']['FarmerID']== $manc[$n]['districts']['district'][$m]['farmers']['farmer'][$p]['farmerID']){
												// go through farms
												for($q=0;$q < $manc[$n]['districts']['district'][$m]['farmers']['farmer'][$p]['farms']['count']; $q++){
													if ($index['Farm']['PropertyID'] == $manc[$n]['districts']['district'][$m]['farmers']['farmer'][$p]['farms']['farm'][$q]['farmID']){
														
														break;
													}
													
												}
												if($q >= $manc[$n]['districts']['district'][$m]['farmers']['farmer'][$p]['farms']['count']){
													$manc[$n]['districts']['district'][$m]['farmers']['farmer'][$p]['farms']['farm'][$q]=array('farmID'=>$index['Farm']['PropertyID'],'propertySize'=>$index['Farm']['PropertySize'],'coords'=>array('X-coord'=>$index['Farm']['Xcoord'],'Y-coord'=>$index['Farm']['Ycoord']));
													$manc[$n]['districts']['district'][$m]['farmers']['farmer'][$p]['farms']['count']+=1;
												}
												break;
											}
										}
										if ($p < $manc[$n]['districts']['district'][$m]['farmers']['count']){
											$manc[$n]['districts']['district'][$m]['farmers']['farmer'][$manc[$n]['districts']['district'][$m]['farmers']['count']]= array('name'=>array('firstName'=>$index['Farm']['firstname'], 'lastName'=>$index['Farm']['lastname']),'farmerSize'=>$index['Farm']['Farmersize'],'farmerID'=>$index['Farm']['FarmerID'], 'farms'=>array('count'=>1,
																		'farm'=>array('0'=>array('farmID'=>$index['Farm']['PropertyID'],'propertySize'=>$index['Farm']['PropertySize'],'coords'=>array('X-coord'=>$index['Farm']['Xcoord'],'Y-coord'=>$index['Farm']['Ycoord'])))));
											$manc[$n]['districts']['district'][$m]['farmers']['count']+=1;
										}
										break;
									}
								}
								if ($m >= $manc[$n]['districts']['count']){
									$manc[$n]['districts']['district'][$manc[$n]['districts']['count']] = array('name'=>$index['Farm']['District'],'farmers'=>array('count'=>1,
														'farmer'=>array('0'=>array('name'=>array('firstName'=>$index['Farm']['firstname'], 'lastName'=>$index['Farm']['lastname']),'farmerSize'=>$index['Farm']['Farmersize'],'farmerID'=>$index['Farm']['FarmerID'], 'farms'=>array('count'=>1,
																		'farm'=>array('0'=>array('farmID'=>$index['Farm']['PropertyID'],'propertySize'=>$index['Farm']['PropertySize'],'coords'=>array('X-coord'=>$index['Farm']['Xcoord'],'Y-coord'=>$index['Farm']['Ycoord']))))))));
									$manc[$n]['districts']['count']+=1;
								}
								
								break;
							}
						}
						if($n >= $mancC) {
							$manc[$mancC]= array('Name'=>$index['Farm']['Extension'],'districts'=>array('count'=>$count, 'district'=>array('0'=>array('name'=>$index['Farm']['District'],'farmers'=>array('count'=>1,
														'farmer'=>array('0'=>array('name'=>array('firstName'=>$index['Farm']['firstname'], 'lastName'=>$index['Farm']['lastname']),'farmerSize'=>$index['Farm']['Farmersize'],'farmerID'=>$index['Farm']['FarmerID'], 'farms'=>array('count'=>1,
																		'farm'=>array('0'=>array('farmID'=>$index['Farm']['PropertyID'],'propertySize'=>$index['Farm']['PropertySize'],'coords'=>array('X-coord'=>$index['Farm']['Xcoord'],'Y-coord'=>$index['Farm']['Ycoord'])))))))))));
							
							$mancC++;
						}
					}
					else if ($index['Farm']['Parish']=="PORTLAND"){
						for ($n=0; $n<$portC; $n++){
							if ($index['Farm']['Extension'] == $port[$n]['Name']){
								//go through districts
								for ($m=0; $m <$port[$n]['districts']['count']; $m++){
									if ($index['Farm']['District'] == $port[$n]['districts']['district'][$m]['name']){
										//go through farmerss
										for ($p = 0; $p < $port[$n]['districts']['district'][$m]['farmers']['count']; $p++){
											if ($index['Farm']['FarmerID']== $port[$n]['districts']['district'][$m]['farmers']['farmer'][$p]['farmerID']){
												// go through farms
												for($q=0;$q < $port[$n]['districts']['district'][$m]['farmers']['farmer'][$p]['farms']['count']; $q++){
													if ($index['Farm']['PropertyID'] == $port[$n]['districts']['district'][$m]['farmers']['farmer'][$p]['farms']['farm'][$q]['farmID']){
														
														break;
													}
													
												}
												if($q >= $port[$n]['districts']['district'][$m]['farmers']['farmer'][$p]['farms']['count']){
													$port[$n]['districts']['district'][$m]['farmers']['farmer'][$p]['farms']['farm'][$q]=array('farmID'=>$index['Farm']['PropertyID'],'propertySize'=>$index['Farm']['PropertySize'],'coords'=>array('X-coord'=>$index['Farm']['Xcoord'],'Y-coord'=>$index['Farm']['Ycoord']));
													$port[$n]['districts']['district'][$m]['farmers']['farmer'][$p]['farms']['count']+=1;
												}
												break;
											}
										}
										if ($p < $port[$n]['districts']['district'][$m]['farmers']['count']){
											$port[$n]['districts']['district'][$m]['farmers']['farmer'][$port[$n]['districts']['district'][$m]['farmers']['count']]= array('name'=>array('firstName'=>$index['Farm']['firstname'], 'lastName'=>$index['Farm']['lastname']),'farmerSize'=>$index['Farm']['Farmersize'],'farmerID'=>$index['Farm']['FarmerID'], 'farms'=>array('count'=>1,
																		'farm'=>array('0'=>array('farmID'=>$index['Farm']['PropertyID'],'propertySize'=>$index['Farm']['PropertySize'],'coords'=>array('X-coord'=>$index['Farm']['Xcoord'],'Y-coord'=>$index['Farm']['Ycoord'])))));
											$port[$n]['districts']['district'][$m]['farmers']['count']+=1;
										}
										break;
									}
								}
								if ($m >= $port[$n]['districts']['count']){
									$port[$n]['districts']['district'][$port[$n]['districts']['count']] = array('name'=>$index['Farm']['District'],'farmers'=>array('count'=>1,
														'farmer'=>array('0'=>array('name'=>array('firstName'=>$index['Farm']['firstname'], 'lastName'=>$index['Farm']['lastname']),'farmerSize'=>$index['Farm']['Farmersize'],'farmerID'=>$index['Farm']['FarmerID'], 'farms'=>array('count'=>1,
																		'farm'=>array('0'=>array('farmID'=>$index['Farm']['PropertyID'],'propertySize'=>$index['Farm']['PropertySize'],'coords'=>array('X-coord'=>$index['Farm']['Xcoord'],'Y-coord'=>$index['Farm']['Ycoord']))))))));
									$port[$n]['districts']['count']+=1;
								}
								
								break;
							}
						}
						if($n >= $portC) {
							$port[$portC]= array('Name'=>$index['Farm']['Extension'],'districts'=>array('count'=>$count, 'district'=>array('0'=>array('name'=>$index['Farm']['District'],'farmers'=>array('count'=>1,
														'farmer'=>array('0'=>array('name'=>array('firstName'=>$index['Farm']['firstname'], 'lastName'=>$index['Farm']['lastname']),'farmerSize'=>$index['Farm']['Farmersize'],'farmerID'=>$index['Farm']['FarmerID'], 'farms'=>array('count'=>1,
																		'farm'=>array('0'=>array('farmID'=>$index['Farm']['PropertyID'],'propertySize'=>$index['Farm']['PropertySize'],'coords'=>array('X-coord'=>$index['Farm']['Xcoord'],'Y-coord'=>$index['Farm']['Ycoord'])))))))))));
							
							$portC++;
						}
					}
					else if ($index['Farm']['Parish']=="ST.ANDREW"){
						for ($n=0; $n<$standC; $n++){
							if ($index['Farm']['Extension'] == $stand[$n]['Name']){
								//go through districts
								for ($m=0; $m <$stand[$n]['districts']['count']; $m++){
									if ($index['Farm']['District'] == $stand[$n]['districts']['district'][$m]['name']){
										//go through farmerss
										for ($p = 0; $p < $stand[$n]['districts']['district'][$m]['farmers']['count']; $p++){
											if ($index['Farm']['FarmerID']== $stand[$n]['districts']['district'][$m]['farmers']['farmer'][$p]['farmerID']){
												// go through farms
												for($q=0;$q < $stand[$n]['districts']['district'][$m]['farmers']['farmer'][$p]['farms']['count']; $q++){
													if ($index['Farm']['PropertyID'] == $stand[$n]['districts']['district'][$m]['farmers']['farmer'][$p]['farms']['farm'][$q]['farmID']){
														
														break;
													}
													
												}
												if($q >= $stand[$n]['districts']['district'][$m]['farmers']['farmer'][$p]['farms']['count']){
													$stand[$n]['districts']['district'][$m]['farmers']['farmer'][$p]['farms']['farm'][$q]=array('farmID'=>$index['Farm']['PropertyID'],'propertySize'=>$index['Farm']['PropertySize'],'coords'=>array('X-coord'=>$index['Farm']['Xcoord'],'Y-coord'=>$index['Farm']['Ycoord']));
													$stand[$n]['districts']['district'][$m]['farmers']['farmer'][$p]['farms']['count']+=1;
												}
												break;
											}
										}
										if ($p < $stand[$n]['districts']['district'][$m]['farmers']['count']){
											$stand[$n]['districts']['district'][$m]['farmers']['farmer'][$stand[$n]['districts']['district'][$m]['farmers']['count']]= array('name'=>array('firstName'=>$index['Farm']['firstname'], 'lastname'=>$index['Farm']['lastname']),'farmerSize'=>$index['Farm']['Farmersize'],'farmerID'=>$index['Farm']['FarmerID'], 'farms'=>array('count'=>1,
																		'farm'=>array('0'=>array('farmID'=>$index['Farm']['PropertyID'],'propertySize'=>$index['Farm']['PropertySize'],'coords'=>array('X-coord'=>$index['Farm']['Xcoord'],'Y-coord'=>$index['Farm']['Ycoord'])))));
											$stand[$n]['districts']['district'][$m]['farmers']['count']+=1;
										}
										break;
									}
								}
								if ($m >= $stand[$n]['districts']['count']){
									$stand[$n]['districts']['district'][$stand[$n]['districts']['count']] = array('name'=>$index['Farm']['District'],'farmers'=>array('count'=>1,
														'farmer'=>array('0'=>array('name'=>array('firstName'=>$index['Farm']['firstname'], 'lastName'=>$index['Farm']['lastname']),'farmerSize'=>$index['Farm']['Farmersize'],'farmerID'=>$index['Farm']['FarmerID'], 'farms'=>array('count'=>1,
																		'farm'=>array('0'=>array('farmID'=>$index['Farm']['PropertyID'],'propertySize'=>$index['Farm']['PropertySize'],'coords'=>array('X-coord'=>$index['Farm']['Xcoord'],'Y-coord'=>$index['Farm']['Ycoord']))))))));
									$stand[$n]['districts']['count']+=1;
								}
								
								break;
							}
						}
						if($n >= $standC) {
							$stand[$standC]= array('Name'=>$index['Farm']['Extension'],'districts'=>array('count'=>$count, 'district'=>array('0'=>array('name'=>$index['Farm']['District'],'farmers'=>array('count'=>1,
														'farmer'=>array('0'=>array('name'=>array('firstName'=>$index['Farm']['firstname'], 'lastName'=>$index['Farm']['lastname']),'farmerSize'=>$index['Farm']['Farmersize'],'farmerID'=>$index['Farm']['FarmerID'], 'farms'=>array('count'=>1,
																		'farm'=>array('0'=>array('farmID'=>$index['Farm']['PropertyID'],'propertySize'=>$index['Farm']['PropertySize'],'coords'=>array('X-coord'=>$index['Farm']['Xcoord'],'Y-coord'=>$index['Farm']['Ycoord'])))))))))));
							
							$standC++;
						}
					}
					else if ($index['Farm']['Parish']=="ST.ANN"){
						for ($n=0; $n<$stannC; $n++){
							if ($index['Farm']['Extension'] == $stann[$n]['Name']){
								//go through districts
								for ($m=0; $m <$stann[$n]['districts']['count']; $m++){
									if ($index['Farm']['District'] == $stann[$n]['districts']['district'][$m]['name']){
										//go through farmerss
										for ($p = 0; $p < $stann[$n]['districts']['district'][$m]['farmers']['count']; $p++){
											if ($index['Farm']['FarmerID']== $stann[$n]['districts']['district'][$m]['farmers']['farmer'][$p]['farmerID']){
												// go through farms
												for($q=0;$q < $stann[$n]['districts']['district'][$m]['farmers']['farmer'][$p]['farms']['count']; $q++){
													if ($index['Farm']['PropertyID'] == $stann[$n]['districts']['district'][$m]['farmers']['farmer'][$p]['farms']['farm'][$q]['farmID']){
														
														break;
													}
													
												}
												if($q >= $stann[$n]['districts']['district'][$m]['farmers']['farmer'][$p]['farms']['count']){
													$stann[$n]['districts']['district'][$m]['farmers']['farmer'][$p]['farms']['farm'][$q]=array('farmID'=>$index['Farm']['PropertyID'],'propertySize'=>$index['Farm']['PropertySize'],'coords'=>array('X-coord'=>$index['Farm']['Xcoord'],'Y-coord'=>$index['Farm']['Ycoord']));
													$stann[$n]['districts']['district'][$m]['farmers']['farmer'][$p]['farms']['count']+=1;
												}
												break;
											}
										}
										if ($p < $stann[$n]['districts']['district'][$m]['farmers']['count']){
											$stann[$n]['districts']['district'][$m]['farmers']['farmer'][$stann[$n]['districts']['district'][$m]['farmers']['count']]= array('name'=>array('firstName'=>$index['Farm']['firstname'], 'lastName'=>$index['Farm']['lastname']),'farmerSize'=>$index['Farm']['Farmersize'],'farmerID'=>$index['Farm']['FarmerID'], 'farms'=>array('count'=>1,
																		'farm'=>array('0'=>array('farmID'=>$index['Farm']['PropertyID'],'propertySize'=>$index['Farm']['PropertySize'],'coords'=>array('X-coord'=>$index['Farm']['Xcoord'],'Y-coord'=>$index['Farm']['Ycoord'])))));
											$stann[$n]['districts']['district'][$m]['farmers']['count']+=1;
										}
										break;
									}
								}
								if ($m >= $stann[$n]['districts']['count']){
									$stann[$n]['districts']['district'][$stann[$n]['districts']['count']] = array('name'=>$index['Farm']['District'],'farmers'=>array('count'=>1,
														'farmer'=>array('0'=>array('name'=>array('firstName'=>$index['Farm']['firstname'], 'lastName'=>$index['Farm']['lastname']),'farmerSize'=>$index['Farm']['Farmersize'],'farmerID'=>$index['Farm']['FarmerID'], 'farms'=>array('count'=>1,
																		'farm'=>array('0'=>array('farmID'=>$index['Farm']['PropertyID'],'propertySize'=>$index['Farm']['PropertySize'],'coords'=>array('X-coord'=>$index['Farm']['Xcoord'],'Y-coord'=>$index['Farm']['Ycoord']))))))));
									$stann[$n]['districts']['count']+=1;
								}
								
								break;
							}
						}
						if($n >= $stannC) {
							$stann[$stannC]= array('Name'=>$index['Farm']['Extension'],'districts'=>array('count'=>$count, 'district'=>array('0'=>array('name'=>$index['Farm']['District'],'farmers'=>array('count'=>1,
														'farmer'=>array('0'=>array('name'=>array('firstName'=>$index['Farm']['firstname'], 'lastName'=>$index['Farm']['lastname']),'farmerSize'=>$index['Farm']['Farmersize'],'farmerID'=>$index['Farm']['FarmerID'], 'farms'=>array('count'=>1,
																		'farm'=>array('0'=>array('farmID'=>$index['Farm']['PropertyID'],'propertySize'=>$index['Farm']['PropertySize'],'coords'=>array('X-coord'=>$index['Farm']['Xcoord'],'Y-coord'=>$index['Farm']['Ycoord'])))))))))));
							
							$stannC++;
						}
					}
					else if ($index['Farm']['Parish']=="ST.CATHERINE"){
						for ($n=0; $n<$stcaC; $n++){
							if ($index['Farm']['Extension'] == $stca[$n]['Name']){
								//go through districts
								for ($m=0; $m <$stca[$n]['districts']['count']; $m++){
									if ($index['Farm']['District'] == $stca[$n]['districts']['district'][$m]['name']){
										//go through farmerss
										for ($p = 0; $p < $stca[$n]['districts']['district'][$m]['farmers']['count']; $p++){
											if ($index['Farm']['FarmerID']== $stca[$n]['districts']['district'][$m]['farmers']['farmer'][$p]['farmerID']){
												// go through farms
												for($q=0;$q < $stca[$n]['districts']['district'][$m]['farmers']['farmer'][$p]['farms']['count']; $q++){
													if ($index['Farm']['PropertyID'] == $stca[$n]['districts']['district'][$m]['farmers']['farmer'][$p]['farms']['farm'][$q]['farmID']){
														
														break;
													}
													
												}
												if($q >= $stca[$n]['districts']['district'][$m]['farmers']['farmer'][$p]['farms']['count']){
													$stca[$n]['districts']['district'][$m]['farmers']['farmer'][$p]['farms']['farm'][$q]=array('farmID'=>$index['Farm']['PropertyID'],'propertySize'=>$index['Farm']['PropertySize'],'coords'=>array('X-coord'=>$index['Farm']['Xcoord'],'Y-coord'=>$index['Farm']['Ycoord']));
													$stca[$n]['districts']['district'][$m]['farmers']['farmer'][$p]['farms']['count']+=1;
												}
												break;
											}
										}
										if ($p < $stca[$n]['districts']['district'][$m]['farmers']['count']){
											$stca[$n]['districts']['district'][$m]['farmers']['farmer'][$stca[$n]['districts']['district'][$m]['farmers']['count']]= array('name'=>array('firstName'=>$index['Farm']['firstname'], 'lastName'=>$index['Farm']['lastname']),'farmerSize'=>$index['Farm']['Farmersize'],'farmerID'=>$index['Farm']['FarmerID'], 'farms'=>array('count'=>1,
																		'farm'=>array('0'=>array('farmID'=>$index['Farm']['PropertyID'],'propertySize'=>$index['Farm']['PropertySize'],'coords'=>array('X-coord'=>$index['Farm']['Xcoord'],'Y-coord'=>$index['Farm']['Ycoord'])))));
											$stca[$n]['districts']['district'][$m]['farmers']['count']+=1;
										}
										break;
									}
								}
								if ($m >= $stca[$n]['districts']['count']){
									$stca[$n]['districts']['district'][$stca[$n]['districts']['count']] = array('name'=>$index['Farm']['District'],'farmers'=>array('count'=>1,
														'farmer'=>array('0'=>array('name'=>array('firstName'=>$index['Farm']['firstname'], 'lastName'=>$index['Farm']['lastname']),'farmerSize'=>$index['Farm']['Farmersize'],'farmerID'=>$index['Farm']['FarmerID'], 'farms'=>array('count'=>1,
																		'farm'=>array('0'=>array('farmID'=>$index['Farm']['PropertyID'],'propertySize'=>$index['Farm']['PropertySize'],'coords'=>array('X-coord'=>$index['Farm']['Xcoord'],'Y-coord'=>$index['Farm']['Ycoord']))))))));
									$stca[$n]['districts']['count']+=1;
								}
								
								break;
							}
						}
						if($n >= $stcaC) {
							$stca[$stcaC]= array('Name'=>$index['Farm']['Extension'],'districts'=>array('count'=>$count, 'district'=>array('0'=>array('name'=>$index['Farm']['District'],'farmers'=>array('count'=>1,
														'farmer'=>array('0'=>array('name'=>array('firstName'=>$index['Farm']['firstname'], 'lastName'=>$index['Farm']['lastname']),'farmerSize'=>$index['Farm']['Farmersize'],'farmerID'=>$index['Farm']['FarmerID'], 'farms'=>array('count'=>1,
																		'farm'=>array('0'=>array('farmID'=>$index['Farm']['PropertyID'],'propertySize'=>$index['Farm']['PropertySize'],'coords'=>array('X-coord'=>$index['Farm']['Xcoord'],'Y-coord'=>$index['Farm']['Ycoord'])))))))))));
							
							$stcaC++;
						}
					}
					else if ($index['Farm']['Parish']=="ST.ELIZABETH"){
						for ($n=0; $n<$stelC; $n++){
							if ($index['Farm']['Extension'] == $stel[$n]['Name']){
								//go through districts
								for ($m=0; $m <$stel[$n]['districts']['count']; $m++){
									if ($index['Farm']['District'] == $stel[$n]['districts']['district'][$m]['name']){
										//go through farmerss
										for ($p = 0; $p < $stel[$n]['districts']['district'][$m]['farmers']['count']; $p++){
											if ($index['Farm']['FarmerID']== $stel[$n]['districts']['district'][$m]['farmers']['farmer'][$p]['farmerID']){
												// go through farms
												for($q=0;$q < $stel[$n]['districts']['district'][$m]['farmers']['farmer'][$p]['farms']['count']; $q++){
													if ($index['Farm']['PropertyID'] == $stel[$n]['districts']['district'][$m]['farmers']['farmer'][$p]['farms']['farm'][$q]['farmID']){
														
														break;
													}
													
												}
												if($q >= $stel[$n]['districts']['district'][$m]['farmers']['farmer'][$p]['farms']['count']){
													$stel[$n]['districts']['district'][$m]['farmers']['farmer'][$p]['farms']['farm'][$q]=array('farmID'=>$index['Farm']['PropertyID'],'propertySize'=>$index['Farm']['PropertySize'],'coords'=>array('X-coord'=>$index['Farm']['Xcoord'],'Y-coord'=>$index['Farm']['Ycoord']));
													$stel[$n]['districts']['district'][$m]['farmers']['farmer'][$p]['farms']['count']+=1;
												}
												break;
											}
										}
										if ($p < $stel[$n]['districts']['district'][$m]['farmers']['count']){
											$stel[$n]['districts']['district'][$m]['farmers']['farmer'][$stel[$n]['districts']['district'][$m]['farmers']['count']]= array('name'=>array('firstName'=>$index['Farm']['firstname'], 'lastName'=>$index['Farm']['lastname']),'farmerSize'=>$index['Farm']['Farmersize'],'farmerID'=>$index['Farm']['FarmerID'], 'farms'=>array('count'=>1,
																		'farm'=>array('0'=>array('farmID'=>$index['Farm']['PropertyID'],'propertySize'=>$index['Farm']['PropertySize'],'coords'=>array('X-coord'=>$index['Farm']['Xcoord'],'Y-coord'=>$index['Farm']['Ycoord'])))));
											$stel[$n]['districts']['district'][$m]['farmers']['count']+=1;
										}
										break;
									}
								}
								if ($m >= $stel[$n]['districts']['count']){
									$stel[$n]['districts']['district'][$stel[$n]['districts']['count']] = array('name'=>$index['Farm']['District'],'farmers'=>array('count'=>1,
														'farmer'=>array('0'=>array('name'=>array('firstName'=>$index['Farm']['firstname'], 'lastName'=>$index['Farm']['lastname']),'farmerSize'=>$index['Farm']['Farmersize'],'farmerID'=>$index['Farm']['FarmerID'], 'farms'=>array('count'=>1,
																		'farm'=>array('0'=>array('farmID'=>$index['Farm']['PropertyID'],'propertySize'=>$index['Farm']['PropertySize'],'coords'=>array('X-coord'=>$index['Farm']['Xcoord'],'Y-coord'=>$index['Farm']['Ycoord']))))))));
									$stel[$n]['districts']['count']+=1;
								}
								
								break;
							}
						}
						if($n >= $stelC) {
							$stel[$stelC]= array('Name'=>$index['Farm']['Extension'],'districts'=>array('count'=>$count, 'district'=>array('0'=>array('name'=>$index['Farm']['District'],'farmers'=>array('count'=>1,
														'farmer'=>array('0'=>array('name'=>array('firstName'=>$index['Farm']['firstname'], 'lastName'=>$index['Farm']['lastname']),'farmerSize'=>$index['Farm']['Farmersize'],'farmerID'=>$index['Farm']['FarmerID'], 'farms'=>array('count'=>1,
																		'farm'=>array('0'=>array('farmID'=>$index['Farm']['PropertyID'],'propertySize'=>$index['Farm']['PropertySize'],'coords'=>array('X-coord'=>$index['Farm']['Xcoord'],'Y-coord'=>$index['Farm']['Ycoord'])))))))))));
							
							$stelC++;
						}
					}
					else if ($index['Farm']['Parish']=="ST.JAMES"){
						for ($n=0; $n<$stjaC; $n++){
							if ($index['Farm']['Extension'] == $stja[$n]['Name']){
								//go through districts
								for ($m=0; $m <$stja[$n]['districts']['count']; $m++){
									if ($index['Farm']['District'] == $stja[$n]['districts']['district'][$m]['name']){
										//go through farmerss
										for ($p = 0; $p < $stja[$n]['districts']['district'][$m]['farmers']['count']; $p++){
											if ($index['Farm']['FarmerID']== $stja[$n]['districts']['district'][$m]['farmers']['farmer'][$p]['farmerID']){
												// go through farms
												for($q=0;$q < $stja[$n]['districts']['district'][$m]['farmers']['farmer'][$p]['farms']['count']; $q++){
													if ($index['Farm']['PropertyID'] == $stja[$n]['districts']['district'][$m]['farmers']['farmer'][$p]['farms']['farm'][$q]['farmID']){
														
														break;
													}
													
												}
												if($q >= $stja[$n]['districts']['district'][$m]['farmers']['farmer'][$p]['farms']['count']){
													$stja[$n]['districts']['district'][$m]['farmers']['farmer'][$p]['farms']['farm'][$q]=array('farmID'=>$index['Farm']['PropertyID'],'propertySize'=>$index['Farm']['PropertySize'],'coords'=>array('X-coord'=>$index['Farm']['Xcoord'],'Y-coord'=>$index['Farm']['Ycoord']));
													$stja[$n]['districts']['district'][$m]['farmers']['farmer'][$p]['farms']['count']+=1;
												}
												break;
											}
										}
										if ($p < $stja[$n]['districts']['district'][$m]['farmers']['count']){
											$stja[$n]['districts']['district'][$m]['farmers']['farmer'][$stja[$n]['districts']['district'][$m]['farmers']['count']]= array('name'=>array('firstName'=>$index['Farm']['firstname'], 'lastName'=>$index['Farm']['lastname']),'farmerSize'=>$index['Farm']['Farmersize'],'farmerID'=>$index['Farm']['FarmerID'], 'farms'=>array('count'=>1,
																		'farm'=>array('0'=>array('farmID'=>$index['Farm']['PropertyID'],'propertySize'=>$index['Farm']['PropertySize'],'coords'=>array('X-coord'=>$index['Farm']['Xcoord'],'Y-coord'=>$index['Farm']['Ycoord'])))));
											$stja[$n]['districts']['district'][$m]['farmers']['count']+=1;
										}
										break;
									}
								}
								if ($m >= $stja[$n]['districts']['count']){
									$stja[$n]['districts']['district'][$stja[$n]['districts']['count']] = array('name'=>$index['Farm']['District'],'farmers'=>array('count'=>1,
														'farmer'=>array('0'=>array('name'=>array('firstName'=>$index['Farm']['firstname'], 'lastName'=>$index['Farm']['lastname']),'farmerSize'=>$index['Farm']['Farmersize'],'farmerID'=>$index['Farm']['FarmerID'], 'farms'=>array('count'=>1,
																		'farm'=>array('0'=>array('farmID'=>$index['Farm']['PropertyID'],'propertySize'=>$index['Farm']['PropertySize'],'coords'=>array('X-coord'=>$index['Farm']['Xcoord'],'Y-coord'=>$index['Farm']['Ycoord']))))))));
									$stja[$n]['districts']['count']+=1;
								}
								
								break;
							}
						}
						if($n >= $stjaC) {
							$stja[$stjaC]= array('Name'=>$index['Farm']['Extension'],'districts'=>array('count'=>$count, 'district'=>array('0'=>array('name'=>$index['Farm']['District'],'farmers'=>array('count'=>1,
														'farmer'=>array('0'=>array('name'=>array('firstName'=>$index['Farm']['firstname'], 'lastName'=>$index['Farm']['lastname']),'farmerSize'=>$index['Farm']['Farmersize'],'farmerID'=>$index['Farm']['FarmerID'], 'farms'=>array('count'=>1,
																		'farm'=>array('0'=>array('farmID'=>$index['Farm']['PropertyID'],'propertySize'=>$index['Farm']['PropertySize'],'coords'=>array('X-coord'=>$index['Farm']['Xcoord'],'Y-coord'=>$index['Farm']['Ycoord'])))))))))));
							
							$stjaC++;
						}
					}
					else if ($index['Farm']['Parish']=="ST.MARY"){
						for ($n=0; $n<$stmaC; $n++){
							if ($index['Farm']['Extension'] == $stma[$n]['Name']){
								//go through districts
								for ($m=0; $m <$stma[$n]['districts']['count']; $m++){
									if ($index['Farm']['District'] == $stma[$n]['districts']['district'][$m]['name']){
										//go through farmerss
										for ($p = 0; $p < $stma[$n]['districts']['district'][$m]['farmers']['count']; $p++){
											if ($index['Farm']['FarmerID']== $stma[$n]['districts']['district'][$m]['farmers']['farmer'][$p]['farmerID']){
												// go through farms
												for($q=0;$q < $stma[$n]['districts']['district'][$m]['farmers']['farmer'][$p]['farms']['count']; $q++){
													if ($index['Farm']['PropertyID'] == $stma[$n]['districts']['district'][$m]['farmers']['farmer'][$p]['farms']['farm'][$q]['farmID']){
														
														break;
													}
													
												}
												if($q >= $stma[$n]['districts']['district'][$m]['farmers']['farmer'][$p]['farms']['count']){
													$stma[$n]['districts']['district'][$m]['farmers']['farmer'][$p]['farms']['farm'][$q]=array('farmID'=>$index['Farm']['PropertyID'],'propertySize'=>$index['Farm']['PropertySize'],'coords'=>array('X-coord'=>$index['Farm']['Xcoord'],'Y-coord'=>$index['Farm']['Ycoord']));
													$stma[$n]['districts']['district'][$m]['farmers']['farmer'][$p]['farms']['count']+=1;
												}
												break;
											}
										}
										if ($p < $stma[$n]['districts']['district'][$m]['farmers']['count']){
											$stma[$n]['districts']['district'][$m]['farmers']['farmer'][$stma[$n]['districts']['district'][$m]['farmers']['count']]= array('name'=>array('firstName'=>$index['Farm']['firstname'], 'lastName'=>$index['Farm']['lastname']),'farmerSize'=>$index['Farm']['Farmersize'],'farmerID'=>$index['Farm']['FarmerID'], 'farms'=>array('count'=>1,
																		'farm'=>array('0'=>array('farmID'=>$index['Farm']['PropertyID'],'propertySize'=>$index['Farm']['PropertySize'],'coords'=>array('X-coord'=>$index['Farm']['Xcoord'],'Y-coord'=>$index['Farm']['Ycoord'])))));
											$stma[$n]['districts']['district'][$m]['farmers']['count']+=1;
										}
										break;
									}
								}
								if ($m >= $stma[$n]['districts']['count']){
									$stma[$n]['districts']['district'][$stma[$n]['districts']['count']] = array('name'=>$index['Farm']['District'],'farmers'=>array('count'=>1,
														'farmer'=>array('0'=>array('name'=>array('firstName'=>$index['Farm']['firstname'], 'lastName'=>$index['Farm']['lastname']),'farmerSize'=>$index['Farm']['Farmersize'],'farmerID'=>$index['Farm']['FarmerID'], 'farms'=>array('count'=>1,
																		'farm'=>array('0'=>array('farmID'=>$index['Farm']['PropertyID'],'propertySize'=>$index['Farm']['PropertySize'],'coords'=>array('X-coord'=>$index['Farm']['Xcoord'],'Y-coord'=>$index['Farm']['Ycoord']))))))));
									$stma[$n]['districts']['count']+=1;
								}
								
								break;
							}
						}
						if($n >= $stmaC) {
							$stma[$stmaC]= array('Name'=>$index['Farm']['Extension'],'districts'=>array('count'=>$count, 'district'=>array('0'=>array('name'=>$index['Farm']['District'],'farmers'=>array('count'=>1,
														'farmer'=>array('0'=>array('name'=>array('firstName'=>$index['Farm']['firstname'], 'lastName'=>$index['Farm']['lastname']),'farmerSize'=>$index['Farm']['Farmersize'],'farmerID'=>$index['Farm']['FarmerID'], 'farms'=>array('count'=>1,
																		'farm'=>array('0'=>array('farmID'=>$index['Farm']['PropertyID'],'propertySize'=>$index['Farm']['PropertySize'],'coords'=>array('X-coord'=>$index['Farm']['Xcoord'],'Y-coord'=>$index['Farm']['Ycoord'])))))))))));
							
							$stmaC++;
						}
					}
					else if ($index['Farm']['Parish']=="ST.THOMAS"){
						for ($n=0; $n<$stthC; $n++){
							if ($index['Farm']['Extension'] == $stth[$n]['Name']){
								//go through districts
								for ($m=0; $m <$stth[$n]['districts']['count']; $m++){
									if ($index['Farm']['District'] == $stth[$n]['districts']['district'][$m]['name']){
										//go through farmerss
										for ($p = 0; $p < $stth[$n]['districts']['district'][$m]['farmers']['count']; $p++){
											if ($index['Farm']['FarmerID']== $stth[$n]['districts']['district'][$m]['farmers']['farmer'][$p]['farmerID']){
												// go through farms
												for($q=0;$q < $stth[$n]['districts']['district'][$m]['farmers']['farmer'][$p]['farms']['count']; $q++){
													if ($index['Farm']['PropertyID'] == $stth[$n]['districts']['district'][$m]['farmers']['farmer'][$p]['farms']['farm'][$q]['farmID']){
														
														break;
													}
													
												}
												if($q >= $stth[$n]['districts']['district'][$m]['farmers']['farmer'][$p]['farms']['count']){
													$stth[$n]['districts']['district'][$m]['farmers']['farmer'][$p]['farms']['farm'][$q]=array('farmID'=>$index['Farm']['PropertyID'],'propertySize'=>$index['Farm']['PropertySize'],'coords'=>array('X-coord'=>$index['Farm']['Xcoord'],'Y-coord'=>$index['Farm']['Ycoord']));
													$stth[$n]['districts']['district'][$m]['farmers']['farmer'][$p]['farms']['count']+=1;
												}
												break;
											}
										}
										if ($p < $stth[$n]['districts']['district'][$m]['farmers']['count']){
											$stth[$n]['districts']['district'][$m]['farmers']['farmer'][$stth[$n]['districts']['district'][$m]['farmers']['count']]= array('name'=>array('firstName'=>$index['Farm']['firstname'], 'lastName'=>$index['Farm']['lastname']),'farmerSize'=>$index['Farm']['Farmersize'],'farmerID'=>$index['Farm']['FarmerID'], 'farms'=>array('count'=>1,
																		'farm'=>array('0'=>array('farmID'=>$index['Farm']['PropertyID'],'propertySize'=>$index['Farm']['PropertySize'],'coords'=>array('X-coord'=>$index['Farm']['Xcoord'],'Y-coord'=>$index['Farm']['Ycoord'])))));
											$stth[$n]['districts']['district'][$m]['farmers']['count']+=1;
										}
										break;
									}
								}
								if ($m >= $stth[$n]['districts']['count']){
									$stth[$n]['districts']['district'][$stth[$n]['districts']['count']] = array('name'=>$index['Farm']['District'],'farmers'=>array('count'=>1,
														'farmer'=>array('0'=>array('name'=>array('firstName'=>$index['Farm']['firstname'], 'lastName'=>$index['Farm']['lastname']),'farmerSize'=>$index['Farm']['Farmersize'],'farmerID'=>$index['Farm']['FarmerID'], 'farms'=>array('count'=>1,
																		'farm'=>array('0'=>array('farmID'=>$index['Farm']['PropertyID'],'propertySize'=>$index['Farm']['PropertySize'],'coords'=>array('X-coord'=>$index['Farm']['Xcoord'],'Y-coord'=>$index['Farm']['Ycoord']))))))));
									$stth[$n]['districts']['count']+=1;
								}
								
								break;
							}
						}
						if($n >= $stthC) {
							$stth[$stthC]= array('Name'=>$index['Farm']['Extension'],'districts'=>array('count'=>$count, 'district'=>array('0'=>array('name'=>$index['Farm']['District'],'farmers'=>array('count'=>1,
														'farmer'=>array('0'=>array('name'=>array('firstName'=>$index['Farm']['firstname'], 'lastName'=>$index['Farm']['lastname']),'farmerSize'=>$index['Farm']['Farmersize'],'farmerID'=>$index['Farm']['FarmerID'], 'farms'=>array('count'=>1,
																		'farm'=>array('0'=>array('farmID'=>$index['Farm']['PropertyID'],'propertySize'=>$index['Farm']['PropertySize'],'coords'=>array('X-coord'=>$index['Farm']['Xcoord'],'Y-coord'=>$index['Farm']['Ycoord'])))))))))));
							
							$stthC++;
						}
					}
					else if ($index['Farm']['Parish']=="TRELAWNY"){
						for ($n=0; $n<$trelC; $n++){
							if ($index['Farm']['Extension'] == $trel[$n]['Name']){
								//go through districts
								for ($m=0; $m <$trel[$n]['districts']['count']; $m++){
									if ($index['Farm']['District'] == $trel[$n]['districts']['district'][$m]['name']){
										//go through farmerss
										for ($p = 0; $p < $trel[$n]['districts']['district'][$m]['farmers']['count']; $p++){
											if ($index['Farm']['FarmerID']== $trel[$n]['districts']['district'][$m]['farmers']['farmer'][$p]['farmerID']){
												// go through farms
												for($q=0;$q < $trel[$n]['districts']['district'][$m]['farmers']['farmer'][$p]['farms']['count']; $q++){
													if ($index['Farm']['PropertyID'] == $trel[$n]['districts']['district'][$m]['farmers']['farmer'][$p]['farms']['farm'][$q]['farmID']){
														
														break;
													}
													
												}
												if($q >= $trel[$n]['districts']['district'][$m]['farmers']['farmer'][$p]['farms']['count']){
													$trel[$n]['districts']['district'][$m]['farmers']['farmer'][$p]['farms']['farm'][$q]=array('farmID'=>$index['Farm']['PropertyID'],'propertySize'=>$index['Farm']['PropertySize'],'coords'=>array('X-coord'=>$index['Farm']['Xcoord'],'Y-coord'=>$index['Farm']['Ycoord']));
													$trel[$n]['districts']['district'][$m]['farmers']['farmer'][$p]['farms']['count']+=1;
												}
												break;
											}
										}
										if ($p < $trel[$n]['districts']['district'][$m]['farmers']['count']){
											$trel[$n]['districts']['district'][$m]['farmers']['farmer'][$trel[$n]['districts']['district'][$m]['farmers']['count']]= array('name'=>array('firstName'=>$index['Farm']['firstname'], 'lastName'=>$index['Farm']['lastname']),'farmerSize'=>$index['Farm']['Farmersize'],'farmerID'=>$index['Farm']['FarmerID'], 'farms'=>array('count'=>1,
																		'farm'=>array('0'=>array('farmID'=>$index['Farm']['PropertyID'],'propertySize'=>$index['Farm']['PropertySize'],'coords'=>array('X-coord'=>$index['Farm']['Xcoord'],'Y-coord'=>$index['Farm']['Ycoord'])))));
											$trel[$n]['districts']['district'][$m]['farmers']['count']+=1;
										}
										break;
									}
								}
								if ($m >= $trel[$n]['districts']['count']){
									$trel[$n]['districts']['district'][$trel[$n]['districts']['count']] = array('name'=>$index['Farm']['District'],'farmers'=>array('count'=>1,
														'farmer'=>array('0'=>array('name'=>array('firstName'=>$index['Farm']['firstname'], 'lastName'=>$index['Farm']['lastname']),'farmerSize'=>$index['Farm']['Farmersize'],'farmerID'=>$index['Farm']['FarmerID'], 'farms'=>array('count'=>1,
																		'farm'=>array('0'=>array('farmID'=>$index['Farm']['PropertyID'],'propertySize'=>$index['Farm']['PropertySize'],'coords'=>array('X-coord'=>$index['Farm']['Xcoord'],'Y-coord'=>$index['Farm']['Ycoord']))))))));
									$trel[$n]['districts']['count']+=1;
								}
								
								break;
							}
						}
						if($n >= $trelC) {
							$trel[$trelC]= array('Name'=>$index['Farm']['Extension'],'districts'=>array('count'=>$count, 'district'=>array('0'=>array('name'=>$index['Farm']['District'],'farmers'=>array('count'=>1,
														'farmer'=>array('0'=>array('name'=>array('firstName'=>$index['Farm']['firstname'], 'lastName'=>$index['Farm']['lastname']),'farmerSize'=>$index['Farm']['Farmersize'],'farmerID'=>$index['Farm']['FarmerID'], 'farms'=>array('count'=>1,
																		'farm'=>array('0'=>array('farmID'=>$index['Farm']['PropertyID'],'propertySize'=>$index['Farm']['PropertySize'],'coords'=>array('X-coord'=>$index['Farm']['Xcoord'],'Y-coord'=>$index['Farm']['Ycoord'])))))))))));
							
							$trelC++;
						}
					}
					else if ($index['Farm']['Parish']=="WESTMORELAND"){
						for ($n=0; $n<$westC; $n++){
							if ($index['Farm']['Extension'] == $west[$n]['Name']){
								//go through districts
								for ($m=0; $m <$west[$n]['districts']['count']; $m++){
									if ($index['Farm']['District'] == $west[$n]['districts']['district'][$m]['name']){
										//go through farmerss
										for ($p = 0; $p < $west[$n]['districts']['district'][$m]['farmers']['count']; $p++){
											if ($index['Farm']['FarmerID']== $west[$n]['districts']['district'][$m]['farmers']['farmer'][$p]['farmerID']){
												// go through farms
												for($q=0;$q < $west[$n]['districts']['district'][$m]['farmers']['farmer'][$p]['farms']['count']; $q++){
													if ($index['Farm']['PropertyID'] == $west[$n]['districts']['district'][$m]['farmers']['farmer'][$p]['farms']['farm'][$q]['farmID']){
														
														break;
													}
													
												}
												if($q >= $west[$n]['districts']['district'][$m]['farmers']['farmer'][$p]['farms']['count']){
													$west[$n]['districts']['district'][$m]['farmers']['farmer'][$p]['farms']['farm'][$q]=array('farmID'=>$index['Farm']['PropertyID'],'propertySize'=>$index['Farm']['PropertySize'],'coords'=>array('X-coord'=>$index['Farm']['Xcoord'],'Y-coord'=>$index['Farm']['Ycoord']));
													$west[$n]['districts']['district'][$m]['farmers']['farmer'][$p]['farms']['count']+=1;
												}
												break;
											}
										}
										if ($p < $west[$n]['districts']['district'][$m]['farmers']['count']){
											$west[$n]['districts']['district'][$m]['farmers']['farmer'][$west[$n]['districts']['district'][$m]['farmers']['count']]= array('name'=>array('firstName'=>$index['Farm']['firstname'], 'lastName'=>$index['Farm']['lastname']),'farmerSize'=>$index['Farm']['Farmersize'],'farmerID'=>$index['Farm']['FarmerID'], 'farms'=>array('count'=>1,
																		'farm'=>array('0'=>array('farmID'=>$index['Farm']['PropertyID'],'propertySize'=>$index['Farm']['PropertySize'],'coords'=>array('X-coord'=>$index['Farm']['Xcoord'],'Y-coord'=>$index['Farm']['Ycoord'])))));
											$west[$n]['districts']['district'][$m]['farmers']['count']+=1;
										}
										break;
									}
								}
								if ($m >= $west[$n]['districts']['count']){
									$west[$n]['districts']['district'][$west[$n]['districts']['count']] = array('name'=>$index['Farm']['District'],'farmers'=>array('count'=>1,
														'farmer'=>array('0'=>array('name'=>array('firstName'=>$index['Farm']['firstname'], 'lastName'=>$index['Farm']['lastname']),'farmerSize'=>$index['Farm']['Farmersize'],'farmerID'=>$index['Farm']['FarmerID'], 'farms'=>array('count'=>1,
																		'farm'=>array('0'=>array('farmID'=>$index['Farm']['PropertyID'],'propertySize'=>$index['Farm']['PropertySize'],'coords'=>array('X-coord'=>$index['Farm']['Xcoord'],'Y-coord'=>$index['Farm']['Ycoord']))))))));
									$west[$n]['districts']['count']+=1;
								}
								
								break;
							}
						}
						if($n >= $westC) {
							$west[$westC]= array('Name'=>$index['Farm']['Extension'],'districts'=>array('count'=>$count, 'district'=>array('0'=>array('name'=>$index['Farm']['District'],'farmers'=>array('count'=>1,
														'farmer'=>array('0'=>array('name'=>array('firstName'=>$index['Farm']['firstname'], 'lastName'=>$index['Farm']['lastname']),'farmerSize'=>$index['Farm']['Farmersize'],'farmerID'=>$index['Farm']['FarmerID'], 'farms'=>array('count'=>1,
																		'farm'=>array('0'=>array('farmID'=>$index['Farm']['PropertyID'],'propertySize'=>$index['Farm']['PropertySize'],'coords'=>array('X-coord'=>$index['Farm']['Xcoord'],'Y-coord'=>$index['Farm']['Ycoord'])))))))))));
							
							$westC++;
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
					$CLAR = array('name'=>"Clarendon", 'Extensions'=>array('count'=>$clarC,'Extension'=>$clar));
						$HANO = array('name'=>"Hanover",  'Extensions'=>array('count'=>$hanoC,'Extension'=>$hano));
						$KING = array('name'=>"Kingston", 'Extensions'=>array('count'=>$kingC, 'Extension'=>$king));
						$MANC = array('name'=>"Manchester", 'Extensions'=>array('count'=>$mancC, 'Extension'=>$manc));
						$PORT = array('name'=>"Portland", 'Extensions'=>array('count'=>$portC, 'Extension'=>$port));
						$STAND= array('name'=>"St. Andrew", 'Extensions'=>array('count'=>$standC, 'Extension'=>$stand));
						$STANN= array('name'=>"St. Ann", 'Extensions'=>array('count'=>$stannC, 'Extension'=>$stann));
						$STCA = array('name'=>"St. Catherine", 'Extensions'=>array('count'=>$stcaC, 'Extension'=>$stca));
						$STEL = array('name'=>"St. Elizabeth", 'Extensions'=>array('count'=>$stelC, 'Extension'=>$stel));
						$STJA = array('name'=>"St. James", 'Extensions'=>array('count'=>$stjaC, 'Extension'=>$stja));
						$STMA = array('name'=>"St. Mary", 'Extensions'=>array('count'=>$stmaC, 'Extension'=>$stma));
						$STTH = array('name'=>"St. Thomas", 'Extensions'=>array('count'=>$stthC, 'Extension'=>$stth));
						$TREL = array('name'=>"Trelawny", 'Extensions'=>array('count'=>$trelC, 'Extension'=>$trel));
						$WEST = array('name'=>"Westmoreland", 'Extensions'=>array('count'=>$westC, 'Extension'=>$west));
						
						$parishes = array('0'=>$CLAR,'1'=>$HANO ,'2'=>$KING ,'3'=>$MANC ,'4'=>$PORT, '5'=>$STANN,'6'=>$STAND, '7'=>$STCA, '8'=>$STEL ,'9'=>$STJA ,'10'=>$STMA ,'11'=>$STTH ,'12'=>$TREL ,'13'=>$WEST);
					
					//$parishes = array('count'=>$countpar, 'parish'=>$parish);
					$data = array('parishes'=>$parishes);
						
					$this->set('farms', $data);
					$this->View = 'Webservice.Webservice';
					
				//}
			
			}
		}
    
        /*Function: Parishes
         *Description: Created a route in config/routes.php that forwards all requests to farms/parishes to this function
         *Input: URL request
         */
        function parishes($paramExt = null, $paramDis = null) {
        function queryString($urlParams) {
			//print_r($urlParams);
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
			//echo $query;
			return $query;
		}	
			function afterQuery(&$pArray) {
                foreach ( $pArray AS &$parish) {
                    $parish['Farm'] += $parish[0];
                    unset($parish[0]);
                }
                return $pArray; 
            }

            $this->View = 'Webservice.Webservice';
            $url = $this->params['url'];
            //            print_r($url);
            if (($paramExt == null) && ($paramDis == null)) {       //data.org/farms/parishes
                $isdis = false;
				$isext = false;
				$ispar = true;
				$parishes = $this->Farm->find('all', array('fields' => array( 'Farm.Parish', '(COUNT("Farm.Parish")) AS FarmCount', 
                    '(SUM(PropertySize)) AS PropertySum'), 'group'=>'Parish', 'order'=>array('Parish ASC')));
                $data = afterQuery($parishes);
                //$this->set('parishes',$data);   
            }
            elseif (($paramExt == ('extension'||'extensions')) && ($paramDis == null)) {     //data.org.jm/farms/extension(s) 
//                echo "Returns parishes+extension information";
                $isdis = false;
				$isext = true;
				$ispar = false;
				$parishes = $this->Farm->find('all', array('fields' => array( 'Farm.Parish', 'Farm.Extension', '(COUNT("Farm.Extension")) AS FarmCount', 
                    '(SUM(PropertySize)) AS PropertySum'), 'group'=>'Extension', 'order'=>array('Parish ASC', 'Extension ASC')));
                $data = afterQuery($parishes);
                //$this->set('parishes',$data);   
                //$this->render('extensions');     //districts.ctp not created yet
            }
            elseif (($paramExt == ('extension'||'extensions')) && ($paramDis  == ('district'||'districts'))) {     //data.org.jm/farms/extension(s)/district(s)/
				//echo "Returns parishes+extensions+districts information";
                $isdis = true;
				$isext = false;
				$ispar = false;
				$parishes = $this->Farm->find('all', array('fields' => array( 'Farm.Parish', 'Farm.Extension', 'Farm.District', 
                    '(COUNT("Farm.District")) AS FarmCount', '(SUM(PropertySize)) AS PropertySum'), 'group'=>'District', 
                    'order'=>array('Parish ASC', 'Extension ASC', 'District ASC')));
                $data = afterQuery($parishes);
                //$this->set('parishes',$data);
				//$this->render('districts');     //districts.ctp not created yet
				
			}
			
			
			if ($url['ext']=="html"){
				if ($ispar == true){
				
					$this->set('parishes',$data);
					//$this->render('districts');
				}
				else if ($isext == true){
				
					$this->set('parishes',$data);
					$this->render('extensions');
				}
				else if ($isdis == true){
				
					$this->set('parishes',$data);
					$this->render('districts');
				}
			}
			else{
				$query = queryString($url);
				//$returndata= false;
				$clarC  = 0; $hanoC = 0; $kingC = 0; $mancC = 0; $portC = 0; $standC = 0;
				$stannC = 0; $stcaC = 0; $stelC = 0; $stjaC = 0; $stmaC = 0; $stthC  = 0;
				$trelC  = 0; $westC = 0;
				//$data = $this->paginate('Farm');
				if ($query == ""){
					//$returndata= false;
					foreach($data as $index){
						$count = 1;
						if ($isdis == true){
						
							if ($index['Farm']['Parish']=="CLARENDON"){
								for ($n=0; $n<$clarC; $n++){
									if ($index['Farm']['Extension'] == $clar[$n]['Name']){
										//go through districts
										for ($m=0; $m <$clar[$n]['districts']['count']; $m++){
											if ($index['Farm']['District'] == $clar[$n]['districts']['district'][$m]['name']){
												$clar[$n]['districts']['district'][$m]['count']+=1;
												break;
											}
										}
										if ($m >= $clar[$n]['districts']['count']){
											$clar[$n]['districts']['district'][$clar[$n]['districts']['count']] = array('name'=>$index['Farm']['District'],
												'farmCount'=>$index['Farm']['FarmCount'], 'propertySum'=>$index['Farm']['PropertySum']);
											$clar[$n]['districts']['count']+=1;
										}
										
										break;
									}
								}
								if($n >= $clarC) {
									$clar[$clarC]= array('Name'=>$index['Farm']['Extension'],
									'districts'=>array('count'=>$count, 'district'=>array('0'=>array('name'=>$index['Farm']['District'],
									'farmCount'=>$index['Farm']['FarmCount'], 'propertySum'=>$index['Farm']['PropertySum']))));
									
									$clarC++;
								}
							}
							else if ($index['Farm']['Parish']=="HANOVER"){
								for ($n=0; $n<$hanoC; $n++){
									if ($index['Farm']['Extension'] == $hano[$n]['Name']){
										//go through districts
										for ($m=0; $m <$hano[$n]['districts']['count']; $m++){
											if ($index['Farm']['District'] == $hano[$n]['districts']['district'][$m]['name']){
												$hano[$n]['districts']['district'][$m]['count']+=1;
												break;
											}
										}
										if ($m >= $hano[$n]['districts']['count']){
											$hano[$n]['districts']['district'][$hano[$n]['districts']['count']] = array('name'=>$index['Farm']['District'],
												'farmCount'=>$index['Farm']['FarmCount'], 'propertySum'=>$index['Farm']['PropertySum']);
											$hano[$n]['districts']['count']+=1;
										}
										
										break;
									}
								}
								if($n >= $hanoC) {
									$hano[$hanoC]= array('Name'=>$index['Farm']['Extension'],
									'districts'=>array('count'=>$count, 'district'=>array('0'=>array('name'=>$index['Farm']['District'],
									'farmCount'=>$index['Farm']['FarmCount'], 'propertySum'=>$index['Farm']['PropertySum']))));
									
									$hanoC++;
								}
							}
							else if ($index['Farm']['Parish']=="KINGSTON"){
								for ($n=0; $n<$kingC; $n++){
									if ($index['Farm']['Extension'] == $king[$n]['Name']){
										//go through districts
										for ($m=0; $m <$king[$n]['districts']['count']; $m++){
											if ($index['Farm']['District'] == $king[$n]['districts']['district'][$m]['name']){
												$king[$n]['districts']['district'][$m]['count']+=1;
												break;
											}
										}
										if ($m >= $king[$n]['districts']['count']){
											$king[$n]['districts']['district'][$king[$n]['districts']['count']] = array('name'=>$index['Farm']['District'],
												'farmCount'=>$index['Farm']['FarmCount'], 'propertySum'=>$index['Farm']['PropertySum']);
											$king[$n]['districts']['count']+=1;
										}
										
										break;
									}
								}
								if($n >= $kingC) {
									$king[$kingC]= array('Name'=>$index['Farm']['Extension'],
									'districts'=>array('count'=>$count, 'district'=>array('0'=>array('name'=>$index['Farm']['District'],
									'farmCount'=>$index['Farm']['FarmCount'], 'propertySum'=>$index['Farm']['PropertySum']))));
									
									$kingC++;
								}
							}
							else if ($index['Farm']['Parish']=="MANCHESTER"){
								for ($n=0; $n<$mancC; $n++){
									if ($index['Farm']['Extension'] == $manc[$n]['Name']){
										//go through districts
										for ($m=0; $m <$manc[$n]['districts']['count']; $m++){
											if ($index['Farm']['District'] == $manc[$n]['districts']['district'][$m]['name']){
												$manc[$n]['districts']['district'][$m]['count']+=1;
												break;
											}
										}
										if ($m >= $manc[$n]['districts']['count']){
											$manc[$n]['districts']['district'][$manc[$n]['districts']['count']] = array('name'=>$index['Farm']['District'],
												'farmCount'=>$index['Farm']['FarmCount'], 'propertySum'=>$index['Farm']['PropertySum']);
											$manc[$n]['districts']['count']+=1;
										}
										
										break;
									}
								}
								if($n >= $mancC) {
									$manc[$mancC]= array('Name'=>$index['Farm']['Extension'],
									'districts'=>array('count'=>$count, 'district'=>array('0'=>array('name'=>$index['Farm']['District'],
									'farmCount'=>$index['Farm']['FarmCount'], 'propertySum'=>$index['Farm']['PropertySum']))));
									
									$mancC++;
								}
							}
							else if ($index['Farm']['Parish']=="PORTLAND"){
								for ($n=0; $n<$portC; $n++){
									if ($index['Farm']['Extension'] == $port[$n]['Name']){
										//go through districts
										for ($m=0; $m <$port[$n]['districts']['count']; $m++){
											if ($index['Farm']['District'] == $port[$n]['districts']['district'][$m]['name']){
												$port[$n]['districts']['district'][$m]['count']+=1;
												break;
											}
										}
										if ($m >= $port[$n]['districts']['count']){
											$port[$n]['districts']['district'][$port[$n]['districts']['count']] = array('name'=>$index['Farm']['District'],
												'farmCount'=>$index['Farm']['FarmCount'], 'propertySum'=>$index['Farm']['PropertySum']);
											$port[$n]['districts']['count']+=1;
										}
										
										break;
									}
								}
								if($n >= $portC) {
									$port[$portC]= array('Name'=>$index['Farm']['Extension'],
									'districts'=>array('count'=>$count, 'district'=>array('0'=>array('name'=>$index['Farm']['District'],
									'farmCount'=>$index['Farm']['FarmCount'], 'propertySum'=>$index['Farm']['PropertySum']))));
									
									$portC++;
								}
							}
							else if ($index['Farm']['Parish']=="ST.ANDREW"){
								for ($n=0; $n<$standC; $n++){
									if ($index['Farm']['Extension'] == $stand[$n]['Name']){
										//go through districts
										for ($m=0; $m <$stand[$n]['districts']['count']; $m++){
											if ($index['Farm']['District'] == $stand[$n]['districts']['district'][$m]['name']){
												$stand[$n]['districts']['district'][$m]['count']+=1;
												break;
											}
										}
										if ($m >= $stand[$n]['districts']['count']){
											$stand[$n]['districts']['district'][$stand[$n]['districts']['count']] = array('name'=>$index['Farm']['District'],
												'farmCount'=>$index['Farm']['FarmCount'], 'propertySum'=>$index['Farm']['PropertySum']);
											$stand[$n]['districts']['count']+=1;
										}
										
										break;
									}
								}
								if($n >= $standC) {
									$stand[$standC]= array('Name'=>$index['Farm']['Extension'],
									'districts'=>array('count'=>$count, 'district'=>array('0'=>array('name'=>$index['Farm']['District'],
									'farmCount'=>$index['Farm']['FarmCount'], 'propertySum'=>$index['Farm']['PropertySum']))));
									
									$standC++;
								}
							}
							else if ($index['Farm']['Parish']=="ST.ANN"){
								for ($n=0; $n<$stannC; $n++){
									if ($index['Farm']['Extension'] == $stann[$n]['Name']){
										//go through districts
										for ($m=0; $m <$stann[$n]['districts']['count']; $m++){
											if ($index['Farm']['District'] == $stann[$n]['districts']['district'][$m]['name']){
												$stann[$n]['districts']['district'][$m]['count']+=1;
												break;
											}
										}
										if ($m >= $stann[$n]['districts']['count']){
											$stann[$n]['districts']['district'][$stann[$n]['districts']['count']] = array('name'=>$index['Farm']['District'],
												'farmCount'=>$index['Farm']['FarmCount'], 'propertySum'=>$index['Farm']['PropertySum']);
											$stann[$n]['districts']['count']+=1;
										}
										
										break;
									}
								}
								if($n >= $stannC) {
									$stann[$stannC]= array('Name'=>$index['Farm']['Extension'],
									'districts'=>array('count'=>$count, 'district'=>array('0'=>array('name'=>$index['Farm']['District'],
									'farmCount'=>$index['Farm']['FarmCount'], 'propertySum'=>$index['Farm']['PropertySum']))));
									
									$stannC++;
								}
							}
							else if ($index['Farm']['Parish']=="ST.CATHERINE"){
								for ($n=0; $n<$stcaC; $n++){
									if ($index['Farm']['Extension'] == $stca[$n]['Name']){
										//go through districts
										for ($m=0; $m <$stca[$n]['districts']['count']; $m++){
											if ($index['Farm']['District'] == $stca[$n]['districts']['district'][$m]['name']){
												$stca[$n]['districts']['district'][$m]['count']+=1;
												break;
											}
										}
										if ($m >= $stca[$n]['districts']['count']){
											$stca[$n]['districts']['district'][$stca[$n]['districts']['count']] = array('name'=>$index['Farm']['District'],
												'farmCount'=>$index['Farm']['FarmCount'], 'propertySum'=>$index['Farm']['PropertySum']);
											$stca[$n]['districts']['count']+=1;
										}
										
										break;
									}
								}
								if($n >= $stcaC) {
									$stca[$stcaC]= array('Name'=>$index['Farm']['Extension'],
									'districts'=>array('count'=>$count, 'district'=>array('0'=>array('name'=>$index['Farm']['District'],
									'farmCount'=>$index['Farm']['FarmCount'], 'propertySum'=>$index['Farm']['PropertySum']))));
									
									$stcaC++;
								}
							}
							else if ($index['Farm']['Parish']=="ST.ELIZABETH"){
								for ($n=0; $n<$stelC; $n++){
									if ($index['Farm']['Extension'] == $stel[$n]['Name']){
										//go through districts
										for ($m=0; $m <$stel[$n]['districts']['count']; $m++){
											if ($index['Farm']['District'] == $stel[$n]['districts']['district'][$m]['name']){
												$stel[$n]['districts']['district'][$m]['count']+=1;
												break;
											}
										}
										if ($m >= $stel[$n]['districts']['count']){
											$stel[$n]['districts']['district'][$stel[$n]['districts']['count']] = array('name'=>$index['Farm']['District'],
												'farmCount'=>$index['Farm']['FarmCount'], 'propertySum'=>$index['Farm']['PropertySum']);
											$stel[$n]['districts']['count']+=1;
										}
										
										break;
									}
								}
								if($n >= $stelC) {
									$stel[$stelC]= array('Name'=>$index['Farm']['Extension'],
									'districts'=>array('count'=>$count, 'district'=>array('0'=>array('name'=>$index['Farm']['District'],
									'farmCount'=>$index['Farm']['FarmCount'], 'propertySum'=>$index['Farm']['PropertySum']))));
									
									$stelC++;
								}
							}
							else if ($index['Farm']['Parish']=="ST.JAMES"){
								for ($n=0; $n<$stjaC; $n++){
									if ($index['Farm']['Extension'] == $stja[$n]['Name']){
										//go through districts
										for ($m=0; $m <$stja[$n]['districts']['count']; $m++){
											if ($index['Farm']['District'] == $stja[$n]['districts']['district'][$m]['name']){
												$stja[$n]['districts']['district'][$m]['count']+=1;
												break;
											}
										}
										if ($m >= $stja[$n]['districts']['count']){
											$stja[$n]['districts']['district'][$stja[$n]['districts']['count']] = array('name'=>$index['Farm']['District'],
												'farmCount'=>$index['Farm']['FarmCount'], 'propertySum'=>$index['Farm']['PropertySum']);
											$stja[$n]['districts']['count']+=1;
										}
										
										break;
									}
								}
								if($n >= $stjaC) {
									$stja[$stjaC]= array('Name'=>$index['Farm']['Extension'],
									'districts'=>array('count'=>$count, 'district'=>array('0'=>array('name'=>$index['Farm']['District'],
									'farmCount'=>$index['Farm']['FarmCount'], 'propertySum'=>$index['Farm']['PropertySum']))));
									
									$stjaC++;
								}
							}
							else if ($index['Farm']['Parish']=="ST.MARY"){
								for ($n=0; $n<$stmaC; $n++){
									if ($index['Farm']['Extension'] == $stma[$n]['Name']){
										//go through districts
										for ($m=0; $m <$stma[$n]['districts']['count']; $m++){
											if ($index['Farm']['District'] == $stma[$n]['districts']['district'][$m]['name']){
												$stma[$n]['districts']['district'][$m]['count']+=1;
												break;
											}
										}
										if ($m >= $stma[$n]['districts']['count']){
											$stma[$n]['districts']['district'][$stma[$n]['districts']['count']] = array('name'=>$index['Farm']['District'],
												'farmCount'=>$index['Farm']['FarmCount'], 'propertySum'=>$index['Farm']['PropertySum']);
											$stma[$n]['districts']['count']+=1;
										}
										
										break;
									}
								}
								if($n >= $stmaC) {
									$stma[$stmaC]= array('Name'=>$index['Farm']['Extension'],
									'districts'=>array('count'=>$count, 'district'=>array('0'=>array('name'=>$index['Farm']['District'],
									'farmCount'=>$index['Farm']['FarmCount'], 'propertySum'=>$index['Farm']['PropertySum']))));
									
									$stmaC++;
								}
							}
							else if ($index['Farm']['Parish']=="ST.THOMAS"){
								for ($n=0; $n<$stthC; $n++){
									if ($index['Farm']['Extension'] == $stth[$n]['Name']){
										//go through districts
										for ($m=0; $m <$stth[$n]['districts']['count']; $m++){
											if ($index['Farm']['District'] == $stth[$n]['districts']['district'][$m]['name']){
												$stth[$n]['districts']['district'][$m]['count']+=1;
												break;
											}
										}
										if ($m >= $stth[$n]['districts']['count']){
											$stth[$n]['districts']['district'][$stth[$n]['districts']['count']] = array('name'=>$index['Farm']['District'],
												'farmCount'=>$index['Farm']['FarmCount'], 'propertySum'=>$index['Farm']['PropertySum']);
											$stth[$n]['districts']['count']+=1;
										}
										
										break;
									}
								}
								if($n >= $stthC) {
									$stth[$stthC]= array('Name'=>$index['Farm']['Extension'],
									'districts'=>array('count'=>$count, 'district'=>array('0'=>array('name'=>$index['Farm']['District'],
									'farmCount'=>$index['Farm']['FarmCount'], 'propertySum'=>$index['Farm']['PropertySum']))));
									
									$stthC++;
								}
							}
							else if ($index['Farm']['Parish']=="TRELAWNY"){
								for ($n=0; $n<$trelC; $n++){
									if ($index['Farm']['Extension'] == $trel[$n]['Name']){
										//go through districts
										for ($m=0; $m <$trel[$n]['districts']['count']; $m++){
											if ($index['Farm']['District'] == $trel[$n]['districts']['district'][$m]['name']){
												$trel[$n]['districts']['district'][$m]['count']+=1;
												break;
											}
										}
										if ($m >= $trel[$n]['districts']['count']){
											$trel[$n]['districts']['district'][$trel[$n]['districts']['count']] = array('name'=>$index['Farm']['District'],
												'farmCount'=>$index['Farm']['FarmCount'], 'propertySum'=>$index['Farm']['PropertySum']);
											$trel[$n]['districts']['count']+=1;
										}
										
										break;
									}
								}
								if($n >= $trelC) {
									$trel[$trelC]= array('Name'=>$index['Farm']['Extension'],
									'districts'=>array('count'=>$count, 'district'=>array('0'=>array('name'=>$index['Farm']['District'],
									'farmCount'=>$index['Farm']['FarmCount'], 'propertySum'=>$index['Farm']['PropertySum']))));
									
									$trelC++;
								}
							}
							else if ($index['Farm']['Parish']=="WESTMORELAND"){
								for ($n=0; $n<$westC; $n++){
									if ($index['Farm']['Extension'] == $west[$n]['Name']){
										//go through districts
										for ($m=0; $m <$west[$n]['districts']['count']; $m++){
											if ($index['Farm']['District'] == $west[$n]['districts']['district'][$m]['name']){
												$west[$n]['districts']['district'][$m]['count']+=1;
												break;
											}
										}
										if ($m >= $west[$n]['districts']['count']){
											$west[$n]['districts']['district'][$west[$n]['districts']['count']] = array('name'=>$index['Farm']['District'],
												'farmCount'=>$index['Farm']['FarmCount'], 'propertySum'=>$index['Farm']['PropertySum']);
											$west[$n]['districts']['count']+=1;
										}
										
										break;
									}
								}
								if($n >= $westC) {
									$west[$westC]= array('Name'=>$index['Farm']['Extension'],
									'districts'=>array('count'=>$count, 'district'=>array('0'=>array('name'=>$index['Farm']['District'],
									'farmCount'=>$index['Farm']['FarmCount'], 'propertySum'=>$index['Farm']['PropertySum']))));
									
									$westC++;
								}
							}
						}
						else if ($ispar == true){
							if ($index['Farm']['Parish']=="CLARENDON"){
								$clar = array('name'=>$index['Farm']['Parish'],'farmCount'=>$index['Farm']['FarmCount'], 'propertySum'=>$index['Farm']['PropertySum']);
								$clarC++;
								
							}
							else if ($index['Farm']['Parish']=="HANOVER"){
								$hano = array('name'=>$index['Farm']['Parish'],'farmCount'=>$index['Farm']['FarmCount'], 'propertySum'=>$index['Farm']['PropertySum']);
								$hanoC++;
							}
							else if ($index['Farm']['Parish']=="KINGSTON"){
								
								$king = array('name'=>$index['Farm']['Parish'],'farmCount'=>$index['Farm']['FarmCount'], 'propertySum'=>$index['Farm']['PropertySum']);
								$kingC++;
							}
							else if ($index['Farm']['Parish']=="MANCHESTER"){
								$manc = array('name'=>$index['Farm']['Parish'],'farmCount'=>$index['Farm']['FarmCount'], 'propertySum'=>$index['Farm']['PropertySum']);
								$mancC++;
							}
							else if ($index['Farm']['Parish']=="PORTLAND"){
								$port = array('name'=>$index['Farm']['Parish'],'farmCount'=>$index['Farm']['FarmCount'], 'propertySum'=>$index['Farm']['PropertySum']);
								$portC++;
								
							}
							else if ($index['Farm']['Parish']=="ST.ANDREW"){
								$stand = array('name'=>$index['Farm']['Parish'],'farmCount'=>$index['Farm']['FarmCount'], 'propertySum'=>$index['Farm']['PropertySum']);
								$standC++;
							}
							else if ($index['Farm']['Parish']=="ST.ANN"){
								$stann = array('name'=>$index['Farm']['Parish'],'farmCount'=>$index['Farm']['FarmCount'], 'propertySum'=>$index['Farm']['PropertySum']);
								$stannC++;
								
							}
							else if ($index['Farm']['Parish']=="ST.CATHERINE"){
								$stca = array('name'=>$index['Farm']['Parish'],'farmCount'=>$index['Farm']['FarmCount'], 'propertySum'=>$index['Farm']['PropertySum']);
								$stcaC++;
							
							}
							else if ($index['Farm']['Parish']=="ST.ELIZABETH"){
								$stel = array('name'=>$index['Farm']['Parish'],'farmCount'=>$index['Farm']['FarmCount'], 'propertySum'=>$index['Farm']['PropertySum']);
								$stelC++;
							
							}
							else if ($index['Farm']['Parish']=="ST.JAMES"){
								$stja = array('name'=>$index['Farm']['Parish'],'farmCount'=>$index['Farm']['FarmCount'], 'propertySum'=>$index['Farm']['PropertySum']);
								$stjaC++;
							}
							else if ($index['Farm']['Parish']=="ST.MARY"){
								$stma = array('name'=>$index['Farm']['Parish'],'farmCount'=>$index['Farm']['FarmCount'], 'propertySum'=>$index['Farm']['PropertySum']);
								$stmaC++;
								
							}
							else if ($index['Farm']['Parish']=="ST.THOMAS"){
								$stth = array('name'=>$index['Farm']['Parish'],'farmCount'=>$index['Farm']['FarmCount'], 'propertySum'=>$index['Farm']['PropertySum']);
								$stthC++;
								
							}
							else if ($index['Farm']['Parish']=="TRELAWNY"){
								$trel = array('name'=>$index['Farm']['Parish'],'farmCount'=>$index['Farm']['FarmCount'], 'propertySum'=>$index['Farm']['PropertySum']);
								$trelC++;
							
							}
							else if ($index['Farm']['Parish']=="WESTMORELAND"){
							$west[$westC]= array('name'=>$index['Farm']['Parish'],'farmCount'=>$index['Farm']['FarmCount'], 'propertySum'=>$index['Farm']['PropertySum']);
							$westC++;
						
							}
							
						
						
						}
						else if ($isext == true){
							if ($index['Farm']['Parish']=="CLARENDON"){
								for ($n=0; $n<$clarC; $n++){
									if ($index['Farm']['Extension'] == $clar[$n]['Name']){
										break;
									}
								}
								if($n >= $clarC) {
									$clar[$clarC]= array('Name'=>$index['Farm']['Extension'],
									'farmCount'=>$index['Farm']['FarmCount'], 'propertySum'=>$index['Farm']['PropertySum']);
									
									$clarC++;
								}
							}
							else if ($index['Farm']['Parish']=="HANOVER"){
								for ($n=0; $n<$hanoC; $n++){
									 if ($index['Farm']['Extension'] == $hano[$n]['Name']){
										break;
									}
								}
								if($n >= $hanoC) {
									$hano[$hanoC]= array('Name'=>$index['Farm']['Extension'],
									'farmCount'=>$index['Farm']['FarmCount'], 'propertySum'=>$index['Farm']['PropertySum']);
									$hanoC++;
								}
							}
							else if ($index['Farm']['Parish']=="KINGSTON"){
								for ($n=0; $n<$kingC; $n++){
									if ($index['Farm']['Extension'] == $king[$n]['Name']){
										break;
									}
								}
								if($n >= $kingC) {
									$king[$kingC]= array('Name'=>$index['Farm']['Extension'],
									'farmCount'=>$index['Farm']['FarmCount'], 'propertySum'=>$index['Farm']['PropertySum']);
									$kingC++;
								}
							}
							else if ($index['Farm']['Parish']=="MANCHESTER"){
								for ($n=0; $n<$mancC; $n++){
									if ($index['Farm']['Extension'] == $manc[$n]['Name']){
										break;
									}
								}
								if($n >= $mancC) {
									$manc[$mancC]= array('Name'=>$index['Farm']['Extension'],
									'farmCount'=>$index['Farm']['FarmCount'], 'propertySum'=>$index['Farm']['PropertySum']);
									$mancC++;
								}
							}
							else if ($index['Farm']['Parish']=="PORTLAND"){
								for ($n=0; $n<$portC; $n++){
									if ($index['Farm']['Extension'] == $port[$n]['Name']){
										break;
									}
								}
								if($n >= $portC) {
									$port[$portC]= array('Name'=>$index['Farm']['Extension'],
									'farmCount'=>$index['Farm']['FarmCount'], 'propertySum'=>$index['Farm']['PropertySum']);
									$portC++;
								}
							}
							else if ($index['Farm']['Parish']=="ST.ANDREW"){
								for ($n=0; $n<$standC; $n++){
									if ($index['Farm']['Extension'] == $stand[$n]['Name']){
										break;
									}
								}
								if($n >= $standC) {
									$stand[$standC]= array('Name'=>$index['Farm']['Extension'],
									'farmCount'=>$index['Farm']['FarmCount'], 'propertySum'=>$index['Farm']['PropertySum']);
									$standC++;
								}
							}
							else if ($index['Farm']['Parish']=="ST.ANN"){
								for ($n=0; $n<$stannC; $n++){
									if ($index['Farm']['Extension'] == $stann[$n]['Name']){
										break;
									}
								}
								if($n >= $stannC) {
									$stann[$stannC]= array('Name'=>$index['Farm']['Extension'],
									'farmCount'=>$index['Farm']['FarmCount'], 'propertySum'=>$index['Farm']['PropertySum']);
									$stannC++;
								}
							}
							else if ($index['Farm']['Parish']=="ST.CATHERINE"){
								for ($n=0; $n<$stcaC; $n++){
									if ($index['Farm']['Extension'] == $stca[$n]['Name']){
										break;
									}
								}
								if($n >= $stcaC) {
									$stca[$stcaC]= array('Name'=>$index['Farm']['Extension'],
									'farmCount'=>$index['Farm']['FarmCount'], 'propertySum'=>$index['Farm']['PropertySum']);
									$stcaC++;
								}
							}
							else if ($index['Farm']['Parish']=="ST.ELIZABETH"){
								for ($n=0; $n<$stelC; $n++){
									if ($index['Farm']['Extension'] == $stel[$n]['Name']){
										break;
									}
								}
								if($n >= $stelC) {
									$stel[$stelC]= array('Name'=>$index['Farm']['Extension'],
									'farmCount'=>$index['Farm']['FarmCount'], 'propertySum'=>$index['Farm']['PropertySum']);
									$stelC++;
								}
							}
							else if ($index['Farm']['Parish']=="ST.JAMES"){
								for ($n=0; $n<$stjaC; $n++){
									if ($index['Farm']['Extension'] == $stja[$n]['Name']){
										break;
									}
								}	
								if($n >= $stjaC) {
									$stja[$stjaC]= array('Name'=>$index['Farm']['Extension'],
									'farmCount'=>$index['Farm']['FarmCount'], 'propertySum'=>$index['Farm']['PropertySum']);
									$stjaC++;
								}
							}
							else if ($index['Farm']['Parish']=="ST.MARY"){
								for ($n=0; $n<$stmaC; $n++){
									if ($index['Farm']['Extension'] == $stma[$n]['Name']){
										break;
									}
								}
								if($n >= $stmaC) {
									$stma[$stmaC]= array('Name'=>$index['Farm']['Extension'],
									'farmCount'=>$index['Farm']['FarmCount'], 'propertySum'=>$index['Farm']['PropertySum']);
									$stmaC++;
								}
							}
							else if ($index['Farm']['Parish']=="ST.THOMAS"){
								for ($n=0; $n<$stthC; $n++){
									if ($index['Farm']['Extension'] == $stth[$n]['Name']){
										break;
									}
								}
								if($n >= $stthC) {
									$stth[$stthC]= array('Name'=>$index['Farm']['Extension'],
									'farmCount'=>$index['Farm']['FarmCount'], 'propertySum'=>$index['Farm']['PropertySum']);
									$stthC++;
								}
							}
							else if ($index['Farm']['Parish']=="TRELAWNY"){
								for ($n=0; $n<$trelC; $n++){
									if ($index['Farm']['Extension'] == $trel[$n]['Name']){
										break;
									}
								}
								if($n >= $trelC) {
									$trel[$trelC]= array('Name'=>$index['Farm']['Extension'],
									'farmCount'=>$index['Farm']['FarmCount'], 'propertySum'=>$index['Farm']['PropertySum']);
									$trelC++;
								}
							}
							else if ($index['Farm']['Parish']=="WESTMORELAND"){
							for ($n=0; $n<$westC; $n++){
								if ($index['Farm']['Extension'] == $west[$n]['Name']){
									break;
								}
							}
							if($n >= $westC) {
								$west[$westC]= array('Name'=>$index['Farm']['Extension'],
								'farmCount'=>$index['Farm']['FarmCount'], 'propertySum'=>$index['Farm']['PropertySum']);
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
				
					if ($ispar == false){
					
						$CLAR = array('name'=>"Clarendon", 'Extensions'=>array('count'=>$clarC,'Extension'=>$clar));
						$HANO = array('name'=>"Hanover",  'Extensions'=>array('count'=>$hanoC,'Extension'=>$hano));
						$KING = array('name'=>"Kingston", 'Extensions'=>array('count'=>$kingC, 'Extension'=>$king));
						$MANC = array('name'=>"Manchester", 'Extensions'=>array('count'=>$mancC, 'Extension'=>$manc));
						$PORT = array('name'=>"Portland", 'Extensions'=>array('count'=>$portC, 'Extension'=>$port));
						$STAND= array('name'=>"St. Andrew", 'Extensions'=>array('count'=>$standC, 'Extension'=>$stand));
						$STANN= array('name'=>"St. Ann", 'Extensions'=>array('count'=>$stannC, 'Extension'=>$stann));
						$STCA = array('name'=>"St. Cathrine", 'Extensions'=>array('count'=>$stcaC, 'Extension'=>$stca));
						$STEL = array('name'=>"St. Elizabeth", 'Extensions'=>array('count'=>$stelC, 'Extension'=>$stel));
						$STJA = array('name'=>"St. James", 'Extensions'=>array('count'=>$stjaC, 'Extension'=>$stja));
						$STMA = array('name'=>"St. Mary", 'Extensions'=>array('count'=>$stmaC, 'Extension'=>$stma));
						$STTH = array('name'=>"St. Thomas", 'Extensions'=>array('count'=>$stthC, 'Extension'=>$stth));
						$TREL = array('name'=>"Trelawny", 'Extensions'=>array('count'=>$trelC, 'Extension'=>$trel));
						$WEST = array('name'=>"Westmoreland", 'Extensions'=>array('count'=>$westC, 'Extension'=>$west));
						
						$parishes = array('0'=>$CLAR,'1'=>$HANO ,'2'=>$KING ,'3'=>$MANC ,'4'=>$PORT, '5'=>$STANN,'6'=>$STAND, '7'=>$STCA, '8'=>$STEL ,'9'=>$STJA ,'10'=>$STMA ,'11'=>$STTH ,'12'=>$TREL ,'13'=>$WEST);
					}
					else {
						$king = array('name'=>"KINGSTON",'farmCount'=>"0", 'propertySum'=>"0");
						$parishes = array('0'=>$clar,'1'=>$hano ,'2'=>$king ,'3'=>$manc ,'4'=>$port, '5'=>$stann,'6'=>$stand, '7'=>$stca, '8'=>$stel ,'9'=>$stja ,'10'=>$stma ,'11'=>$stth ,'12'=>$trel ,'13'=>$west);
					}
					$data = array('0'=>array('Parish'=>$parishes));
					
					if ($ispar == true){
					
						$this->set('parishes',$data);
						//$this->render('districts');
					}
					else if ($isext == true){
					
						$this->set('parishes',$data);
						$this->render('extensions');
					}
					else if ($isdis == true){
					
						$this->set('parishes',$data);
						$this->render('districts');
					}
				}
				
			}
			
			
        }

	}
    
	
?>
