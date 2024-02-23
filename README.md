# Laravel Haversine

Laravel Haversine is a package that provides utilities for calculating distances between geographical points using the Haversine formula. It includes a method that can be used with Laravel's Eloquent ORM to easily calculate distances between database records and a given point.

## Installation

You can install the package via Composer. Run the following command in your terminal:

```bash
composer require iroid/laravel-haversine
```

The package will automatically register itself.

## Usage

### Calculating Distance

You can use the `Haversine::distance()` method to calculate the distance between two geographical points using the Haversine formula. This method returns the distance in kilometers by default.

```php
use Iroid\LaravelHaversine\Haversine;

$latitudeFrom = 40.7128; // Latitude of point A
$longitudeFrom = -74.0060; // Longitude of point A
$latitudeTo = 34.0522; // Latitude of point B
$longitudeTo = -118.2437; // Longitude of point B

$distanceInKm = Haversine::distance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo);
```

### Using Different Units

You can specify the unit of measurement for the distance by passing an additional parameter to the `distance()` method. Supported units include kilometers (default), miles, nautical miles, and meters.

```php
$distanceInMiles = Haversine::distance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, 'miles');
$distanceInNauticalMiles = Haversine::distance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, 'nautical_miles');
$distanceInMeters = Haversine::distance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, 'meters');
```

### Using with Laravel Eloquent

You can use the `applyHaversine()` method provided by the package with Laravel's Eloquent ORM to calculate distances between database records and a given geographical point.

```php
use Iroid\LaravelHaversine\Haversine;

$latitudeFrom = 40.7128; // Latitude of the reference point
$longitudeFrom = -74.0060; // Longitude of the reference point

// Example: Retrieving places sorted by distance from the reference point
$places = Place::applyHaversine($latitudeFrom, $longitudeFrom)
                ->orderBy('distance')
                ->get();
```

#### Parameters for `applyHaversine()`

- `$query`: The Eloquent query builder instance.
- `$latitudeFrom`: Latitude of the reference point.
- `$longitudeFrom`: Longitude of the reference point.
- `$latitudeColumn` (optional): Custom column name for latitude in the database table. Defaults to `'latitude'`.
- `$longitudeColumn` (optional): Custom column name for longitude in the database table. Defaults to `'longitude'`.
- `$unit` (optional): Unit of measurement for the distance. Supported units are kilometers (default), miles, nautical miles, and meters.

You can use these parameters to customize the behavior of the `applyHaversine()` method according to your database schema and requirements.

## Credits

Interested to contribute or modification contact me [email](mailto:salman.iroid@gmail.com).

