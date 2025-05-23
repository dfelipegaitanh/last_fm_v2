<?php

declare(strict_types=1);

namespace App\Console\Commands\LastFm;

use App\Actions\LastFm\Artists\SaveArtist;
use App\Actions\LastFm\Charts\FetchWeeklyChartList;
use App\Actions\LastFm\Charts\FetchWeeklyTrackChart;
use App\Actions\LastFm\Charts\ProcessWeeklyTrackChart;
use App\DTOs\LastFm\ArtistDTO;
use App\DTOs\LastFm\TrackDTO;
use App\DTOs\LastFm\WeeklyChartDTO;
use App\Models\LastFm\Artist;
use App\Models\LastFm\Chart;
use App\Models\User;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

use function Laravel\Prompts\alert;
use function Laravel\Prompts\info;
use function Laravel\Prompts\select;
use function Laravel\Prompts\text;

class ImportWeeklyChartsCommand extends Command
{
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import weekly charts from Last.fm for a specific user';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lastfm:import-weekly-charts ';

    public function __construct(
        private readonly ProcessWeeklyTrackChart $processWeeklyTrackChart,
        private readonly FetchWeeklyChartList $fetchWeeklyChartList,
        private readonly FetchWeeklyTrackChart $fetchWeeklyTrackChart,
        private readonly SaveArtist $saveArtist,
    ) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(

    ): int {

        //        $username = text(
        //            label: 'Last.fm username',
        //            default: 'svigle',
        //            required: true,
        //        );
        //        $reprocess = (bool) select(
        //            label: 'Reprocess charts?',
        //            options: [
        //                1 => 'Yes',
        //                0 => 'No',
        //            ],
        //            default: 1
        //        );
        $username = 'svigle';
        $reprocess = true;

        try {
            $user = User::where('lastfm_user', $username)
                ->firstOrFail();

            info("Importing weekly charts for Last.fm user: $user->lastfm_user");

            $charts = $this->fetchWeeklyChartList->handle($user);
            info("Found {$charts->count()} weekly charts");

            if ($charts->isEmpty()) {
                alert('No weekly charts were found for this user.');

                return Command::FAILURE;
            }

            foreach ($charts as $chart) {

                $weeklyChart = $this->getWeeklyChart(
                    $chart,
                    $reprocess,
                    $user
                );

                if ($weeklyChart->completed === true) {
                    $this->info('Period From '.$weeklyChart->from_formatted_date.' To '.$weeklyChart->to_formatted_date.' has already been processed');

                    continue;
                }

                //                if ($reprocess) {
                //                    $weeklyChart->update(['completed' => true, 'processed' => true]);
                //                }

                $tracks = $this->fetchWeeklyTrackChart->handle(username: $user->lastfm_user, from: $chart->from, to: $chart->to);
                info(message: "Period From {$weeklyChart->from_formatted_date} To {$weeklyChart->to_formatted_date} has {$tracks->count()} songs");

                if ($tracks->isEmpty()) {
                    $weeklyChart->update([
                        'completed' => true,
                        'processed' => true,
                    ]);

                    continue;
                }

                $tracks->each(function (TrackDTO $track): void {

                    $lastFmArtist = $this->getLastFmArtist($track->artist);


                });

                info("Found {$tracks->count()} tracks for this chart");

                //                $progressBar->advance();
            }

            //            $progressBar->finish();

            foreach ($charts as $chartDTO) {

                //                $weeklyChart = $this->getWeaklyChart($processWeeklyTrackChart, $chartDTO, $reprocess, $user);
                //
                //                if (true or $weeklyChart->completed === true && ! $reprocess) {
                //                    $this->info('Period From '.$weeklyChart->from_formatted.' To '.$weeklyChart->to_formatted.' has already been processed');
                //                }
                //
                //                dd($weeklyChart);
                //
                //                if ($weeklyChart->processed && $reprocess) {
                //                    // First, remove existing tracks for this user and chart
                //                    $weeklyChart->tracksForUser($user)->detach();
                //                    // Then process it again
                //                    $weeklyChart->processed = false;
                //                    $weeklyChart->save();
                //                    $weeklyChart = $processWeeklyTrackChart->handle(
                //                        from: $chartDTO->from,
                //                        to: $chartDTO->to
                //                    );
                //                }

                //                $progressBar->advance();
            }

            //            $progressBar->finish();
            $this->newLine(2);

            $this->info('Weekly charts import completed successfully');

            return Command::SUCCESS;
        } catch (Exception $e) {
            $this->error("Error importing weekly charts: {$e->getMessage()}");

            // Only log user ID if the user was found
            $logContext = ['exception' => $e];
            if (isset($user) && $user) {
                $logContext['user_id'] = $user->id;
                $logContext['lastfm_user'] = $user->lastfm_user;
            } else {
                $logContext['username_provided'] = $username;
            }

            Log::error('Weekly charts import failed', $logContext);

            return Command::FAILURE;
        }
    }

    private function getLastFmArtist(ArtistDTO $artist): Artist
    {
        return $this->saveArtist->handle($artist);
    }

    private function getWeeklyChart(WeeklyChartDTO $chartDTO, bool $reprocess, User $user): Chart
    {
        return $this->processWeeklyTrackChart->handle(
            from: $chartDTO->from,
            to: $chartDTO->to,
            reprocess: $reprocess,
            user: $user
        );
    }
}
