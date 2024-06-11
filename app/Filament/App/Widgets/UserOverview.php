<?php

namespace App\Filament\App\Widgets;

use App\Enums\QuestStatus;
use App\Models\Characteristic;
use App\Models\User;
use Filament\Widgets\Concerns\CanPoll;
use Filament\Widgets\Widget;
use Illuminate\Contracts\Support\Htmlable;

class UserOverview extends Widget implements Htmlable
{
    use CanPoll;

    protected static ?int $sort = 1;

    protected int|string|array $columnSpan = 1;

    protected static string $view = 'filament.app.widgets.user-overview';

    protected function getViewData(): array
    {
        $user = auth()->user();

        $stats = [];
        $characteristics = Characteristic::all();
        foreach ($characteristics as $item) {
            $total = 10;
            $completed = $item->quests()->where('status', QuestStatus::COMPLETED)->count();
            $stats[] = [
                'name' => $item->name,
                'color' => $item->color,
                'progress' => $total ? $completed / $total * 100 : 0,
            ];
        }

        return [
            'name' => $user->name,
            'avatar' => filament()->getUserAvatarUrl($user),
            'level' => $user->level,
            'progress' => ($user->xp / User::MAX_XP) * 100,
            'stats' => $stats,
        ];
    }

    public function toHtml(): string
    {
        return $this->render()->render();
    }
}
