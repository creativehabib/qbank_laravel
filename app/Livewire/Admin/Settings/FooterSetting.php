<?php

namespace App\Livewire\Admin\Settings;

use App\Support\SettingsStore;
use Flux\Flux;
use Livewire\Component;

class FooterSetting extends Component
{
    public $about_text;

    public $copyright_text;

    public $facebook_url;

    public $youtube_url;

    public $twitter_url;

    public $linkedin_url;

    public $column1_title;

    public $column1_links;

    public $column2_title;

    public $column2_links;

    public $column3_title;

    public $column3_links;

    public $column4_title;

    public $column4_links;

    public function mount()
    {
        $settings = SettingsStore::group('frontend_footer');

        $this->about_text = $settings['about_text'] ?? 'একাডেমিক, এডমিশন এবং জব প্রিপারেশনের জন্য বাংলাদেশের সেরা ডিজিটাল প্রশ্নব্যাংক ও সমাধান প্ল্যাটফর্ম।';
        $this->copyright_text = $settings['copyright_text'] ?? '&copy; '.date('Y').' Qerobi.com সর্বস্বত্ব সংরক্ষিত।';

        $this->facebook_url = $settings['facebook_url'] ?? '#';
        $this->youtube_url = $settings['youtube_url'] ?? '#';
        $this->twitter_url = $settings['twitter_url'] ?? '#';
        $this->linkedin_url = $settings['linkedin_url'] ?? '#';

        $this->column1_title = $settings['column1_title'] ?? 'পরীক্ষা ও সমাধান';
        $this->column1_links = $settings['column1_links'] ?? "/job-solutions|জব সল্যুশন\n#|প্রশ্ন আর্কাইভ\n#|মডেল টেস্ট\n#|প্রতিষ্ঠানভিত্তিক আর্কাইভ";

        $this->column2_title = $settings['column2_title'] ?? 'একাডেমিক ও ভর্তি';
        $this->column2_links = $settings['column2_links'] ?? "#|এসএসসি\n#|এইচএসসি\n#|বিশ্ববিদ্যালয় ভর্তি\n#|মেডিকেল ও বুয়েট";

        $this->column3_title = $settings['column3_title'] ?? 'প্রস্তুতি টুলস';
        $this->column3_links = $settings['column3_links'] ?? "/tools/payscale-calculate|৯ম পে স্কেল ক্যালকুলেটর\n/tools/age-calculator|বয়স ক্যালকুলেটর\n#|নেগেটিভ মার্কিং\n#|সিভি মেকার";

        $this->column4_title = $settings['column4_title'] ?? 'Qerobi.com';
        $this->column4_links = $settings['column4_links'] ?? "#|আমাদের সম্পর্কে\n#|যোগাযোগ\n/pages/privacy|গোপনীয়তা নীতি\n#|ব্যবহারের শর্তাবলী";
    }

    public function save()
    {
        $data = [
            'about_text' => $this->about_text,
            'copyright_text' => $this->copyright_text,
            'facebook_url' => $this->facebook_url,
            'youtube_url' => $this->youtube_url,
            'twitter_url' => $this->twitter_url,
            'linkedin_url' => $this->linkedin_url,
            'column1_title' => $this->column1_title,
            'column1_links' => $this->column1_links,
            'column2_title' => $this->column2_title,
            'column2_links' => $this->column2_links,
            'column3_title' => $this->column3_title,
            'column3_links' => $this->column3_links,
            'column4_title' => $this->column4_title,
            'column4_links' => $this->column4_links,
        ];

        SettingsStore::saveGroup('frontend_footer', $data);

        Flux::toast('Frontend Footer settings updated successfully!', 'Success');
    }

    public function render()
    {
        return view('livewire.admin.settings.footer-setting')
            ->layout('layouts.app', ['title' => 'Footer Settings']);
    }
}
