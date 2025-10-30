<?php

declare(strict_types=1);

namespace App\Console\Commands\LastFm;

use App\Actions\LastFm\Cleanup\CleanupLastFmAlbums;
use App\Actions\LastFm\Cleanup\CleanupLastFmArtists;
use App\Actions\LastFm\Cleanup\CleanupLastFmTracks;
use App\Actions\LastFm\Cleanup\TruncateLastFmCharts;
use Illuminate\Console\Command;

use function Laravel\Prompts\info;
use function Laravel\Prompts\pause;

class CleanupLastFmDataCommand extends Command
{
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cleanup Last.fm data by removing unused records';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lastfm:cleanup-data';

    public function __construct(
        private readonly TruncateLastFmCharts $truncateLastFmCharts,
        private readonly CleanupLastFmTracks $cleanupLastFmTracks,
        private readonly CleanupLastFmArtists $cleanupLastFmArtists,
        private readonly CleanupLastFmAlbums $cleanupLastFmAlbums,
    ) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        info('Starting Last.fm data cleanup...');

        // Step 1: Truncate last_fm_charts table
        info('Truncating last_fm_charts table...');
        $this->truncateLastFmCharts->handle();
        pause('Presiona ENTER para continuar con la limpieza de tracks no utilizados.');

        // Step 2: Delete unused tracks
        info('Cleaning up unused tracks...');
        $this->cleanupLastFmTracks->handle();
        info('Unused tracks cleaned up successfully.');
        pause('Presiona ENTER para continuar con la limpieza de artistas no utilizados.');

        // Step 3: Delete unused artists
        info('Cleaning up unused artists...');
        $this->cleanupLastFmArtists->handle();
        info('Unused artists cleaned up successfully.');
        pause('Presiona ENTER para continuar con la limpieza de álbumes no utilizados.');

        // Step 4: Delete unused albums
        info('Cleaning up unused albums...');
        $this->cleanupLastFmAlbums->handle();
        info('Unused albums cleaned up successfully.');
        pause('Presiona ENTER para finalizar el proceso y confirmar los cambios (commit).');

        $this->info('Last.fm data cleanup completed successfully.');

        return Command::SUCCESS;
    }
}
