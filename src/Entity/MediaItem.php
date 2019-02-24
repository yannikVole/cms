<?php
namespace App\Entity;

class MediaItem {

    private $item;

    private $uploadDate;

    public function getItem(){
        return $this->item;
    }

    public function setItem($item){
        $this->item = $item;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getUploadDate()
    {
        return $this->uploadDate;
    }

    /**
     * @param \DateTime $uploadDate
     */
    public function setUploadDate(\DateTime $uploadDate = null)
    {
       return $this->uploadDate = $uploadDate;
    }

}