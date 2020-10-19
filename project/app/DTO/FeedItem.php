<?php


namespace App\DTO;


class FeedItem
{
    private $mainTitle;
    private $title;
    private $description;
    private $link;
    private $image;

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return mixed
     */
    public function getMainTitle()
    {
        return $this->mainTitle;
    }

    /**
     * @param mixed $mainTitle
     */
    public function setMainTitle($mainTitle): void
    {
        $this->mainTitle = $mainTitle;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title): void
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description): void
    {
        $this->description = strip_tags(html_entity_decode((string) $description));
    }

    /**
     * @return mixed
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @param mixed $link
     */
    public function setLink($link): void
    {
        $this->link = $link;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($item): void
    {
        if(! empty($item->enclosure['url'])) {
            $this->image = (string) $item->enclosure['url'];
        }
        elseif( count($item->children('media', True)) != 0){
            $this->image = (string) $item->children( 'media', True )->thumbnail->attributes()['url'];
        }
    }

    public function hasImage(){
        return isset($this->image);
    }


}
