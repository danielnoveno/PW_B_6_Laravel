<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use Illuminate\Http\Request;

class BookmarkController extends Controller
{
    /**
     * Display a listing of the bookmarks.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bookmarks = Bookmark::all(); // Fetch all bookmarks
        return response()->json($bookmarks);
    }

    /**
     * Store a newly created bookmark in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the input
        $request->validate([
            'user_id' => 'required|exists:user,id',
            'buku_id' => 'required|exists:buku,id',
        ]);

        // Create a new bookmark
        $bookmark = Bookmark::create($request->all());

        return response()->json([
            'message' => 'Bookmark created successfully',
            'bookmark' => $bookmark,
        ], 201);
    }

    /**
     * Display the specified bookmark.
     *
     * @param  \App\Models\Bookmark  $bookmark
     * @return \Illuminate\Http\Response
     */
    public function show(Bookmark $bookmark)
    {
        return response()->json($bookmark);
    }

    /**
     * Update the specified bookmark in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Bookmark  $bookmark
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bookmark $bookmark)
    {
        // Validate the input
        $request->validate([
            'user_id' => 'required|exists:user,id',
            'buku_id' => 'required|exists:buku,id',
        ]);

        // Update the bookmark
        $bookmark->update($request->all());

        return response()->json([
            'message' => 'Bookmark updated successfully',
            'bookmark' => $bookmark,
        ]);
    }

    /**
     * Remove the specified bookmark from storage.
     *
     * @param  \App\Models\Bookmark  $bookmark
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bookmark $bookmark)
    {
        $bookmark->delete();

        return response()->json([
            'message' => 'Bookmark deleted successfully',
        ]);
    }
}
