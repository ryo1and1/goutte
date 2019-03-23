<?php

require_once __DIR__.'/vendor/autoload.php';
require_once "hotel.php";
require_once "price.php";

define('DB_DATABASE','scraping');
define('DB_USERNAME','basic');
define('DB_PASSWORD','Basic-pass1');
define('DB_DSN','mysql:host=localhost;charset=utf8;dbname='.DB_DATABASE);

$client = new Goutte\Client();

$base_url = "https://www.jtb.co.jp/kokunai_hotel/list/";
$place = "osaka";
$date = "20190321";
$url = $base_url . $place . "/?godate=" . $date . "&itemperpage=20&hotellistsort=recommend&staynight=1&room=1&roomassign=&mapdisp=0&planinfokeywordon=1&temproomassign=0";
$crawler = $client->request("GET",$url);
$max_page = $crawler->filter("body > main > div > div.dom-layout-01 > div > nav > ul > li:nth-last-child(2)")->text();

for ($i = 1; $i <= $max_page; $i++) {
	$url = $base_url . $place . "/?godate=" . $date . "&itemperpage=20&hotellistsort=recommend&staynight=1&room=1&roomassign=&mapdisp=0&planinfokeywordon=1&temproomassign=0&page=" . $i;
	
echo$i . "ページ目:" . $url . PHP_EOL;

sleep(5);

$crawler = $client->request("GET",$url);
$crawler->filter("#spk_hotel-list > div > article")->each(function($article) use (&$result, &$place, &$date) {

$hotel_obj = new Hotel();

$price_obj = new Price();

        // 変数宣言

$name = $article->filter("div:nth-child(1) > div.domhotel-hotel-list__column-01 > h3 > a")->text();

echo $name.PHP_EOL;

        $link = $article->filter("div.domhotel-hotel-list__column-01 > h3 > a")->attr("href");

        $area = $article->filter("div.domhotel-hotel-list__column-04 > p")->text();

        $min_price = $article->filter("div.domhotel-hotel-list__column-05 > div.dom-hotel-price > p.dom-hotel-price__adult > span:nth-child(1)")->text();

 

        // 中には価格が一つだけしか表示されていない場合があるので、存在確認を行います。

        $node_max_price = $article->filter("div.domhotel-hotel-list__column-05 > div.dom-hotel-price > p.dom-hotel-price__adult > span:nth-child(2)");

if ($node_max_price->count() == 0) {
$max_price = $min_price;
} else {
$max_price = $node_max_price->text();
}
$hotel_id = $hotel_obj->insertData([
"name" => $name,"link" => "https://www.jtb.co.jp" . $link,

            "area" => $area,

            "place" => $place

        ]);

$search_char_list = ["円",",","～"];
$replace_char_list = ["", "", ""];

        $price_obj->insertData([

            "target_date" => $date,

            "hotel_id" => $hotel_id,

            "min_price" => str_replace($search_char_list, $replace_char_list, $min_price),

            "max_price" => str_replace($search_char_list, $replace_char_list, $max_price)

        ]);

    });

}

?>
