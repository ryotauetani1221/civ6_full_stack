<?php

namespace App\Traits\Scraping;

use \DOMWrap\Document;
use \GuzzleHttp\Client;

use App\Models\Area;

trait AreaScrapingTrait
{
    public static function init()
    {
        $client = new Client([
            'base_uri' => 'https://google.com/'
        ]);
        // $res = $client->request('GET', 'search?q=RPA');
        // 抽出
        $response = $client->request('GET', 'https://civ6wiki.info/?%B9%B6%CE%AC%BE%F0%CA%F3/%C9%BE%B2%C1/%B6%E8%B0%E8%A1%A6%B7%FA%C2%A4%CA%AA');
        $html = (string) $response->getBody();

        // https://github.com/scotteh/php-dom-wrapper
        $doc = new Document;
        $doc_html = $doc->html($html);

        // 特定のテーブルの各行に対してループ処理をかける例
        $nodes = $doc_html->find('#body h3,#body h4,#body .ie5');
        // var_dump($nodes->text());
        // for ($i = 0; $i < count($nodes); $i++) {
        $array_i = 0;
        $now_area = '';
        $now_area_base = '';
        // 最初がカラだったので1からforを回す
        for ($i = 1; $i < count($nodes); $i++) {

            if ($i === 1) {
                $post_array[$array_i] = [
                    'area' => '',
                    'area_base' => '',
                    'area_building' => '',
                    'production_cost' => '',
                    'maintenance_cost' => '',
                    'building_conditions' => '',
                    'trade_bonus_domestic' => '',
                    'trade_bonus_overseas' => '',
                    'lifting_technology' => '',
                    'adjacent_bonus' => '',
                    'looting_bonus' => '',
                    'effect' => '',
                ];
            }

            // var_dump($nodes[$i]);
            // var_dump($nodes[$i]->text());

            if ($nodes[$i]->tagName === 'h3') {
                $post_array[$array_i]['area'] = trim($nodes[$i]->text());
                if (strpos($post_array[$array_i]['area'], ' (') === false) {
                    $now_area = $post_array[$array_i]['area'];
                    $post_array[$array_i]['area_base'] = $post_array[$array_i]['area'];
                } else {
                    $post_array[$array_i]['area_base'] = $post_array[$array_i - 1]['area_base'];
                }
            } elseif ($nodes[$i]->tagName === 'h4') {
                $post_array[$array_i]['area_building'] = trim($nodes[$i]->text());
                $post_array[$array_i]['area'] = $now_area;
            } elseif ($nodes[$i]->tagName === 'div') {
                $post_array[$array_i]['effect'] = $nodes[$i]->text();
                // var_dump($nodes[$i]->find('td'));

                $table_data_array = [];
                $th_array = [];
                $td_array = [];
                foreach ($nodes[$i]->find('tr') as $item) {
                    // var_dump(count($item->find('th')) . ":" . count($item->find('td')));

                    if (count($item->find('th')) > 0) {
                        foreach ($item->find('th') as $th_item) {
                            $th_array[] = $th_item->text();
                        }
                    }
                    if (count($item->find('td')) > 0) {
                        foreach ($item->find('td') as $td_item) {
                            // $td_array[] = $td_item->text();

                            $td_item = preg_replace('/<\/*td.*?>/', '', $td_item);
                            $td_item = preg_replace(
                                // '/<img (.*?)>/',
                                '/<img([^>]*)alt="(.*?)"([^>]*)>/',
                                '$2',
                                $td_item
                            );
                            $td_item = preg_replace(
                                '/.png/',
                                '：',
                                $td_item
                            );
                            $td_item = preg_replace(
                                '/<br([^>]*)class="(.*?)"([^>]*)>/',
                                '<br class="">',
                                $td_item
                            );

                            $td_item = strip_tags($td_item);


                            $td_array[] = $td_item;
                        }
                    }
                }
                if (count($th_array) === 10) {

                    $key = array_search('国内', $th_array);
                    unset($th_array[$key]);
                    $th_array = array_values($th_array);
                    $key = array_search('国外', $th_array);
                    unset($th_array[$key]);
                    $th_array = array_values($th_array);

                    array_splice($th_array, 4, 0, '交易ボーナス 国外');
                }
                foreach ($th_array as $key => $value) {
                    $table_data_array[] = [
                        'label' => $value,
                        'text' => $td_array[$key],
                    ];
                }
                // var_dump($th_array);
                // var_dump($td_array);
                // var_dump($table_data_array);

                // 最終配列に代入
                foreach ($table_data_array as $item) {
                    switch ($item['label']) {
                        case 'コスト':
                            $post_array[$array_i]['production_cost'] = $item['text'];
                            break;
                        case '維持費':
                            $post_array[$array_i]['maintenance_cost'] = $item['text'];
                            break;
                        case '建設条件':
                            $post_array[$array_i]['building_conditions'] = $item['text'];
                            break;
                        case '交易ボーナス':
                            $post_array[$array_i]['trade_bonus_domestic'] = $item['text'];
                            break;
                        case '交易ボーナス 国外':
                            $post_array[$array_i]['trade_bonus_overseas'] = $item['text'];
                            break;
                        case '解禁条件':
                            $post_array[$array_i]['lifting_technology'] = $item['text'];
                            break;
                        case '隣接ボーナス':
                            $post_array[$array_i]['adjacent_bonus'] = $item['text'];
                            break;
                        case '略奪ボーナス':
                            $post_array[$array_i]['looting_bonus'] = $item['text'];
                            break;
                        case '効果':
                            // $item['text'] = preg_replace('/[a-zA-Z]/', '', $item['text']);
                            // $item['text'] = preg_replace('/_/', '', $item['text']);
                            // $item['text'] = preg_replace('/：/', '', $item['text']);
                            $post_array[$array_i]['effect'] = $item['text'];
                            break;

                        default:
                            # code...
                            break;
                    }
                }
            }

            if ($nodes[$i]->tagName === 'div') {
                // echo ("\n");
                // echo ("============================");
                // echo ("\n");
                // var_dump($post_array[$array_i]);

                $array_i++;
                $post_array[$array_i] = [
                    'area' => '',
                    'area_base' => '',
                    'area_building' => '',
                    'production_cost' => '',
                    'maintenance_cost' => '',
                    'building_conditions' => '',
                    'trade_bonus_domestic' => '',
                    'trade_bonus_overseas' => '',
                    'lifting_technology' => '',
                    'adjacent_bonus' => '',
                    'looting_bonus' => '',
                    'effect' => '',
                ];
            } else {
            }

            // echo ($nodes[$i]->tagName);
            // echo ($nodes[$i]->text());
            // echo ("\n");
        } // for終わり

        // 最後がカラだったので削除
        unset($post_array[count($post_array) - 1]);
        // var_dump($post_array);
        // これをDB areaに突っ込む

        Area::createAreas($post_array);




        // dd($res);
        // return view('welcome')->with(compact('student'));
    }
}
