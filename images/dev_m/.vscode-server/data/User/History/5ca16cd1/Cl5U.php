<?php

namespace App\Http\Controllers;

use App\Models\PostCategory;
use App\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Response;
use Image;

class TemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        // $templates = null;


        // if (isset($request->deleteCache)) Cache::forget("templates-list");

        // if (Cache::has("templates-list")) $templates = Cache::get("templates-list");

        // if (!$templates) {
        //     $templates = Template::orderBy('created_at', 'desc')->get();
        // }

        // $templates
        // dd($templates->range(0, 10));
        $templates = Template::orderBy('created_at', 'desc')->get();
        return view('templates.index', ['templates' => $templates]);
    }


    public function create()
    {
        $categories = PostCategory::orderBy('name')->get();
        return view('templates.create', compact('categories'));
    }

    /**
     * Create a thumbnail of specified size
     *
     * @param string $path path of thumbnail
     * @param int $width
     * @param int $height
     */
    public function saveImageAndThumbs($file, $filename, $s3_path)
    {
        ///CRIAR THUMB PEQUENO E SUBIR no S3/////////////////////
        $smallthumbnail = 'small_' . $filename;

        $thumb = Image::make($file)->resize(150, null, function ($constraint) {
            $constraint->aspectRatio();
        });

        $thumb = $thumb->stream();

        Storage::disk('s3')->put($s3_path . $smallthumbnail, $thumb->__toString());
        Storage::setVisibility($s3_path . $smallthumbnail, 'public');

        ///CRIAR THUMB MEDIO E SUBIR NO S3/////////////////////
        $mediumthumbnail = 'medium_' . $filename;
        $thumb = Image::make($file)->resize(300, null, function ($constraint) {
            $constraint->aspectRatio();
        });

        $thumb = $thumb->stream();

        Storage::disk('s3')->put($s3_path . $mediumthumbnail, $thumb->__toString());
        Storage::setVisibility($s3_path . $mediumthumbnail, 'public');

        /////////// SALVAR ORIGINAL//////////////

        Storage::disk('s3')->put($s3_path . $filename, file_get_contents($file));
        Storage::setVisibility($s3_path . $filename, 'public');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:templates|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',

        ]);
        $data = $request->all();

        if ($request->file('image')) {
            $file = $request->file('image');
            //get file extension
            $extension = $file->getClientOriginalExtension();
            $uuid = Str::uuid();
            $filename = $uuid . '.' . $extension;
            $s3_path = 'public/templates/images/';
            $this->saveImageAndThumbs($file, $filename, $s3_path);

            $data['image'] = $s3_path . $filename;
            $data['small_thumb'] = $s3_path . "small_" . $filename;
            $data['medium_thumb'] = $s3_path . "medium_" . $filename;
        }

        if ($request->file('video')) {
            $file = $request->file('video');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $path = 'public/templates/videos/';
            Storage::disk('s3')->put($path . $filename, file_get_contents($request->video, 'public'));
            Storage::setVisibility($path . $filename, 'public');
            $data['video'] = $path . $filename;
        }

        $show = Template::create($data);
        //notify()->success($request->name.' cadastrado com sucesso!','');

        Cache::rememberForever("templates-list", function () {
            return Template::orderBy('created_at', 'desc')->get();
        });


        return redirect('post-templates')->with('success', $request->name . ' salvo com sucesso!');
        //return back()->with('success', $request->name.' salvo com sucesso!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $template = Template::findOrFail($id);
        $categories = PostCategory::orderBy('name')->get();
        return view('templates.edit', compact('template', 'categories'));
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:255'
        ]);


        if ($request->file('image')) {
            $data = $request->except('_token', '_method');
            $file = $request->file('image');
            //get file extension
            $extension = $file->getClientOriginalExtension();
            // $uuid = Str::uuid();
            $filename = $id . '.' . $extension;
            $s3_path = 'public/templates/images/';
            $this->saveImageAndThumbs($file, $filename, $s3_path);

            $data['image'] = $s3_path . $filename;
            $data['small_thumb'] = $s3_path . "small_" . $filename;
            $data['medium_thumb'] = $s3_path . "medium_" . $filename;
        } else {
            $data = $request->except('_token', '_method', 'image');
        }

        Template::whereId($id)->update($data);
        //notify()->success($request->name.' atualizado com sucesso!','');

        Cache::rememberForever("templates-list", function () {
            return Template::orderBy('created_at', 'desc')->get();
        });

        return redirect('post-templates')->with('success', $request->name . ' atualizado com sucesso!');
        //return back()->with('success', $request->name.' atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Template::whereId($id)->delete();
        //notify()->success($request->name.' excluído com sucesso!','');
        return redirect('post-templates')->with('success', 'Template excluído com sucesso!');
    }
}
