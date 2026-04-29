<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CyberNewsService
{
    private const CHILE_NEWS_RSS = 'https://news.google.com/rss/search?q=ciberseguridad+site:cl&hl=es-419&gl=CL&ceid=CL:es-419';
    private const INTL_NEWS_RSS = 'https://thehackernews.com/feeds/posts/default?alt=rss';

    public function getLatestNews(int $limit = 4): array
    {
        return Cache::remember('cyber_news_feed', now()->addHours(2), function () use ($limit) {
            return [
                'national' => $this->fetchAndParseRss(self::CHILE_NEWS_RSS, $limit),
                'international' => $this->fetchAndParseRss(self::INTL_NEWS_RSS, $limit),
            ];
        });
    }

    private function fetchAndParseRss(string $url, int $limit): array
    {
        try {
            $response = Http::timeout(5)->get($url);

            if (! $response->successful()) {
                return [];
            }

            $xml = simplexml_load_string($response->body(), 'SimpleXMLElement', LIBXML_NOCDATA);
            
            if (! $xml) {
                return [];
            }

            $items = [];
            $count = 0;

            // Handle different RSS formats (Google News uses channel->item, Blogger uses entry)
            if (isset($xml->channel->item)) {
                foreach ($xml->channel->item as $item) {
                    if ($count >= $limit) break;
                    
                    $items[] = [
                        'title' => (string) $item->title,
                        'link' => (string) $item->link,
                        'pubDate' => (string) $item->pubDate,
                        'description' => strip_tags((string) $item->description),
                    ];
                    $count++;
                }
            } elseif (isset($xml->entry)) {
                // Atom format (like The Hacker News)
                foreach ($xml->entry as $entry) {
                    if ($count >= $limit) break;

                    // Get the link
                    $link = '';
                    foreach ($entry->link as $linkElement) {
                        if ((string) $linkElement['rel'] === 'alternate') {
                            $link = (string) $linkElement['href'];
                            break;
                        }
                    }

                    $items[] = [
                        'title' => (string) $entry->title,
                        'link' => $link,
                        'pubDate' => (string) $entry->published,
                        'description' => strip_tags((string) $entry->content ?? $entry->summary),
                    ];
                    $count++;
                }
            }

            return $items;
        } catch (\Exception $e) {
            Log::error("Failed to fetch RSS from {$url}: " . $e->getMessage());
            return [];
        }
    }
}
