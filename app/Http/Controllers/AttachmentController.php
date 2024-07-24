<?php

namespace App\Http\Controllers;

use PDO;
use File;
use Illuminate\Http\Request;
use App\Models\InitAttachment;
use GuzzleHttp\Promise\Promise;
use Illuminate\Support\Facades\DB;

class AttachmentController extends Controller
{
    public function getInitAttachment($id)
    {
        $initattachments = InitAttachment::get()->all();

        foreach ($initattachments as $initattachment) {
            if ($initattachment->initapp_id == $id) {
                $result = $initattachment;
                break;
            }
        }

        if (isset($result)) {
            return response()->json([
                'status' => 200,
                'message' => $result
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Error with retrieving the attachments from the database'
            ]);
        }
    }

    // public function viewInitAttachment(Request $request)
    // {
    //     // return response()->json([
    //     //     'status'=>200,
    //     //     'message'=>'Ok'
    //     // ]);
    //     $attachment = $request->input('attachment');

    //     // return response()->json([
    //     //     'status'=>200,
    //     //     'message'=>$attachment
    //     // ]);

    //     // return redirect()->route('/testing/viewtestfile')->with(['attachment'=>$attachment]);
    //     return view('/testing/viewtestfile', ['filePath' => $attachment]);
    // }
}
