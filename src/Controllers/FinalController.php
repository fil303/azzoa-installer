<?php

namespace IsrafilHossain\LaravelInstaller\Controllers;

use Illuminate\Routing\Controller;
use IsrafilHossain\LaravelInstaller\Events\LaravelInstallerFinished;
use IsrafilHossain\LaravelInstaller\Helpers\EnvironmentManager;
use IsrafilHossain\LaravelInstaller\Helpers\FinalInstallManager;
use IsrafilHossain\LaravelInstaller\Helpers\InstalledFileManager;

class FinalController extends Controller
{
    function __construct()
    {
        set_time_limit(300);
    }

    /**
     * Update installed file and display finished view.
     *
     * @param \IsrafilHossain\LaravelInstaller\Helpers\InstalledFileManager $fileManager
     * @param \IsrafilHossain\LaravelInstaller\Helpers\FinalInstallManager $finalInstall
     * @param \IsrafilHossain\LaravelInstaller\Helpers\EnvironmentManager $environment
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function finish(InstalledFileManager $fileManager, FinalInstallManager $finalInstall, EnvironmentManager $environment)
    {
        $finalMessages = $finalInstall->runFinal();
        $finalStatusMessage = $fileManager->update();
        $finalEnvFile = $environment->getEnvContent();

        event(new LaravelInstallerFinished);

        return view('vendor.installer.finished', compact('finalMessages', 'finalStatusMessage', 'finalEnvFile'));
    }
}
