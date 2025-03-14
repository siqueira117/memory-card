<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    use WithoutModelEvents;
    
    const __LANGUAGES__ = [
        [ "language_id" => 1, "name" => "Arabic", "locale" => "ar", "native_name" => "العربية" ],
        [ "language_id" => 2, "name" => "Chinese (Simplified)", "locale" => "zh-CN", "native_name" => "简体中文" ],
        [ "language_id" => 3, "name" => "Chinese (Traditional)", "locale" => "zh-TW", "native_name" => "繁體中文" ],
        [ "language_id" => 4, "name" => "Czech", "locale" => "cs-CZ", "native_name" => "čeština" ],
        [ "language_id" => 5, "name" => "Danish", "locale" => "da-DK", "native_name" => "Dansk" ],
        [ "language_id" => 6, "name" => "Dutch", "locale" => "nl-NL", "native_name" => "Nederlands" ],
        [ "language_id" => 7, "name" => "English", "locale" => "en-US", "native_name" => "English (US)" ],
        [ "language_id" => 8, "name" => "English (UK)", "locale" => "en-GB", "native_name" => "English (UK)" ],
        [ "language_id" => 9, "name" => "Spanish (Spain)", "locale" => "es-ES", "native_name" => "Español (España)" ],
        [ "language_id" => 10, "name" => "Spanish (Mexico)", "locale" => "es-MX", "native_name" => "Español (Mexico)" ],
        [ "language_id" => 12, "name" => "French", "locale" => "fr-FR", "native_name" => "Français" ],
        [ "language_id" => 14, "name" => "Hungarian", "locale" => "hu-HU", "native_name" => "Magyar" ],
        [ "language_id" => 11, "name" => "Finnish", "locale" => "fi-FI", "native_name" => "Suomi" ],
        [ "language_id" => 15, "name" => "Italian", "locale" => "it-IT", "native_name" => "Italiano" ],
        [ "language_id" => 13, "name" => "Hebrew", "locale" => "he-IL", "native_name" => "עברית" ],
        [ "language_id" => 16, "name" => "Japanese", "locale" => "ja-JP", "native_name" => "日本語" ],
        [ "language_id" => 17, "name" => "Korean", "locale" => "ko-KR", "native_name" => "한국어" ],
        [ "language_id" => 18, "name" => "Norwegian", "locale" => "nb-NO", "native_name" => "Norsk" ],
        [ "language_id" => 20, "name" => "Portuguese (Portugal)", "locale" => "pt-PT", "native_name" => "Português (Portugal)" ],
        [ "language_id" => 21, "name" => "Portuguese (Brazil)", "locale" => "pt-BR", "native_name" => "Português (Brasil)" ],
        [ "language_id" => 19, "name" => "Polish", "locale" => "pl-PL", "native_name" => "Polski" ],
        [ "language_id" => 22, "name" => "Russian", "locale" => "ru-RU", "native_name" => "Русский" ],
        [ "language_id" => 24, "name" => "Turkish", "locale" => "tr-TR", "native_name" => "Türkçe" ],
        [ "language_id" => 25, "name" => "Thai", "locale" => "th-TH", "native_name" => "ไทย" ],
        [ "language_id" => 26, "name" => "Vietnamese", "locale" => "vi-VN", "native_name" => "Tiếng Việt" ],
        [ "language_id" => 23, "name" => "Swedish", "locale" => "sv-SE", "native_name" => "Svenska" ],
        [ "language_id" => 27, "name" => "German", "locale" => "de-DE", "native_name" => "Deutsch" ],
        [ "language_id" => 28, "name" => "Ukrainian", "locale" => "uk-UA", "native_name" => "українська" ],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (self::__LANGUAGES__ as $language) {
            Language::create($language);
        }
    }
}
