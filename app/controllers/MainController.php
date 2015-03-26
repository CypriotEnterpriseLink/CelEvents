<?php

class MainController extends \BaseController{
    public function getIndexPage(){
        /*
        $news = new SimpleXMLElement(Helper::getContent('newsfeed.txt','http://projectcel.com/discussion/celnews?format=feed'));
        $thoughts = new SimpleXMLElement(Helper::getContent('thoughtsfeed.txt','http://projectcel.com/discussion/thoughts?format=feed'));
        $news = $news->channel;
        $thoughts = $thoughts->channel;
        */
        $events = new SimpleXMLElement(Helper::getContent('eventsfeed.txt','http://projectcel.com/component/k2/itemlist/category/1-events?format=feed'));
        $event = $events->channel->item;

        return View::make('index')->with(['events'=>$event]);
    }
    public function getIndividualEvent($slug){

        return View::make('single')->with(['slug'=>$slug]);
    }
}