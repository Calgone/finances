<?php


namespace App\Service;


class InseeSireneService
{
    protected $apiUrl = "https://api.insee.fr/entreprises/sirene/V3/";
    protected $ch; // identifiant de session cUrl
    protected $defaults = [ // https://www.php.net/manual/fr/function.curl-setopt.php
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HEADER => false, // Ne pas mettre de header en retour sinon le json_decode ne fonctionne pas
        CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
//        CURLINFO_HEADER_OUT => true,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_VERBOSE => true,
    ];

    public function __construct()
    {
        $this->ch = curl_init();
//        curl_setopt($this->ch, CURLOPT_URL, $this->apiUrl);
        curl_setopt_array($this->ch, $this->defaults);
    }

    public function __destruct()
    {
        curl_close($this->ch);
    }

    public function rechercheParSiret(string $siret): ?string
    {
        $authorization = "Authorization: Bearer 0adc5c02-ac8d-3efa-826f-3d648274abec";
        curl_setopt($this->ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json', $authorization]);
        curl_setopt($this->ch, CURLOPT_URL, $this->apiUrl . 'siret/' . $siret);
        $verbose = fopen('php://temp', 'w+');
        curl_setopt($this->ch, CURLOPT_STDERR, $verbose);

        $result = curl_exec($this->ch);
        if ($result === false) {
            printf("cUrl error (#%d): %s<br>\n", curl_errno($this->ch),
                htmlspecialchars(curl_error($this->ch)));
        }
        dump($result);
        return json_decode($result);
    }
}