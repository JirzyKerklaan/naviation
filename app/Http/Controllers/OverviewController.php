<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Http;


class OverviewController extends Controller
{
    public function index()
    {
        return Inertia::render('Home', [
            // 'flights' => $this->getData('flights'),
            'flights' => $this->getFLights(),
        ]);
    }

    public function viewFlight(Request $request, string $flightnumber)
    {
        // Here you would typically fetch the flight details from an API or database
        // For now, we'll just return a dummy flight detail
        return Inertia::render('Flight', [
            'flight' => [
                    "flight_date" => "2025-05-17",
                    "flight_status" => "scheduled",
                    "departure" => [
                    "airport" => "Los Angeles",
                    "timezone" => "US/Pacific",
                    "iata" => "LAX",
                    "icao" => "VTBS",
                    "terminal" => null,
                    "gate" => null,
                    "delay" => null,
                    "scheduled" => "2025-05-17T20:35:00+00:00",
                    "estimated" => "2025-05-18T06:35:00+00:00",
                    "actual" => null,
                    "estimated_runway" => null,
                    "actual_runway" => null
                    ],
                    "arrival" => [
                    "airport" => "New York",
                    "timezone" => "US/Eastern",
                    "iata" => "JFK",
                    "icao" => "VOMM",
                    "terminal" => "2",
                    "gate" => null,
                    "baggage" => null,
                    "scheduled" => "2025-05-18T06:10:00+00:00",
                    "delay" => null,
                    "estimated" => null,
                    "actual" => null,
                    "estimated_runway" => null,
                    "actual_runway" => null
                    ],
                    "airline" => [
                    "name" => "IndiGo",
                    "iata" => "6E",
                    "icao" => "IGO"
                    ],
                    "flight" => [
                    "number" => "$flightnumber",
                    "iata" => "6E1062",
                    "icao" => "IGO1062",
                    "codeshared" => null
                    ],
                    "aircraft" => null,
                    "live" => null
                ],
        ]);
    }
    
    // Real API call to get data
    private function getData(string $category)
    {
        $response = Http::get('https://api.aviationstack.com/v1/flights', [
            'access_key' => env('AVIATIONSTACK_API_KEY'),
        ])->json();

        return $response['data'] ?? [];
    }

    // Test data for flights
    private function getFlights(): array
    {
        $airports = $this->getAirports();
        $now = new \DateTimeImmutable('now', new \DateTimeZone('UTC'));
        $flights = [];

        for ($i = 0; $i < 10; $i++) {
            do {
                $departureAirport = $airports[array_rand($airports)];
                $arrivalAirport = $airports[array_rand($airports)];
            } while ($departureAirport['iata'] === $arrivalAirport['iata']);

            $randomMinutes = rand(0, 20 * $i);
            $departureTime = $now->sub(new \DateInterval('PT3H'))->add(new \DateInterval('PT' . $randomMinutes . 'M'));
            
            $randomArrivalMinutes = rand(240, 300);
            $arrivalTime = $departureTime->add(new \DateInterval('PT' . $randomArrivalMinutes . 'M'));


            $randomFlightnumber = rand(0, 1000 * ($i + 1));

            $flights[] = [
                "flight_date" => $departureTime->format('Y-m-d'),
                "flight_status" => "scheduled",
                "departure" => [
                    "airport" => $departureAirport['city'],
                    "timezone" => $departureAirport['timezone'],
                    "iata" => $departureAirport['iata'],
                    "icao" => $departureAirport['icao'],
                    "terminal" => null,
                    "gate" => null,
                    "delay" => null,
                    "scheduled" => $departureTime->format(\DateTime::ATOM),
                    "estimated" => $departureTime->format(\DateTime::ATOM),
                    "actual" => null,
                    "estimated_runway" => null,
                    "actual_runway" => null,
                ],
                "arrival" => [
                    "airport" => $arrivalAirport['city'],
                    "timezone" => $arrivalAirport['timezone'],
                    "iata" => $arrivalAirport['iata'],
                    "icao" => $arrivalAirport['icao'],
                    "terminal" => "2",
                    "gate" => null,
                    "baggage" => null,
                    "scheduled" => $arrivalTime->format(\DateTime::ATOM),
                    "delay" => null,
                    "estimated" => null,
                    "actual" => null,
                    "estimated_runway" => null,
                    "actual_runway" => null,
                ],
                "airline" => [
                    "name" => "Delta Air Lines",
                    "iata" => "DL",
                    "icao" => "DAL",
                ],
                "flight" => [
                    "number" => $randomFlightnumber,
                    "iata" => "DL" . (1000 + $i),
                    "icao" => "DAL" . (1000 + $i),
                    "codeshared" => null,
                ],
                "aircraft" => null,
                "live" => null,
            ];
        }

        return $flights;
    }

    private function getAirports(): array
    {
        return [
            [
                'airport' => 'John F. Kennedy International Airport',
                'city' => 'New York',
                'iata' => 'JFK',
                'icao' => 'KJFK',
                'timezone' => 'US/Eastern',
            ],
            [
                'airport' => 'Los Angeles International Airport',
                'city' => 'Los Angeles',
                'iata' => 'LAX',
                'icao' => 'KLAX',
                'timezone' => 'US/Pacific',
            ],
            [
                'airport' => 'Heathrow Airport',
                'city' => 'London',
                'iata' => 'LHR',
                'icao' => 'EGLL',
                'timezone' => 'Europe/London',
            ],
            [
                'airport' => 'Charles de Gaulle Airport',
                'city' => 'Paris',
                'iata' => 'CDG',
                'icao' => 'LFPG',
                'timezone' => 'Europe/Paris',
            ],
            [
                'airport' => 'Dubai International Airport',
                'city' => 'Dubai',
                'iata' => 'DXB',
                'icao' => 'OMDB',
                'timezone' => 'Asia/Dubai',
            ],
            [
                'airport' => 'Tokyo Haneda Airport',
                'city' => 'Tokyo',
                'iata' => 'HND',
                'icao' => 'RJTT',
                'timezone' => 'Asia/Tokyo',
            ],
            [
                'airport' => 'Frankfurt Airport',
                'city' => 'Frankfurt',
                'iata' => 'FRA',
                'icao' => 'EDDF',
                'timezone' => 'Europe/Berlin',
            ],
            [
                'airport' => 'Singapore Changi Airport',
                'city' => 'Singapore',
                'iata' => 'SIN',
                'icao' => 'WSSS',
                'timezone' => 'Asia/Singapore',
            ],
        ];
    }

}
