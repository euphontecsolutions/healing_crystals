<?php
define("base_url", "http://test.healingcrystals.com/"); 
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
     $servername = "localhost";
   $username = "healingt_user";
   $password = "Madept";
   $dbname = "healint_new";

   $conn = new mysqli($servername, $username, $password, $dbname);

   if ($conn->connect_error) {
       die("Connection failed: " . $conn->connect_error);
} 
   $conn = new mysqli($servername, $username, $password, $dbname);
   header('Access-Control-Allow-Origin: *');
$slideOneArr=array();
$slideOneArr['status']='Success';
$slideOneArr['error']="";
$slideOneArr['data']=array();
/*../images_heal_new/homepage/*/
$sql  = "SELECT * FROM `intro_slider` order by `is_sort` ASC, `is_date` DESC";
$result = $conn->query($sql);

foreach ($result as $var) {

$slide1=array('slide_id'=>$var['is_id'],'slide_date'=>$var['is_date'],'slide_text'=>$var['is_text'],'url'=>base_url.$var['is_image_url']);
array_push($slideOneArr['data'],$slide1);
}


 echo  json_encode($slideOneArr);
 }

function crystals_information(){
	    $servername = "localhost";
        $username = "healingt_user";
        $password = "Madept";
        $dbname = "healint_new";

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
    }
    
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
	$cat2=array('category_id'=>2,'category_level'=>1,'slider'=>2,'category_name'=>'Store Catalog','component'=>'category',"image_url"=>base_url.api_path."images/category/catg_image_2.jpg");
	$cat3=array('category_id'=>3,'category_level'=>1,'slider'=>3,'category_name'=>'Metaphysical Guide','component'=>'mpdp',"image_url"=>base_url.api_path."images/category/catg_image_3.jpg");
	$cat4=array('category_id'=>4,'category_level'=>1,'slider'=>4,'category_name'=>'Crystal Formations Guide','component'=>'category',"image_url"=>base_url.api_path."images/category/catg_image_4.jpg");
	$cat5=array('category_id'=>5,'category_level'=>1,'slider'=>5,'category_name'=>'Crystals by Color','component'=>'category',"image_url"=>base_url.api_path."images/category/catg_image_5.jpg");
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
        $username = "healingt_user";
        $password = "Madept";
        $dbname = "healint_new";

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
        $category_id = trim($request->category_id);
		$category_level = $request->category_level;
		$slider = $request->slider;
		$tag_id = $request->tag_id;
		$category_buy = $request->category_buy;
		$current_page = $request->current_page;
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
						
							
							
							
							
							$listing_sql = "SELECT a2t.*,ad.articles_url, a.articles_id, a.authors_id, a.articles_date_added, ad.articles_name, ad.articles_head_desc_tag, ad.articles_description, au.authors_name, sn.detailed_mpd,sn.stone_name_id, a2t.topics_id, SUBSTRING( ad.articles_name ,1 ,1) AS start_letter FROM (articles a, articles_description ad, articles_to_topics a2t) LEFT JOIN authors au ON a.authors_id = au.authors_id LEFT JOIN stone_names sn ON a.articles_id = sn.summary_mpd WHERE (a.articles_date_available IS NULL OR to_days(a.articles_date_available) <= to_days(now())) AND a.articles_status = '1' AND a.articles_id = a2t.articles_id AND ad.articles_id = a2t.articles_id AND ad.language_id = '1' AND a2t.topics_id = '3' AND sn.detailed_mpd=".$row_one['detailed_mpd']." GROUP BY a.articles_id ORDER BY ad.articles_name limit 50";
        
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
					$pro_array[$i] = substr($pro_array[$i], 0, -1);
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
            				'buy_status'    =>product_availability(trim($rows['stone_name_id'])),
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
					 
					 //Stone name
							$sql="select p.products_id,p.products_image,pts.stone_name_id, stone_name,s.detailed_mpd, count(p.products_id) as count from products_to_stones pts, stone_names s, products p where s.stone_name_id = pts.stone_name_id and pts.products_id = p.products_id and p.products_status = 1 and (p.products_model like '%' or p.products_model like 'D%') and pts.stone_name_id in (select st.stone_name_id from stone_tags st, taglist tl where st.tag_id = tl.tag_id and tl.tag_id = '".$category_id."') group by stone_name_id order by stone_name ASC ";
						$result_stone = $conn->query($sql);
						if ($result_stone->num_rows > 0) {
							while($row_stone = $result_stone->fetch_assoc()) {
							   $stone_name = $row_stone['stone_name'];
							}
						}
						
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
				}elseif($array1['property_id'] == '11'){
                                                    $pro_array[$array1['property_id']] .=  $tag_display_name .', ' ;
                                                }elseif($array1['property_id'] == '9'){
                                                    $psp_query = "select * from products_specific_property psp, products p, products_attributes pa where psp.products_id = p.products_id and pa.products_id = p.products_id and psp.property_value like '".trim($tag_display_name)."' and psp.property_name LIKE '%location%' and p.products_status = '1' and pa.product_attributes_status = '1' group by p.products_id";
                                                    $psp_query = $conn->query($psp_query);
                                                    if($psp_query->num_rows > 0){
                                                        $pro_array['9'] .=  $tag_display_name.',';
                                                        
                                                    }                                                    
                                                }elseif($array1['property_id'] == '4'){
                                                    $get_property_stone_id_query = "SELECT `stone_properties_id` FROM `stone_properties` WHERE `stone_name_id` = '".$stone_name_ids."' and `property_id` = '4' and `property_value` like '%".$array1['tag_name']."%' limit 1"; 
                                                    $get_property_stone_id_query = $conn->query($get_property_stone_id_query);
                                                    if($get_property_stone_id_query->num_rows > 0){
                                                        $pro_array['4'] .=  $tag_display_name.',';
                                                    }     
                                                    
                                                }else{
                                                    $pro_array[$array1['property_id']] .=  $tag_display_name.',';						
                                                }
			}
			for($i = 1; $i<= 23; $i++){
				if($i != 22 || $i != 23){
					$pro_array[$i] = substr($pro_array[$i], 0, -1);
				}
				/*$property_query = "select property_value from stone_properties where property_id = '" . (int)$i . "' and language_id = '1' and stone_name_id='".$stone_name_ids."'";
    			$property = $conn->query($property_query);
				while($array1 = $property->fetch_assoc()){
						$pro_array[$i] =$array1['property_value'];
				}*/
			}
				if($stone_name!=''){
			$pro_final_string.='Stone Name - '.$stone_name.',,';
			}
			if($pro_array[22]!=''){
			$pro_final_string.='Alternate Stone Name #1 - '. $pro_array[22].',,';
			}
			if($pro_array[23]!=''){
			$pro_final_string.='Alternate Stone Name #2 - '. $pro_array[23].',,';
			}
			if($pro_array[2]!=''){
			$pro_final_string.='Primary Chakra - '.$pro_array[2].',,';
			}
			if($pro_array[12]!=''){
			$pro_final_string.='Secondary Chakra - '. $pro_array[12].',,';
			}
			if($pro_array[3]!=''){
			$pro_final_string.='Crystal System - '. $pro_array[3].',,';
			}
			if($pro_array[4]!=''){
			    $pro_array[4] = str_replace('_', ' ', $pro_array[4]);
			$pro_final_string.='Chemical Composition - '. $pro_array[4].',,';
			}
			if($pro_array[5]!=''){
			$pro_final_string.='Astrological Sign - '.$pro_array[5].',,';
			}
			if($pro_array[6]!=''){
			$pro_final_string.='Numerical Vibration - '. $pro_array[6].',,';
			}
			if($pro_array[7]!=''){
			$pro_final_string.='Hardness - '.$pro_array[7].',,';
			}
			if($pro_array[8]!=''){
			$pro_final_string.='Color - '. preg_replace('/[^(\x20-\x7F)]*/','',$pro_array[8]).',,';
			}
			if($pro_array[9]!=''){
			$pro_final_string.='Location - '. $pro_array[9].',,';
			}
			if($pro_array[10]!=''){
			$pro_final_string.='Rarity - '.$pro_array[10].',,';
			}
			if($pro_array[11]!=''){
			$pro_final_string.='Pronunciation - '. $pro_array[11].',,';
			}
			if($pro_array[13]!=''){
			$pro_final_string.='Mineral Class - '.$pro_array[13].',,';
			}
			if($pro_array[14]!=''){
			$pro_final_string.='Common Conditions (Physical) - '. $pro_array[14].',,';
			}
			if($pro_array[15]!=''){
			 $pro_final_string.='Common Conditions (Emotional) - '. $pro_array[15].',,';
			}
			if($pro_array[16]!=''){
			 $pro_final_string.='Common Conditions (Spiritual) - '. $pro_array[16].',,';
			}
			if($pro_array[17]!=''){
			 $pro_final_string.='Extra Grade - '. $pro_array[17].',,';
			}
			if($pro_array[18]!=''){
			 $pro_final_string.='A Grade - '. $pro_array[18].',,';
			}
			if($pro_array[19]!=''){
			 $pro_final_string.='B Grade - '. $pro_array[19].',,';
			}
			if($pro_array[20]!=''){
			 $pro_final_string.='Affirmation - '. $pro_array[20].',,';
			}
			if($pro_array[21]!=''){
			  $pro_final_string.='Question - '. $pro_array[21];
			}
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
				    $totalPriceArr=array();
						$categoryArr['status']='Success';
						$categoryArr['error']="";
						$categoryArr['data']=array();
				    
				    	$sql="select distinct p.products_id from products p, products_to_stones pts where pts.products_id = p.products_id and (pts.stone_name_id = ".$category_id.") and p.products_status = 1 and (p.products_model like '%' or p.products_model like 'D%')";
						$productsIdsString='';
						$result = $conn->query($sql);
						if ($result->num_rows > 0) {
							// output data of each row
							while($row = $result->fetch_assoc()) {
							    $productsIdsString.=$row['products_id'].',';
							    
							}
						}
						$prolist87= rtrim($productsIdsString,',');
					    $prolist87 = explode(',',$prolist87);
					    foreach($prolist87 as $value){
					        if(tep_get_product_quantity($value) === false)
					        continue;
					        $prolist99 .= $value.','; 
					    }
					    $prolist99 = substr($prolist99,0,-1);					    
					    $productsIdsString = $prolist99;
						
						
					 	$sql="select p.products_image, pd.products_name, p.products_model, p.products_id from (products_description pd, products p) where p.products_status = '1' and p.products_id = pd.products_id and pd.language_id = '1' and p.products_id in (".$productsIdsString.")";
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
						
						
						//Stone name
							$sql="select p.products_id,p.products_image,pts.stone_name_id, stone_name,s.detailed_mpd, count(p.products_id) as count from products_to_stones pts, stone_names s, products p where s.stone_name_id = pts.stone_name_id and pts.products_id = p.products_id and p.products_status = 1 and (p.products_model like '%' or p.products_model like 'D%') and pts.stone_name_id in (select st.stone_name_id from stone_tags st, taglist tl where st.tag_id = tl.tag_id and tl.tag_id = '".$category_id."') group by stone_name_id order by stone_name ASC ";
						$result_stone = $conn->query($sql);
						if ($result_stone->num_rows > 0) {
							while($row_stone = $result_stone->fetch_assoc()) {
							   $stone_name = $row_stone['stone_name'];
							}
						}
						
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
				}elseif($array1['property_id'] == '11'){
                                                    $pro_array[$array1['property_id']] .=  $tag_display_name .', ' ;
                                                }elseif($array1['property_id'] == '9'){
                                                    $psp_query = "select * from products_specific_property psp, products p, products_attributes pa where psp.products_id = p.products_id and pa.products_id = p.products_id and psp.property_value like '".trim($tag_display_name)."' and psp.property_name LIKE '%location%' and p.products_status = '1' and pa.product_attributes_status = '1' group by p.products_id";
                                                    $psp_query = $conn->query($psp_query);
                                                    if($psp_query->num_rows > 0){
                                                        $pro_array['9'] .=  $tag_display_name.',';
                                                        
                                                    }                                                    
                                                }elseif($array1['property_id'] == '4'){
                                                    $get_property_stone_id_query = "SELECT `stone_properties_id` FROM `stone_properties` WHERE `stone_name_id` = '".$stone_name_ids."' and `property_id` = '4' and `property_value` like '%".$array1['tag_name']."%' limit 1"; 
                                                    $get_property_stone_id_query = $conn->query($get_property_stone_id_query);
                                                    if($get_property_stone_id_query->num_rows > 0){
                                                        $pro_array['4'] .=  $tag_display_name.',';
                                                    }     
                                                    
                                                }else{
                                                    $pro_array[$array1['property_id']] .=  $tag_display_name.',';						
                                                }
			}
			for($i = 1; $i<= 23; $i++){
				if($i != 22 || $i != 23){
					$pro_array[$i] = substr($pro_array[$i], 0, -1);
				}
				/*$property_query = "select property_value from stone_properties where property_id = '" . (int)$i . "' and language_id = '1' and stone_name_id='".$stone_name_ids."'";
    			$property = $conn->query($property_query);
				while($array1 = $property->fetch_assoc()){
						$pro_array[$i] =$array1['property_value'];
				}*/
			}
			if($stone_name!=''){
			$pro_final_array['Stone Name']= $stone_name;
			}
			if($pro_array[22]!=''){
			$pro_final_array['Alternate Stone Name #1']= $pro_array[22];
			}
			if($pro_array[23]!=''){
			$pro_final_array['Alternate Stone Name #2']= $pro_array[23];
			}
			if($pro_array[2]!=''){
			$pro_final_array['Primary Chakra']= $pro_array[2];
			}
			if($pro_array[12]!=''){
			$pro_final_array['Secondary Chakra']= $pro_array[12];
			}
			if($pro_array[3]!=''){
			$pro_final_array['Crystal System']= $pro_array[3];
			}
			if($pro_array[4]!=''){
			    $pro_array[4] = str_replace('_', ' ', $pro_array[4]);
			$pro_final_array['Chemical Composition']= $pro_array[4];
			}
			if($pro_array[5]!=''){
			$pro_final_array['Astrological Sign']= $pro_array[5];
			}
			if($pro_array[6]!=''){
			$pro_final_array['Numerical Vibration']= $pro_array[6];
			}
			if($pro_array[7]!=''){
			$pro_final_array['Hardness']= $pro_array[7];
			}
			if($pro_array[8]!=''){
			$pro_final_array['Color']= preg_replace('/[^(\x20-\x7F)]*/','',$pro_array[8]);
			}
			if($pro_array[9]!=''){
			$pro_final_array['Location']= $pro_array[9];
			}
			if($pro_array[10]!=''){
			$pro_final_array['Rarity']= $pro_array[10];
			}
			if($pro_array[11]!=''){
			$pro_final_array['Pronunciation']= $pro_array[11];
			}
			if($pro_array[13]!=''){
			$pro_final_array['Mineral Class']= $pro_array[13];
			}
			if($pro_array[14]!=''){
			$pro_final_array['Common Conditions (Physical)']= $pro_array[14];
			}
			if($pro_array[15]!=''){
			 $pro_final_array['Common Conditions (Emotional)']= $pro_array[15];
			}
			if($pro_array[16]!=''){
			 $pro_final_array['Common Conditions (Spiritual)']= $pro_array[16];
			}
			if($pro_array[17]!=''){
			 $pro_final_array['Extra Grade']= $pro_array[17];
			}
			if($pro_array[18]!=''){
			 $pro_final_array['A Grade']= $pro_array[18];
			}
			if($pro_array[19]!=''){
			 $pro_final_array['B Grade']= $pro_array[19];
			}
			if($pro_array[20]!=''){
			 $pro_final_array['Affirmation']= $pro_array[20];
			}
			if($pro_array[21]!=''){
			  $pro_final_array['Question']= $pro_array[21];
			}
		}
	}
}
						
						
						
						
						
						
						
						
						//END of properties
						$sql="select * from products p, products_description pd where p.products_id = '".$category_id."' and pd.products_id = p.products_id and pd.language_id = '1'";
					
						$property_result = $conn->query($sql);
						if ($property_result->num_rows > 0) {
						    $totalPriceArr=array();
							// output data of each row
							while($row = $property_result->fetch_assoc()) {
							    
							    
							    //---------------------------------PRICE-----------------------------------------------
							    
							    
							    
							    //---------------------------------PRICE-----------------------------------------------
							    if ($row['products_price'] != '0'){
							        $add_price = $row['products_price'];
							    }else{
							        $add_price = 0;
							    }
							    
							    $products_options_sql ="select pov.products_options_values_id, pov.products_options_values_name, pa.products_attributes_name, products_attributes_units, products_attributes_retail_units, only_linked_options, pa.options_values_price, pa.price_prefix, pa.products_attributes_special_price, pa.special_end_date, pa.special_start_date, pa.product_attribute_qty_1, pa.product_attribute_price_1, pa.product_attribute_qty_2, pa.product_attribute_price_2, pa.product_attribute_qty_3, pa.product_attribute_price_3, pa.product_attribute_qty_4, pa.product_attribute_price_4, pa.product_attribute_qty_5, pa.product_attribute_price_5, product_attribute_spe_price_1, product_attribute_spe_price_2, product_attribute_spe_price_3, product_attribute_spe_price_4, product_attribute_spe_price_5, items_per_unit, selling_unit_type, only_linked_options from products_attributes pa, products_options_values pov where pa.products_id = '".$category_id."' and pa.options_id = '1' and pa.options_values_id = pov.products_options_values_id and pov.language_id = '1' and pa.product_attributes_status = '1' and pa.options_values_price IS NOT NULL order by pa.products_options_sort_order
";
							    $results = $conn->query($products_options_sql);
							    if ($results->num_rows > 0) {
							        
							        while($products_options_values = $results->fetch_assoc()) {
							            
							            //product quantity
							        
							        $linked_product_query="select child_products_id , child_options_id, child_options_values_id, linked_options_quantity from linked_products_options where parent_products_id = '".$category_id."' and parent_options_id = '1' and parent_options_values_id ='".$products_options_values['products_options_values_id']."'";
							       $linked_product_query = $conn->query($linked_product_query);
							        if ($linked_product_query->num_rows > 0) {
							        
    							        while($linked_product = $linked_product_query->fetch_assoc()) {
    							          
    							            $uprid=$category_id.'{1}'.$products_options_values['products_options_values_id'];
                                    	$linked_product_qty=tep_get_products_stock($uprid);

                                            if($products_options_values['only_linked_options']=='1'&& $linked_product_qty>0){
                                                    $limited_qty='';
                                                    $products_options_values['products_attributes_units'] = $linked_product_qty;
                                            }
    							            
    							            
    							        }
							        }
							          if($products_options_values['products_attributes_units']>0){
							            if($products_options_values['product_attribute_price_1']>0){
							            if($products_options_values['products_attributes_special_price']>0){
							                $strick = '<strike>$'.number_format($products_options_values['options_values_price'], 2, '.', '').'</strike>';
							            }
							            //-----------------
							               $attribute_1    ='1 -'. ($products_options_values['product_attribute_qty_1'] == '' ? ' or more' : $products_options_values['product_attribute_qty_1'].' pc -').$strick.' $'.$products_options_values['product_attribute_price_1']. 'ea';
							            }
							            
							            if($products_options_values['product_attribute_price_2']>0){
							                
							                 //percentage
							            $special_saving = number_format(((($products_options_values['product_attribute_price_2']-$products_options_values['products_attributes_special_price'])/$products_options_values['options_values_price'])*100),0);
							            $special_saving =100-$special_saving;
							            if($special_saving!=100 && $special_saving!=0){
							               $special_saving ="(Save ".$special_saving." % )";
							            }
							                
							            $attribute_2    =$special_saving. ($products_options_values['product_attribute_qty_1']+1).'-'. ($products_options_values['product_attribute_qty_2'] == '' ? ' or more' : $products_options_values['product_attribute_qty_2'].' pc -').$strick.' $'.$products_options_values['product_attribute_price_2']. 'ea';
							           }
							            
							            if($products_options_values['product_attribute_price_3']>0){
							                
							                 $special_saving = number_format(((($products_options_values['product_attribute_price_3']-$products_options_values['products_attributes_special_price'])/$products_options_values['options_values_price'])*100),0);
							                 $special_saving =100-$special_saving;
							            if($special_saving!=100 && $special_saving!=0){
							               $special_saving ="(Save ".$special_saving." % )";
							            }
							             
							              $attribute_3    =$special_saving.($products_options_values['product_attribute_qty_2']+1).'-'. ($products_options_values['product_attribute_qty_3'] == '' ? ' or more' : $products_options_values['product_attribute_qty_3'].' pc -').$strick.' $'.$products_options_values['product_attribute_price_3']. 'ea';
							            }
							            
							            if($products_options_values['product_attribute_price_4']>0){
							                
							                 $special_saving = number_format(((($products_options_values['product_attribute_price_4']-$products_options_values['products_attributes_special_price'])/$products_options_values['options_values_price'])*100),0);
							                 $special_saving =100-$special_saving;
							            if($special_saving!=100 && $special_saving!=0){
							               $special_saving ="(Save ".$special_saving." % )";
							            }
							            
							              $attribute_4    = $special_saving. ($products_options_values['product_attribute_qty_3']+1).'-'.($products_options_values['product_attribute_qty_4'] == '' ? ' or more' : $products_options_values['product_attribute_qty_4'].' pc -'). $strick.' $'.$products_options_values['product_attribute_price_4']. ' ea';
							           }
							            
							            if($products_options_values['product_attribute_price_5']>0){
							                $special_saving = number_format(((($products_options_values['product_attribute_price_5']-$products_options_values['products_attributes_special_price'])/$products_options_values['options_values_price'])*100),0);
							                 $special_saving =100-$special_saving;
							            if($special_saving!=100 && $special_saving!=0){
							               $special_saving ="(Save ".$special_saving." % )";
							            }
							               $attribute_5    =  $special_saving. ($products_options_values['product_attribute_qty_4']+1).'-'.($products_options_values['product_attribute_qty_5'] == '' ? ' or more' : $products_options_values['product_attribute_qty_5'].' pc -'). $strick.' $'.$products_options_values['product_attribute_price_5']. ' ea';
							             }
							            
							            //------------------
							            
							            $products_attributes_name=$products_options_values['products_attributes_name'];
							            
							            $priceArr   = array('heading'=>$products_attributes_name,
							            'save'=>$attribute_1.'<br>'.$attribute_2.'<br>'.$attribute_3.'<br>'.$attribute_4.'<br>'.$attribute_5.'<br>'.($products_options_values['products_attributes_units'] < 15 ? '*Limited Quantity - '.$products_options_values['products_attributes_units'].' units left in Stock' : ''),
							            'price'=>number_format($products_options_values['options_values_price'], 2, '.', ''),'quantity'=>$products_options_values['products_attributes_units'],'option_value'=>$products_options_values['products_options_values_id']);
							            
							            array_push($totalPriceArr,$priceArr);
							          }
							          
							        }
							        
							    }
							    //-----------------------------------------------------------------------------------------
							   
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
								'component'=>'product',
								'purchase_option'=>$totalPriceArr);
								
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
				
					if($category_id==2){
						$cat1=array('category_id'=>'A','slider'=>2,'category_level'=>2,'category_name'=>'Assortments','component'=>'products');
						$cat2=array('category_id'=>'C','slider'=>2,'category_level'=>2,'category_name'=>'Cut & Polish Crystals','component'=>'category');
						$cat3=array('category_id'=>'J','slider'=>2,'category_level'=>2,'category_name'=>'Crystal Jewelry','component'=>'category');
						$cat4=array('category_id'=>'N','slider'=>2,'category_level'=>2,'category_name'=>'Natural Crystals & Minerals','component'=>'category');
						$cat5=array('category_id'=>'NQ','slider'=>2,'category_level'=>2,'category_name'=>'Quartz Crystals','component'=>'category');
						$cat6=array('category_id'=>'T','slider'=>2,'category_level'=>2,'category_name'=>'Tumbled Stone & Gemstones','component'=>'category');
						$cat7=array('category_id'=>'V','slider'=>2,'category_level'=>2,'category_name'=>'Other/Accessories','component'=>'products');
						$cat8=array('category_id'=>'O','slider'=>2,'category_level'=>2,'category_name'=>'On Sale Today','component'=>'products');
						$cat9=array('category_id'=>'BS','slider'=>2,'category_level'=>2,'category_name'=>'Best Sellers','component'=>'category');
						
						array_push($categoryArr['data'],$cat1);
						array_push($categoryArr['data'],$cat2);
						array_push($categoryArr['data'],$cat3);
						array_push($categoryArr['data'],$cat4);
						array_push($categoryArr['data'],$cat5);
						array_push($categoryArr['data'],$cat6);
						array_push($categoryArr['data'],$cat7);
						array_push($categoryArr['data'],$cat8);
						array_push($categoryArr['data'],$cat9);
					
					}
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
					    $prolist87 = explode(',',$prolist87);
					    foreach($prolist87 as $value){
					        if(tep_get_product_quantity($value) === false)
					        continue;
					        $prolist99 .= $value.','; 
					    }
					    $prolist99 = substr($prolist99,0,-1);					    
					   $productsIdsString = $prolist99;
					    
					    $sql="select p.products_image, pd.products_name, p.products_model, p.products_id from (products_description pd, products p) where p.products_status = '1' and p.products_id = pd.products_id and pd.language_id = '1' and p.products_id in (".$productsIdsString.")";
						$result = $conn->query($sql);
						if ($result->num_rows > 0) {
							// output data of each row
							while($row = $result->fetch_assoc()) {
								$cat1=array('category_id'=>$row['products_id'],'slider'=>2,'category_level'=>4,'category_name'=>$row['products_name'],'category_image'=>base_url.'images/'.$row['products_image'],'component'=>'product');
								array_push($categoryArr['data'],$cat1);
							}
						}
					 $conn->close(); 
						
						
						
					
					}
					else if($category_id=='C'){
					    
					   $sql = "select psp.products_id, psp.property_value from products p, products_description pd, products_specific_property psp where p.products_status=1 and psp.products_id = p.products_id and pd.products_id = p.products_id and pd.language_id = '1' and lower(psp.property_name) = 'shape' and p.products_status = 1 and (p.products_model like 'C%' or p.products_model like 'DC%') order by property_value ASC";
					    
					    $result = $conn->query($sql);
					    if ($result->num_rows > 0) {
					        $propertyArr=array();
							while($row = $result->fetch_assoc()) {
							    if(tep_get_product_quantity($row['products_id'])>0){
							        
							        if (!in_array($row['property_value'], $propertyArr)){
							            array_push($propertyArr,$row['property_value']);
							            
							            $cat1=array('category_id'=>$row['property_value'],'slider'=>2,
            				'category_level'=>3,'category_name'=>$row['property_value'],
							    	'component'=>'products');
								array_push($categoryArr['data'],$cat1);
							        }
                                }
							}
						}
					    
					  
					 $conn->close(); 
					    
					}
					
						else if($category_id=='J'){
					    
					   $sql = "select psp.property_value, p.products_id, p.products_image, pd.products_name from products p, products_description pd, products_specific_property psp where psp.products_id = p.products_id and pd.products_id = p.products_id and pd.language_id = '1' and lower(psp.property_name) = 'shape' and p.products_status = 1 and p.products_model like 'J%' order by property_value ASC";
					    
					    $result = $conn->query($sql);
					    if ($result->num_rows > 0) {
					        $propertyArr=array();
							while($row = $result->fetch_assoc()) {
							    if(tep_get_product_quantity($row['products_id'])>0){
							        
							        if (!in_array($row['property_value'], $propertyArr)){
							            array_push($propertyArr,$row['property_value']);
							            
							            $cat1=array('category_id'=>$row['property_value'],'slider'=>2,
            				'category_level'=>5,'category_name'=>$row['property_value'],
							    	'component'=>'products');
								array_push($categoryArr['data'],$cat1);
							        }
                                }
							}
						}
					    
					  
					 $conn->close(); 
					    
					}
				else if($category_id=='N'){
					    
					   $sql = "select psp.property_value, p.products_id, p.products_image, pd.products_name from products p, products_description pd, products_specific_property psp where psp.products_id = p.products_id and pd.products_id = p.products_id and pd.language_id = '1' and lower(psp.property_name) = 'shape' and p.products_status = 1 and (p.products_model like 'N%' or p.products_model like 'DN%') order by property_value ASC";
					    
					    $result = $conn->query($sql);
					    if ($result->num_rows > 0) {
					        $propertyArr=array();
							while($row = $result->fetch_assoc()) {
							    if(tep_get_product_quantity($row['products_id'])>0){
							        
							        if (!in_array($row['property_value'], $propertyArr)){
							            array_push($propertyArr,$row['property_value']);
							            
							            $cat1=array('category_id'=>$row['property_value'],'slider'=>2,
            				'category_level'=>6,'category_name'=>$row['property_value'],
							    	'component'=>'products');
								array_push($categoryArr['data'],$cat1);
							        }
                                }
							}
						}
					    
					  
					 $conn->close();
					}
						else if($category_id=='T'){ 
						    $sql = "select distinct p.products_id, sn.stone_name, sn.detailed_mpd, pts.stone_name_id from products p, products_to_stones pts, stone_names sn where sn.stone_name_id = pts.stone_name_id and pts.products_id = p.products_id and p.products_status = 1 and (p.products_model like 'T%' or p.products_model like 'DT%') order by stone_name ASC";
					    $stonesArray=array();
					    $result = $conn->query($sql);
					    if ($result->num_rows > 0) {
					        
							while($row = $result->fetch_assoc()) {
							    if(tep_get_product_quantity($row['products_id'])>0){
							        
							        $stonesArray[$row['stone_name_id']] = $row['stone_name'];
                                }
							}
						}
						
						$sql = "select sn.stone_name, sn.detailed_mpd, sn.stone_name_id from stone_names sn, stone_names sn2 where sn.stone_name_id = sn2.parent_stone_id order by sn.stone_name ASC";
					    
					    $result = $conn->query($sql);
					    if ($result->num_rows > 0) {
					        
							while($row = $result->fetch_assoc()) {
							   
							        
							        $stonesArray[$row['stone_name_id']] = $row['stone_name'];
                                
							}
						}
						
						$stonesArray = array_unique($stonesArray);
				  asort($stonesArray);
				 
					    if(!empty($stonesArray)){
					        foreach($stonesArray as $key=>$val){
					            $cat1=array('category_id'=>$key,'slider'=>2,
            				'category_level'=>8,'category_name'=>$val,
							    	'component'=>'products');
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
					    $prolist87 = explode(',',$prolist87);
					    foreach($prolist87 as $value){
					        if(tep_get_product_quantity($value) === false)
					        continue;
					        $prolist99 .= $value.','; 
					    }
					    $prolist99 = substr($prolist99,0,-1);					    
					    $productsIdsString = $prolist99;
					    
					    $sql="select p.products_image, pd.products_name, p.products_model, p.products_id from (products_description pd, products p) where p.products_status = '1' and p.products_id = pd.products_id and pd.language_id = '1' and p.products_id in (".$productsIdsString.")";
						$results = $conn->query($sql);
						if ($results->num_rows > 0) {
							// output data of each row
							while($rows = $results->fetch_assoc()) {
							    if(tep_get_product_quantity($rows['products_id'])>0){
								$cat1=array('category_id'=>$rows['products_id'],'slider'=>2,'category_level'=>4,'category_name'=>htmlentities($rows['products_name']),'category_image'=>base_url.'images/'.$rows['products_image'],'component'=>'product');
								array_push($categoryArr['data'],$cat1);
							    }
								
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
					    $prolist87 = explode(',',$prolist87);
					    foreach($prolist87 as $value){
					        if(tep_get_product_quantity($value) === false)
					        continue;
					        $prolist99 .= $value.','; 
					    }
					    $prolist99 = substr($prolist99,0,-1);					    
					    $productsIdsString = $prolist99;
					    
					    $sql="select p.products_image, pd.products_name, p.products_model, p.products_id from (products_description pd, products p) where p.products_status = '1' and p.products_id = pd.products_id and pd.language_id = '1' and p.products_id in (".$productsIdsString.")";
						$result = $conn->query($sql);
						if ($result->num_rows > 0) {
							// output data of each row
							while($row = $result->fetch_assoc()) {
								$cat1=array('category_id'=>$row['products_id'],'slider'=>2,'category_level'=>4,'category_name'=>$row['products_name'],'category_image'=>base_url.'images/'.$row['products_image'],'component'=>'product');
								array_push($categoryArr['data'],$cat1);
							}
						}
						//CUT & POLISHED CRYSTALS
						 $sql = "SELECT DISTINCT pa.products_attributes_id, pa.products_id, pa.products_attributes_model, pa.products_attributes_name, pd.products_name, pa.products_attributes_special_price, p.products_model, p.products_image FROM products_attributes AS pa LEFT JOIN products_description AS pd ON pd.products_id = pa.products_id LEFT JOIN products AS p ON p.products_id = pa.products_id	WHERE pd.language_id = '1' AND p.products_status = 1 AND pd.language_id = 1 AND pa.products_attributes_units > 0 AND (p.products_model LIKE 'DC%' or p.products_model LIKE 'C%' ) AND pa.products_attributes_special_price > 0 and special_start_date < now() and special_start_date != '0000-00-00 00:00:00'";
					    
					    $result = $conn->query($sql);
					    if ($result->num_rows > 0) {
							while($row = $result->fetch_assoc()) {
							    $productsIdsString.=$row['products_id'].',';
							    
							}
						}
					    $prolist87= rtrim($productsIdsString,',');
					    $prolist87 = explode(',',$prolist87);
					    foreach($prolist87 as $value){
					        if(tep_get_product_quantity($value) === false)
					        continue;
					        $prolist99 .= $value.','; 
					    }
					    $prolist99 = substr($prolist99,0,-1);					    
					    $productsIdsString = $prolist99;
					    
					    $sql="select p.products_image, pd.products_name, p.products_model, p.products_id from (products_description pd, products p) where p.products_status = '1' and p.products_id = pd.products_id and pd.language_id = '1' and p.products_id in (".$productsIdsString.")";
						$result = $conn->query($sql);
						if ($result->num_rows > 0) {
							// output data of each row
							while($row = $result->fetch_assoc()) {
								$cat1=array('category_id'=>$row['products_id'],'slider'=>2,'category_level'=>4,'category_name'=>$row['products_name'],'category_image'=>base_url.'images/'.$row['products_image'],'component'=>'product');
								array_push($categoryArr['data'],$cat1);
							}
						}
						
						//CRYSTAL JEWELRY
						 $sql = "SELECT DISTINCT pa.products_attributes_id, pa.products_id, pa.products_attributes_model, pa.products_attributes_name, pd.products_name, pa.products_attributes_special_price, p.products_model, p.products_image FROM products_attributes AS pa LEFT JOIN products_description AS pd ON pd.products_id = pa.products_id LEFT JOIN products AS p ON p.products_id = pa.products_id	WHERE pd.language_id = '1' AND p.products_status = 1 AND pd.language_id = 1 AND pa.products_attributes_units > 0 AND (p.products_model LIKE 'DJ%' or p.products_model LIKE 'J%' ) AND pa.products_attributes_special_price > 0 and special_start_date < now() and special_start_date != '0000-00-00 00:00:00'";
					    
					    $result = $conn->query($sql);
					    if ($result->num_rows > 0) {
							while($row = $result->fetch_assoc()) {
							    $productsIdsString.=$row['products_id'].',';
							    
							}
						}
					    $prolist87= rtrim($productsIdsString,',');
					    $prolist87 = explode(',',$prolist87);
					    foreach($prolist87 as $value){
					        if(tep_get_product_quantity($value) === false)
					        continue;
					        $prolist99 .= $value.','; 
					    }
					    $prolist99 = substr($prolist99,0,-1);					    
					    $productsIdsString = $prolist99;
					    
					    $sql="select p.products_image, pd.products_name, p.products_model, p.products_id from (products_description pd, products p) where p.products_status = '1' and p.products_id = pd.products_id and pd.language_id = '1' and p.products_id in (".$productsIdsString.")";
						$result = $conn->query($sql);
						if ($result->num_rows > 0) {
							// output data of each row
							while($row = $result->fetch_assoc()) {
								$cat1=array('category_id'=>$row['products_id'],'slider'=>2,'category_level'=>4,'category_name'=>$row['products_name'],'category_image'=>base_url.'images/'.$row['products_image'],'component'=>'product');
								array_push($categoryArr['data'],$cat1);
							}
						}
						
							//NATURAL CRYSTAL
						 $sql = "SELECT DISTINCT pa.products_attributes_id, pa.products_id, pa.products_attributes_model, pa.products_attributes_name, pd.products_name, pa.products_attributes_special_price, p.products_model, p.products_image FROM products_attributes AS pa LEFT JOIN products_description AS pd ON pd.products_id = pa.products_id LEFT JOIN products AS p ON p.products_id = pa.products_id	WHERE pd.language_id = '1' AND p.products_status = 1 AND pd.language_id = 1 AND pa.products_attributes_units > 0 AND (p.products_model LIKE 'DN%' or p.products_model LIKE 'N%' and products_model NOT LIKE 'NQ%') AND pa.products_attributes_special_price > 0 and special_start_date < now() and special_start_date != '0000-00-00 00:00:00' ";
					    
					    $result = $conn->query($sql);
					    if ($result->num_rows > 0) {
							while($row = $result->fetch_assoc()) {
							    $productsIdsString.=$row['products_id'].',';
							    
							}
						}
					    $prolist87= rtrim($productsIdsString,',');
					    $prolist87 = explode(',',$prolist87);
					    foreach($prolist87 as $value){
					        if(tep_get_product_quantity($value) === false)
					        continue;
					        $prolist99 .= $value.','; 
					    }
					    $prolist99 = substr($prolist99,0,-1);					    
					    $productsIdsString = $prolist99;
					    
					    $sql="select p.products_image, pd.products_name, p.products_model, p.products_id from (products_description pd, products p) where p.products_status = '1' and p.products_id = pd.products_id and pd.language_id = '1' and p.products_id in (".$productsIdsString.")";
						$result = $conn->query($sql);
						if ($result->num_rows > 0) {
							// output data of each row
							while($row = $result->fetch_assoc()) {
								$cat1=array('category_id'=>$row['products_id'],'slider'=>2,'category_level'=>4,'category_name'=>$row['products_name'],'category_image'=>base_url.'images/'.$row['products_image'],'component'=>'product');
								array_push($categoryArr['data'],$cat1);
							}
						}
						
						//QUARTZ CRYSTAL
						 $sql = "SELECT DISTINCT pa.products_attributes_id, pa.products_id, pa.products_attributes_model, pa.products_attributes_name, pd.products_name, pa.products_attributes_special_price, p.products_model, p.products_image FROM products_attributes AS pa LEFT JOIN products_description AS pd ON pd.products_id = pa.products_id LEFT JOIN products AS p ON p.products_id = pa.products_id	WHERE pd.language_id = '1' AND p.products_status = 1 AND pd.language_id = 1 AND pa.products_attributes_units > 0 AND (p.products_model LIKE 'DNQ%' or p.products_model LIKE 'NQ%' ) AND pa.products_attributes_special_price > 0 and special_start_date < now() and special_start_date != '0000-00-00 00:00:00'";
					    
					    $result = $conn->query($sql);
					    if ($result->num_rows > 0) {
							while($row = $result->fetch_assoc()) {
							    $productsIdsString.=$row['products_id'].',';
							    
							}
						}
					    $prolist87= rtrim($productsIdsString,',');
					    $prolist87 = explode(',',$prolist87);
					    foreach($prolist87 as $value){
					        if(tep_get_product_quantity($value) === false)
					        continue;
					        $prolist99 .= $value.','; 
					    }
					    $prolist99 = substr($prolist99,0,-1);					    
					    $productsIdsString = $prolist99;
					    
					    $sql="select p.products_image, pd.products_name, p.products_model, p.products_id from (products_description pd, products p) where p.products_status = '1' and p.products_id = pd.products_id and pd.language_id = '1' and p.products_id in (".$productsIdsString.")";
						$result = $conn->query($sql);
						if ($result->num_rows > 0) {
							// output data of each row
							while($row = $result->fetch_assoc()) {
								$cat1=array('category_id'=>$row['products_id'],'slider'=>2,'category_level'=>4,'category_name'=>$row['products_name'],'category_image'=>base_url.'images/'.$row['products_image'],'component'=>'product');
								array_push($categoryArr['data'],$cat1);
							}
						}
						
						//TUMBLED STONE
						 $sql = "SELECT DISTINCT pa.products_attributes_id, pa.products_id, pa.products_attributes_model, pa.products_attributes_name, pd.products_name, pa.products_attributes_special_price, p.products_model, p.products_image FROM products_attributes AS pa LEFT JOIN products_description AS pd ON pd.products_id = pa.products_id LEFT JOIN products AS p ON p.products_id = pa.products_id	WHERE pd.language_id = '1' AND p.products_status = 1 AND pd.language_id = 1 AND pa.products_attributes_units > 0 AND (p.products_model LIKE 'DT%' or p.products_model LIKE 'T%' ) AND pa.products_attributes_special_price > 0 and special_start_date < now() and special_start_date != '0000-00-00 00:00:00'";
					    
					    $result = $conn->query($sql);
					    if ($result->num_rows > 0) {
							while($row = $result->fetch_assoc()) {
							    $productsIdsString.=$row['products_id'].',';
							    
							}
						}
					    $prolist87= rtrim($productsIdsString,',');
					    $prolist87 = explode(',',$prolist87);
					    foreach($prolist87 as $value){
					        if(tep_get_product_quantity($value) === false)
					        continue;
					        $prolist99 .= $value.','; 
					    }
					    $prolist99 = substr($prolist99,0,-1);					    
					    $productsIdsString = $prolist99;
					    
					    $sql="select p.products_image, pd.products_name, p.products_model, p.products_id from (products_description pd, products p) where p.products_status = '1' and p.products_id = pd.products_id and pd.language_id = '1' and p.products_id in (".$productsIdsString.")";
						$result = $conn->query($sql);
						if ($result->num_rows > 0) {
							// output data of each row
							while($row = $result->fetch_assoc()) {
								$cat1=array('category_id'=>$row['products_id'],'slider'=>2,'category_level'=>4,'category_name'=>$row['products_name'],'category_image'=>base_url.'images/'.$row['products_image'],'component'=>'product');
								array_push($categoryArr['data'],$cat1);
							}
						}
						//Others
						 $sql = "SELECT DISTINCT pa.products_attributes_id, pa.products_id, pa.products_attributes_model, pa.products_attributes_name, pd.products_name, pa.products_attributes_special_price, p.products_model, p.products_image FROM products_attributes AS pa LEFT JOIN products_description AS pd ON pd.products_id = pa.products_id LEFT JOIN products AS p ON p.products_id = pa.products_id	WHERE pd.language_id = '1' AND p.products_status = 1 AND pd.language_id = 1 AND pa.products_attributes_units > 0 AND (p.products_model LIKE 'DV%' or p.products_model LIKE 'V%' ) AND pa.products_attributes_special_price > 0 and special_start_date < now() and special_start_date != '0000-00-00 00:00:00'";
					    
					    $result = $conn->query($sql);
					    if ($result->num_rows > 0) {
							while($row = $result->fetch_assoc()) {
							    $productsIdsString.=$row['products_id'].',';
							    
							}
						}
					    $prolist87= rtrim($productsIdsString,',');
					    $prolist87 = explode(',',$prolist87);
					    foreach($prolist87 as $value){
					        if(tep_get_product_quantity($value) === false)
					        continue;
					        $prolist99 .= $value.','; 
					    }
					    $prolist99 = substr($prolist99,0,-1);					    
					    $productsIdsString = $prolist99;
					    
					    $sql="select p.products_image, pd.products_name, p.products_model, p.products_id from (products_description pd, products p) where p.products_status = '1' and p.products_id = pd.products_id and pd.language_id = '1' and p.products_id in (".$productsIdsString.")";
						$result = $conn->query($sql);
						if ($result->num_rows > 0) {
							// output data of each row
							while($row = $result->fetch_assoc()) {
								$cat1=array('category_id'=>$row['products_id'],'slider'=>2,'category_level'=>4,'category_name'=>$row['products_name'],'category_image'=>base_url.'images/'.$row['products_image'],'component'=>'product');
								array_push($categoryArr['data'],$cat1);
							}
						}
					 $conn->close(); 
					}
					
					else if($category_id=='BS'){
					    
					    $cat1=array('category_id'=>'A','slider'=>2,'category_level'=>9,'category_name'=>'CRYSTAL & MINERAL ASSORTMENTS','component'=>'products');
					    $cat2=array('category_id'=>'C','slider'=>2,'category_level'=>9,'category_name'=>'CUT & POLISHED CRYSTALS','component'=>'products');
					    $cat3=array('category_id'=>'J','slider'=>2,'category_level'=>9,'category_name'=>'CRYSTAL JEWELRY','component'=>'products');
					    $cat4=array('category_id'=>'N','slider'=>2,'category_level'=>9,'category_name'=>'NATURAL CRYSTALS & MINERALS','component'=>'products');
					    $cat5=array('category_id'=>'NQ','slider'=>2,'category_level'=>9,'category_name'=>'QUARTZ CRYSTALS - CLEAR QUARTZ','component'=>'products');
					    $cat6=array('category_id'=>'T','slider'=>2,'category_level'=>9,'category_name'=>'TUMBLED STONES (GEMSTONES)','component'=>'products');
					    $cat7=array('category_id'=>'V','slider'=>2,'category_level'=>9,'category_name'=>'OTHER / ACCESSORIES','component'=>'products');
						array_push($categoryArr['data'],$cat1);
						array_push($categoryArr['data'],$cat2);
						array_push($categoryArr['data'],$cat3);
						array_push($categoryArr['data'],$cat4);
						array_push($categoryArr['data'],$cat5);
						array_push($categoryArr['data'],$cat6);
						array_push($categoryArr['data'],$cat7);
					   
					    
					   /**/
					}
					
					///
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
					     $sql = "select psp.property_value, p.products_id, p.products_image, pd.products_name from products p, products_description pd, products_specific_property psp, products_to_stones p2st where psp.products_id = p.products_id and pd.products_id = p.products_id and pd.language_id = '1' and lower(psp.property_name) = 'shape' and p.products_status = 1 and (p.products_model like 'N%' or p.products_model like 'DN%') and p2st.products_id = p.products_id and p2st.stone_name_id = '203' order by property_value ASC";
					    
					    $result = $conn->query($sql);
					    if ($result->num_rows > 0) {
					        $propertyArr=array();
							while($row = $result->fetch_assoc()) {
							    if(tep_get_product_quantity($row['products_id'])>0){
							        
							        if (!in_array($row['property_value'], $propertyArr)){
							            array_push($propertyArr,$row['property_value']);
							            
							            $cat1=array('category_id'=>$row['property_value'],'slider'=>2,
            				'category_level'=>7,'category_name'=>$row['property_value'],
							    	'component'=>'products');
								array_push($categoryArr['data'],$cat1);
							        }
                                }
							}
						}
					    
					  
					 $conn->close();
					    
					}
				}elseif($category_level==3){
				    	$cat1='';
					$cat2='';
					$cat3='';
					 
					$categoryArr			= array();
					$categoryArr['status']	= 'Success';
					$categoryArr['error']	= "";
					$categoryArr['data']	= array();
					  $sql = "select psp.property_value, p.products_id, p.products_image, pd.products_name from products p, products_description pd, products_specific_property psp where psp.products_id = p.products_id and pd.products_id = p.products_id and pd.language_id = '1' and lower(psp.property_name) = 'shape' and p.products_status = 1 and (p.products_model like 'C%' or p.products_model like 'DC%') and psp.property_value like '%".$category_id."%' order by property_value ASC";
					    
					    $result = $conn->query($sql);
					    if ($result->num_rows > 0) {
							while($row = $result->fetch_assoc()) {
							    if(tep_get_product_quantity($row['products_id'])>0){
							        $cat1=array('category_id'=>$row['products_id'],'slider'=>1,'category_level'=>6,'category_name'=>$row['products_name'],'category_image'=>base_url.'images/'.$row['products_image'],'component'=>'product');
    								array_push($categoryArr['data'],$cat1);
							}
							    
							}
						}
					    }elseif($category_level==5){
					        
				    	$cat1='';
					$cat2='';
					$cat3='';
					 
					$categoryArr			= array();
					$categoryArr['status']	= 'Success';
					$categoryArr['error']	= "";
					$categoryArr['data']	= array();
					
					  $sql = "select psp.property_value, p.products_id, p.products_image, pd.products_name from products p, products_description pd, products_specific_property psp where psp.products_id = p.products_id and pd.products_id = p.products_id and pd.language_id = '1' and lower(psp.property_name) = 'shape' and p.products_status = 1 and p.products_model like 'J%' and psp.property_value like '%".$category_id."%'  order by property_value ASC";
					    
					    $result = $conn->query($sql);
					    if ($result->num_rows > 0) {
							while($row = $result->fetch_assoc()) {
							    if(tep_get_product_quantity($row['products_id'])>0){
							        $cat1=array('category_id'=>$row['products_id'],'slider'=>1,'category_level'=>6,'category_name'=>$row['products_name'],'category_image'=>base_url.'images/'.$row['products_image'],'component'=>'product');
    								array_push($categoryArr['data'],$cat1);
							}
							    
							}
						}
					    }elseif($category_level==6){
					        
				    	$cat1='';
					$cat2='';
					$cat3='';
					 
					$categoryArr			= array();
					$categoryArr['status']	= 'Success';
					$categoryArr['error']	= "";
					$categoryArr['data']	= array();
					
					  $sql = "select psp.property_value, p.products_id, p.products_image, pd.products_name from products p, products_description pd, products_specific_property psp where psp.products_id = p.products_id and pd.products_id = p.products_id and pd.language_id = '1' and lower(psp.property_name) = 'shape' and p.products_status = 1 and (p.products_model like 'N%' or p.products_model like 'DN%') and psp.property_value like '%".$category_id."%'  order by property_value ASC";
					    
					    $result = $conn->query($sql);
					    if ($result->num_rows > 0) {
							while($row = $result->fetch_assoc()) {
							    if(tep_get_product_quantity($row['products_id'])>0){
							        $cat1=array('category_id'=>$row['products_id'],'slider'=>1,'category_level'=>6,'category_name'=>$row['products_name'],'category_image'=>base_url.'images/'.$row['products_image'],'component'=>'product');
    								array_push($categoryArr['data'],$cat1);
							}
							    
							}
						}
					    }elseif($category_level==7){
					        
				    	$cat1='';
					$cat2='';
					$cat3='';
					 
					$categoryArr			= array();
					$categoryArr['status']	= 'Success';
					$categoryArr['error']	= "";
					$categoryArr['data']	= array();
					
					  $sql = "select psp.property_value, p.products_id, p.products_image, pd.products_name from products p, products_description pd, products_specific_property psp, products_to_stones p2st where psp.products_id = p.products_id and pd.products_id = p.products_id and pd.language_id = '1' and lower(psp.property_name) = 'shape' and p.products_status = 1 and (p.products_model like 'N%' or p.products_model like 'DN%') and p2st.products_id = p.products_id and p2st.stone_name_id = '203' and psp.property_value like '%".$category_id."%'  order by property_value ASC";
					    
					    $result = $conn->query($sql);
					    if ($result->num_rows > 0) {
							while($row = $result->fetch_assoc()) {
							    if(tep_get_product_quantity($row['products_id'])>0){
							        $cat1=array('category_id'=>$row['products_id'],'slider'=>1,'category_level'=>6,'category_name'=>$row['products_name'],'category_image'=>base_url.'images/'.$row['products_image'],'component'=>'product');
    								array_push($categoryArr['data'],$cat1);
							}
							    
							}
						}
					    }elseif($category_level==8){
					        
					        $childStoneIdsArray = getChildStonesIds($category_id);
					        if (!empty($childStoneIdsArray)) {
					            $childStoneStr = " or (pts.stone_name_id in (" . implode(',', $childStoneIdsArray) . "))";
					        }
					        
					        $sql = "select distinct p.products_id from products p, products_to_stones pts where pts.products_id = p.products_id and (pts.stone_name_id = '" . $category_id . "'".$childStoneStr.")  and p.products_status = 1 and (p.products_model like 'T%' or p.products_model like 'DT%')";
					         
					       $result = $conn->query($sql);
						if ($result->num_rows > 0) {
							// output data of each row
							while($row = $result->fetch_assoc()) {
							    $productsIdsString.=$row['products_id'].',';
							    
							}
						}
						$prolist87= rtrim($productsIdsString,',');
					    $prolist87 = explode(',',$prolist87);
					    foreach($prolist87 as $value){
					        if(tep_get_product_quantity($value) === false)
					        continue;
					        $prolist99 .= $value.','; 
					    }
					    $prolist99 = substr($prolist99,0,-1);					    
					    $productsIdsString = $prolist99;
						
						
					 	$sql="select p.products_image, pd.products_name, p.products_model, p.products_id from (products_description pd, products p) where p.products_status = '1' and p.products_id = pd.products_id and pd.language_id = '1' and p.products_id in (".$productsIdsString.")";
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
                  
					        
					        
					    }elseif($category_level==9){
					        
					         $productsIdsString='';
					          if($category_id=='N'){
					              $sql = "SELECT DISTINCT pa.products_attributes_id, pa.products_id, pa.options_id, pa.options_values_id, pa.products_attributes_model, pa.products_attributes_name, pd.products_name, pa.products_attributes_special_price, p.products_model, p.products_image FROM products_attributes AS pa LEFT JOIN products_description AS pd ON pd.products_id = pa.products_id LEFT JOIN products AS p ON p.products_id = pa.products_id	WHERE pd.language_id = '1' AND p.products_status = 1 AND pd.language_id = 1	AND p.products_model LIKE 'N%' and products_model NOT LIKE 'NQ%' ORDER BY options_units_sold DESC, products_attributes_id, p.products_model, pa.products_attributes_model, pa.products_id";
					          }else{
					                  $sql = "SELECT DISTINCT pa.products_attributes_id, pa.products_id, pa.options_id, pa.options_values_id, pa.products_attributes_model, pa.products_attributes_name, pd.products_name, pa.products_attributes_special_price, p.products_model, p.products_image FROM products_attributes AS pa LEFT JOIN products_description AS pd ON pd.products_id = pa.products_id LEFT JOIN products AS p ON p.products_id = pa.products_id	WHERE pd.language_id = '1' AND p.products_status = 1 AND pd.language_id = 1	AND p.products_model LIKE '".$category_id."%' ORDER BY options_units_sold DESC, products_attributes_id, p.products_model, pa.products_attributes_model, pa.products_id ";
					              }
					    $result = $conn->query($sql);
					    if ($result->num_rows > 0) {
							while($row = $result->fetch_assoc()) {
							    $productsIdsString.=$row['products_id'].',';
							    
							}
						}
					    $prolist87= rtrim($productsIdsString,',');
					    $prolist87 = explode(',',$prolist87);
					    foreach($prolist87 as $value){
					        if(tep_get_product_quantity($value) === false)
					        continue;
					        $prolist99 .= $value.','; 
					    }
					    $prolist99 = substr($prolist99,0,-1);					    
					    $productsIdsString = $prolist99;
					    
					    $sql="select p.products_image, pd.products_name, p.products_model, p.products_id from (products_description pd, products p) where p.products_status = '1' and p.products_id = pd.products_id and pd.language_id = '1' and p.products_id in (".$productsIdsString.")";
						$result = $conn->query($sql);
						if ($result->num_rows > 0) {
							// output data of each row
							$i=0;
							while($row = $result->fetch_assoc()) {
							    if($i<15){
								$cat1=array('category_id'=>$row['products_id'],'slider'=>1,'category_level'=>6,'category_name'=>$row['products_name'],'category_image'=>base_url.'images/'.$row['products_image'],'component'=>'product');
								array_push($categoryArr['data'],$cat1);
							    }
							    $i++;
							}
						}
					    
					 $conn->close(); 
					        
					    }
					    
					    else if($category_level==4){
					$categoryArr=array();
						$categoryArr['status']='Success';
						$categoryArr['error']="";
						$categoryArr['data']=array();
						
						
						//Stone name
							$sql="select p.products_id,p.products_image,pts.stone_name_id, stone_name,s.detailed_mpd, count(p.products_id) as count from products_to_stones pts, stone_names s, products p where s.stone_name_id = pts.stone_name_id and pts.products_id = p.products_id and p.products_status = 1 and (p.products_model like '%' or p.products_model like 'D%') and pts.stone_name_id in (select st.stone_name_id from stone_tags st, taglist tl where st.tag_id = tl.tag_id and tl.tag_id = '".$category_id."') group by stone_name_id order by stone_name ASC ";
						$result_stone = $conn->query($sql);
						if ($result_stone->num_rows > 0) {
							while($row_stone = $result_stone->fetch_assoc()) {
							   $stone_name = $row_stone['stone_name'];
							}
						}
						
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
				}elseif($array1['property_id'] == '11'){
                                                    $pro_array[$array1['property_id']] .=  $tag_display_name .', ' ;
                                                }elseif($array1['property_id'] == '9'){
                                                    $psp_query = "select * from products_specific_property psp, products p, products_attributes pa where psp.products_id = p.products_id and pa.products_id = p.products_id and psp.property_value like '".trim($tag_display_name)."' and psp.property_name LIKE '%location%' and p.products_status = '1' and pa.product_attributes_status = '1' group by p.products_id";
                                                    $psp_query = $conn->query($psp_query);
                                                    if($psp_query->num_rows > 0){
                                                        $pro_array['9'] .=  $tag_display_name.',';
                                                        
                                                    }                                                    
                                                }elseif($array1['property_id'] == '4'){
                                                    $get_property_stone_id_query = "SELECT `stone_properties_id` FROM `stone_properties` WHERE `stone_name_id` = '".$stone_name_ids."' and `property_id` = '4' and `property_value` like '%".$array1['tag_name']."%' limit 1"; 
                                                    $get_property_stone_id_query = $conn->query($get_property_stone_id_query);
                                                    if($get_property_stone_id_query->num_rows > 0){
                                                        $pro_array['4'] .=  $tag_display_name.',';
                                                    }     
                                                    
                                                }else{
                                                    $pro_array[$array1['property_id']] .=  $tag_display_name.',';						
                                                }
			}
			for($i = 1; $i<= 23; $i++){
				if($i != 22 || $i != 23){
					$pro_array[$i] = substr($pro_array[$i], 0, -1);
				}
				/*$property_query = "select property_value from stone_properties where property_id = '" . (int)$i . "' and language_id = '1' and stone_name_id='".$stone_name_ids."'";
    			$property = $conn->query($property_query);
				while($array1 = $property->fetch_assoc()){
						$pro_array[$i] =$array1['property_value'];
				}*/
			}
			if($stone_name!=''){
			$pro_final_array['Stone Name']= $stone_name;
			}
			if($pro_array[22]!=''){
			$pro_final_array['Alternate Stone Name #1']= $pro_array[22];
			}
			if($pro_array[23]!=''){
			$pro_final_array['Alternate Stone Name #2']= $pro_array[23];
			}
			if($pro_array[2]!=''){
			$pro_final_array['Primary Chakra']= $pro_array[2];
			}
			if($pro_array[12]!=''){
			$pro_final_array['Secondary Chakra']= $pro_array[12];
			}
			if($pro_array[3]!=''){
			$pro_final_array['Crystal System']= $pro_array[3];
			}
			if($pro_array[4]!=''){
			    $pro_array[4] = str_replace('_', ' ', $pro_array[4]);
			$pro_final_array['Chemical Composition']= $pro_array[4];
			}
			if($pro_array[5]!=''){
			$pro_final_array['Astrological Sign']= $pro_array[5];
			}
			if($pro_array[6]!=''){
			$pro_final_array['Numerical Vibration']= $pro_array[6];
			}
			if($pro_array[7]!=''){
			$pro_final_array['Hardness']= $pro_array[7];
			}
			if($pro_array[8]!=''){
			$pro_final_array['Color']= preg_replace('/[^(\x20-\x7F)]*/','',$pro_array[8]);
			}
			if($pro_array[9]!=''){
			$pro_final_array['Location']= $pro_array[9];
			}
			if($pro_array[10]!=''){
			$pro_final_array['Rarity']= $pro_array[10];
			}
			if($pro_array[11]!=''){
			$pro_final_array['Pronunciation']= $pro_array[11];
			}
			if($pro_array[13]!=''){
			$pro_final_array['Mineral Class']= $pro_array[13];
			}
			if($pro_array[14]!=''){
			$pro_final_array['Common Conditions (Physical)']= $pro_array[14];
			}
			if($pro_array[15]!=''){
			 $pro_final_array['Common Conditions (Emotional)']= $pro_array[15];
			}
			if($pro_array[16]!=''){
			 $pro_final_array['Common Conditions (Spiritual)']= $pro_array[16];
			}
			if($pro_array[17]!=''){
			 $pro_final_array['Extra Grade']= $pro_array[17];
			}
			if($pro_array[18]!=''){
			 $pro_final_array['A Grade']= $pro_array[18];
			}
			if($pro_array[19]!=''){
			 $pro_final_array['B Grade']= $pro_array[19];
			}
			if($pro_array[20]!=''){
			 $pro_final_array['Affirmation']= $pro_array[20];
			}
			if($pro_array[21]!=''){
			  $pro_final_array['Question']= $pro_array[21];
			}
		}
	}
}
						
						
						
						
						
						
						
						
						//END of properties
						$sql="select * from products p, products_description pd where p.products_id = '".$category_id."' and pd.products_id = p.products_id and pd.language_id = '1'";
					
						$property_result = $conn->query($sql);
						if ($property_result->num_rows > 0) {
						    $totalPriceArr=array();
							// output data of each row
							while($row = $property_result->fetch_assoc()) {
							    
							    
							    //---------------------------------PRICE-----------------------------------------------
							    
							    
							    
							    //---------------------------------PRICE-----------------------------------------------
							    if ($row['products_price'] != '0'){
							        $add_price = $row['products_price'];
							    }else{
							        $add_price = 0;
							    }
							    
							    $products_options_sql ="select pov.products_options_values_id, pov.products_options_values_name, pa.products_attributes_name, products_attributes_units, products_attributes_retail_units, only_linked_options, pa.options_values_price, pa.price_prefix, pa.products_attributes_special_price, pa.special_end_date, pa.special_start_date, pa.product_attribute_qty_1, pa.product_attribute_price_1, pa.product_attribute_qty_2, pa.product_attribute_price_2, pa.product_attribute_qty_3, pa.product_attribute_price_3, pa.product_attribute_qty_4, pa.product_attribute_price_4, pa.product_attribute_qty_5, pa.product_attribute_price_5, product_attribute_spe_price_1, product_attribute_spe_price_2, product_attribute_spe_price_3, product_attribute_spe_price_4, product_attribute_spe_price_5, items_per_unit, selling_unit_type, only_linked_options from products_attributes pa, products_options_values pov where pa.products_id = '".$category_id."' and pa.options_id = '1' and pa.options_values_id = pov.products_options_values_id and pov.language_id = '1' and pa.product_attributes_status = '1' and pa.options_values_price IS NOT NULL order by pa.products_options_sort_order
";
							    $results = $conn->query($products_options_sql);
							    if ($results->num_rows > 0) {
							        
							        while($products_options_values = $results->fetch_assoc()) {
							            
							            //product quantity
							        
							        $linked_product_query="select child_products_id , child_options_id, child_options_values_id, linked_options_quantity from linked_products_options where parent_products_id = '".$category_id."' and parent_options_id = '1' and parent_options_values_id ='".$products_options_values['products_options_values_id']."'";
							       $linked_product_query = $conn->query($linked_product_query);
							        if ($linked_product_query->num_rows > 0) {
							        
    							        while($linked_product = $linked_product_query->fetch_assoc()) {
    							          
    							            $uprid=$category_id.'{1}'.$products_options_values['products_options_values_id'];
                                    	$linked_product_qty=tep_get_products_stock($uprid);

                                            if($products_options_values['only_linked_options']=='1'&& $linked_product_qty>0){
                                                    $limited_qty='';
                                                    $products_options_values['products_attributes_units'] = $linked_product_qty;
                                            }
    							            
    							            
    							        }
							        }
							          if($products_options_values['products_attributes_units']>0){
							            if($products_options_values['product_attribute_price_1']>0){
							            if($products_options_values['products_attributes_special_price']>0){
							                $strick = '<strike>$'.number_format($products_options_values['options_values_price'], 2, '.', '').'</strike>';
							            }
							            //-----------------
							               $attribute_1    ='1 -'. ($products_options_values['product_attribute_qty_1'] == '' ? ' or more' : $products_options_values['product_attribute_qty_1'].' pc -').$strick.' $'.$products_options_values['product_attribute_price_1']. 'ea';
							            }
							            
							            if($products_options_values['product_attribute_price_2']>0){
							                
							                 //percentage
							            $special_saving = number_format(((($products_options_values['product_attribute_price_2']-$products_options_values['products_attributes_special_price'])/$products_options_values['options_values_price'])*100),0);
							            $special_saving =100-$special_saving;
							            if($special_saving!=100 && $special_saving!=0){
							               $special_saving ="(Save ".$special_saving." % )";
							            }
							                
							            $attribute_2    =$special_saving. ($products_options_values['product_attribute_qty_1']+1).'-'. ($products_options_values['product_attribute_qty_2'] == '' ? ' or more' : $products_options_values['product_attribute_qty_2'].' pc -').$strick.' $'.$products_options_values['product_attribute_price_2']. 'ea';
							           }
							            
							            if($products_options_values['product_attribute_price_3']>0){
							                
							                 $special_saving = number_format(((($products_options_values['product_attribute_price_3']-$products_options_values['products_attributes_special_price'])/$products_options_values['options_values_price'])*100),0);
							                 $special_saving =100-$special_saving;
							            if($special_saving!=100 && $special_saving!=0){
							               $special_saving ="(Save ".$special_saving." % )";
							            }
							             
							              $attribute_3    =$special_saving.($products_options_values['product_attribute_qty_2']+1).'-'. ($products_options_values['product_attribute_qty_3'] == '' ? ' or more' : $products_options_values['product_attribute_qty_3'].' pc -').$strick.' $'.$products_options_values['product_attribute_price_3']. 'ea';
							            }
							            
							            if($products_options_values['product_attribute_price_4']>0){
							                
							                 $special_saving = number_format(((($products_options_values['product_attribute_price_4']-$products_options_values['products_attributes_special_price'])/$products_options_values['options_values_price'])*100),0);
							                 $special_saving =100-$special_saving;
							            if($special_saving!=100 && $special_saving!=0){
							               $special_saving ="(Save ".$special_saving." % )";
							            }
							            
							              $attribute_4    = $special_saving. ($products_options_values['product_attribute_qty_3']+1).'-'.($products_options_values['product_attribute_qty_4'] == '' ? ' or more' : $products_options_values['product_attribute_qty_4'].' pc -'). $strick.' $'.$products_options_values['product_attribute_price_4']. ' ea';
							           }
							            
							            if($products_options_values['product_attribute_price_5']>0){
							                $special_saving = number_format(((($products_options_values['product_attribute_price_5']-$products_options_values['products_attributes_special_price'])/$products_options_values['options_values_price'])*100),0);
							                 $special_saving =100-$special_saving;
							            if($special_saving!=100 && $special_saving!=0){
							               $special_saving ="(Save ".$special_saving." % )";
							            }
							               $attribute_5    =  $special_saving. ($products_options_values['product_attribute_qty_4']+1).'-'.($products_options_values['product_attribute_qty_5'] == '' ? ' or more' : $products_options_values['product_attribute_qty_5'].' pc -'). $strick.' $'.$products_options_values['product_attribute_price_5']. ' ea';
							             }
							            
							            //------------------
							            
							            $products_attributes_name=$products_options_values['products_attributes_name'];
							            
							            $priceArr   = array('heading'=>$products_attributes_name,
							            'save'=>$attribute_1.'<br>'.$attribute_2.'<br>'.$attribute_3.'<br>'.$attribute_4.'<br>'.$attribute_5.'<br>'.($products_options_values['products_attributes_units'] < 15 ? '*Limited Quantity - '.$products_options_values['products_attributes_units'].' units left in Stock' : ''),
							            'price'=>number_format($products_options_values['options_values_price'], 2, '.', ''),'quantity'=>$products_options_values['products_attributes_units'],'option_value'=>$products_options_values['products_options_values_id']);
							            
							            array_push($totalPriceArr,$priceArr);
							          }
							          
							        }
							        
							    }
							    //-----------------------------------------------------------------------------------------
							   
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
								'component'=>'product',
								'purchase_option'=>$totalPriceArr);
								
								array_push($categoryArr['data'],$cat1);
							}
						}
					 $conn->close(); 	
				
				    
				}
			}//END slider2
			
			//slider 3
			if($slider==3){
			    $perpage=10;
			    if($category_level==1){
			        if($current_page==''){
			            $current_page=1;
			        }
			      $listing_sqlcount = "SELECT a2t.*,ad.articles_url, a.articles_id, a.authors_id, a.articles_date_added, ad.articles_name, ad.articles_head_desc_tag, ad.articles_description, au.authors_name, sn.detailed_mpd,sn.stone_name_id, a2t.topics_id, SUBSTRING( ad.articles_name ,1 ,1) AS start_letter FROM (articles a, articles_description ad, articles_to_topics a2t) LEFT JOIN authors au ON a.authors_id = au.authors_id LEFT JOIN stone_names sn ON a.articles_id = sn.summary_mpd WHERE (a.articles_date_available IS NULL OR to_days(a.articles_date_available) <= to_days(now())) AND a.articles_status = '1' AND a.articles_id = a2t.articles_id AND ad.articles_id = a2t.articles_id AND ad.language_id = '1' AND a2t.topics_id = '3' GROUP BY a.articles_id  ORDER BY ad.articles_name";
        //--------------------
        
         $result_rows = $conn->query($listing_sqlcount);
           $tot_rows = $result_rows->num_rows;
           $pages = ceil($tot_rows / $perpage); 
           $startindex  = ($current_page * $perpage) - $perpage;
           

    
			      $listing_sql = "SELECT a2t.*,ad.articles_url, a.articles_id, a.authors_id, a.articles_date_added, ad.articles_name, ad.articles_head_desc_tag, ad.articles_description, au.authors_name, sn.detailed_mpd,sn.stone_name_id, a2t.topics_id, SUBSTRING( ad.articles_name ,1 ,1) AS start_letter FROM (articles a, articles_description ad, articles_to_topics a2t) LEFT JOIN authors au ON a.authors_id = au.authors_id LEFT JOIN stone_names sn ON a.articles_id = sn.summary_mpd WHERE (a.articles_date_available IS NULL OR to_days(a.articles_date_available) <= to_days(now())) AND a.articles_status = '1' AND a.articles_id = a2t.articles_id AND ad.articles_id = a2t.articles_id AND ad.language_id = '1' AND a2t.topics_id = '3' GROUP BY a.articles_id ORDER BY ad.articles_name limit $startindex,$perpage";
      
        
        //--------------------
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
					$pro_array[$i] = substr($pro_array[$i], 0, -1);
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
            				'buy_status'    =>product_availability(trim($rows['stone_name_id'])),
            				'component'=>'MPD',
            				'current_page'=>$current_page+1
            				
            			);
            			array_push($categoryArr['data'],$cat1);
            		    }
            		}
			    }
			    else if($category_level==2){
			        
			        //Stone name
							$sql="select p.products_id,p.products_image,pts.stone_name_id, stone_name,s.detailed_mpd, count(p.products_id) as count from products_to_stones pts, stone_names s, products p where s.stone_name_id = pts.stone_name_id and pts.products_id = p.products_id and p.products_status = 1 and (p.products_model like '%' or p.products_model like 'D%') and pts.stone_name_id in (select st.stone_name_id from stone_tags st, taglist tl where st.tag_id = tl.tag_id and tl.tag_id = '".$category_id."') group by stone_name_id order by stone_name ASC ";
						$result_stone = $conn->query($sql);
						if ($result_stone->num_rows > 0) {
							while($row_stone = $result_stone->fetch_assoc()) {
							   $stone_name = $row_stone['stone_name'];
							}
						}
			        
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
				}elseif($array1['property_id'] == '11'){
                                                    $pro_array[$array1['property_id']] .=  $tag_display_name .', ' ;
                                                }elseif($array1['property_id'] == '9'){
                                                    $psp_query = "select * from products_specific_property psp, products p, products_attributes pa where psp.products_id = p.products_id and pa.products_id = p.products_id and psp.property_value like '".trim($tag_display_name)."' and psp.property_name LIKE '%location%' and p.products_status = '1' and pa.product_attributes_status = '1' group by p.products_id";
                                                    $psp_query = $conn->query($psp_query);
                                                    if($psp_query->num_rows > 0){
                                                        $pro_array['9'] .=  $tag_display_name.',';
                                                        
                                                    }                                                    
                                                }elseif($array1['property_id'] == '4'){
                                                    $get_property_stone_id_query = "SELECT `stone_properties_id` FROM `stone_properties` WHERE `stone_name_id` = '".$stone_name_ids."' and `property_id` = '4' and `property_value` like '%".$array1['tag_name']."%' limit 1"; 
                                                    $get_property_stone_id_query = $conn->query($get_property_stone_id_query);
                                                    if($get_property_stone_id_query->num_rows > 0){
                                                        $pro_array['4'] .=  $tag_display_name.',';
                                                    }     
                                                    
                                                }else{
                                                    $pro_array[$array1['property_id']] .=  $tag_display_name.',';						
                                                }
			}
			for($i = 1; $i<= 23; $i++){
				if($i != 22 || $i != 23){
					$pro_array[$i] = substr($pro_array[$i], 0, -1);
				}
				/*$property_query = "select property_value from stone_properties where property_id = '" . (int)$i . "' and language_id = '1' and stone_name_id='".$stone_name_ids."'";
    			$property = $conn->query($property_query);
				while($array1 = $property->fetch_assoc()){
						$pro_array[$i] =$array1['property_value'];
				}*/
			}
			if($stone_name!=''){
			$pro_final_string.='Stone Name - '.$stone_name.',,';
			}
			if($pro_array[22]!=''){
			$pro_final_string.='Alternate Stone Name #1 - '. $pro_array[22].',,';
			}
			if($pro_array[23]!=''){
			$pro_final_string.='Alternate Stone Name #2 - '. $pro_array[23].',,';
			}
			if($pro_array[2]!=''){
			$pro_final_string.='Primary Chakra - '.$pro_array[2].',,';
			}
			if($pro_array[12]!=''){
			$pro_final_string.='Secondary Chakra - '. $pro_array[12].',,';
			}
			if($pro_array[3]!=''){
			$pro_final_string.='Crystal System - '. $pro_array[3].',,';
			}
			if($pro_array[4]!=''){
			    $pro_array[4] = str_replace('_', ' ', $pro_array[4]);
			$pro_final_string.='Chemical Composition - '. $pro_array[4].',,';
			}
			if($pro_array[5]!=''){
			$pro_final_string.='Astrological Sign - '.$pro_array[5].',,';
			}
			if($pro_array[6]!=''){
			$pro_final_string.='Numerical Vibration - '. $pro_array[6].',,';
			}
			if($pro_array[7]!=''){
			$pro_final_string.='Hardness - '.$pro_array[7].',,';
			}
			if($pro_array[8]!=''){
			$pro_final_string.='Color - '. preg_replace('/[^(\x20-\x7F)]*/','',$pro_array[8]).',,';
			}
			if($pro_array[9]!=''){
			$pro_final_string.='Location - '. $pro_array[9].',,';
			}
			if($pro_array[10]!=''){
			$pro_final_string.='Rarity - '.$pro_array[10].',,';
			}
			if($pro_array[11]!=''){
			$pro_final_string.='Pronunciation - '. $pro_array[11].',,';
			}
			if($pro_array[13]!=''){
			$pro_final_string.='Mineral Class - '.$pro_array[13].',,';
			}
			if($pro_array[14]!=''){
			$pro_final_string.='Common Conditions (Physical) - '. $pro_array[14].',,';
			}
			if($pro_array[15]!=''){
			 $pro_final_string.='Common Conditions (Emotional) - '. $pro_array[15].',,';
			}
			if($pro_array[16]!=''){
			 $pro_final_string.='Common Conditions (Spiritual) - '. $pro_array[16].',,';
			}
			if($pro_array[17]!=''){
			 $pro_final_string.='Extra Grade - '. $pro_array[17].',,';
			}
			if($pro_array[18]!=''){
			 $pro_final_string.='A Grade - '. $pro_array[18].',,';
			}
			if($pro_array[19]!=''){
			 $pro_final_string.='B Grade - '. $pro_array[19].',,';
			}
			if($pro_array[20]!=''){
			 $pro_final_string.='Affirmation - '. $pro_array[20].',,';
			}
			if($pro_array[21]!=''){
			  $pro_final_string.='Question - '. $pro_array[21];
			}
		}
	}
}else{
    $pro_final_string.='Category - Assortments';
}
//END of properties

$stone_name_id_sql = "SELECT sn.stone_name_id FROM (articles a, articles_description ad, articles_to_topics a2t) LEFT JOIN authors au ON a.authors_id = au.authors_id LEFT JOIN stone_names sn ON a.articles_id = sn.summary_mpd WHERE (a.articles_date_available IS NULL OR to_days(a.articles_date_available) <= to_days(now())) AND a.articles_status = '1' AND a.articles_id = a2t.articles_id AND ad.articles_id = a2t.articles_id AND ad.language_id = '1' AND a2t.topics_id = '3' and sn.detailed_mpd=".$category_id." ORDER BY ad.articles_name limit 1";
$result_stone_name_id = $conn->query($stone_name_id_sql);
            		if ($result_stone_name_id->num_rows > 0) {
            		    while($key = $result_stone_name_id->fetch_assoc()) {
            		        $stone_name_id=$key['stone_name_id'];
            		    }
            		}
			        $listing_sql = "select a.articles_id, a.articles_date_added, a.articles_date_available, a.authors_id, ad.articles_name, ad.articles_description, ad.articles_url, au.authors_name, a.articles_video from (articles a, articles_description ad) left join authors au on a.authors_id = au.authors_id where a.articles_id = '1324' and ad.articles_id = a.articles_id and ad.language_id = '1'";
        $listing_sql_one = "select a.articles_id, a.articles_date_added, a.articles_date_available, a.authors_id, ad.articles_name, ad.articles_description, ad.articles_url, au.authors_name, a.articles_video from (articles a, articles_description ad) left join authors au on a.authors_id = au.authors_id where a.articles_id = ".$category_id." and ad.articles_id = a.articles_id and ad.language_id = '1'";
                    $results = $conn->query($listing_sql_one);
            		if ($results->num_rows > 0) {
            		    while($rows = $results->fetch_assoc()) {
            		       
            		       $articles1 = str_replace('in our online catalog.',' ',html_entity_decode(stripslashes($rows['articles_description'])));
            		       $articles1 = str_replace('See',' ',$articles1);
            		       $articles1 = str_replace('<a href="https://www.healingcrystals.com/advanced_search_result.php','<a style="display:none" href="https://www.healingcrystals.com/advanced_search_result.php ',$articles1);
            		       $articles2 = str_replace('<a href="http://www.healingcrystals.com/Metaphysical','<a style="display:none" href="http://www.healingcrystals.com/Metaphysical',$articles1);
            		       $articles2 = str_replace('Return to our',' ',$articles2);
            		       
            		         $cat1=  array(
            				'category_id' =>$rows['articles_id'],
            				'slider'=>3,
            				'category_level'=>2,
            				'buy_status'    =>product_availability(trim($stone_name_id)),
            				'category_buy' =>$category_id,
            				'category_name' => $rows['articles_name'],
            				'category_properties'=>$pro_final_string,
            				'category_description' => $articles2,
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
			      $listing_sql = "select distinct psp.property_value from products p, products_specific_property psp where psp.products_id = p.products_id and psp.property_name='Shape' and p.products_status=1 and p.products_model like '%' order by property_value";
        
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
			        $productsIdsString='';
			        $sql = "select distinct p.products_id from products p, products_specific_property psp where psp.products_id = p.products_id and lower(psp.property_name) = 'shape' and psp.property_value = '".$category_id."' and p.products_status = 1 and (p.products_model like '%' or p.products_model like 'D%')";
					    
					    $result = $conn->query($sql);
					    if ($result->num_rows > 0) {
							while($row = $result->fetch_assoc()) {
							    $productsIdsString.=$row['products_id'].',';
							    
							}
						}
					   $prolist87= rtrim($productsIdsString,',');
					    $prolist87 = explode(',',$prolist87);
					    foreach($prolist87 as $value){
					        if(tep_get_product_quantity($value) === false)
					        continue;
					        $prolist99 .= $value.','; 
					    }
					    $prolist99 = substr($prolist99,0,-1);					    
					    $productsIdsString = $prolist99;
					    
					    $sql1 = "select p.products_image, pd.products_name, p.products_model, p.products_id from (products_description pd, products p) where p.products_status = '1' and p.products_id = pd.products_id and pd.language_id = '1' and p.products_id in (".$productsIdsString.") order by p.products_model ASC";
					    $results = $conn->query($sql1);
					    if ($results->num_rows > 0) {
							while($rows = $results->fetch_assoc()) {
							    $products_name=strip_tags($rows['products_name']);
							    $products_name = preg_replace('/[\x00-\x1F\x7F-\xFF]/', '', $products_name);
							     $cat1=  array(
                				'category_id' =>$rows['products_id'] ,
                				'slider'=>4,
                				'category_level'=>3,
                				'category_name' => $products_name,
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
						
						
						//Stone name
							$sql="select p.products_id,p.products_image,pts.stone_name_id, stone_name,s.detailed_mpd, count(p.products_id) as count from products_to_stones pts, stone_names s, products p where s.stone_name_id = pts.stone_name_id and pts.products_id = p.products_id and p.products_status = 1 and (p.products_model like '%' or p.products_model like 'D%') and pts.stone_name_id in (select st.stone_name_id from stone_tags st, taglist tl where st.tag_id = tl.tag_id and tl.tag_id = '".$category_id."') group by stone_name_id order by stone_name ASC ";
						$result_stone = $conn->query($sql);
						if ($result_stone->num_rows > 0) {
							while($row_stone = $result_stone->fetch_assoc()) {
							   $stone_name = $row_stone['stone_name'];
							}
						}
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
				}elseif($array1['property_id'] == '11'){
                                                    $pro_array[$array1['property_id']] .=  $tag_display_name .', ' ;
                                                }elseif($array1['property_id'] == '9'){
                                                    $psp_query = "select * from products_specific_property psp, products p, products_attributes pa where psp.products_id = p.products_id and pa.products_id = p.products_id and psp.property_value like '".trim($tag_display_name)."' and psp.property_name LIKE '%location%' and p.products_status = '1' and pa.product_attributes_status = '1' group by p.products_id";
                                                    $psp_query = $conn->query($psp_query);
                                                    if($psp_query->num_rows > 0){
                                                        $pro_array['9'] .=  $tag_display_name.',';
                                                        
                                                    }                                                    
                                                }elseif($array1['property_id'] == '4'){
                                                    $get_property_stone_id_query = "SELECT `stone_properties_id` FROM `stone_properties` WHERE `stone_name_id` = '".$stone_name_ids."' and `property_id` = '4' and `property_value` like '%".$array1['tag_name']."%' limit 1"; 
                                                    $get_property_stone_id_query = $conn->query($get_property_stone_id_query);
                                                    if($get_property_stone_id_query->num_rows > 0){
                                                        $pro_array['4'] .=  $tag_display_name.',';
                                                    }     
                                                    
                                                }else{
                                                    $pro_array[$array1['property_id']] .=  $tag_display_name.',';						
                                                }
			}
			for($i = 1; $i<= 23; $i++){
				if($i != 22 || $i != 23){
					$pro_array[$i] = substr($pro_array[$i], 0, -1);
				}
			/*	$property_query = "select property_value from stone_properties where property_id = '" . (int)$i . "' and language_id = '1' and stone_name_id='".$stone_name_ids."'";
    			$property = $conn->query($property_query);
				while($array1 = $property->fetch_assoc()){
						$pro_array[$i] =$array1['property_value'];
				}*/
			}
			if($stone_name!=''){
			$pro_final_array['Stone Name']= $stone_name;
			}
			if($pro_array[22]!=''){
			$pro_final_array['Alternate Stone Name #1']= $pro_array[22];
			}
			if($pro_array[23]!=''){
			$pro_final_array['Alternate Stone Name #2']= $pro_array[23];
			}
			if($pro_array[2]!=''){
			$pro_final_array['Primary Chakra']= $pro_array[2];
			}
			if($pro_array[12]!=''){
			$pro_final_array['Secondary Chakra']= $pro_array[12];
			}
			if($pro_array[3]!=''){
			$pro_final_array['Crystal System']= $pro_array[3];
			}
			if($pro_array[4]!=''){
			    $pro_array[4] = str_replace('_', ' ', $pro_array[4]);
			$pro_final_array['Chemical Composition']= $pro_array[4];
			}
			if($pro_array[5]!=''){
			$pro_final_array['Astrological Sign']= $pro_array[5];
			}
			if($pro_array[6]!=''){
			$pro_final_array['Numerical Vibration']= $pro_array[6];
			}
			if($pro_array[7]!=''){
			$pro_final_array['Hardness']= $pro_array[7];
			}
			if($pro_array[8]!=''){
			$pro_final_array['Color']= preg_replace('/[^(\x20-\x7F)]*/','',$pro_array[8]);
			}
			if($pro_array[9]!=''){
			$pro_final_array['Location']= $pro_array[9];
			}
			if($pro_array[10]!=''){
			$pro_final_array['Rarity']= $pro_array[10];
			}
			if($pro_array[11]!=''){
			$pro_final_array['Pronunciation']= $pro_array[11];
			}
			if($pro_array[13]!=''){
			$pro_final_array['Mineral Class']= $pro_array[13];
			}
			if($pro_array[14]!=''){
			$pro_final_array['Common Conditions (Physical)']= $pro_array[14];
			}
			if($pro_array[15]!=''){
			 $pro_final_array['Common Conditions (Emotional)']= $pro_array[15];
			}
			if($pro_array[16]!=''){
			 $pro_final_array['Common Conditions (Spiritual)']= $pro_array[16];
			}
			if($pro_array[17]!=''){
			 $pro_final_array['Extra Grade']= $pro_array[17];
			}
			if($pro_array[18]!=''){
			 $pro_final_array['A Grade']= $pro_array[18];
			}
			if($pro_array[19]!=''){
			 $pro_final_array['B Grade']= $pro_array[19];
			}
			if($pro_array[20]!=''){
			 $pro_final_array['Affirmation']= $pro_array[20];
			}
			if($pro_array[21]!=''){
			  $pro_final_array['Question']= $pro_array[21];
			}
		}
	}
}else{
    $pro_final_array['Category']= 'Assortments';
}
						
						
						
						
						
						
						
						
						//END of properties
						$sql="select * from products p, products_description pd where p.products_id = '".$category_id."' and pd.products_id = p.products_id and pd.language_id = '1'";
					
						$result = $conn->query($sql);
						if ($result->num_rows > 0) {
						    $totalPriceArr=array();
							// output data of each row
							while($row = $result->fetch_assoc()) {
							    
							     //---------------------------------PRICE-----------------------------------------------
							    if ($row['products_price'] != '0'){
							        $add_price = $row['products_price'];
							    }else{
							        $add_price = 0;
							    }
							    
							    $products_options_sql ="select pov.products_options_values_id, pov.products_options_values_name, pa.products_attributes_name, products_attributes_units, products_attributes_retail_units, only_linked_options, pa.options_values_price, pa.price_prefix, pa.products_attributes_special_price, pa.special_end_date, pa.special_start_date, pa.product_attribute_qty_1, pa.product_attribute_price_1, pa.product_attribute_qty_2, pa.product_attribute_price_2, pa.product_attribute_qty_3, pa.product_attribute_price_3, pa.product_attribute_qty_4, pa.product_attribute_price_4, pa.product_attribute_qty_5, pa.product_attribute_price_5, product_attribute_spe_price_1, product_attribute_spe_price_2, product_attribute_spe_price_3, product_attribute_spe_price_4, product_attribute_spe_price_5, items_per_unit, selling_unit_type, only_linked_options from products_attributes pa, products_options_values pov where pa.products_id = '".$category_id."' and pa.options_id = '1' and pa.options_values_id = pov.products_options_values_id and pov.language_id = '1' and pa.product_attributes_status = '1' and pa.options_values_price IS NOT NULL order by pa.products_options_sort_order
";
							    $results = $conn->query($products_options_sql);
							    if ($results->num_rows > 0) {
							        
							        while($products_options_values = $results->fetch_assoc()) {
							            
							            //product quantity
							        
							        $linked_product_query="select child_products_id , child_options_id, child_options_values_id, linked_options_quantity from linked_products_options where parent_products_id = '".$category_id."' and parent_options_id = '1' and parent_options_values_id ='".$products_options_values['products_options_values_id']."'";
							       $linked_product_query = $conn->query($linked_product_query);
							        if ($linked_product_query->num_rows > 0) {
							        
    							        while($linked_product = $linked_product_query->fetch_assoc()) {
    							          
    							            $uprid=$category_id.'{1}'.$products_options_values['products_options_values_id'];
                                    	$linked_product_qty=tep_get_products_stock($uprid);

                                            if($products_options_values['only_linked_options']=='1'&& $linked_product_qty>0){
                                                    $limited_qty='';
                                                    $products_options_values['products_attributes_units'] = $linked_product_qty;
                                            }
    							            
    							            
    							        }
							        }
							          if($products_options_values['products_attributes_units']>0){
							            if($products_options_values['product_attribute_price_1']>0){
							            if($products_options_values['products_attributes_special_price']>0){
							                $strick = '<strike>$'.number_format($products_options_values['options_values_price'], 2, '.', '').'</strike>';
							            }
							            //-----------------
							               $attribute_1    ='1 -'. ($products_options_values['product_attribute_qty_1'] == '' ? ' or more' : $products_options_values['product_attribute_qty_1'].' pc -').$strick.' $'.$products_options_values['product_attribute_price_1']. 'ea';
							            }
							            
							            if($products_options_values['product_attribute_price_2']>0){
							                
							                 //percentage
							            $special_saving = number_format(((($products_options_values['product_attribute_price_2']-$products_options_values['products_attributes_special_price'])/$products_options_values['options_values_price'])*100),0);
							            $special_saving =100-$special_saving;
							            if($special_saving!=100 && $special_saving!=0){
							               $special_saving ="(Save ".$special_saving." % )";
							            }
							                
							            $attribute_2    =$special_saving. ($products_options_values['product_attribute_qty_1']+1).'-'. ($products_options_values['product_attribute_qty_2'] == '' ? ' or more' : $products_options_values['product_attribute_qty_2'].' pc -').$strick.' $'.$products_options_values['product_attribute_price_2']. 'ea';
							           }
							            
							            if($products_options_values['product_attribute_price_3']>0){
							                
							                 $special_saving = number_format(((($products_options_values['product_attribute_price_3']-$products_options_values['products_attributes_special_price'])/$products_options_values['options_values_price'])*100),0);
							                 $special_saving =100-$special_saving;
							            if($special_saving!=100 && $special_saving!=0){
							               $special_saving ="(Save ".$special_saving." % )";
							            }
							             
							              $attribute_3    =$special_saving.($products_options_values['product_attribute_qty_2']+1).'-'. ($products_options_values['product_attribute_qty_3'] == '' ? ' or more' : $products_options_values['product_attribute_qty_3'].' pc -').$strick.' $'.$products_options_values['product_attribute_price_3']. 'ea';
							            }
							            
							            if($products_options_values['product_attribute_price_4']>0){
							                
							                 $special_saving = number_format(((($products_options_values['product_attribute_price_4']-$products_options_values['products_attributes_special_price'])/$products_options_values['options_values_price'])*100),0);
							                 $special_saving =100-$special_saving;
							            if($special_saving!=100 && $special_saving!=0){
							               $special_saving ="(Save ".$special_saving." % )";
							            }
							            
							              $attribute_4    = $special_saving. ($products_options_values['product_attribute_qty_3']+1).'-'.($products_options_values['product_attribute_qty_4'] == '' ? ' or more' : $products_options_values['product_attribute_qty_4'].' pc -'). $strick.' $'.$products_options_values['product_attribute_price_4']. ' ea';
							           }
							            
							            if($products_options_values['product_attribute_price_5']>0){
							                $special_saving = number_format(((($products_options_values['product_attribute_price_5']-$products_options_values['products_attributes_special_price'])/$products_options_values['options_values_price'])*100),0);
							                 $special_saving =100-$special_saving;
							            if($special_saving!=100 && $special_saving!=0){
							               $special_saving ="(Save ".$special_saving." % )";
							            }
							               $attribute_5    =  $special_saving. ($products_options_values['product_attribute_qty_4']+1).'-'.($products_options_values['product_attribute_qty_5'] == '' ? ' or more' : $products_options_values['product_attribute_qty_5'].' pc -'). $strick.' $'.$products_options_values['product_attribute_price_5']. ' ea';
							             }
							            
							            //------------------
							            
							            $products_attributes_name=$products_options_values['products_attributes_name'];
							            
							            $priceArr   = array('heading'=>$products_attributes_name,
							            'save'=>$attribute_1.'<br>'.$attribute_2.'<br>'.$attribute_3.'<br>'.$attribute_4.'<br>'.$attribute_5.'<br>'.($products_options_values['products_attributes_units'] < 15 ? '*Limited Quantity - '.$products_options_values['products_attributes_units'].' units left in Stock' : ''),
							            'price'=>number_format($products_options_values['options_values_price'], 2, '.', ''),'quantity'=>$products_options_values['products_attributes_units'],'option_value'=>$products_options_values['products_options_values_id']);
							            
							            array_push($totalPriceArr,$priceArr);
							          }
							          
							        }
							        
							    }
							    //-----------------------------------------------------------------------------------------
							   
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
								'component'=>'product',
								'purchase_option'=>$totalPriceArr);
								
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
			       $category_id= str_replace(" ","-",$category_id);
			       $category_id=strtolower($category_id);
			       $sql="select pts.stone_name_id, stone_name,detailed_mpd, products_id from products_to_stones pts, stone_names s, stone_properties sp where sp.stone_name_id = pts.stone_name_id and s.stone_name_id = pts.stone_name_id and sp.property_id = '8' and products_id in (select p.products_id from products_specific_property psp, products p where psp.products_id = p.products_id and p.products_status = 1 and (p.products_model like '%' or p.products_model like 'D%') and lower(property_name) = 'color' and property_value = '".$category_id."') group by stone_name_id order by stone_name ASC";
                    $result = $conn->query($sql);
            		if ($result->num_rows > 0) {
            		    $stoneNameArr=array();
							// output data of each row
							while($row_fetch = $result->fetch_assoc()) {
							     $sql_one="select pts.products_id from products p, products_to_stones pts, products_specific_property psp where pts.products_id = p.products_id and psp.products_id = p.products_id and lower(psp.property_name) = 'color' and psp.property_value = '".$category_id."' and pts.stone_name_id = '".$row_fetch['stone_name_id']."' and p.products_status = 1 and (p.products_model like '%' or p.products_model like 'D%')";
							    $result_one = $conn->query($sql_one);
							    if ($result_one->num_rows > 0) {
    							    while($row_two = $result_one->fetch_assoc()) {
    							       // echo $row_two['products_id'].',';
    							         if(tep_get_product_quantity($row_two['products_id']) != false){
    							             if(!in_array($row_fetch['detailed_mpd'], $stoneNameArr)){
    							                 array_push($stoneNameArr,$row_fetch['detailed_mpd']);  
    							             }
    							         }
    							    }
							    }
							}
							
							
							if($stoneNameArr){
							    foreach($stoneNameArr as $key=>$val){
							        //-----------
							
							
							$listing_sql = "SELECT a2t.*,ad.articles_url, a.articles_id, a.authors_id, a.articles_date_added, ad.articles_name, ad.articles_head_desc_tag, ad.articles_description, au.authors_name, sn.detailed_mpd,sn.stone_name_id, a2t.topics_id, SUBSTRING( ad.articles_name ,1 ,1) AS start_letter FROM (articles a, articles_description ad, articles_to_topics a2t) LEFT JOIN authors au ON a.authors_id = au.authors_id LEFT JOIN stone_names sn ON a.articles_id = sn.summary_mpd WHERE (a.articles_date_available IS NULL OR to_days(a.articles_date_available) <= to_days(now())) AND a.articles_status = '1' AND a.articles_id = a2t.articles_id AND ad.articles_id = a2t.articles_id AND ad.language_id = '1' AND a2t.topics_id = '3' AND sn.detailed_mpd=".$val." ORDER BY ad.articles_name";
        
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
					$pro_array[$i] = substr($pro_array[$i], 0, -1);
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
            				'buy_status'    =>product_availability(trim($rows['stone_name_id'])),
            				'component'=>'article'
            				
            			);
            			array_push($categoryArr['data'],$cat1);
            		    }
            		}
							
							        
							        //----------
							    }
							    
							}
						}
			        
			        
			    }
			    elseif($category_level==3){
			        
			        $sql = "select DISTINCT(psp.products_id) from products p, products_specific_property psp, products_to_stones pts where psp.products_id = p.products_id and pts.products_id = p.products_id and p.products_status = 1 and p.products_model like '%' and lower(property_name) = 'color' and property_value = '".$tag_id."' and stone_name_id = '".$category_id."'";
					    $productsIdsString='';
					    $result = $conn->query($sql);
					    if ($result->num_rows > 0) {
							while($row = $result->fetch_assoc()) {
							    $productsIdsString.=$row['products_id'].',';
							    
							}
						}
					   $prolist87= rtrim($productsIdsString,',');
					    $prolist87 = explode(',',$prolist87);
					    foreach($prolist87 as $value){
					        if(tep_get_product_quantity($value) === false)
					        continue;
					        $prolist99 .= $value.','; 
					    }
					    $prolist99 = substr($prolist99,0,-1);					    
					    $productsIdsString = $prolist99;
					    
					     $sql1 = "select * from products p, products_description pd where p.products_id in (".$productsIdsString.") and pd.products_id = p.products_id and pd.language_id = '1'";
					    
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
						
						//Stone name
							$sql="select p.products_id,p.products_image,pts.stone_name_id, stone_name,s.detailed_mpd, count(p.products_id) as count from products_to_stones pts, stone_names s, products p where s.stone_name_id = pts.stone_name_id and pts.products_id = p.products_id and p.products_status = 1 and (p.products_model like '%' or p.products_model like 'D%') and pts.stone_name_id in (select st.stone_name_id from stone_tags st, taglist tl where st.tag_id = tl.tag_id and tl.tag_id = '".$category_id."') group by stone_name_id order by stone_name ASC ";
						$result_stone = $conn->query($sql);
						if ($result_stone->num_rows > 0) {
							while($row_stone = $result_stone->fetch_assoc()) {
							   $stone_name = $row_stone['stone_name'];
							}
						}
						
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
				}elseif($array1['property_id'] == '11'){
                                                    $pro_array[$array1['property_id']] .=  $tag_display_name .', ' ;
                                                }elseif($array1['property_id'] == '9'){
                                                    $psp_query = "select * from products_specific_property psp, products p, products_attributes pa where psp.products_id = p.products_id and pa.products_id = p.products_id and psp.property_value like '".trim($tag_display_name)."' and psp.property_name LIKE '%location%' and p.products_status = '1' and pa.product_attributes_status = '1' group by p.products_id";
                                                    $psp_query = $conn->query($psp_query);
                                                    if($psp_query->num_rows > 0){
                                                        $pro_array['9'] .=  $tag_display_name.',';
                                                        
                                                    }                                                    
                                                }elseif($array1['property_id'] == '4'){
                                                    $get_property_stone_id_query = "SELECT `stone_properties_id` FROM `stone_properties` WHERE `stone_name_id` = '".$stone_name_ids."' and `property_id` = '4' and `property_value` like '%".$array1['tag_name']."%' limit 1"; 
                                                    $get_property_stone_id_query = $conn->query($get_property_stone_id_query);
                                                    if($get_property_stone_id_query->num_rows > 0){
                                                        $pro_array['4'] .=  $tag_display_name.',';
                                                    }     
                                                    
                                                }else{
                                                    $pro_array[$array1['property_id']] .=  $tag_display_name.',';						
                                                }
			}
			for($i = 1; $i<= 23; $i++){
				if($i != 22 || $i != 23){
					$pro_array[$i] = substr($pro_array[$i], 0, -1);
				}
			/*	$property_query = "select property_value from stone_properties where property_id = '" . (int)$i . "' and language_id = '1' and stone_name_id='".$stone_name_ids."'";
    			$property = $conn->query($property_query);
				while($array1 = $property->fetch_assoc()){
						$pro_array[$i] =$array1['property_value'];
				}*/
			}
			if($stone_name!=''){
			$pro_final_array['Stone Name']= $stone_name;
			}
			if($pro_array[22]!=''){
			$pro_final_array['Alternate Stone Name #1']= $pro_array[22];
			}
			if($pro_array[23]!=''){
			$pro_final_array['Alternate Stone Name #2']= $pro_array[23];
			}
			if($pro_array[2]!=''){
			$pro_final_array['Primary Chakra']= $pro_array[2];
			}
			if($pro_array[12]!=''){
			$pro_final_array['Secondary Chakra']= $pro_array[12];
			}
			if($pro_array[3]!=''){
			$pro_final_array['Crystal System']= $pro_array[3];
			}
			if($pro_array[4]!=''){
			    $pro_array[4] = str_replace('_', ' ', $pro_array[4]);
			$pro_final_array['Chemical Composition']= $pro_array[4];
			}
			if($pro_array[5]!=''){
			$pro_final_array['Astrological Sign']= $pro_array[5];
			}
			if($pro_array[6]!=''){
			$pro_final_array['Numerical Vibration']= $pro_array[6];
			}
			if($pro_array[7]!=''){
			$pro_final_array['Hardness']= $pro_array[7];
			}
			if($pro_array[8]!=''){
			$pro_final_array['Color']= preg_replace('/[^(\x20-\x7F)]*/','',$pro_array[8]);
			}
			if($pro_array[9]!=''){
			$pro_final_array['Location']= $pro_array[9];
			}
			if($pro_array[10]!=''){
			$pro_final_array['Rarity']= $pro_array[10];
			}
			if($pro_array[11]!=''){
			$pro_final_array['Pronunciation']= $pro_array[11];
			}
			if($pro_array[13]!=''){
			$pro_final_array['Mineral Class']= $pro_array[13];
			}
			if($pro_array[14]!=''){
			$pro_final_array['Common Conditions (Physical)']= $pro_array[14];
			}
			if($pro_array[15]!=''){
			 $pro_final_array['Common Conditions (Emotional)']= $pro_array[15];
			}
			if($pro_array[16]!=''){
			 $pro_final_array['Common Conditions (Spiritual)']= $pro_array[16];
			}
			if($pro_array[17]!=''){
			 $pro_final_array['Extra Grade']= $pro_array[17];
			}
			if($pro_array[18]!=''){
			 $pro_final_array['A Grade']= $pro_array[18];
			}
			if($pro_array[19]!=''){
			 $pro_final_array['B Grade']= $pro_array[19];
			}
			if($pro_array[20]!=''){
			 $pro_final_array['Affirmation']= $pro_array[20];
			}
			if($pro_array[21]!=''){
			  $pro_final_array['Question']= $pro_array[21];
			}
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
				
				
						$cat1=array('category_id'=>'M','slider'=>7,'category_level'=>2,'category_name'=>'Monthly Newsletter Archive','component'=>'category');
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
				        		$listing_sql = "select distinct a.articles_id, a.authors_id, a.articles_date_added, a.articles_date_available, ad.articles_name,ad.articles_description, a.articles_image, ad.articles_head_desc_tag, au.authors_name, td.topics_name, a2t.topics_id from (articles a, articles_description ad, articles_to_topics a2t) left join authors au on a.authors_id = au.authors_id left join topics_description td on a2t.topics_id = td.topics_id where (a.articles_date_available IS NULL or a.articles_date_available <= now()) and a.articles_status = '1' and a.publish_on_hc = '1' and a.articles_id = a2t.articles_id and ad.articles_id = a2t.articles_id and ad.language_id = '1' and td.language_id = '1' and a2t.topics_id = '2' group by a.articles_id order by a.articles_date_available desc, ad.articles_name";
        
                    $result = $conn->query($listing_sql);
            		if ($result->num_rows > 0) { 
            		    $i=0;
            		    $propertyArray=array();
            		   while( $rows= $result->fetch_assoc()) {
            		       $string=htmlentities($rows['articles_description']);
            		       //	$string = preg_replace('/[\x00-\x1F\x7F-\xFF]/', '', $dd);
            		      $string = preg_replace('@<(\w+)\b.*?>.*?</\1>@si', '', $string);
            		      
            		     /*  $cat1=  array(
                				'category_id' =>$rows['products_id'] ,
                				'slider'=>4,
                				'category_level'=>3,
                				'category_name' => $rows['products_name'],
                				'category_description' => '',
                				'category_image' =>base_url.'images/'.$rows['products_image'],
                				'component'=>'product'
                				
                			);		*/
                			
                			if($rows['articles_image']==''){
                			    $articles_image='Capture.JPG';
                			}else{
                			    $articles_image=$rows['articles_image'];
                			}
            		         $cat1=  array(
            				'category_id' =>$rows['articles_id'],
            				'slider'=>7,
            				'category_level'=>3,
            				'tag_id'=>'M',
            				'category_name' => strip_tags($rows['articles_name']),
            				'category_description' => '',
            				'category_image' =>base_url.'images/'.$articles_image,
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
        $username = "healingt_user";
        $password = "Madept";
        $dbname = "healint_new";
        
        
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
						
						
						//Stone name
							$sql="select p.products_id,p.products_image,pts.stone_name_id, stone_name,s.detailed_mpd, count(p.products_id) as count from products_to_stones pts, stone_names s, products p where s.stone_name_id = pts.stone_name_id and pts.products_id = p.products_id and p.products_status = 1 and (p.products_model like '%' or p.products_model like 'D%') and pts.stone_name_id in (select st.stone_name_id from stone_tags st, taglist tl where st.tag_id = tl.tag_id and tl.tag_id = '".$category_id."') group by stone_name_id order by stone_name ASC ";
						$result_stone = $conn->query($sql);
						if ($result_stone->num_rows > 0) {
							while($row_stone = $result_stone->fetch_assoc()) {
							   $stone_name = $row_stone['stone_name'];
							}
						}
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
				}elseif($array1['property_id'] == '11'){
                                                    $pro_array[$array1['property_id']] .=  $tag_display_name .', ' ;
                                                }elseif($array1['property_id'] == '9'){
                                                    $psp_query = "select * from products_specific_property psp, products p, products_attributes pa where psp.products_id = p.products_id and pa.products_id = p.products_id and psp.property_value like '".trim($tag_display_name)."' and psp.property_name LIKE '%location%' and p.products_status = '1' and pa.product_attributes_status = '1' group by p.products_id";
                                                    $psp_query = $conn->query($psp_query);
                                                    if($psp_query->num_rows > 0){
                                                        $pro_array['9'] .=  $tag_display_name.',';
                                                        
                                                    }                                                    
                                                }elseif($array1['property_id'] == '4'){
                                                    $get_property_stone_id_query = "SELECT `stone_properties_id` FROM `stone_properties` WHERE `stone_name_id` = '".$stone_name_ids."' and `property_id` = '4' and `property_value` like '%".$array1['tag_name']."%' limit 1"; 
                                                    $get_property_stone_id_query = $conn->query($get_property_stone_id_query);
                                                    if($get_property_stone_id_query->num_rows > 0){
                                                        $pro_array['4'] .=  $tag_display_name.',';
                                                    }     
                                                    
                                                }else{
                                                    $pro_array[$array1['property_id']] .=  $tag_display_name.',';						
                                                }
			}
			for($i = 1; $i<= 23; $i++){
				if($i != 22 || $i != 23){
					$pro_array[$i] = substr($pro_array[$i], 0, -1);
				}
			/*	$property_query = "select property_value from stone_properties where property_id = '" . (int)$i . "' and language_id = '1' and stone_name_id='".$stone_name_ids."'";
    			$property = $conn->query($property_query);
				while($array1 = $property->fetch_assoc()){
						$pro_array[$i] =$array1['property_value'];
				}*/
			}
				if($stone_name!=''){
			$pro_final_array['Stone Name']= $stone_name;
			}
			if($pro_array[22]!=''){
			$pro_final_array['Alternate Stone Name #1']= $pro_array[22];
			}
			if($pro_array[23]!=''){
			$pro_final_array['Alternate Stone Name #2']= $pro_array[23];
			}
			if($pro_array[2]!=''){
			$pro_final_array['Primary Chakra']= $pro_array[2];
			}
			if($pro_array[12]!=''){
			$pro_final_array['Secondary Chakra']= $pro_array[12];
			}
			if($pro_array[3]!=''){
			$pro_final_array['Crystal System']= $pro_array[3];
			}
			if($pro_array[4]!=''){
			    $pro_array[4] = str_replace('_', ' ', $pro_array[4]);
			$pro_final_array['Chemical Composition']= $pro_array[4];
			}
			if($pro_array[5]!=''){
			$pro_final_array['Astrological Sign']= $pro_array[5];
			}
			if($pro_array[6]!=''){
			$pro_final_array['Numerical Vibration']= $pro_array[6];
			}
			if($pro_array[7]!=''){
			$pro_final_array['Hardness']= $pro_array[7];
			}
			if($pro_array[8]!=''){
			$pro_final_array['Color']= preg_replace('/[^(\x20-\x7F)]*/','',$pro_array[8]);
			}
			if($pro_array[9]!=''){
			$pro_final_array['Location']= $pro_array[9];
			}
			if($pro_array[10]!=''){
			$pro_final_array['Rarity']= $pro_array[10];
			}
			if($pro_array[11]!=''){
			$pro_final_array['Pronunciation']= $pro_array[11];
			}
			if($pro_array[13]!=''){
			$pro_final_array['Mineral Class']= $pro_array[13];
			}
			if($pro_array[14]!=''){
			$pro_final_array['Common Conditions (Physical)']= $pro_array[14];
			}
			if($pro_array[15]!=''){
			 $pro_final_array['Common Conditions (Emotional)']= $pro_array[15];
			}
			if($pro_array[16]!=''){
			 $pro_final_array['Common Conditions (Spiritual)']= $pro_array[16];
			}
			if($pro_array[17]!=''){
			 $pro_final_array['Extra Grade']= $pro_array[17];
			}
			if($pro_array[18]!=''){
			 $pro_final_array['A Grade']= $pro_array[18];
			}
			if($pro_array[19]!=''){
			 $pro_final_array['B Grade']= $pro_array[19];
			}
			if($pro_array[20]!=''){
			 $pro_final_array['Affirmation']= $pro_array[20];
			}
			if($pro_array[21]!=''){
			  $pro_final_array['Question']= $pro_array[21];
			}
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
        $username = "healingt_user";
        $password = "Madept";
        $dbname = "healint_new";

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
        $username = "healingt_user";
        $password = "Madept";
        $dbname = "healint_new";

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
					    $prolist87 = explode(',',$prolist87);
					    foreach($prolist87 as $value){
					        if(tep_get_product_quantity($value) === false)
					        continue;
					        $prolist99 .= $value.','; 
					    }
					    $prolist99 = substr($prolist99,0,-1);					    
					    $productsIdsString = $prolist99;
						
					  	$sql1 = "select ad.*,a.articles_id, a.articles_date_added, a.articles_date_available, a.authors_id, ad.articles_name, ad.articles_description, ad.articles_url, au.authors_name, a.articles_video from (articles a, articles_description ad) left join authors au on a.authors_id = au.authors_id where ad.articles_id in (".$productsIdsString.")  and ad.articles_id = a.articles_id and ad.language_id = '1'";
		    
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
        $username = "healingt_user";
        $password = "Madept";
        $dbname = "healint_new";
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
        $username = "healingt_user";
        $password = "Madept";
        $dbname = "healint_new";

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
    
     $servername = "localhost";
        $username = "healingt_user";
        $password = "Madept";
        $dbname = "healint_new";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
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
      $servername = "localhost";
        $username = "healingt_user";
        $password = "Madept";
        $dbname = "healint_new";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
		$i = $products_id;
    $products_id = tep_get_prid($products_id);
  
		if ($i != $products_id){
			$i = tep_get_attributes_id($i);
			
			
                     $stock_query = "select products_attributes_units as products_quantity, only_linked_options from products_attributes where products_id = '".$products_id."' and options_values_id = '".$i."' and product_attributes_status = '1'";
                       
						$stock_query = $conn->query($stock_query);
						
						if (!$stock_query->num_rows && $amazon_flag){
                            $stock_query = "select products_attributes_units as products_quantity, only_linked_options from products_attributes where products_id = '".$products_id."' and options_values_id = '".$i."'";
						}
						if (!$stock_query->num_rows){
							return 0;
						}
                        $stock_values = $stock_query->fetch_assoc();

                        //linked options
                        
                        
                        if($stock_values['only_linked_options'] == 1 && (!function_exists('tep_session_is_registered') || (function_exists('tep_session_is_registered') && !tep_session_is_registered('is_retail_store') && (!tep_session_is_registered('retail_rep') && $_SESSION['retail_rep'] == '')) ) ){
                           
                            $linked_options_query = "select product_attributes_status, linked_options_quantity, products_attributes_units from linked_products_options l, products_attributes pa where l.child_products_id = pa.products_id and l.child_options_id = pa.options_id and l.child_options_values_id = pa.options_values_id and l.parent_products_id = '".$products_id."' and parent_options_values_id = '".$i."' ";
                            $linked_options_query = $conn->query($linked_options_query);
                            if($linked_options_query->num_rows){
                                $min_linked_qty_left = NULL;
                                while($linked_options_array = $linked_options_query->fetch_assoc()){
                                    
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

                                    
                                }
                                   $stock_values['products_quantity'] = $min_linked_qty_left;
                            }
                        }
		}else{
	    $stock_query = "select products_quantity from products where products_id = '" .$products_id . "'";
	    $stock_values = $conn->query($stock_query);
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
        $username = "healingt_user";
        $password = "Madept";
        $dbname = "healint_new";

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
        $category_id = $request->category_buy;
        
     $servername = "localhost";
        $username = "healingt_user";
        $password = "Madept";
        $dbname = "healint_new";

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
						$childStoneIdsArray = getChildStonesIds($category_id);
					        if (!empty($childStoneIdsArray)) {
					            $childStoneStr = " or (pts.stone_name_id in (" . implode(',', $childStoneIdsArray) . "))";
					        }
					        
					       $sql = "select distinct p.products_id from products p, products_to_stones pts where pts.products_id = p.products_id and (pts.stone_name_id = '" . $category_id . "'".$childStoneStr.") and (p.products_model like '%' or p.products_model like 'D%')";
					         
					       $result = $conn->query($sql);
						if ($result->num_rows > 0) {
							// output data of each row
							while($row = $result->fetch_assoc()) {
							    $productsIdsString.=$row['products_id'].',';
							    
							}
						}
						$prolist87= rtrim($productsIdsString,',');
					    $prolist87 = explode(',',$prolist87);
					    foreach($prolist87 as $value){
					        if(tep_get_product_quantity($value) === false)
					        continue;
					        $prolist99 .= $value.','; 
					    }
					    $prolist99 = substr($prolist99,0,-1);					    
					    $productsIdsString = $prolist99;
						
						
					 	$sql="select p.products_image, pd.products_name, p.products_model, p.products_id from (products_description pd, products p) where p.products_status = '1' and p.products_id = pd.products_id and pd.language_id = '1' and p.products_id in (".$productsIdsString.")";
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
            		
		 
    echo  json_encode($categoryArr);
}

function user_login(){
    header('Access-Control-Allow-Origin: *');
    $servername = "localhost";
    $username = "healingt_user";
    $password = "Madept";
    $dbname = "healint_new";

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
        
        //Traceability
		$category_name=$request->category_name;
		$location=$request->location;
		$user_app_id=$request->user_app_id;
		$action='Login';
		$event=1;
		
		
		traceability_api_trigger($user_app_id,$action,$event,$location);
		
		$categoryArr			= array();
		$categoryArr['data']	= array();
		
		$sql                    = "SELECT * FROM `customers` WHERE `customers_email_address` LIKE '".$email."'";
		$result                 = $conn->query($sql);
		if ($result->num_rows > 0) {
		    while($row = $result->fetch_assoc()) {
			    
			    $password_check = compare_password($password,$row['customers_password']);
			    if($password_check==1){
			        $app_key                = customer_pass_encryption($user_app_id);
			        
			       // $sql1                    = "SELECT cma_id FROM `customer_mobile_app` WHERE `cma_customers_app_id` LIKE '".$user_app_id."'";
            	//	$results                 = $conn->query($sql1);
            	//	if ($results->num_rows > 0) {
            		    // $sql2 = "update customer_mobile_app set cma_customers_id = '" .$row['customers_id'] . "', cma_customers_token = '".$app_key."', cma_customers_location = '".$location."' where `cma_customers_app_id` LIKE '".$user_app_id."'";
                    //$conn->query($sql2); 
            		//}else{
			            $sql3 = "INSERT INTO customer_mobile_app (cma_customers_id, cma_customers_app_id, cma_customers_token, cma_customers_location) VALUES ('".$row['customers_id']."', '".$user_app_id."', '".$app_key."', '".$location."')";
                        $conn->query($sql3);
            		//}
                    
			        $categoryArr['status']  = 'Success';
			        $userArr                = array('user_id'=>$row['customers_id'],
			                                        'user_name'=>$row['customers_firstname'],
			                                        'token'=>$app_key);
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
        $username = "healingt_user";
        $password = "Madept";
        $dbname = "healint_new";
    
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
    
    
    
    function edit_account(){
        
        
        header('Access-Control-Allow-Origin: *');
        $servername = "localhost";
        $username = "healingt_user";
        $password = "Madept";
        $dbname = "healint_new";
    
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
            //Authentication
            $token      = trim($request->security_token);
            $user_id    = trim($request->user_id);
            
            $firstname = trim($request->customers_firstname);
            $lastname= trim($request->customers_lastname);
            //$password= trim($request->password);
            $email_address= trim($request->customers_email_address);
            $telephone= trim($request->customers_telephone);
            $company= trim($request->entry_company);
            $street_address= trim($request->entry_street_address);
            $suburb= trim($request->entry_suburb);
            $city= trim($request->entry_city);
            $state= trim($request->entry_state);
            $postcode= trim($request->entry_postcode);
            $country= trim($request->entry_country_id);
            $company2= trim($request->entry_company2);
            $street_address2= trim($request->entry_street_address2);
            $suburb2= trim($request->entry_suburb2);
            $city2= trim($request->entry_city);
            $state2= trim($request->entry_state2);
            $postcode2= trim($request->entry_postcode2);
            $country2= trim($request->entry_country_id2);
            
            
    		$categoryArr			= array();
    		$categoryArr['data']	= array();
    		
    		$auth                    = "SELECT * FROM `customer_mobile_app` WHERE `cma_customers_id`='".$user_id."' AND `cma_customers_token` LIKE '".$token."'";
		    $auth_result                 = $conn->query($auth);
		if ($auth_result->num_rows > 0) {
           
           
            
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
    		
    		$address_book   = "SELECT address_book_id FROM `address_book` WHERE `customers_id`='".$user_id."'";
    		$address_result    = $conn->query($address_book);
		if ($address_result->num_rows > 0) {
		    $adressArr=array();
		    
		    while($row = $address_result->fetch_array()) {
		        $address=$row['address_book_id'];
		      array_push($adressArr,$address);
		    }
		    $address1=$adressArr[0];
		    $address2=$adressArr[1];
		    
        	   $sql= "update customers set customers_firstname = '" .$firstname . "', customers_lastname = '" .$lastname . "', customers_email_address = '" .$email_address . "', customers_telephone = '" .$telephone . "'  where customers_id = '" . $user_id . "'";
                $conn->query($sql);
		    
		    if(!empty($address1)){
                $sql1 = "update address_book set  entry_firstname = '" .$firstname . "', entry_lastname = '" .$lastname . "', entry_street_address = '" .$street_address . "', entry_postcode = '" .$postcode . "', entry_city = '" .$city . "', entry_country_id = '" .$country . "',entry_company = '" .$company . "',entry_suburb = '" .$suburb . "' ,entry_state = '" .$state . "' where address_book_id = '" . $address1 . "'";
                $conn->query($sql1);
		    }else{
		         $sql1 = "INSERT INTO address_book (customers_id, entry_firstname, entry_lastname, entry_street_address, entry_postcode, entry_city, entry_country_id,entry_company,entry_suburb,entry_zone_id,entry_state ) VALUES ('".$user_id."', '".$firstname."', '".$lastname."', '".$street_address."', '".$postcode."', '".$city."','".$country."','".$company."','".$suburb."','0','".$state."')";
                    $conn->query($sql1);
		    }
		    if(!empty($address2)){
                $sql2 = "update address_book set  entry_firstname = '" .$firstname . "', entry_lastname = '" .$lastname . "', entry_street_address = '" .$street_address2 . "', entry_postcode = '" .$postcode2 . "', entry_city = '" .$city2 . "', entry_country_id = '" .$country2 . "',entry_company = '" .$company2 . "',entry_suburb = '" .$suburb2 . "' ,entry_state = '" .$state2 . "' where address_book_id = '" . $address2 . "'";
                $conn->query($sql2);
		    }else{
		         $sql2 = "INSERT INTO address_book (customers_id, entry_firstname, entry_lastname, entry_street_address, entry_postcode, entry_city, entry_country_id,entry_company,entry_suburb,entry_zone_id,entry_state ) VALUES ('".$user_id."', '".$firstname."', '".$lastname."', '".$street_address2."', '".$postcode2."', '".$city2."','".$country2."','".$company2."','".$suburb2."','0','".$state2."')";
                 $conn->query($sql2);
		        
		    }
                    
		}
		$conn->close(); 
    		
		}
		
    }		
	   
	    echo  json_encode($categoryArr);
        
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
        $username = "healingt_user";
        $password = "Madept";
        $dbname = "healint_new";

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

function add_to_cart(){
    header('Access-Control-Allow-Origin: *');
    $servername = "localhost";
    $username = "healingt_user";
    $password = "Madept";
    $dbname = "healint_new";

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
        
        
        //Traceability
		$category_name=$request->category_name;
		$location=$request->location;
		$user_app_id=$request->user_app_id;
		$action='Add to cart';
		$event=1;
		
		
		traceability_api_trigger($user_app_id,$action,$event,$location);
		
        //Authentication
        $token      = $request->token;
        $user_id    = $request->user_id;
        $product_id = $request->product_id;
        $quantity   = $request->quantity;
        $product_price = $request->product_price;
        
        $sql                    = "SELECT * FROM `customer_mobile_app` WHERE `cma_customers_id`='".$user_id."' AND `cma_customers_token` LIKE '".$token."'";
		$result                 = $conn->query($sql);
		if ($result->num_rows > 0) {
		    
		    $sql = "INSERT INTO customers_basket_attributes (customers_id, products_id,products_options_id, products_options_value_id,app_added_price) VALUES ('".$user_id."', '".$product_id."{1}2', '1', '2',$product_price)";
            $conn->query($sql);
            
            $sql1 = "INSERT INTO customers_basket (customers_id, products_id,customers_basket_quantity, final_price,customers_basket_date_added,app_added_price) VALUES ('".$user_id."', '".$product_id."{1}2', '".$quantity."', '0.0000', '".date('Ymd').",$product_price')";
            $conn->query($sql1);
            
			$categoryArr['status']  = 'Success';
			
			        
			   
		}
    }		
	   
	    echo  json_encode($categoryArr);
		
}

function view_account(){
    
        header('Access-Control-Allow-Origin: *');
        $servername = "localhost";
        $username = "healingt_user";
        $password = "Madept";
        $dbname = "healint_new";
    
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
           
            //Traceability
    		$category_name=$request->category_name;
    		$location=$request->location;
    		$user_app_id=$request->user_app_id;
    		$action='View Account';
    		$event=1;
		
		
    		traceability_api_trigger($user_app_id,$action,$event,$location);
    		
            //Authentication
            $token      = $request->token;
            $user_id    = $request->user_id;
            
            
            
    		$categoryArr			= array();
    		$categoryArr['data']	= array();
    		
    		$auth                    = "SELECT * FROM `customer_mobile_app` WHERE `cma_customers_id`='".$user_id."' AND `cma_customers_token` LIKE '".$token."'";
		    $auth_result                 = $conn->query($auth);
		if ($auth_result->num_rows > 0) {
		    
		    $sql = "SELECT customers_firstname, customers_lastname, customers_email_address, customers_telephone, customers_password, password_updated, ip_address FROM `customers` WHERE `customers_id`='".$user_id."'";
		    $result = $conn->query($sql);
		    if ($result->num_rows > 0) {
		        while($rows = $result->fetch_assoc()) {
		            $customers_firstname    = $rows['customers_firstname'];
		            $customers_lastname = $rows['customers_lastname'];
		            $customers_email_address    = $rows['customers_email_address'];
		            $customers_telephone    = $rows['customers_telephone'];
		        }
		    }
		    
		   $sql1 = "SELECT entry_street_address, entry_postcode, entry_city, entry_country_id,entry_company,entry_suburb,entry_zone_id,entry_state FROM  `address_book` WHERE `customers_id`='".$user_id."'";
		    $results = $conn->query($sql1);
		    if ($results->num_rows > 0) {$i=1;
		        while($rows = $results->fetch_array()) {
		            
		        if($i==1){
		            $entry_street_address   = $rows['entry_street_address'];
		            $entry_postcode = $rows['entry_postcode'];
		            $entry_city    = $rows['entry_city'];
		            $entry_country_id    = $rows['entry_country_id'];
		            $entry_company   = $rows['entry_company'];
		            $entry_suburb = $rows['entry_suburb'];
		            $entry_zone_id    = $rows['entry_zone_id'];
		            $entry_state    = $rows['entry_state'];
		            }elseif($i==2){
		            $entry_street_address2   = $rows['entry_street_address'];
		            $entry_postcode2 = $rows['entry_postcode'];
		            $entry_city2    = $rows['entry_city'];
		            $entry_country_id2    = $rows['entry_country_id'];
		            $entry_company2   = $rows['entry_company'];
		            $entry_suburb2 = $rows['entry_suburb'];
		            $entry_zone_id2    = $rows['entry_zone_id'];
		            $entry_state2    = $rows['entry_state'];
		            }$i=$i+1;
		        }
		    }
		   
		    $cat1   = array(    'customers_firstname'=>$customers_firstname,
								'customers_lastname'=>$customers_lastname,
								'customers_email_address'=>$customers_email_address,
								'customers_telephone'=>$customers_telephone,
								'entry_street_address'=>$entry_street_address,
								'entry_postcode'=>$entry_postcode,
								'entry_city'=>$entry_city,
								'entry_country_id'=>$entry_country_id,
								'entry_company'=>$entry_company,
								'entry_suburb'=>$entry_suburb,
								'entry_zone_id'=>$entry_zone_id,
								'entry_state'=>$entry_state,
								'entry_street_address2'=>$entry_street_address2,
								'entry_postcode2'=>$entry_postcode2,
								'entry_city2'=>$entry_city,
								'entry_country_id2'=>$entry_country_id2,
								'entry_company2'=>$entry_company2,
								'entry_suburb2'=>$entry_suburb2,
								'entry_zone_id2'=>$entry_zone_id2,
								'entry_state2'=>$entry_state2
								);
			$categoryArr['status']  = 'Success';					
			array_push($categoryArr['data'],$cat1);
               
    }else{
        $categoryArr['status']  = 'Error';
    }
    echo  json_encode($categoryArr);
        }
}

function get_app_status(){
    
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
        $app_id = $request->app_id;
        $category = $request->category;
        
        $servername = "localhost";
        $username = "healingt_user";
        $password = "Madept";
        $dbname = "healint_new";

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
    
              
    $sql="select * from customer_meta_mobile where app_id = '".$app_id."' AND category='".$category."' ";

            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
              
              while($row = $result->fetch_assoc()) {
                  $cat1 = array('flag'=>$row['flag']);
                array_push($categoryArr['data'],$cat1);
              }
            }
     }
   
    $conn->close();
    echo  json_encode($categoryArr);
}



function get_token(){
    header('Access-Control-Allow-Origin: *');
    $servername = "localhost";
    $username = "healingt_user";
    $password = "Madept";
    $dbname = "healint_new";

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
        
        //Traceability
        $user_id=trim($request->user_id);
		$location=$request->location;
		$app_id=trim($request->app_id);
		$push_key=trim($request->push_key);
		$action='Token';
		$event=1;
		if($app_id){
		
		traceability_api_trigger($app_id,$action,$event,$location);
		
		$categoryArr			= array();
		$categoryArr['data']	= array();
		
		$app_key                = customer_pass_encryption($app_id);
		
		$sql                    = "SELECT * FROM `customer_mobile_app` WHERE `cma_customers_token` LIKE '".$app_key."' limit 1";
		$result                 = $conn->query($sql);
		if ($result->num_rows > 0) {
		    while($row = $result->fetch_assoc()) {
		         $userArr                = array(
			            'user_id'=>$row['cma_customers_id'],
			            'token'=>$row['cma_customers_token']);
					array_push($categoryArr['data'],$userArr);
		        
		    }
		    
		}else{
		    $app_key    = customer_pass_encryption($app_id);
    		$sql = "INSERT INTO customer_mobile_app (cma_customers_id, cma_customers_app_id, cma_customers_token, cma_customers_location, cma_push_token) VALUES ('".$user_id."', '".$app_id."', '".$app_key."', '".$location."', '".$push_key."')";
                    $conn->query($sql);
                    
			$categoryArr['status']  = 'Success';
			$userArr                = array('user_id'=>$row['customers_id'],
						            'token'=>$app_key);
			array_push($categoryArr['data'],$userArr);
			    
		}
  
    }		
	   
	    echo  json_encode($categoryArr);
    }
}


function mpd_filter(){
    
     $servername = "localhost";
        $username = "healingt_user";
        $password = "Madept";
        $dbname = "healint_new";
    
        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
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
        $filter = trim($request->filter);
        
		$categoryArr=array();
		$categoryArr['status']='Success';
		$categoryArr['error']="";
		$categoryArr['data']=array();
						
			       
		$listing_sql = "SELECT a2t.*,ad.articles_url, a.articles_id, a.authors_id, a.articles_date_added, ad.articles_name, ad.articles_head_desc_tag, ad.articles_description, au.authors_name, sn.detailed_mpd,sn.stone_name_id, a2t.topics_id, SUBSTRING( ad.articles_name ,1 ,1) AS start_letter FROM (articles a, articles_description ad, articles_to_topics a2t) LEFT JOIN authors au ON a.authors_id = au.authors_id LEFT JOIN stone_names sn ON a.articles_id = sn.summary_mpd WHERE (a.articles_date_available IS NULL OR to_days(a.articles_date_available) <= to_days(now())) AND a.articles_status = '1' AND a.articles_id = a2t.articles_id AND ad.articles_id = a2t.articles_id AND ad.language_id = '1' AND a2t.topics_id = '3' and ad.articles_name LIKE '".$filter."%' GROUP BY a.articles_id ORDER BY ad.articles_name";
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
					$pro_array[$i] = substr($pro_array[$i], 0, -1);
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
            				'buy_status'    =>product_availability(trim($rows['stone_name_id'])),
            				'component'=>'MPD'
            				
            			);
            			array_push($categoryArr['data'],$cat1);
            		    }
            		}
    }
     echo  json_encode($categoryArr);
}

function cart_count(){
    header('Access-Control-Allow-Origin: *');
    $servername = "localhost";
    $username = "healingt_user";
    $password = "Madept";
    $dbname = "healint_new";

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
        $request            = json_decode($postdata);
        $user_id            = trim($request->user_id);
        $token              = trim($request->token);
        
		$auth                    = "SELECT * FROM `customer_mobile_app` WHERE `cma_customers_id`='".$user_id."' AND `cma_customers_token` LIKE '".$token."'";
		    $auth_result                 = $conn->query($auth);
		if ($auth_result->num_rows > 0) {
		    $categoryArr			= array();
    		$categoryArr['data']	= array();
    		
    		$sql                    = "SELECT count(customers_basket_id) as backet_count FROM `customers_basket` WHERE `customers_id`=".$user_id."";
    		$result                 = $conn->query($sql);
    		if ($result->num_rows > 0) {
    		    while($row = $result->fetch_assoc()) {
    		        $categoryArr['status']  = 'Success';
			$basketArr                = array('cart_count'=>$row['backet_count']);
			array_push($categoryArr['data'],$basketArr);
    		    }
    		}else{
    		    $categoryArr['status']	= "error";
    		    $categoryArr['error']	        = "Incorrect User";
    		}
		}
  
    }		
	   
	    echo  json_encode($categoryArr);
}

function get_user_checkout_flag(){
    
    
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
        $user_id = trim($request->user_id);
        
     $servername = "localhost";
        $username = "healingt_user";
        $password = "Madept";
        $dbname = "healint_new";

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
    
    					
        $sql="select flag from customer_redirect_payment  where customer_id = ".$user_id."";
        
        $result = $conn->query($sql);
    	if ($result->num_rows > 0) {
    	    $cat1=array('flag'=>1);
    		array_push($categoryArr['data'],$cat1);
    		
    	}else{
    	    $cat1=array('flag'=>0);
    		array_push($categoryArr['data'],$cat1);
    	}
     }
   
    $conn->close();
    echo  json_encode($categoryArr);
}

function delete_user_checkout_flag(){
    
    
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
        $user_id = trim($request->user_id);
        
     $servername = "localhost";
        $username = "healingt_user";
        $password = "Madept";
        $dbname = "healint_new";

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
    
    					
        $sql="DELETE FROM `customer_redirect_payment` WHERE `customer_redirect_payment`.`id` = ".$user_id."";
        $result = $conn->query($sql);
    	
     }
   
    $conn->close();
    echo  json_encode($categoryArr);
}

function notification(){
    
    
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
        $user_id = trim($request->user_id);
        
     $servername = "localhost";
        $username = "healingt_user";
        $password = "Madept";
        $dbname = "healint_new";

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
    
    					
        $sql="select * from customer_mobile_notification where cn_user_id = ".$user_id." order by `cn_status` ASC, `cn_date` DESC";
        $result = $conn->query($sql);
    	if ($result->num_rows > 0) {
    	    while($row = $result->fetch_assoc()) {
    	    $cat1   = array('subject'=>$row['cn_subject'],
        	                'status'=>$row['cn_status'],
        	                'date'=>$row['cn_date'],
        	                'id'=>$row['cn_id']);
    		array_push($categoryArr['data'],$cat1);
    	    }
    	}
    	
     }
   
    $conn->close();
    echo  json_encode($categoryArr);
}

function notification_detail(){
    
    
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
        $id = trim($request->id);
        
     $servername = "localhost";
        $username = "healingt_user";
        $password = "Madept";
        $dbname = "healint_new";

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
    
    					
        $sql="select * from customer_mobile_notification where cn_id = ".$id."";
        $result = $conn->query($sql);
    	if ($result->num_rows > 0) {
    	     $sql2 = "update customer_mobile_notification set cn_status = '1' where cn_id = '" . $id . "'";
             $conn->query($sql2);
             while($row = $result->fetch_assoc()) {
            	    $cat1   = array('subject'=>$row['cn_subject'],
            	                    'description'=>$row['cn_description'],
                	                'status'=>$row['cn_status'],
                	                'date'=>$row['cn_date'],
                	                'id'=>$row['cn_id']);
            		array_push($categoryArr['data'],$cat1);
             }
    	}
    	
     }
   
    $conn->close();
    echo  json_encode($categoryArr);
}

function product_availability($category_buy=0){
    header('Access-Control-Allow-Origin: *');
   $servername = "localhost";
   $username = "healingt_user";
   $password = "Madept";
   $dbname = "healint_new";
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $flag=0;
	$productsIdsString='';
	$sql="select distinct p.products_id from products p, products_to_stones pts where pts.products_id = p.products_id and (pts.stone_name_id = ".$category_buy.") and p.products_status = 1 and (p.products_model like '%' or p.products_model like 'D%')";
						
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		// output data of each row
		while($row = $result->fetch_assoc()) {
				$productsIdsString.=$row['products_id'].',';
		}
	}
	$prolist87= rtrim($productsIdsString,',');
	$prolist87 = explode(',',$prolist87);
	foreach($prolist87 as $value){
		if(tep_get_product_quantity($value) === false)
			continue;
			$prolist99 .= $value.','; 
		}
	$prolist99 = substr($prolist99,0,-1);					    
	$productsIdsString = $prolist99;
						
						
	$sql="select p.products_image, pd.products_name, p.products_model, p.products_id from (products_description pd, products p) where p.products_status = '1' and p.products_id = pd.products_id and pd.language_id = '1' and p.products_id in (".$productsIdsString.")";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		$flag=1;
	}
	$conn->close(); 
	return $flag;
}



function getChildStonesIds($id){
    $servername = "localhost";
   $username = "healingt_user";
   $password = "Madept";
   $dbname = "healint_new";

   $conn = new mysqli($servername, $username, $password, $dbname);
    $stone_query = "select stone_name_id from stone_names where parent_stone_id = '".$id."'";
    $stone_array = array();	
   $result = $conn->query($stone_query);						    
    if($result->num_rows > 0){
        while($array = $result->fetch_assoc()){
            $stone_array[] = $array['stone_name_id'];
			$stone_child_query = "select stone_name_id from stone_names where parent_stone_id = '".$array['stone_name_id']."'";
			$results = $conn->query($sql);
			if($results->num_rows > 0){
				$stone_child_array = array();
				while($stone_child = $results->fetch_assoc()){
					$stone_child_array[] = $stone_child['stone_name_id'];	
				}
				$stone_array = array_merge($stone_array, $stone_child_array);
			}
        }
    }
	$stone_array = array_unique($stone_array); 
    return $stone_array;
}

function check(){
   $servername = "localhost";
   $username = "healingt_user";
   $password = "Madept";
   $dbname = "healint_new";

   $conn = new mysqli($servername, $username, $password, $dbname);

   if ($conn->connect_error) {
       die("Connection failed: " . $conn->connect_error);
} 
   $conn = new mysqli($servername, $username, $password, $dbname);
   header('Access-Control-Allow-Origin: *');
$categoryArr=array();
$categoryArr['status']='Success';
$categoryArr['error']="";
$categoryArr['data']=array();
$category_level=2;
$category_id=296;
			    
		
		
				 
					        
					        $childStoneIdsArray = getChildStonesIds($category_id);
					        if (!empty($childStoneIdsArray)) {
					            $childStoneStr = " or (pts.stone_name_id in (" . implode(',', $childStoneIdsArray) . "))";
					        }
					        
					       echo $sql = "select distinct p.products_id from products p, products_to_stones pts where pts.products_id = p.products_id and (pts.stone_name_id = '" . $category_id . "'".$childStoneStr.") and (p.products_model like '%' or p.products_model like 'D%')";
					         
					       $result = $conn->query($sql);
						if ($result->num_rows > 0) {
							// output data of each row
							while($row = $result->fetch_assoc()) {
							    $productsIdsString.=$row['products_id'].',';
							    
							}
						}
						$prolist87= rtrim($productsIdsString,',');
					    $prolist87 = explode(',',$prolist87);
					    foreach($prolist87 as $value){
					        if(tep_get_product_quantity($value) === false)
					        continue;
					        $prolist99 .= $value.','; 
					    }
					    $prolist99 = substr($prolist99,0,-1);					    
					    $productsIdsString = $prolist99;
						
						
					 	$sql="select p.products_image, pd.products_name, p.products_model, p.products_id from (products_description pd, products p) where p.products_status = '1' and p.products_id = pd.products_id and pd.language_id = '1' and p.products_id in (".$productsIdsString.")";
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
				 
			    echo '<pre>';
			    print_r($categoryArr);
}





?>