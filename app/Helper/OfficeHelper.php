<?php

namespace App\Helper;

class OfficeHelper
{
    /**
     * @param string $phone
     *
     * @return string
     */
    public static function getCountryNumber(string $phone): string
    {
        return preg_replace('![^0-9]+!', '', $phone);
    }

    /**
     * @param string $address
     *
     * @return null | array
     */
    public static function getAddressArray(string $address): ?array
    {
        $resultAddress = [];
        if (preg_match('/г.(.*?) улица/', $address, $match) == 1) {
            $resultAddress['city'] = $match[1];
        }
        if (preg_match('/улица (.*?) дом/', $address, $match) == 1) {
            $resultAddress['street'] = $match[1];
        }

        if (preg_match('/офис/', $address, $match)) {
            if (preg_match('/дом (.*?) офис/', $address, $match) == 1) {
                $resultAddress['house'] = $match[1];
            }
            $officeOrApartment = explode('офис ', $address);
            $resultAddress['officeOrApartment'] = $officeOrApartment[1];
        } else {
            $house = explode('дом ', $address);
            $resultAddress['house'] = $house[1];
        }

        return $resultAddress;
    }
}