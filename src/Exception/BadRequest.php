<?php
namespace Rjsmelo\Fiware\Poi\Exception;

/**
 * Thrown if the the request sent to the server is invalid
 */
class BadRequest extends \RuntimeException implements PoiExceptionInterface
{
}
