<?php

namespace App\Console\Commands;

use Exception;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;
use Illuminate\Console\Command;
use Symfony\Component\DomCrawler\Crawler;

class ScrapeImage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scrape:image';

    /**
     * The console command description.
     *
     * @var string
     */
    // protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */

    private function getStr($start, $end, $string)
    {
        if (!empty($string))
        {
            $getString = explode($start,$string);
            $getString = explode($end,$getString[1]);

        return $getString[0];
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

    public function handle()
    {
        $this->client = new Client([
            'timeout'   => 10,
            'verify'    => false
        ]);

        $response = $this->client->get("https://burst.shopify.com/photos/search?q=face");
        $content = $response->getBody()->getContents();
        $pagination = $this->getStr('<li class="last">', '</li>', $content);
        $pagination = $this->getStr('/photos/search?page=', '&amp;q=', $pagination);

        $i = 1;
        while (true) {
            try{
                $response = $this->client->get("https://burst.shopify.com/photos/search?page={$i}&q=face");
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
                echo "Page $i done\n";
                if ($i == 35){
                    break;
                }
            }catch(Exception $e) {
                continue;
            }
        }
    }
}
