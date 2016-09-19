<?php  
	
	function markPhoto ($photo, $watermark_png_file, $destination_folder){
		if(isset($photo))
		{
		    $max_size = 800; //max image size in Pixels
		    // $destination_folder = 'path/to/upload/folder';
		    // $watermark_png_file = "../img/logo.png"; //path to watermark image
		    
		    $image_name = $photo['name']; //file name
		    $image_size = $photo['size']; //file size
		    $image_temp = $photo['tmp_name']; //file temp
		    $image_type = $photo['type']; //file type

		    switch(strtolower($image_type)){ //determine uploaded image type 
		            //Create new image from file
		            case 'image/png': 
		                $image_resource =  imagecreatefrompng($image_temp);
		                break;
		            case 'image/gif':
		                $image_resource =  imagecreatefromgif($image_temp);
		                break;          
		            case 'image/jpeg': case 'image/pjpeg':
		                $image_resource = imagecreatefromjpeg($image_temp);
		                break;
		            default:
		                $image_resource = false;
		        }
		    
		    if($image_resource){
		        //Copy and resize part of an image with resampling
		        list($img_width, $img_height) = getimagesize($image_temp);
		        
		        //Construct a proportional size of new image
		        $image_scale        = min($max_size / $img_width, $max_size / $img_height); 
		        $new_image_width    = ceil($image_scale * $img_width);
		        $new_image_height   = ceil($image_scale * $img_height);
		        $new_canvas         = imagecreatetruecolor($new_image_width , $new_image_height);

		        //Resize image with new height and width
		        if(imagecopyresampled($new_canvas, $image_resource , 0, 0, 0, 0, $new_image_width, $new_image_height, $img_width, $img_height))
		        {
		            
		            if(!is_dir($destination_folder)){ 
		                mkdir($destination_folder);//create dir if it doesn't exist
		            }
		            
		            //calculate center position of watermark image
		            $watermark_left = ($new_image_width - 250); //watermark left
		            $watermark_bottom = ($new_image_height - 50); //watermark bottom

		            $watermark = imagecreatefrompng($watermark_png_file); //watermark image

		            //use PHP imagecopy() to merge two images.
		            $new_img = imagecopy($new_canvas, $watermark, $watermark_left, $watermark_bottom, 0, 0, 300, 100); //merge image
		            
		            //output image direcly on the browser.
		            // header('Content-Type: image/jpeg');
		            // imagejpeg($new_canvas, NULL , 90);
		            
		            //Or Save image to the folder
		            imagejpeg($new_canvas, $destination_folder.'/'.$image_name , 90);
		            
		            //free up memory
		            imagedestroy($new_canvas); 
		            imagedestroy($image_resource);
		            // die();
		            return $new_img;
		        }
		    }
		}
	}
	//just css
	function put_styles(){
		echo "<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,700' rel='stylesheet' type='text/css'>";
		echo "<link rel='stylesheet' type='text/css' href='.." . DS . ".." . DS . "css" . DS . "main.css'>";
	}

	function title() {
		echo "Hotel Insignia";
	}
	function subtitle() {
		echo "The sign of the world's most elegant hotel";
	}

	//validation functions
	function has_presence($value) {
		return isset($value) && $value !== "";
	}

	//loop through required fields
	function validate_presence($required_fields) {
		global $errors;

		foreach ($required_fields as $field) {
			$value = trim($_POST[$field]);
			if (!has_presence($value)) {
				$errors[$field] = field_name_to_text($field) . " cant be blank.";
			}
		}
	}

	function validate_directory($dir) {
		global $errors;

		if(is_dir($dir)) {
			$errors[] = "room already exist";
		}
	}

	function validate_captcha($captcha, $typed) {
		global $errors;
		$typed = isset($typed) ? trim($typed) : "";
		if($captcha !== $typed) $errors[] = "Invalid Captcha";	
	}

	function validate_image($image_file="", $target_dir) {
		global $errors;
		$target_file = $target_dir.basename($image_file['name']);
		$is_image = !empty($image_file) ? @getimagesize($image_file['tmp_name']) : null;

		if (empty($image_file['name'])) {
			//comment muna
			//$errors[] = "Please select a picture!";
		} else if (file_exists($target_file)) {
			$errors[] = "file already exists.";
		} else if ($is_image === false) {
			$errors[] = "It is not an image...";
		} else if ($image_file['size'] > 2500000) {
			$errors[] = "image is too large..";
		} else {
			return true;
			//move_uploaded_file($image_file['tmp_name'], $target_file);
		}

	}

	function password_comparison($pass1="", $pass2="") {
		global $errors;
		if ($pass1 !== $pass2) $errors[] = "password dont match."; 		 
	}

	//display form errors
	function form_errors() {
		global $errors;
		if (is_array($errors)) {
			foreach($errors as $error) {
				echo $error . "<br/>";
			}
 		}
	}

	function field_name_to_text($field_name) {
		$field_name = str_replace("_", " ", $field_name);
		$field_name = ucfirst($field_name);
		return $field_name;
	}

	//end of validations

	function redirect_to($new_location) {
		header("Location: {$new_location}");
		exit();
	}

	function strip_zeros_from_date($marked_string="") {
		//remove the marked zeros
		$no_zeros = str_replace('*0', "", $marked_string);
		// remove any remaining marks
		$cleaned_string = str_replace('*','', $no_zeros);
		return $cleaned_string;
		// usage
		// echo strip_zeros_from_date(strftime("today is *%m/*%d/%y", $timestamp));
	}

	function get_mysql_datetime($dt) {
		//$dt = time();
		$mysql_datetime = strftime("%Y-%m-%d %H:%M:%S", $dt);
		return $mysql_datetime;		
	}

	//
	function select_option($limit=0, $name="", $index=0) {
		global $session;
		$output  = "<select name=\"{$name}\">";
		//var_dump($session->has_person($postName));
			if ($session->has_person($index)) {
				$output .= "<option value=0>" . $session->noOfPersons[$index] . "</option>";
			} 
			for ($i = 1; $i <=$limit; $i++) {
				$output .= "<option value={$i}>{$i}</option>";	
			}
		$output .= "</select>";
		return $output; 
	}

	//rearray_files
	function reArrayFiles(&$file_post) {

	    $file_ary = array();
	    $file_count = count($file_post['name']);
	    $file_keys = array_keys($file_post);

	    for ($i=0; $i<$file_count; $i++) {
	        foreach ($file_keys as $key) {
	            $file_ary[$i][$key] = $file_post[$key][$i];
	        }
	    }

	    return $file_ary;
	}	
	// loads automatically upon requiring
	function __autoload($class_name) {
		$class_name = strtolower($class_name);
		$path = LIB_PATH.DS."{$class_name}.php";
		if (file_exists($path)) {
			require_once($path);
		} else {
			die("The file {$class_name}.php could not be found. ");
		}
	}

	function format_date($strDate) {
		// return $strDate;
		return $strDate == "0000-00-00 00:00:00" ? "0000-00-00 00:00 am" : date("Y-m-d g:i a", strtotime($strDate));
	}

	//newly created function
	function BACKUPcreateJSONEntity($holder, $objArr) {
		$otString = '"' . $holder . '":[';
		$otArray = array();

		foreach ($objArr as $key => $eachObj) {
			$otArray[] = $eachObj->toJSON();
		}

		$otString .= "{" . join("},{", $otArray) . "}";
		$otString .= "]";

		return $otString;
	}	

	//handles array of object of the models
	function createJSONEntity($holder, $objArr, $customized=false) {
		$otString = '"' . $holder . '":[';
		
		if (empty($objArr)) {
			return $otString .= ']';
		}
		
		$otArray = array();

		foreach ($objArr as $key => $eachObj) {
			$otArray[] = !$customized ? $eachObj->toJSON() : $eachObj->toJSON($customized);
		}

		$otString .= "{" . join("},{", $otArray) . "}";
		$otString .= "]";

		return $otString;
	}	

	function cym_decode_unicode($str) {
		   $pattern = "/[\"'<>]/";
   		   return preg_replace($pattern, "", $str);		
	}	

	function time_txt_to_24hour($str_time, $period) {
		$time_array = explode(":", $str_time);
		if ($period == "pm" || $period == "PM") {
			$time_array[0] += 12;
		}
		return implode(":", $time_array);
	}
?>