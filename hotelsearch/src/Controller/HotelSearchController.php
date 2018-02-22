<?php
namespace App\Controller;

use Cake\Http\Client;
use SimpleXMLElement;

class HotelSearchController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
    }

    public function index()
    {
        // 都道府県の表示
        $xml_prefs = new SimpleXMLElement('https://www.jalan.net/jalan/doc/jws/data/area.xml', null, true);
        // selectにバインドする配列(key=cd,value=name)を作成
        $prefs = [];
        foreach ($xml_prefs->Prefecture as $_pref) {
            $prefs[(string) $_pref['cd']] = (string) $_pref['name'];
        }
        $this->set('prefs', $prefs);

        if ($this->request->is('post')) {
            $hotelname = $this->request->data('hotelname');
            $prefcode = $this->request->data('prefectures');
            $adult_num = $this->request->data('adult_num');
            $stay_count = $this->request->data('stay_count');

            // 宿名・都道府県両方未入力なら処理を中止
            if (! $hotelname && ! $prefcode) {
                $this->set('hotels', []);
                $this->set('message', '宿名か都道府県のどちらかを入力してください。');
                return;
            } else {
                $this->set('message', '');
            }

            // 検索条件文字列の生成
            if ($hotelname) {
                $hotelname = '&h_name=' . $hotelname;
            }
            if ($prefcode) {
                $prefcode = '&pref=' . $prefcode;
                var_dump($prefcode);
            }
            if ($adult_num) {
                $adult_num = '&adult_num=' . $adult_num;
            }
            if ($stay_count) {
                $stay_count = '&stay_count=' . $stay_count;
            }

            // 検索結果の取得
            $http = new Client();
            $response = $http->get("http://jws.jalan.net/APIAdvance/HotelSearch/V1/?key=tau161a8b480fc$hotelname$prefcode$adult_num$stay_count&count=20");
            $xml_response = @$response->xml; // namespaceエラーを非表示

            $this->set('hotels', $xml_response->Hotel);

            // エラーの場合メッセージを表示
            if ($xml_response->Message) {
                $this->set('message', $xml_response->Message);
                return;
            } else {
                $this->set('message', '');
            }
            // 0件の場合メッセージを表示
            if ($xml_response->NumberOfResults > 0) {
                $this->set('message', '');
            } else {
                $this->set('message', '条件に一致する宿がありませんでした。');
            }
        } else {
            // 初期は何も表示しない
            $this->set('hotels', []);
            $this->set('message', '');
        }
    }

    // ajax非同期処理用
    // クロスドメインエラー回避のためControllerをかませる
    // hotel_idに紐づくPlanを取得しxmlデータを返す
    public function getPlan()
    {
        $this->autoRender = false;

        // 検索結果の取得
        $http = new Client();
        $response = $http->get("http://jws.jalan.net/APIAdvance/HotelSearch/V1/?key=tau161a8b480fc&h_id=300624");
        $xml_response = @$response->xml; // namespaceエラーを非表示

        $this->set('data', $xml_response->Plan);
        $this->set('_serialize', [
            'data'
        ]);
    }
}