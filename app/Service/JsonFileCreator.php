<?php

namespace App\Service;

use App\Helper\OfficeHelper;
use App\Service\IFileCreator;
use App\Model\Office;

class JsonFileCreator implements IFileCreator
{
    const FILE_NAME = 'offices.json';

    /**
     * @param $offices
     *
     * @return string
     */
    public function create($offices): string
    {
        $result = ['data' => []];

        /** @var Office $office */
        foreach ($offices as $office) {
            $result['data'][] = [
                'type'       => $office->getType(),
                'id'         => $office->getId(),
                'attributes' => [
                    'name'    => $office->getName(),
                    'address' => OfficeHelper::getAddressArray($office->getAddress()),
                    'phone'   => [
                        'countryNumber' => OfficeHelper::getCountryNumber($office->getPhone()),
                        'official'      => $office->getPhone(),
                    ],
                ],
            ];
        }
        $json = json_encode($result, JSON_UNESCAPED_UNICODE);
        file_put_contents(self::FILE_NAME, $json);

        return self::FILE_NAME;
    }
}