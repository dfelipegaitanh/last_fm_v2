<?php

declare(strict_types=1);

namespace App\Console\Commands\LastFm;

use App\Actions\LastFm\FetchWeeklyChartList;
use App\Actions\LastFm\ProcessWeeklyTrackChart;
use App\Models\User;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ImportWeeklyChartsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lastfm:import-weekly-charts
                            {--username= : The Last.fm username to import charts for}
                            {--reprocess : Reprocess charts that have already been processed}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import weekly charts from Last.fm for a specific user';

    /**
     * Execute the console command.
     */
    public function handle(
        FetchWeeklyChartList $fetchWeeklyChartList,
        ProcessWeeklyTrackChart $processWeeklyTrackChart
    ): int {

        $reprocess = $this->option('reprocess');
        $username = $this->option('username');

        if (empty($username)) {
            $this->error('The Last.fm username option is required.');

            return Command::FAILURE;
        }

        try {
            $user = User::where('lastfm_user', $username)
                ->firstOrFail();

            $this->info("Importing weekly charts for Last.fm user: {$user->lastfm_user}");

            // Fetch all weekly charts
            $charts = $fetchWeeklyChartList->handle($user->lastfm_user);
            $this->info("Found {$charts->count()} weekly charts");

            // Process each chart
            $progressBar = $this->output->createProgressBar($charts->count());
            $progressBar->start();

            foreach ($charts as $chartDTO) {
                // Process the chart directly using the ProcessWeeklyTrackChart action
                // which will handle checking if it's already processed
                $weeklyChart = $processWeeklyTrackChart->handle(
                    user: $user,
                    from: $chartDTO->from,
                    to: $chartDTO->to
                );

                // If reprocessing is enabled and the chart was already processed,
                // we need to process it again
                if ($reprocess && $weeklyChart->processed) {
                    // First, remove existing tracks for this user and chart
                    $weeklyChart->tracksForUser($user)->detach();

                    // Then process it again
                    $weeklyChart->processed = false;
                    $weeklyChart->save();

                    $weeklyChart = $processWeeklyTrackChart->handle(
                        user: $user,
                        from: $chartDTO->from,
                        to: $chartDTO->to
                    );
                }

                $progressBar->advance();
            }

            $progressBar->finish();
            $this->newLine(2);
            $this->info('Weekly charts import completed successfully');

            return Command::SUCCESS;
        } catch (Exception $e) {
            $this->error("Error importing weekly charts: {$e->getMessage()}");
            Log::error('Weekly charts import failed', [
                'exception' => $e,
                'user_id' => $user->id, // $userId was not defined, I assume it should be $user->id
            ]);

            return Command::FAILURE;
        }
    }
}
