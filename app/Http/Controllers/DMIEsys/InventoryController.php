<?php

namespace App\Http\Controllers\DMIEsys;

use App\Imports\ExcelImport;
use App\Models\Inventory;
use App\Traits\Notify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use App\Http\Controllers\Controller;

class InventoryController extends Controller
{
    use Notify;

    public function index()
    {
        /* Checking if the user has the ability to add, see, edit, or delete inventory. */
        abort_unless(($this->canAny(['add inventory', 'see inventory', 'edit inventory', 'delete inventory'])), 404);
        /* Returning the view of the laboratories.inventory page. */
        return view('dmiesys.laboratories.inventory');
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function show(string $id)
    {
        /* Checking if the user has the permission to see inventory. */
        abort_unless(($this->can('see inventory')), 404);
        /* Finding the item in the inventory table where the item_code is equal to the id. */
        $item = Inventory::where('item_code', $id)->firstOrFail();
        /* Returning the view of the inventory item. */
        return view('dmiesys.laboratories.inventory-item', compact('item'));
    }

    public function store(Request $request)
    {
        abort_unless(($this->can('add inventory')), 404);

        /* Checking if the request type is equal to "add item to inventory" */
        if ($request->_type == "add item to inventory") {
            /* Validating the request. */
            Validator::make($request->all(), [
                'item_code' => 'required|string|max:50',
                'item_name' => 'required|string|max:50',
                'supplier_name' => 'required|string|max:100',
                'received_date' => 'required|date|before_or_equal:today|max:50',
                'indent_no' => 'nullable|string|max:100',
                'model' => 'nullable|string|max:50',
                'photo' => 'nullable|image|max:5000',
                'serial_number' => 'nullable|string|max:50',
                'properties' => 'required|string',
                'book_no' => 'required|integer',
                'folio_no' => 'required|integer',
                'value' => 'nullable|integer',
                'budget_allocation' => 'nullable|string|max:50',
                'location' => 'required|string|max:100',
                'remark' => 'nullable|string',
            ])->validate();

            /* Setting the variable  to null. */
            $photoname = null;

            /* Checking if the request has a file called photo. If it does, it will try to get the extension of the file, then it will create a random name for the file, then it will save the file to the storage folder. */
            if ($request->hasFile('photo')) {
                try {
                    $extention = $request->file('photo')->getClientOriginalExtension();
                    $photoname = md5(Str::random(20)) . '.' . $extention;
                    Image::make($request->file('photo'))->fit(800, 600)->save('storage/inventory-item-photos/' . $photoname);
                } catch (\Throwable $th) {
                    $this->failed($th);
                    return back()->withErrors('Something went wrong when uploading the image.');
                }
            }

            try {
                $item = new Inventory;
                $item->item_code = $request->item_code;
                $item->item_name = $request->item_name;
                $item->supplier_name = $request->supplier_name;
                $item->received_date = $request->received_date;
                $item->indent_no = $request->indent_no;
                $item->model = $request->model;
                $item->serial_number = $request->serial_number;
                $item->properties = $request->properties;
                $item->book_no = $request->book_no;
                $item->folio_no = $request->folio_no;
                $item->value = $request->value;
                $item->budget_allocation = $request->budget_allocation;
                $item->location = $request->location;
                $item->remark = $request->remark;
                $item->image_path = $photoname;
                $item->save();
                $this->passed($request->item_code . ' item added to the inventory');
                return back()->with('toast_success', 'Inventory item added successfully!');
            } catch (\Throwable $th) {
                $this->failed($th);
                return back()->withErrors('Something went wrong. Please check the data again.');
            }
        } elseif ($request->_type == "add items to inventory") {
            Validator::make($request->all(), [
                'inventory_item_list' => 'required|mimes:xlsx|max:5120',
            ])->validate();

            $file = $request->file('inventory_item_list');
            $items = Excel::toArray(new ExcelImport(), $file);
            $items = $items[0];

            //validation
            foreach ($items as $item) {
                Validator::make($item, [
                    'item_code' => 'required|string|max:50',
                    'item_name' => 'required|string|max:50',
                    'supplier_name' => 'required|string|max:100',
                    'received_date' => 'required|date|before_or_equal:today|max:50',
                    'indent_no' => 'nullable|string|max:100',
                    'model' => 'nullable|string|max:50',
                    'serial_number' => 'nullable|string|max:50',
                    'properties' => 'required|string',
                    'book_no' => 'required|integer',
                    'folio_no' => 'required|integer',
                    'value' => 'nullable|integer',
                    'budget_allocation' => 'nullable|string|max:50',
                    'location' => 'required|string|max:100',
                    'remark' => 'nullable|string',
                ])->validate();
            }

            $item_code_list = [];
            DB::beginTransaction();
            foreach ($items as $item) {
                try {
                    $inventory_item = new Inventory;
                    $inventory_item->item_code = $item['item_code'];
                    $inventory_item->item_name = $item['item_name'];
                    $inventory_item->supplier_name = $item['supplier_name'];
                    $inventory_item->received_date = $item['received_date'];
                    $inventory_item->indent_no = $item['indent_no'];
                    $inventory_item->model = $item['model'];
                    $inventory_item->serial_number = $item['serial_number'];
                    $inventory_item->properties = $item['properties'];
                    $inventory_item->book_no = $item['book_no'];
                    $inventory_item->folio_no = $item['folio_no'];
                    $inventory_item->value = $item['value'];
                    $inventory_item->budget_allocation = $item['budget_allocation'];
                    $inventory_item->location = $item['location'];
                    $inventory_item->remark = $item['remark'];
                    $inventory_item->save();
                    $this->passed($item['item_code'] . ' item added to the inventory');
                    array_push($item_code_list, $item['item_code']);
                } catch (\Throwable $th) {
                    DB::rollBack();
                    $this->failed($th);
                    return back()->withErrors('Something went wrong. Please check the data again.');
                }
            }
            DB::commit();
            return view('dmiesys.laboratories.inventory-qr-codes', compact('item_code_list'));
        }
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        abort_unless(($this->can('add inventory')), 404);
        return view('dmiesys.laboratories.add-item-to-inventory');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Inventory $inventory)
    {
        abort_unless(($this->can('delete inventory')), 404);

        try {
            $inventory->delete();
            $this->passed($inventory->item_code . ' Inventory Item was deleted');
            $this->notifyHOD('Inventory Item was deleted by ' . auth()->user()->name);
            return back()->with('toast_success', 'Item deleted successfully! <a class="font-semibold underline hover:text-green-800 dark:hover:text-green-900" href="' . route('inventory.restore', $inventory->id) . '">Undo</a>');
        } catch (\Throwable $th) {
            $this->failed($th);
            return back()->withErrors($th->getMessage());
        }
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore(int $id)
    {
        abort_unless(($this->can('delete inventory')), 404);
        $item = Inventory::withTrashed()->find($id);
        if ($item && $item->trashed()) {
            $item->restore();
        }
        $this->passed($item->item_code . ' Inventory Item was restored');
        return back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Inventory $inventory)
    {
        abort_unless(($this->can('edit inventory')), 404);

        if ($inventory->image_path) {
            try {
                if (File::exists(public_path('storage/inventory-item-photos/' . $inventory->image_path))) {
                    File::delete(public_path('storage/inventory-item-photos/' . $inventory->image_path));
                }
            } catch (\Throwable $th) {
                $this->failed($th);
                return back()->withErrors('Something went wrong when uploading the image.');
            }
        }

        Validator::make($request->all(), [
            'photo' => 'required|image|max:5000',
        ])->validate();

        try {
            $extention = $request->file('photo')->getClientOriginalExtension();
            $photoname = md5(Str::random(20)) . '.' . $extention;
            Image::make($request->file('photo'))->fit(800, 600)->save('storage/inventory-item-photos/' . $photoname);
        } catch (\Throwable $th) {
            $this->failed($th);
            return back()->withErrors('Something went wrong when uploading the image.');
        }

        try {
            $inventory->image_path = $photoname;
            $inventory->save();
            $this->passed($inventory->item_code . ' Inventory photo updated');
            return back()->with('toast_success', 'Image uploaded successfully!');
        } catch (\Throwable $th) {
            $this->failed($th);
            return back()->withErrors('Something went wrong when uploading the image.');
        }
    }

    /**
     * Delete the resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deletePhoto(int $id)
    {
        abort_unless(($this->can('edit inventory')), 404);

        $inventory = Inventory::where('id', $id)->firstOrFail();

        if ($inventory->image_path) {
            try {
                if (File::exists(config('settings.system.path') . 'storage/inventory-item-photos/' . $inventory->image_path)) {
                    File::delete(config('settings.system.path') . 'storage/inventory-item-photos/' . $inventory->image_path);
                }
                $inventory->image_path = NULL;
                $inventory->save();
                $this->passed($inventory->item_code . ' Inventory item photo deleted!');
                return back()->with('toast_success', 'Image deleted successfully!');
            } catch (\Throwable $th) {
                $this->failed($th);
                return back()->withErrors('Something went wrong when uploading the image.');
            }
        }
        return back()->withErrors('Something went wrong when uploading the image.');
    }
}
