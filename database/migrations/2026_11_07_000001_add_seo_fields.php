<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private array $tables = ['services', 'projects', 'posts', 'events', 'members', 'post_categories', 'products'];

    private array $settingColumns = [
        'site_name', 'og_image', 'google_site_verification',
        'google_tag_id', 'google_ads_id', 'google_ads_label_lead', 'google_ads_label_phone',
        'business_type', 'business_street', 'business_city', 'business_state',
        'business_postcode', 'business_country', 'business_area_served',
        'business_opening_hours', 'business_latitude', 'business_longitude',
    ];

    public function up(): void
    {
        foreach ($this->tables as $table) {
            Schema::table($table, function (Blueprint $t) use ($table) {
                if (!Schema::hasColumn($table, 'seo_title')) {
                    $t->string('seo_title')->nullable();
                }
                if (!Schema::hasColumn($table, 'seo_meta_description')) {
                    $t->text('seo_meta_description')->nullable();
                }
            });
        }

        Schema::table('settings', function (Blueprint $t) {
            foreach ($this->settingColumns as $col) {
                if (!Schema::hasColumn('settings', $col)) {
                    $t->string($col)->nullable();
                }
            }
        });

        \DB::table('settings')->where('id', 1)->update([
            'site_name' => 'Affordable Fine Finish',
            'business_type' => 'GeneralContractor',
            'business_city' => 'Sydney',
            'business_state' => 'NSW',
            'business_country' => 'AU',
            'business_area_served' => 'Sydney',
        ]);
    }

    public function down(): void
    {
        foreach ($this->tables as $table) {
            Schema::table($table, function (Blueprint $t) {
                $t->dropColumn(['seo_title', 'seo_meta_description']);
            });
        }
        Schema::table('settings', function (Blueprint $t) {
            $t->dropColumn($this->settingColumns);
        });
    }
};
