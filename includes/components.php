<?php

function tile($link, $title, $icon){
    $card = <<<CARD
<a href="$link" class="card tile">
    <div class="card-body">
        <h5 class="card-title">$title</h5>
        <div class="tile-icon-container">
             <i class="bi $icon" style="font-size: 1.5rem;"></i>  
        </div>
    </div>
</a>
CARD;
    echo $card;
}


