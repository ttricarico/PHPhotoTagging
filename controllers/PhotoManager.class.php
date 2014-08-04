<?php

class PhotoManager extends FileManager {


  public function __construct() {

    if(func_num_args() == 1) {
        parent::__construct(func_get_arg(0)); //send filename up to parent
    } else {
        parent::__construct();
    }

  }

  public function uploadImage() {

    if(empty($_FILES)) {
      //error out or whatever
      throw new Exception('No file to upload');
    }

    $file = $_FILES['uploadfile'];

    //check if image or not
    if(strpos($this->findMimeType($_FILES['uploadfile']['tmp_name']), 'image') === false) {
      //again, die because lying
      throw new Exception('Not an image, or incorrect MimeType');
    }

    //resize and save photo
    $this->saveAsJPG($_FILES['uploadfile']['tmp_name']);

    return $this->getFileName();

  }
  // $file = from $_FILES array; @return redrawn file in jpg
  public function saveAsJPG($file) {

    $mime = $this->findMimeType($file);

    switch($mime) {
      case 'image/gif':
        $srcimg = imagecreatefromgif($file);
        break;

      case 'image/jpeg':
      case 'image/pjpeg':
      case 'pjpeg':
        $srcimg = imagecreatefromjpeg($file);
        break;

      case 'image/png':
        $srcimg = imagecreatefrompng($file);
        break;

      case 'image/wbmp':
        $srcimg = imagecreatefromwbmp($file);
        break;

      default:
        throw new Exception("The File is not in the correct format. Must be in gif, jpeg, png, wbmp");
        break;
    }

    //move file into temp directory
    //if(!move_uploaded_file()

    //get image dimensions
    list($width, $height) = getimagesize($file);

    //create filename
    $this->setFileName($this->createFileName());
    //resample image
    $newimg = imagecreatetruecolor($width, $height);
    imagecopyresampled($newimg, $srcimg, 0, 0, 0, 0, $width, $height, $width, $height);
    if(!imagejpeg($newimg, $this->tempdir.'/'.$this->getFileName().'.jpg')) {
      die('cant create image');
    }
    imagedestroy($newimg);
    imagedestroy($srcimg);


    //now, check to make sure this file isn't the same as one in the uploaded repo
    if(!$this->checkIfDuplicateExists($this->tempdir.'/'.$this->getFileName().'.jpg')) {
      $this->addFileToDatabase(array('name' => $this->getFileName().'.jpg',
                                    'urlpath' => '/photo/'.$this->getFileName().'.jpg',
                                    'filepath' => '/files/uploads/images/'.$this->getFileName().'.jpg',
                                    'user' => 0,//$->get('userid'),
                                    'filehash' => md5_file($this->tempdir.'/'.$this->getFileName().'.jpg'),
                                    'type' => $this->findMimeType($file)
                                    )
                              );
      //and move into the uploads directory
      rename($this->tempdir.'/'.$this->getFileName().'.jpg', basepath().'/files/uploads/images/'.$this->getFileName().'.jpg');
    }

    return $this->getFileName().'.jpg';

  } //redrawImage()

  public function convertImage($convertto) {

  } //convertImage()

  public function displayImage() {

  }
}
