<?php

namespace App\Http\Controllers;

use Exception;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\DomCrawler\Crawler;



class CrawlerController extends Controller
{
    // public function crawler()
    // {
    //     $get = file_get_contents('https://www.detik.com/tag/virus-corona');
    //     $crawler = new Crawler($get);

    //     $coba = $crawler->filter('.tabs-menu')->text();

    //     dd($coba);
    // }

    private $client;

    public function __construct()
    {
        $this->client = new Client([
            'timeout'   => 10,
            'verify'    => false
        ]);
    }

    public function getCrawler()
    {
        // try{
            $pagination = 2;
            $response = $this->client->get("https://burst.shopify.com/photos/search?page={$pagination}&q=face");
            // if($pagination != 1 || $pagination != 0){
                // $response . "page=" . $pagination . "&q=face";
            // }

            // dd($response);die;

                $content = $response->getBody()->getContents();
                $crawler = new Crawler($content);

                $self = $this;
                $data = $crawler->filter('div.gutter-bottom')
                                ->each(function (Crawler $node, $i) use($self) {
                                    return $self->getNodeContent($node);
                                });

                dd($data);die;

                $string = implode("\n", $data);

                Storage::disk('local')->put('foto.txt', $string);
        // } catch(Exception $e) {
        //     echo $e->getMessage();
        // }
    }

    public function hasContent($node)
    {
        return $node->count() > 0 ? true : false;
    }

    public function getNodeContent($node)
    {
        // $array = [
        //     'foto' => $this->hasContent($node->filter('.photo-card img')) != false ? $node->filter('.photo-card img')->attr('src') : ''
        // ];

        return $this->hasContent($node->filter('.ratio-box img')) != false ? $node->filter('.ratio-box img')->attr('src') : '';
        // return $array;
    }
}
