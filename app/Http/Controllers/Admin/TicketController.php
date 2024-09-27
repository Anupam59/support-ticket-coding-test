<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CommentModel;
use App\Models\TicketModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class TicketController extends Controller
{
    //    public function __construct() {}
    public function TicketIndex(){
        $status = request()->query('status');
        $query = TicketModel::join('users as creator_by', 'creator_by.id', '=', 'ticket.creator')
            ->leftJoin('users as modifier_by', 'modifier_by.id', '=', 'ticket.modifier')
            ->select(
                'creator_by.name as creator_by',
                'modifier_by.name as modifier_by',
                'ticket.*'
            );
        if($status) {
            $query = $query->where('status', $status);
        }
        $Ticket = $query->orderBy('created_date','desc')->paginate(10);
        return view('Admin/Pages/Ticket/TicketIndex',compact('Ticket'));
    }

    public function TicketCreate(){
        return view('Admin/Pages/Ticket/TicketCreate');
    }

    public function TicketEntry(Request $request){
        date_default_timezone_set("Asia/Dhaka");
        $validation = $request->validate([
            'ticket_title' => 'required',
            'ticket_description' => 'required',
        ]);

        $data =  array();
        $data['ticket_title'] = $request->ticket_title;
        $data['ticket_description'] = $request->ticket_description;

        $data['status'] = 1;
        $data['creator'] = Auth::user()->id;
        $data['modifier'] = Auth::user()->id;
        $data['created_date'] = date("Y-m-d h:i:s");
        $data['modified_date'] = date("Y-m-d h:i:s");
        $id = TicketModel::insertGetId($data);

        Mail::send('Admin.Email.AdminReceiveEmail', ['ticket_title' => $request->ticket_title,'ticket_id' => $id,], function($message) use($request){
            $allUser = User::where('role', 1)->get();
            foreach($allUser as $allUsers){
                $message->to($allUsers->email);
                $message->subject('New ticket has been created');
            }
        });

        if ($id){
            return back()->with('success_message','Ticket Add Successfully!');
        }else{
            return back()->with('error_message','Ticket Add Fail!');
        }
    }

    public function TicketEdit($id){
        $Ticket = TicketModel::where('ticket_id',$id)->first();
        $Comment = CommentModel::join('users as creator_by', 'creator_by.id', '=', 'comment.creator')
            ->leftJoin('users as modifier_by', 'modifier_by.id', '=', 'comment.modifier')
            ->select(
                'creator_by.name as creator_by',
                'modifier_by.name as modifier_by',
                'comment.*'
            )->where('ticket_id',$id)->orderBy('comment_id','asc')->get();
        return view('Admin/Pages/Ticket/TicketUpdate',compact('Ticket','Comment'));
    }

    public function TicketDone(Request $request){
        date_default_timezone_set("Asia/Dhaka");
        $data =  array();
        $data['status'] = 2; //Status = 2 means Closes.
        $data['modifier'] = Auth::user()->id;
        $data['modified_date'] = date("Y-m-d h:i:s");
        $res = TicketModel::where('ticket_id','=',$request->ticket_id)->update($data);

        $TicketShow = TicketModel::join('users as creator_by', 'creator_by.id', '=', 'ticket.creator')
            ->leftJoin('users as modifier_by', 'modifier_by.id', '=', 'ticket.modifier')
            ->select(
                'creator_by.name as creator_by',
                'modifier_by.name as modifier_by',
                'ticket.*'
            )->where('ticket_id',$request->ticket_id)->first();


        Mail::send('Admin.Email.CustomerReceiveEmail', [
            'ticket_title' => $TicketShow->ticket_title,
            'ticket_id' => $TicketShow->ticket_id,
            'modifier' => $TicketShow->modifier_by
            ], function($message) use($TicketShow){
            $User = User::where('id', $TicketShow->creator)->where('role', 2)->first();
            $message->to($User->email);
            $message->subject('Ticket has been Closes');
        });


        if ($res){
            return back()->with('success_message','Ticket Done Successfully!');
        }else{
            return back()->with('error_message','Ticket Done Fail!');
        }
    }



    public function CommentEntry(Request $request){
        date_default_timezone_set("Asia/Dhaka");
        $validation = $request->validate([
            'comment_text' => 'required',
        ]);
        $data =  array();
        $data['comment_text'] = $request->comment_text;
        $data['ticket_id'] = $request->ticket_id;
        $data['status'] = 1;
        $data['creator'] = Auth::user()->id;
        $data['modifier'] = Auth::user()->id;
        $data['created_date'] = date("Y-m-d h:i:s");
        $data['modified_date'] = date("Y-m-d h:i:s");
        $res = CommentModel::insert($data);
        if ($res){
            return back()->with('success_message','Comment Add Successfully!');
        }else{
            return back()->with('error_message','Comment Add Fail!');
        }
    }

    function TicketDelete(Request $request){
        $ticket_id= $request->input('ticket_id');
        $res= TicketModel::where('ticket_id','=',$ticket_id)->delete();
        if ($res){
            return back()->with('success_message','Ticket Delete Successfully!');
        }else{
            return back()->with('error_message','Ticket Delete Fail!');
        }
    }
}
