<?php

/**
 * Created by PhpStorm.
 * User: dion.tsai
 * Date: 6/09/2015
 * Time: 11:54 AM
 */

namespace lib\helper;

abstract class CarouselHelper
{
    public static function Merge($carousels, $news)
    {
        $items = Array();
        foreach ($carousels as $carousel) {
            if(isset($items[$carousel->meta('carouselPosition')])){
                continue;
            }

            $item = Array();
            $item['postID'] = $carousel->post->ID;
            
            if (strcmp($carousel->meta('carouselType'), 'image') == 0) {
                $item['title'] = $carousel->meta('carouselTitle');
                $item['subTitle'] = $carousel->meta('carouselSubTitle');
                $item['imageLarge'] = $carousel->meta('carouselImageLarge');
                $item['imageSmall'] = $carousel->meta('carouselImageSmall');
                $item['link'] = $carousel->meta('carouselLink');
                $item['age'] = $carousel->age();
            } else if (strcmp($carousel->meta('carouselType'), 'video') == 0) {
                $video = $carousel->video();
                $item['title'] = $video->meta('v8videoTitle');
                $item['subTitle'] = $video->meta('v8videoSubTitle');
                $item['imageLarge'] = $video->meta('v8videoSnap');
                $item['imageSmall'] = $video->meta('v8videoSnap');
                $item['link'] = $video->link;
                $item['age'] = $video->age();
            } else if (strcmp($carousel->meta('carouselType'), 'news') == 0) {
                $carousel_news = $carousel->news();
                $item['postID'] = $carousel_news->post->ID;
                $item['title'] = $carousel_news->meta('newsTitle');
                $item['subTitle'] = $carousel_news->meta('newsSubtitle');
                $item['imageLarge'] = $carousel_news->meta('newsMedia');
                $item['imageSmall'] = $carousel_news->meta('newsMedia');
                $item['link'] = $carousel_news->link;
                $item['age'] = $carousel_news->age();
            }
            $items[$carousel->meta('carouselPosition')] = $item;
        }

        // Fill the rest with news.
        $position = 1;
        foreach ($news as $news_each) {
            while(isset($items[$position])){
                $position++;
            }

            $item = Array();
            $item['postID'] = $news_each->post->ID;
            $item['title'] = $news_each->meta('newsTitle');
            $item['subTitle'] = $news_each->meta('newsSubtitle');
            $item['imageLarge'] = $news_each->meta('newsMedia');
            $item['imageSmall'] = $news_each->meta('newsMedia');
            $item['link'] = $news_each->link;
            $item['age'] = $news_each->age();
            $items[$position] = $item;
            if($position == 4)
                break;
        }

        return $items;
    }
}
