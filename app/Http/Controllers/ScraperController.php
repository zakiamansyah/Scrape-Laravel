<?php

namespace App\Http\Controllers;

use GuzzleHttp\Exception\GuzzleException;
use Goutte\Client;
use Illuminate\Http\Request;

class ScraperController extends Controller
{
    private $result = array();

    public function scrapping()
    {
        $client = new Client();
        $url = 'https://www.detik.com/tag/virus-corona';
        $page = $client->request('GET', $url);

        // var_dump($page);die;

        /*echo "<pre>";
        print_r($page);*/

        // dd($page->filter('.ratiobox_content')->text());
        // dd($page->filter('.ratiobox_content')->image());

        // $images = $page->filter('.tabs-menu')->each(function ($item) {
        //     $
        // });

        $title = $page->filter('.plain')->text();
        $datepublished = $page->filter('.dateonline')->text();
        $description = $page->filter('.teaser-link')->text();
        $link = $page->filter('a')->link();

        if(!empty ($link_r = $link->getUri()))
        {
            $image = $page->filter('img')->image();
            $image_s = $image->getUri();
            $filename = basename($image_s);
            $image_path = ('news-gallery/' . $filename);
        }

        var_dump($image_path);
        // $coba = $page->filter('.tabs-menu')->each(function ($item){
        //         $this->result[$item->filter('h2')->text()] = $item->filter('.tabs-menu')->text();
        // });

        // dd($coba);

        // $page->filter('#maincounter-wrap')->each(function ($item) {
        //     $this->results[$item->filter('h1')->text()] = $item->filter('#maincounter-wrap')->text();
        // });

        // $data = $this->results;

        // dd($data);die;
        // return view('scrape', compact('data'));
    }
}
