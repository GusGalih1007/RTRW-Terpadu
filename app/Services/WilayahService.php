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
        $provinceIds = $data->pluck('kodeProvinsi')->unique()->filter();
        $regencyIds = $data->pluck('kodeKabupaten')->unique()->filter();
        $districtIds = $data->pluck('kodeKecamatan')->unique()->filter();

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

        return $data->map(function ($item) use ($provinces, $regencies, $districts, $villages) {
            $item->province_name = $provinces->firstWhere('id', $item->kodeProvinsi)['name'] ?? '-';
            $item->regency_name = $regencies->firstWhere('id', $item->kodeKabupaten)['name'] ?? '-';
            $item->district_name = $districts->firstWhere('id', $item->kodeKecamatan)['name'] ?? '-';
            $item->village_name = $villages->firstWhere('id', $item->kodeKelurahan)['name'] ?? '-';

            return $item;
        });
    }
}
