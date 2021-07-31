<?php
require "../inc/config.inc.php";
require '../inc/pixo.class.php';


$pixo = new Pixo($CONFIG);
$last_height = $pixo->getLastHeight();
echo($last_height);
$data = json_decode(file_get_contents("https://events.nyzo.today/txs_from/3/$last_height"));
foreach($data as $tx){
    print_r($tx);
    if($tx->tx_type == "ND"){
        if($tx->comment == "color"){
            $pixo->storePaint($tx->nft_id, substr($tx->recipient, 0, 6), $tx->sender, $tx->height);
        }
    }else if ($tx->tx_type == "NM" or $tx->tx_type == "NT"){
        $pixo->updateOwner($tx->nft_id, $tx->recipient);
    }else if ($tx->tx_type == "NB"){
        $pixo->updateOwner($tx->nft_id, "");
    }
    
    
}
//echo($data);
echo("\n");
