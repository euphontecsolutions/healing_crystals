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
	$slide1=array('slide_id'=>1,'slide_text'=>'Welcome to the Healing Crystals Metaphysical Directory App!',"url"=>base_url.api_path."images/slider/slider_image_1.jpg");
	$slide2=array('slide_id'=>2,'slide_text'=>'Search over 3,000 crystals! Sort by various attributes including chakra healing, and much more.',"url"=>base_url.api_path."images/slider/slider_image_2.jpg");
//	$slide3=array('slide_id'=>3,'slide_text'=>'Sign up! Save crystals, save searches, & learn about crystals.',"url"=>base_url.api_path."images/slider/slider_image_3.jpg");
//	$slide4=array('slide_id'=>4,'slide_text'=>'Be the first to know! Get updates via newsletters & daily nuggets.',"url"=>base_url.api_path."images/slider/slider_image_4.jpg");
	$slide5=array('slide_id'=>5,'slide_text'=>'Promoting education and use of crystals to support healing.',"url"=>base_url.api_path."images/slider/slider_image_5.jpg");	
	
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
	$cat1=array('category_id'=>1,'category_level'=>1,'slider'=>1,'category_name'=>'Crystals For Common Conditions',"image_url"=>base_url.api_path."images/category/catg_image_1.jpg");	
	$cat2=array('category_id'=>2,'category_level'=>1,'slider'=>1,'category_name'=>'Store Catalog',"image_url"=>base_url.api_path."images/category/catg_image_2.jpg");
	$cat3=array('category_id'=>3,'category_level'=>1,'slider'=>1,'category_name'=>'Metaphysical Guide',"image_url"=>base_url.api_path."images/category/catg_image_3.jpg");
	$cat4=array('category_id'=>4,'category_level'=>1,'slider'=>1,'category_name'=>'Formation Guide',"image_url"=>base_url.api_path."images/category/catg_image_4.jpg");
	$cat5=array('category_id'=>5,'category_level'=>1,'slider'=>1,'category_name'=>'Crystal by Color',"image_url"=>base_url.api_path."images/category/catg_image_5.jpg");
	$cat6=array('category_id'=>6,'category_level'=>1,'slider'=>1,'category_name'=>'Crystal Safeguard',"image_url"=>base_url.api_path."images/category/catg_image_6.jpg");
	$cat7=array('category_id'=>7,'category_level'=>1,'slider'=>1,'category_name'=>'More Crystal Information',"image_url"=>base_url.api_path."images/category/catg_image_7.jpg");
	
	
	array_push($categoryArr['data'],$cat1);
	array_push($categoryArr['data'],$cat2);
	array_push($categoryArr['data'],$cat3);
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
		
		if($slider==1){
				if($category_level==1){
				
					$cat1='';
					$cat2='';
					$cat3='';
					 
					$categoryArr			= array();
					$categoryArr['status']	= 'Success';
					$categoryArr['error']	= "";
					$categoryArr['data']	= array();
				
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
								$cat1=array('category_id'=>$row['tag_id'],'slider'=>1,'category_level'=>3,'category_name'=>$row['tag_name'],'component'=>'category');
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
						
						$sql="select p.products_id,pts.stone_name_id, stone_name, count(p.products_id) as count from products_to_stones pts, stone_names s, products p where s.stone_name_id = pts.stone_name_id and pts.products_id = p.products_id and p.products_status = 1 and (p.products_model like '%' or p.products_model like 'D%') and pts.stone_name_id in (select st.stone_name_id from stone_tags st, taglist tl where st.tag_id = tl.tag_id and tl.tag_id = '".$category_id."') group by stone_name_id order by stone_name ASC  limit 10";
						$result = $conn->query($sql);
						if ($result->num_rows > 0) {
							// output data of each row
							while($row = $result->fetch_assoc()) {
								$cat1=array('category_id'=>$row['products_id'],'slider'=>1,'category_level'=>4,'category_name'=>$row['stone_name'],'component'=>'products');
								array_push($categoryArr['data'],$cat1);
							}
						}
					 $conn->close(); 	
				}
				
				else if($category_level==4){
					$categoryArr=array();
						$categoryArr['status']='Success';
						$categoryArr['error']="";
						$categoryArr['data']=array();
						
						$sql="select p.products_id, pd.products_name, pd.products_description, p.products_model, p.products_quantity, p.products_image, p.products_image_med, p.products_image_lrg, p.products_image_sm_1, p.products_image_xl_1, p.products_image_sm_2, p.products_image_xl_2, p.products_image_sm_3, p.products_image_xl_3, p.products_image_sm_4, p.products_image_xl_4, p.products_image_sm_5, p.products_image_xl_5, p.products_image_sm_6, p.products_image_xl_6, p.products_image_sm_7, p.products_image_xl_7, p.products_image_sm_8, p.products_image_xl_8, p.products_image_sm_9, p.products_image_xl_9, p.products_image_sm_10, p.products_image_xl_10, p.products_image_sm_11, p.products_image_xl_11, p.products_image_sm_12, p.products_image_xl_12, p.products_image_alt, p.products_image_alt_1, p.products_image_alt_2, p.products_image_alt_3, p.products_image_alt_4, p.products_image_alt_5, p.products_image_alt_6, p.products_image_alt_7, p.products_image_alt_8, p.products_image_alt_9, p.products_image_alt_10,p.products_image_alt_11,p.products_image_alt_12, pd.products_url, p.products_price, p.products_tax_class_id, p.products_date_added, p.products_date_available, p.manufacturers_id from products p, products_description pd where p.products_id = '".$category_id."' and pd.products_id = p.products_id and pd.language_id = '1'";
						$result = $conn->query($sql);
						if ($result->num_rows > 0) {
							// output data of each row
							while($row = $result->fetch_assoc()) {
								$cat1=array('category_id'=>$row['products_id'],'slider'=>1,'category_level'=>5,'category_name'=>$row['products_name'],'product_description'=>$row['products_description'],'component'=>'product');
								array_push($categoryArr['data'],$cat1);
							}
						}
					 $conn->close(); 	
				}
				
	    }//slidert 1
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
function check(){
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
    //$productsIdsStrings='';
						$sql="select distinct p.products_id from products p where p.products_id and p.products_status = 1 and (p.products_model like 'A%' or p.products_model like 'DA%')";
						$result = $conn->query($sql);
					//	echo $numItems = count($sql);die();
						$i = 0;
						if ($result->num_rows > 0) {//print_r($result->fetch_assoc());die();
							while($row = $result->fetch_assoc()) {
							    $productsIdsStrings.= trim($row['products_id']).',';
							   
								
							//	$productsIdsStrings.= ', ';
							    
							}
							
						}
						$productsIds=rtrim($productsIdsStrings,',');
						
						
if($productsIds!=''){
						 $sql1="select p.products_image, pd.products_name, p.products_model, p.products_id from (products_description pd, products p) where p.products_status = '1' and p.products_id = pd.products_id and pd.language_id = '1' and p.products_id in (".$productsIds.")";
						
						$result = $conn->query($sql1);
						
						if ($result->num_rows > 0) {
							while($row = $result->fetch_assoc()) {
							echo $row['products_id'];
								$cat1=array('category_id'=>$row['products_id'],'slider'=>2,'category_level'=>3,'category_name'=>$row['products_name'],'product_image'=>$row['products_image'],'component'=>'product');
								array_push($categoryArr['data'],$cat1);
							}
							
						}
					}
}
?>