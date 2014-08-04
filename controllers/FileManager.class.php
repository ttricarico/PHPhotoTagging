<?php

class FileManager {

  private $chars, $filetypes;
  private $filename, $filepath, $urlpath, $filemime;
  protected $mysql, $session;
  public $tempdir;


  public function __construct() {
    global $mysql, $session;

    $chars = '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $cl = strlen($chars);
    for($i = 0; $i < $cl; $i++){
        $this->chars[] = $chars[$i];
    }

    $this->tempdir = basepath().'/files/uploads/temp';
    $this->mysql = $mysql;
    $this->session = $session;

    if(func_num_args() == 1) {
      $this->filename = func_get_arg(0);
    } else {
      $this->filename = '';
    }
  }

  /**
   * public function createFileName
   *  @param $filetype: file extension and there
   **/
  public function createFileName($length = 5) {
    $name = '';
    for($x=0; $x<$length; $x++) {
      $name .= $this->chars[( mt_rand() % ( count($this->chars) - 1) )];
    }

    $this->filename = $name;
    return $name;
  } //createFileName()

  public function loadFileByHash($filehash) {
    $result = $this->mysql->one('SELECT * FROM uploads WHERE filehash = :fh',
                       array(':fh' => $filehash)
                     );
    $this->setFileName($result['filename']);
    $this->setFilePath($result['filepath']);
    $this->setURLPath($result['urlpath']);
  }//loadFileByHash()

  public function getFileName() {
    return $this->filename;
  } //getFilename()

  protected function setFileName($filename) {
    $this->filename = $filename;
    return $filename;
  }
  public function getFilePath() {
    return $this->filepath;
  }//getFilePath
  private function setFilePath($filepath) {
    $this->filepath = $filepath;
    return $filepath;
  }
  public function getURLPath() {
    return $this->urlpath;
  }
  private function setURLPath($urlpath) {
    $this->urlpath = $urlpath;
    return $urlpath;
  }

  public function findMimeType($file) {
    //die($file);
    $finfo = new finfo(FILEINFO_MIME);
    $type = explode(';',$finfo->file($file));

    return $type[0];
  }
  public function getMimeType() {
    if(!$this->filemime) {
      $finfo = new finfo(FILEINFO_MIME);
      $type = explode(';',$finfo->file($file));
      $this->filemime = $type[0];
    }
    return $this->filemime;
  }


  public function checkIfDuplicateExists($file) {

    $result = $this->mysql->one('SELECT COUNT(id) FROM uploads WHERE filehash = :fh',
                                  array(':fh' => md5_file($file))
                               );
    if($result['COUNT(id)'] != 0) {
      return true;
    }
    else {
      return false;
    }
  }

  /**
   * public function upload
   *  @param $files : array
   **/
  public function saveFile($file) {


  } //upload()
  public function addFileToDatabase($file) {
    try {
      $this->mysql->run('INSERT INTO uploads(filename, urlpath, filepath, uploadtime, whoupload, filehash, type)
                                    VALUES(:fn, :up, :fp, :ut, :wu, :fh, :ty)',
                         array(':fn' => $file['name'],
                               ':up' => $file['urlpath'],
                               ':fp' => $file['filepath'],
                               ':ut' => time(),
                               ':wu' => $file['user'],
                               ':fh' => $file['filehash'],
                               ':ty' => $file['type'])
                        );
      return true;
    } catch (Exception $e) {
      $e->getMessage();
      return false;
    }
  }
}
