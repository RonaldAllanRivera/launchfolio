<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'countries:refresh', description: 'Generate JSON datasets for countries and ISO 3166-2 subdivisions from maintained sources (if installed), with safe fallbacks.')]
class CountriesRefreshCommand extends Command
{
    protected $signature = 'countries:refresh {--locale=en : Locale for localized names (e.g. en, fr, es)}';

    protected $description = 'Generate JSON datasets for countries and ISO 3166-2 subdivisions from maintained sources (if installed), with safe fallbacks.';

    public function handle(): int
    {
        $locale = (string) $this->option('locale') ?: 'en';

        $metaDir = storage_path('app/meta');
        $statesDir = $metaDir . DIRECTORY_SEPARATOR . 'states';
        if (! is_dir($metaDir)) {
            mkdir($metaDir, 0775, true);
        }
        if (! is_dir($statesDir)) {
            mkdir($statesDir, 0775, true);
        }

        $countries = (array) (config('countries.list') ?? []);

        // Try to use symfony/intl for localized country names
        if (class_exists(\Symfony\Component\Intl\Countries::class)) {
            try {
                /** @var array<string,string> $names */
                $names = \Symfony\Component\Intl\Countries::getNames($locale);
                if (! empty($names)) {
                    // Ensure keys are ISO alpha-2 codes
                    $countries = $names;
                }
                $this->info('Loaded country names from symfony/intl for locale: ' . $locale);
            } catch (\Throwable $e) {
                $this->warn('symfony/intl failed: ' . $e->getMessage() . ' — using fallback config dataset.');
            }
        } else {
            $this->warn('symfony/intl not installed. Using fallback config dataset.');
        }

        // Write countries JSON
        $countriesFile = $metaDir . DIRECTORY_SEPARATOR . 'countries.' . $locale . '.json';
        file_put_contents($countriesFile, json_encode($countries, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        $this->info('Wrote ' . count($countries) . ' countries to ' . $countriesFile);

        // Subdivisions per country via commerceguys/addressing if available
        $subdivisionCount = 0;
        if (class_exists(\CommerceGuys\Addressing\Subdivision\SubdivisionRepository::class)) {
            try {
                $repo = new \CommerceGuys\Addressing\Subdivision\SubdivisionRepository();
                foreach (array_keys($countries) as $countryCode) {
                    $list = [];
                    if (method_exists($repo, 'getList')) {
                        // getList accepts parent IDs array like ['US'] and returns [code => name]
                        $list = (array) $repo->getList([$countryCode]);
                    } elseif (method_exists($repo, 'getAll')) {
                        $subs = (array) $repo->getAll([$countryCode]);
                        foreach ($subs as $sub) {
                            // Subdivision interface has getCode/getName
                            if (is_object($sub) && method_exists($sub, 'getCode') && method_exists($sub, 'getName')) {
                                $list[$sub->getCode()] = $sub->getName();
                            }
                        }
                    }

                    if (! empty($list)) {
                        $file = $statesDir . DIRECTORY_SEPARATOR . $countryCode . '.' . $locale . '.json';
                        file_put_contents($file, json_encode($list, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
                        $subdivisionCount += count($list);
                    }
                }
                $this->info('Wrote subdivisions for countries that provide them (total entries: ' . $subdivisionCount . ').');
            } catch (\Throwable $e) {
                $this->warn('commerceguys/addressing failed: ' . $e->getMessage() . ' — skipping subdivisions.');
            }
        } else {
            $this->warn('commerceguys/addressing not installed. Skipping subdivisions.');
        }

        $this->info('Done. Clear config cache to use updated datasets: php artisan config:clear');
        return self::SUCCESS;
    }
}
