<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChannelProgram;

class ChannelProgramController extends Controller
{
    /**
     * Display a listing of the channel programs.
     */
    public function index(Request $request)
    {
        $query = ChannelProgram::query();

        // Simple search by program name or status
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('program_name', 'like', "%{$search}%")
                  ->orWhere('status', 'like', "%{$search}%");
        }

        $channelPrograms = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('channel_programs.index', compact('channelPrograms'));
    }

    /**
     * Show the form for creating a new channel program.
     */
    public function create()
    {
        return view('channel_programs.create');
    }

    /**
     * Store a newly created channel program.
     */
    public function store(Request $request)
    {
        $request->validate([
            'program_name' => 'required|string|max:255|unique:channel_programs,program_name',
            'description'  => 'nullable|string',
            'status'       => 'required|string|max:50',
            'start_date'   => 'nullable|date',
            'end_date'     => 'nullable|date',
        ]);

        ChannelProgram::create($request->all());

        return redirect()->route('channel_programs.index')->with('success', 'Channel Program created successfully.');
    }

    /**
     * Display the specified channel program.
     */
    public function show($id)
    {
        $channelProgram = ChannelProgram::findOrFail($id);
        return view('channel_programs.show', compact('channelProgram'));
    }

    /**
     * Show the form for editing the specified channel program.
     */
    public function edit($id)
    {
        $channelProgram = ChannelProgram::findOrFail($id);
        return view('channel_programs.edit', compact('channelProgram'));
    }

    /**
     * Update the specified channel program.
     */
    public function update(Request $request, $id)
    {
        $channelProgram = ChannelProgram::findOrFail($id);
        $request->validate([
            'program_name' => 'required|string|max:255|unique:channel_programs,program_name,' . $channelProgram->id,
            'description'  => 'nullable|string',
            'status'       => 'required|string|max:50',
            'start_date'   => 'nullable|date',
            'end_date'     => 'nullable|date',
        ]);

        $channelProgram->update($request->all());

        return redirect()->route('channel_programs.index')->with('success', 'Channel Program updated successfully.');
    }

    /**
     * Remove the specified channel program.
     */
    public function destroy($id)
    {
        $channelProgram = ChannelProgram::findOrFail($id);
        $channelProgram->delete();

        return redirect()->route('channel_programs.index')->with('success', 'Channel Program deleted successfully.');
    }
}
