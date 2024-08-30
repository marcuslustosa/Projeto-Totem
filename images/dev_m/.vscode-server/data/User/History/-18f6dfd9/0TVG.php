<?php

namespace App\Http\Controllers;

use App\Models\PostCategory;
use App\Models\Template;
use Carbon\Carbon;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Response;

use function PHPUnit\Framework\isNull;

class PostGalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $title = "Posts";
        $type = 0;
        if ($request->has('type')) {
            $type = $request->type;
            if ($request->type == 0) {
                $title = "Imagens para Feed_";
            } else {
                $title = "Imagens para Story";
            }

            $templates = Template::where('type', $request->type);
            /*if ($request->has('cat')) {
                $category_ids = collect(explode(',', $request->cat))
                ->map(fn($i) => trim($i))
                ->all();

                $templates->whereHas('category', fn($query) =>
                    $query->whereIn('post_categories.id', $category_ids)

                );

            }*/

            if ($request->has('categories')) {
                $category_ids = $request->get('categories');

                $templates->whereHas(
                    'category',
                    fn ($query) =>
                    $query->whereIn('post_categories.id', $category_ids)

                );
            }



            $templates = $templates->orderBy('updated_at', 'desc')->paginate(24);
        } else {
            $templates = Template::orderBy('updated_at', 'desc')->paginate(24);
        }

        $categories = PostCategory::all();
        return view('post-gallery.list', compact('templates', 'title', 'categories', 'type'));
    }


    public function postByType(Request $request, string $type)
    {

        $key = array_search($type, array_column(postType(), 'slug'));
        if ($key === false) dd('Não!', $key);

        $postType = postType()[$key];
        $postTypeID = $postType['id'];


        $templates = Template::where('type', $postTypeID)->orderBy('updated_at', 'desc')->paginate(24);
        if (ucfirst($type) == 'Reels') $title = "Vídeos para Reels";
        else $title = "Imagens para " . ucfirst($type);

        $categories = PostCategory::all();
        $type = 0;
        return view('post-gallery.list', compact('templates', 'title', 'categories', 'type'));
    }

    public function filter(Request $request)
    {

        $title = "Posts";
        $type = 0;
        if ($request->has('type')) {
            $type = $request->type;
            if ($request->type == 0) {
                $title = "Imagens para Feed*";
            } else {
                $title = "wefadfadfadfasdas";
            }

            $templates = Template::where('type', $request->type);
            /*if ($request->has('cat')) {
                $category_ids = collect(explode(',', $request->cat))
                ->map(fn($i) => trim($i))
                ->all();

                $templates->whereHas('category', fn($query) =>
                    $query->whereIn('post_categories.id', $category_ids)

                );

            }*/

            if ($request->has('categories')) {
                $category_ids = $request->get('categories');

                $templates->whereHas(
                    'category',
                    fn ($query) =>
                    $query->whereIn('post_categories.id', $category_ids)

                );
            }

            $templates = $templates->orderBy('updated_at', 'desc')->paginate(10);
        } else {
            $templates = Template::orderBy('updated_at', 'desc')->paginate(10);
        }

        return response()->json($templates);
    }

    public function create()
    {
        //return view('post-gallery.list',compact('templates'));
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

        ]);
        $data = $request->all();

        if ($request->file('image')) {
            $file = $request->file('image');
            $filename = date('YmdHi') . random_int(1, 999) . $file->getClientOriginalName();
            $file->move(public_path('templates'), $filename);
            $data['image'] = $filename;
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

        return view('templates.edit', compact('template'));
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
            $filename = date('YmdHi') . random_int(1, 999) . $file->getClientOriginalName();
            $file->move(public_path('templates'), $filename);
            $data['image'] = $filename;
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

    public function saveImage(Request $request)
    {

        $file_url = '';
        try {
            $filename = '';
            $img = $request->image;
            $img = str_replace('data:image/png;base64,', '', $img);
            $img = str_replace(' ', '+', $img);
            $fileData = base64_decode($img);
            $date = new DateTime();
            //saving
            $fileName = 'e' . $request->userId . 'p' . $filename . $date->getTimestamp() . '.jpg';
            //file_put_contents('created_posts/'.$request->userId.'/'.$fileName, $fileData);
            Storage::disk('digitalocean')->put('familia-metalife/created_posts/' . $request->userId . '/' . $fileName, $fileData, 'public');
        } catch (Exception $e) {
            return $e->getMessage();
        }


        return 'https://cdn.metalife.com.br/familia-metalife/created_posts/' . $request->userId . '/' . $fileName;
    }
}
