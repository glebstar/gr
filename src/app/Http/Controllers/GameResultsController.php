<?php

namespace App\Http\Controllers;

use App\Models\Result;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Requests\AddResultRequest;
use App\Models\Member;
use function App\Helpers\hideEndEmail;

class GameResultsController extends Controller
{
    /**
     * Сохраняет результаты игры.
     *
     * @param AddResultRequest $request
     * @return JsonResponse
     */
    public function addResult(AddResultRequest $request): JsonResponse
    {
        //dd(hideEndEmail('blamsbl@example.com'));

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


        return response()->json(['status' => 'ok']);
    }
}
