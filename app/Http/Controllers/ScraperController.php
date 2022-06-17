<?php

namespace App\Http\Controllers;

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
        dd($page->filter('.logo-main')->text());

        // $page->filter('#maincounter-wrap')->each(function ($item) {
        //     $this->results[$item->filter('h1')->text()] = $item->filter('#maincounter-wrap')->text();
        // });

        // $data = $this->results;

        // dd($data);die;
        // return view('scrape', compact('data'));
    }
}
