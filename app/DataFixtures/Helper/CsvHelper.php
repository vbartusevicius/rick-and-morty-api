<?php

declare(strict_types=1);

namespace DataFixtures\Helper;

use Traversable;

class CsvHelper
{
    public static function readRow(string $file, string $separator): Traversable
    {
        $fp = fopen($file, 'r');
        $head = fgetcsv($fp, 4096, $separator);

        while($column = fgetcsv($fp, 4096, $separator))
        {
            yield array_combine(
                $head,
                array_map(
                    static function (string $element): ?string {
                        if ($element === '') {
                            return null;
                        }
                        return $element;
                    },
                    $column
                )
            );
        }
    }
}
