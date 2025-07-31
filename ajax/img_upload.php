<?php
//Check if we are getting the image
if(isset($_FILES['image'])){

  /*
    // file
      if (!is_dir($picsPath)) {
        mkdir($picsPath, 0775, true);
      }
      $target_file = $picsPath . '/' . basename($newFileName);
*/

        //Get the image array of details
        $img = $_FILES['image'];
        //The new path of the uploaded image, rand is just used for the sake of it
        // check
        $target_file_temp = explode(".", $img['name']);
        $fileExtension = strtolower(end($target_file_temp));
        $allowedfileExtensions = array('jpg', 'jpeg', 'gif', 'png', 'webp', 'bmp');
        if (!in_array($fileExtension, $allowedfileExtensions)) {
          echo json_encode(["result"=>'Неизвестный формат файла.']);
          exit();
        }
        // file
        $newFileName = md5(time() . $img['name']) . ".{$fileExtension}";
        $path = __DIR__ . "/img/announcement/" . $newFileName;
        //Move the file to our new path
        move_uploaded_file($img['tmp_name'],$path);
        //Get image info, reuiqred to biuld the JSON object
        $data = getimagesize($path);
        //The direct link to the uploaded image, this might varyu depending on your script location
        $link = "https://{$_SERVER['HTTP_HOST']}/ajax/img/announcement/" . $newFileName;
        //Here we are constructing the JSON Object
        $id = "ajax/img/announcement/{$newFileName}";
        $res = array("status" => 200, "success" => true, "data" => array(
          "id" => "Rt1O7lk", // $id,
          "deletehash" => "HIVo1yxnQMGz9SQ",
          "link" => $link,
          "width" => $data[0],
          "height" => $data[1],
          "size" => $img['size'],
          "type" => $data['mime'],
          "account_id" => null,
          "account_url" => null,
          "ad_type" => null,
          "ad_url" => null,
          "title" => null,
          "description" => null,
          "name" => "",
          "views" => 0,
          "section" => null,
          "vote" => null,
          "bandwidth" => 0,
          "animated" => false,
          "favorite" => false,
          "in_gallery" => false,
          "in_most_viral" => false,
          "has_sound" => false,
          "is_ad" => false,
          "nsfw" => null,
          "tags" => [],
          "datetime" => time(),
          "mp4" => "",
          "hls" => ""
          )
        );
        //echo out the response
        echo json_encode($res);
}
