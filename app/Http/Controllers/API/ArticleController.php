<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ArticleModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;

class ArticleController extends Controller
{
    public function getAllData()
    {
        $data = ArticleModel::all();
        if ($data == null) {
            return response()->json([
                'code' => 401,
                'message' => 'data not found',
            ]);
        } else {
            return response()->json([
                'code' => 200,
                'message' => 'success get all data',
                'data' => $data
            ]);
        }
    }

    public function createData(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'date' => 'required',
            'image_article' => 'required|image|max:2048',
            'doc_image' => 'required',
            'title' => 'required',
            'author' => 'required',
            'description' => 'required'
        ]);

        if ($validation->fails()) {
            return response()->json([
                'code' => 401,
                'message' => 'check your validation',
                'errors' => $validation->errors()
            ]);
        }

        $validated = $validation->validated();

        try {
            $data = new ArticleModel($validated);
            $data->uuid = Uuid::uuid4()->toString();
            $data->date = $request->input('date');
            if ($request->hasFile('image_article')) {
                $file = $request->file('image_article');
                $extension = $file->getClientOriginalExtension();
                $filename = 'ARTICLE-' . Str::random(30) . '.' . $extension;
                Storage::makeDirectory('/uploads/article/');
                $file->move(public_path('uploads/article/'), $filename);
                $data->image_article = $filename;
            }
            $data->doc_image = $request->input('doc_image');
            $data->title = $request->input('title');
            $data->author = $request->input('author');
            $data->description = $request->input('description');
            $data->save();
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'failed create article',
                'errors' => $th->getMessage()
            ]);
        }

        return response()->json([
            'code' => 200,
            'message' => 'success create data article',
            'data' => $data

        ]);
    }

    public function updateData(Request $request, $id)
    {
        $validation = Validator::make($request->all(), [
            'date' => 'required',
            'doc_image' => 'required',
            'title' => 'required',
            'author' => 'required',
            'description' => 'required',
            'image_article' => 'sometimes|required|image|max:2048',
        ]);
    
        if ($validation->fails()) {
            return response()->json([
                'code' => 401,
                'message' => 'check your validation',
                'errors' => $validation->errors()
            ]);
        }
    
        $validated = $validation->validated();
    
        try {
            $data = ArticleModel::findOrFail($id);
            $data->date = $request->input('date');
            $data->doc_image = $request->input('doc_image');
            $data->title = $request->input('title');
            $data->author = $request->input('author');
            $data->description = $request->input('description');
    
            if ($request->hasFile('image_article')) {
                $file = $request->file('image_article');
                $extension = $file->getClientOriginalExtension();
                $filename = 'ARTICLE-' . Str::random(30) . '.' . $extension;
                Storage::makeDirectory('/uploads/article/');
                $file->move(public_path('uploads/article/'), $filename);
                $old_file_path = public_path('uploads/article/') . $data->image_article;
                if (file_exists($old_file_path)) {
                    unlink($old_file_path);
                }
                $data->image_article = $filename;
            }
    
            $data->save();
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'failed update article',
                'errors' => $th->getMessage()
            ]);
        }
    
        return response()->json([
            'code' => 200,
            'message' => 'success update data article',
            'data' => $data
        ]);
    }
    
}
