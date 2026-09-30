<?php

namespace App\Http\Controllers;

use App\Models\MasterItem;
use App\Models\Category;
use App\Exports\MasterItemsExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class MasterItemsController extends Controller
{
    public function index()
    {
        return view('master_items.index.index');
    }

    public function search(Request $request)
    {
        $kode = $request->kode;
        $nama = $request->nama;
        $hargamin = $request->hargamin;
        $hargamax = $request->hargamax;

        $data_search = MasterItem::with('categories');

        if (!empty($kode)) {
            $data_search->where('kode', 'LIKE', '%' . $kode . '%');
        }
        if (!empty($nama)) {
            $data_search->where('nama', 'LIKE', '%' . $nama . '%');
        }
        
        // FIX BUG: filter harga min dan harga max dipisah dan dipastikan valid
        if ($hargamin !== null && $hargamin !== '') {
            $data_search->where('harga_beli', '>=', $hargamin);
        }
        if ($hargamax !== null && $hargamax !== '') {
            $data_search->where('harga_beli', '<=', $hargamax);
        }

        $items = $data_search->orderBy('id', 'desc')->get();

        $formatted_data = $items->map(function ($item) {
            return [
                'kode' => $item->kode,
                'nama' => $item->nama,
                'jenis' => $item->jenis,
                'harga_beli' => $item->harga_beli,
                'laba' => $item->laba,
                'supplier' => $item->supplier,
                'foto' => $item->foto ? asset('storage/' . $item->foto) : null,
                'categories' => $item->categories->pluck('nama')->implode(', '),
            ];
        });

        return response()->json([
            'status' => 200,
            'data' => $formatted_data
        ]);
    }

    public function formView($method, $id = 0)
    {
        if ($method == 'new') {
            $item = new MasterItem();
            $selectedCategories = [];
        } else {
            $item = MasterItem::with('categories')->findOrFail($id);
            $selectedCategories = $item->categories->pluck('id')->toArray();
        }

        $categories = Category::orderBy('nama')->get();

        $data['item'] = $item;
        $data['method'] = $method;
        $data['categories'] = $categories;
        $data['selectedCategories'] = $selectedCategories;

        return view('master_items.form.index', $data);
    }

    public function singleView($kode)
    {
        $data['data'] = MasterItem::with('categories')->where('kode', $kode)->firstOrFail();
        return view('master_items.single.index', $data);
    }

    public function formSubmit(Request $request, $method, $id = 0)
    {
        if ($method == 'new') {
            $data_item = new MasterItem();
            $lastItem = MasterItem::orderBy('id', 'desc')->first();
            $nextId = $lastItem ? $lastItem->id + 1 : 1;
            $kode = str_pad($nextId, 5, '0', STR_PAD_LEFT);
        } else {
            $data_item = MasterItem::findOrFail($id);
            $kode = $data_item->kode;
        }

        if ($request->hasFile('foto')) {
            $request->validate([
                'foto' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $fotoPath = $request->file('foto')->store('items', 'public');
            $data_item->foto = $fotoPath;
        }

        $data_item->nama = $request->nama;
        $data_item->harga_beli = $request->harga_beli;
        $data_item->laba = $request->laba;
        $data_item->kode = $kode;
        $data_item->supplier = $request->supplier;
        $data_item->jenis = $request->jenis;
        $data_item->save();

        if ($request->has('categories')) {
            $data_item->categories()->sync($request->categories);
        } else {
            $data_item->categories()->detach();
        }

        return redirect('master-items');
    }

    public function delete($id)
    {
        MasterItem::findOrFail($id)->delete();
        return redirect('master-items');
    }

    public function exportExcel()
    {
        return Excel::download(new MasterItemsExport(), 'master-items.xlsx');
    }

    public function updateRandomData()
    {
        $data = MasterItem::get();
        foreach($data as $item)
        {
            $kode = $item->id;
            $kode = str_pad($kode, 5, '0', STR_PAD_LEFT);

            $item->harga_beli = rand(100,1000000);
            $item->laba = rand(10,99);
            $item->kode = $kode;
            $item->supplier = $this->getRandomSupplier();
            $item->jenis = $this->getRandomJenis();
            $item->save();
        }
        return redirect('master-items');
    }

    private function getRandomSupplier()
    {
        $array = ['Tokopaedi','Bukulapuk','TokoBagas','E Commurz','Blublu'];
        $random = rand(0,4);
        return $array[$random];
    }

    private function getRandomJenis()
    {
        $array = ['Obat','Alkes','Matkes','Umum','ATK'];
        $random = rand(0,4);
        return $array[$random];
    }
}
