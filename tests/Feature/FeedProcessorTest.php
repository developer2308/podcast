<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use function PHPUnit\Framework\assertEquals;
use App\Services\FeedProcessor;

class FeedProcessorTest extends TestCase
{
    /**
     * Test handle() function of FeedProcessor class.
     *
     */
    public function test_handle()
    {
        $feedProcessor = new FeedProcessor;
        $feedXml = file_get_contents('./tests/Feature/sample_feed.xml');
        $podCast = $feedProcessor->handle($feedXml);

        // Test title
        assertEquals('Hiking Treks', $podCast->title);

        // Test artwork url
        assertEquals('https://applehosted.podcasts.apple.com/hiking_treks/artwork.png', $podCast->artwork_url);

        // Test language
        assertEquals('en-us', $podCast->language);

        // Test rss feed url
        assertEquals('https://www.omnycontent.com/podcast.rss', $podCast->rss_feed_url);

        // Test website url
        assertEquals('https://www.apple.com/itunes/podcasts/', $podCast->website_url);

        // Test the count of episodes
        assertEquals(2, $podCast->episodes->count());
    }
}
