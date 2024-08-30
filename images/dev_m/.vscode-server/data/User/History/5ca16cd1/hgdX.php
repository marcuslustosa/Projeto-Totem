<?php

namespace App\Http\Controllers;

use App\Models\PostCategory;
use App\Models\Template;
use Illuminate\Http\Request;
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
    public function index()
    {
        $templates = Template::orderBy('updated_at', 'desc')->get();
        return view('templates.index', compact('templates'));
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
    public function createThumbnail($local_path, $s3_path, $width, $height)
    {
        // configure with favored image driver (gd by default)
        Image::configure(['driver' => 'imagick']);
        
        $thumb = Image::make($local_path)->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
        });
        //$img->save($path);
        Storage::disk('s3')->put($s3_path, file_get_contents($thumb, 'public'));
        Storage::setVisibility($s3_path, 'public');
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

            ///CRIAR THUMBS/////////////////////
            $smallthumbnail = 'small_' .$filename;
            $mediumthumbnail = 'medium_' .$filename;
            //Upload local File
            $request->file('image')->storeAs("templates/images/", $filename, "public");
            // $request->file('profile_image')->storeAs($path, $smallthumbnail);
            // $request->file('profile_image')->storeAs($path, $mediumthumbnail);            
            
            //$local_image = public_path($local_path.$filename);
                       
            //$this->createThumbnail($local_image,$path.$smallthumbnail, 150, null);                   
            //$this->createThumbnail($local_image,$path.$mediumthumbnail, 300, null);

            /////////// SALVAR ORIGINAL//////////////
            $path = 'public/templates/images/';
            $local_path = 'storage/templates/images/';
            Storage::disk('s3')->put($path . $filename, file_get_contents($request->image, 'public'));
            Storage::setVisibility($path . $filename, 'public');
            $data['image'] = $path . $filename;
            
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
            $uuid = Str::uuid();
            $filename = $uuid . '.' . $extension;  

            ///CRIAR THUMBS/////////////////////
            $smallthumbnail = 'small_' .$filename;
            $mediumthumbnail = 'medium_' .$filename;
            //Upload local File
            $request->file('image')->storeAs("templates/images/", $filename, "public");
            // $request->file('profile_image')->storeAs($path, $smallthumbnail);
            // $request->file('profile_image')->storeAs($path, $mediumthumbnail);            
            
            //$local_image = public_path($local_path.$filename);
                       
            //$this->createThumbnail($local_image,$path.$smallthumbnail, 150, null);                   
            //$this->createThumbnail($local_image,$path.$mediumthumbnail, 300, null);

            /////////// SALVAR ORIGINAL//////////////
            $path = 'public/templates/images/';
            $local_path = 'storage/templates/images/';
            Storage::disk('s3')->put($path . $filename, file_get_contents($request->image, 'public'));
            Storage::setVisibility($path . $filename, 'public');
            $data['image'] = $path . $filename;
        } else {
            $data = $request->except('_token', '_method', 'image');
        }

        Template::whereId($id)->update($data);
        //notify()->success($request->name.' atualizado com sucesso!','');
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
