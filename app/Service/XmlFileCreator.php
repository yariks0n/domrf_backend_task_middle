<?php

namespace App\Service;

use App\Helper\OfficeHelper;
use App\Model\Office;
use DOMDocument;

class XmlFileCreator implements IFileCreator
{
    const FILE_NAME = 'offices.xml';

    /**
     * @param $offices
     *
     * @return string
     */
    public function create($offices): string
    {
        $dom = new DOMDocument('1.0', 'utf-8');
        $dom->formatOutput = true;
        $companies = $dom->createElement('companies');
        $dom->appendChild($companies);

        /** @var Office $office */
        foreach ($offices as $office) {
            $company = $dom->createElement('company');
            $company->appendChild($dom->createElement("company-id", $office->getId()));
            $name = $dom->createElement("name", $office->getName());
            $name->setAttribute('lang', 'ru');
            $company->appendChild($name);
            $phone = $dom->createElement('phone');
            $phoneType = $dom->createElement('type', 'phone');
            $phoneNumber = $dom->createElement('number', $office->getPhone());
            $phone->appendChild($phoneType);
            $phone->appendChild($phoneNumber);
            $company->appendChild($phone);
            $address = $dom->createElement('address', $office->getAddress());
            $address->setAttribute('lang', 'ru');
            $company->appendChild($address);

            $addresArray = OfficeHelper::getAddressArray($office->getAddress());
            if (!empty($addresArray['officeOrApartment'])) {
                $company->appendChild($dom->createElement('address-add', 'офис ' . $addresArray['officeOrApartment']));
            }
            $companies->appendChild($company);
        }

        $dom->save(self::FILE_NAME);

        return self::FILE_NAME;
    }
}