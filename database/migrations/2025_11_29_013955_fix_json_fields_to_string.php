<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Fix MainComponents
        $mainComponents = DB::table('main_components')->get();
        
        foreach ($mainComponents as $mc) {
            $updates = [];
            
            // Fix saiz
            if ($mc->saiz && $this->isJson($mc->saiz)) {
                $decoded = json_decode($mc->saiz, true);
                $updates['saiz'] = is_array($decoded) ? ($decoded[0] ?? null) : $decoded;
            }
            
            // Fix saiz_unit
            if ($mc->saiz_unit && $this->isJson($mc->saiz_unit)) {
                $decoded = json_decode($mc->saiz_unit, true);
                $updates['saiz_unit'] = is_array($decoded) ? ($decoded[0] ?? null) : $decoded;
            }
            
            // Fix kadaran
            if ($mc->kadaran && $this->isJson($mc->kadaran)) {
                $decoded = json_decode($mc->kadaran, true);
                $updates['kadaran'] = is_array($decoded) ? ($decoded[0] ?? null) : $decoded;
            }
            
            // Fix kadaran_unit
            if ($mc->kadaran_unit && $this->isJson($mc->kadaran_unit)) {
                $decoded = json_decode($mc->kadaran_unit, true);
                $updates['kadaran_unit'] = is_array($decoded) ? ($decoded[0] ?? null) : $decoded;
            }
            
            // Fix kapasiti
            if ($mc->kapasiti && $this->isJson($mc->kapasiti)) {
                $decoded = json_decode($mc->kapasiti, true);
                $updates['kapasiti'] = is_array($decoded) ? ($decoded[0] ?? null) : $decoded;
            }
            
            // Fix kapasiti_unit
            if ($mc->kapasiti_unit && $this->isJson($mc->kapasiti_unit)) {
                $decoded = json_decode($mc->kapasiti_unit, true);
                $updates['kapasiti_unit'] = is_array($decoded) ? ($decoded[0] ?? null) : $decoded;
            }
            
            if (!empty($updates)) {
                DB::table('main_components')
                    ->where('id', $mc->id)
                    ->update($updates);
            }
        }
        
        // Fix SubComponents
        $subComponents = DB::table('sub_components')->get();
        
        foreach ($subComponents as $sc) {
            $updates = [];
            
            // Fix saiz
            if ($sc->saiz && $this->isJson($sc->saiz)) {
                $decoded = json_decode($sc->saiz, true);
                $updates['saiz'] = is_array($decoded) ? ($decoded[0] ?? null) : $decoded;
            }
            
            // Fix saiz_unit
            if ($sc->saiz_unit && $this->isJson($sc->saiz_unit)) {
                $decoded = json_decode($sc->saiz_unit, true);
                $updates['saiz_unit'] = is_array($decoded) ? ($decoded[0] ?? null) : $decoded;
            }
            
            // Fix kadaran
            if ($sc->kadaran && $this->isJson($sc->kadaran)) {
                $decoded = json_decode($sc->kadaran, true);
                $updates['kadaran'] = is_array($decoded) ? ($decoded[0] ?? null) : $decoded;
            }
            
            // Fix kadaran_unit
            if ($sc->kadaran_unit && $this->isJson($sc->kadaran_unit)) {
                $decoded = json_decode($sc->kadaran_unit, true);
                $updates['kadaran_unit'] = is_array($decoded) ? ($decoded[0] ?? null) : $decoded;
            }
            
            // Fix kapasiti
            if ($sc->kapasiti && $this->isJson($sc->kapasiti)) {
                $decoded = json_decode($sc->kapasiti, true);
                $updates['kapasiti'] = is_array($decoded) ? ($decoded[0] ?? null) : $decoded;
            }
            
            // Fix kapasiti_unit
            if ($sc->kapasiti_unit && $this->isJson($sc->kapasiti_unit)) {
                $decoded = json_decode($sc->kapasiti_unit, true);
                $updates['kapasiti_unit'] = is_array($decoded) ? ($decoded[0] ?? null) : $decoded;
            }
            
            if (!empty($updates)) {
                DB::table('sub_components')
                    ->where('id', $sc->id)
                    ->update($updates);
            }
        }
    }
    
    public function down()
    {
        // No rollback needed
    }
    
    private function isJson($string)
    {
        if (!is_string($string)) {
            return false;
        }
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }
};