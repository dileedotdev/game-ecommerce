<?php

namespace App\Filament\Resources\UserResource\Widgets;

use App\Models\User;
use Filament\Widgets\LineChartWidget;

class RegisteringOverview extends LineChartWidget
{
    public ?string $filter = '1';

    protected int|string|array $columnSpan = 'full';

    protected static ?string $pollingInterval = null;

    protected function getFilters(): ?array
    {
        return [
            '1' => 'Month',
            '3' => 'Three months',
            '6' => 'Six months',
            '12' => 'Year',
        ];
    }

    protected function getData(): array
    {
        $filter = (int) $this->filter;
        $ceil = now()->valueOf();
        $floor = now()->subMonths($filter)->valueOf();
        $interval = $ceil - $floor;

        $columns = 30;
        for ($i = 0; $i < $columns; ++$i) {
            $registered[] = 0;
            $verified[] = 0;
            $labels[] = '';
        }

        $users = User::where('created_at', '>=', now()->subMonths($filter))->get('created_at');
        foreach ($users as $user) {
            ++$registered[
                floor(
                    (($user->created_at->valueOf() - $floor) / $interval) * $columns
                )
            ];
        }

        $users = User::where('email_verified_at', '>=', now()->subMonths($filter))->get('email_verified_at');
        foreach ($users as $user) {
            ++$verified[
                floor(
                    (($user->email_verified_at->valueOf() - $floor) / $interval) * $columns
                )
            ];
        }

        return [
            'datasets' => [
                [
                    'label' => 'Users created',
                    'data' => $registered,
                    'tension' => 0.2,
                ],
                [
                    'label' => 'Users verified',
                    'data' => $verified,
                    'borderColor' => '#00ff00',
                    'backgroundColor' => '#00ff00',
                    'tension' => 0.2,
                ],
            ],
            'labels' => $labels,
        ];
    }
}
