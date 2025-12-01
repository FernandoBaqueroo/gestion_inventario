<?php

/**
 * Clase base para consumir APIs externas
 */
class ApiService
{
    protected $baseUrl;
    protected $timeout = 10;
    protected $cacheDir;
    protected $cacheDuration = 3600; // 1 hora por defecto

    public function __construct()
    {
        // Directorio para cache de respuestas
        $this->cacheDir = __DIR__ . '/../../cache/api/';

        // Crear directorio si no existe
        if (!file_exists($this->cacheDir)) {
            mkdir($this->cacheDir, 0755, true);
        }
    }

    /**
     * Realizar petición GET a una API
     */
    protected function get($endpoint, $params = [])
    {
        // Construir URL
        $url = $this->baseUrl . $endpoint;

        if (!empty($params)) {
            $url .= '?' . http_build_query($params);
        }

        // Verificar cache
        $cacheKey = md5($url);
        $cachedData = $this->getFromCache($cacheKey);

        if ($cachedData !== null) {
            return $cachedData;
        }

        // Realizar petición con cURL
        $ch = curl_init();

        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => $this->timeout,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_SSL_VERIFYPEER => false, // Para desarrollo local
            CURLOPT_HTTPHEADER => [
                'Accept: application/json',
                'User-Agent: PHP-Inventory-System/1.0'
            ]
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);

        curl_close($ch);

        // Manejar errores
        if ($error) {
            error_log("API Error: " . $error);
            return null;
        }

        if ($httpCode !== 200) {
            error_log("API HTTP Error: " . $httpCode);
            return null;
        }

        // Decodificar respuesta
        $data = json_decode($response, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            error_log("API JSON Error: " . json_last_error_msg());
            return null;
        }

        // Guardar en cache
        $this->saveToCache($cacheKey, $data);

        return $data;
    }

    /**
     * Obtener datos del cache
     */
    protected function getFromCache($key)
    {
        $cacheFile = $this->cacheDir . $key . '.json';

        if (!file_exists($cacheFile)) {
            return null;
        }

        // Verificar si el cache expiró
        $cacheTime = filemtime($cacheFile);
        if (time() - $cacheTime > $this->cacheDuration) {
            unlink($cacheFile);
            return null;
        }

        $data = file_get_contents($cacheFile);
        return json_decode($data, true);
    }

    /**
     * Guardar datos en cache
     */
    protected function saveToCache($key, $data)
    {
        $cacheFile = $this->cacheDir . $key . '.json';
        file_put_contents($cacheFile, json_encode($data));
    }

    /**
     * Limpiar cache
     */
    public function clearCache()
    {
        $files = glob($this->cacheDir . '*.json');
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
    }
}
