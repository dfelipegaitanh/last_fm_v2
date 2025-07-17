<?php

declare(strict_types=1);

namespace App\Console\Commands\LastFm;

use App\Actions\LastFm\Charts\DeleteWeeklyTrackCharts;
use App\Actions\LastFm\Charts\FetchWeeklyChartList;
use App\Actions\LastFm\Charts\FetchWeeklyTrackChart;
use App\Actions\LastFm\Charts\ProcessWeeklyTrackChart;
use App\Actions\LastFm\Charts\ProcessWeeklyTrackChartItems;
use App\Actions\LastFm\Charts\ShouldProcessWeeklyChart;
use App\Actions\LastFm\Tracks\FetchTrackInfo;
use App\Actions\LastFm\Tracks\SaveTrack;
use App\DTOs\LastFm\WeeklyChartDTO;
use App\Models\LastFm\Chart;
use App\Models\LastFm\Track;
use App\Models\User;
use App\Services\LastFm\ArtistCacheService;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

use function Laravel\Prompts\alert;
use function Laravel\Prompts\info;
use function Laravel\Prompts\progress;
use function Laravel\Prompts\table;

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
    protected $signature = 'lastfm:import-weekly-charts';

    private User $user;

    public function __construct(
        private readonly ArtistCacheService $artistCacheService,
        private readonly DeleteWeeklyTrackCharts $deleteWeeklyTrackCharts,
        private readonly FetchWeeklyChartList $fetchWeeklyChartList,
        private readonly FetchWeeklyTrackChart $fetchWeeklyTrackChart,
        private readonly ProcessWeeklyTrackChart $processWeeklyTrackChart,
        private readonly ProcessWeeklyTrackChartItems $processWeeklyTrackChartItems,
        private readonly ShouldProcessWeeklyChart $shouldProcessWeeklyChart,
    ) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): int
    {

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
        $reprocess = (bool) rand(0, 10);

        try {
            $this->user = User::where('lastfm_user', $username)
                ->firstOrFail();

            info("Importing weekly charts for Last.fm user: {$this->user->lastfm_user}");

            $charts = $this->fetchWeeklyChartList->handle($this->user);
            info("Found {$charts->count()} weekly charts");

            if ($charts->isEmpty()) {
                alert('No weekly charts were found for this user.');

                return Command::FAILURE;
            }

            foreach ($charts as $chart) {

                $weeklyChart = $this->processWeeklyTrackChart->handle(
                    from: $chart->from,
                    to: $chart->to,
                    user: $this->user
                );

                if ($reprocess) {
                    $this->deleteWeeklyTrackCharts->handle($weeklyChart);
                    $weeklyChart->markAsIncomplete();
                }

                if (! $this->shouldProcessWeeklyChart->handle($weeklyChart, $reprocess)) {
                    info('Period From '.$weeklyChart->from_formatted_date.' To '.$weeklyChart->to_formatted_date.' has already been processed');

                    continue;
                }

                $tracks = $this->fetchWeeklyTrackChart->handle(username: $this->user->lastfm_user, chart: $weeklyChart);
                info(message: "Period From {$weeklyChart->from_formatted_date} To {$weeklyChart->to_formatted_date} has {$tracks->count()} songs");

                if ($tracks->isEmpty()) {
                    $weeklyChart->markAsComplete();

                    continue;
                }

                $progress = progress(label: 'Processing tracks', steps: $tracks->count());
                $progress->start();

                $this->processWeeklyTrackChartItems->handle($weeklyChart, $tracks, $this->user);

                $progress->finish();

                table(['Song', 'Artist', 'Album', 'Playcount'], $weeklyChart->tracks->map(fn (Track $track): array => [
                    $track->name,
                    $track->artist->name,
                    $track->album?->title,
                    $track->pivot->playcount,
                ])->toArray());

                info("Found {$weeklyChart->tracks->count()} tracks for this chart");

                $weeklyChart->markAsComplete();

                $this->newLine(2);

                info('Weekly charts import completed successfully');

            }

            $this->artistCacheService->clearCache();

            $this->newLine(2);

            $this->info('Weekly charts import completed successfully');

            return Command::SUCCESS;
        } catch (Exception $e) {
            $this->error("Error importing weekly charts: {$e->getMessage()}");

            // Only log user ID if the user was found
            $logContext = ['exception' => $e];
            if (isset($this->user) && $this->user) {
                $logContext['user_id'] = $this->user->id;
                $logContext['lastfm_user'] = $this->user->lastfm_user;
            } else {
                $logContext['username_provided'] = $username;
            }

            Log::error('Weekly charts import failed', $logContext);

            return Command::FAILURE;
        }
    }

    private function getWeeklyChart(WeeklyChartDTO $chartDTO): Chart
    {
        return $this->processWeeklyTrackChart->handle(
            from: $chartDTO->from,
            to: $chartDTO->to,
            user: $this->user
        );
    }
}
