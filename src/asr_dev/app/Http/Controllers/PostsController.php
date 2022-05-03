<?php

namespace App\Http\Controllers;

use App\Models\Posts;
use App\Models\Tags;
use App\Models\TagsPosts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        /*$data = [
            'titulo' => 'Vacuna Covid',
            'tags' => array(
                [
                    'titulo' => '#Vacuna',
                ],
                [
                    'titulo' => '#Vacuna2'
                ]
            )
        ];

        return json_encode($data);*/

        try {
            $posts = Posts::all();
            foreach ($posts as $post) {
                $post->tagsPivot;
            }
            //$posts = Posts::with('tags');
        } catch (\Exception $e) {
            return response()->json(['error' => 'Problemas al procesar la solicitud'], 500);
        }
        return response()->json(compact('posts'), 200);
        //return response()->json(['posts' => $posts], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $flag = true;
            $flag2 = true;
            $flag3 = true;

            $model = new Posts();
            $model->titulo = $request->input('titulo');

            if (!$model->save()) {
                $flag = false;
            }

            $tags = $request->input('tags');
            if (count($tags) > 0) {
                foreach ($tags as $tag) {
                    $tag_exist = Tags::where('titulo', $tag['titulo'])->first();
                    if ($tag_exist) {
                        $id_tag = $tag_exist->id_tag;
                    } else {
                        $modelTag = new Tags();
                        $modelTag->titulo = $tag['titulo'];
                        if ($modelTag->save()) {
                            $id_tag = $modelTag->id_tag;
                        } else {
                            $flag2 = false;
                        }
                    }
                    //se asocia a relacion
                    $modelTagPost = new TagsPosts();
                    $modelTagPost->id_tag = $id_tag;
                    $modelTagPost->id_post = $model->id_post;
                    if (!$modelTagPost->save()) {
                        $flag3 = false;
                    }
                }
            }

            if (!$flag && !$flag2 && !$flag3) {
                DB::rollBack();
                return response()->json(['error' => 'No se agrego el post'], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Problemas al procesar la solicitud'], 500);
        }

        DB::commit();
        return response()->json(['success' => 'El post se creo correctamente'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        try {
            $posts = Posts::where('id_post', $id)->with('tagsPivot')->first();
        } catch (\Exception $e) {
            return response()->json(['error' => 'Problemas al procesar la solicitud'], 500);
        }
        return response()->json(['posts' => $posts], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

    }
}
