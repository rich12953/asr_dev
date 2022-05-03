<?php

namespace App\Http\Controllers;

use App\Models\Posts;
use App\Models\Tags;
use App\Models\TagsPosts;
use App\Models\TagsVideos;
use App\Models\Videos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VideosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $videos = Videos::all();
            foreach ($videos as $video) {
                $video->tagsPivot;
            }
            //$posts = Posts::with('tags');
        } catch (\Exception $e) {
            return response()->json(['error' => 'Problemas al procesar la solicitud'], 500);
        }
        return response()->json(compact('videos'), 200);
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

            $model = new Videos();
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
                    $modelTagVideos = new TagsVideos();
                    $modelTagVideos->id_tag = $id_tag;
                    $modelTagVideos->id_video = $model->id_video;
                    if (!$modelTagVideos->save()) {
                        $flag3 = false;
                    }
                }
            }

            if (!$flag && !$flag2 && !$flag3) {
                DB::rollBack();
                return response()->json(['error' => 'No se agrego el video'], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Problemas al procesar la solicitud'], 500);
        }

        DB::commit();
        return response()->json(['success' => 'El video se creo correctamente'], 201);
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
            $videos = Videos::where('id_post', $id)->with('tagsPivot')->first();
        } catch (\Exception $e) {
            return response()->json(['error' => 'Problemas al procesar la solicitud'], 500);
        }
        return response()->json(['videos' => $videos], 200);
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
