<?php

namespace App\Http\Controllers;

use App\Http\Requests\ListItemRequest;
use App\Models\ListItem;
use Illuminate\Http\Request;

class TodoListController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status', 'all');

        $listItems = ListItem::query()
            ->when($search, fn ($query, $search) => $query->where('name', 'like', '%'.$search.'%'))
            ->when($status === 'active', fn ($query) => $query->where('is_complete', 0))
            ->when($status === 'done', fn ($query) => $query->where('is_complete', 1))
            ->get();

        return view('welcome', [
            'listItems' => $listItems,
            'search' => $search,
            'status' => $status,
        ]);
    }

    public function saveItem(ListItemRequest $request)
    {
        $newListItem = new ListItem;
        $newListItem->name = $request->validated('listItem');
        $newListItem->is_complete = 0;
        $newListItem->save();

        // \Log::info(json_encode($request->all()));
        //return view('welcome', ["listItems" => ListItem::all()]);
        return redirect()->back();
    }

    public function complete($id)
    {
        // \Log::info($id);

        $newListItem = ListItem::find($id);
        $newListItem->is_complete = 1;
        $newListItem->save();

        return redirect()->back();
    }

    public function incomplete($id)
    {
        $listItem = ListItem::find($id);
        $listItem->is_complete = 0;
        $listItem->save();

        return redirect()->back();
    }

    public function edit(ListItemRequest $request, $id)
    {
        $listItem = ListItem::findOrFail($id);
        $listItem->name = $request->validated('listItem');
        $listItem->save();

        return redirect()->back();
    }

    public function remove($id)
    {
        $listItem = ListItem::findOrFail($id);
        $listItem->delete();

        return redirect()->back()->with('undo', [
            'id' => $listItem->id,
            'name' => $listItem->name,
        ]);
    }

    public function restore($id)
    {
        ListItem::onlyTrashed()->findOrFail($id)->restore();

        return redirect()->back();
    }

    public function markAllComplete()
    {
        ListItem::where('is_complete', 0)->update(['is_complete' => 1]);

        return redirect()->back();
    }

    public function markAllIncomplete()
    {
        ListItem::where('is_complete', 1)->update(['is_complete' => 0]);

        return redirect()->back();
    }
}
