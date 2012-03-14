<?php
require_once ('../config.php');
require_once ('functions.php');
date_default_timezone_set('GMT');
$date = date( 'U' );  
$card_id =  $_GET['card_id'];
if (isset($_GET['img'])){$old_img = $_GET['img'];}else{$old_img='';}
$bkg_w = 800;
$bkg_h= 800;
//check if there are files uploaded
if ((($_FILES['value']["type"] == "image/gif")
|| ($_FILES['value']["type"] == "image/jpeg")
|| ($_FILES['value']["type"] == "image/png")
|| ($_FILES['value']["type"] == "image/pjpeg"))
&& ($_FILES['value']["size"] < 15000000)
&& (!empty($_FILES['value']['tmp_name']))
&& ($_FILES['value']['tmp_name'] != 'none'))
  {       
       list($width, $height) = getimagesize($_FILES['value']['tmp_name']);
       //if (($width>=800)&&($height>=500)){
           //$new_filename = md5($date.$_FILES['value']['name']).'.'.pathinfo($_FILES['value']['name'], PATHINFO_EXTENSION);
           $new_filename = md5($date.$_FILES['value']['name']);
           $im = imagecreatefromstring(file_get_contents($_FILES['value']['tmp_name']));
           if (imagejpeg($im, UPLOADS_DIR.$new_filename.'.jpg')){
               $b_im = resize_image_max(UPLOADS_URL.$new_filename.'.jpg',$bkg_w,$bkg_h);
               imageinterlace($b_im, true);
               imagejpeg($b_im, UPLOADS_DIR.$new_filename.'_l.jpg');
               $t_im = width_tumb(UPLOADS_URL.$new_filename.'.jpg',260);
               imageinterlace($t_im, true);
               imagejpeg($t_im, UPLOADS_DIR.$new_filename.'_t.jpg');
               imagedestroy($im);
               imagedestroy($b_im);
               imagedestroy($t_im);
              $saved_card_json = callAPI("card/put?id=".$card_id.'&image='.$new_filename);
              $saved_card = json_decode($saved_card_json);
              if (isset($saved_card)){
                  if(file_exists(UPLOADS_DIR.$old_img.'.jpg')) unlink(UPLOADS_DIR.$old_img.'.jpg');
                  if(file_exists(UPLOADS_DIR.$old_img.'_l.jpg')) unlink(UPLOADS_DIR.$old_img.'_l.jpg');
                  if(file_exists(UPLOADS_DIR.$old_img.'_t.jpg')) unlink(UPLOADS_DIR.$old_img.'_t.jpg');
                  echo(UPLOADS_URL.$new_filename.'_l.jpg');
                }else{
                 return die ("There was a problem saving the file.".$new_filename);
              }
          }else{
              return die ("There was a problem saving the file.");
          }
      //}else{
           //return die ("File too small, minimum size 800x600.");
      //}
          
          
} else {			
//print "No file has been uploaded.";
	return die ("Please upload a valid gif, jpg or png under 15Mb");
	//die();
} 