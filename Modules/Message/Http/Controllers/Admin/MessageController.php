<?php

namespace Modules\Message\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Message\Http\Requests\CreateMessageRequest;
use Modules\Message\Http\Requests\UpdateMessageRequest;
use Modules\Message\Repositories\MessageRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Message\Entities\Message;
use Modules\Message\Entities\Chat;
use Excel;

class MessageController extends AdminBaseController
{
    /**
     * @var MessageRepository
     */
    private $message;

    public function __construct(MessageRepository $message)
    {
        parent::__construct();

        $this->message = $message;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $messages = Message::with(['seller', 'buyer', 'item'])->get();

        return view('message::admin.messages.index', compact('messages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('message::admin.messages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateMessageRequest $request
     * @return Response
     */
    public function store(CreateMessageRequest $request)
    {
        $this->message->create($request->all());

        return redirect()->route('admin.message.message.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('message::messages.title.messages')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Message $message
     * @return Response
     */
    public function edit(Message $message)
    {
        $chat = $message->chat;
        return view('message::admin.messages.edit', compact(['message', 'chat']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Message $message
     * @param  UpdateMessageRequest $request
     * @return Response
     */
    public function update(Message $message, UpdateMessageRequest $request)
    {
        $this->message->update($message, $request->all());

        return redirect()->route('admin.message.message.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('message::messages.title.messages')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Message $message
     * @return Response
     */
    public function destroy(Message $message)
    {
        $this->message->destroy($message);

        return redirect()->route('admin.message.message.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('message::messages.title.messages')]));
    }
    
    /**
     * Export the message chat list to excel file
     *
     * @return Response
     */
    public function export(Request $request)
    {
        ob_end_clean();
        
        $input = $request->all();
        $message_id = $input['message_id'];
        
        $chats = Chat::where('message_id', $message_id)->with(['sender'])->get();
        if (count($chats) > 0) {
            $exportedFile = Excel::create(trans('message::messages.title.chat export file name'), function($excel) use($chats) {
                $excel->sheet(trans('message::messages.title.chat export sheet name'), function($sheet) use($chats) {
                    $sheet->loadView('message::admin.messages.export', array('items' => $chats));
                });
            })->export('xls');

            return $exportedFile;  
        }                    
        

        return redirect()->back();
    }
}
