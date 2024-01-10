<?php

namespace App\Services;

use App\Models\Member;
use App\Models\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function App\Helpers\hideEndEmail;

class GameResult
{
    /**
     * Добавляет результат игры.
     *
     * @param Request $request
     * @return void
     */
    public function addResult(Request $request): void
    {
        if ($request->email) {
            Member::factory()
                ->state([
                    'email' => $request->email,
                ])
                ->has(Result::factory()
                    ->state([
                        'milliseconds' => $request->milliseconds,
                    ]))
                ->create();
        } else {
            Result::create(['milliseconds' => $request->milliseconds]);
        }
    }

    /**
     * Возвращает результаты игры.
     *
     * @param Request $request
     * @return array
     */
    public function getResults(Request $request): array
    {
        DB::select("set @row:=0");

        $top = DB::table('members', 'm')
            ->selectRaw('@row:=@row+1 as place, results.milliseconds, m.email')
            ->leftJoin('results', 'm.id', '=', 'results.member_id')
            ->whereNotNull('results.member_id')
            ->orderBy('results.milliseconds')
            ->orderBy('results.id')
            ->limit(10)
            ->get();

        foreach ($top as $item) {
            $item->email = hideEndEmail($item->email);
        }

        return [
            'top' => $top,
            'self' => $request->email ? $this->getSelf($request->email) : false,
        ];
    }

    /**
     * Возвращает результаты для одного email.
     *
     * @param $email
     * @return \stdClass|bool
     */
    private function getSelf($email): \stdClass|bool
    {
        $self = DB::select('SELECT * FROM (
    SELECT @i:=@i+1 place,
     r.milliseconds, m.email
    FROM members m
    LEFT JOIN results r ON r.member_id = m.id, (SELECT @i:=0) X
    WHERE r.member_id IS NOT NULL
    ORDER BY r.milliseconds, r.id
) t WHERE t.email=?
ORDER BY t.milliseconds
LIMIT 1', [$email]);

        return $self[0] ?? false;
    }
}
