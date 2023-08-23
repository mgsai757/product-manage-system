<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class AdminController extends Controller
{
    //

    //change password page
    public function changePasswordPage(){
        return view('admin.account.changePassword');
    }

    //change password
    public function changePassword(Request $request){
        // dd($request->all());
        /*
            1.all field must be fill
            2.new password and confirm password length must be greater than 6 and less than 10 characters
            3.new password and confirm password must same
            4.client old password must be same with db password
            5.password change
        */
        $this ->passwordValidationCheck($request);

        $user = User::select('password')->where('id',Auth::user()->id)->first();
        $dbPassword = $user->password;
        // dd($dbPassword);
        // dd('change password');
        if(Hash::check($request->oldPassword,$dbPassword)){
            User::where('id',Auth::user()->id)->update([
                'password' => Hash::make($request->newPassword)
            ]);
            Auth::logout();
            return redirect()->route('auth#loginPage');
        }

        return back()->with(['notMatch'=> 'The Old Password not Match! Try Again!']);

    }

    //direct admin details page
    public function details(){
        return view('admin.account.details');
    }
    //direct admin profile edit page
    public function edit(){
        return view('admin.account.edit');
    }

    //update account
    public function update($id,Request $request){
        // dd($id,$request->all());
        $this->accountValidationCheck($request);
        $data = $this->getUserData($request);

        //for image
        if($request->hasFile('image')){
            //1 old image name | check=>delete | store
            $dbImage = User::where('id',$id)->first();
            $dbImage = $dbImage->image;
            if($dbImage !=null){
                Storage::delete('public/'.$dbImage);
            }
            $fileName = uniqid() . $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('public',$fileName);
            $data['image'] = $fileName;
            // dd($fileName);
        }
        User::where('id',$id)->update($data);
        return redirect()->route('admin#details')->with(['updateSuccess' =>'Admin Account Updated...']);
    }
    //admin list
    public function list(){
        $admin = User::when(request('key'),function($query){
            $query->orWhere('name','like','%'.request('key').'%')
                  ->orWhere('email','like','%'.request('key').'%')
                  ->orWhere('gender','like','%'.request('key').'%')
                  ->orWhere('phone','like','%'.request('key').'%')
                  ->orWhere('address','like','%'.request('key').'%');
        })
        ->where('role','admin')->paginate(3);
        $admin->appends(request()->all());
        // dd($admin->toArray());
        return view('admin.account.adminList',compact('admin'));

    }
    //user list
    public function userList(){
        $user = User::where('role','user')->paginate(3);
        // dd($user->toArray());
        return view('admin.account.userList',compact('user'));
    }
    //delete
    public function delete($id){
        User::where('id',$id)->delete();
        return back()->with(['deleteSuccess'=>'Admin Account Deleted']);
    }
    //change role
    public function changeRole($id){
        $account = User::where('id',$id)->first();
        return view('admin.account.changeRole',compact('account'));
    }
    //change
    public function change($id,Request $request){
        $data['role'] = $request->role;
        User::where('id',$id)->update($data);
        return redirect()->route('admin#list');
    }
    //contact message
    public function contact(){
        $message = Contact::paginate(4);
        logger($message);
        return view('admin.account.contact',compact('message'));
    }
    public function deleteContact($id){
        Contact::where('id',$id)->delete();
        return redirect()->route('admin#contact');
    }
    //request user data
    private function getUserData($request){
        return[
            'name' => $request->name,
            'email' => $request->email,
            'gender' => $request->gender,
            'phone' => $request->phone,
            'address' => $request->address,
            'updated_at' => Carbon::now()
        ];
    }
    //account validation check
    private function accountValidationCheck($request){
        Validator::make($request->all(),[
            'name' => ['required'],
            'email' => ['required'],
            'gender' => ['required'],
            'phone' => ['required'],
            'image' => 'mimes:png,jpg,jpeg |file' ,
            'address' => ['required'],

        ])->validate();
    }
    //password validation check
    private function passwordValidationCheck($request){
        Validator::make($request->all(),[
            'oldPassword' =>'required| min:6 | max:10',
            'newPassword' =>'required| min:6 | max:10',
            'confirmPassword' => 'required| min:6 | max:10 |same:newPassword'
        ])->validate();
    }
}
