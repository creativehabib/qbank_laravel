<?php

namespace App\Console\Commands;

use App\Models\Organization;
use App\Models\PastExam;
use App\Models\Question;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class GenerateSitemapCommand extends Command
{
    protected $signature = 'sitemap:generate';

    protected $description = 'Generate the XML sitemap index and separate category sitemaps for the application';

    public function handle()
    {
        $this->info('Starting sitemap generation...');

        $sitemaps = [];

        // 1. Static Pages Sitemap
        $this->info('Generating static pages sitemap...');
        $staticUrls = [
            $this->createUrlNode(url('/'), '1.0', 'daily'),
            $this->createUrlNode(url('/job-solutions'), '0.9', 'daily'),
        ];
        $sitemaps[] = $this->saveSitemap('sitemap-static.xml', $staticUrls);

        // 2. Tools Sitemap
        $this->info('Generating tools sitemap...');
        $toolsUrls = [
            $this->createUrlNode(url('/tools'), '0.9', 'weekly'),
            $this->createUrlNode(url('/tools/payscale-calculator'), '0.8', 'monthly'),
            $this->createUrlNode(url('/tools/age-calculator'), '0.8', 'monthly'),
            $this->createUrlNode(url('/tools/cgpa-calculator'), '0.8', 'monthly'),
            $this->createUrlNode(url('/tools/unit-converter'), '0.8', 'monthly'),
        ];
        $sitemaps[] = $this->saveSitemap('sitemap-tools.xml', $toolsUrls);

        // 3. Organizations Sitemap
        $this->info('Generating organizations sitemap...');
        $orgUrls = [];
        $organizations = Organization::whereNotNull('slug')->get();
        foreach ($organizations as $org) {
            $orgUrls[] = $this->createUrlNode(url('/'.$org->slug), '0.8', 'weekly', $org->updated_at);
        }
        if (count($orgUrls) > 0) {
            $sitemaps[] = $this->saveSitemap('sitemap-organizations.xml', $orgUrls);
        }

        // 4. Exams Sitemap
        $this->info('Generating exams sitemap...');
        $examUrls = [];
        $pastExams = PastExam::with('organization')->whereNotNull('slug')->get();
        foreach ($pastExams as $exam) {
            if ($exam->organization && $exam->organization->slug) {
                $examUrls[] = $this->createUrlNode(url('/'.$exam->organization->slug.'/'.$exam->slug), '0.7', 'weekly', $exam->updated_at);
            }
        }
        if (count($examUrls) > 0) {
            $sitemaps[] = $this->saveSitemap('sitemap-exams.xml', $examUrls);
        }

        // 5. Questions Sitemap (Chunked into multiple files if > 40,000)
        $this->info('Generating questions sitemaps...');
        $questionCount = 0;
        $fileIndex = 1;
        $questionUrls = [];
        $maxPerFile = 40000;

        Question::whereNotNull('slug')->select('slug', 'updated_at')->chunk(5000, function ($questions) use (&$questionUrls, &$questionCount, &$fileIndex, &$sitemaps, $maxPerFile) {
            foreach ($questions as $question) {
                $questionUrls[] = $this->createUrlNode(url('/question/'.$question->slug), '0.6', 'monthly', $question->updated_at);
                $questionCount++;

                if (count($questionUrls) >= $maxPerFile) {
                    $filename = "sitemap-questions-{$fileIndex}.xml";
                    $sitemaps[] = $this->saveSitemap($filename, $questionUrls);
                    $questionUrls = [];
                    $fileIndex++;
                }
            }
        });

        // Save remaining questions
        if (count($questionUrls) > 0) {
            $filename = $fileIndex === 1 ? 'sitemap-questions.xml' : "sitemap-questions-{$fileIndex}.xml";
            $sitemaps[] = $this->saveSitemap($filename, $questionUrls);
        }

        // Generate Main Sitemap Index
        $this->info('Generating sitemap index...');
        $indexXml = '<?xml version="1.0" encoding="UTF-8"?>'.PHP_EOL;
        $indexXml .= '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'.PHP_EOL;

        foreach ($sitemaps as $sitemapFile) {
            $indexXml .= "  <sitemap>\n";
            $indexXml .= '    <loc>'.url('/'.$sitemapFile)."</loc>\n";
            $indexXml .= '    <lastmod>'.now()->toAtomString()."</lastmod>\n";
            $indexXml .= "  </sitemap>\n";
        }

        $indexXml .= '</sitemapindex>';
        File::put(public_path('sitemap.xml'), $indexXml);

        $this->info("Sitemap index generated successfully! Total question nodes: {$questionCount}");
    }

    private function saveSitemap($filename, $urls)
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>'.PHP_EOL;
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'.PHP_EOL;
        foreach ($urls as $url) {
            $xml .= $url;
        }
        $xml .= '</urlset>';

        File::put(public_path($filename), $xml);

        return $filename;
    }

    private function createUrlNode($url, $priority = '0.5', $changefreq = 'weekly', $lastmod = null)
    {
        $date = $lastmod ? Carbon::parse($lastmod)->toAtomString() : now()->toAtomString();

        return "  <url>\n    <loc>".htmlspecialchars($url)."</loc>\n    <lastmod>{$date}</lastmod>\n    <changefreq>{$changefreq}</changefreq>\n    <priority>{$priority}</priority>\n  </url>\n";
    }
}
