<?php

namespace App\Helpers;

class SystemHelper {
    public static function getFuelTypes() {
        return ['petrol', 'diesel', 'kerosene', 'jet_fuel'];
    }

    public static function getSensorTypes() {
        return ['mq2', 'bmp180'];
    }
}
