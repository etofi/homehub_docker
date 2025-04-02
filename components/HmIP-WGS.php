<?php

// Validated by Gerti
//

function HmIP_WGS($component) {
    
    if(!isset($component['button'])) {
        $component['button'] = 'switch';
    }
    
    if ($component['parent_device_interface'] == 'HmIP-RF' && $component['visible'] == 'true' && isset($component['STATE'])) {
        if (!isset($component['color'])) $component['color'] = '#FFCC00';
        return '<div class="hh" style=\'border-left-color: '.$component['color'].'; border-left-style: solid;\'>'
            . '<div class="pull-left"><img src="icon/' . $component["icon"] . '" class="icon">' . $component['name'] . '</div>'
            . '<div class="pull-right">'
                . '<span class="info set" data-id="' . $component['STATE'] . '" data-component="' . $component['component'] . '" data-datapoint="STATE" data-set-id="' . $component['STATE'] . '" data-button="' . $component['button'] . '" data-set-value=""></span>'
            . '</div>'
            . '<div class="clearfix"></div>'
        . '</div>';
    }
}
