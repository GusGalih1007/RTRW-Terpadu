<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class WilayahService
{
    protected string $baseUrl;
    protected int $cacheTTL;

    public function __construct()
    {
        $this->baseUrl = config('services.wilayah.base_url', 'https://open-api.my.id/api/wilayah');
        $this->cacheTTL = config('services.wilayah.cache_ttl', 86400);
    }

    public function getProvinces(): array
    {
        return Cache::remember('provinces', $this->cacheTTL, function () {
            try {
                $response = Http::get("{$this->baseUrl}/provinces");

                if (!$response->successful()) {
                    Log::error('WilayahService: Failed to fetch provinces', [
                        'status' => $response->status(),
                        'body' => $response->body()
                    ]);
                    return [];
                }

                $data = $response->json();

                // Debug log
                Log::info('WilayahService: Provinces fetched successfully', [
                    'count' => count($data),
                    'sample' => $data[0] ?? null
                ]);

                return $data;
            } catch (\Exception $e) {
                Log::error('WilayahService: Exception when fetching provinces', [
                    'error' => $e->getMessage()
                ]);
                return [];
            }
        });
    }

    public function getRegencies(string $provinceId): array
    {
        if (empty($provinceId)) {
            return [];
        }

        return Cache::remember("regencies.{$provinceId}", $this->cacheTTL, function () use ($provinceId) {
            try {
                $response = Http::get("{$this->baseUrl}/regencies/{$provinceId}");

                if (!$response->successful()) {
                    Log::error('WilayahService: Failed to fetch regencies', [
                        'province_id' => $provinceId,
                        'status' => $response->status(),
                        'body' => $response->body()
                    ]);
                    return [];
                }

                $data = $response->json();

                // Debug log
                Log::info('WilayahService: Regencies fetched successfully', [
                    'province_id' => $provinceId,
                    'count' => count($data),
                    'sample' => $data[0] ?? null
                ]);

                return $data;
            } catch (\Exception $e) {
                Log::error('WilayahService: Exception when fetching regencies', [
                    'province_id' => $provinceId,
                    'error' => $e->getMessage()
                ]);
                return [];
            }
        });
    }

    public function getDistricts(string $regencyId): array
    {
        if (empty($regencyId)) {
            return [];
        }

        return Cache::remember("districts.{$regencyId}", $this->cacheTTL, function () use ($regencyId) {
            try {
                $response = Http::get("{$this->baseUrl}/districts/{$regencyId}");

                if (!$response->successful()) {
                    Log::error('WilayahService: Failed to fetch districts', [
                        'regency_id' => $regencyId,
                        'status' => $response->status(),
                        'body' => $response->body()
                    ]);
                    return [];
                }

                $data = $response->json();

                // Debug log
                Log::info('WilayahService: Districts fetched successfully', [
                    'regency_id' => $regencyId,
                    'count' => count($data),
                    'sample' => $data[0] ?? null
                ]);

                return $data;
            } catch (\Exception $e) {
                Log::error('WilayahService: Exception when fetching districts', [
                    'regency_id' => $regencyId,
                    'error' => $e->getMessage()
                ]);
                return [];
            }
        });
    }

    public function getVillages(string $districtId): array
    {
        if (empty($districtId)) {
            return [];
        }

        return Cache::remember("villages.{$districtId}", $this->cacheTTL, function () use ($districtId) {
            try {
                $response = Http::get("{$this->baseUrl}/villages/{$districtId}");

                if (!$response->successful()) {
                    Log::error('WilayahService: Failed to fetch villages', [
                        'district_id' => $districtId,
                        'status' => $response->status(),
                        'body' => $response->body()
                    ]);
                    return [];
                }

                $data = $response->json();

                // Debug log
                Log::info('WilayahService: Villages fetched successfully', [
                    'district_id' => $districtId,
                    'count' => count($data),
                    'sample' => $data[0] ?? null
                ]);

                return $data;
            } catch (\Exception $e) {
                Log::error('WilayahService: Exception when fetching villages', [
                    'district_id' => $districtId,
                    'error' => $e->getMessage()
                ]);
                return [];
            }
        });
    }

    public function mapWilayahCollection($data)
    {
        // Ensure $data is always a collection
        $collection = collect($data);
        
        // Handle case where collection might contain strings instead of objects
        if ($collection->isEmpty()) {
            return $collection;
        }

        // Check if the first item is a string (which would cause the error)
        $firstItem = $collection->first();
        if (is_string($firstItem)) {
            Log::error('WilayahService: mapWilayahCollection received string data instead of objects', [
                'first_item' => $firstItem,
                'collection_type' => gettype($firstItem)
            ]);
            return $collection;
        }
        
        $provinceIds = $collection->pluck('kodeProvinsi')->unique()->filter();
        $regencyIds = $collection->pluck('kodeKabupaten')->unique()->filter();
        $districtIds = $collection->pluck('kodeKecamatan')->unique()->filter();

        $provinces = collect($this->getProvinces());

        $regencies = collect();
        foreach ($provinceIds as $provinceId) {
            $regencies = $regencies->merge($this->getRegencies($provinceId));
        }

        $districts = collect();
        foreach ($regencyIds as $regencyId) {
            $districts = $districts->merge($this->getDistricts($regencyId));
        }

        $villages = collect();
        foreach ($districtIds as $districtId) {
            $villages = $villages->merge($this->getVillages($districtId));
        }

        return $collection->map(function ($item) use ($provinces, $regencies, $districts, $villages) {
            // Ensure $item is an object before accessing properties
            if (!is_object($item) && !is_array($item)) {
                Log::warning('WilayahService: Skipping non-object item in mapWilayahCollection', [
                    'item_type' => gettype($item),
                    'item_value' => $item
                ]);
                return $item;
            }

            // Get province name
            $provinceName = '-';
            if (isset($item->kodeProvinsi) || isset($item['kodeProvinsi'])) {
                $provinceId = $item->kodeProvinsi ?? $item['kodeProvinsi'];
                $province = $provinces->firstWhere('id', $provinceId);
                $provinceName = $province ? $province['name'] : '-';
            }

            // Get regency name
            $regencyName = '-';
            if (isset($item->kodeKabupaten) || isset($item['kodeKabupaten'])) {
                $regencyId = $item->kodeKabupaten ?? $item['kodeKabupaten'];
                $regency = $regencies->firstWhere('id', $regencyId);
                $regencyName = $regency ? $regency['name'] : '-';
            }

            // Get district name
            $districtName = '-';
            if (isset($item->kodeKecamatan) || isset($item['kodeKecamatan'])) {
                $districtId = $item->kodeKecamatan ?? $item['kodeKecamatan'];
                $district = $districts->firstWhere('id', $districtId);
                $districtName = $district ? $district['name'] : '-';
            }

            // Get village name
            $villageName = '-';
            if (isset($item->kodeKelurahan) || isset($item['kodeKelurahan'])) {
                $villageId = $item->kodeKelurahan ?? $item['kodeKelurahan'];
                $village = $villages->firstWhere('id', $villageId);
                $villageName = $village ? $village['name'] : '-';
            }

            // Add the new properties to the item
            if (is_object($item)) {
                $item->province_name = $provinceName;
                $item->regency_name = $regencyName;
                $item->district_name = $districtName;
                $item->village_name = $villageName;
            } elseif (is_array($item)) {
                $item['province_name'] = $provinceName;
                $item['regency_name'] = $regencyName;
                $item['district_name'] = $districtName;
                $item['village_name'] = $villageName;
            }

            return $item;
        });
    }
}
