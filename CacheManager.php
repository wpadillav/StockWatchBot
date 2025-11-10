<?php

class CacheManager {
    private $cacheDir;
    private $defaultTTL;
    
    public function __construct($cacheDir = '/tmp/stock_cache/', $defaultTTL = 300) {
        $this->cacheDir = rtrim($cacheDir, '/') . '/';
        $this->defaultTTL = $defaultTTL;
        
        // Crear directorio de cache si no existe
        if (!is_dir($this->cacheDir)) {
            mkdir($this->cacheDir, 0755, true);
        }
    }
    
    /**
     * Obtener datos del cache
     */
    public function get($key) {
        $filename = $this->getCacheFilename($key);
        
        if (!file_exists($filename)) {
            return null;
        }
        
        $data = json_decode(file_get_contents($filename), true);
        
        if (!$data || time() > $data['expires']) {
            $this->delete($key);
            return null;
        }
        
        return $data['value'];
    }
    
    /**
     * Guardar datos en cache
     */
    public function set($key, $value, $ttl = null) {
        $ttl = $ttl ?? $this->defaultTTL;
        $filename = $this->getCacheFilename($key);
        
        $data = [
            'value' => $value,
            'expires' => time() + $ttl,
            'created' => time()
        ];
        
        return file_put_contents($filename, json_encode($data)) !== false;
    }
    
    /**
     * Eliminar entrada del cache
     */
    public function delete($key) {
        $filename = $this->getCacheFilename($key);
        
        if (file_exists($filename)) {
            return unlink($filename);
        }
        
        return true;
    }
    
    /**
     * Limpiar cache expirado
     */
    public function cleanup() {
        $files = glob($this->cacheDir . '*.cache');
        $cleaned = 0;
        
        foreach ($files as $file) {
            $data = json_decode(file_get_contents($file), true);
            
            if (!$data || time() > $data['expires']) {
                unlink($file);
                $cleaned++;
            }
        }
        
        return $cleaned;
    }
    
    /**
     * Obtener estadísticas del cache
     */
    public function getStats() {
        $files = glob($this->cacheDir . '*.cache');
        $totalSize = 0;
        $validEntries = 0;
        $expiredEntries = 0;
        
        foreach ($files as $file) {
            $totalSize += filesize($file);
            $data = json_decode(file_get_contents($file), true);
            
            if ($data && time() <= $data['expires']) {
                $validEntries++;
            } else {
                $expiredEntries++;
            }
        }
        
        return [
            'total_files' => count($files),
            'valid_entries' => $validEntries,
            'expired_entries' => $expiredEntries,
            'total_size_bytes' => $totalSize,
            'total_size_mb' => round($totalSize / 1024 / 1024, 2)
        ];
    }
    
    /**
     * Generar nombre de archivo para cache
     */
    private function getCacheFilename($key) {
        $hash = md5($key);
        return $this->cacheDir . $hash . '.cache';
    }
    
    /**
     * Verificar si una clave existe en cache y no ha expirado
     */
    public function exists($key) {
        return $this->get($key) !== null;
    }
    
    /**
     * Obtener o establecer (get or set pattern)
     */
    public function remember($key, $callback, $ttl = null) {
        $value = $this->get($key);
        
        if ($value === null) {
            $value = $callback();
            $this->set($key, $value, $ttl);
        }
        
        return $value;
    }
}
?>