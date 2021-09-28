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
 * @param int $seconds
 * @return DateInterval
 * @throws Exception
 */
function getDateInterval(int $seconds): DateInterval
{
    $day1 = date_create('@0');
    $day2 = date_create('@0')->add(new DateInterval('PT' . $seconds . 'S'));
    return $day2->diff($day1, true);
}
