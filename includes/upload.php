<?php
require_once ('../config.php');
require_once ('functions.php');
date_default_timezone_set('GMT');
$date = date( 'U' );  
$card_id =  $_GET['card_id'];
//old imgae to delete
if (isset($_GET['img'])){$old_img = $_GET['img'];}else{$old_img='';}
//max sizes
$bkg_w = 800;
$bkg_h= 800;
function checkType($inMimeArray, $fieldName){
    $FILES_type_pass = false;
    $IMAGE_type_check = false;
    $imgArray = array(
                "image/gif",
                "image/jpeg",
                "image/pjpeg",
                "image/tiff",
                "image/png");

    $imgTypeConstants = array(
        IMAGETYPE_GIF,
        IMAGETYPE_JPEG,
        IMAGETYPE_PNG,
        IMAGETYPE_BMP,
        IMAGETYPE_TIFF_II,
        IMAGETYPE_TIFF_MM);

        $testFile = escapeshellcmd($_FILES[$fieldName]['tmp_name']);
        // PECL fileinfo 
        // http://pecl.php.net/package/fileinfo
        // http://wiki.cc/php/Fileinfo
        // http://us2.php.net/mime_magic
        $res                                    = finfo_open(FILEINFO_MIME_TYPE);
        $tmpMIME                                = finfo_file($res,$testFile);
        finfo_close($res);
        // end PECL fileinfo
        
        $checkImage                             = (in_array($tmpMIME, $imgArray) ? true : false);

        if($_FILES[$fieldName]["error"] == "0"){
                if(is_array($inMimeArray) && sizeof($inMimeArray)){

                        $FILES_type_pass        = (in_array($_FILES[$fieldName]["type"], $inMimeArray) ? true : false);
                        $MIME_type_pass         = (in_array($tmpMIME, $inMimeArray) ? true : false);

                        if($checkImage){
                                foreach($imgTypeConstants as $constantVal){
                                        if(exif_imagetype($_FILES[$fieldName]['tmp_name']) == $constantVal){
                                                $IMAGE_type_check       = true;
                                                break;
                                        }
                                }

                                $MIME_type_pass = ($IMAGE_type_check ? true : false);
                        }

                }else{
                        unlink($_FILES[$fieldName]["tmp_name"]);
                        return die ("There was a problem saving the file.");
                }

        }else{
                return die ("There was a problem saving the file.");

        }

        $retVal         =   ($MIME_type_pass ? true : false);

        if(!$retVal){
                $msg    = serialize($inMimeArray).chr(10).chr(10);
                return die ("<span class=\"red\">Please upload a valid jpg, gif or png.</span>");
        }
        return $retVal;

}

if(isset($_FILES["value"]["size"]) && $_FILES["value"]["size"] > 0){

        if(is_uploaded_file($_FILES['value']['tmp_name'])){

                $allowedTypes   = array("image/gif",
                                        "image/jpeg",
                                        "image/pjpeg",
                                        "image/png");

                if(checkType($allowedTypes,"value")){

                        //make large & thumbnail and save all in uploads folder
                        list($width, $height) = getimagesize($_FILES['value']['tmp_name']);
                        $new_filename = md5($date.$_FILES['value']['name']);
                        $original = UPLOADS_DIR.$new_filename.'.jpg';
                        $large = UPLOADS_DIR.$new_filename.'_l.jpg';
                        $thumb = UPLOADS_DIR.$new_filename.'_t.jpg';
                        $im = imagecreatefromstring(file_get_contents($_FILES['value']['tmp_name']));
                        //if original
                        if (imagejpeg($im, $original)){
                                   //do large
                                   $b_im = resize_image_max($original,$bkg_w,$bkg_h);
                                   imageinterlace($b_im, true);
                                   imagejpeg($b_im, $large);
                                   //do thumbnail
                                   $t_im = width_tumb($original,260);
                                   imageinterlace($t_im, true);
                                   imagejpeg($t_im, $thumb);
                                   imagedestroy($im);
                                   imagedestroy($b_im);
                                   imagedestroy($t_im);
                                   chmod($original,0644);
                                   chmod($large,0644);
                                   chmod($thumb,0644);
                                   //save name in database
                                  $saved_card_json = callAPI("card/put?id=".$card_id.'&image='.$new_filename);
                                  $saved_card = json_decode($saved_card_json);
                                  if (isset($saved_card)){
                                      //delete old
                                      if(file_exists(UPLOADS_DIR.$old_img.'.jpg')) unlink(UPLOADS_DIR.$old_img.'.jpg');
                                      if(file_exists(UPLOADS_DIR.$old_img.'_l.jpg')) unlink(UPLOADS_DIR.$old_img.'_l.jpg');
                                      if(file_exists(UPLOADS_DIR.$old_img.'_t.jpg')) unlink(UPLOADS_DIR.$old_img.'_t.jpg');
                                      //return file name
                                      echo(UPLOADS_URL.$new_filename);
                                    }else{
                                      return die ("There was a problem saving the file.");
                                  }
                              }else{
                                  return die ("There was a problem saving the file.");
                              }
                        
                }

        }else{
            return die ("There was a problem saving the file.");
        }

}

?>