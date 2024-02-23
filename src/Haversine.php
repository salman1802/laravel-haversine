<?php
namespace Iroid\HaversinePackage;

class Haversine
{
    public static function distance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $unit = 'km', $earthRadius = 6371000)
    {
        $latFrom = deg2rad($latitudeFrom);
        $lonFrom = deg2rad($longitudeFrom);
        $latTo = deg2rad($latitudeTo);
        $lonTo = deg2rad($longitudeTo);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
            cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));

        $distance = $angle * $earthRadius;

        switch ($unit) {
            case 'km':
                // Convert meters to kilometers
                $distance /= 1000;
                break;
            case 'miles':
                // Convert meters to miles
                $distance *= 0.000621371;
                break;
            case 'nautical_miles':
                // Convert meters to nautical miles
                $distance *= 0.000539957;
                break;
            case 'meters':
                // Keep distance as is, already in meters
                break;
            default:
                throw new \InvalidArgumentException('Invalid unit provided. Must be one of: km, miles, nautical_miles, meters');
        }

        return $distance;
    }



    public static function haversineRaw($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371000)
    {
        // Calculate distances without unit conversion
        $latFrom = deg2rad($latitudeFrom);
        $lonFrom = deg2rad($longitudeFrom);
        $latTo = deg2rad($latitudeTo);
        $lonTo = deg2rad($longitudeTo);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
            cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));

        return $angle * $earthRadius;
    }

    public static function applyHaversine($query, $latitudeFrom, $longitudeFrom, $latitudeColumn = 'latitude', $longitudeColumn = 'longitude', $unit = 'km')
    {
        $distanceExpression = static::haversineRaw(
            $latitudeFrom,
            $longitudeFrom,
            $query->getModel()->{$latitudeColumn},
            $query->getModel()->{$longitudeColumn}
        );

        // Convert the distance based on the provided unit
        switch ($unit) {
            case 'km':
                // Convert meters to kilometers
                $distanceExpression /= 1000;
                break;
            case 'miles':
                // Convert meters to miles
                $distanceExpression *= 0.000621371;
                break;
            case 'nautical_miles':
                // Convert meters to nautical miles
                $distanceExpression *= 0.000539957;
                break;
            case 'meters':
                // Keep distance as is, already in meters
                break;
            default:
                throw new \InvalidArgumentException('Invalid unit provided. Must be one of: km, miles, nautical_miles, meters');
        }

        // Return the modified query
        return $query->selectRaw("*, $distanceExpression AS distance");
    }
}