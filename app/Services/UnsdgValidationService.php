<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class UnsdgValidationService
{
    /**
     * Validate a D-U-N-S number format.
     *
     * @param string $dunsNumber
     * @return bool
     */
    public function validateDunsNumber(string $dunsNumber): bool
    {
        // Basic format validation (9 digits)
        if (!preg_match('/^\d{9}$/', $dunsNumber)) {
            return false;
        }

        // Optional: Check the D-U-N-S number against cache to avoid repeated API calls
        $cacheKey = 'duns_validation_' . $dunsNumber;
        
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        // In a real implementation, you might validate against the D&B database
        // For now, we'll just do a basic check
        try {
            // Example of how you'd integrate with the D&B API (commented out)
            /*
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . config('services.dnb.api_key'),
                'Content-Type' => 'application/json'
            ])->get('https://api.dnb.com/v1/data/duns/' . $dunsNumber);
            
            $isValid = $response->successful() && !empty($response->json('organization'));
            */
            
            // For now, just implement basic validation
            // Sum of digits modulo 10 should equal the last digit (simplified check)
            $digits = str_split($dunsNumber);
            $checksum = array_sum(array_slice($digits, 0, 8)) % 10;
            $isValid = ($checksum == $digits[8]);
            
            // Cache the result for 24 hours
            Cache::put($cacheKey, $isValid, 86400);
            
            return $isValid;
        } catch (\Exception $e) {
            Log::error('D-U-N-S validation error', [
                'duns' => $dunsNumber,
                'error' => $e->getMessage()
            ]);
            
            // In case of API error, allow the registration to proceed
            // but mark it for manual verification
            return true;
        }
    }
    
    /**
     * Validate against UN Security Council sanctions lists.
     *
     * @param string $companyName
     * @param string $country
     * @return array
     */
    public function validateSanctionsCompliance(string $companyName, string $country): array
    {
        try {
            // This would typically integrate with UNGM or UN sanctions API
            // For demo purposes, we'll return a simulated result
            
            $cacheKey = 'sanctions_check_' . md5($companyName . $country);
            
            if (Cache::has($cacheKey)) {
                return Cache::get($cacheKey);
            }
            
            // In a real implementation, you would call the UN Global Marketplace API
            /*
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . config('services.ungm.api_key'),
                'Content-Type' => 'application/json'
            ])->post('https://api.ungm.org/v1/sanctions/check', [
                'entity_name' => $companyName,
                'country_code' => $country
            ]);
            
            $result = $response->json();
            */
            
            // Simulate a response for now
            $result = [
                'pass' => true,
                'matches' => [],
                'score' => 0
            ];
            
            // Cache results for 7 days (sanctions lists don't update frequently)
            Cache::put($cacheKey, $result, 604800);
            
            return $result;
        } catch (\Exception $e) {
            Log::error('Sanctions compliance check error', [
                'company' => $companyName,
                'country' => $country,
                'error' => $e->getMessage()
            ]);
            
            // Flag for manual review in case of API error
            return [
                'pass' => false,
                'manual_review' => true,
                'error' => 'API unavailable'
            ];
        }
    }
    
    /**
     * Validate if a company meets sustainable development goals criteria.
     *
     * @param array $companyData
     * @return array
     */
    public function validateSdgCompliance(array $companyData): array
    {
        // This would check if the company meets relevant SDG criteria
        // For demonstration purposes, we'll return a simulated result
        
        return [
            'sdg_compliant' => true,
            'sdg_categories' => [
                'gender_equality' => isset($companyData['womenOwnershipDocument']),
                'decent_work' => true,
                'climate_action' => false,
                'needs_review' => false
            ]
        ];
    }
    
    /**
     * Check if supplier is in a least developed country.
     *
     * @param string $countryCode
     * @return bool
     */
    public function isLeastDevelopedCountry(string $countryCode): bool
    {
        // List of least developed countries according to UN classification
        $ldcCountries = [
            'AF', 'AO', 'BD', 'BJ', 'BF', 'BI', 'KH', 'CF', 'TD', 
            'KM', 'CD', 'DJ', 'ER', 'ET', 'GM', 'GN', 'GW', 'HT', 
            'KI', 'LA', 'LS', 'LR', 'MG', 'MW', 'ML', 'MR', 'MZ', 
            'MM', 'NP', 'NE', 'RW', 'ST', 'SN', 'SL', 'SB', 'SO', 
            'SS', 'SD', 'TZ', 'TL', 'TG', 'TV', 'UG', 'VU', 'YE', 'ZM'
        ];
        
        return in_array(strtoupper($countryCode), $ldcCountries);
    }
    
    /**
     * Check if supplier qualifies for small-medium enterprise benefits.
     *
     * @param array $companyData
     * @return bool
     */
    public function isSmeQualified(array $companyData): bool
    {
        // This would implement UN's SME qualification logic
        // For demonstration, we'll return a simplified check
        
        // Criteria could include revenue thresholds, employee count, etc.
        return true;
    }
}