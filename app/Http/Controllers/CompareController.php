<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CompareController extends Controller
{
    public function compare(Request $request): View
    {
        $validated = $request->validate([
            'destination_ids' => ['required', 'array', 'size:2'],
            'destination_ids.*' => ['required', 'integer', 'distinct', Rule::exists('destinations', 'id')],
            'month' => ['required', 'integer', 'between:1,12'],
        ], [
            'destination_ids.required' => 'Na porovnanie vyberte presne dve destinácie.',
            'destination_ids.array' => 'Na porovnanie vyberte presne dve destinácie.',
            'destination_ids.size' => 'Na porovnanie je možné vybrať presne dve destinácie.',
            'destination_ids.*.distinct' => 'Každá destinácia môže byť v porovnaní iba raz.',
        ]);

        $ids = array_map('intval', $validated['destination_ids']);

        $destinations = Destination::query()
            ->with(['country', 'types', 'monthlyWeather'])
            ->whereIn('id', $ids)
            ->get()
            ->sortBy(fn (Destination $destination): int => array_search($destination->id, $ids, true))
            ->values();

        return view('compare.result', [
            'destinations' => $destinations,
            'month' => (int) $validated['month'],
        ]);
    }
}
