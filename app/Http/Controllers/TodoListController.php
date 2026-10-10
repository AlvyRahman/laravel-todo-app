<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ListItem;

class TodoListController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status', 'all');

        $listItems = ListItem::query()
            ->when($search, fn ($query, $search) => $query->where('name', 'like', '%' . $search . '%'))
            ->when($status === 'active', fn ($query) => $query->where('is_complete', 0))
            ->when($status === 'done', fn ($query) => $query->where('is_complete', 1))
            ->get();

        return view('welcome', [
            "listItems" => $listItems,
            "search" => $search,
            "status" => $status
        ]);
    }

    public function saveItem(Request $request)
    {
        $newListItem = new ListItem;
        $newListItem->name = $request->listItem;
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

    /*
    public function editItem($id)
    {
        // \Log::info($id);
        
     
        return redirect()->back();
    } 
    */

    public function remove($id)
    {
        // \Log::info($id);
        
        $newListItem = ListItem::find($id);
        $newListItem->delete();

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
