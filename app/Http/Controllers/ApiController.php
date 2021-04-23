<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Storage;
//use Maatwebsite\Excel\Excel;
//use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Input;
use App\models\Wallet;
use App\models\User;
use App\models\Category;
use App\models\PromoCodes;
use App\models\Products;
use App\models\Appusers;
use App\models\Cities;
use App\models\States;
use App\models\Brands;
use App\models\Cart;
use App\models\ReferalCode;
use App\models\UserTransactions;
use App\models\UsersFeedbacks;
use App\models\UsersDeliveryAddress;
use App\models\TrendingProducts;
use App\Exports\InvoicesExport;
use App\Imports\InvoiceImport;
use HTML,Form,Validator,Mail,Response,Session,DB,Redirect,Image,Password,Cookie,File,View,JsValidator,URL,Excel;


class ApiController extends Controller
{
    #user login or register
    public function login(Request $request){
        try{
            $appUsers = new Appusers();
            #login with email
            if(!empty($request->email_id)){
                #get data of user if email will match
                $response['appusers'] = Appusers::where('email_id',$request->email_id)->first();
                if(!empty($response['appusers']) && isset($response['appusers'])) {
                    #send response
                    return response()->json([
                        'message'=>'login successfully.',
                        'code'=>200,
                        'data'=>$response,
                        'status'=>'success'
                    ]);
                }else{
                    #register if user not found in database
                    //$appUsers->user_type = $appUsers->user_type;
                    $appUsers->name           = $request->name;
                    $appUsers->email_id       = $request->email_id;
                    $appUsers->phone_number   = " ";
                    $appUsers->login_method   = $request->login_method;
                    $appUsers->firebase_token = $request->firebase_token;
                    $appUsers->gender         = " ";
                    $appUsers->state          = " ";
                    $appUsers->city           = " ";                   
                    $appUsers->dob            = " ";
                    $appUsers->image            = " ";
                    $appUsers->delete_status  = "1";
                    $appUsers->created_at     = date("Y-m-d");
                    $appUsers->save();
                    if($appUsers->id){
                        $response['user_id'] = $appUsers->id;
                        return response()->json([
                            'message'=>'Registered successfully.',
                            'code'=>200,
                            'data'=>$response,
                            'status'=>'success'
                        ]);
                    }else{
                        return response()->json([
                            'message'=>"something went wrong contact with administrator.",
                            'status'=>'error'
                        ]);
                    }
                }
            #login with phone number  
            }elseif(!empty($request->phone_number)){
                #get data of user if phone_number will match
                $response['appusers'] = Appusers::where('phone_number',$request->phone_number)->first();
                if(!empty($response['appusers']) && isset($response['appusers'])) {
                    #send response
                    return response()->json([
                        'message'=>'login successfully.',
                        'code'=>200,
                        'data'=>$response,
                        'status'=>'success'
                    ]);
                }else{
                    #register if user not found in database
                    //$appUsers->user_type = $appUsers->user_type;
                    $appUsers->name           = $request->name;
                    $appUsers->email_id       = " ";
                    $appUsers->phone_number   = $request->phone_number;
                    $appUsers->login_method   = $request->login_method;
                    $appUsers->firebase_token = $request->firebase_token;
                    $appUsers->gender         = " ";
                    $appUsers->state          = " ";
                    $appUsers->city           = " ";                   
                    $appUsers->dob            = " ";
                    $appUsers->image          = " ";
                    $appUsers->delete_status  = "1";
                    $appUsers->created_at     = date("Y-m-d");
                    $appUsers->save();
                    if($appUsers->id){
                        $response['user_id'] = $appUsers->id;
                        return response()->json([
                            'message'=>'Registered successfully.',
                            'code'=>200,
                            'data' => $response,
                            'status'=>'success'
                        ]);
                    }else{
                        return response()->json([
                            'message'=>"something went wrong contact with administrator.",
                            'status'=>'error'
                        ]);
                    }
                }
            }else{
                return response()->json([
                    'message'=>"Please provide atleast one login detail",
                    'status'=>'error'
                ]);
            }
        }catch(\Exception $e){
            return response()->json([
                'message'=>"Something went wrong. Please contact administrator.".$e->getMessage(),
                'status'=>'error'
            ]);
        }
    }
    #get states
    public function getAllStates(Request $request){
        try{
            $response['states'] = States::all();
            if(!empty($response['states'])){
                #send response
                return response()->json([
                    'message'=>'All states',
                    'code'=>200,
                    'data'=>$response,
                    'status'=>'success'
                ]);
            }else{
                return response()->json([
                    'message'=>"no states found",
                    'status'=>'error'
                ]);
            }
        }catch(\Exception $e){
            return response()->json([
                'message'=>"Something went wrong. Please contact administrator.".$e->getMessage(),
                'status'=>'error'
            ]);
        }
    }
    #get cities based on state id
    public function getAllCities(Request $request){
        try{
            if($request->state_id){
                $response['cities'] = Cities::where('state_id',$request->state_id)->get();
                if(!empty($response['cities'])){
                    #send response
                    return response()->json([
                        'message'=>'All Cities',
                        'code'=>200,
                        'data'=>$response,
                        'status'=>'success'
                    ]);
                }else{
                    return response()->json([
                        'message'=>"no cities found",
                        'status'=>'error'
                    ]);
                }
            }else{
                return response()->json([
                    'message'=>"Please provide state id first",
                    'status'=>'error'
                ]);
            }
        }catch(\Exception $e){
            return response()->json([
                'message'=>"Something went wrong. Please contact administrator.".$e->getMessage(),
                'status'=>'error'
            ]);
        }
    }
    //app user profile update
    public function appUserProfileUpdate(Request $request){
        try{
            $appUserId = $request['user_id'];
            //check request have data or not
            if(!empty($appUserId) && isset($appUserId)){
                $appUser = Appusers::where('id',$appUserId)->first();
                //check user is in database
                if(!empty($appUser) && isset($appUser)) {
                    Appusers::where('id',$appUserId)->update([
                        
                       'name'         => $request->name,
                       'email_id'     => $request->email_id,
                       'phone_number' => $request->phone_number,
                       'gender'     => $request->gender,
                       'state'      => ucfirst($request->state),
                       'city'       => ucfirst($request->city),
                       'dob'        => $request->dob,
                       'updated_at' => date("Y-m-d"),
                    ]);
                    $response = [];
                    $response['appUser'] =  Appusers::where('id', $appUserId)->first();
                    return response()->json([
                        'message'=>'Profile successfully updated',
                        'status'=>'success',
                        'data'=>$response
                    ]);
                }else{
                    return response()->json([
                        'message'=>'User not found',
                        'status'=>'error'
                    ]);
                }
            }else{
                return response()->json([
                    'message'=>'You are not able to performe this task',
                    'status'=>'error'
                ]);
            }        
        }catch(\Exception $e){
            return response()->json([
                "message" => "Something went wrong. Please contact administrator.".$e->getMessage(),
                "error" =>true,
            ]);
        }

    }
    // user image upload
    public function imageUpload(Request $request){
        try{
            //return  response()->json([base64_decode($request->userImage)]);
            $appUserId = $request['user_id'];
            //check request have data or not
            if(!empty($appUserId) && isset($appUserId)){
                $appUser = Appusers::where('id',$appUserId)->first();
                //check user is in database
                if (!empty($appUser) && isset($appUser)) {
                    $validator = Validator::make($request->all(), ['image' => 'required']);
                    if ($validator->fails()) {
                        return response()->json([
                            'message'=>$validator->messages(),
                            'status'=>'error'
                        ]);
                    }
                    if($request->image){
                        $file_name = 'public/user_images/_user'.time().'.png';
                        $path = Storage::put($file_name, base64_decode($request->image),'public');
                        if($path==true){
                            //update image in agent table of agent
                            $appUsers =   Appusers::where('id', $appUserId)->first();
                            $appUsers->update(['image' => $file_name]);
                            //send url for android
                            //$agent->imagePath = url('public/user_images')."/".$file_name;
                            //$path = Storage::url($file_name);
                            //$finalPath = $file_name ?   url('/')."/public".Storage::url($file_name) : url('/')."/public/dist/img/user-dummy-pic.png";
                            $finalPath = $file_name ? url('/').'/storage/app/'.$file_name : url('/')."/public/dist/img/user-dummy-pic.png";
                            return response()->json([
                                'message'=>'Image successfully uploaded',
                                'status'=>'success',
                                'response'=>$finalPath,
                                'code'=>200
                            ]);

                        }else{
                            return response()->json([
                                'message'=>'Something went wrong with request.Please try again later',
                                'status'=>'error'
                            ]);
                        }
                    }else{
                        return response()->json([
                            'message'=>'Please provide image for uploading',
                            'status'=>'error'
                        ]);
                    }
                }else{
                    return response()->json([
                        'message'=>'User not found',
                        'status'=>'error'
                    ]);
                }
            }else{
                return response()->json([
                    'message'=>'You are not able to performe this task',
                    'status'=>'error'
                ]);
            }
        }catch(\Exception $e){
            return response()->json([
                "message" => "Something went wrong. Please contact administrator.".$e->getMessage(),
                "error" =>true,
            ]);
        }
    }
    #update firebase token
    public function updateFireBaseToken(Request $request){
        try{
            if($request->id  &&  $request->fireBaseToken){
                $appUsers = Appusers::where('id',$request->id)->first();
                if($appUsers){
                    $updateToken = Appusers::where('id',$request->id)->update([
                        'firebase_token'    => $request->fireBaseToken,
                    ]);
                    if($updateToken){
                        return response()->json([
                            'agent_customers'=>"token successfully updated",
                            'status' =>'success',
                            'code' =>200,
                        ]);
                    }else{
                        return  response()->json([
                            'message'=>'token is not updated yet. please try again',
                            'status' =>'error',
                        ]);
                    }
                }else{
                    return response()->json([
                        'message'=>'user is not found in database',
                        'status' =>'error',
                    ]);
                }
            }else{
                return response()->json([
                    'message'=>' userId or token not provided',
                    'status' =>'error',
                ]);
            }
        }catch(\Exception $e){
            return response()->json([
                'message'=>"something went wrong.Please contact administrator.".$e->getMessage(),
                'error' =>true,
            ]);
        }
    }
    #get all categories
    public function getAllCategories(Request $request){
        try{
            $allProducts = [];
            $categories = Category::where('delete_status','1')->get();
            foreach($categories as $category){
                $brands = Brands::with('categoryBrands')->where('cat_id',$category->id)->get();
                if(count($brands) > 0 ){
                    array_push($allProducts,$brands);
                } 
            }
            $response['allproducts'] = $allProducts;
            if(!empty($response['allproducts'])){
                #send response
                return response()->json([
                    'message'=>'All Categories',
                    'code'=>200,
                    'data'=>$response,
                    'status'=>'success'
                ]);
            }else{
                return response()->json([
                    'message'=>"no Categories found",
                    'status'=>'error'
                ]);
            }
        }catch(\Exception $e){
            return response()->json([
                'message'=>"Something went wrong. Please contact administrator.".$e->getMessage(),
                'status'=>'error'
            ]);
        }
    }
    #get all products
    public function getAllProducts(Request $request){
        try{
            $cat_products = [];
            if(!empty($request->cat_id) && !empty($request->brand_id)){
                //print_r($request->brand_id);die;
                for($i=0; $i<count($request->brand_id); $i++){
                    $brand_id = $request->brand_id[$i]['id'];
                    $products = Products::where('cat_id',$request->cat_id)
                                                    ->where('brand_id',$brand_id)
                                                    ->get();
                    if($products != NULL){
                        array_push($cat_products,$products);
                    }
                }
                $response['products_listing'] = $cat_products;
                $response['base_url'] = "http://www.projects.estateahead.com/stock_inventory_mgt/storage/app/public/";
                if(!empty($response['products_listing'])){
                    #send response
                    return response()->json([
                        'message'=>'All categories Products',
                        'code'=>200,
                        'data'=>$response,
                        'status'=>'success'
                    ]);
                }else{
                    return response()->json([
                        'message'=>"no Products found of this category",
                        'status'=>'error'
                    ]);
                }
            }else{
                $response['products'] = Products::where('delete_status','1')->get();
                if(!empty($response)){
                    return response()->json([
                        'message'=>'All categories Products',
                        'code'=>200,
                        'data'=>$response,
                        'status'=>'success'
                    ]);
                }else{
                    return response()->json([
                        'message'=>"no Products found in the database",
                        'status'=>'error'
                    ]);
                }   
            } 
        }catch(\Exception $e){
            return response()->json([
                'message'=>"Something went wrong. Please contact administrator.".$e->getMessage(),
                'status'=>'error'
            ]);
        }
    }
    #get weight of product
    public function getAllWeightOfProduct(Request $request){
        try{
            if(!empty($request->cat_id) &&  !empty($request->brand_id)){
                
                $response['productsPrice'] = $productsPrice = DB::table('products')
                                                                ->where('cat_id',$request->cat_id)
                                                                ->where('brand_id',$request->brand_id)
                                                                ->where('products',$request->product_name)
                                                                ->select('weight','unit')
                                                                ->get();
                if(!empty($productsPrice)){
                    #send response
                    return response()->json([
                        'message'=>'All weights of particular Products',
                        'code'=>200,
                        'data'=>$response,
                        'status'=>'success'
                    ]);
                }else{
                    return response()->json([
                        "message"=>"weights not found of particular products",
                        "status"=>'error'
                    ]);
                }
            }else{
                return response()->json([
                    'message'=>"Provide category id  and brand id first",
                    'status'=>'error'
                ]);
            }
        }catch(\Exception $e){
            return response()->json([
                'message'=>'Something went wrong. Please contact administrator.'.$e->getMessage(),
                'status' =>'error'

            ]);
        }
    }
    #add cart 
    public function addToCart(Request $request){
        try{
            if(!empty($request->product_id) && !empty($request->user_id)){
                $cart =  new Cart();
                $cart->product_id = $request->product_id;
                $cart->user_id = $request->user_id;
                $cart->created_at = date('Y-m-d');
                $cart->save();
                if($cart->id){
                    return response()->json([
                        'message'=>"product has been successfully added in the cart",
                        "code"=>200,
                        'status'=>'success'
                    ]);
                }else{
                    return response()->json([
                        'message'=>"Sorry we cant add product in the cart. Please try again.",
                        'status'=>'error'
                    ]);
                }
            }else{
                return response()->json([
                    'message'=>"Provide category id  and brand id first",
                    'status'=>'error'
                ]);
            }
        }catch(\Exception $e){
            return response()->json([
                'message'=>'Something went wrong. Please contact administrator.'.$e->getMessage(),
                'status' =>'error'
            ]);
        }
    }
    #view cart 
    public function viewCartOfUser(Request $request){
        try{
            if(!empty($request->user_id)){
                $appUser = Appusers::where('id',$request->user_id)->first();
                if(!empty($appUser)){
                    $response['cart'] = Cart::with(['getProduct'])->where('user_id',$request->user_id)->get();
                    $response['base_url'] = "http://www.projects.estateahead.com/stock_inventory_mgt/storage/app/public/";               
                    if(!empty($response)){
                        #send response
                        return response()->json([
                            'message'=>'user cart items.',
                            'code'=>200,
                            'data'=>$response,
                            'status'=>'success'
                        ]);
                    }else{
                        return response()->json([
                            'message'=>"Product not found in the database please provide excisting user id",
                            'status'=>'error'
                        ]);
                    }
                }else{
                    return response()->json([
                        'message'=>"User not found in the database please provide excisting user id",
                        'status'=>'error'
                    ]);
                }
            }else{
                return response()->json([
                    'message'=>"Provide user id first",
                    'status'=>'error'
                ]);
            }
        }catch(\Exception $e){
            return response()->json([
                'message'=>'Something went wrong. Please contact administrator.'.$e->getMessage(),
                'status' =>'error'
            ]);
        }
    }
    #delete product from the cart
    public function deleteProductFromCart(Request $request){
        try{
            $carts = FALSE;
            if($request->cart_id){
                for($i=0; $i<count($request->cart_id); $i++){
                    $cart_id       = $request->cart_id[$i]['id'];
                    $productsPrice = DB::table('carts')->where('id',$cart_id)->get();
                    if(count($productsPrice) != 0){
                        $cart = DB::table('carts')->where('id',$cart_id)->delete();
                        $carts = $cart;
                        break;
                    } 
                } 
                if($carts==TRUE){
                    #send response
                    return response()->json([
                        'message'=>'Deleted successfully',
                        'code'=>200,
                        'status'=>'success'
                    ]);
                }else{
                    return response()->json([
                        'message'=>"cart not deleted yet.Please try again later.",
                        'status'=>'error'
                    ]);
                }
            }else{
                return response()->json([
                    'message'=>"Provide Cart id first",
                    'status'=>'error'
                ]);
            }
        }catch(\Exception $e){
            return response()->json([
                'message'=>'Something went wrong. Please contact administrator.'.$e->getMessage(),
                'status' =>'error'
            ]);
        }
    }
    #get single product according to weight
    public function getSingleProduct(Request $request){
        try{
            if(!empty($request->cat_id) && !empty($request->brand_id) && !empty($request->weight) && !empty($request->product_name)){
                #get product from database
                $response['product'] = Products::where('cat_id',$request->cat_id)
                                                ->where('brand_id',$request->brand_id)
                                                ->where('weight',$request->weight)
                                                ->where('products',$request->product_name)
                                                ->first();

                if(!empty($response['product'])){
                    #send response
                    return response()->json([
                        'message'=>'Product according to weight',
                        'code'=>200,
                        'data'=>$response,
                        'status'=>'success'
                    ]);
                }else{
                    return response()->json([
                        'message'=>"Product not found in the database please provide excisting ids",
                        'status'=>'error'
                    ]);
                }
            }else{
                return response()->json([
                    'message'=>"Provide all ids first",
                    'status'=>'error'
                ]);
            }
        }catch(\Exception $e){
            return response()->json([
                'message'=>'Something went wrong. Please contact administrator.'.$e->getMessage(),
                'status' =>'error'
            ]);
        }
    }
    #add delivery address of user
    public function AddUsersDeliveryAddress(Request  $request){
        try{
            if(!empty($request->user_id) && !empty($request->dlvry_address)){
                $model = new UsersDeliveryAddress();
                $model->user_id       = $request->user_id;
                $model->dlvry_address = $request->dlvry_address;
                $model->created_at    = date("Y-m-d");
                $model->save();
                if($model->id){
                    #send response
                    return response()->json([
                        'message'=>'address successfully added',
                        'code'=>200,
                        'status'=>'success'
                    ]); 
                }else{
                    return response()->json([
                        'message'=>"address not successfully added",
                        'status'=>'error'
                    ]);
                }
            }else{
                return response()->json([
                    'message'=>"Provide all ids first",
                    'status'=>'error'
                ]);
            }
        }catch(\Exception $e){
            return response()->json([
                'message'=>'Something went wrong. Please contact administrator.'.$e->getMessage(),
                'status' =>'error'
            ]);
        }
    }
    #get delivery address of user 
    public function getDeliveryAddress(Request $request){
        try{
            if(!empty($request->user_id)){
                $response['deliveryAddress'] = UsersDeliveryAddress::where('user_id',$request->user_id)->get();
                if($response['deliveryAddress']){
                    #send response
                    return response()->json([
                        'message'=>'All address of this user.',
                        'code'=>200,
                        'data'=>$response,
                        'status'=>'success'
                    ]);
                }else{
                    return response()->json([
                        'message' => ' Delivery address not found of this user',
                        'status' => 'error'
                    ]);
                }
            }else{
                return response()->json([
                    'message' => 'Please provide user id',
                    'status' => 'error'
                ]);
            }
        }catch(\Exception $e){
            return response()->json([
                'message'=>'Something went wrong. Please contact administrator.'.$e->getMessage(),
                'status' =>'error'
            ]);
        }
    }
    #Add feedbacks of user
    public function addFeedbacks(Request $request){
        try{
            if(!empty($request->user_id) && !empty($request->product_id) && !empty($request->feedbacks)){
                $model = new UsersFeedbacks();
                $model->user_id    = $request->user_id;
                $model->product_id = $request->product_id;
                $model->feedbacks   = $request->feedbacks;
                $model->created_at = date('Y-m-d');
                $model->save();
                if($model->id){
                    #send response
                    return response()->json([
                        'message'=>'Feedback successfully added.',
                        'code'=>200,
                        'status'=>'success'
                    ]);
                }else{
                    return response()->json([
                        'message'=>'feedback not saved yet. Please try again later',
                        'status' =>'error'
                    ]);  
                }
            }else{
                return response()->json([
                    'message'=>'Please provide data',
                    'status' =>'error'
                ]);   
            }
        }catch(\Exception $e){
            return response()->json([
                'message'=>'Something went wrong. Please contact administrator.'.$e->getMessage(),
                'status' =>'error'
            ]);
        }  
    }
    # get users feedbacks
    public function getUsersFeedback(Request $request){
        try{
            $response = [];
            $usersFeedbacks = []; 
            $users = Appusers::all();

            for($i=0; $i<count($users); $i++){
                
               // $feedbacks = UsersFeedbacks::where('user_id',$users[$i]['id'])->get();
                $feedbacks = Appusers::where('id',$users[$i]['id'])->with(["getUsersFeedbacks"])->get();
                
                if(count($feedbacks) != 0){
                    array_push($usersFeedbacks,$feedbacks);
                }
            }
            $response['users_feedbacks'] =  $usersFeedbacks;
            $response['base_url'] = "http://www.projects.estateahead.com/stock_inventory_mgt/storage/app/public/";
            if(!empty($response['users_feedbacks'])){
                #send response
                return response()->json([
                    'message'=>'Users Feedbacks',
                    'code'=>200,
                    'data'=>$response,
                    'status'=>'success'
                ]);
            }else{
                return response()->json([
                    'message'=>"data not found",
                    'status'=>'error'
                ]);
            }
        }catch(\Exception $e){
            return response()->json([
                'message'=>'Something went wrong. Please contact administrator.'.$e->getMessage(),
                'status' =>'error'
            ]);

        }
    }
    #addition of amount of products
    public function additionOfAmount(Request $request){
        try{
            $productsPrices = [];
            $addition = 0;
            if($request->user_id){
                $carts = Cart::where('user_id',$request->user_id)->get();
                
                #get products price
                for($i=0; $i<count($carts); $i++){
                    $product_id  = $carts[$i]->product_id;
                    $productsPrice = DB::table('products')->where('id',$product_id)
                                                          ->select('rujooal_price')
                                                          ->get();
                    if($productsPrice != NULL){
                        array_push($productsPrices,$productsPrice);
                    }
                }
               
                #get sum of prices
                for($i=0; $i<count($productsPrices); $i++){
                    $addition = $addition + $productsPrices[$i][0]->rujooal_price;
                }
                $response['totalAmount'] = $addition;
                if(!empty($response['totalAmount'])){
                    #send response
                    return response()->json([
                        'message'=>'Total amount',
                        'code'=>200,
                        'data'=>$response,
                        'status'=>'success'
                    ]);
                }else{
                    return response()->json([
                        'message'=>'No Amount found.',
                        'status' =>'error'
                    ]);
                }
            }else{
                return response()->json([
                    'message'=>'Please provide user id',
                    'status' =>'error'
                ]);
            }
        }catch(\Exception $e){
            return response()->json([
                'message'=>'Something went wrong. Please contact administrator.'.$e->getMessage(),
                'status' =>'error'
            ]);
        }
    }
    # get trending products
    public function trendingProducts(Request $request){
        try{
            $response = [];
            $trendingProducts = [];  
            $trending_data = TrendingProducts::orderBy('priority','asc')->get();
            for($i=0; $i<count($trending_data); $i++){
                $product = Products::where('id',$trending_data[$i]['product_id'])->get();
                if($product != NULL){
                    array_push($trendingProducts,$product);
                }
            }
            $response['trending_products'] =  $trendingProducts;
           
            if(!empty($response['trending_products'])){
                #send response
                return response()->json([
                    'message'=>'Trending Products',
                    'code'=>200,
                    'data'=>$response,
                    'status'=>'success'
                ]);
            }else{
                return response()->json([
                    'message'=>"Product not found in the database please provide excisting user id",
                    'status'=>'error'
                ]);
            }
        }catch(\Exception $e){
            return response()->json([
                'message'=>'Something went wrong. Please contact administrator.'.$e->getMessage(),
                'status' =>'error'
            ]);
        }
    }
    # delete delivery 
    public function deleteDeliveryAddress(Request $request){
        try{
            if(!empty($request->dlvry_id) && !empty($request->user_id)){
                $dlvryAddress = UsersDeliveryAddress::where('id',$request->dlvry_id)
                                                      ->where('user_id',$request->user_id)
                                                      ->get();
                if(!empty($dlvryAddress)){
                    $action = DB::table('users_delivery_addresses')->where('id',$request->dlvry_id)->delete();
                    if($action==TRUE){
                        #send response
                        return response()->json([
                            'message'=>'Deleted successfully',
                            'code'=>200,
                            'status'=>'success'
                        ]);
                    }else{
                        return response()->json([
                            'message'=>"Delivery address not deleted yet.Please try again later.",
                            'status'=>'error'
                        ]);
                    }
                }else{
                    return response()->json([
                        'message'=>"Delivery address not found in the database",
                        'status'=>'error'
                    ]);
                }
            }else{
                return response()->json([
                    'message'=>"Please provide dlvry id and user id",
                    'status'=>'error'
                ]);
            }
        }catch(\Exception $e){
            return response()->json([
                'message'=>'Something went wrong. Please contact administrator.'.$e->getMessage(),
                'status' =>'error'
            ]);
        }
    }
    #save transactions of user
    public function submitTransaction(Request $request){
        try{
            $data = [];
            if($request->order_id){
                $model = new UserTransactions();
                $model->order_id   = $request->order_id;
                $model->user_id    = $request->user_id;
                for($i=0; $i<count($request->product_id); $i++){
                    $product_ids = $request->product_id[$i]['id'];
                    $count = $request->product_id[$i]['count'];
                    for($j=0; $j<$count;$j++){
                        array_push($data,$product_ids);
                    }
                }
                $model->product_id = json_encode($data);
                $model->invoice_id = rand(10,1000);
                $model->amount     = $request->amount;
                $model->status     = ($request->status=="") ? "Cash On Delivery": $request->status;
                $model->promo_code = $request->promo_code;
                $model->dlvry_address = $request->dlvry_address;
                if(($request->status == "Success") || ($request->status == "")){$model->dlvry_status = "0";}else{$model->dlvry_status = " ";}
                $model->created_at = date('Y-m-d');
                $model->save();
                #update stock as well
                if(($request->status == "Success") || ($request->status == " ")){
                    for($i=0; $i<count($request->product_id); $i++){
                        $productStock = DB::table('products')->where('id',$request->product_id[$i]['id'])
                                                              ->select('stock')
                                                              ->get()->toArray();
                        for($j=0; $j<count($productStock); $j++){
                            $stock =  $productStock[$j]->stock;
                            $didectedStock = $stock - 1;
                            Products::where('id',$request->product_id[$i]['id'])->update([
                                'stock' => $didectedStock,
                            ]);
                        }
                    }
                }
                if($model->id){
                    $userData = Appusers::where('id',$request->user_id)->where('delete_status','1')->first();
                    if($request->status =="Fail"){
                        #send response
                        $authKey = "782a3998b8c705c6f6a650897f4f3403";
                        $mobileNumber = $userData->phone_number;
                        $senderId = "RUJOAL";
                        $message = "Your Transaction has been cancelled. Your order id : ".$request->order_id." and Your final amount : ".$request->amount;
                        $route = "4";
                        //Prepare you post parameters
                        $postData = array(
                            'authkey' => $authKey,
                            'mobiles' => $mobileNumber,
                            'message' => $message,
                            'sender'  => $senderId,
                            'route'   => $route
                        );
                        //API URL
                        $url = "http://sms.bulksmsserviceproviders.com/api/send_http.php";
                        // init the resource
                        $ch = curl_init();
                        curl_setopt_array($ch, array(
                            CURLOPT_URL => $url,
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_POST => true,
                            CURLOPT_POSTFIELDS => $postData
                            //,CURLOPT_FOLLOWLOCATION => true
                        ));
                        //Ignore SSL certificate verification
                        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                        //get response
                        $output = curl_exec($ch);
                        //Print error if any
                        if (curl_errno($ch)) {
                            return response()->json([
                                'message'=>curl_error($ch)."sms did not send but all operation has been successful",
                                'status' =>'error'
                            ]);
                        }
                        curl_close($ch); 
                        return response()->json([
                            'message'=>'Transaction Cancelled. Please try again',
                            'code'=>200,
                            'status'=>'success'
                        ]);

                    }else{
                        #send response
                        $authKey = "782a3998b8c705c6f6a650897f4f3403";
                        $mobileNumber = $userData->phone_number;
                        $senderId = "RUJOAL";
                        $message = "Your order" .$request->order_id. " is confirmed! Thank you for placing the order with RUJOOAL. Please track your order at.  http://bitly.com/2W45qvG ";
                        $route = "4";
                        //Prepare you post parameters
                        $postData = array(
                            'authkey' => $authKey,
                            'mobiles' => $mobileNumber,
                            'message' => $message,
                            'sender'  => $senderId,
                            'route'   => $route
                        );
                        //API URL
                        $url = "http://sms.bulksmsserviceproviders.com/api/send_http.php";
                        // init the resource
                        $ch = curl_init();
                        curl_setopt_array($ch, array(
                            CURLOPT_URL => $url,
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_POST => true,
                            CURLOPT_POSTFIELDS => $postData
                            //,CURLOPT_FOLLOWLOCATION => true
                        ));
                        //Ignore SSL certificate verification
                        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                        //get response
                        $output = curl_exec($ch);
                        //Print error if any
                        if (curl_errno($ch)) {
                            return response()->json([
                                'message'=>curl_error($ch)."sms did not send but all operation has been successful",
                                'status' =>'error'
                            ]);
                        }
                        curl_close($ch); 
                        return response()->json([
                            'message'=>'Transaction successfully added.',
                            'code'=>200,
                            'status'=>'success'
                        ]);

                    }
                    #send response
                    // $message = "http://api.smscountry.com/SMSCwebservice_bulk.aspx?User=upharfinvest&passwd=Uphar@1074&mobilenumber=9568083266&message=Forget%20password%20request%20for%20id%20:%20".$request['email']."%20has%20been%20requested.%20Please%20provide%20this%20new%20password%20".$stringcode."%20for%20login.&sid=smscntry&mtype=N&DR=Y";
                    // $ch = curl_init($message);
                    // $response = curl_exec($ch);
                        return response()->json([
                            'message'=>'Transaction successfully added.',
                            'code'=>200,
                            'status'=>'success'
                        ]);
                }else{
                    return response()->json([
                        'message'=>'Transaction not saved yet. Please try again later',
                        'status' =>'error'
                    ]);  
                }
            }else{
                return response()->json([
                    'message'=>'Please provide data',
                    'status' =>'error'
                ]);
            }
        }catch(\Exception $e){
            return response()->json([
                'message'=>'Something went wrong. Please contact administrator.'.$e->getMessage(),
                'status' =>'error'
            ]);
        }
    }
    #list of all promocodes
    public function allPromocodes(Request $request){
        try{
            $promocodes = PromoCodes::all();
            if(!empty($promocodes)){
                #send response
                return response()->json([
                    'message'=>'There is no text of discount_in key so you have to implement 1 for rs and 2 for %.',
                    'data'=>$promocodes,
                    'code'=>200,
                    'status'=>'success'
                ]); 
            }else{
                return response()->json([
                    'message'=>"Promo Codes not found in the database",
                    'status'=>'error'
                ]);
            }
        }catch(\Exception $e){
            return response()->json([
                'message'=>'Something went wrong. Please contact administrator.'.$e->getMessage(),
                'status' =>'error'
            ]);
        }
    }
    #old Transactions
    public function oldTransactions(Request $request){
        try{
            if(!empty($request->user_id)){
                $response['usertransections'] = UserTransactions::where('user_id',$request->user_id)->get();
                if($response['usertransections']){
                    #send response
                    return response()->json([
                        'message'=>'All transections of this user.',
                        'code'=>200,
                        'data'=>$response,
                        'status'=>'success'
                    ]);
                }else{
                    return response()->json([
                        'message' => 'Transections not found of this user',
                        'status' => 'error'
                    ]);
                }
            }else{
                return response()->json([
                    'message' => 'Please provide user id',
                    'status' => 'error'
                ]);
            }
        }catch(\Exception $e){
            return response()->json([
                'message'=>'Something went wrong. Please contact administrator.'.$e->getMessage(),
                'status' =>'error'
            ]);
        }
    }
    #apply promo code
    public function applyPromoCode(Request $request){
        try{
            if(!empty($request->promo_id)){
                $promoCode = PromoCodes::where('id',$request->promo_id)->first();
                if(!empty($promoCode)){
                    $response['promoCode'] = $promoCode; 
                    return response()->json([
                        'message' => '1 for rs and 2 for %',
                        'code'=>200,
                        'data'=> $response,
                        'status' => 'success'
                    ]); 
                }else{
                    return response()->json([
                        'message' => 'Invalid Promocode',
                        'status' => 'error'
                    ]);
                }
            }else{
                return response()->json([
                    'message' => 'Please provide amount and promocode id',
                    'status' => 'error'
                ]);
            }
        }catch(\Exception $e){
            return response()->json([
                'message'=>'Something went wrong. Please contact administrator.'.$e->getMessage(),
                'status' =>'error'
            ]);
        }
    }
    #get delivery status
    public function getDeliveryStatus(Request $request){
        try{
            $grandTotal = [];
            $addition = 0;
            $getUserProduct = []; 
            $product_id = [];
            if(!empty($request->user_id)){
                $delivery_status = UserTransactions::where('user_id',$request->user_id)->get();
            
                if(!empty($delivery_status)){
                    $response['delivery_status'] = $delivery_status; 
                    $user_transactions = UserTransactions::where('user_id',$request->user_id)
                                                          ->where('status','Success')
                                                          ->get();
                    #get user's products
                    if(!empty($user_transactions)){
                        for($i=0; $i<count($user_transactions); $i++){
                            $product_id = json_decode($delivery_status[$i]['product_id']);
                            for($j=0; $j<count($product_id);$j++){
                            //    echo $product_id[$j];
                                $product = Products::where('id',$product_id[$j])->get();
                                if($product != NULL){
                                    array_push($getUserProduct,$product);
                                }                                
                            }
                        }
                        if(!empty($getUserProduct)){
                            $response['user_products'] =  $getUserProduct;
                            return response()->json([
                                'message' => 'All delivery status of particualr user',
                                'code'=>200,
                                'data'=> $response,
                                'status' => 'success'
                            ]); 
                        }else{
                            return response()->json([
                                'message' => 'data not found with products.',
                                'status' => 'error'
                            ]);
                        }
                    }else{
                        return response()->json([
                            'message' => 'data not found with total amount.',
                            'status' => 'error'
                        ]);
                    } 
                }else{
                    return response()->json([
                        'message' => 'data not found.',
                        'status' => 'error'
                    ]);
                }
            }else{
                return response()->json([
                    'message' => 'Please provide user_id',
                    'status' => 'error'
                ]);
            }
        }catch(\Exception $e){
            return response()->json([
                'message'=>'Something went wrong. Please contact administrator.'.$e->getMessage(),
                'status' =>'error'
            ]);
        }
    }
    #get data for posters
    public function getDescountProducts(Request $request){
        try{
            $brand_products =[];
            $cat_products =[];
            if(!empty($request->brand_name)){
                $brands = Brands::where('brand_name',$request->brand_name)->get();
                for($i=0; $i<count($brands); $i++){
                    $brand_id = $brands[$i]['id'];
                    $products = Products::where('brand_id',$brand_id)->get();                           
                    if($products != NULL){
                        array_push($brand_products,$products);
                    }
                }
                $response['base_url'] = "http://www.projects.estateahead.com/stock_inventory_mgt/storage/app/public/";
                if(!empty($brand_products)){
                    #send response
                    return response()->json([
                        'message'=>'All brands Products',
                        'code'=>200,
                        'data'=>$brand_products,
                        'status'=>'success'
                    ]);
                }else{
                    return response()->json([
                        'message'=>"no Products found with this brand name",
                        'status'=>'error'
                    ]);
                }
            }elseif(!empty($request->category_name)){
                $categories = Category::where('categories',$request->category_name)->get();
                for($i=0; $i<count($categories); $i++){
                    $cat_id = $categories[$i]['id'];
                    $products = Products::where('cat_id',$cat_id)->get();                           
                    if($products != NULL){
                        array_push($cat_products,$products);
                    }
                }
                $response['base_url'] = "http://www.projects.estateahead.com/stock_inventory_mgt/storage/app/public/";
                if(!empty($cat_products)){
                    #send response
                    return response()->json([
                        'message'=>'All categories Products',
                        'code'=>200,
                        'data'=>$cat_products,
                        'status'=>'success'
                    ]);
                }else{
                    return response()->json([
                        'message'=>"no Products found with this brand name",
                        'status'=>'error'
                    ]);
                }

            }else{
                return response()->json([
                    'message' => 'Provide atleast one name category or brand.',
                    'status' => 'error'
                ]);

            }

        }catch(\Exception $e){
            return response()->json([
                'message'=>'Something went wrong. Please contact administrator.'.$e->getMessage(),
                'status' =>'error'
            ]);
        }

    }
    #generate referal code
    public function addReferalCode(Request $request){
        try{
            if(!empty($request->user_id)){
                $model = new ReferalCode();
                $model->user_id      = $request->user_id;
                $model->referal_code =  "";
                $model->redmeed_id   =  $request->redmeed_id;
                $model->delete_status = '1';
                $model->created_at = date('Y-m-d');
                $model->save();
                if($model->id){
                    $referal_code = "RUJ-ID".$request->user_id."-".rand(10000,20000);
                    $returnData = ReferalCode::where('id',$model->id)->update([
                        'referal_code' => $referal_code,
                    ]);
                    if($returnData){
                        #send response
                        return response()->json([
                            'message'=>'new referal code for this user',
                            'code'=>200,
                            'data'=>$referal_code,
                            'status'=>'success'
                        ]);
                    }else{
                        return response()->json([
                            'message'=>'Something went wrong.Please contact to administrator.',
                            'status' =>'error'
                        ]);
                    }
                }else{
                    return response()->json([
                        'message'=>'Referal code is not inserted yet.Please contact to administrator.',
                        'status' =>'error'
                    ]);
                }  
            }else{
                return response()->json([
                    'message'=>'please provide the user id',
                    'status' =>'error'
                ]);
            }
        }catch(\Exception $e){
            return response()->json([
                'message'=>'Something went wrong. Please contact administrator.'.$e->getMessage(),
                'status' =>'error'
            ]);
        }
    }
    #insert redemed data
    public function addRedemeedData(Request $request){
        try{
            if(!empty($request->redemeed_id) && !empty($request->referal_code)){
                 
                $findReferalCode = ReferalCode::where('referal_code',$request->referal_code)->first();
                //$findRdmdId = ReferalCode::where('redmeed_id',$request->redemeed_id)->first();
               // print_r($findReferalCode['redmeed_id']);die;

				#check redmeed id is exist ot not
                if(($findReferalCode['redmeed_id'] != $request->redemeed_id) && ($findReferalCode['user_id'] != $request->redemeed_id)){
                         
                    if(empty($findReferalCode->redmeed_id)){
                        #inseert redmeed if
                        $returnData = ReferalCode::where('referal_code',$request->referal_code)->update([
                            'redmeed_id'=> $request->redemeed_id,
                            'updated_at'=> date('Y-m-d')
                        ]);
                        if($returnData){
                            #add data in wallet
                            $model = new Wallet();
                            $model->user_id = $findReferalCode->user_id;
                            $model->redmeed_id = $request->redemeed_id;
                            $model->amount  = 20;
                            $model->method  = "by referal";
                            $model->transaction_type = "Credit";
                            $model->created_at = date('Y-m-d');
                            $model->save();
                            if($model->id){
                                $appUser = Appusers::where('id',$findReferalCode->user_id)->first();
                                #send notification for update wallet balance
                                //Your authentication key
                                $authKey = "782a3998b8c705c6f6a650897f4f3403";
                                //Multiple mobiles numbers separated by comma
                                $mobileNumber = $appUser->phone_number;
                                //Sender ID,While using route4 sender id should be 6 characters long.
                                $senderId = "REPAIR";
                                //Your message to send, Add URL encoding here.
                                $message = "Congratulation! 20Rs credited in your wallet check now: http://bit.ly/2J7Zdw4";
                                //Define route 
                                $route = "4";
                                //Prepare you post parameters
                                $postData = array(
                                    'authkey' => $authKey,
                                    'mobiles' => $mobileNumber,
                                    'message' => $message,
                                    'sender'  => $senderId,
                                    'route'   => $route
                                );
                                //API URL
                                $url = "http://sms.bulksmsserviceproviders.com/api/send_http.php";
                                // init the resource
                                $ch = curl_init();
                                curl_setopt_array($ch, array(
                                    CURLOPT_URL => $url,
                                    CURLOPT_RETURNTRANSFER => true,
                                    CURLOPT_POST => true,
                                    CURLOPT_POSTFIELDS => $postData
                                    //,CURLOPT_FOLLOWLOCATION => true
                                ));
                                //Ignore SSL certificate verification
                                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                                //get response
                                $output = curl_exec($ch);
                                //Print error if any
                                if (curl_errno($ch)) {
                                    return response()->json([
                                        'message'=>curl_error($ch)."sms did not send but all operation has been successful",
                                        'status' =>'error'
                                    ]);
                                }
                                curl_close($ch);
                                #send response
                                return response()->json([
                                    'message'=>'add money in the wallet also update redmeed_id',
                                    'code'=>200,
                                    'status'=>'success'
                                ]);
                            }else{
                                return response()->json([
                                    'message'=>'updated redmeed id but not saved data in wallet.Pease Contact to administrator',
                                    'status' =>'error'
                                ]);
                            }
                        }else{
                            return response()->json([
                                'message'=>'Something went wrong.Please try again',
                                'status' =>'error'
                            ]);
                        } 
                    }else{
                        return response()->json([
                            'message'=>'Referal code already used.',
                            'status' =>'error'
                        ]);
                    }
                }else{
                    return response()->json([
                        'message'=>'You cant apply more than one time and also can not apply same user',
                        'status' =>'error'
                    ]);
                }
            }else{
                return response()->json([
                    'message'=>'please provide the redemeed id and referal code.',
                    'status' =>'error'
                ]);
            }
        }catch(\Exception $e){
            return response()->json([
                'message'=>'Something went wrong. Please contact administrator.'.$e->getMessage(),
                'status' =>'error'
            ]);
        }
    }
    #get all amount of wallet for particular id
    public function getAllWalletAmount(Request $request){
        try{
            $appUsers = [];
            if(!empty($request->user_id)){
                $walletData = Wallet::where('user_id',$request->user_id)->get();
                for($i=0; $i<count($walletData); $i++){
                    $userId = $walletData[$i]['redmeed_id'];
                    $userData = Appusers::where('id',$userId)->get();                          
                    if($userData != NULL){
                        array_push($appUsers,$userData);
                    }
                }
                $response['walletData'] = $walletData;
                $response['redmeedUsers'] = $appUsers;
                if(count($walletData)!= 0 && count($walletData)!= 0 ){
                    #send response
                    return response()->json([
                        'message'=>'Wallet',
                        'code'=>200,
                        'data'=>$response,
                        'status'=>'success'
                    ]);
                }else{
                    return response()->json([
                        'message'=>'Provide user id first',
                        'status' =>'error'
                    ]);
                }
            }else{
                return response()->json([
                    'message'=>'Provide user id first',
                    'status' =>'error'
                ]);
            }
        }catch(\Exception $e){
            return response()->json([
                'message'=>'Something went wrong. Please contact administrator.'.$e->getMessage(),
                'status' =>'error'
            ]);
        }
    }
}
