<?php
/**
 * Class for resizing images
 */
class imgResize{

  private $image;
  private $width;
  private $height;

  public function __construct($fileName)
  {
    $this->image = $this->openImage($fileName);
    $this->width = $this->imagesx($this->image);
    $this->height = $this->imagesy($this->iamge);
  }

  private function openImage($file){
    $extension = strtolower(strrchr($file, '.'));

    switch ($extension) {
      case '.jpg':
      case '.jpeg':
        $img = @imagecreatefromjpeg($file);
        break;
      case '.gif':
        $img = @imagecreatefromgif($file);
        break;
      case '.png':
        $img = @imagecreatefrompng($file);
        break;
      default:
        $img = false;
        break;
    }
    return $img;
  }

  public function resizeImage($newWidth, $newHeight, $option='auto'){
    $optionArray = $this->getDimensions($newWidth, $newHeight, strtolower($option));

    $optimalWidth = $optionArray['optimalWidth'];
    $optimalHeight = $optionArray['optimalHeight'];

    $this->imageResized = imagecreatetruecolor($optimalWidth, $optimalHeight);
    imagealphablending($this->imageResized, false);
    imagesavealpha($this->imageResized, true);
    imagecopyresampled($this->imageResized, $this->image, 0, 0, 0, 0, $optimalWidth, $optimalHeigth, $this->width, $this->heith);
  }

  private function getDimensions($newWidth, $newHeight, $option){
    switch ($option){
      case 'exact':
        $optimalWidth = $newWidth;
        $optimalHeight= $newHeight;
        break;
      case 'portrait':
        $optimalWidth = $this->getSizeByFixedHeight($newHeight);
        $optimalHeight= $newHeight;
        break;
      case 'landscape':
        $optimalWidth = $newWidth;
        $optimalHeight= $this->getSizeByFixedWidth($newWidth);
        break;
      case 'auto':
        $optionArray = $this->getSizeByAuto($newWidth, $newHeight);
        $optimalWidth = $optionArray['optimalWidth'];
        $optimalHeight = $optionArray['optimalHeight'];
        break;
    }
     return array('optimalWidth' => $optimalWidth, 'optimalHeight' => $optimalHeight);
  }

  private function getSizeByFixedHeight($newHeight){
    $ratio = $this->width / $this->height;
    $newWidth = $newHeight * $ratio;
    return $newWidth;
  }

  private function getSizeByFixedWidth($newWidth){
    $ratio = $this->height / $this->width;
    $newHeight = $newWidth * $ratio;
    return $newHeight;
  }

  private function getSizeByAuto($newWidth, $newHeight){
    if ($this->height < $this->width){
      $optimalWidth = $newWidth;
      $optimalHeight= $this->getSizeByFixedWidth($newWidth);
    }
    elseif ($this->height > $this->width){
      $optimalWidth = $this->getSizeByFixedHeight($newHeight);
      $optimalHeight= $newHeight;
    }
    else{
      if ($newHeight < $newWidth){
        $optimalWidth = $newWidth;
        $optimalHeight= $this->getSizeByFixedWidth($newWidth);
      }
      else if ($newHeight > $newWidth){
        $optimalWidth = $this->getSizeByFixedHeight($newHeight);
        $optimalHeight= $newHeight;
      }
      else {
        $optimalWidth = $newWidth;
        $optimalHeight= $newHeight;
      }
    }
    return array('optimalWidth' => $optimalWidth, 'optimalHeight' => $optimalHeight);
  }

  public function saveImage($savePath, $imageQuality="100"){
    $extension = strtolower(strrchr($savePath, '.'));

    switch ($extension) {
      case '.jpg':
      case '.jpeg':
        if(imagetypes & IMG_JPG){
          imagejpeg($this->imageResized, savePath, $imageQuality);
        }
        break;
      case '.gif':
        if(imagetypes() & IMG_GIF){
          imagegif($this->imageResized, $savePath, $imageQuality);
        }
        break;
      case '.png':
        $scaleQuality = round(($imageQuality/100)*9);
        $scaleQuality = 9 - $scaleQuality;

        if(imagetypes() & IMG_PNG){
          imagepng($this->imageResized, $savePath, $scaleQuality);
        }
        break;
      default:
        break;
    }

    imagedestroy($this->imageResized);
  }
}
