<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Messagefile;
use App\Repositories\Exhibitor\ExhibitorRepository;
use App\Repositories\Message\MessageRepository;
use Pusher\Pusher;
use App\User;
use Image;
use PDF;

class ChatController extends Controller
{
    protected $model;

    public function __construct(MessageRepository $model, ExhibitorRepository $exhibitor)
    {
        $this->model = $model;
        $this->exhibitor = $exhibitor;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allStudents = $this->model->with(['student'])->latest()->where('receiver_id', auth()->user()->id)->get();
        $allStudents = $allStudents->unique(function ($item) {
            return $item['sender_id'] . $item['receiver_id'];
        });
        return view('front.chat.list', compact('allStudents'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getMessage($receiverId)
    {
        $my_id = auth()->user()->id;

        // Make read all unread message
        Message::where(['sender_id' => $my_id, 'receiver_id' => $receiverId])->update(['is_read' => 1]);

        // Get all message from selected user
        $messages = Message::where(function ($query) use ($receiverId, $my_id) {
            $query->where('sender_id', $receiverId)->where('receiver_id', $my_id);
        })->orWhere(function ($query) use ($receiverId, $my_id) {
            $query->where('sender_id', $my_id)->where('receiver_id', $receiverId);
        })->get();
        return view('front.chat.messages.index', compact('messages', 'receiverId'));
    }

    public function sendMessage(Request $request)
    {

        $request->validate([
            'file_attachment' => 'max:3043|mimes:jpeg,bmp,png,gif,svg,pdf',
            'file_attachments' => 'max:3043|mimes:jpeg,bmp,png,gif,svg,pdf',
        ]);

        $sender_id = auth()->user()->id;
        $formData = $request->except(['is_read', 'file_attachment', 'file_attachments']);

        $formData['sender_id'] = $sender_id;

        // message will be unread when sending message
        $formData['is_read'] = 0;

        // save to database if there is file or message
        if ($request->hasFile('file_attachment')) {
            $documents = $request->file('file_attachment');
            $filename = time() . '-' . rand() . '.' . $documents->getClientOriginalExtension();
            $documents->move(public_path('document/'), $filename);
            $formData['file_attachment'] = $filename;
        }

        $this->model->create($formData);

        // pusher
        $options = array(
            'cluster' => 'ap2',
            'useTLS' => true
        );

        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            $options
        );

        // sending from and to user id when pressed enter
        $data = [
            'sender_id' => $sender_id,
            'receiver_id' => $request->receiver_id,
        ];

        $pusher->trigger('my-channel', 'my-event', $data);
    }

    public function exportPDF($receiverId)
    {
        if (!auth()->user()) {
            return redirect()->route('exhibitorLogin')->with('message', 'Please login first');
        }

        $my_id = auth()->user()->id;
        $receiver = User::findOrFail($receiverId);
        $messages = Message::where(function ($query) use ($receiverId, $my_id) {
            $query->where('sender_id', $receiverId)->where('receiver_id', $my_id);
        })->orWhere(function ($query) use ($receiverId, $my_id) {
            $query->where('sender_id', $my_id)->where('receiver_id', $receiverId);
        })->get();

        // return view('chatHistory', compact('messages', 'receiver'));

        $datas = [
            'messages' => $messages,
            'receiver' => $receiver,
        ];

        $pdf = PDF::loadView('chatHistory', $datas);
        return $pdf->download('chat.pdf');
    }

    public function unlinkImage($imagename)
    {
        $thumbPath = public_path('images/thumbnail/') . $imagename;
        $mainPath = public_path('images/main/') . $imagename;
        $listingPath = public_path('images/listing/') . $imagename;
        if (file_exists($thumbPath)) {
            unlink($thumbPath);
        }

        if (file_exists($mainPath)) {
            unlink($mainPath);
        }

        if (file_exists($listingPath)) {
            unlink($listingPath);
        }

        return;
    }

    //save different size of images inside image folder
    public function saveImagesOfMessages($id, $filename)
    {
        ini_set('memory_limit', '500M');
        for ($i = 0; $i < count($filename); $i++) {
            $file = $filename[$i];
            $file_name = time() . rand() . '.' . $file->getClientOriginalExtension();

            $main = public_path('images/main/');

            $img = Image::make($file->getRealPath());
            $img->save($main . $file_name);

            $formData = ['message_id' => $id, 'file_attachment' => $file_name];

            Messagefile::create($formData);
        }
    }

    public function removeParticularImage(Request $request)
    {
        $id = $request->datas;
        $thatImage = Messagefile::findorfail($id);
        $main = public_path('images/main/');
        $status = $thatImage->delete();
        if (file_exists($main . $thatImage->file_attachment)) {
            unlink($main . $thatImage->file_attachment);
        }

        if (isset($status)) {
            return response()->json(['success' => 'success']);
        } else {
            return response()->json(['error' => 'error in server']);
        }
    }
}
