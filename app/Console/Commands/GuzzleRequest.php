<?php

namespace App\Console\Commands;

use DOMDocument;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Pool;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\TransferStats;
use Illuminate\Console\Command;
use Psr\Http\Message\ResponseInterface;

class GuzzleRequest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:request';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $arr = [];
        $block =1024*1024;
        if ($fh = fopen("/Users/admin/Desktop/8c9a136cf0b891e005540aedea5d62bb-02ad4f543c214f36f8cf3ce78658fbfd45d94572/site_list.txt", "r")) {
            $left='';
            while (!feof($fh)) {// read the file
                $temp = fread($fh, $block);
                $fgetslines = explode("\n",$temp);
                $fgetslines[0]=$left.$fgetslines[0];
                if(!feof($fh) )$left = array_pop($lines);
                foreach ($fgetslines as $k => $line) {
                    $arr[] = $line;
                }
            }
        }
//        dd($arr);
//        $arr = [
//            "http://www.vnexpress.net",
//            "http://www.tuoitre.com.vn",
//            "http://vietnamnet.vn/",
//            "http://www.dantri.com.vn",
//            "http://www.vietnamplus.vn/",
//            "http://www.baodatviet.vn/",
//            "http://www.vtc.vn/",
//            "http://www.linkhay.com",
//            "http://vn.news.yahoo.com/"
//        ];
        $client = new Client();

        $START = microtime(true);
        try{
            foreach ($arr as $url){
                $res = $client->request('GET', $url);
                $body =  $res->getBody();
                $dom = new DomDocument();
                libxml_use_internal_errors(true);
                $dom->loadHTML($body);
                $aElements = $dom->getElementsByTagName('h1');
                if($aElements->length < 1){
                    $aElements = $dom->getElementsByTagName('h2');
                    if($aElements->length < 1){
                        $aElements = $dom->getElementsByTagName('h2');
                    }
                };
            }
        }catch (\Exception $e){

        }


        echo "Time to request normal :".(microtime(true) - $START);
        echo "\n";
        $one = microtime(true);
        $requests = function ($urls) {
            foreach ($urls as $url){
                yield new Request('GET', $url);
            }
        };

        $pool = new Pool($client, $requests($arr), [
            'concurrency' => 5,
            'fulfilled' => function ($response, $index) {
                $body =  $response->getBody();
                $dom = new DomDocument();
                libxml_use_internal_errors(true);
                $dom->loadHTML($body);
                $aElements = $dom->getElementsByTagName('h1');
                if($aElements->length < 1){
                    $aElements = $dom->getElementsByTagName('h2');
                    if($aElements->length < 1){
                        $aElements = $dom->getElementsByTagName('h2');
                    }
                };

            },
            'rejected' => function ($reason, $index) {

            },
        ]);
        $promise = $pool->promise();
        $promise->wait();
        $two = microtime(true);
        echo "Time to request async concurency 5 :".($two - $one);
        echo "\n";
        $one2 = microtime(true);
        $requests = function ($urls) {
            foreach ($urls as $url){
                yield new Request('GET', $url);
            }
        };

        $pool = new Pool($client, $requests($arr), [
            'concurrency' => 10,
            'fulfilled' => function ($response, $index) {
                $body =  $response->getBody();
                $dom = new DomDocument();
                libxml_use_internal_errors(true);
                $dom->loadHTML($body);
                $aElements = $dom->getElementsByTagName('h1');
                if($aElements->length < 1){
                    $aElements = $dom->getElementsByTagName('h2');
                    if($aElements->length < 1){
                        $aElements = $dom->getElementsByTagName('h2');
                    }
                };

            },
            'rejected' => function ($reason, $index) {

            },
        ]);
        $promise = $pool->promise();
        $promise->wait();
        $two2 = microtime(true);
        echo "Time to request async concurency 10 :".($two2 - $one2);


    }
}
