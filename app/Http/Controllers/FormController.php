<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Services\FormService;
use App\Http\Requests\CreateFormRequest;
use Illuminate\Http\Request;

class FormController extends Controller
{
    public function __construct(
        private readonly FormService $formService
    ) {}

    public function index(Request $request, ?int $userId = null)
    {
        $this->authorize('viewAny', Form::class);
        return $this->formService->index($request, $userId);
    }

    public function store(CreateFormRequest $request)
    {
        $this->authorize('store', Form::class);

        return response()->json([
            'message' => 'Form created successfully',
            'data' => $this->formService->store($request->validated()),
        ], 201);
    }


    public function show(string $slug)
    {
        return $this->formService->show($slug);
    }
}
