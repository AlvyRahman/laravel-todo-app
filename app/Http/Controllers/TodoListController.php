<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ListItem;

class TodoListController extends Controller
{
    public function index()
    {
        return view('welcome', ["listItems" => ListItem::where('is_complete', 0)->get()]);
    }

    public function saveItem(Request $request)
    {
        $newListItem = new ListItem;
        $newListItem->name = $request->listItem;
        $newListItem->is_complete = 0;
        $newListItem->save();
        
        // \Log::info(json_encode($request->all()));
        //return view('welcome', ["listItems" => ListItem::all()]);
        return redirect('/');
    }

    public function complete($id)
    {
        // \Log::info($id);
        
        $newListItem = ListItem::find($id);
        $newListItem->is_complete = 1;
        $newListItem->save();

        return redirect('/');
    }

    /*
    public function editItem($id)
    {
        // \Log::info($id);
        
     
        return redirect('/');
    } 
    */

    public function remove($id)
    {
        // \Log::info($id);
        
        $newListItem = ListItem::find($id);
        $newListItem->delete();

        return redirect('/');
    }

    public function markAllComplete()
    {
        ListItem::where('is_complete', 0)->update(['is_complete' => 1]);

        return redirect('/');
    }

    public function markAllIncomplete()
    {   
        ListItem::where('is_complete', 1)->update(['is_complete' => 0]);

        return redirect('/');
    }
}
