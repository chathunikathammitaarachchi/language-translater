<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class TranslateJson extends Command
{
    protected $signature = 'translate:json {source=en} {target=si}';
    protected $description = 'Translate JSON language file from source to target language';

    public function handle()
    {
        $source = $this->argument('source');
        $target = $this->argument('target');

        $sourcePath = resource_path("lang/{$source}.json");
        $targetPath = resource_path("lang/{$target}.json");

        if (!file_exists($sourcePath)) {
            $this->error("Source file '{$source}.json' does not exist!");
            return 1;
        }

        $strings = json_decode(file_get_contents($sourcePath), true);

        if (!$strings) {
            $this->error("Source JSON file is invalid!");
            return 1;
        }

        $this->info("Translating from '{$source}' to '{$target}'...");

        $translated = [];

        foreach ($strings as $key => $value) {
            $translated[$key] = $this->translateText($value, $source, $target);
            $this->line("{$key}: {$value} => {$translated[$key]}");
        }

        file_put_contents($targetPath, json_encode($translated, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        $this->info("✅ Translation complete! File saved to: resources/lang/{$target}.json");

        return 0;
    }

   protected function translateText($text, $source, $target)
{
$response = Http::withoutVerifying()->post('https://libretranslate.com/translate', [
    'q' => $text,
    'source' => $source,
    'target' => $target,
    'format' => 'text',
]);


// Debug log
$this->error("Status: " . $response->status());
$this->error("Body: " . $response->body());

if ($response->successful()) {
    $data = $response->json();
    if (isset($data['translatedText'])) {
        return $data['translatedText'];
    } else {
        $this->error("No 'translatedText' key in response: " . json_encode($data));
    }
} else {
    $this->error("API request failed: " . $response->status() . ' - ' . $response->body());
}
    // fallback to original text if failed
    return $text;
}

}
