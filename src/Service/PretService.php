<?php


namespace App\Service;


use DateTime;
use App\Service\FinanceMathPHP;

class PretService
{
    /**
     * @var DateTime
     */
    protected $deb;
    /**
     * @var int
     */
    protected $nb_mois;
    /**
     * @var float
     */
    protected $mt_emprunt;
    /**
     * @var float
     */
    protected $tx_pret;
    /**
     * @var float
     */
    protected $tx_ass;
    /**
     * @var array
     */
    protected $tab_amort;


    /**
     * Calcule une mensualité hors assurance avec un prêt à taux fixe
     * @return float|int
     */
    public function getMensualiteBase()
    {
        $val1 = $this->mt_emprunt * $this->tx_pret / 12;
        $val2 = 1 - pow(1 + $this->tx_pret / 12, -$this->nb_mois);
        return $val1 / $val2;
    }

    public function getMensualiteAss()
    {
        return $this->mt_emprunt * $this->tx_ass / 12;
    }

    public function test()
    {
        $rate          = 0.012 / 12; // % interest paid at the end of every month
        $periods       = 20 * 12;    // 20-year mortgage
        $present_value = 103040.8;     // Mortgage note of $265,000.00
        $future_value  = 0;
        $beginning     = false;      // Adjust the payment to the beginning or end of the period
        $pmt           = FinanceMathPHP::pmt($rate, $periods, $present_value, $future_value, $beginning);
        $period        = 1;
        $periodpmt     = FinanceMathPHP::ipmt($rate, $period, $periods, $present_value, $future_value, $beginning);
        $ppmt          = FinanceMathPHP::ppmt($rate, $period, $periods, $present_value, $future_value, $beginning);
        return [$pmt, $periodpmt, $ppmt];
    }

    /**
     * @throws \Exception
     */
    public function getTableauAmortissement()
    {
//        $mensualite_base = $this->getMensualiteBase(); // capital + intérêts
//        $mensualite_ass  = $this->getMensualiteAss();
        $date_paiement = clone $this->deb;
        $period        = 1;
        $periods       = $this->nb_mois;
        $future_value  = 0;
        $present_value = $this->mt_emprunt;
        $beginning     = false;

//        $ipmt          = FinanceMathPHP::ipmt($this->tx_pret / 12, $period, $periods, $present_value, $future_value, $beginning);
//        $ppmt          = FinanceMathPHP::ppmt($this->tx_pret / 12, $period, $periods, $present_value, $future_value, $beginning);
//        $pass          = $this->getMensualiteAss();
//        $payment       = $ipmt + $ppmt + $pass;
//        $solde_cloture = $present_value - $payment;

        $nb_mois_restant = $this->nb_mois - 1;
        $annee           = (int)$this->deb->format('Y');
        $mois            = (int)$this->deb->format('m');

        for ($i = 1; $i <= $this->nb_mois; $i++) {
            $ipmt          = abs(FinanceMathPHP::ipmt($this->tx_pret / 12, $period, $periods, $present_value, $future_value, $beginning));
            $ppmt          = abs(FinanceMathPHP::ppmt($this->tx_pret / 12, $period, $periods, $present_value, $future_value, $beginning));
            $pass          = $this->getMensualiteAss();
            $payment       = $ipmt + $ppmt + $pass;
            $solde_cloture = $present_value - $ppmt;

            $this->tab_amort[$annee][$mois]['numero']          = $i;
            $this->tab_amort[$annee][$mois]['date_paiement']   = $date_paiement->format('Y-m-d');
            $this->tab_amort[$annee][$mois]['solde_ouverture'] = $present_value;
            $this->tab_amort[$annee][$mois]['interet']         = $ipmt;
            $this->tab_amort[$annee][$mois]['principal']       = $ppmt;
            $this->tab_amort[$annee][$mois]['assurance']       = $pass;
            $this->tab_amort[$annee][$mois]['mensualite']      = $payment;
            $this->tab_amort[$annee][$mois]['solde_cloture']   = $solde_cloture;
            $this->tab_amort[$annee][$mois]['nb_mois_restant'] = $nb_mois_restant;

            $nb_mois_restant = $nb_mois_restant - 1;
            $date_paiement->add(new \DateInterval('P1M'));
            $present_value   = $solde_cloture;
//            $beginning = true;
            $annee = (int)$date_paiement->format('Y');
            $mois  = (int)$date_paiement->format('m');
        }
        return $this->tab_amort;
    }
// TAEG = ((montant total à rembourser - montant de l'emprunt)/ montant de l'emprunt) * nombre de mensualités
// Montant total à rembourser = montant des mensualités * nombre de mensualités + total des autres frais éventuels

    /**
     * Calcule le montant des mensualités (méthode des taux variables)
     * @param float $loanAmount
     * @param int $totalPayments
     * @param float $periodnterest
     * @return float|int
     */
    function calcPayment(float $loanAmount, int $totalPayments, float $periodnterest)
    {
        //***********************************************************
        //              INTEREST * ((1 + INTEREST) ^ TOTALPAYMENTS)
        // PMT = LOAN * -------------------------------------------
        //                  ((1 + INTEREST) ^ TOTALPAYMENTS) - 1
        //***********************************************************

        $value1 = $periodnterest * pow((1 + $periodnterest), $totalPayments);
        $value2 = pow((1 + $periodnterest), $totalPayments) - 1;
        $pmt    = $loanAmount * ($value1 / $value2);
        return $pmt;
    }

    /**
     * @return DateTime
     */
    public function getDeb(): DateTime
    {
        return $this->deb;
    }

    /**
     * @param DateTime $deb
     * @return PretService
     */
    public function setDeb(DateTime $deb): PretService
    {
        $this->deb = $deb;
        return $this;
    }

    /**
     * @return int
     */
    public function getNbMois(): int
    {
        return $this->nb_mois;
    }

    /**
     * @param int $nb_mois
     * @return PretService
     */
    public function setNbMois(int $nb_mois): PretService
    {
        $this->nb_mois = $nb_mois;
        return $this;
    }

    /**
     * @return float
     */
    public function getMtEmprunt(): float
    {
        return $this->mt_emprunt;
    }

    /**
     * @param float $mt_emprunt
     * @return PretService
     */
    public function setMtEmprunt(float $mt_emprunt): PretService
    {
        $this->mt_emprunt = $mt_emprunt;
        return $this;
    }

    /**
     * @return float
     */
    public function getTxPret(): float
    {
        return $this->tx_pret;
    }

    /**
     * @param float $tx_pret
     * @return PretService
     */
    public function setTxPret(float $tx_pret): PretService
    {
        $this->tx_pret = $tx_pret;
        return $this;
    }

    /**
     * @return float
     */
    public function getTxAss(): float
    {
        return $this->tx_ass;
    }

    /**
     * @param float $tx_ass
     * @return PretService
     */
    public function setTxAss(float $tx_ass): PretService
    {
        $this->tx_ass = $tx_ass;
        return $this;
    }

    /**
     * @return array
     */
    public function getTabAmort(): array
    {
        return $this->tab_amort;
    }

    /**
     * @param array $tab_amort
     * @return PretService
     */
    public function setTabAmort(array $tab_amort): PretService
    {
        $this->tab_amort = $tab_amort;
        return $this;
    }


}