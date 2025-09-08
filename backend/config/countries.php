<?php

$locale = env('APP_LOCALE', 'en');

$fallbackCountries = [
    'PH' => 'Philippines',
    'US' => 'United States',
    'CA' => 'Canada',
];

$fallbackStates = [
    'PH' => [
        'Abra' => 'Abra',
        'Agusan del Norte' => 'Agusan del Norte',
        'Agusan del Sur' => 'Agusan del Sur',
        'Albay' => 'Albay',
        'Apayao' => 'Apayao',
        'Benguet' => 'Benguet',
        'Ilocos Norte' => 'Ilocos Norte',
        'Ilocos Sur' => 'Ilocos Sur',
        'La Union' => 'La Union',
        'Metro Manila' => 'Metro Manila',
        'Pangasinan' => 'Pangasinan',
        'Zambales' => 'Zambales',
    ],
    'US' => [
        'AL' => 'Alabama',
        'AK' => 'Alaska',
        'AZ' => 'Arizona',
        'CA' => 'California',
        'CO' => 'Colorado',
        'FL' => 'Florida',
        'NY' => 'New York',
        'TX' => 'Texas',
        'WA' => 'Washington',
    ],
    'CA' => [
        'AB' => 'Alberta',
        'BC' => 'British Columbia',
        'MB' => 'Manitoba',
        'NB' => 'New Brunswick',
        'NL' => 'Newfoundland and Labrador',
        'NS' => 'Nova Scotia',
        'ON' => 'Ontario',
        'QC' => 'Quebec',
        'SK' => 'Saskatchewan',
    ],
];

$pathCountries = storage_path('app/meta/countries.' . $locale . '.json');
$list = $fallbackCountries;
if (is_file($pathCountries)) {
    $json = json_decode((string) file_get_contents($pathCountries), true);
    if (is_array($json) && ! empty($json)) {
        $list = $json;
    }
}

$statesAccessor = function (string $country) use ($locale, $fallbackStates) {
    $path = storage_path('app/meta/states/' . $country . '.' . $locale . '.json');
    if (is_file($path)) {
        $json = json_decode((string) file_get_contents($path), true);
        if (is_array($json)) {
            return $json;
        }
    }
    return $fallbackStates[$country] ?? [];
};

return [
    'list' => $list,
    'states' => new class($statesAccessor) {
        private $resolver;
        public function __construct(\Closure $resolver) { $this->resolver = $resolver; }
        public function __get($name) { return ($this->resolver)($name); }
        public function __invoke($country) { return ($this->resolver)($country); }
    },
];
