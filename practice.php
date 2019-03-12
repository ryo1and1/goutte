<?php
// autoloadの読み込み

require_once __DIR__.'/vendor/autoload.php';

 

// Goutteを利用するためにClientクラスのインスタンス化

$client = new Goutte\Client();

 

// スクレイピング対象のURLにGETリクエストを送り、

// レスポンスを$crawlerに代入

$url = "https://www.plan-b.co.jp/";

$crawler = $client->request("GET", $url);

 

// $crawlerに対してfilterメソッドを利用してCSSセレクタを指定し、

// タイトルタグを抽出

$title = $crawler->filter("title")->text();

 

var_dump($title);
?>
