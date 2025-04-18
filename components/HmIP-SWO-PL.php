<?php

// Parameter (config/custom.json)
//
// Einstellungen
// use_device_counter (optional): wenn leer nutze CCU-Zähler, ansonsten Geräteinternen Zähler ("use_device_counter":"true")

function HmIP_SWO_PL($component) {

    global $export;
    $obj = $export;

    if (empty($component['use_device_counter'])) {
        if (isset($component['RAIN_COUNTER'])) {
            if (isset($obj['systemvariablesinternal'])) {
                foreach ($obj['systemvariablesinternal'] as $sv_int) {
                    if (strpos($sv_int['name'], 'RainCounter_'.$component['ise_id']) !== false) {
                        // echo PHP_EOL.$component['ise_id'].': ersetze RAIN_COUNTER '.$component['RAIN_COUNTER'].' durch Systemvariable '.$sv_int['ise_id'].' '.$sv_int['name'].PHP_EOL;
                        $component['RAIN_COUNTER'] = $sv_int['ise_id'];
                    }
                }
            }
        }
    }

    $key = array_search(substr($component['address'], 0, -1)."0", array_column($obj['channels'], 'address'));
    foreach($obj['channels'][$key]['datapoints'] as $datapoint)
    { $status_component[$datapoint['type']] = $datapoint['ise_id']; }

    if ($component['parent_device_interface'] == 'HmIP-RF' && $component['visible'] == 'true' && isset($component['ACTUAL_TEMPERATURE'])) {
        if (!isset($component['color'])) $component['color'] = '#00CC33';
        return '<div class="hh" style=\'border-left-color: '.$component['color'].'; border-left-style: solid; height:65px;\'>'
                 . '<div class="pull-left"><img src="icon/' . $component["icon"] . '" class="icon">' . $component['name'] . '</div>'
                 . '<div class="pull-right">'
                   . '<span class="info" data-id="' . $status_component['LOW_BAT'] . '" data-component="' . $component['component'] . '" data-datapoint="LOW_BAT"></span>'
                   . '<span class="info" data-id="' . $component['ACTUAL_TEMPERATURE'] . '" data-component="' . $component['component'] . '" data-datapoint="ACTUAL_TEMPERATURE"></span>'
                   . '<span class="info" data-id="' . $component['HUMIDITY'] . '" data-component="' . $component['component'] . '" data-datapoint="HUMIDITY"></span>'
                   . '<span class="info" data-id="' . $component['RAINING'] . '" data-component="' . $component['component'] . '" data-datapoint="RAINING"></span>'
                 . '</div>'
                 . '<div class="pull-right">'
                   . '<span class="info" data-id="' . $component['WIND_SPEED'] . '" data-component="' . $component['component'] . '" data-datapoint="WIND_SPEED"></span>'
                   . '<span class="info" data-id="' . $component['ILLUMINATION'] . '" data-component="' . $component['component'] . '" data-datapoint="ILLUMINATION"></span>'
                   . '<span class="info" data-id="' . $component['RAIN_COUNTER'] . '" data-component="' . $component['component'] . '" data-datapoint="RAIN_COUNTER"></span>'
                 . '</div>'
             . '</div>';
    }
}
