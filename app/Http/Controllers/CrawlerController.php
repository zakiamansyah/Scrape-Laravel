<?php

namespace App\Http\Controllers;

use Exception;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
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
        $response = $this->client->get('https://www.detik.com/tag/virus-corona');

        $content = $response->getBody()->getContents();
        $crawler = new Crawler( $content );

        $ini = $this;
        $data = $crawler->filter('div.list')
                        ->each(function (Crawler $node) use($ini) {
                            return $ini->getNodeContent($node);
                        });
        dd($data);
    }

    public function hasContent($node)
    {
        return $node->count() > 0 ? true : false;
    }

    public function getNodeContent($node)
    {
        $array = [
            'title' => $this->hasContent($node->filter('.post__content h2')) != false ? $node->filter('.post__content h2')->text() : '',
            'content' => $this->hasContent($node->filter('.post__content p')) != false ? $node->filter('.post__content p')->text() : '',
            'author' => $this->hasContent($node->filter('.author__content h4 a')) != false ? $node->filter('.author__content h4 a')->text() : '',
            'featured_image' => $this->hasContent($node->filter('.post__image a img')) != false ? $node->filter('.post__image a img')->eq(0)->attr('src') : ''
        ];

        return $array;
    }
}
