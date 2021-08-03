<?php

namespace App\Service;

use App\Model\Office;

class OfficeFileParser
{
    private $fileName;

    public function __construct($fileName)
    {
        $this->fileName = $fileName;
    }

    /**
     * @return array|null
     */
    public function getOffices(): ?array
    {
        $offices = [];

        if (file_exists($this->fileName) && is_readable($this->fileName)) {
            $lines = explode("\n", file_get_contents($this->fileName));

            $office = new Office();

            if (!empty($lines)) {
                foreach ($lines as $line) {
                    if (!empty(trim($line))) {
                        [$code, $value] = explode(':', $line);
                        $value = trim($value);
                        switch ($code) {
                            case 'id':
                                $office->setId($value);
                            case 'name':
                                $office->setName($value);
                            case 'address':
                                $office->setAddress($value);
                            case 'phone':
                                $office->setPhone($value);
                        }
                    } else {
                        $offices[] = $office;
                        unset($office);
                        $office = new Office();
                    }
                }

                if ($office instanceof Office) {
                    $offices[] = $office;
                    unset($office);
                }
            }
        }

        return $offices;
    }

}