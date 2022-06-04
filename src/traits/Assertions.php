<?php

declare(strict_types=1);

namespace Game\traits;

trait Assertions
{
    public static function assertArrayLengthEquality(array $array, int $integer, string $message = null): void
    {
        if (count($array) != $integer)
            throw new \Exception($message ?? "The length of the array must be {$integer}");
    }

    public static function assertIsArrayContainsNaturalIntegers(array $array, string $message = null): void
    {
        foreach ($array as $item) {
            if (!is_numeric($item) || $item < 0)
                throw new \Exception($message ?? "The array must contain natural integers");
        }
    }

    public static function assertIsArrayContainsIntegers(array $array, string $message = null): void
    {
        foreach ($array as $item) {
            if (!is_numeric($item))
                throw new \Exception($message ?? "The array must contain integers");
        }
    }

    // public static function assertIsPositionValid(array $position, array $boardDimensions): array
    // {
    //     self::assertArrayLengthEquality($position, 2, 'The length of $position must be equal to 2');
    //     self::assertArrayLengthEquality($boardDimensions, 2, 'The length of $boardDimensions must be equal to 2');
    //     self::assertIsArrayContainsNaturalIntegers($position);
    //     self::assertIsArrayContainsNaturalIntegers($boardDimensions);

    //     $x = $position[0];
    //     $y = $position[1];

    //     if ($x > $boardDimensions['x'] || $y > $boardDimensions['y'])
    //         throw new \Exception("Position must be in range of {$boardDimensions['x']}x{$boardDimensions['y']}");

    //     return ['x' => $x, 'y' => $y];
    // }

}
