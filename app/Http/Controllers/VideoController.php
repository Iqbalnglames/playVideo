<?php

namespace App\Http\Controllers;

use App\Models\Video;
use App\Models\VideoAccessReq;
use App\Models\VideoAccessTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{
    public function indexVideo()
    {
        $video = Video::paginate(20);
        $videoReqExist = VideoAccessReq::where('user_id', auth()->user()->id)->get()->keyBy('video_id');

        return view('pages.home', compact('video', 'videoReqExist'));
    }

    public function viewVideo(Video $video)
    {
        $videoReq = VideoAccessReq::where('user_id', auth()->user()->id)->where('video_id', $video->id)->first();

        return view('pages.videoPlayer', compact('video', 'videoReq'));
    }

    public function listVideo()
    {
       $video = Video::paginate(20);

       return view('pages.home', compact('video', 'videoReqExist'));
    }

    public function videoData()
    {
        $video = Video::paginate(20);

       return view('pages.videoList', compact('video'));
    }

    public function uploadVideo()
    {
        return view('pages.videoUpload');
    }

    public function storeVideo(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'video' => 'required|file|mimes:mp4,mkv,avi|max:51200',
            'thumbnail' => 'required|file|mimes:jpg,png,jpeg,webp|max:1240',
        ]);

        $video = $request->file('video');
        $thumbnail = $request->file('thumbnail');
        $pathVideo = Storage::putFile('videos', $video);
        $pathThumbnail = Storage::putFile('thumbnail', $thumbnail);

        Video::create([
            'title' => $request->title,
            'description' => $request->description,
            'video_path' => $pathVideo,
            'thumbnail' => $pathThumbnail,
        ]);

        return back()->with('success', 'Video berhasil diupload');
    }

    public function editVideo(Video $video)
    {
        return view('pages.videoEdit', compact('video'));
    }

    public function updateVideo(Request $request, Video $video)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'video' => 'nullable|file|mimes:mp4,mkv,avi|max:51200',
            'thumbnail' => 'nullable|file|mimes:jpg,png,jpeg,webp|max:1240',
        ]);

        if($request->hasFile('video')) {
            if($video->video_path && Storage::exists($video->video_path)) {
                Storage::delete($video->video_path);
            }

            $videoPath = Storage::putFile('videos', $request->video);

            $video->video_path = $videoPath;
        }

        if($request->hasFile('thumbnail')) {
            if($video->thumbnail && Storage::exists($video->thumbnail)) {
                Storage::delete($video->thumbnail);
            }

            $thumbnailPath = Storage::putFile('thumbnail', $request->thumbnail);

            $video->thumbnail = $thumbnailPath;
        }

        $video->title = $request->title;
        $video->description = $request->description;
        $video->save();

        return back()->with('success', 'Video berhasil diupdate');
    }

    public function deleteVideo(Video $video)
    {
        if($video->video_path && Storage::exists($video->video_path)) {
            Storage::delete($video->video_path);
        }

        if($video->thumbnail && Storage::exists($video->thumbnail)) {
            Storage::delete($video->thumbnail);
        }

        $video->delete();

        return back()->with('success', 'Video berhasil dihapus');
    }

    public function videoRequest()
    {
        $videoReq = VideoAccessReq::paginate(20);

        return view('pages.request', compact('videoReq'));
    }

    public function videoRequestAccess(Video $video)
    {
        $videoReqExist = VideoAccessReq::where('user_id', auth()->user()->id)->where('video_id', $video->id)
        ->exists();
        if($videoReqExist){
            return back()->with('error', 'request sudah diajukan');
        }

        $videoAccessReq = VideoAccessReq::create([
            'user_id' => auth()->user()->id,
            'video_id' => $video->id,
            'status' => 'menunggu persetujuan',
        ]);

        VideoAccessTime::create([
            'video_access_req_id' => $videoAccessReq->id
        ]);

        return back()->with('success', 'berhasil meminta akses, tunggu hingga akses diberikan oleh admin');
    }

    public function approveAccess(VideoAccessReq $videoAccess, Request $request)
    {
        $videoAccess->update([
            'status' => 'diizinkan',
        ]);

        $videoAccessTime = VideoAccessTime::where('video_access_req_id', $videoAccess->id)->first();

        if(!$videoAccessTime) {
            VideoAccessTime::create([
                'video_access_req_id' => $videoAccess->id,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
            ]);
        }

        $videoAccessTime->update([
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        return back()->with('success', 'berhasil memberikan akses');
    }

    public function denyAccess(VideoAccessReq $videoAccess)
    {
        $videoAccessTime = VideoAccessTime::where('video_access_req_id', $videoAccess->id)->first();

        $videoAccess->update([
            'status' => 'ditolak',
        ]);

        $videoAccessTime->update([
            'start_date' => null,
            'end_date' => null,
        ]);

        return back()->with('success', 'berhasil menolak akses');
    }
}
