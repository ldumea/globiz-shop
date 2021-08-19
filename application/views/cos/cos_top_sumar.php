<?php 
    $no_articole = count($this->cart->contents());
    $item = $this->cart->find_by_id('transport');
    if(count($item)){
        $no_articole -=1;
    }
    $item = $this->cart->find_by_id('discount');
    if(count($item)){
        $no_articole -=1;
    } 
    echo $no_articole;
?> <span class=" d-none d-lg-inline-block"><?= lang('pro_duse') ?> - </span> <?= number_format($this->cart->total(),2,",",".") ?> <?= $moneda ?></span>
