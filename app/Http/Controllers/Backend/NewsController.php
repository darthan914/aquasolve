<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\News;
use DB;
use File;
use Illuminate\Http\Request;
use Image;
use Validator;

class NewsController extends Controller
{
    public function index()
    {
        $News = News::get();

        return view('backend.news.index', compact('News'));
    }

    public function add()
    {
        return view('backend.news.add');
    }

    public function store(request $request)
    {
        $message = [
            'name.unique'        => 'Sudah pernah digunakan',
            'name.required'      => 'This Field Required',
            'name.max'           => 'Max Character 35',
            'descript.required'  => 'This Field Required',
            'picture.required'   => 'This Field Required',
            'picture.dimensions' => 'Maximum Resolution 1366px x 1366px',
            'picture.image'      => 'Invalid Format, Image file only',
            'picture.max'        => 'File too large',
        ];

        $validator = Validator::make($request->all(), [
            'name'     => 'required|max:35|unique:amd_news',
            'descript' => 'required',
            'picture'  => 'required|image|mimes:jpeg,bmp,png|max:2000|dimensions:max_width=1366,max_height=1366',
        ], $message);

        if ($validator->fails()) {
            return redirect()->route('backend.news.add')->withErrors($validator)->withInput()->with('info-form-add', true);
        }

        DB::transaction(function () use ($request) {
            $salt    = str_random(4);
            $image   = $request->file('picture');
            $img_url = str_slug($request->name, '-') . '-' . $salt . '.' . $image->getClientOriginalExtension();
            $upload1 = Image::make($image);
            $upload1->save('amadeo/images/' . $img_url);

            $save           = new News;
            $save->name     = $request->name;
            $save->slug     = str_slug($request->name, '-');
            $save->descript = $request->descript;
            $save->picture  = $img_url;

            $save->meta_title       = $request->meta_title;
            $save->meta_url         = $request->meta_url;
            $save->meta_keywords    = $request->meta_keywords;
            $save->meta_description = $request->meta_description;
            if ($request->hasFile('meta_image')) {

                $pathSource = 'amadeo/images/news/meta/';
                $image      = $request->file('meta_image');
                $filename   = time() . '-' . $image->getClientOriginalName();
                if ($image->move($pathSource, $filename)) {
                    $save->meta_image = $pathSource . $filename;
                }
            }

            $save->save();
        });

        return redirect()->route('backend.news')->with('berhasil', 'Data Has Been Added ' . $request->name);
    }

    public function change($id)
    {
        $News = News::find($id);

        return view('backend.news.change', compact('News'));
    }

    public function changeStore(request $request, $id)
    {
        $message = [
            'name.required'      => 'This Field Required',
            'name.max'           => 'Terlalu Panjang, Maks 25 Karakter',
            'name.unique'        => 'Produk ini sudah ada',
            'descript.required'  => 'This Field Required',
            'picture.dimensions' => 'Maximum Resolution 1366px x 1366px',
            'picture.image'      => 'Invalid Format, Image file only',
            'picture.max'        => 'File too large',
        ];

        $validator = Validator::make($request->all(), [
            'name'     => 'required|max:35',
            'descript' => 'required',
            'picture'  => 'nullable|image|mimes:jpeg,bmp,png|max:2000|dimensions:max_width=1366,max_height=1366',
        ], $message);

        if ($validator->fails()) {
            return redirect()->route('backend.news.store.change', ['id' => $id])->withErrors($validator)->withInput()->with('info-form-change', true);
        }

        DB::transaction(function () use ($request) {
            $save = News::find($request->id);

            if ($request->has('picture')) {
                File::delete('amadeo/images/' . $save->picture);
                $salt    = str_random(4);
                $image   = $request->file('picture');
                $img_url = str_slug($request->name, '-') . '-' . $salt . '.' . $image->getClientOriginalExtension();
                $upload1 = Image::make($image);
                $upload1->save('amadeo/images/' . $img_url);
                $save->picture = $img_url;
            }

            $save->name     = $request->name;
            $save->slug     = str_slug($request->name, '-');
            $save->descript = $request->descript;

            $save->meta_title       = $request->meta_title;
            $save->meta_url         = $request->meta_url;
            $save->meta_keywords    = $request->meta_keywords;
            $save->meta_description = $request->meta_description;
            if (isset($request->remove_meta_image)) {
                if ($save->meta_image != '') {
                    File::delete($save->meta_image);
                    $save->meta_image = '';
                }
            } else {
                if ($request->hasFile('meta_image')) {

                    $pathSource = 'amadeo/images/news/meta/';
                    $image      = $request->file('meta_image');
                    $filename   = time() . '-' . $image->getClientOriginalName();
                    if ($image->move($pathSource, $filename)) {
                        if ($save->meta_image != '') {
                            File::delete($update->meta_image);
                        }
                        $save->meta_image = $pathSource . $filename;
                    }
                }
            }
            $save->save();
        });

        return redirect()->route('backend.news')->with('berhasil', 'Data Has Been Updated ' . $request->name);
    }

    public function flagPublish($id)
    {
        $News = News::find($id);
        if ($News->flug_publish == 'N') {
            $News->flug_publish = 'Y';
        } else if ($News->flug_publish == 'Y') {
            $News->flug_publish = 'N';
        }
        $News->save();
        return redirect()->route('backend.news')->with('berhasil', 'Data Has Been Updated ' . $News->name);
    }

    public function delete($id)
    {
        $News = News::find($id);

        DB::transaction(function () use ($News) {
            File::delete('amadeo/images/' . $News->picture);
            $News->delete();
        });

        return redirect()->route('backend.news')->with('berhasil', 'Data Has Been Deleted ' . $News->name);
    }

    public function preview($id)
    {
        $News = News::find($id);
        if ($News == null) {
            return view('errors.404');
        }

        $NewsHot = News::where('flug_publish', 'Y')->orderBy('id', 'desc')->limit(7)->get();

        return view('frontend.news-page.view', compact(
            'News',
            'NewsHot'
        ));
    }
}
