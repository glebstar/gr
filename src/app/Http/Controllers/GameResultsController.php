<?php

namespace App\Http\Controllers;

use App\Models\Result;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Requests\AddResultRequest;
use App\Models\Member;

class GameResultsController extends Controller
{
    public function addResult(AddResultRequest $request): JsonResponse
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


        return response()->json(['status' => 'ok']);
    }
}
