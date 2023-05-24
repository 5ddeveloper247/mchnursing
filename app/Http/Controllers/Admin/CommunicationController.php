<?php



namespace App\Http\Controllers\Admin;



use App\User;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;

use App\Http\Controllers\Controller;

use Brian2694\Toastr\Facades\Toastr;

use Illuminate\Support\Facades\Auth;

use Modules\CourseSetting\Entities\Course;
use Modules\CourseSetting\Entities\CourseEnrolled;
use Modules\StudentSetting\Entities\Program;
use Modules\SystemSetting\Entities\Message;

use Modules\CourseSetting\Entities\CourseComment;



class CommunicationController extends Controller

{

    public function QuestionAnswer()

    {

        $comments = CourseComment::where('instructor_id', Auth::id())->with('course', 'replies', 'user')->paginate(10);

        return view('backend.communication.question_answer', compact('comments'));

    }



    public function PrivateMessage()

    {

        if (Auth::user()->role_id == 1) {

            $users = User::where('id', '!=', Auth::id())->whereIn('role_id', [2,3])->with('sender')->get();

        }else if (Auth::user()->role_id == 2){
            $query = CourseEnrolled::where('course_id',null)->with('user')
                ->whereHas('program', function ($query) {

                });
            $courses = Course::where('user_id', Auth::id())->where('type', 1)->pluck('id');
            $programs = Program::query();
            foreach ($courses as $course){
                $programs =  $programs->orWhere('allcourses', 'like', '%,"' . $course . '",%');
            }
            $programs =  $programs->pluck('id');
            $query = $query->whereIn('program_id',$programs->unique())->groupBy('program_id')->groupBy('user_id')->pluck('user_id')->toArray();
            array_push($query,'1');
            $users = User::with('sender')->where('id', '!=', Auth::id())->whereIn('id',$query)->get();
//                ->where(function ($query) {
//
//                $query->where('role_id', 1)->orWhereIn('enrollStudents');
//
//            })->get();

        }else if (Auth::user()->role_id == 3){
            $query = CourseEnrolled::where('course_id',null)->where('user_id',Auth::id())->groupBy('program_id')->groupBy('user_id')->has('program')->with('program')->get();
            $student_ids = CourseEnrolled::where('course_id',null)->where('user_id' ,'!=',Auth::id())->groupBy('program_id')->groupBy('user_id')->pluck('user_id')->unique()->toArray();
            $course_ids = [];
            if(!empty($course_ids)){
                foreach ($query as $program){
                    if(isset($program->program) && is_array(json_decode($program->program->allcourses))){
                        array_push($course_ids,json_decode($program->program->allcourses));
                    }
                }

                $course_ids = array_unique($course_ids[0]);
                $user_ids = Course::whereIn('id', $course_ids)->pluck('user_id')->toArray();
                array_push($user_ids,1);
                $user_ids = array_unique($user_ids);
            }else{
                $user_ids = ['1'];
            }
            $user_ids = array_merge($user_ids,$student_ids);
            $users = User::whereIn('id', $user_ids)->with('sender')->get();
        }else{
            Toastr::error("Permission Denied", 'Permission');
            return redirect()->back();
        }

        $singleMessage = Message::where('sender_id', Auth::id())->orderBy('id', 'DESC')->first();

        if ($singleMessage) {

            $messages = Message::whereIn('reciever_id', array(Auth::id(), $singleMessage->reciever_id))

                ->whereIn('sender_id', array(Auth::id(), $singleMessage->reciever_id))->get();



        } else {

            $messages = "";

        }


        if(Auth::user()->role_id == 3){
            return view('backend.communication.private_messages_students', compact('messages', 'users', 'singleMessage'));
        }else{
            return view('backend.communication.private_messages', compact('messages', 'users', 'singleMessage'));
        }

    }





    public function StorePrivateMessage(Request $request)

    {

        if (demoCheck()) {

            return false;

        }



        $rules = [

            'message' => 'required',

        ];



        $this->validate($request, $rules, validationMessage($rules));



        try {



            $message = new Message;

            $message->sender_id = Auth::id();

            $message->reciever_id = $request->reciever_id;

            $message->message = $request->message;

            $message->type = Auth::id() == 1 ? 1 : 2;

            $message->seen = 0;

            $message->save();





            Toastr::success('Message has been send successfully', 'Success');



            $messages = Message::whereIn('reciever_id', array(Auth::id(), $request->reciever_id))

                ->whereIn('sender_id', array(Auth::id(), $request->reciever_id))->get();





            $output = getConversations($messages);



            return response()->json($output);



        } catch (\Exception $e) {



            Log::info($e);

            return response()->json(['error' => $e]);

        }

    }





    public function getMessage(Request $request)

    {


        try {

            $receiver_id = $request->id;

            $messages = Message::whereIn('reciever_id', array(Auth::id(), $receiver_id))

                ->whereIn('sender_id', array(Auth::id(), $receiver_id))->get();

            $output = getConversations($messages);

            Message::where('seen', '=', 0)->where('sender_id', $receiver_id)->where('reciever_id', Auth::id())->update(['seen' => 1]);

            $data['messages'] = $output;

            $receiver = User::find($receiver_id);

            $data['receiver_name'] = $receiver->name;

            $data['avatar'] = url('public/' . $receiver->image);

            return response()->json($data);



        } catch (\Exception $e) {



            Log::info($e);

            return response()->json(['error' => 'error']);

        }

    }





}

