<?php

namespace App\Http\Controllers;

use App\Board;
use App\BoardFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class BoardFilesController extends Controller
{
    private $savePath = 'storage' . DIRECTORY_SEPARATOR . 'board' . DIRECTORY_SEPARATOR;
    private $allowMime = ['image/jpg', 'image/jpeg', 'image/png', 'image/gif'];

    public function store(Request $request)
    {
        if(! $request->hasFile('file')) {
            return response()->json('잘못된 요청입니다.', 403);
        }

        $file = $request->file('file');

        if(! in_array($file->getClientMimeType(), $this->allowMime)) {
            return response()->json('업로드 불가능한 파일입니다.', 403);
        }

        $boardId = $request->input('boardId');
        $saveName = $file->hashName();

        $file->move(public_path($this->savePath), $saveName);

        $createData = [
            'real_name' => $file->getClientOriginalName(),
            'save_name' => $saveName,
        ];

        $uploadFile = $boardId
            ? Board::findOrFail($boardId)->files()->create($createData)
            : BoardFile::create($createData);

        return response()->json([
            'id' => $uploadFile->id,
            'real_name' => $file->getClientOriginalName(),
            'save_name' => $saveName,
            'type' => $file->getClientMimeType(),
        ]);
    }

    public function destroy($id)
    {
        $boardFile = BoardFile::findOrFail($id);

        $deletePath = public_path($this->savePath . $boardFile->save_name);
        echo $deletePath . '<br/>';
        if(File::exists($deletePath)) {
            File::delete($deletePath);
        }

        $boardFile->delete();

        return response()->json(null, 204);
    }
}
