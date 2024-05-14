<?php

namespace Database\Seeders;

use App\Models\Characteristic;
use App\Models\Quest;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
        ]);

        $testData = [
            [
                'category' => 'Work',
                'quests' => [
                    [
                        'name' => 'Set Career Goals',
                        'slug' => 'set-career-goals',
                        'xp' => 50,
                        'description' => 'Define clear and achievable goals for your career path.',
                    ],
                    [
                        'name' => 'Seek Feedback',
                        'slug' => 'seek-feedback',
                        'xp' => 40,
                        'description' => 'Ask for constructive feedback to improve your performance.',
                    ],
                    [
                        'name' => 'Skill Development',
                        'slug' => 'skill-development',
                        'xp' => 60,
                        'description' => 'Identify areas for skill improvement and work on enhancing your expertise.',
                    ],
                ],
            ],
            [
                'category' => 'Finance',
                'quests' => [
                    [
                        'name' => 'Budgeting',
                        'slug' => 'budgeting',
                        'xp' => 50,
                        'description' => 'Create and stick to a budget to manage your finances effectively.',
                    ],
                    [
                        'name' => 'Saving Goals',
                        'slug' => 'saving-goals',
                        'xp' => 60,
                        'description' => 'Set realistic saving goals for short-term and long-term financial stability.',
                    ],
                    [
                        'name' => 'Debt Management',
                        'slug' => 'debt-management',
                        'xp' => 70,
                        'description' => 'Develop a plan to pay off debts and avoid accumulating new ones.',
                    ],
                ],
            ],
            [
                'category' => 'Skills',
                'quests' => [
                    [
                        'name' => 'Learning New Skills',
                        'slug' => 'learning-new-skills',
                        'xp' => 60,
                        'description' => 'Engage in continuous learning to expand your knowledge and abilities.',
                    ],
                    [
                        'name' => 'Professional Development',
                        'slug' => 'professional-development',
                        'xp' => 70,
                        'description' => 'Attend workshops or courses to enhance your professional skills.',
                    ],
                    [
                        'name' => 'Networking',
                        'slug' => 'networking',
                        'xp' => 50,
                        'description' => 'Build and maintain professional connections to support your career growth.',
                    ],
                ],
            ],
            [
                'category' => 'Health',
                'quests' => [
                    [
                        'name' => 'Exercise Regularly',
                        'slug' => 'exercise-regularly',
                        'xp' => 70,
                        'description' => 'Incorporate regular physical activity into your routine for better health.',
                    ],
                    [
                        'name' => 'Healthy Eating Habits',
                        'slug' => 'healthy-eating-habits',
                        'xp' => 60,
                        'description' => 'Adopt a balanced diet with plenty of fruits, vegetables, and whole grains.',
                    ],
                    [
                        'name' => 'Mental Wellness Practices',
                        'slug' => 'mental-wellness-practices',
                        'xp' => 80,
                        'description' => 'Practice mindfulness, meditation, or relaxation techniques to reduce stress.',
                    ],
                ],
            ],
            [
                'category' => 'Family',
                'quests' => [
                    [
                        'name' => 'Quality Time with Loved Ones',
                        'slug' => 'quality-time-with-loved-ones',
                        'xp' => 80,
                        'description' => 'Spend meaningful time with family and friends to nurture relationships.',
                    ],
                    [
                        'name' => 'Effective Communication',
                        'slug' => 'effective-communication',
                        'xp' => 70,
                        'description' => 'Improve communication skills to build stronger connections with others.',
                    ],
                    [
                        'name' => 'Resolve Conflicts Constructively',
                        'slug' => 'resolve-conflicts-constructively',
                        'xp' => 60,
                        'description' => 'Learn conflict resolution techniques to address disagreements peacefully.',
                    ],
                ],
            ],
            [
                'category' => 'Love',
                'quests' => [
                    [
                        'name' => 'Express Gratitude',
                        'slug' => 'express-gratitude',
                        'xp' => 70,
                        'description' => 'Show appreciation and gratitude towards your loved ones regularly.',
                    ],
                    [
                        'name' => 'Date Nights',
                        'slug' => 'date-nights',
                        'xp' => 60,
                        'description' => 'Plan special evenings together to keep the romance alive in your relationship.',
                    ],
                    [
                        'name' => 'Emotional Support',
                        'slug' => 'emotional-support',
                        'xp' => 80,
                        'description' => 'Offer and seek emotional support to strengthen your bond with your partner.',
                    ],
                ],
            ],
            [
                'category' => 'Home',
                'quests' => [
                    [
                        'name' => 'Organize Living Space',
                        'slug' => 'organize-living-space',
                        'xp' => 60,
                        'description' => 'Declutter and organize your home environment for improved productivity and relaxation.',
                    ],
                    [
                        'name' => 'Home Maintenance',
                        'slug' => 'home-maintenance',
                        'xp' => 70,
                        'description' => 'Regularly attend to home maintenance tasks to ensure a comfortable living space.',
                    ],
                    [
                        'name' => 'Create a Sanctuary',
                        'slug' => 'create-a-sanctuary',
                        'xp' => 80,
                        'description' => 'Designate a space in your home where you can unwind and rejuvenate.',
                    ],
                ],
            ],
            [
                'category' => 'Social',
                'quests' => [
                    [
                        'name' => 'Attend Social Events',
                        'slug' => 'attend-social-events',
                        'xp' => 70,
                        'description' => 'Participate in social gatherings and events to connect with others.',
                    ],
                    [
                        'name' => 'Cultivate Friendships',
                        'slug' => 'cultivate-friendships',
                        'xp' => 80,
                        'description' => 'Nurture and maintain friendships through regular communication and shared activities.',
                    ],
                    [
                        'name' => 'Join Communities',
                        'slug' => 'join-communities',
                        'xp' => 60,
                        'description' => 'Become involved in clubs or groups that align with your interests and values.',
                    ],
                ],
            ],
            [
                'category' => 'Spirituality',
                'quests' => [
                    [
                        'name' => 'Meditation Practice',
                        'slug' => 'meditation-practice',
                        'xp' => 80,
                        'description' => 'Establish a regular meditation practice to connect with your inner self.',
                    ],
                    [
                        'name' => 'Reflect on Values',
                        'slug' => 'reflect-on-values',
                        'xp' => 70,
                        'description' => 'Contemplate your core beliefs and values to deepen your sense of spirituality.',
                    ],
                    [
                        'name' => 'Acts of Kindness',
                        'slug' => 'acts-of-kindness',
                        'xp' => 60,
                        'description' => 'Engage in acts of kindness and compassion towards yourself and others.',
                    ],
                ],
            ],
            [
                'category' => 'Fun & Recreation',
                'quests' => [
                    [
                        'name' => 'Explore New Hobbies',
                        'slug' => 'explore-new-hobbies',
                        'xp' => 70,
                        'description' => 'Discover and try out new activities that bring you joy and excitement.',
                    ],
                    [
                        'name' => 'Adventure Travel',
                        'slug' => 'adventure-travel',
                        'xp' => 80,
                        'description' => 'Embark on thrilling adventures and explore new destinations around the world.',
                    ],
                    [
                        'name' => 'Laugh Often',
                        'slug' => 'laugh-often',
                        'xp' => 60,
                        'description' => 'Seek out opportunities for laughter and lightheartedness to boost your mood.',
                    ],
                ],
            ],
        ];

        foreach ($testData as $data) {
            $characteristic = Characteristic::create([
                'name' => $data['category'],
                'slug' => Str::slug($data['category']),
                'user_id' => $user->id,
            ]);
            foreach ($data['quests'] as $questData) {
                $quest = $user->quests()->create($questData);
                $quest->characteristics()->attach($characteristic->id);
            }
        }

    }
}
