<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
//use Maatwebsite\Excel\Excel;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\InvoiceImport;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Mail\Sendloginagentinfo;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use App\models\User;
use App\models\Category;
//use App\User;
//use App\Category;
use Validator;
use Session;
use DB;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['index','categoryActions','brandActions','getProdects','trendingProdects','promoCode','appUsers','deliveries']);
    }
    
    public function index()
    {
        $data = [];
        return view('admin.dashboard',$data);
    }
    //login admin
    public function loginDashboard(Request $request)
    {
        
        try{
            $validator = Validator::make($request->all(), [
                'email'              => 'required|Email',
                'password'           => 'required',
            ]);
            if($validator->fails()) {
                Session::flash('flash_message', $validator->messages());    
                return back(); 
            }
            $userdata = array(
                'email'     =>  $request['email'],
                'password'  =>  $request['password'],
            );
            //check in auth for login
            if(Auth::attempt($userdata)){
                $user_role = User::where('email',$request['email'])->value('role');
                if($user_role == "1"){
                    $admin = User::where('email',$request['email'])->first();
                    // $request->session()->put('data', $admin);
                    return redirect('/dashboard');
                }elseif($user_role == "2"){
                    return redirect('/dashboard');
                }elseif($user_role == "3"){
                    return redirect('/dashboard');
                }elseif($user_role == "4"){
                    return redirect('/dashboard');  
                }else{
                    Session::flash('flash_message','User is not exist.');    
                    return back();
                }
            }else{
                Session::flash('flash_message','User is not exist.');    
                return back();
            }    
        }catch(\Exception $e){
            //$e->getMessage()
            Session::flash('flash_message',"Something went wrong. please contact to administration"); 
            return back();
        } 
    }
    public function categoryActions(Request $request){
        return view('admin.categories_actions');
    }
    public function brandActions(Request $request){
        return view('admin.brand_actions');
    }
    public function trendingProdects(Request $request){
        return view('admin.trending_products');
    }
    public function getProdects(Request $request){
        return view('admin.products');
    }
    public function promoCode(Request $request){
        return view('admin.promocodes');
    } 
    public function appUsers(Request $request){
        return view('admin.app_users');
    } 
    public function deliveries(Request $request){
        return view('admin.deliveries');
    }
    public function import(Request $request)
    {
       //validate the xls file
        $this->validate($request, array(
            'file'      => 'required'
        ));
  
        if($request->hasFile('file')){
           //$extension = File::extension($request->file->getClientOriginalName()); also we can use
           $extension = $request->file->getClientOriginalExtension();
            if ($extension == "xlsx" || $extension == "xls" || $extension == "csv"){
                $file_name = 'products_'.date('d-m-y').".".$request->file->getClientOriginalExtension();
          
                $path = Storage::put($file_name, $request->file,'public');
                $path = $request->file->storeAs('public/products_files', $file_name);
                Excel::import(new InvoiceImport, $path);
            
                Session::flash('flash_message', 'Your Data has successfully imported');
                return back();
            }else {
                Session::flash('flash_error', 'File is a '.$extension.' file.!! Please upload a valid xls/xlsx/csv file..!!');
                return back();
            }
        }
    }

  
}

