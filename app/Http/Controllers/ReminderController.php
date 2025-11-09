<?php

namespace App\Http\Controllers;

use App\Models\Reminder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReminderController extends Controller
{
    public function index()
    {
        $reminders = Auth::user()->reminders;
        return response()->json(['data' => $reminders], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'time' => 'required|date_format:H:i',
            'days' => 'required|array|size:7',
            'days.*' => 'in:0,1',
            'enabled' => 'boolean'
        ]);

        $reminder = Auth::user()->reminders()->create($request->all());

        return response()->json(['data' => $reminder], 201);
    }

    public function update(Request $request, Reminder $reminder)
    {
        $this->authorize('update', $reminder);

        $request->validate([
            'time' => 'sometimes|date_format:H:i',
            'days' => 'sometimes|array|size:7',
            'enabled' => 'sometimes|boolean'
        ]);

        $reminder->update($request->all());

        return response()->json(['data' => $reminder], 200);
    }

    public function destroy(Reminder $reminder)
    {
        $this->authorize('delete', $reminder);
        $reminder->delete();
        return response()->json(null, 204);
    }
}
