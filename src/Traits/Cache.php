<?php

namespace Fantismic\YetAnotherTable\Traits;

use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache as CacheFacade;

trait Cache
{
    public $cachePrefix = '';
    public $cacheTimeStamp;

    public function setCachePrefix(string $string) {
        $this->cachePrefix = $string."_";
    }

    public function cacheData() {
        $this->all_data_count = count($this->userData);
        if (!CacheFacade::has($this->cachePrefix.static::class.'\\'.Auth::user()->username)) {
            CacheFacade::put($this->cachePrefix.static::class.'\\'.Auth::user()->username, $this->userData, now()->addMinutes(60));
            $this->cacheTimeStamp = now()->getTimestampMs();
        }
    }

    public function clearData() {
        CacheFacade::forget($this->cachePrefix.static::class.'\\'.Auth::user()->username);
    }

    public function getCachedData() {
        if (!CacheFacade::has($this->cachePrefix.static::class.'\\'.Auth::user()->username)) {
            $this->mount();
        }
        return CacheFacade::get($this->cachePrefix.static::class.'\\'.Auth::user()->username);
    }

    public function updateCacheData($data) {
        $this->all_data_count = count($data);
        $this->emptySelection();
        CacheFacade::put($this->cachePrefix.static::class.'\\'.Auth::user()->username, $data, now()->addMinutes(60));
        $this->cacheTimeStamp = now()->getTimestampMs();
    }
}
