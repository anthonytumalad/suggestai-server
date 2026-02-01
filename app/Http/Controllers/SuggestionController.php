<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SuggestionService;
use Illuminate\Http\JsonResponse;

class SuggestionController extends Controller
{
    public function __construct(
        private readonly SuggestionService $suggestionService
    ) {}

    public function analyzeTopics(int $formId)
    {
        try {
            $suggestions = $this->suggestionService->getSuggestionsTextByForm($formId);

            if (empty($suggestions)) {
                return response()->json([
                    'message' => 'No suggestions found for this form',
                    'data' => []
                ]);
            }

            $topics = $this->suggestionService->analyzeTopics($suggestions);

            return response()->json([
                'message' => 'Topic modeling completed',
                'data' => $topics
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error analyzing topics',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function index(Request $request, int $formId): JsonResponse
    {
        $suggestions = $this->suggestionService->getSuggestionsByForm($formId, $request);
        return $suggestions;
    }
}
