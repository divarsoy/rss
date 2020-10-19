<?php

namespace App\Services;

use App\DTO\FeedItem;

class RSS_Service
{

    public function parse($url)
    {
        $stream = simplexml_load_file($url);
        if ((string) $stream->attributes() == "2.0"){
            return $this->parse2_0($stream);
        }
        return [];
    }

    protected function parse2_0($stream){
        $collection = [];
        foreach($stream->channel->item as $item){
            $feedItem = new FeedItem();
            $feedItem->setMainTitle($stream->channel->title);
            $feedItem->setTitle($item->title);
            $feedItem->setDescription($item->description);
            $feedItem->setLink($item->link);
            $feedItem->setImage($item);
            $collection[] = $feedItem;
        }
        return $collection;
    }
}
