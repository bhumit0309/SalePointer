<?php
$get_data = array();
$base_URL = "http://www.wincoredata.com/PHPTesting/";
    $files = glob("banners/*.*");
    for ($i=0; $i<count($files); $i++)
     {
       $image = $files[$i];
       $supported_file = array(
               'gif',
               'jpg',
               'jpeg',
               'png'
        );
 
        $ext = strtolower(pathinfo($image, PATHINFO_EXTENSION));
        if (in_array($ext, $supported_file)) {
             $get_data['SalePointer'][] = array(
				'status' => 'true',
                'banner_url' => $base_URL."".$image,
			);
            
          // echo basename($image)."<br />"; // show only image name if you want to show full path then use this code //
            //echo $image."<br />";
           //    echo '<img src="'.$image .'" alt="Random image" />'."<br /><br />";
           } else {
               continue;
           }
        }
        echo json_encode($get_data);
      ?>