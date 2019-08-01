<?php

namespace App\Services\Channels;


use DiDom\Document;

class LinkService
{
    private const URL_REGEX = '#\bhttps?://[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|/))#';

    private const USER_AGENT = 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36';

    private const CURL_TIMEOUT = 4000;

    private const CONNECT_TIMEOUT = 30;

    private $ch;

    public function __construct()
    {
        $this->ch = curl_init();

        curl_setopt($this->ch, CURLOPT_ENCODING, '');
        curl_setopt($this->ch, CURLOPT_HEADER, 0);
        curl_setopt($this->ch, CURLOPT_USERAGENT, self::USER_AGENT);
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($this->ch, CURLOPT_TIMEOUT, self::CURL_TIMEOUT);
        curl_setopt($this->ch, CURLOPT_CONNECTTIMEOUT, self::CONNECT_TIMEOUT);
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
    }

    public function __destruct()
    {
        curl_close($this->ch);
    }

    /**
     * Валидация на наличие ссылок в строке
     *
     * @param $text
     * @throws \Exception
     */
    public static function validate(string $text){
        if(!preg_match_all(self::URL_REGEX, $text, $matches)){
            throw new \Exception('invalid url');
        }
        return $matches;
    }

    /**
     * Валидация на правильную ссылку
     * @param string $url
     * @throws \Exception
     */
    public static function validateSingle(string $url){
        if(!filter_var($url, FILTER_VALIDATE_URL)){
            throw new \Exception('invalid url');
        }
    }

    /**
     * Парсинг ссылок в тексте
     *
     * @param string $text
     * @return array
     * @throws \Exception
     */
    public function parse(string $text){

        $matches = self::validate($text);

        $parsed_arr = [];

        foreach ($matches[0] as $url) {
            $parsed_arr[] = self::grabMeta($url);
        }

        return $parsed_arr;
    }

    /**
     * Извлечь мета данные из html документа
     *
     * @param string $url
     * @return array
     * @throws \Exception
     */
    public function grabMeta(string $url){

        self::validateSingle($url);

        $dom = new Document($this->html($url));

        $base = parse_url($url, PHP_URL_HOST);

        $description_el = $dom->first('meta[name=description]');
        $description = $description_el? $description_el->attr('content') : null;

        $title_el = $dom->find('title')[0];
        $title = $title_el? $title_el->text() : null;

        $icon_selectors = ['meta[property="og:image"]', 'img', 'link[rel="apple-touch-icon"]', 'link[rel="icon"][type="image/png"]', 'link[rel$="icon"][type="image/png"]'];
        $icon_attr      = ['content', 'src', 'href', 'href', 'href'];
        $icon = null;
        foreach ($icon_selectors as $i => $selector){
            if($dom->has($selector)){
                $icon = $dom->first($selector)->attr($icon_attr[$i]);
                break;
            }
        }

        return compact('url', 'title', 'description', 'icon', 'base');
    }

    /**
     * Получить HTML страницу
     *
     * @param string $url
     * @return string
     */
    private function html(string $url) : string {
        curl_setopt($this->ch, CURLOPT_URL, $url);
        return curl_exec($this->ch);
    }
}