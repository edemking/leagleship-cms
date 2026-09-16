<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Statamic\Facades\Asset;
use Statamic\Facades\Entry;

class ProgramController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $request->validate([
            'is_past' => ['nullable', 'in:true,false,1,0'],
        ]);

        $programs = Entry::query()
            ->where('collection', 'programs')
            ->whereStatus('published')
            ->when(
                $request->has('is_past'),
                fn ($query) => $query->where('is_past', $request->boolean('is_past')),
            )
            ->orderBy('date_time')
            ->get()
            ->map(fn ($program) => [
                'id' => $program->id(),
                'title' => $program->get('title'),
                'date_time' => $this->isoDateTime($program->get('date_time')),
                'is_past' => (bool) $program->get('is_past'),
                'summary' => $program->get('summary'),
                'image' => $this->imageUrl($program->get('image')),
                'apply_url' => $program->get('apply_url'),
            ])
            ->values();

        return response()->json([
            'data' => $programs,
        ]);
    }

    private function imageUrl(mixed $image): ?string
    {
        $path = is_array($image) ? $image[0] ?? null : $image;

        return $path ? Asset::find($path)?->url() : null;
    }

    private function isoDateTime(mixed $dateTime): ?string
    {
        if (blank($dateTime)) {
            return null;
        }

        return Carbon::parse($dateTime)->toIso8601String();
    }
}
