<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\FeedProcessor;

class StoreRssFeed extends Command
{
    const URLS = [
        'https://www.omnycontent.com/d/playlist/2b465d4a-14ee-4fbe-a3c2-ac46009a2d5a/b1907157-de93-4ea2-a952-ac700085150f/be1924e3-559d-4f7d-98e5-ac7000851521/podcast.rss',
        'https://nosleeppodcast.libsyn.com/rss',
        'https://www.omnycontent.com/d/playlist/aaea4e69-af51-495e-afc9-a9760146922b/43816ad6-9ef9-4bd5-9694-aadc001411b2/808b901f-5d31-4eb8-91a6-aadc001411c0/podcast.rss',
        'https://feeds.megaphone.fm/stuffyoushouldknow',
        'https://feeds.megaphone.fm/stuffyoumissedinhistoryclass',
        'https://www.omnycontent.com/d/playlist/aaea4e69-af51-495e-afc9-a9760146922b/d2c4e775-99ce-4c17-b04c-ac380133d68c/2c6993d0-eac8-4252-8c4e-ac380133d69a/podcast.rss',
        'https://feeds.megaphone.fm/VMP5705694065',
        'https://feeds.simplecast.com/54nAGcIl',
    ];

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rss:store';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parse the podcast RSS feeds and store data about the podcast and its episodes into a database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(FeedProcessor $feedProcessor)
    {
        foreach(self::URLS as $url) {
            $this->line('Processing ' . $url);
            $feeds = file_get_contents($url);
            $feedProcessor->handle($feeds);
        }
        $this->info('The command was successful!');
        return 0;
    }
}
