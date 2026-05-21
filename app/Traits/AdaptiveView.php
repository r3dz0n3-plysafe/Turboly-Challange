<?php

namespace App\Traits;

use Jenssegers\Agent\Agent;

trait AdaptiveView
{
    protected function renderView($viewName, $data = [])
    {
        $agent = new Agent();
        $device = 'desktop'; // Default

        if ($agent->isTablet()) {
            $device = 'tablet';
        } elseif ($agent->isMobile()) {
            $device = 'mobile';
        }
        $targetView = "{$device}.{$viewName}";

        // Cek apakah file view perangkat tersebut benar-benar ada
        if (view()->exists($targetView)) {
            return view($targetView, $data);
        }

        return view("{$device}.{$viewName}", $data);
    }
}
