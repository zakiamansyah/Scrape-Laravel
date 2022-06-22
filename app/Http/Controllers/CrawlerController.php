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
        try {
            $response = $this->client->get('https://www.detik.com/tag/virus-corona');
            $content = $response->getBody()->getContents();
            $crawler = new Crawler($content);

            $_this = $this;
            $data = $crawler->filter('span.ratiobox')
                            ->each(function (Crawler $node, $i) use($_this) {
                                return $_this->getNodeContent($node);
                            });

            $url = "https://www.detik.com/tag";
            $contents = file_get_contents($url);
            $name = substr($url, strrpos($url, '/') + 1);
            dd($name);

        } catch(Exception $e) {
            echo $e->getMessage();
        }
    }

    // public function saveImage()
    // {
    //     $url = "http://www.google.co.in/intl/en_com/images/srpr/logo1w.png";
    //     $contents = file_get_contents($url);
    //     $name = substr($url, strrpos($url, '/') + 1);

    // }

    public function hasContent($node)
    {
        return $node->count() > 0 ? true : false;
    }

    public function getNodeContent($node)
    {
        $array = [
            'foto' => $this->hasContent($node->filter('.ratiobox_content img')) != false ? $node->filter('.ratiobox_content img')->attr('src') : ''
        ];

        return $array;
    }
}
