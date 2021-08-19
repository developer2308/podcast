<?php

namespace App\Services;

use App\Models\Podcast;
use App\Models\Episode;

class FeedProcessor
{
    /**
     * Parse the podcast RSS feeds and store data about the podcast and its episodes into a database
     *
     * @param string $xmlString rss feed string
     *
     * @return Podcast saved model instance
     */
    public function handle(string $xmlString): Podcast {

        // Parse xml string to object
        $rss = simplexml_load_string($xmlString);

        // Parse itunes namespace
        $itunes = $rss->channel->children("http://www.itunes.com/dtds/podcast-1.0.dtd");

        $title = (string)$rss->channel->title;
        $artworkUrl = (string)$itunes->image->attributes()->href;
        $feedUrl = (string)$itunes->{"new-feed-url"};
        $description = trim((string)$rss->channel->description);
        $language = (string)$rss->channel->language;
        $websiteUrl = (string)$rss->channel->link;

        // Save podcast to database
        $podcast = Podcast::create([
            'title' => $title,
            'artwork_url' => $artworkUrl,
            'rss_feed_url' => $feedUrl,
            'description' => $description,
            'language' => $language,
            'website_url' => $websiteUrl,
        ]);

        // Save episodes of podcast to database
        foreach($rss->channel->item as $entry) {
            $title = (string)$entry->title;
            $description = trim((string)$entry->description);
            $audioUurl = (string)$entry->enclosure->attributes()->url;

            Episode::create([
                'title' => $title,
                'podcast_id' => $podcast->id,
                'description' => $description,
                'audio_url' => $audioUurl,
            ]);
        }

        return $podcast;
    }
}
