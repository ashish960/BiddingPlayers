<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Playerdata;
use App\Models\Playerbidding;
use App\Models\Teamdata;
use Illuminate\Support\Facades\Validator;  
use Illuminate\Support\Facades\DB;   
use Illuminate\Support\Facades\hash;    

class Biddingcontroller extends Controller
{



    //adminlogin


       //to login admin via generated token.
   public function Adminlogin(Request $request){
   echo "hello";
   }

   //to add player
 
   public function AddPlayer(Request $request){

    
    $validator =Validator::make($request->all(),[
            'Player_Name'=>['required','string'],
            'Player_No'=>['required|numeric|unique'],
            'Player_Age'=>['required','numeric'],
            'Player_MinBid_Price'=>['required','numeric','in:2'],
            'Player_CBidPrice_Price'=>['required','numeric','in:0'],
            'Player_Status'=>['required','numeric']
        
        ]);
       
        if($validator->fails()){
            return response()->json($validator->messages(),400);
        }
        else{
            $data=[
                'Player_Name' =>$request->playername,
                'Player_No' =>$request->playerno,
                'Player_Age' =>Hash::make($request->playerage),
                'Player_MinBid_Price' =>$request ->playerminprice,
                'Player_CBidPrice_Price' =>$request ->playermaxprice,
                'Player_Status' =>$request ->playerstatus,
                
              ];     
              DB::beginTransaction();
          try{
              Playerdata::create($data);
              DB::commit();
          }catch(\Exception $err){
              DB::rollBack();
              $data=null;
          }
          if($data != null){
            return response()->json([
                'message' => 'Player Register successfully'
            ],200);}
            else{
                return response()->json([
                    'message' => 'Internal server error',
                    'error_msg'=>$err->getMessage()
                ],500);
            }
          
              
        }

    }

   
//to add team in database
   public function AddTeam(Request $request){

    
    $validator =Validator::make($request->all(),[
            'team_name'=>['required','string'],
            'team_id'=>['required|numeric|unique'],
            'team_passkey'=>['required','numeric'],
            'team_size'=>['required','numeric','in:10'],
            'max_bid_size'=>['required','numeric','in:20'],
            'team_bid_size'=>['required','numeric'],
            'team_status'=>['required','in:0,1,2']
        
        ]);
       
        if($validator->fails()){
            return response()->json($validator->messages(),400);
        }
        else{
            $data=[
                'team_name' =>$request->team_name,
                'team_id' =>$request->team_id,
                'team_passkey' =>Hash::make($request->team_passkey),
                'team_size' =>$request ->team_size,
                'max_bid_size' =>$request ->max_bid_size,
                'team_bid_size' =>$request ->team_bid_size,
                'team_status' =>$request->team_status
              ];     
              DB::beginTransaction();
          try{
              Teamdata::create($data);
              DB::commit();
          }catch(\Exception $err){
              DB::rollBack();
              $data=null;
          }
          if($data != null){
            return response()->json([
                'message' => 'Team Register successfully'
            ],200);}
            else{
                return response()->json([
                    'message' => 'Internal server error',
                    'error_msg'=>$err->getMessage()
                ],500);
            }
          
              
        }

    }


    //bidding process




    //view active player
    public function playerview(){
    
    
        $playerdata =Playerdata::where('Player_Status'== 1)->first();           
             if(is_null($playerdata)){
                $response=[
                    'message'=> 'Biddding doest start right now',
                    'status'=>0,                     
                
                ];
               
             }
             else{
                $response=[
                    'message' =>'Player found',
                    'status' =>1,
                    'data'=> $playerdata
                ];
             }
             return response()-> json($response,200);
        }



     //setplayer bid
     public function setplayerbid(){

        $validator =Validator::make($request->all(),[
            'Player_Name'=>['required','string'],
            'Player_No'=>['required|numeric|unique'],
            'Team_Name'=>['required','numeric'],
            'Team_No'=>['required|numeric|unique'],
            
        ]);
       
        if($validator->fails()){
            return response()->json($validator->messages(),400);
        }
        else{
            $data=[
                'Player_Name' =>$request->team_name,
                'Player_No' =>$request->team_id,
                'Team_Name' =>Hash::make($request->team_passkey),
                'Team_Np' =>$request ->team_size,
                'Bid_Price' =>$request ->max_bid_size,
                
              ];     
              DB::beginTransaction();
          try{
              Playerbidding::create($data);
              DB::commit();
          }catch(\Exception $err){
              DB::rollBack();
              $data=null;
          }
          if($data != null){
            return response()->json([
                'message' => 'Bidister successfully'
            ],200);}
            else{
                return response()->json([
                    'message' => 'Internal server error',
                    'error_msg'=>$err->getMessage()
                ],500);
            }
          
              
        }

           
     }

    }
    

   
























   


   

