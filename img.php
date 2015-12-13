<?php

//Loads images given through show argument
//checks if user requesting is either admin or user with rights
//rights are given comparing filename beginning with user if (passed through session c)
require('wp-load.php');


//get id from previous page
session_start();
$current_user_id=$_SESSION['c'];
session_write_close();

//set secret PDF-only key.
$key=""

//find out what's the user's role.
global $current_user;
$userRole = ($current_user->roles);
$role = current($userRole);


if (isset($_GET['show'])&&is_user_logged_in()) {


		$filename="{$_GET['show']}";
		$pdfFilename=substr($filename,0,16);


//check if pdf is in use
if($pdfFilename==$key){

		$filename=str_replace($key, '', $filename);
		$img="../../Subidas_cliente/".$filename;

		$imgjpg=$img.'.jpg';
        $imgjpeg=$img.'.jpeg';
        $imgpng=$img.'.png';


		if (file_exists($imgjpg)){header('Content-Type: image/jpeg');readfile($imgjpg);exit;
			}
        //JPEG CASE

        elseif (file_exists($imgjpeg)){header('Content-Type: image/jpeg');readfile($imgjpeg);exit;
        	}
        //PNG CASE

        elseif (file_exists($imgpng)){header('Content-Type: image/png');readfile($imgpng);exit;
		}
		else{
                    header('Content-Type: image/jpeg');
                    readfile('../../Subidas_cliente/default.jpg');
                    exit;
                    }

}else{
	$idLength=strlen($current_user_id);

	if ($idLength>0){

		$img="../../Subidas_cliente/{$_GET['show']}";

		$imgjpg=$img.'.jpg';
        $imgjpeg=$img.'.jpeg';
        $imgpng=$img.'.png';

        //JPG CASE

		if (file_exists($imgjpg)){
			if($role!='subscriber'){header('Content-Type: image/jpeg');readfile($imgjpg);exit;}
			else{

				$tmp=substr($filename,0,$idLength);

				$r=strcmp($tmp, $current_user_id);

				if ($r==0){

					header('Content-Type: image/jpeg');

					//readfile
					readfile($imgjpg);
                    exit;
				}else{
					header('Content-Type: image/jpeg');
   	 				readfile('../../Subidas_cliente/default.jpg');
                    exit;
					}
			}
        }
        //JPEG CASE

        elseif (file_exists($imgjpeg)){
            if($role!='subscriber'){header('Content-Type: image/jpeg');readfile($imgjpeg);exit(0);}
            else{

                $tmp=substr($filename,0,$idLength);

                $r=strcmp($tmp, $current_user_id);

                if ($r==0){

                    header('Content-Type: image/jpeg');

                    //readfile
                    readfile($imgjpeg);
                    exit(0);
                }else{
                    header('Content-Type: image/jpeg');
                    readfile('../../Subidas_cliente/default.jpg');
                    exit(0);
                    }
            }
        }
        //PNG CASE

        elseif (file_exists($imgpng)){
            if($role!='subscriber'){header('Content-Type: image/png');readfile($imgpng);exit(0);}
            else{

                $tmp=substr($filename,0,$idLength);

                $r=strcmp($tmp, $current_user_id);

                if ($r==0){

                    header('Content-Type: image/png');

                    //readfile
                    readfile($imgpng);
                    exit;
                }else{
                    header('Content-Type: image/jpeg');
                    readfile('../../Subidas_cliente/default.jpg');
                    exit;
                    }
            }
        }else{
		header('Content-Type: image/jpeg');
   	    readfile('../../Subidas_cliente/default.jpg');
         exit;
	   }

    }else{
    exit;}
}




}else{
   exit;
 }

?>