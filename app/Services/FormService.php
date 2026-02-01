<?php

namespace App\Services;

use App\Models\Form;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\FormResource;
use Illuminate\Http\Request;
use App\Traits\Pagination;

final readonly class FormService
{
    use Pagination;

    public function index(Request $request, ?int $userId = null)
    {
        $userId ??= Auth::id();

        $query = Form::query()
            ->ofUser($userId)
            ->withCount('suggestions')
            ->latest();

        return $this->paginateWithResource(
            $query,
            FormResource::class,
            $request,
            ['per_page' => 15, 'max_per_page' => 100]
        );
    }


    //for the student to see the form
    public function show(string $slug)
    {
        $form = Form::where('slug', $slug)->active()->firstOrFail();

        $student = Auth::user();

        return view('form', [
            'form' => $form,
            'userEmail' => $student?->email ?? null,
        ]);
    }

    public function store(array $data): FormResource
    {
        $data['user_id'] = Auth::id();

        if (!empty($data['img'])) {
            $path = $data['img']->store('forms', 'public');
            $data['img_path'] = "storage/{$path}";
        }

        $form = Form::create($data);

        return new FormResource($form);
    }
}
