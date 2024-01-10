<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Http\Requests\AddResultRequest;
use App\Http\Requests\GetResultsRequest;
use App\Http\Resources\MemberResource;
use App\Services\GameResult;

class GameResultsController extends Controller
{
    /**
     * @var GameResult
     */
    private GameResult $gameResultService;

    public function __construct(GameResult $gameResultService)
    {
        $this->gameResultService = $gameResultService;
    }

    /**
     * Сохраняет результаты игры.
     *
     * @param AddResultRequest $request
     * @return JsonResponse
     */
    public function addResult(AddResultRequest $request): JsonResponse
    {
        $this->gameResultService->addResult($request);

        return response()->json(['status' => 'ok']);
    }

    /**
     * Возращает результаты игры.
     *
     * @param GetResultsRequest $request
     * @return JsonResponse
     */
    public function getResults(GetResultsRequest $request): JsonResponse
    {
        $results = $this->gameResultService->getResults($request);

        $data = [
            'top' => MemberResource::collection($results['top']),
        ];

        if ($results['self']) {
            $data['self'] = new MemberResource($results['self']);
        }

        return response()->json(['data' => $data]);
    }
}
