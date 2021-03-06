<?php
/*
 * LibreNMS
 *
 * This program is free software: you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the
 * Free Software Foundation, either version 3 of the License, or (at your
 * option) any later version.  Please see LICENSE.txt at the top level of
 * the source code distribution for details.
 */

$transmitPower = snmp_get($device, "transmitPower.0", "-Ovqn", "CAMBIUM-PTP250-MIB");
if (is_numeric($transmitPower)) {
    $rrd_def = 'DS:transmitPower:GAUGE:600:0:100';
    $fields = array(
        'transmitPower' => $transmitPower / 10,
    );

    $tags = compact('rrd_def');
    data_update($device, 'cambium-250-transmitPower', $tags, $fields);
    $graphs['cambium_250_transmitPower'] = TRUE;
}

$receivePower = snmp_get($device, "receivePower.0", "-Ovqn", "CAMBIUM-PTP250-MIB");
$noiseFloor = snmp_get($device, "noiseFloor.0", "-Ovqn", "CAMBIUM-PTP250-MIB");
if (is_numeric($receivePower)) {
    $rrd_def = array(
        'DS:receivePower:GAUGE:600:-150:0',
        'DS:noiseFloor:GAUGE:600:-150:0'
    );
    $fields = array(
        'receivePower' => $receivePower / 10,
        'noiseFloor' => $noiseFloor,
    );

    $tags = compact('rrd_def');
    data_update($device, 'cambium-250-receivePower', $tags, $fields);
    $graphs['cambium_250_receivePower'] = TRUE;
}

$txModulation = snmp_get($device, ".1.3.6.1.4.1.17713.250.5.9.0", "-Ovqn", "");
$rxModulation = snmp_get($device, ".1.3.6.1.4.1.17713.250.5.8.0", "-Ovqn", "");
if (is_numeric($txModulation) && is_numeric($rxModulation)) {
    $rrd_def = array(
        'DS:txModulation:GAUGE:600:0:24',
        'DS:rxModulation:GAUGE:600:0:24'
    );
    $fields = array(
        'txModuation' => $txModulation,
        'rxModulation' => $rxModulation,
    );

    $tags = compact('rrd_def');
    data_update($device, 'cambium-250-modulationMode', $tags, $fields);
    $graphs['cambium_250_modulationMode'] = TRUE;
}

$receiveDataRate = snmp_get($device, "receiveDataRate.0", "-Ovqn", "CAMBIUM-PTP250-MIB");
$transmitDataRate = snmp_get($device, "transmitDataRate.0", "-Ovqn", "CAMBIUM-PTP250-MIB");
$aggregateDataRate = snmp_get($device, "aggregateDataRate.0", "-Ovqn", "CAMBIUM-PTP250-MIB");
if (is_numeric($receiveDataRate) && is_numeric($transmitDataRate) && is_numeric($aggregateDataRate)) {
    $rrd_def = array(
        'DS:receiveDataRate:GAUGE:600:0:10000',
        'DS:transmitDataRate:GAUGE:600:0:10000',
        'DS:aggregateDataRate:GAUGE:600:0:10000'
    );
    $fields = array(
        'receiveDataRate' => $receiveDataRate / 100,
        'transmitDataRate' => $transmitDataRate / 100,
        'aggregateDataRate' => $aggregateDataRate / 100,
    );

    $tags = compact('rrd_def');
    data_update($device, 'cambium-250-dataRate', $tags, $fields);
    $graphs['cambium_250_dataRate'] = TRUE;
}

$ssr = snmp_get($device, "signalStrengthRatio.0", "-Ovqn", "CAMBIUM-PTP250-MIB");
if (is_numeric($ssr)) {
    $rrd_def = 'DS:ssr:GAUGE:600:-150:150';
    $fields = array(
        'ssr' => $ssr,
    );

    $tags = compact('rrd_def');
    data_update($device, 'cambium-250-ssr', $tags, $fields);
    $graphs['cambium_250_ssr'] = TRUE;
}