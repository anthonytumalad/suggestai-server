<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;
use App\Models\Suggestion;
use App\Http\Resources\SuggestionResource;
use Illuminate\Http\Request;
use App\Traits\Pagination;

final readonly class SuggestionService
{
    use Pagination;

    protected string $pythonServiceUrl;

    public function __construct()
    {
        $this->pythonServiceUrl = config('services.python_bertopic.url');
    }

    public function getSuggestionsByForm(int $formId, Request $request)
    {
        $query = Suggestion::query()
            ->with('student:id,email,profile_picture')
            ->where('form_id', $formId);

        if ($request->has('start_date') && $request->start_date) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->has('end_date') && $request->end_date) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $query->latest();

        return $this->paginateWithResource(
            $query,
            SuggestionResource::class,
            $request,
            [
                'per_page' => 15,
                'max_per_page' => 100,
                'allowed_sort_columns' => ['id', 'created_at'],
                'default_sort' => [
                    'column' => 'created_at',
                    'direction' => 'desc'
                ],
            ],
            ['suggestion', 'student.email'],
        );
    }

    public function getSuggestionsTextByForm(int $formId): array
    {
        return Suggestion::where('form_id', $formId)
            ->latest()
            ->pluck('suggestion')
            ->toArray();
    }

    public function analyzeTopics(array $suggestions): array
    {
        if (empty($suggestions)) {
            throw new \Exception('No suggestions to analyze');
        }

        /** @var Response $response */
        $response = Http::timeout(60)->post($this->pythonServiceUrl, [
            'documents' => $suggestions,
        ]);

        if ($response->successful()) {
            return $response->json();
        }

        throw new \Exception('Python service returned an error: ' . $response->body(), $response->status());
    }
}
