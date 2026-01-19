<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class WilayahService
{
    protected string $baseUrl = 'https://open-api.my.id/api/wilayah';
    
    protected int $cacheTTL = 86400; // 24 hours in seconds
    
    public function getProvinces(): array
    {
        return Cache::remember('provinces', $this->cacheTTL, function () {
            $response = Http::get("{$this->baseUrl}/provinces");
            
            if (!$response->successful()) {
                return [];
            }
            
            return $response->json();
        });
    }
    
    public function getRegencies(string $provinceId): array
    {
        return Cache::remember("regencies.{$provinceId}", $this->cacheTTL, function () use ($provinceId) {
            $response = Http::get("{$this->baseUrl}/regencies/{$provinceId}");
            
            if (!$response->successful()) {
                return [];
            }
            
            return $response->json();
        });
    }
    
    public function getDistricts(string $regencyId): array
    {
        return Cache::remember("districts.{$regencyId}", $this->cacheTTL, function () use ($regencyId) {
            $response = Http::get("{$this->baseUrl}/districts/{$regencyId}");
            
            if (!$response->successful()) {
                return [];
            }
            
            return $response->json();
        });
    }
    
    public function getVillages(string $districtId): array
    {
        return Cache::remember("villages.{$districtId}", $this->cacheTTL, function () use ($districtId) {
            $response = Http::get("{$this->baseUrl}/villages/{$districtId}");
            
            if (!$response->successful()) {
                return [];
            }
            
            return $response->json();
        });
    }
    
    public function clearCache(string $key): void
    {
        if ($key) {
            Cache::forget($key);
        } else {
            // Clear all wilayah cache
            Cache::forget('provinces');
            // You might want to implement a more sophisticated cache clearing mechanism
            // if you need to clear all regencies, districts, etc.
        }
    }
}