<?php
define("base_url", "http://www.copy.healingcrystals.com/"); 
define("api_path", "hybrid_api/"); 

if(function_exists($_GET['fn'])){
	$_GET['fn']();
}
// Defining function

 
 
 function encryption_decryption($string,$action){
     header('Access-Control-Allow-Origin: *');
     //$string='VUFuK3FqNi9PVnlFQWxTOTgwUWxOdz09';
//$action='d';

	
    $secret_key = 'my_simple_secret_key';
    $secret_iv = 'my_simple_secret_iv';
 
    $output = false;
    $encrypt_method = "AES-256-CBC";
    $key = hash( 'sha256', $secret_key );
    $iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );
 
    if( $action == 'e' ) {
        $output = base64_encode( openssl_encrypt( $string, $encrypt_method, $key, 0, $iv ) );
    }
    else if( $action == 'd' ){
        $output = openssl_decrypt( base64_decode( $string ), $encrypt_method, $key, 0, $iv );
    }
 
    return  $output;
 }
 
 function get_post(){
     header('Access-Control-Allow-Origin: *');
    echo  $_POST['val'];
 }
 
 function slide_text(){
     header('Access-Control-Allow-Origin: *');
	$slideOneArr=array();
	$slideOneArr['status']='Success';
	$slideOneArr['error']="";
	$slideOneArr['data']=array();
	$slide1=array('slide_id'=>1,'slide_date'=>'2018-06-09 08:34:37','slide_text'=>'Welcome to the Healing Crystals Mobile App!',"url"=>base_url.api_path."images/slider/slider_image_1.jpg");
	$slide2=array('slide_id'=>2,'slide_date'=>'2018-06-09 08:33:36','slide_text'=>'Find a Crystal for most Common Conditions.  Browse our Metaphysical Crystal Guides.',"url"=>base_url.api_path."images/slider/slider_image_2.jpg");
//	$slide3=array('slide_id'=>3,'slide_text'=>'Sign up! Save crystals, save searches, & learn about crystals.',"url"=>base_url.api_path."images/slider/slider_image_3.jpg");
//	$slide4=array('slide_id'=>4,'slide_text'=>'Be the first to know! Get updates via newsletters & daily nuggets.',"url"=>base_url.api_path."images/slider/slider_image_4.jpg");
	$slide5=array('slide_id'=>5,'slide_date'=>'2018-06-09 08:33:36','slide_text'=>'You can also shop for crystals inside of this app. We appreciate your business!',"url"=>base_url.api_path."images/slider/slider_image_5.gif");	
	
	array_push($slideOneArr['data'],$slide1);
	array_push($slideOneArr['data'],$slide2);
//	array_push($slideOneArr['data'],$slide3);
//	array_push($slideOneArr['data'],$slide4);
	array_push($slideOneArr['data'],$slide5);
	
	echo  json_encode($slideOneArr);
}

function crystals_information(){
	    $servername = "localhost";
        $username = "copyache_new";
        $password = ",&B.9X1G_yoC";
        $dbname = "copyache_10nov17";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
    $categoryArr=array();
    $categoryArr['status']='Success';
	$categoryArr['error']="";
	$categoryArr['data']=array();
	
	
					$crystals_info='Crystals For Common Conditions';
			  $sql="select distinct st.tag_id, tl.tag_name, st.property_id from stone_tags st, taglist tl, tags_to_products t2p, products p where st.tag_id = tl.tag_id and tl.tag_id = t2p.tag_id and t2p.products_id = p.products_id and p.products_model like '' and property_id = '15' order by tl.sort_order, tl.tag_name"; 
			//$query = $mysqli->real_escape_string($query);
			$result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $cat1=array('category_id'=>$row['tag_id'],'category_name'=>$row['tag_name'],'component'=>'category');
            array_push($categoryArr['data'],$cat1);
        }
    } else {
        echo "0 results";
    }echo '<pre>';
    
    $conn->close(); 
    echo  json_encode($categoryArr);
    	
}














function get_category(){
    header('Access-Control-Allow-Origin: *');
    $categoryArr=array();
	$categoryArr['status']='Success';
	$categoryArr['error']="";
	$categoryArr['data']=array();
	$cat1=array('category_id'=>1,'category_level'=>1,'slider'=>1,'category_name'=>'Crystals for Common Conditions','component'=>'category',"image_url"=>base_url.api_path."images/category/catg_image_1.png");	
	$cat2=array('category_id'=>2,'category_level'=>1,'slider'=>2,'category_name'=>'Store Catalog','component'=>'article',"image_url"=>base_url.api_path."images/category/catg_image_2.jpg");
	$cat3=array('category_id'=>3,'category_level'=>1,'slider'=>3,'category_name'=>'Metaphysical Guide','component'=>'guides',"image_url"=>base_url.api_path."images/category/catg_image_3.jpg");
	$cat4=array('category_id'=>4,'category_level'=>1,'slider'=>4,'category_name'=>'Crystal Formations Guide','component'=>'category',"image_url"=>base_url.api_path."images/category/catg_image_4.jpg");
	$cat5=array('category_id'=>5,'category_level'=>1,'slider'=>5,'category_name'=>'Crystal by Color','component'=>'category',"image_url"=>base_url.api_path."images/category/catg_image_5.jpg");
	$cat6=array('category_id'=>6,'category_level'=>1,'slider'=>6,'category_name'=>'Crystal Safeguards','component'=>'article',"image_url"=>base_url.api_path."images/category/catg_image_6.jpg");
	$cat7=array('category_id'=>7,'category_level'=>1,'slider'=>7,'category_name'=>'Crystal References & Resources','component'=>'category',"image_url"=>base_url.api_path."images/category/catg_image_7.jpg");
	
	array_push($categoryArr['data'],$cat2);
	array_push($categoryArr['data'],$cat3);
	array_push($categoryArr['data'],$cat1);
	array_push($categoryArr['data'],$cat4);
	array_push($categoryArr['data'],$cat5);
	array_push($categoryArr['data'],$cat6);
	array_push($categoryArr['data'],$cat7);
	
	
    echo  json_encode($categoryArr);
   
}


function get_sub_category(){
    header('Access-Control-Allow-Origin: *');
    $servername = "localhost";
        $username = "copyache_new";
        $password = ",&B.9X1G_yoC";
        $dbname = "copyache_10nov17";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
     if (isset($_SERVER['HTTP_ORIGIN'])) {
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
    }
 
    // Access-Control headers are received during OPTIONS requests
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
 
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         
 
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers:        {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
 
        exit(0);
    }
     $postdata = file_get_contents("php://input");
    if (isset($postdata)) {
        $request = json_decode($postdata);
        $category_id = $request->category_id;
		$category_level = $request->category_level;
		$slider = $request->slider;
		$tag_id = $request->tag_id;
		$category_buy = $request->category_buy;
		//Traceability
		$category_name=$request->category_name;
		$location=$request->location;
		$user_app_id=$request->user_app_id;
		$action='Accessed the item '.$category_name;
		$event=1;
		
		
		traceability_api_trigger($user_app_id,$action,$event,$location);
		
		$cat1='';
		$cat2='';
		$cat3='';
		$categoryArr			= array();
		$categoryArr['status']	= 'Success';
		$categoryArr['error']	= "";
		$categoryArr['data']	= array();
			if($slider==1){
				if($category_level==1){
				
					
				
					if($category_id==1){
					    
						$cat1=array('category_id'=>15,'slider'=>1,'category_level'=>2,'category_name'=>'Emotional','component'=>'category');
						$cat2=array('category_id'=>14,'slider'=>1,'category_level'=>2,'category_name'=>'Physical','component'=>'category');
						$cat3=array('category_id'=>16,'slider'=>1,'category_level'=>2,'category_name'=>'Spiritual','component'=>'category');
						array_push($categoryArr['data'],$cat1);
						array_push($categoryArr['data'],$cat2);
						array_push($categoryArr['data'],$cat3);
					
					}
				}
				else if($category_level==2){
					
					//if($category_id==1){
						
						$categoryArr=array();
						$categoryArr['status']='Success';
						$categoryArr['error']="";
						$categoryArr['data']=array();
						
						
						$sql="select distinct st.tag_id, tl.tag_name, st.property_id from stone_tags st, taglist tl, tags_to_products t2p, products p where st.tag_id = tl.tag_id and tl.tag_id = t2p.tag_id and t2p.products_id = p.products_id and p.products_model like '%' and property_id = '".$category_id."' order by tl.sort_order, tl.tag_name";
						
						$result = $conn->query($sql);
						if ($result->num_rows > 0) {
							// output data of each row
							while($row = $result->fetch_assoc()) {
								$cat1=array('category_id'=>$row['tag_id'],
								'slider'=>1,
								'category_level'=>3,
								'category_name'=>$row['tag_name'],
								'component'=>'guides');
								array_push($categoryArr['data'],$cat1);
							}
						}
					 $conn->close(); 	
					//}
					
					
				}
				else if($category_level==3){
					$categoryArr=array();
						$categoryArr['status']='Success';
						$categoryArr['error']="";
						$categoryArr['data']=array();
						
					$sql="select p.products_id,p.products_image,pts.stone_name_id, stone_name,s.detailed_mpd, count(p.products_id) as count from products_to_stones pts, stone_names s, products p where s.stone_name_id = pts.stone_name_id and pts.products_id = p.products_id and p.products_status = 1 and (p.products_model like '%' or p.products_model like 'D%') and pts.stone_name_id in (select st.stone_name_id from stone_tags st, taglist tl where st.tag_id = tl.tag_id and tl.tag_id = '".$category_id."') group by stone_name_id order by stone_name ASC ";
						$result = $conn->query($sql);
						if ($result->num_rows > 0) {
							// output data of each row
							while($row_one = $result->fetch_assoc()) {
						
							
							
							
							
							$listing_sql = "SELECT a2t.*,ad.articles_url, a.articles_id, a.authors_id, a.articles_date_added, ad.articles_name, ad.articles_head_desc_tag, ad.articles_description, au.authors_name, sn.detailed_mpd,sn.stone_name_id, a2t.topics_id, SUBSTRING( ad.articles_name ,1 ,1) AS start_letter FROM (articles a, articles_description ad, articles_to_topics a2t) LEFT JOIN authors au ON a.authors_id = au.authors_id LEFT JOIN stone_names sn ON a.articles_id = sn.summary_mpd WHERE (a.articles_date_available IS NULL OR to_days(a.articles_date_available) <= to_days(now())) AND a.articles_status = '1' AND a.articles_id = a2t.articles_id AND ad.articles_id = a2t.articles_id AND ad.language_id = '1' AND a2t.topics_id = '3' AND sn.detailed_mpd=".$row_one['detailed_mpd']." ORDER BY ad.articles_name limit 50";
        
                    $results = $conn->query($listing_sql);
            		if ($results->num_rows > 0) {
            		    while($rows = $results->fetch_assoc()) {
            		        
            		             //Properties
            		        $stone_name_query = "select stone_name_id from products_to_stones where products_id = '" . $rows['detailed_mpd'] . "' order by stone_name_id ASC limit 1";
$no_of_stones = $conn->query($stone_name_query);
	$stone_name_ids2 = array();
		while($stone_name_ids_new = $no_of_stones->fetch_assoc()){		    
			$stone_name_ids2[] = $stone_name_ids_new['stone_name_id'];
		}
$pro_final_string='';		
if($stone_name_ids2){

	foreach($stone_name_ids2 as $stone_name_ids){
		$prosql_tags = "select distinct st.tag_id, tl.tag_name, st.property_id from stone_tags st, taglist tl where st.tag_id = tl.tag_id and stone_name_id ='".$stone_name_ids."' order by st.property_id, tl.tag_name";
		$prosql_tags = $conn->query($prosql_tags);
		if($prosql_tags->num_rows > 0){
			$pro_array = array();					
			$alternate_stone_name_array = array();
		  	while($array1 = $prosql_tags->fetch_assoc()){
				$tag_display_name = str_replace('-', ' ',$array1['tag_name']);
                if($array1['property_id'] == '22' || $array1['property_id'] == '23' ){
                         if(!in_array($array1['tag_name'],$alternate_stone_name_array) ){
                                  $alternate_stone_name_array[] = $array1['tag_name'];
						 }
                         $pro_array[$array1['property_id']] .=  $array1['tag_name']  ;						
				}
			}
			for($i = 1; $i<= 23; $i++){
				if($i != 22 || $i != 23){
					$pro_array[$i] = substr($pro_array[$i], 0, -2);
				}
				$property_query = "select property_value from stone_properties where property_id = '" . (int)$i . "' and language_id = '1' and stone_name_id='".$stone_name_ids."'";
    			$property = $conn->query($property_query);
				while($array1 = $property->fetch_assoc()){
						
						if($i==5){
						    	$astroIdArray = explode(', ', $array1['property_value']);
                    			$as_sign=='';
                    			if($astroIdArray[0]){
                    			    $as_sign.=$astroIdArray[0];
                    			}
                    				if($astroIdArray[1]){
                    			    $as_sign.=','.$astroIdArray[1];
                    			}
                    			if($astroIdArray[2]){
                    			    $as_sign.=','.$astroIdArray[2];
                    			}
                    			$pro_array[$i] =$as_sign;
						}else{
						    $pro_array[$i] =$array1['property_value'];
						}
				}
			}
			
		
		
			$pro_final_string.='Primary Chakra - '.$pro_array[2].',,';
			$pro_final_string.='Astrological Sign - '.$pro_array[5];
		}	
	}
}else{
    $pro_final_string.='Category - Assortments';
}
//Properties
            		       
            		         $cat1=  array(
            				'category_id' =>$rows['detailed_mpd'],
            				'slider'=>3,
            				'category_level'=>2,
            				'category_properties'=>$pro_final_string,
            				'category_name' => $rows['articles_name'],
            				'category_description' => strip_tags($rows['articles_description']),
            				'category_image' =>$rows['articles_url'],
            				'category_buy' =>trim($rows['stone_name_id']),
            				'component'=>'MPD'
            				
            			);
            			array_push($categoryArr['data'],$cat1);
            		    }
            		}
							
							
							
							}
						}
					 $conn->close(); 	
				}
				else if($category_level==4){
				  
				    $categoryArr=array();
						$categoryArr['status']='Success';
						$categoryArr['error']="";
						$categoryArr['data']=array();
						
						/*$sql="select t2p.products_id from products p, tags_to_products t2p, products_to_stones pts where t2p.products_id = p.products_id and pts.products_id = p.products_id and p.products_status = 1 and (p.products_model like '%' or p.products_model like 'D%') and tag_id =  '".$tag_id."' and stone_name_id =  '".$category_id."'";
						
						$result = $conn->query($sql);
						if ($result->num_rows > 0) {
							// output data of each row
							while($row = $result->fetch_assoc()) {
							    $productsIdsString.=$row['products_id'].',';
							    
							}
						}
						$prolist87= rtrim($productsIdsString,',');
						$sql="select p.products_image, pd.products_name, p.products_model, p.products_id from (products_description pd, products p) where p.products_status = '1' and p.products_id = pd.products_id and pd.language_id = '1' and p.products_id in (".$prolist87.")";
						$result = $conn->query($sql);
						if ($result->num_rows > 0) {
							// output data of each row
							while($row = $result->fetch_assoc()) {
								$cat1=array('category_id'=>$row['products_id'],'slider'=>1,'category_level'=>5,'category_name'=>$row['products_name'],'category_image'=>base_url.'images/'.$row['products_image'],'component'=>'product');
								array_push($categoryArr['data'],$cat1);
							}
						}
					 $conn->close(); 	*/
						
						$stone_name_query = "select stone_name_id from products_to_stones where products_id = '" . $category_id . "' order by stone_name_id ASC";
$no_of_stones = $conn->query($stone_name_query);
	$stone_name_ids2 = array();
		while($stone_name_ids_new = $no_of_stones->fetch_assoc()){		    
			$stone_name_ids2[] = $stone_name_ids_new['stone_name_id'];
		}
		
if($stone_name_ids2){
$pro_final_string='';
	foreach($stone_name_ids2 as $stone_name_ids){
		$prosql_tags = "select distinct st.tag_id, tl.tag_name, st.property_id from stone_tags st, taglist tl where st.tag_id = tl.tag_id and stone_name_id ='".$stone_name_ids."' order by st.property_id, tl.tag_name";
		$prosql_tags = $conn->query($prosql_tags);
		if($prosql_tags->num_rows > 0){
			$pro_array = array();					
			$alternate_stone_name_array = array();
		  	while($array1 = $prosql_tags->fetch_assoc()){
				$tag_display_name = str_replace('-', ' ',$array1['tag_name']);
                if($array1['property_id'] == '22' || $array1['property_id'] == '23' ){
                         if(!in_array($array1['tag_name'],$alternate_stone_name_array) ){
                                  $alternate_stone_name_array[] = $array1['tag_name'];
						 }
                         $pro_array[$array1['property_id']] .=  $array1['tag_name']  ;						
				}
			}
			for($i = 1; $i<= 23; $i++){
				if($i != 22 || $i != 23){
					$pro_array[$i] = substr($pro_array[$i], 0, -2);
				}
				$property_query = "select property_value from stone_properties where property_id = '" . (int)$i . "' and language_id = '1' and stone_name_id='".$stone_name_ids."'";
    			$property = $conn->query($property_query);
				while($array1 = $property->fetch_assoc()){
						$pro_array[$i] =$array1['property_value'];
				}
			}
			$pro_final_string.='Stone Name - '.$pro_array[1].',,';
			$pro_final_string.='Alternate Stone Name #1 - '. $pro_array[22].',,';
			$pro_final_string.='Alternate Stone Name #2 - '. $pro_array[23].',,';
			$pro_final_string.='Primary Chakra - '.$pro_array[2].',,';
			$pro_final_string.='Secondary Chakra - '. $pro_array[12].',,';
			$pro_final_string.='Crystal System - '. $pro_array[3].',,';
			$pro_final_string.='Chemical Composition - '. $pro_array[4].',,';
			$pro_final_string.='Astrological Sign - '.$pro_array[5].',,';
			$pro_final_string.='Numerical Vibration - '. $pro_array[6].',,';
			$pro_final_string.='Hardness - '.$pro_array[7].',,';
			$pro_final_string.='Color - '. preg_replace('/[^(\x20-\x7F)]*/','',$pro_array[8]).',,';
			$pro_final_string.='Location - '. $pro_array[9].',,';
			$pro_final_string.='Rarity - '.$pro_array[10].',,';
			$pro_final_string.='Pronunciation - '. $pro_array[11].',,';
			$pro_final_string.='Mineral Class - '.$pro_array[13].',,';
			$pro_final_string.='Common Conditions (Physical) - '. $pro_array[14].',,';
			 $pro_final_string.='Common Conditions (Emotional) - '. $pro_array[15].',,';
			 $pro_final_string.='Common Conditions (Spiritual) - '. $pro_array[16].',,';
			 $pro_final_string.='Extra Grade - '. $pro_array[17].',,';
			 $pro_final_string.='A Grade - '. $pro_array[18].',,';
			 $pro_final_string.='B Grade - '. $pro_array[19].',,';
			 $pro_final_string.='Affirmation - '. $pro_array[20].',,';
			  $pro_final_string.='Question - '. $pro_array[21];
		}
	}
}else{
    $pro_final_string.='Category - Assortments';
}

//END of properties
						
			       
        
        
         $listing_sql_one = "select a.articles_id, a.articles_date_added, a.articles_date_available, a.authors_id, ad.articles_name, ad.articles_description, ad.articles_url, au.authors_name, a.articles_video,sn.stone_name_id from (articles a, articles_description ad) LEFT JOIN stone_names sn ON a.articles_id = sn.detailed_mpd left join authors au on a.authors_id = au.authors_id where a.articles_id = ".$category_id." and ad.articles_id = a.articles_id and ad.language_id = '1'";
                    $results = $conn->query($listing_sql_one);
            		if ($results->num_rows > 0) {
            		    while($rows = $results->fetch_assoc()) {
            		       
            		         $cat1=  array(
            				'category_id' =>$rows['stone_name_id'],
            				'slider'=>1,
            				'category_level'=>5,
            				'category_name' => $rows['articles_name'],
            				'category_properties'=>$pro_final_string,
            				'category_description' => html_entity_decode(stripslashes($rows['articles_description'])),
            				'category_image' =>$rows['articles_url'],
            				'component'=>'products'
            				
            			);
            			array_push($categoryArr['data'],$cat1);
            		    }
            		}
					
      
						
						
					 	
				}
				else if($category_level==5){
				    $categoryArr=array();
						$categoryArr['status']='Success';
						$categoryArr['error']="";
						$categoryArr['data']=array();
				    
				    	$sql="select distinct p.products_id from products p, products_to_stones pts where pts.products_id = p.products_id and (pts.stone_name_id = ".$category_id.") and p.products_status = 1 and (p.products_model like '%' or p.products_model like 'D%')";
						
						$result = $conn->query($sql);
						if ($result->num_rows > 0) {
							// output data of each row
							while($row = $result->fetch_assoc()) {
							    $productsIdsString.=$row['products_id'].',';
							    
							}
						}
						$prolist87= rtrim($productsIdsString,',');
      
     
      
						
						
					 	$sql="select p.products_image, pd.products_name, p.products_model, p.products_id from (products_description pd, products p) where p.products_status = '1' and p.products_id = pd.products_id and pd.language_id = '1' and p.products_id in (".$prolist87.")";
						$result = $conn->query($sql);
						if ($result->num_rows > 0) {
							// output data of each row
							while($row = $result->fetch_assoc()) {
								$cat1=array('category_id'=>$row['products_id'],
								'slider'=>1,
								'category_level'=>6,
								'category_name'=>$row['products_name'],
								'category_image'=>base_url.'images/'.$row['products_image'],
								'component'=>'product');
								array_push($categoryArr['data'],$cat1);
							}
						}
					 $conn->close(); 
				    
				}
				else if($category_level==6){
					$categoryArr=array();
						$categoryArr['status']='Success';
						$categoryArr['error']="";
						$categoryArr['data']=array();
						
						
						//properties
						
						
						
						$stone_name_query = "select stone_name_id from products_to_stones where products_id = '" . $category_id . "' order by stone_name_id ASC";
$no_of_stones = $conn->query($stone_name_query);
	$stone_name_ids2 = array();
		while($stone_name_ids_new = $no_of_stones->fetch_assoc()){		    
			$stone_name_ids2[] = $stone_name_ids_new['stone_name_id'];
		}
		
if($stone_name_ids2){

	foreach($stone_name_ids2 as $stone_name_ids){
		$prosql_tags = "select distinct st.tag_id, tl.tag_name, st.property_id from stone_tags st, taglist tl where st.tag_id = tl.tag_id and stone_name_id ='".$stone_name_ids."' order by st.property_id, tl.tag_name";
		$prosql_tags = $conn->query($prosql_tags);
		if($prosql_tags->num_rows > 0){
			$pro_array = array();					
			$alternate_stone_name_array = array();
		  	while($array1 = $prosql_tags->fetch_assoc()){
				$tag_display_name = str_replace('-', ' ',$array1['tag_name']);
                if($array1['property_id'] == '22' || $array1['property_id'] == '23' ){
                         if(!in_array($array1['tag_name'],$alternate_stone_name_array) ){
                                  $alternate_stone_name_array[] = $array1['tag_name'];
						 }
                         $pro_array[$array1['property_id']] .=  $array1['tag_name']  ;						
				}
			}
			for($i = 1; $i<= 23; $i++){
				if($i != 22 || $i != 23){
					$pro_array[$i] = substr($pro_array[$i], 0, -2);
				}
				$property_query = "select property_value from stone_properties where property_id = '" . (int)$i . "' and language_id = '1' and stone_name_id='".$stone_name_ids."'";
    			$property = $conn->query($property_query);
				while($array1 = $property->fetch_assoc()){
						$pro_array[$i] =$array1['property_value'];
				}
			}
			$pro_final_array['Stone Name']= $pro_array[1];
			$pro_final_array['Alternate Stone Name #1']= $pro_array[22];
			$pro_final_array['Alternate Stone Name #2']= $pro_array[23];
			$pro_final_array['Primary Chakra']= $pro_array[2];
			$pro_final_array['Secondary Chakra']= $pro_array[12];
			$pro_final_array['Crystal System']= $pro_array[3];
			$pro_final_array['Chemical Composition']= $pro_array[4];
			$pro_final_array['Astrological Sign']= $pro_array[5];
			$pro_final_array['Numerical Vibration']= $pro_array[6];
			$pro_final_array['Hardness']= $pro_array[7];
			$pro_final_array['Color']= preg_replace('/[^(\x20-\x7F)]*/','',$pro_array[8]);
			$pro_final_array['Location']= $pro_array[9];
			$pro_final_array['Rarity']= $pro_array[10];
			$pro_final_array['Pronunciation']= $pro_array[11];
			$pro_final_array['Mineral Class']= $pro_array[13];
			$pro_final_array['Common Conditions (Physical)']= $pro_array[14];
			 $pro_final_array['Common Conditions (Emotional)']= $pro_array[15];
			 $pro_final_array['Common Conditions (Spiritual)']= $pro_array[16];
			 $pro_final_array['Extra Grade']= $pro_array[17];
			 $pro_final_array['A Grade']= $pro_array[18];
			 $pro_final_array['B Grade']= $pro_array[19];
			 $pro_final_array['Affirmation']= $pro_array[20];
			  $pro_final_array['Question']= $pro_array[21];
		}
	}
}
						
						
						
						
						
						
						
						
						//END of properties
						$sql="select * from products p, products_description pd where p.products_id = '".$category_id."' and pd.products_id = p.products_id and pd.language_id = '1'";
					
						$result = $conn->query($sql);
						if ($result->num_rows > 0) {
							// output data of each row
							while($row = $result->fetch_assoc()) {
							   
							    $dd=strip_tags($row['products_description']);
							$string = preg_replace('/[\x00-\x1F\x7F-\xFF]/', '', $dd);
								$cat1=array('category_id'=>$row['products_id'],
								'slider'=>1,
								'category_name'=>$row['products_name'],
								'category_description'=>$string,
							'products_image' => base_url.'images/'.$row['products_image'],
						'products_image_med' => base_url.'images/'.$row['products_image_med'],
						'products_image_lrg' => base_url.'images/'.$row['products_image_lrg'],
						'products_image_sm_1' => base_url.'images/'.$row['products_image_sm_1'],
						'products_image_xl_1' => base_url.'images/'.$row['products_image_xl_1'],
						'products_image_sm_2' => base_url.'images/'.$row['products_image_sm_2'],
						'products_image_xl_2' => base_url.'images/'.$row['products_image_xl_2'],
						'products_image_sm_3' => base_url.'images/'.$row['products_image_sm_3'],
						'products_image_xl_3' => base_url.'images/'.$row['products_image_xl_3'],
						'products_image_sm_4' => base_url.'images/'.$row['products_image_sm_4'],
						'products_image_xl_4' => base_url.'images/'.$row['products_image_xl_4'],
						'products_image_sm_5' => base_url.'images/'.$row['products_image_sm_5'],
						'products_image_xl_5' => base_url.'images/'.$row['products_image_xl_5'],
						'products_image_sm_6' => base_url.'images/'.$row['products_image_sm_6'],
						'products_image_xl_6' => base_url.'images/'.$row['products_image_xl_6'],
						'products_image_alt' =>  base_url.'images/'.$row['products_image_alt'],
						'products_image_alt_1' => base_url.'images/'.$row['products_image_alt_1'],
						'products_image_alt_2' => base_url.'images/'.$row['products_image_alt_2'],
						'products_image_alt_3' => base_url.'images/'.$row['products_image_alt_3'],
						'products_image_alt_4' => base_url.'images/'.$row['products_image_alt_4'],
						'products_image_alt_5' => base_url.'images/'.$row['products_image_alt_5'],
						'products_image_alt_6' => base_url.'images/'.$row['products_image_alt_6'],						
						'products_image_sm_7' => base_url.'images/'.$row['products_image_sm_7'],
						'products_image_sm_8' => base_url.'images/'.$row['products_image_sm_8'],
						'products_image_sm_9' => base_url.'images/'.$row['products_image_sm_9'],
						'products_image_sm_10' => base_url.'images/'.$row['products_image_sm_10'],
						'products_image_xl_7' => base_url.'images/'.$row['products_image_xl_7'],
						'products_image_xl_8' => base_url.'images/'.$row['products_image_xl_8'],
						'products_image_xl_9' => base_url.'images/'.$row['products_image_xl_9'],
						'products_image_xl_10' => base_url.'images/'.$row['products_image_xl_10'],
						'products_image_alt_7' => base_url.'images/'.$row['products_image_alt_7'],
						'products_image_alt_8' => base_url.'images/'.$row['products_image_alt_8'],
						'products_image_alt_9' => base_url.'images/'.$row['products_image_alt_9'],
						'products_image_alt_10' => base_url.'images/'.$row['products_image_alt_10'],
						'products_image_sm_11' => base_url.'images/'.$row['products_image_sm_11'],
						'products_image_xl_11' => base_url.'images/'.$row['products_image_xl_11'],
						'products_image_alt_11' => base_url.'images/'.$row['products_image_alt_11'],
						'products_image_sm_12' => base_url.'images/'.$row['products_image_sm_12'],
						'products_image_xl_12' => base_url.'images/'.$row['products_image_xl_12'],
						'products_image_alt_12' => base_url.'images/'.$row['products_image_alt_12'],
								'category_price'=>'0.00','category_properties'=>$pro_final_array,
								'component'=>'product');
								
								array_push($categoryArr['data'],$cat1);
							}
						}
					 $conn->close(); 	
				}
				
	    
	   
				
	    }//slidert 1
	    
	    //slider 2
	    	if($slider==2){
				if($category_level==1){
				
					$cat1='';
					$cat2='';
					$cat3='';
					 
					$categoryArr			= array();
					$categoryArr['status']	= 'Success';
					$categoryArr['error']	= "";
					$categoryArr['data']	= array();
				$cat1=array('category_id'=>'A','category_description'=>'This feature will be available soon!');
				array_push($categoryArr['data'],$cat1);
					/*if($category_id==2){
						$cat1=array('category_id'=>'A','slider'=>2,'category_level'=>2,'category_name'=>'Assortments','component'=>'products');
						$cat2=array('category_id'=>'C','slider'=>2,'category_level'=>2,'category_name'=>'Cut & Polish Crystals','component'=>'products');
						$cat3=array('category_id'=>'J','slider'=>2,'category_level'=>2,'category_name'=>'Crystal Jewelry','component'=>'products');
						$cat4=array('category_id'=>'N','slider'=>2,'category_level'=>2,'category_name'=>'Natural Crystals & Minerals','component'=>'products');
						$cat5=array('category_id'=>'NQ','slider'=>2,'category_level'=>2,'category_name'=>'Quartz Crystals','component'=>'category');
						$cat6=array('category_id'=>'T','slider'=>2,'category_level'=>2,'category_name'=>'Tumbled Stone & Gemstones','component'=>'products');
						$cat7=array('category_id'=>'V','slider'=>2,'category_level'=>2,'category_name'=>'Other/Accessories','component'=>'products');
						$cat8=array('category_id'=>'O','slider'=>2,'category_level'=>2,'category_name'=>'On Sale Today','component'=>'products');
						array_push($categoryArr['data'],$cat1);
						array_push($categoryArr['data'],$cat2);
						array_push($categoryArr['data'],$cat3);
						array_push($categoryArr['data'],$cat4);
						array_push($categoryArr['data'],$cat5);
						array_push($categoryArr['data'],$cat6);
						array_push($categoryArr['data'],$cat7);
						array_push($categoryArr['data'],$cat8);
					
					}*/
				}
				else if($category_level==2){
				
					$cat1='';
					$cat2='';
					$cat3='';
					 
					$categoryArr			= array();
					$categoryArr['status']	= 'Success';
					$categoryArr['error']	= "";
					$categoryArr['data']	= array();
				
					if($category_id=='A'){
					    $productsIdsString='';
					    $sql = "select distinct p.products_id from products p where p.products_id and p.products_status = 1 and (p.products_model like '".$category_id."%' or p.products_model like 'DA%')";
					    $result = $conn->query($sql);
					    if ($result->num_rows > 0) {
							while($row = $result->fetch_assoc()) {
							    $productsIdsString.=$row['products_id'].',';
							    
							}
						}
					    $prolist87= rtrim($productsIdsString,',');
					    
					    $sql="select p.products_image, pd.products_name, p.products_model, p.products_id from (products_description pd, products p) where p.products_status = '1' and p.products_id = pd.products_id and pd.language_id = '1' and p.products_id in (".$prolist87.")";
						$result = $conn->query($sql);
						if ($result->num_rows > 0) {
							// output data of each row
							while($row = $result->fetch_assoc()) {
								$cat1=array('category_id'=>$row['products_id'],'slider'=>2,'category_level'=>3,'category_name'=>$row['products_name'],'category_image'=>base_url.'images/'.$row['products_image'],'component'=>'product');
								array_push($categoryArr['data'],$cat1);
							}
						}
					 $conn->close(); 
						
						
						
					
					}
					else if($category_id=='C'){
					    
					    $productsIdsString='';
					    $sql = "select distinct p.products_id from products p where p.products_id and p.products_status = 1 and (p.products_model like 'DAM%' or p.products_model like 'DAC%' or p.products_model like 'AC%' or p.products_model like 'AM%')";
					    
					    $result = $conn->query($sql);
					    if ($result->num_rows > 0) {
							while($row = $result->fetch_assoc()) {
							    $productsIdsString.=$row['products_id'].',';
							    
							}
						}
					    $prolist87= rtrim($productsIdsString,',');
					    
					    $sql="select p.products_image, pd.products_name, p.products_model, p.products_id from (products_description pd, products p) where p.products_status = '1' and p.products_id = pd.products_id and pd.language_id = '1' and p.products_id in (".$prolist87.")";
						$result = $conn->query($sql);
						if ($result->num_rows > 0) {
							// output data of each row
							while($row = $result->fetch_assoc()) {
								$cat1=array('category_id'=>$row['products_id'],'slider'=>2,'category_level'=>3,'category_name'=>$row['products_name'],'category_image'=>base_url.'images/'.$row['products_image'],'component'=>'product');
								array_push($categoryArr['data'],$cat1);
							}
						}
					 $conn->close(); 
					    
					}
					
						else if($category_id=='J'){
					    
					    $productsIdsString='';
					    $sql = "select distinct p.products_id from products p where p.products_id and p.products_status = 1 and (p.products_model like 'DAJ%' or p.products_model like 'AJ%')";
					    
					    $result = $conn->query($sql);
					    if ($result->num_rows > 0) {
							while($row = $result->fetch_assoc()) {
							    $productsIdsString.=$row['products_id'].',';
							    
							}
						}
					    $prolist87= rtrim($productsIdsString,',');
					    
					    $sql="select p.products_image, pd.products_name, p.products_model, p.products_id from (products_description pd, products p) where p.products_status = '1' and p.products_id = pd.products_id and pd.language_id = '1' and p.products_id in (".$prolist87.")";
						$result = $conn->query($sql);
						if ($result->num_rows > 0) {
							// output data of each row
							while($row = $result->fetch_assoc()) {
								$cat1=array('category_id'=>$row['products_id'],'slider'=>2,'category_level'=>3,'category_name'=>$row['products_name'],'category_image'=>base_url.'images/'.$row['products_image'],'component'=>'product');
								array_push($categoryArr['data'],$cat1);
							}
						}
					 $conn->close(); 
					    
					}
				else if($category_id=='N'){
					    
					    $productsIdsString='';
					    $sql = "select distinct p.products_id from products p where p.products_id and p.products_status = 1 and (p.products_model like 'DAN%' or p.products_model like 'AN%')";
					    
					    $result = $conn->query($sql);
					    if ($result->num_rows > 0) {
							while($row = $result->fetch_assoc()) {
							    $productsIdsString.=$row['products_id'].',';
							    
							}
						}
					    $prolist87= rtrim($productsIdsString,',');
					    
					    $sql="select p.products_image, pd.products_name, p.products_model, p.products_id from (products_description pd, products p) where p.products_status = '1' and p.products_id = pd.products_id and pd.language_id = '1' and p.products_id in (".$prolist87.")";
						$result = $conn->query($sql);
						if ($result->num_rows > 0) {
							// output data of each row
							while($row = $result->fetch_assoc()) {
								$cat1=array('category_id'=>$row['products_id'],'slider'=>2,'category_level'=>3,'category_name'=>$row['products_name'],'category_image'=>base_url.'images/'.$row['products_image'],'component'=>'product');
								array_push($categoryArr['data'],$cat1);
							}
						}
					 $conn->close(); 
					}
						else if($category_id=='T'){
					    
					    $productsIdsString='';
					    $sql = "select distinct p.products_id from products p where p.products_id and p.products_status = 1 and (p.products_model like 'DAT%' or p.products_model like 'AT%')";
					    
					    $result = $conn->query($sql);
					    if ($result->num_rows > 0) {
							while($row = $result->fetch_assoc()) {
							    $productsIdsString.=$row['products_id'].',';
							    
							}
						}
					    $prolist87= rtrim($productsIdsString,',');
					    
					    $sql="select p.products_image, pd.products_name, p.products_model, p.products_id from (products_description pd, products p) where p.products_status = '1' and p.products_id = pd.products_id and pd.language_id = '1' and p.products_id in (".$prolist87.")";
						$result = $conn->query($sql);
						if ($result->num_rows > 0) {
							// output data of each row
							while($row = $result->fetch_assoc()) {
								$cat1=array('category_id'=>$row['products_id'],'slider'=>2,'category_level'=>3,'category_name'=>$row['products_name'],'category_image'=>base_url.'images/'.$row['products_image'],'component'=>'product');
								array_push($categoryArr['data'],$cat1);
							}
						}
					 $conn->close(); 
					}
					
					else if($category_id=='V'){
					    
					    $productsIdsString='';
					    $sql = "select p.products_id from products p where p.products_id and p.products_status = 1 and (p.products_model like 'V%' or p.products_model like 'V%' or (p.products_id in (select products_id from products_specific_property where property_name = 'Category' and property_value = 'Other / Accessories')))";
					    
					    $result = $conn->query($sql);
					    if ($result->num_rows > 0) {
							while($row = $result->fetch_assoc()) {
							    $productsIdsString.=$row['products_id'].',';
							    
							}
						}
					    $prolist87= rtrim($productsIdsString,',');
					    
					    $sql="select p.products_image, pd.products_name, p.products_model, p.products_id from (products_description pd, products p) where p.products_status = '1' and p.products_id = pd.products_id and pd.language_id = '1' and p.products_id in (".$prolist87.")";
						$results = $conn->query($sql);
						if ($results->num_rows > 0) {
							// output data of each row
							while($rows = $results->fetch_assoc()) {//print_r($rows );
								$cat1=array('category_id'=>$rows['products_id'],'slider'=>2,'category_level'=>3,'category_name'=>htmlentities($rows['products_name']),'category_image'=>base_url.'images/'.$rows['products_image'],'component'=>'product');
								array_push($categoryArr['data'],$cat1);
								
							}
						}
					}
					else if($category_id=='O'){
					    
					    $productsIdsString='';
					    $sql = "select distinct p.products_id, pa.products_attributes_special_price from products p, products_attributes pa where p.products_id = pa.products_id and p.products_status = 1 and pa.products_attributes_special_price > 0 and (pa.special_end_date > now() or pa.special_end_date = '0000-00-00 00:00:00') and pa.special_start_date < now() and pa.special_start_date != '0000-00-00 00:00:00' and (p.products_model like 'DA%' or p.products_model like 'A%')";
					    
					    $result = $conn->query($sql);
					    if ($result->num_rows > 0) {
							while($row = $result->fetch_assoc()) {
							    $productsIdsString.=$row['products_id'].',';
							    
							}
						}
					    $prolist87= rtrim($productsIdsString,',');
					    
					    $sql="select p.products_image, pd.products_name, p.products_model, p.products_id from (products_description pd, products p) where p.products_status = '1' and p.products_id = pd.products_id and pd.language_id = '1' and p.products_id in (".$prolist87.")";
						$result = $conn->query($sql);
						if ($result->num_rows > 0) {
							// output data of each row
							while($row = $result->fetch_assoc()) {
								$cat1=array('category_id'=>$row['products_id'],'slider'=>2,'category_level'=>3,'category_name'=>$row['products_name'],'category_image'=>base_url.'images/'.$row['products_image'],'component'=>'product');
								array_push($categoryArr['data'],$cat1);
							}
						}
					 $conn->close(); 
					}
				/*if($category_id=='NQ'){
					    $productsIdsString='';
					    $sql = "select psp.property_value, p.products_id, p.products_image, pd.products_name from products p, products_description pd, products_specific_property psp, products_to_stones p2st where psp.products_id = p.products_id and pd.products_id = p.products_id and pd.language_id = '1' and lower(psp.property_name) = 'shape' and p.products_status = 1 and (p.products_model like 'N%' or p.products_model like 'DN%') and p2st.products_id = p.products_id and p2st.stone_name_id = '203' order by property_value ASC";
					    $result = $conn->query($sql);
					    if ($result->num_rows > 0) {
							while($row = $result->fetch_assoc()) {
							    $productsIdsString.=$row['products_id'].',';
							    
							}
						}
					    $prolist87= rtrim($productsIdsString,',');
					    
					    $sql="select p.products_image, pd.products_name, p.products_model, p.products_id from (products_description pd, products p) where p.products_status = '1' and p.products_id = pd.products_id and pd.language_id = '1' and p.products_id in (".$prolist87.")";
						$result = $conn->query($sql);
						if ($result->num_rows > 0) {
							// output data of each row
							while($row = $result->fetch_assoc()) {
								$cat1=array('category_id'=>$row['products_id'],'slider'=>2,'category_level'=>3,'category_name'=>$row['products_name'],'category_image'=>base_url.'images_100/'.$row['products_image'],'component'=>'product');
								array_push($categoryArr['data'],$cat1);
							}
						}
					 $conn->close(); 
						
						
						
					
					}*/	
					if($category_id=='NQ'){
					    if($category_level==2){
    					    $sql = "select psp.property_value, p.products_id, p.products_image, pd.products_name from products p, products_description pd, products_specific_property psp, products_to_stones p2st where psp.products_id = p.products_id and pd.products_id = p.products_id and pd.language_id = '1' and lower(psp.property_name) = 'shape' and p.products_status = 1 and (p.products_model like 'N%' or p.products_model like 'DN%') and p2st.products_id = p.products_id and p2st.stone_name_id = '203' group by psp.property_value order by property_value ASC";
    					    $result = $conn->query($sql);
    					    if ($result->num_rows > 0) {
    						    while($rows = $result->fetch_assoc()) {
    						        $cat1=array('category_id'=>$rows['property_value'],'slider'=>2,'category_level'=>3,'category_name'=>$rows['property_value'],'category_image'=>base_url.'images_100/'.$rows['products_image'],'component'=>'products');
    								array_push($categoryArr['data'],$cat1);
    						    }
    					    }
					    }
					    
					}
				}elseif($category_level==3){
				    	$cat1='';
					$cat2='';
					$cat3='';
					 
					$categoryArr			= array();
					$categoryArr['status']	= 'Success';
					$categoryArr['error']	= "";
					$categoryArr['data']	= array();
					       $sql = "select psp.property_value, p.products_id, p.products_image, pd.products_name from products p, products_description pd, products_specific_property psp, products_to_stones p2st where psp.products_id = p.products_id and pd.products_id = p.products_id and pd.language_id = '1' and lower(psp.property_name) = 'shape' and p.products_status = 1 and (p.products_model like 'N%' or p.products_model like 'DN%') and p2st.products_id = p.products_id and p2st.stone_name_id = '203'and psp.property_value = '".$category_id."' order by property_value ASC";
					        $result = $conn->query($sql);
					    if ($result->num_rows > 0) {
							while($row = $result->fetch_assoc()) {
							    $productsIdsString.=$row['products_id'].',';
							    
							}
						}
					     $prolist87= rtrim($productsIdsString,',');
					    
    					  
    					  $sql="select psp.property_value, p.products_id, p.products_image, pd.products_name from products p, products_description pd, products_specific_property psp, products_to_stones p2st where psp.products_id = p.products_id and pd.products_id = p.products_id and pd.language_id = '1' and lower(psp.property_name) = 'shape' and p.products_status = 1 and (p.products_model like 'N%' or p.products_model like 'DN%') and p2st.products_id = p.products_id and p2st.stone_name_id = '203'and p.products_id in (".$prolist87.") group by psp.property_value order by psp.property_value ASC";
    					    $result = $conn->query($sql);
    					    if ($result->num_rows > 0) {
    						    while($rows = $result->fetch_assoc()) {
    						        $cat1=array('category_id'=>$rows['products_id'],'slider'=>2,'category_level'=>4,'category_name'=>$rows['property_value'],'category_image'=>base_url.'images_100/'.$rows['products_image'],'component'=>'product');
    								array_push($categoryArr['data'],$cat1);
    						    }
    					    }
					    }
					    
					    else if($category_level==4){
				    
					$categoryArr=array();
						$categoryArr['status']='Success';
						$categoryArr['error']="";
						$categoryArr['data']=array();
						
						
						//properties
						
						
						
						$stone_name_query = "select stone_name_id from products_to_stones where products_id = '" . $category_id . "' order by stone_name_id ASC";
$no_of_stones = $conn->query($stone_name_query);
	$stone_name_ids2 = array();
		while($stone_name_ids_new = $no_of_stones->fetch_assoc()){		    
			$stone_name_ids2[] = $stone_name_ids_new['stone_name_id'];
		}
		
if($stone_name_ids2){

	foreach($stone_name_ids2 as $stone_name_ids){
		$prosql_tags = "select distinct st.tag_id, tl.tag_name, st.property_id from stone_tags st, taglist tl where st.tag_id = tl.tag_id and stone_name_id ='".$stone_name_ids."' order by st.property_id, tl.tag_name";
		$prosql_tags = $conn->query($prosql_tags);
		if($prosql_tags->num_rows > 0){
			$pro_array = array();					
			$alternate_stone_name_array = array();
		  	while($array1 = $prosql_tags->fetch_assoc()){
				$tag_display_name = str_replace('-', ' ',$array1['tag_name']);
                if($array1['property_id'] == '22' || $array1['property_id'] == '23' ){
                         if(!in_array($array1['tag_name'],$alternate_stone_name_array) ){
                                  $alternate_stone_name_array[] = $array1['tag_name'];
						 }
                         $pro_array[$array1['property_id']] .=  $array1['tag_name']  ;						
				}
			}
			for($i = 1; $i<= 23; $i++){
				if($i != 22 || $i != 23){
					$pro_array[$i] = substr($pro_array[$i], 0, -2);
				}
				$property_query = "select property_value from stone_properties where property_id = '" . (int)$i . "' and language_id = '1' and stone_name_id='".$stone_name_ids."'";
    			$property = $conn->query($property_query);
				while($array1 = $property->fetch_assoc()){
						$pro_array[$i] =$array1['property_value'];
				}
			}
			$pro_final_array['Stone Name']= $pro_array[1];
			$pro_final_array['Alternate Stone Name #1']= $pro_array[22];
			$pro_final_array['Alternate Stone Name #2']= $pro_array[23];
			$pro_final_array['Primary Chakra']= $pro_array[2];
			$pro_final_array['Secondary Chakra']= $pro_array[12];
			$pro_final_array['Crystal System']= $pro_array[3];
			$pro_final_array['Chemical Composition']= $pro_array[4];
			$pro_final_array['Astrological Sign']= $pro_array[5];
			$pro_final_array['Numerical Vibration']= $pro_array[6];
			$pro_final_array['Hardness']= $pro_array[7];
			$pro_final_array['Color']= preg_replace('/[^(\x20-\x7F)]*/','',$pro_array[8]);
			$pro_final_array['Location']= $pro_array[9];
			$pro_final_array['Rarity']= $pro_array[10];
			$pro_final_array['Pronunciation']= $pro_array[11];
			$pro_final_array['Mineral Class']= $pro_array[13];
			$pro_final_array['Common Conditions (Physical)']= $pro_array[14];
			 $pro_final_array['Common Conditions (Emotional)']= $pro_array[15];
			 $pro_final_array['Common Conditions (Spiritual)']= $pro_array[16];
			 $pro_final_array['Extra Grade']= $pro_array[17];
			 $pro_final_array['A Grade']= $pro_array[18];
			 $pro_final_array['B Grade']= $pro_array[19];
			 $pro_final_array['Affirmation']= $pro_array[20];
			  $pro_final_array['Question']= $pro_array[21];
		}
	}
}else{
    $pro_final_array['Category']= 'Assortments';
}
						
						
						
						
						
						
						
						
						//END of properties
						$sql="select * from products p, products_description pd where p.products_id = '".$category_id."' and pd.products_id = p.products_id and pd.language_id = '1'";
					
						$result = $conn->query($sql);
						if ($result->num_rows > 0) {
							// output data of each row
							while($row = $result->fetch_assoc()) {
							   
							    $dd=strip_tags($row['products_description']);
							$string = preg_replace('/[\x00-\x1F\x7F-\xFF]/', '', $dd);
								$cat1=array('category_id'=>$row['products_id'],
								'slider'=>1,
								'category_name'=>$row['products_name'],
								'category_description'=>$string,
								'products_image' => base_url.'images_100/'.$row['products_image'],
						'products_image_med' => base_url.'images_100/'.$row['products_image_med'],
						'products_image_lrg' => base_url.'images_100/'.$row['products_image_lrg'],
						'products_image_sm_1' => base_url.'images_100/'.$row['products_image_sm_1'],
						'products_image_xl_1' => base_url.'images_100/'.$row['products_image_xl_1'],
						'products_image_sm_2' => base_url.'images_100/'.$row['products_image_sm_2'],
						'products_image_xl_2' => base_url.'images_100/'.$row['products_image_xl_2'],
						'products_image_sm_3' => base_url.'images_100/'.$row['products_image_sm_3'],
						'products_image_xl_3' => base_url.'images_100/'.$row['products_image_xl_3'],
						'products_image_sm_4' => base_url.'images_100/'.$row['products_image_sm_4'],
						'products_image_xl_4' => base_url.'images_100/'.$row['products_image_xl_4'],
						'products_image_sm_5' => base_url.'images_100/'.$row['products_image_sm_5'],
						'products_image_xl_5' => base_url.'images_100/'.$row['products_image_xl_5'],
						'products_image_sm_6' => base_url.'images_100/'.$row['products_image_sm_6'],
						'products_image_xl_6' => base_url.'images_100/'.$row['products_image_xl_6'],
						'products_image_alt' =>  base_url.'images_100/'.$row['products_image_alt'],
						'products_image_alt_1' => base_url.'images_100/'.$row['products_image_alt_1'],
						'products_image_alt_2' => base_url.'images_100/'.$row['products_image_alt_2'],
						'products_image_alt_3' => base_url.'images_100/'.$row['products_image_alt_3'],
						'products_image_alt_4' => base_url.'images_100/'.$row['products_image_alt_4'],
						'products_image_alt_5' => base_url.'images_100/'.$row['products_image_alt_5'],
						'products_image_alt_6' => base_url.'images_100/'.$row['products_image_alt_6'],						
						'products_image_sm_7' => base_url.'images_100/'.$row['products_image_sm_7'],
						'products_image_sm_8' => base_url.'images_100/'.$row['products_image_sm_8'],
						'products_image_sm_9' => base_url.'images_100/'.$row['products_image_sm_9'],
						'products_image_sm_10' => base_url.'images_100/'.$row['products_image_sm_10'],
						'products_image_xl_7' => base_url.'images_100/'.$row['products_image_xl_7'],
						'products_image_xl_8' => base_url.'images_100/'.$row['products_image_xl_8'],
						'products_image_xl_9' => base_url.'images_100/'.$row['products_image_xl_9'],
						'products_image_xl_10' => base_url.'images_100/'.$row['products_image_xl_10'],
						'products_image_alt_7' => base_url.'images_100/'.$row['products_image_alt_7'],
						'products_image_alt_8' => base_url.'images_100/'.$row['products_image_alt_8'],
						'products_image_alt_9' => base_url.'images_100/'.$row['products_image_alt_9'],
						'products_image_alt_10' => base_url.'images_100/'.$row['products_image_alt_10'],
						'products_image_sm_11' => base_url.'images_100/'.$row['products_image_sm_11'],
						'products_image_xl_11' => base_url.'images_100/'.$row['products_image_xl_11'],
						'products_image_alt_11' => base_url.'images_100/'.$row['products_image_alt_11'],
						'products_image_sm_12' => base_url.'images_100/'.$row['products_image_sm_12'],
						'products_image_xl_12' => base_url.'images_100/'.$row['products_image_xl_12'],
						'products_image_alt_12' => base_url.'images_100/'.$row['products_image_alt_12'],
								'category_price'=>'0.00','category_properties'=>$pro_final_array,
								'component'=>'product');
								
								array_push($categoryArr['data'],$cat1);
							}
						}
					 $conn->close(); 	
				
				    
				}
			}//END slider2
			
			//slider 3
			if($slider==3){
			    if($category_level==1){
			      $listing_sql = "SELECT a2t.*,ad.articles_url, a.articles_id, a.authors_id, a.articles_date_added, ad.articles_name, ad.articles_head_desc_tag, ad.articles_description, au.authors_name, sn.detailed_mpd,sn.stone_name_id, a2t.topics_id, SUBSTRING( ad.articles_name ,1 ,1) AS start_letter FROM (articles a, articles_description ad, articles_to_topics a2t) LEFT JOIN authors au ON a.authors_id = au.authors_id LEFT JOIN stone_names sn ON a.articles_id = sn.summary_mpd WHERE (a.articles_date_available IS NULL OR to_days(a.articles_date_available) <= to_days(now())) AND a.articles_status = '1' AND a.articles_id = a2t.articles_id AND ad.articles_id = a2t.articles_id AND ad.language_id = '1' AND a2t.topics_id = '3' ORDER BY ad.articles_name limit 50";
        
                    $result = $conn->query($listing_sql);
            		if ($result->num_rows > 0) {
            		    while($rows = $result->fetch_assoc()) {
            		        
            		        //Properties
            		        $stone_name_query = "select stone_name_id from products_to_stones where products_id = '" . $rows['detailed_mpd'] . "' order by stone_name_id ASC";
$no_of_stones = $conn->query($stone_name_query);
	$stone_name_ids2 = array();
		while($stone_name_ids_new = $no_of_stones->fetch_assoc()){		    
			$stone_name_ids2[] = $stone_name_ids_new['stone_name_id'];
		}
		
if($stone_name_ids2){
$pro_final_string='';
	foreach($stone_name_ids2 as $stone_name_ids){
		$prosql_tags = "select distinct st.tag_id, tl.tag_name, st.property_id from stone_tags st, taglist tl where st.tag_id = tl.tag_id and stone_name_id ='".$stone_name_ids."' order by st.property_id, tl.tag_name";
		$prosql_tags = $conn->query($prosql_tags);
		if($prosql_tags->num_rows > 0){
			$pro_array = array();					
			$alternate_stone_name_array = array();
		  	while($array1 = $prosql_tags->fetch_assoc()){
				$tag_display_name = str_replace('-', ' ',$array1['tag_name']);
                if($array1['property_id'] == '22' || $array1['property_id'] == '23' ){
                         if(!in_array($array1['tag_name'],$alternate_stone_name_array) ){
                                  $alternate_stone_name_array[] = $array1['tag_name'];
						 }
                         $pro_array[$array1['property_id']] .=  $array1['tag_name']  ;						
				}
			}
			for($i = 1; $i<= 23; $i++){
				if($i != 22 || $i != 23){
					$pro_array[$i] = substr($pro_array[$i], 0, -2);
				}
				$property_query = "select property_value from stone_properties where property_id = '" . (int)$i . "' and language_id = '1' and stone_name_id='".$stone_name_ids."'";
    			$property = $conn->query($property_query);
				while($array1 = $property->fetch_assoc()){
				    $as_sign='';
				    $pm_ck='';
						if($i==5){
						    	$astroIdArray = explode(', ', $array1['property_value']);
                    			
                    			if($astroIdArray[0]){
                    			    $as_sign.=$astroIdArray[0];
                    			}
                    				if($astroIdArray[1]){
                    			    $as_sign.=','.$astroIdArray[1];
                    			}
                    			if($astroIdArray[2]){
                    			    $as_sign.=','.$astroIdArray[2];
                    			}
                    			$pro_array[$i] =$as_sign;
						}
						elseif($i==2){
						    	$astroIdArray = explode(', ', $array1['property_value']);
                    			
                    			if($astroIdArray[0]){
                    			    $pm_ck.=$astroIdArray[0];
                    			}
                    				if($astroIdArray[1]){
                    			    $pm_ck.=','.$astroIdArray[1];
                    			}
                    			if($astroIdArray[2]){
                    			    $pm_ck.=','.$astroIdArray[2];
                    			}
                    			$pro_array[$i] =$pm_ck;
						}
						
						else{
						    $pro_array[$i] =$array1['property_value'];
						}
				}
			}
			$pro_final_string.='Primary Chakra - '.$pro_array[2].',,';
			$pro_final_string.='Astrological Sign - '.$pro_array[5];
		}
	}
}else{
    //$pro_final_string.='Category - Assortments';
}
//Properties
            		       
            		         $cat1=  array(
            				'category_id' =>$rows['detailed_mpd'],
            				'slider'=>3,
            				'category_level'=>2,
            				'category_properties'=>$pro_final_string,
            				'category_name' => $rows['articles_name'],
            				'category_description' => strip_tags($rows['articles_description']),
            				'category_image' =>$rows['articles_url'],
            				'category_buy' =>trim($rows['stone_name_id']),
            				'component'=>'MPD'
            				
            			);
            			array_push($categoryArr['data'],$cat1);
            		    }
            		}
			    }
			    else if($category_level==2){
			        
			        		$stone_name_query = "select stone_name_id from products_to_stones where products_id = '" . $category_id . "' order by stone_name_id ASC";
$no_of_stones = $conn->query($stone_name_query);
	$stone_name_ids2 = array();
		while($stone_name_ids_new = $no_of_stones->fetch_assoc()){		    
			$stone_name_ids2[] = $stone_name_ids_new['stone_name_id'];
		}
		
if($stone_name_ids2){

	foreach($stone_name_ids2 as $stone_name_ids){
		$prosql_tags = "select distinct st.tag_id, tl.tag_name, st.property_id from stone_tags st, taglist tl where st.tag_id = tl.tag_id and stone_name_id ='".$stone_name_ids."' order by st.property_id, tl.tag_name";
		$prosql_tags = $conn->query($prosql_tags);
		if($prosql_tags->num_rows > 0){
			$pro_array = array();					
			$alternate_stone_name_array = array();
		  	while($array1 = $prosql_tags->fetch_assoc()){
				$tag_display_name = str_replace('-', ' ',$array1['tag_name']);
                if($array1['property_id'] == '22' || $array1['property_id'] == '23' ){
                         if(!in_array($array1['tag_name'],$alternate_stone_name_array) ){
                                  $alternate_stone_name_array[] = $array1['tag_name'];
						 }
                         $pro_array[$array1['property_id']] .=  $array1['tag_name']  ;						
				}
			}
			for($i = 1; $i<= 23; $i++){
				if($i != 22 || $i != 23){
					$pro_array[$i] = substr($pro_array[$i], 0, -2);
				}
				$property_query = "select property_value from stone_properties where property_id = '" . (int)$i . "' and language_id = '1' and stone_name_id='".$stone_name_ids."'";
    			$property = $conn->query($property_query);
				while($array1 = $property->fetch_assoc()){
						$pro_array[$i] =$array1['property_value'];
				}
			}
			$pro_final_string.='Stone Name - '.$pro_array[1].',,';
			$pro_final_string.='Alternate Stone Name #1 - '. $pro_array[22].',,';
			$pro_final_string.='Alternate Stone Name #2 - '. $pro_array[23].',,';
			$pro_final_string.='Primary Chakra - '.$pro_array[2].',,';
			$pro_final_string.='Secondary Chakra - '. $pro_array[12].',,';
			$pro_final_string.='Crystal System - '. $pro_array[3].',,';
			$pro_final_string.='Chemical Composition - '. $pro_array[4].',,';
			$pro_final_string.='Astrological Sign - '.$pro_array[5].',,';
			$pro_final_string.='Numerical Vibration - '. $pro_array[6].',,';
			$pro_final_string.='Hardness - '.$pro_array[7].',,';
			$pro_final_string.='Color - '. preg_replace('/[^(\x20-\x7F)]*/','',$pro_array[8]).',,';
			$pro_final_string.='Location - '. $pro_array[9].',,';
			$pro_final_string.='Rarity - '.$pro_array[10].',,';
			$pro_final_string.='Pronunciation - '. $pro_array[11].',,';
			$pro_final_string.='Mineral Class - '.$pro_array[13].',';
			$pro_final_string.='Common Conditions (Physical) - '. $pro_array[14].',,';
			 $pro_final_string.='Common Conditions (Emotional) - '. $pro_array[15].',,';
			 $pro_final_string.='Common Conditions (Spiritual) - '. $pro_array[16].',,';
			 $pro_final_string.='Extra Grade - '. $pro_array[17].',,';
			 $pro_final_string.='A Grade - '. $pro_array[18].',,';
			 $pro_final_string.='B Grade - '. $pro_array[19].',,';
			 $pro_final_string.='Affirmation - '. $pro_array[20].',,';
			  $pro_final_string.='Question - '. $pro_array[21];
		}
	}
}else{
    $pro_final_string.='Category - Assortments';
}
//END of properties
						
			        $listing_sql = "select a.articles_id, a.articles_date_added, a.articles_date_available, a.authors_id, ad.articles_name, ad.articles_description, ad.articles_url, au.authors_name, a.articles_video from (articles a, articles_description ad) left join authors au on a.authors_id = au.authors_id where a.articles_id = '1324' and ad.articles_id = a.articles_id and ad.language_id = '1'";
        $listing_sql_one = "select a.articles_id, a.articles_date_added, a.articles_date_available, a.authors_id, ad.articles_name, ad.articles_description, ad.articles_url, au.authors_name, a.articles_video from (articles a, articles_description ad) left join authors au on a.authors_id = au.authors_id where a.articles_id = ".$category_id." and ad.articles_id = a.articles_id and ad.language_id = '1'";
                    $results = $conn->query($listing_sql_one);
            		if ($results->num_rows > 0) {
            		    while($rows = $results->fetch_assoc()) {
            		       
            		         $cat1=  array(
            				'category_id' =>$rows['articles_id'],
            				'slider'=>3,
            				'category_level'=>2,
            				'category_buy' =>$category_id,
            				'category_name' => $rows['articles_name'],
            				'category_properties'=>$pro_final_string,
            				'category_description' => html_entity_decode(stripslashes($rows['articles_description'])),
            				'category_image' =>$rows['articles_url'],
            				'component'=>'article'
            				
            			);
            			array_push($categoryArr['data'],$cat1);
            		    }
            		}
			        
			    }
			}//END Slider 3
			if($slider==4){
			    
			    if($category_level==1){
			      $listing_sql = "select distinct psp.property_value from products p, products_specific_property psp where psp.products_id = p.products_id and psp.property_name='Shape' and p.products_model like '%' order by property_value";
        
                    $result = $conn->query($listing_sql);
            		if ($result->num_rows > 0) {
            		    while($rows = $result->fetch_assoc()) {
            		       
            		         $cat1=  array(
            				'category_id' =>$rows['property_value'],
            				'slider'=>4,
            				'category_level'=>2,
            				'category_name' => $rows['property_value'],
            				'category_description' => '',
            				'category_image' =>'',
            				'component'=>'products'
            				
            			);
            			array_push($categoryArr['data'],$cat1);
            		    }
            		}
			    }
			     elseif($category_level==2){
			        
			        $sql = "select distinct p.products_id from products p, products_specific_property psp where psp.products_id = p.products_id and lower(psp.property_name) = 'shape' and psp.property_value = '".$category_id."' and p.products_status = 1 and (p.products_model like '%' or p.products_model like 'D%')";
					    
					    $result = $conn->query($sql);
					    if ($result->num_rows > 0) {
							while($row = $result->fetch_assoc()) {
							    $productsIdsString.=$row['products_id'].',';
							    
							}
						}
					   $prolist87= rtrim($productsIdsString,',');
					    
					    $sql1 = "select p.products_image, pd.products_name, p.products_model, p.products_id from (products_description pd, products p) where p.products_status = '1' and p.products_id = pd.products_id and pd.language_id = '1' and p.products_id in (".$prolist87.") order by p.products_model ASC";
					    $results = $conn->query($sql1);
					    if ($results->num_rows > 0) {
							while($rows = $results->fetch_assoc()) {
							     $cat1=  array(
                				'category_id' =>$rows['products_id'] ,
                				'slider'=>4,
                				'category_level'=>3,
                				'category_name' => $rows['products_name'],
                				'category_description' => '',
                				'category_image' =>base_url.'images/'.$rows['products_image'],
                				'component'=>'product'
                				
                			);		
            				array_push($categoryArr['data'],$cat1);
							    
							}
						}
			        
			    }
			    elseif($category_level==3){
			        $categoryArr=array();
						$categoryArr['status']='Success';
						$categoryArr['error']="";
						$categoryArr['data']=array();
						
						
						//properties
						
						
						
						$stone_name_query = "select stone_name_id from products_to_stones where products_id = '" . $category_id . "' order by stone_name_id ASC";
$no_of_stones = $conn->query($stone_name_query);
	$stone_name_ids2 = array();
	if($no_of_stones->num_rows > 0){
		while($stone_name_ids_new = $no_of_stones->fetch_assoc()){		    
			$stone_name_ids2[] = $stone_name_ids_new['stone_name_id'];
		}
	}
		
if($stone_name_ids2){

	foreach($stone_name_ids2 as $stone_name_ids){
		$prosql_tags = "select distinct st.tag_id, tl.tag_name, st.property_id from stone_tags st, taglist tl where st.tag_id = tl.tag_id and stone_name_id ='".$stone_name_ids."' order by st.property_id, tl.tag_name";
		$prosql_tags = $conn->query($prosql_tags);
		if($prosql_tags->num_rows > 0){
			$pro_array = array();					
			$alternate_stone_name_array = array();
		  	while($array1 = $prosql_tags->fetch_assoc()){
				$tag_display_name = str_replace('-', ' ',$array1['tag_name']);
                if($array1['property_id'] == '22' || $array1['property_id'] == '23' ){
                         if(!in_array($array1['tag_name'],$alternate_stone_name_array) ){
                                  $alternate_stone_name_array[] = $array1['tag_name'];
						 }
                         $pro_array[$array1['property_id']] .=  $array1['tag_name']  ;						
				}
			}
			for($i = 1; $i<= 23; $i++){
				if($i != 22 || $i != 23){
					$pro_array[$i] = substr($pro_array[$i], 0, -2);
				}
				$property_query = "select property_value from stone_properties where property_id = '" . (int)$i . "' and language_id = '1' and stone_name_id='".$stone_name_ids."'";
    			$property = $conn->query($property_query);
				while($array1 = $property->fetch_assoc()){
						$pro_array[$i] =$array1['property_value'];
				}
			}
			$pro_final_array['Stone Name']= $pro_array[1];
			$pro_final_array['Alternate Stone Name #1']= $pro_array[22];
			$pro_final_array['Alternate Stone Name #2']= $pro_array[23];
			$pro_final_array['Primary Chakra']= $pro_array[2];
			$pro_final_array['Secondary Chakra']= $pro_array[12];
			$pro_final_array['Crystal System']= $pro_array[3];
			$pro_final_array['Chemical Composition']= $pro_array[4];
			$pro_final_array['Astrological Sign']= $pro_array[5];
			$pro_final_array['Numerical Vibration']= $pro_array[6];
			$pro_final_array['Hardness']= $pro_array[7];
			$pro_final_array['Color']= preg_replace('/[^(\x20-\x7F)]*/','',$pro_array[8]);
			$pro_final_array['Location']= $pro_array[9];
			$pro_final_array['Rarity']= $pro_array[10];
			$pro_final_array['Pronunciation']= $pro_array[11];
			$pro_final_array['Mineral Class']= $pro_array[13];
			$pro_final_array['Common Conditions (Physical)']= $pro_array[14];
			 $pro_final_array['Common Conditions (Emotional)']= $pro_array[15];
			 $pro_final_array['Common Conditions (Spiritual)']= $pro_array[16];
			 $pro_final_array['Extra Grade']= $pro_array[17];
			 $pro_final_array['A Grade']= $pro_array[18];
			 $pro_final_array['B Grade']= $pro_array[19];
			 $pro_final_array['Affirmation']= $pro_array[20];
			  $pro_final_array['Question']= $pro_array[21];
		}
	}
}else{
    $pro_final_array['Category']= 'Assortments';
}
						
						
						
						
						
						
						
						
						//END of properties
						$sql="select * from products p, products_description pd where p.products_id = '".$category_id."' and pd.products_id = p.products_id and pd.language_id = '1'";
					
						$result = $conn->query($sql);
						if ($result->num_rows > 0) {
							// output data of each row
							while($row = $result->fetch_assoc()) {
							   
							    $dd=strip_tags($row['products_description']);
							$string = preg_replace('/[\x00-\x1F\x7F-\xFF]/', '', $dd);
								$cat1=array('category_id'=>$row['products_id'],
								'slider'=>1,
								'category_name'=>$row['products_name'],
								'category_description'=>$string,
								'products_image' => base_url.'images_100/'.$row['products_image'],
						'products_image_med' => base_url.'images_100/'.$row['products_image_med'],
						'products_image_lrg' => base_url.'images_100/'.$row['products_image_lrg'],
						'products_image_sm_1' => base_url.'images_100/'.$row['products_image_sm_1'],
						'products_image_xl_1' => base_url.'images_100/'.$row['products_image_xl_1'],
						'products_image_sm_2' => base_url.'images_100/'.$row['products_image_sm_2'],
						'products_image_xl_2' => base_url.'images_100/'.$row['products_image_xl_2'],
						'products_image_sm_3' => base_url.'images_100/'.$row['products_image_sm_3'],
						'products_image_xl_3' => base_url.'images_100/'.$row['products_image_xl_3'],
						'products_image_sm_4' => base_url.'images_100/'.$row['products_image_sm_4'],
						'products_image_xl_4' => base_url.'images_100/'.$row['products_image_xl_4'],
						'products_image_sm_5' => base_url.'images_100/'.$row['products_image_sm_5'],
						'products_image_xl_5' => base_url.'images_100/'.$row['products_image_xl_5'],
						'products_image_sm_6' => base_url.'images_100/'.$row['products_image_sm_6'],
						'products_image_xl_6' => base_url.'images_100/'.$row['products_image_xl_6'],
						'products_image_alt' =>  base_url.'images_100/'.$row['products_image_alt'],
						'products_image_alt_1' => base_url.'images_100/'.$row['products_image_alt_1'],
						'products_image_alt_2' => base_url.'images_100/'.$row['products_image_alt_2'],
						'products_image_alt_3' => base_url.'images_100/'.$row['products_image_alt_3'],
						'products_image_alt_4' => base_url.'images_100/'.$row['products_image_alt_4'],
						'products_image_alt_5' => base_url.'images_100/'.$row['products_image_alt_5'],
						'products_image_alt_6' => base_url.'images_100/'.$row['products_image_alt_6'],						
						'products_image_sm_7' => base_url.'images_100/'.$row['products_image_sm_7'],
						'products_image_sm_8' => base_url.'images_100/'.$row['products_image_sm_8'],
						'products_image_sm_9' => base_url.'images_100/'.$row['products_image_sm_9'],
						'products_image_sm_10' => base_url.'images_100/'.$row['products_image_sm_10'],
						'products_image_xl_7' => base_url.'images_100/'.$row['products_image_xl_7'],
						'products_image_xl_8' => base_url.'images_100/'.$row['products_image_xl_8'],
						'products_image_xl_9' => base_url.'images_100/'.$row['products_image_xl_9'],
						'products_image_xl_10' => base_url.'images_100/'.$row['products_image_xl_10'],
						'products_image_alt_7' => base_url.'images_100/'.$row['products_image_alt_7'],
						'products_image_alt_8' => base_url.'images_100/'.$row['products_image_alt_8'],
						'products_image_alt_9' => base_url.'images_100/'.$row['products_image_alt_9'],
						'products_image_alt_10' => base_url.'images_100/'.$row['products_image_alt_10'],
						'products_image_sm_11' => base_url.'images_100/'.$row['products_image_sm_11'],
						'products_image_xl_11' => base_url.'images_100/'.$row['products_image_xl_11'],
						'products_image_alt_11' => base_url.'images_100/'.$row['products_image_alt_11'],
						'products_image_sm_12' => base_url.'images_100/'.$row['products_image_sm_12'],
						'products_image_xl_12' => base_url.'images_100/'.$row['products_image_xl_12'],
						'products_image_alt_12' => base_url.'images_100/'.$row['products_image_alt_12'],
								'category_price'=>'0.00','category_properties'=>$pro_final_array,
								'component'=>'product');
								
								array_push($categoryArr['data'],$cat1);
							}
						}
					 $conn->close(); 
			    }
			    
			    
			}
			if($slider==5){
			    if($category_level==1){
			   	$listing_sql = "select distinct p.products_id, psp.property_value from products p, products_specific_property psp where psp.products_id = p.products_id and lower(psp.property_name) = 'color' and p.products_status = 1 and (p.products_model like '%' or p.products_model like 'D%') order by property_value ASC";
        
                    $result = $conn->query($listing_sql);
            		if ($result->num_rows > 0) { 
            		    $i=0;
            		    $propertyArray=array();
            		    while($rows = $result->fetch_assoc()) {
            		       
            		        $propertyArray[$i] = htmlentities($rows['property_value']);
            		         $i++;
            		    }
            		    $propertyArray_list = array_unique($propertyArray);
            		    foreach($propertyArray_list as $key=>$val){
            		        	 $cat1=  array(
            				'category_id' =>$val,
            				'slider'=>5,
            				'category_level'=>2,
            				'category_name' => $val,
            				'category_description' => '',
            				'category_image' =>'',
            				'component'=>'guides'
            				
            			);		
        								array_push($categoryArr['data'],$cat1);
        						
            		        
            		    }
            		}
            		    
			    }
			    elseif($category_level==2){
			        
			        $sql="select pts.stone_name_id, stone_name,detailed_mpd, count(products_id) as count from products_to_stones pts, stone_names s, stone_properties sp where sp.stone_name_id = pts.stone_name_id and s.stone_name_id = pts.stone_name_id and sp.property_id = '8' and products_id in (select p.products_id from products_specific_property psp, products p where psp.products_id = p.products_id and p.products_status = 1 and (p.products_model like '%' or p.products_model like 'D%') and lower(property_name) = 'color' and property_value = '".$category_id."') group by stone_name_id order by stone_name ASC";
        
                    $result = $conn->query($sql);
            		if ($result->num_rows > 0) {
							// output data of each row
							while($row_one = $result->fetch_assoc()) {
						
							
							
							
							
							$listing_sql = "SELECT a2t.*,ad.articles_url, a.articles_id, a.authors_id, a.articles_date_added, ad.articles_name, ad.articles_head_desc_tag, ad.articles_description, au.authors_name, sn.detailed_mpd,sn.stone_name_id, a2t.topics_id, SUBSTRING( ad.articles_name ,1 ,1) AS start_letter FROM (articles a, articles_description ad, articles_to_topics a2t) LEFT JOIN authors au ON a.authors_id = au.authors_id LEFT JOIN stone_names sn ON a.articles_id = sn.summary_mpd WHERE (a.articles_date_available IS NULL OR to_days(a.articles_date_available) <= to_days(now())) AND a.articles_status = '1' AND a.articles_id = a2t.articles_id AND ad.articles_id = a2t.articles_id AND ad.language_id = '1' AND a2t.topics_id = '3' AND sn.detailed_mpd=".$row_one['detailed_mpd']." ORDER BY ad.articles_name limit 50";
        
                    $results = $conn->query($listing_sql);
            		if ($results->num_rows > 0) {
            		    while($rows = $results->fetch_assoc()) {
            		        
            		             //Properties
            		        $stone_name_query = "select stone_name_id from products_to_stones where products_id = '" . $rows['detailed_mpd'] . "' order by stone_name_id ASC limit 1";
$no_of_stones = $conn->query($stone_name_query);
	$stone_name_ids2 = array();
		while($stone_name_ids_new = $no_of_stones->fetch_assoc()){		    
			$stone_name_ids2[] = $stone_name_ids_new['stone_name_id'];
		}
$pro_final_string='';		
if($stone_name_ids2){

	foreach($stone_name_ids2 as $stone_name_ids){
		$prosql_tags = "select distinct st.tag_id, tl.tag_name, st.property_id from stone_tags st, taglist tl where st.tag_id = tl.tag_id and stone_name_id ='".$stone_name_ids."' order by st.property_id, tl.tag_name";
		$prosql_tags = $conn->query($prosql_tags);
		if($prosql_tags->num_rows > 0){
			$pro_array = array();					
			$alternate_stone_name_array = array();
		  	while($array1 = $prosql_tags->fetch_assoc()){
				$tag_display_name = str_replace('-', ' ',$array1['tag_name']);
                if($array1['property_id'] == '22' || $array1['property_id'] == '23' ){
                         if(!in_array($array1['tag_name'],$alternate_stone_name_array) ){
                                  $alternate_stone_name_array[] = $array1['tag_name'];
						 }
                         $pro_array[$array1['property_id']] .=  $array1['tag_name']  ;						
				}
			}
			for($i = 1; $i<= 23; $i++){
				if($i != 22 || $i != 23){
					$pro_array[$i] = substr($pro_array[$i], 0, -2);
				}
				$property_query = "select property_value from stone_properties where property_id = '" . (int)$i . "' and language_id = '1' and stone_name_id='".$stone_name_ids."'";
    			$property = $conn->query($property_query);
				while($array1 = $property->fetch_assoc()){
						
						if($i==5){
						    	$astroIdArray = explode(', ', $array1['property_value']);
                    			$as_sign=='';
                    			if($astroIdArray[0]){
                    			    $as_sign.=$astroIdArray[0];
                    			}
                    				if($astroIdArray[1]){
                    			    $as_sign.=','.$astroIdArray[1];
                    			}
                    			if($astroIdArray[2]){
                    			    $as_sign.=','.$astroIdArray[2];
                    			}
                    			$pro_array[$i] =$as_sign;
						}else{
						    $pro_array[$i] =$array1['property_value'];
						}
				}
			}
			
		
		
			$pro_final_string.='Primary Chakra - '.$pro_array[2].',,';
			$pro_final_string.='Astrological Sign - '.$pro_array[5];
		}	
	}
}else{
    $pro_final_string.='Category - Assortments';
}
//Properties
            		       
            		         $cat1=  array(
            				'category_id' =>$rows['detailed_mpd'],
            				'slider'=>3,
            				'category_level'=>2,
            				'category_properties'=>$pro_final_string,
            				'category_name' => $rows['articles_name'],
            				'category_description' => strip_tags($rows['articles_description']),
            				'category_image' =>$rows['articles_url'],
            				'category_buy' =>trim($rows['stone_name_id']),
            				'component'=>'article'
            				
            			);
            			array_push($categoryArr['data'],$cat1);
            		    }
            		}
							
							
							
							}
						}
			        
			        
			    }
			    elseif($category_level==3){
			        
			        $sql = "select DISTINCT(psp.products_id) from products p, products_specific_property psp, products_to_stones pts where psp.products_id = p.products_id and pts.products_id = p.products_id and p.products_status = 1 and p.products_model like '%' and lower(property_name) = 'color' and property_value = '".$tag_id."' and stone_name_id = '".$category_id."'";
					    
					    $result = $conn->query($sql);
					    if ($result->num_rows > 0) {
							while($row = $result->fetch_assoc()) {
							    $productsIdsString.=$row['products_id'].',';
							    
							}
						}
					   $prolist87= rtrim($productsIdsString,',');
					    
					     $sql1 = "select * from products p, products_description pd where p.products_id in (".$prolist87.") and pd.products_id = p.products_id and pd.language_id = '1'";
					    
					    $results = $conn->query($sql1);
					    if ($results->num_rows > 0) {
							while($rows = $results->fetch_assoc()) {
							     $cat1=  array(
                				'category_id' =>$rows['products_id'] ,
                				'slider'=>5,
                				'category_level'=>4,
                				'category_name' => $rows['products_name'],
                				'category_description' => '',
                				'category_image' =>base_url.'images/'.$rows['products_image'],
                				'component'=>'product'
                				
                			);		
            				array_push($categoryArr['data'],$cat1);
							    
							}
						}
			        
			    }
			    elseif($category_level==4){
			        $categoryArr=array();
						$categoryArr['status']='Success';
						$categoryArr['error']="";
						$categoryArr['data']=array();
						
						
						//properties
						
						
						
						$stone_name_query = "select stone_name_id from products_to_stones where products_id = '" . $category_id . "' order by stone_name_id ASC";
$no_of_stones = $conn->query($stone_name_query);
	$stone_name_ids2 = array();
		while($stone_name_ids_new = $no_of_stones->fetch_assoc()){		    
			$stone_name_ids2[] = $stone_name_ids_new['stone_name_id'];
		}
		
if($stone_name_ids2){

	foreach($stone_name_ids2 as $stone_name_ids){
		$prosql_tags = "select distinct st.tag_id, tl.tag_name, st.property_id from stone_tags st, taglist tl where st.tag_id = tl.tag_id and stone_name_id ='".$stone_name_ids."' order by st.property_id, tl.tag_name";
		$prosql_tags = $conn->query($prosql_tags);
		if($prosql_tags->num_rows > 0){
			$pro_array = array();					
			$alternate_stone_name_array = array();
		  	while($array1 = $prosql_tags->fetch_assoc()){
				$tag_display_name = str_replace('-', ' ',$array1['tag_name']);
                if($array1['property_id'] == '22' || $array1['property_id'] == '23' ){
                         if(!in_array($array1['tag_name'],$alternate_stone_name_array) ){
                                  $alternate_stone_name_array[] = $array1['tag_name'];
						 }
                         $pro_array[$array1['property_id']] .=  $array1['tag_name']  ;						
				}
			}
			for($i = 1; $i<= 23; $i++){
				if($i != 22 || $i != 23){
					$pro_array[$i] = substr($pro_array[$i], 0, -2);
				}
				$property_query = "select property_value from stone_properties where property_id = '" . (int)$i . "' and language_id = '1' and stone_name_id='".$stone_name_ids."'";
    			$property = $conn->query($property_query);
				while($array1 = $property->fetch_assoc()){
						$pro_array[$i] =$array1['property_value'];
				}
			}
			$pro_final_array['Stone Name']= $pro_array[1];
			$pro_final_array['Alternate Stone Name #1']= $pro_array[22];
			$pro_final_array['Alternate Stone Name #2']= $pro_array[23];
			$pro_final_array['Primary Chakra']= $pro_array[2];
			$pro_final_array['Secondary Chakra']= $pro_array[12];
			$pro_final_array['Crystal System']= $pro_array[3];
			$pro_final_array['Chemical Composition']= $pro_array[4];
			$pro_final_array['Astrological Sign']= $pro_array[5];
			$pro_final_array['Numerical Vibration']= $pro_array[6];
			$pro_final_array['Hardness']= $pro_array[7];
			$pro_final_array['Color']= preg_replace('/[^(\x20-\x7F)]*/','',$pro_array[8]);
			$pro_final_array['Location']= $pro_array[9];
			$pro_final_array['Rarity']= $pro_array[10];
			$pro_final_array['Pronunciation']= $pro_array[11];
			$pro_final_array['Mineral Class']= $pro_array[13];
			$pro_final_array['Common Conditions (Physical)']= $pro_array[14];
			 $pro_final_array['Common Conditions (Emotional)']= $pro_array[15];
			 $pro_final_array['Common Conditions (Spiritual)']= $pro_array[16];
			 $pro_final_array['Extra Grade']= $pro_array[17];
			 $pro_final_array['A Grade']= $pro_array[18];
			 $pro_final_array['B Grade']= $pro_array[19];
			 $pro_final_array['Affirmation']= $pro_array[20];
			  $pro_final_array['Question']= $pro_array[21];
		}
	}
}else{
    $pro_final_array['Category']= 'Assortments';
}
						
						
						
						
						
						
						
						
						//END of properties
						$sql="select * from products p, products_description pd where p.products_id = '".$category_id."' and pd.products_id = p.products_id and pd.language_id = '1'";
					
						$result = $conn->query($sql);
						if ($result->num_rows > 0) {
							// output data of each row
							while($row = $result->fetch_assoc()) {
							   
							    $dd=strip_tags($row['products_description']);
							$string = preg_replace('/[\x00-\x1F\x7F-\xFF]/', '', $dd);
								$cat1=array('category_id'=>$row['products_id'],
								'slider'=>1,
								'category_name'=>$row['products_name'],
								'category_description'=>$string,
								'products_image' => base_url.'images_100/'.$row['products_image'],
						'products_image_med' => base_url.'images_100/'.$row['products_image_med'],
						'products_image_lrg' => base_url.'images_100/'.$row['products_image_lrg'],
						'products_image_sm_1' => base_url.'images_100/'.$row['products_image_sm_1'],
						'products_image_xl_1' => base_url.'images_100/'.$row['products_image_xl_1'],
						'products_image_sm_2' => base_url.'images_100/'.$row['products_image_sm_2'],
						'products_image_xl_2' => base_url.'images_100/'.$row['products_image_xl_2'],
						'products_image_sm_3' => base_url.'images_100/'.$row['products_image_sm_3'],
						'products_image_xl_3' => base_url.'images_100/'.$row['products_image_xl_3'],
						'products_image_sm_4' => base_url.'images_100/'.$row['products_image_sm_4'],
						'products_image_xl_4' => base_url.'images_100/'.$row['products_image_xl_4'],
						'products_image_sm_5' => base_url.'images_100/'.$row['products_image_sm_5'],
						'products_image_xl_5' => base_url.'images_100/'.$row['products_image_xl_5'],
						'products_image_sm_6' => base_url.'images_100/'.$row['products_image_sm_6'],
						'products_image_xl_6' => base_url.'images_100/'.$row['products_image_xl_6'],
						'products_image_alt' =>  base_url.'images_100/'.$row['products_image_alt'],
						'products_image_alt_1' => base_url.'images_100/'.$row['products_image_alt_1'],
						'products_image_alt_2' => base_url.'images_100/'.$row['products_image_alt_2'],
						'products_image_alt_3' => base_url.'images_100/'.$row['products_image_alt_3'],
						'products_image_alt_4' => base_url.'images_100/'.$row['products_image_alt_4'],
						'products_image_alt_5' => base_url.'images_100/'.$row['products_image_alt_5'],
						'products_image_alt_6' => base_url.'images_100/'.$row['products_image_alt_6'],						
						'products_image_sm_7' => base_url.'images_100/'.$row['products_image_sm_7'],
						'products_image_sm_8' => base_url.'images_100/'.$row['products_image_sm_8'],
						'products_image_sm_9' => base_url.'images_100/'.$row['products_image_sm_9'],
						'products_image_sm_10' => base_url.'images_100/'.$row['products_image_sm_10'],
						'products_image_xl_7' => base_url.'images_100/'.$row['products_image_xl_7'],
						'products_image_xl_8' => base_url.'images_100/'.$row['products_image_xl_8'],
						'products_image_xl_9' => base_url.'images_100/'.$row['products_image_xl_9'],
						'products_image_xl_10' => base_url.'images_100/'.$row['products_image_xl_10'],
						'products_image_alt_7' => base_url.'images_100/'.$row['products_image_alt_7'],
						'products_image_alt_8' => base_url.'images_100/'.$row['products_image_alt_8'],
						'products_image_alt_9' => base_url.'images_100/'.$row['products_image_alt_9'],
						'products_image_alt_10' => base_url.'images_100/'.$row['products_image_alt_10'],
						'products_image_sm_11' => base_url.'images_100/'.$row['products_image_sm_11'],
						'products_image_xl_11' => base_url.'images_100/'.$row['products_image_xl_11'],
						'products_image_alt_11' => base_url.'images_100/'.$row['products_image_alt_11'],
						'products_image_sm_12' => base_url.'images_100/'.$row['products_image_sm_12'],
						'products_image_xl_12' => base_url.'images_100/'.$row['products_image_xl_12'],
						'products_image_alt_12' => base_url.'images_100/'.$row['products_image_alt_12'],
								'category_price'=>'0.00','category_properties'=>$pro_final_array,
								'component'=>'product');
								
								array_push($categoryArr['data'],$cat1);
							}
						}
					 $conn->close(); 
			    }
			}
			if($slider==6){
			    
			     		$listing_sql = "select a.articles_id, a.articles_date_added, a.articles_date_available, a.authors_id, ad.articles_name, ad.articles_description, ad.articles_url, au.authors_name, a.articles_video from (articles a, articles_description ad) left join authors au on a.authors_id = au.authors_id where a.articles_id = '1009' and ad.articles_id = a.articles_id and ad.language_id = '1'";
        
                     $result = $conn->query($listing_sql);
                		if ($result->num_rows > 0) { 
                		    $i=0;
                		    $propertyArray=array();
                		   while( $rows= $result->fetch_assoc()) {
                		      $cat1=array('category_id'=>$rows['articles_id'],
            								'category_description'=>$rows['articles_description'],
            								'category_image'=>$rows['articles_url'],
            								'category_name'=>$rows['articles_name']);
            								array_push($categoryArr['data'],$cat1);
                		       
                		   }
                		}
            		    
			}
			if($slider==7){
				if($category_level==1){
				
					$cat1='';
					$cat2='';
					$cat3='';
					 
					$categoryArr			= array();
					$categoryArr['status']	= 'Success';
					$categoryArr['error']	= "";
					$categoryArr['data']	= array();
				
				
						$cat1=array('category_id'=>'M','slider'=>7,'category_level'=>2,'category_name'=>'Monthly Newsletter Archive','component'=>'guides');
						$cat2=array('category_id'=>'A','slider'=>7,'category_level'=>2,'category_name'=>'Astrology and Birthstone Information','component'=>'article');
						$cat3=array('category_id'=>'S','slider'=>7,'category_level'=>2,'category_name'=>'Crystal Shape Information','component'=>'article');
						$cat4=array('category_id'=>'C','slider'=>7,'category_level'=>2,'category_name'=>'Crystals and Color','component'=>'article');
						$cat5=array('category_id'=>'V','slider'=>7,'category_level'=>2,'category_name'=>'Videos','component'=>'browser');
						$cat6=array('category_id'=>'P','slider'=>7,'category_level'=>2,'category_name'=>'Crystals For Protection','component'=>'article');
						array_push($categoryArr['data'],$cat1);
						array_push($categoryArr['data'],$cat2);
						array_push($categoryArr['data'],$cat3);
						array_push($categoryArr['data'],$cat4);
						array_push($categoryArr['data'],$cat5);
						array_push($categoryArr['data'],$cat6);
					
				
				}
				elseif($category_level==2){
				    if($category_id=='M'){
				        		$listing_sql = "select distinct a.articles_id, a.authors_id, a.articles_date_added, a.articles_date_available, ad.articles_name,ad.articles_description, ad.articles_url, ad.articles_head_desc_tag, au.authors_name, td.topics_name, a2t.topics_id from (articles a, articles_description ad, articles_to_topics a2t) left join authors au on a.authors_id = au.authors_id left join topics_description td on a2t.topics_id = td.topics_id where (a.articles_date_available IS NULL or a.articles_date_available <= now()) and a.articles_status = '1' and a.publish_on_hc = '1' and a.articles_id = a2t.articles_id and ad.articles_id = a2t.articles_id and ad.language_id = '1' and td.language_id = '1' and a2t.topics_id = '2' group by a.articles_id order by a.articles_date_available desc, ad.articles_name";
        
                    $result = $conn->query($listing_sql);
            		if ($result->num_rows > 0) { 
            		    $i=0;
            		    $propertyArray=array();
            		   while( $rows= $result->fetch_assoc()) {
            		       $string=htmlentities($rows['articles_description']);
            		       //	$string = preg_replace('/[\x00-\x1F\x7F-\xFF]/', '', $dd);
            		      $string = preg_replace('@<(\w+)\b.*?>.*?</\1>@si', '', $string);
            		         $cat1=  array(
            				'category_id' =>$rows['articles_id'],
            				'slider'=>7,
            				'category_level'=>3,
            				'tag_id'=>'M',
            				'category_name' => strip_tags($rows['articles_name']),
            				'category_description' => substr(strip_tags($string, "<strong><em>"),0,210),
            				'category_image' =>$rows['articles_url'],
            				'component'=>'article'
            				
            			);		
        								array_push($categoryArr['data'],$cat1);
            		    }
            		}
            		
				    }
            		elseif($category_id=='A'){
            		    	$listing_sql = "select a.articles_id, a.articles_date_added, a.articles_date_available, a.authors_id, ad.articles_name, ad.articles_description, ad.articles_url, au.authors_name, a.articles_video from (articles a, articles_description ad) left join authors au on a.authors_id = au.authors_id where a.articles_id = '1124' and ad.articles_id = a.articles_id and ad.language_id = '1'";
        
                        $result = $conn->query($listing_sql);
                		if ($result->num_rows > 0) { 
                		    $i=0;
                		    $propertyArray=array();
                		   while( $rows= $result->fetch_assoc()) {
                		      $cat1=array('category_id'=>$rows['articles_id'],
            								'category_description'=>$rows['articles_description'],
            								'category_image'=>$rows['articles_url'],
            								'category_name'=>$rows['articles_name']);
            								array_push($categoryArr['data'],$cat1);
                		       
                		   }
                		}
            		}
            		elseif($category_id=='S'){
            		    	$listing_sql = "select a.articles_id, a.articles_date_added, a.articles_date_available, a.authors_id, ad.articles_name, ad.articles_description, ad.articles_url, au.authors_name, a.articles_video from (articles a, articles_description ad) left join authors au on a.authors_id = au.authors_id where a.articles_id = '11619' and ad.articles_id = a.articles_id and ad.language_id = '1'";
        
                        $result = $conn->query($listing_sql);
                		if ($result->num_rows > 0) { 
                		    $i=0;
                		    $propertyArray=array();
                		   while( $rows= $result->fetch_assoc()) {
                		      $cat1=array('category_id'=>$rows['articles_id'],
            								'category_description'=>$rows['articles_description'],
            								'category_image'=>$rows['articles_url'],
            								'category_name'=>$rows['articles_name']);
            								array_push($categoryArr['data'],$cat1);
                		       
                		   }
                		}
            		}elseif($category_id=='C'){
            		    	$listing_sql = "select a.articles_id, a.articles_date_added, a.articles_date_available, a.authors_id, ad.articles_name, ad.articles_description, ad.articles_url, au.authors_name, a.articles_video from (articles a, articles_description ad) left join authors au on a.authors_id = au.authors_id where a.articles_id = '5744' and ad.articles_id = a.articles_id and ad.language_id = '1'";
        
                        $result = $conn->query($listing_sql);
                		if ($result->num_rows > 0) { 
                		    $i=0;
                		    $propertyArray=array();
                		   while( $rows= $result->fetch_assoc()) {
                		      $cat1=array('category_id'=>$rows['articles_id'],
            								'category_description'=>$rows['articles_description'],
            								'category_image'=>$rows['articles_url'],
            								'category_name'=>$rows['articles_name']);
            								array_push($categoryArr['data'],$cat1);
                		       
                		   }
                		}
            		}elseif($category_id=='V'){
            		    	
                		      $cat1=array('category_id'=>'',
            								'category_description'=>'https://www.youtube.com/user/healingcrystals/videos',
            								'category_image'=>'',
            								'category_name'=>'');
            								array_push($categoryArr['data'],$cat1);
                		       
                		   
                		}
            		elseif($category_id=='P'){
            		    	$listing_sql = "select a.articles_id, a.articles_date_added, a.articles_date_available, a.authors_id, ad.articles_name, ad.articles_description, ad.articles_url, au.authors_name, a.articles_video from (articles a, articles_description ad) left join authors au on a.authors_id = au.authors_id where a.articles_id = '11686' and ad.articles_id = a.articles_id and ad.language_id = '1'";
        
                        $result = $conn->query($listing_sql);
                		if ($result->num_rows > 0) { 
                		    $i=0;
                		    $propertyArray=array();
                		   while( $rows= $result->fetch_assoc()) {
                		      $cat1=array('category_id'=>$rows['articles_id'],
            								'category_description'=>$rows['articles_description'],
            								'category_image'=>$rows['articles_url'],
            								'category_name'=>$rows['articles_name']);
            								array_push($categoryArr['data'],$cat1);
                		       
                		   }
                		}
            		}
				}
				elseif($category_level==3){
				    
				    	$listing_sql = "select distinct a.articles_id, a.authors_id, a.articles_date_added, a.articles_date_available, ad.articles_name,ad.articles_description, ad.articles_url, ad.articles_head_desc_tag, au.authors_name, td.topics_name, a2t.topics_id from (articles a, articles_description ad, articles_to_topics a2t) left join authors au on a.authors_id = au.authors_id left join topics_description td on a2t.topics_id = td.topics_id where (a.articles_date_available IS NULL or a.articles_date_available <= now()) and a.articles_status = '1' and a.publish_on_hc = '1' and a.articles_id = a2t.articles_id and ad.articles_id = a2t.articles_id and ad.language_id = '1' and td.language_id = '1' and a2t.topics_id = '2' and a.articles_id='".$category_id."' group by a.articles_id order by a.articles_date_available desc, ad.articles_name";
        
                    	            $result = $conn->query($listing_sql);
            		if ($result->num_rows > 0) { 
            		    $i=0;
            		    $propertyArray=array();
            		   while( $rows= $result->fetch_assoc()) {
            		       $string=htmlentities($rows['articles_description']);
            		       //	$string = preg_replace('/[\x00-\x1F\x7F-\xFF]/', '', $dd);
            		       //'category_description' => substr(strip_tags($string, "<strong><em>"),0,210),
            		      $string = preg_replace('@<(\w+)\b.*?>.*?</\1>@si', '', $string);
            		         $cat1=  array(
            				'category_id' =>$rows['articles_id'],
            				'slider'=>7,
            				'category_level'=>3,
            				'tag_id'=>'M',
            				'category_name' => strip_tags($rows['articles_name']),
            				'category_description' => $rows['articles_description'],
            				'category_image' =>$rows['articles_url'],
            				'component'=>'article'
            				
            			);		
        								array_push($categoryArr['data'],$cat1);
            		    }
            		}
            		
				}
			}
			
			
	}else{
        $categoryArr['status']='Error';
		$categoryArr['error']="category id cant be null";
	}
    
    echo  json_encode($categoryArr);
} 


function get_splash(){
	header('Access-Control-Allow-Origin: *');
	$splashArr=array();
	$splashArr['status']='Success';
	$splashArr['error']="";
	$splashArr['data']=array();
	$slide1=array('splash_id'=>1,'splash_text'=>'Welcome to the Healing Crystals Metaphysical Directory App!',"url"=>base_url.api_path."images/splash/splash_image.jpg");
	
	array_push($splashArr['data'],$slide1);
	
	echo  json_encode($splashArr);
}

function social_media(){
			 
			  $categoryArr=array();
			  $categoryArr['status']='Success';
			  $categoryArr['error']="";
			  $categoryArr['data']=array();
			  $cat1=array('sort'=>1,'name'=>'Facebook',"url"=>"https://www.facebook.com/crystaltalk");	
			  $cat2=array('sort'=>2,'name'=>'You Tube',"url"=>"https://www.youtube.com/user/healingcrystals");	
			  $cat3=array('sort'=>3,'name'=>'Twitter',"url"=>"https://twitter.com/crystaltalk");	
			  $cat4=array('sort'=>4,'name'=>'Instagram',"url"=>"https://www.instagram.com/healingcrystals/#");	
			  $cat5=array('sort'=>5,'name'=>'Tumblr',"url"=>"https://healingcrystals-crystaltalk.tumblr.com/");	
			  $cat6=array('sort'=>6,'name'=>'Pinterest',"url"=>"https://in.pinterest.com/crystaltalk/");	
				
				array_push($categoryArr['data'],$cat1);
				array_push($categoryArr['data'],$cat2);
				array_push($categoryArr['data'],$cat3);
				array_push($categoryArr['data'],$cat4);
				array_push($categoryArr['data'],$cat5);
				array_push($categoryArr['data'],$cat6);	
				
				echo  json_encode($categoryArr);
		 }

function search_product(){
    header('Access-Control-Allow-Origin: *');
    $categoryArr=array();
	$categoryArr['status']='Success';
	$categoryArr['error']="";
	$categoryArr['data']=array();
    
    if (isset($_SERVER['HTTP_ORIGIN'])) {
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
    }
 
    // Access-Control headers are received during OPTIONS requests
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
 
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         
 
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers:        {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
 
        exit(0);
    }
     $postdata = file_get_contents("php://input");
     if (isset($postdata)) {
        $request = json_decode($postdata);
        $product_level = $request->product_level;
        $product_name = $request->product_name;
        $products_id = $request->products_id;
     $servername = "localhost";
        $username = "copyache_new";
        $password = ",&B.9X1G_yoC";
        $dbname = "copyache_10nov17";
        
        
        //Traceability
		
		$location=$request->location;
		$user_app_id=$request->user_app_id;
		$action='Searched the product '.$product_name;
		$event=2;
		
		traceability_api_trigger($user_app_id,$action,$event,$location);

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    	$categoryArr=array();
		$categoryArr['status']='Success';
		$categoryArr['error']="";
		$categoryArr['data']=array();
		if($product_level==1){				
		$sql="SELECT DISTINCT p.products_id FROM products p INNER JOIN products_description pd ON p.products_id = pd.products_id WHERE pd.language_id = '1' AND p.products_status = '1' AND pd.products_name LIKE '".stripslashes($product_name)."%'";
						
						$result = $conn->query($sql);
						if ($result->num_rows > 0) {
							// output data of each row
							while($row = $result->fetch_assoc()) {
							     $search_prod_count[] = $row['products_id'];
							
							}
							$search_prod_ids=implode(",",$search_prod_count);
							
						}
						$sql1 = "SELECT p.products_id, pd.products_name, p.products_image,p.products_model,pd.products_description FROM products p INNER JOIN products_description pd on p.products_id = pd.products_id INNER JOIN  products_attributes pa ON pa.products_id=p.products_id  WHERE pd.language_id = '1' AND p.products_status = '1' AND p.products_id IN (".$search_prod_ids.")  GROUP BY p.products_id ORDER BY pd.products_name ASC ";
							$result = $conn->query($sql1);
						if ($result->num_rows > 0) {
							while($rows = $result->fetch_assoc()) {
							     $cat1=  array(
				'products_id' =>$rows['products_id'],
				'products_name' => $rows['products_name'],
				'products_description' => $products_description,
				'products_image' =>base_url.'/images/'.$rows['products_image'],
				'component' =>'product','product_level'=>2);
			array_push($categoryArr['data'],$cat1);
							
							}
						}
		}elseif($product_level==2){
		    
		   $categoryArr=array();
						$categoryArr['status']='Success';
						$categoryArr['error']="";
						$categoryArr['data']=array();
						
						
						//properties
						
						
						
						$stone_name_query = "select stone_name_id from products_to_stones where products_id = '" . $product_id . "' order by stone_name_id ASC";
$no_of_stones = $conn->query($stone_name_query);
	$stone_name_ids2 = array();
		while($stone_name_ids_new = $no_of_stones->fetch_assoc()){		    
			$stone_name_ids2[] = $stone_name_ids_new['stone_name_id'];
		}
		
if($stone_name_ids2){

	foreach($stone_name_ids2 as $stone_name_ids){
		$prosql_tags = "select distinct st.tag_id, tl.tag_name, st.property_id from stone_tags st, taglist tl where st.tag_id = tl.tag_id and stone_name_id ='".$stone_name_ids."' order by st.property_id, tl.tag_name";
		$prosql_tags = $conn->query($prosql_tags);
		if($prosql_tags->num_rows > 0){
			$pro_array = array();					
			$alternate_stone_name_array = array();
		  	while($array1 = $prosql_tags->fetch_assoc()){
				$tag_display_name = str_replace('-', ' ',$array1['tag_name']);
                if($array1['property_id'] == '22' || $array1['property_id'] == '23' ){
                         if(!in_array($array1['tag_name'],$alternate_stone_name_array) ){
                                  $alternate_stone_name_array[] = $array1['tag_name'];
						 }
                         $pro_array[$array1['property_id']] .=  $array1['tag_name']  ;						
				}
			}
			for($i = 1; $i<= 23; $i++){
				if($i != 22 || $i != 23){
					$pro_array[$i] = substr($pro_array[$i], 0, -2);
				}
				$property_query = "select property_value from stone_properties where property_id = '" . (int)$i . "' and language_id = '1' and stone_name_id='".$stone_name_ids."'";
    			$property = $conn->query($property_query);
				while($array1 = $property->fetch_assoc()){
						$pro_array[$i] =$array1['property_value'];
				}
			}
			$pro_final_array['Stone Name']= $pro_array[1];
			$pro_final_array['Alternate Stone Name #1']= $pro_array[22];
			$pro_final_array['Alternate Stone Name #2']= $pro_array[23];
			$pro_final_array['Primary Chakra']= $pro_array[2];
			$pro_final_array['Secondary Chakra']= $pro_array[12];
			$pro_final_array['Crystal System']= $pro_array[3];
			$pro_final_array['Chemical Composition']= $pro_array[4];
			$pro_final_array['Astrological Sign']= $pro_array[5];
			$pro_final_array['Numerical Vibration']= $pro_array[6];
			$pro_final_array['Hardness']= $pro_array[7];
			$pro_final_array['Color']= preg_replace('/[^(\x20-\x7F)]*/','',$pro_array[8]);
			$pro_final_array['Location']= $pro_array[9];
			$pro_final_array['Rarity']= $pro_array[10];
			$pro_final_array['Pronunciation']= $pro_array[11];
			$pro_final_array['Mineral Class']= $pro_array[13];
			$pro_final_array['Common Conditions (Physical)']= $pro_array[14];
			 $pro_final_array['Common Conditions (Emotional)']= $pro_array[15];
			 $pro_final_array['Common Conditions (Spiritual)']= $pro_array[16];
			 $pro_final_array['Extra Grade']= $pro_array[17];
			 $pro_final_array['A Grade']= $pro_array[18];
			 $pro_final_array['B Grade']= $pro_array[19];
			 $pro_final_array['Affirmation']= $pro_array[20];
			  $pro_final_array['Question']= $pro_array[21];
		}
	}
}else{
    $pro_final_array['Category']= 'Assortments';
}

						
						
						
						
						
						
						
						
						//END of properties
						$sql="select * from products p, products_description pd where p.products_id = '".$product_id."' and pd.products_id = p.products_id and pd.language_id = '1'";
					
						$result = $conn->query($sql);
						if ($result->num_rows > 0) {
							// output data of each row
							while($row = $result->fetch_assoc()) {
							   
							    $dd=strip_tags($row['products_description']);
							$string = preg_replace('/[\x00-\x1F\x7F-\xFF]/', '', $dd);
								$cat1=array('category_id'=>$row['products_id'],
								'slider'=>1,
								'category_name'=>$row['products_name'],
								'category_description'=>$string,
								'products_image' => base_url.'images/'.$row['products_image'],
						'products_image_med' => base_url.'images/'.$row['products_image_med'],
						'products_image_lrg' => base_url.'images/'.$row['products_image_lrg'],
						'products_image_sm_1' => base_url.'images/'.$row['products_image_sm_1'],
						'products_image_xl_1' => base_url.'images/'.$row['products_image_xl_1'],
						'products_image_sm_2' => base_url.'images/'.$row['products_image_sm_2'],
						'products_image_xl_2' => base_url.'images/'.$row['products_image_xl_2'],
						'products_image_sm_3' => base_url.'images/'.$row['products_image_sm_3'],
						'products_image_xl_3' => base_url.'images/'.$row['products_image_xl_3'],
						'products_image_sm_4' => base_url.'images/'.$row['products_image_sm_4'],
						'products_image_xl_4' => base_url.'images/'.$row['products_image_xl_4'],
						'products_image_sm_5' => base_url.'images/'.$row['products_image_sm_5'],
						'products_image_xl_5' => base_url.'images/'.$row['products_image_xl_5'],
						'products_image_sm_6' => base_url.'images/'.$row['products_image_sm_6'],
						'products_image_xl_6' => base_url.'images/'.$row['products_image_xl_6'],
						'products_image_alt' =>  base_url.'images/'.$row['products_image_alt'],
						'products_image_alt_1' => base_url.'images/'.$row['products_image_alt_1'],
						'products_image_alt_2' => base_url.'images/'.$row['products_image_alt_2'],
						'products_image_alt_3' => base_url.'images/'.$row['products_image_alt_3'],
						'products_image_alt_4' => base_url.'images/'.$row['products_image_alt_4'],
						'products_image_alt_5' => base_url.'images/'.$row['products_image_alt_5'],
						'products_image_alt_6' => base_url.'images/'.$row['products_image_alt_6'],						
						'products_image_sm_7' => base_url.'images/'.$row['products_image_sm_7'],
						'products_image_sm_8' => base_url.'images/'.$row['products_image_sm_8'],
						'products_image_sm_9' => base_url.'images/'.$row['products_image_sm_9'],
						'products_image_sm_10' => base_url.'images/'.$row['products_image_sm_10'],
						'products_image_xl_7' => base_url.'images/'.$row['products_image_xl_7'],
						'products_image_xl_8' => base_url.'images/'.$row['products_image_xl_8'],
						'products_image_xl_9' => base_url.'images/'.$row['products_image_xl_9'],
						'products_image_xl_10' => base_url.'images/'.$row['products_image_xl_10'],
						'products_image_alt_7' => base_url.'images/'.$row['products_image_alt_7'],
						'products_image_alt_8' => base_url.'images/'.$row['products_image_alt_8'],
						'products_image_alt_9' => base_url.'images/'.$row['products_image_alt_9'],
						'products_image_alt_10' => base_url.'images/'.$row['products_image_alt_10'],
						'products_image_sm_11' => base_url.'images/'.$row['products_image_sm_11'],
						'products_image_xl_11' => base_url.'images/'.$row['products_image_xl_11'],
						'products_image_alt_11' => base_url.'images/'.$row['products_image_alt_11'],
						'products_image_sm_12' => base_url.'images/'.$row['products_image_sm_12'],
						'products_image_xl_12' => base_url.'images/'.$row['products_image_xl_12'],
						'products_image_alt_12' => base_url.'images/'.$row['products_image_alt_12'],
								'category_price'=>'0.00','category_properties'=>$pro_final_array,
								'component'=>'product');
								
								array_push($categoryArr['data'],$cat1);
							}
						}
		    
		}
					
					 $conn->close(); 
					  echo  json_encode($categoryArr);
     }

}


function search_auto_stone(){
    header('Access-Control-Allow-Origin: *');
    $categoryArr=array();
	$categoryArr['status']='Success';
	$categoryArr['error']="";
	$categoryArr['data']=array();
    
    if (isset($_SERVER['HTTP_ORIGIN'])) {
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
    }
 
    // Access-Control headers are received during OPTIONS requests
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
 
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         
 
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers:        {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
 
        exit(0);
    }
     $postdata = file_get_contents("php://input");
     if (isset($postdata)) {
        $request = json_decode($postdata);
        $product_name = $request->product_name;
        $product_level = $request->product_level;
        $product_id = $request->product_id;
        
        //Traceability
		
		$location=$request->location;
		$user_app_id=$request->user_app_id;
		$action='Searched the stone '.$product_name;
		$event=2;
		
		traceability_api_trigger($user_app_id,$action,$event,$location);
        
     $servername = "localhost";
        $username = "copyache_new";
        $password = ",&B.9X1G_yoC";
        $dbname = "copyache_10nov17";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    	$categoryArr=array();
		$categoryArr['status']='Success';
		$categoryArr['error']="";
		$categoryArr['data']=array();
		
		if($product_level==1){				
		$sql = "select distinct sn.stone_name, pts.stone_name_id, sn.detailed_mpd from products p, products_to_stones pts, stone_names sn where sn.stone_name_id = pts.stone_name_id and pts.products_id = p.products_id and p.products_status = 1 and sn.stone_name like '".stripslashes($product_name)."%' order by stone_name ASC";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
			while($rows = $result->fetch_assoc()) {
				$cat=  array(
				'products_id' =>$rows['detailed_mpd'],
				'products_name' => $rows['stone_name'],
				'products_level'=>2,
				'component'=>'search');
			array_push($categoryArr['data'],$cat);
							
							}
						}
		}elseif($product_level==2){
		    	$sql1 = "select a.articles_id, a.articles_date_added, a.articles_date_available, a.authors_id, ad.articles_name, ad.articles_description, ad.articles_url, au.authors_name, a.articles_video from (articles a, articles_description ad) left join authors au on a.authors_id = au.authors_id where a.articles_id = '".$product_id."' and ad.articles_id = a.articles_id and ad.language_id = '1'";
		    	$result = $conn->query($sql1);
		    	
        		if ($result->num_rows > 0) {
        		    while($row = $result->fetch_assoc()) {
        								$cat1=array('products_id'=>$row['articles_id'],
        								'products_description'=>$row['articles_description'],
        								'products_url'=>$row['articles_url'],
        								'products_name'=>$row['articles_name'],
        								'products_level'=>3,
        								'component'=>'article');
        								array_push($categoryArr['data'],$cat1);
        		    }
        		}
		}elseif($product_level==3){
		    	$sql1 = "select a.articles_id, a.articles_date_added, a.articles_date_available, a.authors_id, ad.articles_name, ad.articles_description, ad.articles_url, au.authors_name, a.articles_video from (articles a, articles_description ad) left join authors au on a.authors_id = au.authors_id where a.articles_id = '".$product_id."' and ad.articles_id = a.articles_id and ad.language_id = '1'";
		    	$result = $conn->query($sql1);
		    	
        		if ($result->num_rows > 0) {
        		    while($row = $result->fetch_assoc()) {
        								$cat1=array('products_id'=>$row['articles_id'],
        								'products_description'=>$row['articles_description'],
        								'products_url'=>$row['articles_url'],
        								'products_name'=>$row['articles_name']);
        								array_push($categoryArr['data'],$cat1);
        		    }
        		}
		}
					
					 $conn->close(); 
					  echo  json_encode($categoryArr);
     }
}


function search_auto_issues(){
    
    
    
    header('Access-Control-Allow-Origin: *');
    $categoryArr=array();
	$categoryArr['status']='Success';
	$categoryArr['error']="";
	$categoryArr['data']=array();
    
    if (isset($_SERVER['HTTP_ORIGIN'])) {
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
    }
 
    // Access-Control headers are received during OPTIONS requests
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
 
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         
 
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers:        {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
 
        exit(0);
    }
     $postdata = file_get_contents("php://input");
     if (isset($postdata)) {
        $request = json_decode($postdata);
        $product_name = $request->product_name;
        $product_level = $request->product_level;
        $product_id = $request->product_id;
        
        //Traceability
		
		$location=$request->location;
		$user_app_id=$request->user_app_id;
		$action='Searched the issue '.$product_name;
		$event=2;
		
		traceability_api_trigger($user_app_id,$action,$event,$location);
        
     $servername = "localhost";
        $username = "copyache_new";
        $password = ",&B.9X1G_yoC";
        $dbname = "copyache_10nov17";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    	$categoryArr=array();
		$categoryArr['status']='Success';
		$categoryArr['error']="";
		$categoryArr['data']=array();
		
		if($product_level==1){				
		$sql = "select distinct st.tag_id, tl.tag_name, st.property_id from stone_tags st, taglist tl, tags_to_products t2p, products p where st.tag_id = tl.tag_id and tl.tag_id = t2p.tag_id and t2p.products_id = p.products_id and tl.tag_name like '".stripslashes($product_name)."%' and property_id in (14, 15, 16) order by tl.sort_order, tl.tag_name";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
		    while($row = $result->fetch_assoc()) {
    			$cat1=array('products_id'=>$row['tag_id'],
            				'products_name'=>$row['tag_name'],
            				'products_level'=>2,
            				'component'=>'search');
        	array_push($categoryArr['data'],$cat1);
							
		    }
		}
		}elseif($product_level==2){
		    	$sql1 = "select detailed_mpd,pts.*,p.products_image,p.*,pts.stone_name_id, stone_name, count(p.products_id) as count from products_to_stones pts, stone_names s, products p where s.stone_name_id = pts.stone_name_id and pts.products_id = p.products_id and p.products_status = 1 and (p.products_model like '%' or p.products_model like 'D%') and pts.stone_name_id in (select st.stone_name_id from stone_tags st, taglist tl where st.tag_id = tl.tag_id and tl.tag_id = '".$product_id."') group by stone_name_id order by stone_name ASC";
		    	$result = $conn->query($sql1);
		    	$productsIdsString='';
        		if ($result->num_rows > 0) {
        		    	while($row = $result->fetch_assoc()) {
							    $productsIdsString.=$row['detailed_mpd'].',';
							    
							}
							
						}
					
						 $prolist87= rtrim($productsIdsString,',');
						
					  	$sql1 = "select ad.*,a.articles_id, a.articles_date_added, a.articles_date_available, a.authors_id, ad.articles_name, ad.articles_description, ad.articles_url, au.authors_name, a.articles_video from (articles a, articles_description ad) left join authors au on a.authors_id = au.authors_id where ad.articles_id in (".$prolist87.")  and ad.articles_id = a.articles_id and ad.language_id = '1'";
		    
		    	$result = $conn->query($sql1);
		    	
        		if ($result->num_rows > 0) {
        		    while($row = $result->fetch_assoc()) {
        								$cat1=array('products_id'=>$row['articles_id'],
        								'products_description'=>$row['articles_description'],
        								'products_url'=>$row['articles_url'],
        								'products_name'=>$row['articles_name'],
        								'products_level'=>3,
            				            'component'=>'article');
        								array_push($categoryArr['data'],$cat1);
        		    }
        		}
        		   /* while($row = $result->fetch_assoc()) {
        								$cat1=array(
        								'products_id'=>$row['detailed_mpd'],
        								'products_description'=>$row['articles_description'],
        								'products_url'=>base_url.'images_100/'.$row['products_image'],
        								'products_name'=>$row['stone_name'],
        								'products_level'=>3,
        								'component'=>'article');
        								array_push($categoryArr['data'],$cat1);
        								
        								
        		    }
        		}*/
		}elseif($product_level==3){
		    	$sql1 = "select ad.*,a.articles_id, a.articles_date_added, a.articles_date_available, a.authors_id, ad.articles_name, ad.articles_description, ad.articles_url, au.authors_name, a.articles_video from (articles a, articles_description ad) left join authors au on a.authors_id = au.authors_id where ad.articles_id='".$product_id."' and ad.articles_id = a.articles_id and ad.language_id = '1'";
		    	$result = $conn->query($sql1);
		    	
        		if ($result->num_rows > 0) {
        		    while($row = $result->fetch_assoc()) {
        								$cat1=array('products_id'=>$row['articles_id'],
        								'products_description'=>$row['articles_description'],
        								'products_url'=>$row['articles_url'],
        								'products_name'=>$row['articles_name']);
        								array_push($categoryArr['data'],$cat1);
        		    }
        		}
		}
					
					 $conn->close(); 
					  echo  json_encode($categoryArr);
     }
     
     
     
}


function mobile_traceability(){
    
    header('Access-Control-Allow-Origin: *');
    $categoryArr=array();
	$categoryArr['status']='Success';
	$categoryArr['error']="";
	$categoryArr['data']=array();
    
    if (isset($_SERVER['HTTP_ORIGIN'])) {
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
    }
 
    // Access-Control headers are received during OPTIONS requests
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
 
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         
 
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers:        {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
 
        exit(0);
    }
    $servername = "localhost";
        $username = "copyache_new";
        $password = ",&B.9X1G_yoC";
        $dbname = "copyache_10nov17";
     // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
     $postdata = file_get_contents("php://input");
     if (isset($postdata)) {
        $request = json_decode($postdata);
        $mt_user_app_id = $request->user_app_id;
        $mt_event = $request->event;
        $mt_action = $request->action;
        $mt_location = $request->location;

        
        
        $sql = "INSERT INTO mobile_traceability (mt_user_app_id, mt_action, mt_event, mt_location) VALUES ('".$mt_user_app_id."', '".$mt_action."', '".$mt_event."', '".$mt_location."')";
        $conn->query($sql);
        $conn->close(); 
    }
}







	    







function related_products(){
    
    header('Access-Control-Allow-Origin: *');
    $categoryArr=array();
	$categoryArr['status']='Success';
	$categoryArr['error']="";
	$categoryArr['data']=array();
    
    if (isset($_SERVER['HTTP_ORIGIN'])) {
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
    }
 
    // Access-Control headers are received during OPTIONS requests
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
 
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         
 
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers:        {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
 
        exit(0);
    }
     $postdata = file_get_contents("php://input");
     if (isset($postdata)) {
        $request = json_decode($postdata);
        $products_id = $request->products_id;
        
     $servername = "localhost";
        $username = "copyache_new";
        $password = ",&B.9X1G_yoC";
        $dbname = "copyache_10nov17";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    	$categoryArr=array();
		$categoryArr['status']='Success';
		$categoryArr['error']="";
		$categoryArr['data']=array();
    
    					
    $sql="select p.products_id, p.products_image from orders_products opa, orders_products opb, orders o, products p where opa.products_id = ".$products_id." and opa.orders_id = opb.orders_id and opb.products_id != ".$products_id." and opb.products_id = p.products_id and opb.orders_id = o.orders_id and p.products_status = '1' group by p.products_id order by o.date_purchased desc limit 8";

						$result = $conn->query($sql);
						if ($result->num_rows > 0) {
							
							while($row = $result->fetch_assoc()) {
							    $sql1="select p.products_image, pd.products_name, p.products_model, p.products_id from (products_description pd, products p) where p.products_status = '1' and p.products_id = pd.products_id and pd.language_id = '1' and p.products_id=".$row['products_id']."";
							    $results = $conn->query($sql1);
						if ($results->num_rows > 0) {
							// output data of each row
							while($rows = $results->fetch_assoc()) {
								$cat1=array('category_id'=>$row['products_id'],
								'category_name'=>$rows['products_name'],
								'category_image'=>base_url.'images/'.$rows['products_image'],
								'component'=>'product');
								array_push($categoryArr['data'],$cat1);
							}
						}
							}
						}
     }
   
    $conn->close();
    echo  json_encode($categoryArr);
}



function tep_get_product_quantity($products_id){
    
     $sql="select products_id, options_values_id from products_attributes where products_id = ".$products_id."";
     $product_qty = 0;
						$result = $conn->query($sql);
						if ($result->num_rows > 0) {
							while($check = $result->fetch_assoc()) {
                                $uprid = $check['products_id'].'{1}'.$check['options_values_id'];
                                $new_product_qty = tep_get_products_stock($uprid);
                                if($product_qty < $new_product_qty && $new_product_qty != ''){
                                    $product_qty = $new_product_qty;
                                }
                            }
        
    }else{
        return FALSE;
    }
    
    if($product_qty < 1){
        return FALSE;
    }else{
        return $product_qty;
    }
}

function tep_get_products_stock($products_id, $amazon_flag = false) {
		$i = $products_id;
    $products_id = tep_get_prid($products_id);
   // echo $products_id;
		if ($i != $products_id){
			$i = tep_get_attributes_id($i);
			//if(tep_session_is_registered('is_retail_store') || (tep_session_is_registered('retail_rep') && $_SESSION['retail_rep'] != '')){
			if(function_exists('tep_session_is_registered') && (tep_session_is_registered('is_retail_store') || (tep_session_is_registered('retail_rep') && $_SESSION['retail_rep'] != '')) ){
                            $stock_query = tep_db_query("select products_attributes_retail_units as products_quantity, only_linked_options from ".TABLE_PRODUCTS_ATTRIBUTES . " where products_id = '".(int)$products_id."' and options_values_id = '".$i."' and product_attributes_status = '1'");
                        }else{
                            $stock_query = tep_db_query("select products_attributes_units as products_quantity, only_linked_options from ".TABLE_PRODUCTS_ATTRIBUTES . " where products_id = '".(int)$products_id."' and options_values_id = '".$i."' and product_attributes_status = '1'");
                        }
						
						if (!tep_db_num_rows($stock_query) && $amazon_flag){
                            $stock_query = tep_db_query("select products_attributes_units as products_quantity, only_linked_options from ".TABLE_PRODUCTS_ATTRIBUTES . " where products_id = '".(int)$products_id."' and options_values_id = '".$i."'");
						}
						if (!tep_db_num_rows($stock_query)){
							return 0;
						}
                        $stock_values = tep_db_fetch_array($stock_query);

                        //linked options
                        //echo "select linked_options_quantity, products_attributes_units from linked_products_options l, products_attributes pa where l.child_products_id = pa.products_id and l.child_options_id = pa.options_id and l.child_options_values_id = pa.options_values_id and l.parent_products_id = '".(int)$products_id."' and parent_options_values_id = '".$i."' and product_attributes_status = '1'";
                        //if($stock_values['only_linked_options'] == 1 && (!tep_session_is_registered('is_retail_store') && (!tep_session_is_registered('retail_rep') && $_SESSION['retail_rep'] == ''))){
                        if($stock_values['only_linked_options'] == 1 && (!function_exists('tep_session_is_registered') || (function_exists('tep_session_is_registered') && !tep_session_is_registered('is_retail_store') && (!tep_session_is_registered('retail_rep') && $_SESSION['retail_rep'] == '')) ) ){
                            //$linked_options_query = tep_db_query("select linked_options_quantity, products_attributes_units from linked_products_options l, products_attributes pa where l.child_products_id = pa.products_id and l.child_options_id = pa.options_id and l.child_options_values_id = pa.options_values_id and l.parent_products_id = '".(int)$products_id."' and parent_options_values_id = '".$i."' and product_attributes_status = '1'");
                            $linked_options_query = tep_db_query("select product_attributes_status, linked_options_quantity, products_attributes_units from linked_products_options l, products_attributes pa where l.child_products_id = pa.products_id and l.child_options_id = pa.options_id and l.child_options_values_id = pa.options_values_id and l.parent_products_id = '".(int)$products_id."' and parent_options_values_id = '".$i."' ");
                            //if(tep_db_num_rows($linked_options_query)  && (!tep_session_is_registered('is_retail_store') && (!tep_session_is_registered('retail_rep') && $_SESSION['retail_rep'] == ''))){
                            if(tep_db_num_rows($linked_options_query)  && ( !function_exists('tep_session_is_registered') || (!tep_session_is_registered('is_retail_store') && (!tep_session_is_registered('retail_rep') && $_SESSION['retail_rep'] == '')) ) ){
                                $min_linked_qty_left = NULL;
                                while($linked_options_array = tep_db_fetch_array($linked_options_query)){
                                    
                                    if($linked_options_array['product_attributes_status'] == '0'){
                                        $linked_options_array['products_attributes_units'] = 0; 
                                    }
                                    
                                    if($linked_options_array['linked_options_quantity'] == 0 ){
                                        $min_linked_qty_left = 0;
                                        break;
                                    }else{
                                        $linked_option_qty = floor($linked_options_array['products_attributes_units']/$linked_options_array['linked_options_quantity']);    
                                        if(is_null($min_linked_qty_left)){
                                            $min_linked_qty_left = (int)$linked_option_qty;
                                        }elseif((int)$min_linked_qty_left > (int)$linked_option_qty ){
                                            $min_linked_qty_left = (int)$linked_option_qty;
                                        }

                                    }

                                    /*elseif($linked_options_array['linked_options_quantity']>0 && $linked_options_array['products_attributes_units']/$linked_options_array['linked_options_quantity']<$stock_values['products_quantity']){
                                        $stock_values['products_quantity'] = floor($linked_options_array['products_attributes_units']/$linked_options_array['linked_options_quantity']);
                                    }*/
                                }
                                    $stock_values['products_quantity'] = $min_linked_qty_left;
                            }
                        }
		}else{
	    $stock_query = tep_db_query("select products_quantity from " . TABLE_PRODUCTS . " where products_id = '" . (int)$products_id . "'");
  	  $stock_values = tep_db_fetch_array($stock_query);
		}

    return $stock_values['products_quantity'];
  }


// Return a product ID from a product ID with attributes
  function tep_get_prid($uprid) {
    $pieces = explode('{', $uprid);

    return $pieces[0];
  }


  function tep_get_attributes_id($i, $number = 0){
	  preg_match_all("/\}([^\{]+)/", $i, $arr);

    return $arr[1][$number];
	}
	
	
	

function traceability_api_trigger($mt_user_app_id=0,$mt_action=0,$mt_event=0,$mt_location=0){
     header('Access-Control-Allow-Origin: *');
    $categoryArr=array();
	$categoryArr['status']='Success';
	$categoryArr['error']="";
	$categoryArr['data']=array();
    
    if (isset($_SERVER['HTTP_ORIGIN'])) {
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
    }
 
    // Access-Control headers are received during OPTIONS requests
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
 
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         
 
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers:        {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
 
        exit(0);
    }
     $postdata = file_get_contents("php://input");
    // if (isset($postdata)) {
        //$request = json_decode($postdata);
       
     $servername = "localhost";
        $username = "copyache_new";
        $password = ",&B.9X1G_yoC";
        $dbname = "copyache_10nov17";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
        
         $sql = "INSERT INTO mobile_traceability (mt_user_app_id, mt_action, mt_event, mt_location) VALUES ('".$mt_user_app_id."', '".$mt_action."', '".$mt_event."', '".$mt_location."')";
        $conn->query($sql);
        $conn->close(); 
     
     
}

function metaphysical_buy(){
    header('Access-Control-Allow-Origin: *');
    $categoryArr=array();
	$categoryArr['status']='Success';
	$categoryArr['error']="";
	$categoryArr['data']=array();
    
    if (isset($_SERVER['HTTP_ORIGIN'])) {
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
    }
 
    // Access-Control headers are received during OPTIONS requests
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
 
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         
 
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers:        {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
 
        exit(0);
    }
     $postdata = file_get_contents("php://input");
     if (isset($postdata)) {
        $request = json_decode($postdata);
        $category_buy = $request->category_buy;
        
     $servername = "localhost";
        $username = "copyache_new";
        $password = ",&B.9X1G_yoC";
        $dbname = "copyache_10nov17";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    
   
			        
			       
			        $categoryArr=array();
						$categoryArr['status']='Success';
						$categoryArr['error']="";
						$categoryArr['data']=array();
						$sql="select distinct p.products_id from products p, products_to_stones pts where pts.products_id = p.products_id and (pts.stone_name_id = ".$category_buy.") and p.products_status = 1 and (p.products_model like '%' or p.products_model like 'D%')";
						
						$result = $conn->query($sql);
						if ($result->num_rows > 0) {
							// output data of each row
							while($row = $result->fetch_assoc()) {
							    $productsIdsString.=$row['products_id'].',';
							    
							}
						}
						$prolist87= rtrim($productsIdsString,',');
      
     
      
						
						
					 	$sql="select p.products_image, pd.products_name, p.products_model, p.products_id from (products_description pd, products p) where p.products_status = '1' and p.products_id = pd.products_id and pd.language_id = '1' and p.products_id in (".$prolist87.")";
						$result = $conn->query($sql);
						if ($result->num_rows > 0) {
							// output data of each row
							while($row = $result->fetch_assoc()) {
								$cat1=array('category_id'=>$row['products_id'],'slider'=>1,'category_level'=>6,'category_name'=>$row['products_name'],'category_image'=>base_url.'images/'.$row['products_image'],'component'=>'product');
								array_push($categoryArr['data'],$cat1);
							}
						}
					 $conn->close(); 
					 
			        
   
     
						
     }	
            		
		 
    echo  json_encode($categoryArr);
}

function user_login(){
    header('Access-Control-Allow-Origin: *');
    $servername = "localhost";
    $username = "copyache_new";
    $password = ",&B.9X1G_yoC";
    $dbname = "copyache_10nov17";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
     if (isset($_SERVER['HTTP_ORIGIN'])) {
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
    }
 
    // Access-Control headers are received during OPTIONS requests
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
 
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         
 
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers:        {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
 
        exit(0);
    }
     $postdata                  = file_get_contents("php://input");
    if (isset($postdata)) {
        $request                = json_decode($postdata);
        $email                  = trim($request->email);
        $password               = trim($request->password);
		$categoryArr			= array();
		$categoryArr['data']	= array();
		
		$sql                    = "SELECT * FROM `customers` WHERE `customers_email_address` LIKE '".$email."'";
		$result                 = $conn->query($sql);
		if ($result->num_rows > 0) {
		    while($row = $result->fetch_assoc()) {
			    
			    $password_check = compare_password($password,$row['customers_password']);
			    if($password_check==1){
			        $categoryArr['status']  = 'Success';
			        $userArr                = array('user_id'=>$row['customers_id']);
					array_push($categoryArr['data'],$userArr);
			        
			    }else{
			        $categoryArr['status']	= "error";
			        $categoryArr['error']	= "Incorrect Username/Password";
			    }
		    }
		}else{
		    $categoryArr['status']	= "error";
		    $categoryArr['error']	        = "Incorrect Username/Password";
		}
  
    }		
	   
	    echo  json_encode($categoryArr);
}

    //Password Encryption
    function customer_pass_encryption($plain){
        $password = '';
        for ($i=0; $i<10; $i++) {
            $password .= tep_rand();
        }
        $salt = substr(md5($password), 0, 2);
        $password = md5($salt . $plain) . ':' . $salt;
        return $password;
    }

    function tep_rand($min = null, $max = null) {
        static $seeded;
        if (!isset($seeded)) {
            $seeded = true;
           if ( (PHP_VERSION < '4.2.0') ) {
              mt_srand((double)microtime()*1000000);
           }
        }
     
        if (isset($min) && isset($max)) {
            if ($min >= $max) {
              return $min;
            } else {
              return mt_rand($min, $max);
            }
          } else {
            return mt_rand();
          }
    }
    
    //Password comparison
    function compare_password($plain='', $encrypted='') {
        $result=0;
        if ($plain!='' && $encrypted!='') {
          $stack = explode(':', $encrypted);
          if (sizeof($stack) != 2) return false;
          if (md5($stack[1] . $plain) == $stack[0]) {
            $result= 1;
          }
        }
        return $result;
    }
    
    function user_register(){
        header('Access-Control-Allow-Origin: *');
        $servername = "localhost";
        $username = "copyache_new";
        $password = ",&B.9X1G_yoC";
        $dbname = "copyache_10nov17";
    
        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 
         if (isset($_SERVER['HTTP_ORIGIN'])) {
            header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
            header('Access-Control-Allow-Credentials: true');
            header('Access-Control-Max-Age: 86400');    // cache for 1 day
        }
     
        // Access-Control headers are received during OPTIONS requests
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
     
            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
                header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         
     
            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
                header("Access-Control-Allow-Headers:        {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
     
            exit(0);
        }
        $postdata                  = file_get_contents("php://input");
        if (isset($postdata)) {
            $request                = json_decode($postdata);
            // $confirmation= trim($request->confirmation);
            
            $firstname = trim($request->firstname);
            $lastname= trim($request->lastname);
            $password= trim($request->password);
            $email_address= trim($request->email_address);
            $telephone= trim($request->telephone);
            $company= trim($request->company);
            $street_address= trim($request->street_address);
            $suburb= trim($request->suburb);
            $city= trim($request->city);
            $state= trim($request->state);
            $postcode= trim($request->postcode);
            $country= trim($request->country);
            $company2= trim($request->company2);
            $street_address2= trim($request->street_address2);
            $suburb2= trim($request->suburb2);
            $city2= trim($request->city2);
            $state2= trim($request->state2);
            $postcode2= trim($request->postcode2);
            $country2= trim($request->country2);
            
           /* $firstname                  = 'damu@euphontec.com';
            $lastname='2';
            $password='3';
            $confirmation='4';
            $email_address='5';
            $telephone='6';
            $company='7';
            $street_address='8';
            $suburb='9';
            $city='1';
            $state='2';
            $postcode='3';
            $country='4';
            $company2='5';
            $street_address2='6';
            $suburb2='7';
            $city2='8';
            $state2='9';
            $postcode2='1';
            $country2='2';*/
            
            
    		$categoryArr			= array();
    		$categoryArr['data']	= array();
    		
        	$sql_check                    = "SELECT * FROM `customers` WHERE `customers_email_address` LIKE '".$email."'";
    		$results                 = $conn->query($sql_check);
    		if ($results->num_rows > 0) {
    		      $categoryArr['status']	= "error";
    		      $categoryArr['error']	= "Email Id already exists";
    		}else{
    		    $sql = "INSERT INTO customers (customers_firstname, customers_lastname, customers_email_address, customers_telephone, customers_password, password_updated, ip_address ) VALUES ('".$firstname."', '".$lastname."', '".$email_address."', '".$telephone."', '".customer_pass_encryption($password)."', '1','')";
                $conn->query($sql);
                $customer_id = $conn->insert_id;
                if($customer_id){
                    $sql1 = "INSERT INTO address_book (customers_id, entry_firstname, entry_lastname, entry_street_address, entry_postcode, entry_city, entry_country_id,entry_company,entry_suburb,entry_zone_id,entry_state ) VALUES ('".$customer_id."', '".$firstname."', '".$lastname."', '".$street_address."', '".$postcode."', '".$city."','".$country."','".$company."','".$suburb."','0','".$state."')";
                    $conn->query($sql1);
                    $address_id = $conn->insert_id;
                    
                    if($address_id){
                
                    $sql2 = "INSERT INTO address_book (customers_id, entry_firstname, entry_lastname, entry_street_address, entry_postcode, entry_city, entry_country_id,entry_company,entry_suburb,entry_zone_id,entry_state ) VALUES ('".$customer_id."', '".$firstname."', '".$lastname."', '".$street_address2."', '".$postcode2."', '".$city2."','".$country2."','".$company2."','".$suburb2."','0','".$state2."')";
                    $conn->query($sql2);
                    $address_id2 = $conn->insert_id;
                    }else{
                        $categoryArr['status']	= "error";
                    }
                    
                    if($address_id2){
                
                    $sql3 = "update customer set customers_default_address_id = '" .$address_id . "', customers_default_shipping_id = '".$address_id2."' where customers_id = '" . $customer_id . "'";
                    $conn->query($sql3);    
                
                    $sql4="insert into customers_info (customers_info_id, customers_info_number_of_logons, customers_info_date_account_created) values ('" .$customer_id . "', '0', now())";
                    $conn->query($sql4);
                    $categoryArr['status']	= "success";
                    }else{
                        $categoryArr['status']	= "error";
                    }
                }
                $conn->close(); 
    		}
		
		
    }		
	   
	    echo  json_encode($categoryArr);
        
    }
    
    
    
    function forgot_password(){
        
    }
    function contac_us(){
        
    }
   function countries(){
    
    header('Access-Control-Allow-Origin: *');
    $categoryArr=array();
	$categoryArr['status']='Success';
	$categoryArr['error']="";
	$categoryArr['data']=array();
    
    if (isset($_SERVER['HTTP_ORIGIN'])) {
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
    }
 
    // Access-Control headers are received during OPTIONS requests
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
 
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         
 
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers:        {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
 
        exit(0);
    }
     $postdata = file_get_contents("php://input");
     if (isset($postdata)) {
        $request = json_decode($postdata);
        $products_id = $request->products_id;
        
     $servername = "localhost";
        $username = "copyache_new";
        $password = ",&B.9X1G_yoC";
        $dbname = "copyache_10nov17";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    	$categoryArr=array();
		$categoryArr['status']='Success';
		$categoryArr['error']="";
		$categoryArr['data']=array();
    
    					
    $sql="SELECT * FROM countries";

						$result = $conn->query($sql);
						if ($result->num_rows > 0) {
							
							while($rows = $result->fetch_assoc()) {
								$cat1=array('countries_id'=>$rows['countries_id'],
								'countries_name'=>$rows['countries_name'],
								'countries_iso_code_2'=>$rows['countries_iso_code_2'],
								'countries_iso_code_3'=>$rows['countries_iso_code_3'],
								'address_format_id'=>$rows['address_format_id']);
								array_push($categoryArr['data'],$cat1);
							}
						}
     }
   
    $conn->close();
    echo  json_encode($categoryArr);
}

?>