<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\DomCrawler\Crawler;

class scrape extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scrape:foto';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */

    private $client;


    private function getStr($start, $end, $string) {
        if (!empty($string)) {
        $setring = explode($start,$string);
        $setring = explode($end,$setring[1]);
        return $setring[0];
        }
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

    public function handle()
    {
        $this->client = new Client([
            'timeout'   => 10,
            'verify'    => false
        ]);
        try{
                $response = $this->client->get("https://burst.shopify.com/photos/search?q=face");
                $content = $response->getBody()->getContents();
                $last = $this->getStr('<li class="last">','</li>',$content);
                $last = $this->getStr('/photos/search?page=','&amp;q=',$last);
                for ($i=1; $i <= $last; $i++) {

                $response = $this->client->get("https://burst.shopify.com/photos/search?page={$i}&q=face");
                $content = $response->getBody()->getContents();
                $crawler = new Crawler($content);

                $self = $this;
                $data = $crawler->filter('div.tile--with-overlay')
                                ->each(function (Crawler $node, $i) use($self) {
                                    return $self->getNodeContent($node);
                                });

                // dd($data);die;

                $string = implode("\n", $data);

                Storage::disk('local')->append('foto.txt', $string);
                echo "page $i done\n";
                sleep(1);
                }
        } catch(Exception $e) {
            echo $e->getMessage();
        }
    }
}
