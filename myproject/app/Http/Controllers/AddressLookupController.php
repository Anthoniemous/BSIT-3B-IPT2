<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class AddressLookupController extends Controller
{
    private string $base = 'https://psgc.cloud/api'; // 10-digit codes

    private function getJson(string $url, array $query = []): array
    {
        try {
            $res = Http::retry(2, 200)
                ->timeout(60)
                ->acceptJson()
                ->get($url, $query);

            if (!$res->ok()) return [];

            $json = $res->json();
            return is_array($json) ? $json : [];
        } catch (\Throwable $e) {
            return [];
        }
    }

    private function isList(array $arr): bool
    {
        return array_keys($arr) === range(0, count($arr) - 1);
    }

    private function toList(array $json): array
    {
        return $this->isList($json) ? $json : ($json['data'] ?? []);
    }

    private function normalize(array $list): array
    {
        $out = [];
        foreach ($list as $row) {
            if (!is_array($row)) continue;

            $code = (string)($row['code'] ?? '');
            $name = (string)($row['name'] ?? '');

            if ($code !== '' && $name !== '') {
                $out[] = ['code' => $code, 'name' => $name];
            }
        }
        return $out;
    }

    public function regions(Request $request)
    {
        if ($request->boolean('nocache')) Cache::forget('addr_regions');

        $data = Cache::remember('addr_regions', 86400, function () {
            return $this->toList($this->getJson($this->base . '/regions'));
        });

        return response()->json($this->normalize($data));
    }

    public function provinces(Request $request)
    {
        $regionCode = (string) $request->query('region_code');
        abort_unless($regionCode, 400, 'region_code required');

        $regionPrefix = substr($regionCode, 0, 2);

        $cacheKey = 'addr_provinces_' . $regionPrefix;
        if ($request->boolean('nocache')) Cache::forget($cacheKey);

        $data = Cache::remember($cacheKey, 86400, function () use ($regionPrefix) {
            $all = $this->toList($this->getJson($this->base . '/provinces'));

            return array_values(array_filter($all, function ($p) use ($regionPrefix) {
                $code = (string)($p['code'] ?? '');
                return $code !== '' && substr($code, 0, 2) === $regionPrefix;
            }));
        });

        return response()->json($this->normalize($data));
    }

    public function cities(Request $request)
    {
        $provinceCode = (string) $request->query('province_code');
        abort_unless($provinceCode, 400, 'province_code required');

        $provincePrefix = substr($provinceCode, 0, 5);

        $cacheKey = 'addr_cities_' . $provincePrefix;
        if ($request->boolean('nocache')) Cache::forget($cacheKey);

        $data = Cache::remember($cacheKey, 86400, function () use ($provincePrefix) {
            $all = $this->toList($this->getJson($this->base . '/cities-municipalities'));

            return array_values(array_filter($all, function ($c) use ($provincePrefix) {
                $code = (string)($c['code'] ?? '');
                return $code !== '' && substr($code, 0, 5) === $provincePrefix;
            }));
        });

        return response()->json($this->normalize($data));
    }

    // ✅ NEW WAY: fetch ALL barangays once, then filter by city prefix (first 7 digits)
   
}
