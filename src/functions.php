<?php

declare(strict_types=1);

/**
 * @param object $obj
 * @return stdClass
 */
function getDataObject(object $obj): \stdClass
{
    return json_decode(json_encode($obj));
}

/**
 * @param object $obj
 * @return array
 */
function getDataArray(object $obj): array
{
    return json_decode(json_encode($obj), true);
}

/**
 * @return string
 */
function getMigrationsPath(): string
{
    return realpath(__DIR__ . '/../tests/lib/Migrations/') . DIRECTORY_SEPARATOR;
}
