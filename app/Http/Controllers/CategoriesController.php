<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class CategoriesController extends Controller
{
    public function index()
    {
        return view('categories.index.index');
    }

    public function search(Request $request)
    {
        $kode = $request->kode;
        $nama = $request->nama;

        $query = Category::query();

        if (!empty($kode)) {
            $query->where('kode', 'LIKE', '%' . $kode . '%');
        }
        if (!empty($nama)) {
            $query->where('nama', 'LIKE', '%' . $nama . '%');
        }

        $data_search = $query->withCount('masterItems')->orderBy('id', 'desc')->get();

        return response()->json([
            'status' => 200,
            'data' => $data_search
        ]);
    }

    public function formView($method, $id = 0)
    {
        if ($method == 'new') {
            $category = new Category();
        } else {
            $category = Category::findOrFail($id);
        }

        $data['category'] = $category;
        $data['method'] = $method;

        return view('categories.form.index', $data);
    }

    public function formSubmit(Request $request, $method, $id = 0)
    {
        if ($method == 'new') {
            $category = new Category();
            $request->validate([
                'kode' => 'required|unique:categories,kode',
                'nama' => 'required',
            ]);
        } else {
            $category = Category::findOrFail($id);
            $request->validate([
                'kode' => 'required|unique:categories,kode,' . $id,
                'nama' => 'required',
            ]);
        }

        $category->kode = $request->kode;
        $category->nama = $request->nama;
        $category->save();

        return redirect('categories');
    }

    public function singleView($id)
    {
        $data['category'] = Category::with('masterItems')->findOrFail($id);
        return view('categories.single.index', $data);
    }

    public function delete($id)
    {
        Category::findOrFail($id)->delete();
        return redirect('categories');
    }

    public function downloadPdf($id)
    {
        $category = Category::with('masterItems')->findOrFail($id);
        $printed_at = now()->format('d-m-Y H:i:s');

        $pdf = Pdf::loadView('categories.single.pdf', compact('category', 'printed_at'));
        return $pdf->download('kategori-' . $category->kode . '.pdf');
    }
}
