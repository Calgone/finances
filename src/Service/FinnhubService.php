<?php


namespace App\Service;


use App\Entity\Bourse\Quote;
use App\Entity\Bourse\Stock;

class FinnhubService extends ApiService
{
    protected $token = 'brefq7vrh5rckh45bos0';
    protected $url = 'https://finnhub.io/api/v1/';


    public function __construct()
    {
        parent::__construct();
    }

    public function __destruct()
    {
        parent::__destruct();
    }

    protected function setUrl(string $path, array $values)
    {
        $url = $this->url . $path . '?';
        foreach ($values as $k => $v) {
            $url .= '&' . $k . '=' . $v;
        }
        $url .= '&token=' . $this->token;
        curl_setopt($this->ch, CURLOPT_URL, $url);
    }

    /**
     * https://finnhub.io/docs/api#company-profile2
     * @param string $isin
     * @return \stdClass
     */
    public function getProfile(string $isin): \stdClass
    {
//        dump($symbol);
        $this->setUrl('stock/profile2', ['isin' => $isin]);
        $result = $this->exec();
//        dd($result);

        return json_decode($result);
    }

    /**
     * @param string $symbol
     * @return mixed
     */
    public function getQuote(string $symbol)
    {
        $this->setUrl('quote', ['symbol' => $symbol]);
        $result = $this->exec();
        return json_decode($result);

    }

    /**
     * Get company basic financials such as margin, P/E ratio, 52-week high/low etc.
     * @param string $symbol
     * @return mixed
     */
    public function getBasicFinancial(string $symbol)
    {
        $this->setUrl('stock/metric', ['symbol' => $symbol]);
        $result = $this->exec();
        return json_decode($result);
    }

    /**
     * List supported stocks (PA = NYSE EURONEXT - EURONEXT PARIS)
     * https://docs.google.com/spreadsheets/d/1I3pBxjfXB056-g_JYf_6o3Rns3BV2kMGG1nCatb91ls/edit?usp=sharing
     * @param string $exchange
     */
    public function getExchangeSymbols(string $exchange)
    {
        $this->setUrl('stock/symbol', ['exchange', $exchange]);
        $result = $this->exec();
        dd($result);
    }
}
