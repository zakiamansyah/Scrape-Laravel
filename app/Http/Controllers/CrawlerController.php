<?php

namespace App\Http\Controllers;

use Exception;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\DomCrawler\Crawler;

class CrawlerController extends Controller
{
    private $client;

    public function __construct()
    {
        $this->client = new Client([
            'timeout'   => 10,
            'verify'    => false
        ]);
    }

    private function getStr($start, $end, $string)
    {
        if (!empty($string))
        {
            $getString = explode($start,$string);
            $getString = explode($end,$getString[1]);

        return $getString[0];
        }
    }

    public function getCrawler()
    {
        $response = $this->client->get("https://burst.shopify.com/photos/search?q=face");
        $content = $response->getBody()->getContents();
        $pagination = $this->getStr('<li class="last">', '</li>', $content);
        $pagination = $this->getStr('/photos/search?page=', '&amp;q=', $pagination);

        $i = 1;
        while (true) {
            try{
                $response = $this->client->get("https://burst.shopify.com/photos/search?page={$i}&q=face");
            }
            catch(Exception $e) {
                break;
            }
            $content = $response->getBody()->getContents();
            $crawler = new Crawler($content);

            $self = $this;
            $data = $crawler->filter('div.tile--with-overlay')
                            ->each(function (Crawler $node, $i) use($self) {
                                return $self->getNodeContent($node);
                            });

            $string = implode("\n", $data);

            Storage::disk('local')->append('foto-face.txt', $string);
            $i++;
        }
    }

    public function hasContent($node)
    {
        return $node->count() > 0 ? true : false;
    }

    public function getNodeContent($node)
    {
        return $this->hasContent($node->filter('.ratio-box img')) != false ? $node->filter('.ratio-box img')->attr('src') : '';
    }
}
