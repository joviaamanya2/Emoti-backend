<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Truncate existing testimonials to avoid duplicates on re-runs
        \App\Models\UserTestimonial::truncate();

        $testimonials = [
            [
                'user_id' => '1',
                'user_name' => 'Sarah M.',
                'session_type' => 'Meditation',
                'what_worked' => 'Deep Breathing + Body Scan',
                'description' => 'The breathing exercises helped me calm down before my big presentation. I felt so much more centered!',
                'star_rating' => 5,
                'mood_when_it_worked' => 'Stressed',
                'is_approved' => 1,
                'helpful_count' => 12,
                'created_at' => now()->subDays(2),
            ],
            [
                'user_id' => '2',
                'user_name' => 'James K.',
                'session_type' => 'Self-Care',
                'what_worked' => 'Self-Love Meditations',
                'description' => 'I started the self-love meditation series and it genuinely changed how I view alone time. I feel more connected to myself.',
                'star_rating' => 5,
                'mood_when_it_worked' => 'Lonely',
                'is_approved' => 1,
                'helpful_count' => 8,
                'created_at' => now()->subDays(5),
            ],
            [
                'user_id' => '3',
                'user_name' => 'Priya R.',
                'session_type' => 'Journaling',
                'what_worked' => 'Gratitude Journaling',
                'description' => 'Morning gratitude journaling has made me notice so many good things I was overlooking. My whole day feels brighter now.',
                'star_rating' => 4,
                'mood_when_it_worked' => 'Great',
                'is_approved' => 1,
                'helpful_count' => 15,
                'created_at' => now()->subDays(1),
            ],
            [
                'user_id' => '4',
                'user_name' => 'Michael T.',
                'session_type' => 'Therapy',
                'what_worked' => 'Emotional Processing Sessions',
                'description' => 'When I was going through a tough time, the healing sessions helped me process my emotions without feeling overwhelmed.',
                'star_rating' => 5,
                'mood_when_it_worked' => 'Sad',
                'is_approved' => 1,
                'helpful_count' => 20,
                'created_at' => now()->subDays(7),
            ],
            [
                'user_id' => '5',
                'user_name' => 'Emma L.',
                'session_type' => 'Mindfulness',
                'what_worked' => 'Clarity & Decision Making',
                'description' => 'The clarity meditation helped me make a difficult career decision. I finally felt sure about my path forward.',
                'star_rating' => 4,
                'mood_when_it_worked' => 'Confused',
                'is_approved' => 1,
                'helpful_count' => 9,
                'created_at' => now()->subDays(3),
            ],
        ];

        $this->call(\Database\Seeders\AdminSeeder::class);

        foreach ($testimonials as $t) {
            \App\Models\UserTestimonial::create($t);
        }
    }
}
