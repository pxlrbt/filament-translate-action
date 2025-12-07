<?php

namespace pxlrbt\FilamentTranslateAction\Actions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class TranslateModelAction
{
    public function __construct(
        private string $sourceLocale,
        private string $targetLocale,
        private string $apiKey,
    ) {}

    public function __invoke(Model $model): Model
    {
        $untranslatedAttributes = $this->getUntranslatedAttributes($model);

        $translatedAttributes = $this->translate($untranslatedAttributes);

        foreach ($translatedAttributes as $key => $value) {
            $model->setTranslation($key, $this->targetLocale, $value);
        }

        return $model;
    }

    protected function getUntranslatedAttributes(Model $model): array
    {
        $untranslatedAttributes = [];

        foreach ($model->translatable as $fieldName) {
            if ($model->hasTranslation($fieldName, $this->targetLocale)) {
                continue;
            }

            $originalValue = $model->getTranslation($fieldName, $this->sourceLocale);

            if (blank($originalValue)) {
                continue;
            }

            $untranslatedAttributes[$fieldName] = $originalValue;
        }

        return $untranslatedAttributes;
    }

    private function translate(array $attributes): array
    {
        $translations = [];
        $subsets = array_chunk($attributes, 50, true);

        foreach ($subsets as $subset) {
            $mapping = array_keys($subset);

            $data = Http::baseUrl('https://api-free.deepl.com/v2')
                ->withHeaders([
                    'Authorization' => 'DeepL-Auth-Key '.$this->getApiKey(),
                ])
                ->throw()
                ->post('/translate', [
                    'text' => array_values($subset),
                    'source_lang' => 'de',
                    'target_lang' => strtoupper($this->targetLocale),
                ])
                ->json();

            foreach ($data['translations'] as $index => $translation) {
                $translations[$mapping[$index]] = $translation['text'];
            }
        }

        return $translations;
    }

    protected function getApiKey(): string
    {
        return $this->apiKey;
    }
}
