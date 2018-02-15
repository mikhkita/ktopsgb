<?php
Class BankClient{
    public $data = NULL;
    public $error = NULL;
    public $accounts = [];
    public $inn = NULL;
    public $warnings = [];

    public function __construct($inn){
        $this->inn = trim($inn);
    }

    public function readOrders($filename){
        $rules = [
            "Номер" => "number",
            "Дата" => "date",
            "Плательщик1" => "payer1",
            "ПлательщикИНН" => "payerInn",
            "Получатель1" => "receiver1",
            "ПолучательИНН" => "receiverInn",
            "НазначениеПлатежа" => "purpose",
            "ПлательщикРасчСчет" => "payerAcc",
            "ПолучательРасчСчет" => "receiverAcc",
            "Сумма" => "sum",
        ];
        $textFile = file( trim($filename) );
        $arTmp = NULL;
        $result = [];

        foreach ($textFile as &$value) {
            $value = trim( iconv("windows-1251", "utf-8", $value) );
            $stringExploded = explode("=", $value);

            switch ($stringExploded[0]) {
                case "СекцияДокумент":
                    $arTmp = [
                        "income" => false,
                    ];
                    break;
                case "КонецДокумента":
                    if ($resultTmp = $this->getCorr($arTmp)){
                        $result[] = (object)$resultTmp;
                    } 
                    $arTmp = NULL;
                    break;
                default:
                    if (is_array($arTmp) && isset($rules[ $stringExploded[0] ])){
                        $arTmp[$rules[ $stringExploded[0] ]] = trim($stringExploded[1]);
                    }
                    break;
            }
        }

        if (empty($result)) {
            $this->error = "Ошибка чтения файла";
            return false;
        }

        $this->data = $result;
        return $this->data;
    }

    private function getCorr($inArr) {
        if ($inArr["payerInn"] == $this->inn){
            $this->accounts[ $inArr["payerAcc"] ] = true;
            $inArr["corrName"] = $inArr["receiver1"];
            $inArr["corrInn"] = $inArr["receiverInn"];
        } else if ($inArr["receiverInn"] == $this->inn){
            $this->accounts[ $inArr["receiverAcc"] ] = true;
            $inArr["corrName"] = $inArr["payer1"];
            $inArr["corrInn"] = $inArr["payerInn"];
            $inArr["income"] = true;
        } else if ($inArr["payerInn"] == "" && $inArr["receiverInn"] == ""){
            if (isset($this->accounts[ $inArr["payerAcc"] ])){
                $inArr["corrName"] = $inArr["receiver1"];
            }
            else if (isset($this->accounts[ $inArr["receiverAcc"] ])){
                $inArr["corrName"] = $inArr["payer1"];
                $inArr["income"] = true;   
            }
        } else {
            $this->warnings[] = "Ошибка в документе № ".$inArr["number"];
            return false;
        }

        $inArr["corrInn"] = intval($inArr["corrInn"]);

        unset($inArr["receiver1"]);
        unset($inArr["receiverInn"]);
        unset($inArr["receiverAcc"]);
        unset($inArr["payer1"]);
        unset($inArr["payerInn"]);
        unset($inArr["payerAcc"]);

        return $inArr;
    }

    public function getCorrArr(){
        $out = [];
        if( is_array($this->data) && count($this->data) ){
            foreach ($this->data as $key => $item) {
                if( $item->corrInn != 0 ){
                    $out[$item->corrInn] = [
                        "name" => mb_substr($item->corrName, 0, 256, "UTF-8"),
                        "inn" => $item->corrInn,
                    ];
                }
            }

            return $out;
        }else{
            return false;
        }
    }
}
?>