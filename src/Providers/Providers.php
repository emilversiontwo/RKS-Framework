<?php

namespace Src\Providers;

$providers = [
    AppServiceProvider::class
];
new AppServiceProvider()->register();

foreach ($providers as $prov) {
    new $prov()->register();
}