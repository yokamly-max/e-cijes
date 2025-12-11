<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class SupabaseService
{
    protected $baseUrl;
    protected $apiKey;

    public function __construct()
    {
        $this->baseUrl = env('SUPABASE_URL') . '/rest/v1';
        $this->apiKey = env('SUPABASE_API_KEY');
        $this->roleKey = env('SUPABASE_SERVICE_ROLE_KEY');
    }

    private function headers()
    {
        return [
            'apikey' => $this->apiKey,
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Content-Type' => 'application/json',
        ];
    }

    public function get($table, $query = [])
    {
        return Http::withHeaders($this->headers())
            ->get("{$this->baseUrl}/{$table}", $query)
            ->json();
    }

    public function insert($table, $data)
    {
        return Http::withHeaders($this->headers())
            ->post("{$this->baseUrl}/{$table}", $data)
            ->json();
    }

    public function update($table, $id, $data)
    {
        return Http::withHeaders($this->headers())
            ->patch("{$this->baseUrl}/{$table}?id=eq.{$id}", $data)
            ->json();
    }

    public function delete($table, $id)
    {
        return Http::withHeaders($this->headers())
            ->delete("{$this->baseUrl}/{$table}?id=eq.{$id}")
            ->json();
    }
    
public function insertWithServiceRole($table, $data)
{
    return Http::withHeaders([
        'apikey'        => env('SUPABASE_SERVICE_ROLE_KEY'),
        'Authorization' => 'Bearer ' . env('SUPABASE_SERVICE_ROLE_KEY'),
        'Content-Type'  => 'application/json',
        // ✅ On demande explicitement à Supabase de renvoyer les lignes créées
        'Prefer'        => 'return=representation',
    ])->post("{$this->baseUrl}/{$table}", $data)
      ->json();
}


}
