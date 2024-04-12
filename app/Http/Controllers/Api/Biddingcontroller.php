<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Requests\setGame;
use App\Http\Requests\addPlayer;
use App\Http\Requests\addTeam;
use App\Http\Requests\adminLogin;
use App\Http\Requests\teamLogin;
use App\Http\Requests\setPlayerBid;
use App\Http\Requests\adminAllotTeam;
use App\Http\Requests\activePlayerViews;
use App\Http\Requests\startBid;


use App\Models\Playerdata;
use App\Models\Playerbidding;
use App\Models\Teamdata;
use App\Models\User;
use App\Models\Gamesizing;

use Illuminate\Support\Facades\Validator;  
use Illuminate\Support\Facades\DB;   
use Illuminate\Support\Facades\hash;   

class Biddingcontroller extends Controller
{



//adminlogin
 //to login admin via generated token.
   public function AdminLogin(adminLogin $request){
        $user =User::where(['email'=>$request['email'],'password' => $request['password']])->first();
        $token = $user->createToken("auth_token",["Admin"])->accessToken;  //here admin is the scope of token 
        return response()->json(
            [
                'token' => $token,
                'user' => $user,
                'message' => 'Login successfully',
                'status' =>1
            ]
            );
   }


   //admin start bid
   public function StartBid(startBid $request){
    $gameData=Gamesizing::where(['game_id'=>$request['game_id']])->first();
                   
    try{
        $updateTeamStatus =Teamdata::where(['game_id'=>$request['game_id']])->where(['team_no'=> 1])->first()->update(['team_status' => 1]);
        $updatePlayerStatus =Playerdata::where(['game_id'=>$request['game_id']])->where(['player_no'=> 1])->first()->update(['player_status' => 1]);  
        $updateTeamData =  Teamdata::where(['game_id'=>$request['game_id']])->where('team_no', '!=', 1)->update(['team_status' => 0]);
        $updatePlayerData =  Playerdata::where(['game_id'=>$request['game_id']])->where('player_no', '!=', 1)->update(['player_status' => 0]);
       
      }catch(\Exception $err){
            $updateTeamStatus=null;
            $updatePlayerStatus= null;
            $updatePlayerData =null;
            $updateTeamData= null;
    }
    if($updateTeamStatus == null && $updateTeamStatus == null &&  $updatePlayerData &&  $updateTeamData ){
        return response()->json([
            'status' => 0,
            'message'=> 'Internal Server Error'
        ],500); 
    }else{

  return response()->json([
      'status' => 1,
      'message'=> 'Bidding Started successfully'
  ],200);                    
}
}


//To set game
   public function SetGame(setGame $request){
            $gameSet=[
                   'game_id'=>$request->game_id,
                   'game_name'=>$request->game_name,
                   'team_size'=>$request->team_size,
                   'player_size'=>$request->player_size
            ];
            try{
                Gamesizing::create($gameSet);  
            }catch(\Exception $err){
                
                $gameSet=null;
            }
            if($gameSet != null){
                return response()->json([
                    'message'=>'Game Created  Successfully',
                    'status' =>1
                ],200);
            }
            else{
                 return response()->json([
                    'message'=>'Internal Server Error',
                  //  'error_msg'=>$err->getMessage()
                 ],500);
            }  
   }

 
//to add player
   public function AddPlayer(addPlayer $request){
    $gameData=Gamesizing::where(['game_id'=>$request['game_id']])->first();
    $playerData = Playerdata::where(['game_id'=>$request['game_id']])->where(['player_no'=> $request['player_no']])->first();
    if($playerData == null){
    $playerSize=$gameData['player_size'];
    $playerNo=$request['player_no'];
    if($playerNo <= $playerSize){
            $data=[
                'player_name' =>$request->player_name,
                'player_no' =>$request->player_no,
                'Player_Age' =>$request->player_age,
                'player_min_bid_price' =>$request ->player_min_bid_price,
                'game_id'=>$request->game_id
              ];      
          try{
              Playerdata::create($data);   
          }catch(\Exception $err){
             
              $data=null;
          }
          if($data != null){
            return response()->json([
                'message' => 'Player Register successfully',
                'status' =>1
            ],200);}
            else{
                return response()->json([
                    'message' => 'Internal server error',
                    'status'=>0
                   // 'error_msg'=>$err->getMessage()
                ],500);
            }     
    }
    else{
        return response()->json([
            'message' => 'Player No Exceeds Beyond the Player limit for the game the player no should be between 1 to '.$playerSize ,
            'status'=>0
        ],400);
    }   
}
else{
    return response()->json([
        'message' => 'The given player no is already exists',
        'status'=>0
    ],400);
}  
        }

    

//to add team in database

   public function AddTeam(addTeam $request){
    $gameData=Gamesizing::where(['game_id'=>$request['game_id']])->first();
    $teamData = Teamdata::where(['game_id'=>$request['game_id']])->where(['team_no'=> $request['team_no']])->first();
    if($teamData==null){
        $teamSize=$gameData['team_size'];
        $teamId=$request['team_no'];
        if($teamId <= $teamSize){
            $data=[
                'team_name' =>$request->team_name,
                'team_no' =>$request->team_no,
                'team_password' =>Hash::make($request->team_password),
                'team_size' =>$request ->team_size,
                'team_max_bid_amount' =>$request ->team_max_bid_amount,
                'game_id'=>$request->game_id
              ];          
          try{
              Teamdata::create($data);   
          }catch(\Exception $err){
              $data=null;
          }
          if($data != null){
                    return response()->json([
                        'message' => 'Team Register successfully',
                        'status' =>1
                    ],200);}
                    else{
                        return response()->json([
                            'message' => 'Internal server error',
                            'status' =>0
                        ],500);
                  }       
        }
        else{
            return response()->json([
                'message' => 'Team No Exceeds Beyond the Team limit for the game the Team no should be between 1 to '.$teamSize ,
                'status' =>0
            ],400);
        }   
    }
    else{
            return response()->json([
                'message' => 'The given Team no is already exists',
            ],400);
        }  
    }


    
//bidding process

 //teamlogin
     public function TeamLogin(teamLogin $request){
        
          $TeamData =Teamdata::where(['team_name'=>$request['team_name']])->first();
          if($TeamData == null){
            return response()->json([
                'message'=>'User not found'
            ]);
          }else{
          $token = $TeamData->createToken("auth_token",["Team"])->accessToken;
          return response()->json(
            [
                'token' => $token,
                'user' => $TeamData,
                'message' => 'Team Login successfully',
                'status' =>1
            ]
            );
     }
    }



//view active player
    public function ActivePlayerView(activePlayerViews $request){
        $playerdata = Playerdata::where(['game_id'=>$request['game_id']])->where(['player_status'=> 1])->first();    
             if(is_null($playerdata)){
                $response=[
                    'message'=> 'Bidding doest start right now',
                    'status'=>1,                     
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
public function SetPlayerBid(setPlayerBid $request){
    $gameData=Gamesizing::where(['game_id'=>$request['game_id']])->first();
    if($gameData['team_size'] < $request['team_no']){
        return response()->json([
            'message'=>'Invalid team No : team no should be between 1 to '. $gameData['team_size'],
        ]);
    }
        $playerData=Playerdata::where(['player_status'=>1])->where(['game_id'=>$request['game_id']])->first();
        if($playerData['player_min_bid_price'] > $request['bid_price']){
            return response()->json([
                'message'=>'Invalid bid_price : Min Bid Price Should Be  '. $playerData['player_min_bid_price'],
            ]);

    }
        $teamData=Teamdata::where(['team_no'=>$request['team_no']])->where(['game_id'=>$request['game_id']])->first();  
        if($teamData['team_max_bid_amount'] < $request['bid_price']){
            return response()->json([
                'message'=>'Your,account doesnt have sufficient',
            ]);
        }


        if($teamData['team_status'] == 0){
            $response=[
                "message"=>"Sorry you are not able to bid yet",
            ];
            return response()->json($response,200);
        }
        elseif($teamData['team_status'] == 2){
            $response=[
                "message"=>"You are already bidded"
        ];
        return response()->json($response,200);
        }
        else{
            $interest= $request->interest;  
            if($interest == 'skip'){      //to skip the bid
                        try{
                            $maxTeamNo=Gamesizing::where(['game_id'=>$request['game_id']])->first();
                            if($teamData['team_no'] == $maxTeamNo['team_size']){
                                //code to alot team to player 
                                $nextTeamId = 1;
                              }
                              else{
                                $nextTeamId=$teamData['team_no'] + 1;
                              }
                           
                           $teamData2=Teamdata::where(['team_no'=>$nextTeamId])->where(['game_id'=>$request['game_id']])->first();
                           DB::beginTransaction();
                           $teamData->team_status = 2;

                           if( $nextTeamId == 1){
                            $teamData2->team_status = 2;
                           }
                           else{
                            $teamData2->team_status = 1;
                           }
                           
                           $teamData->save();
                           $teamData2->save();
                                DB::commit();
                        }catch(\Exception $err){
                            DB::rollBack();
                            $teamData=null;
                            $teamData2=null;
                        }
                        if(is_null($teamData && $teamData2)){
                            return response()->json([
                                'status' =>0,
                                'message' =>'internal server error',
                                //'error_msg'=>$err->getMessage()            
                            ],500);            
                        }else{
                            return response()->json([
                                'status' => 1,
                                'message'=> 'Bid skipped successfully'
                            ],200);                    
                        }
        
            }
            else{   //to set bidding
                  $teamData=Teamdata::where(['team_status'=>1])->where(['game_id'=>$request['game_id']])->first();
                 
                  $playerData=Playerdata::where(['player_status'=>1])->where(['game_id'=>$request['game_id']])->first();
                  $data=[
                      'player_name' =>$playerData->player_name,
                      'player_no' =>$playerData->player_no,
                      'team_name' =>$teamData->team_name,
                      'team_no' =>$teamData->team_no,
                      'game_id'=>$teamData->game_id,
                      'bid_price' =>$request->bid_price,
                      
                    ];     
                    DB::beginTransaction();
                  try{
                    Playerbidding::create($data);
                    $teamData=Teamdata::where(['team_status'=>1])->where(['game_id'=>$request['game_id']])->first();
                    $maxTeamNo=Gamesizing::where(['game_id'=>$request['game_id']])->first();
                    if($teamData['team_no'] == $maxTeamNo['team_size']){
                        $nextTeamId = 1;
                      }
                      else{
                        $nextTeamId=$teamData['team_no'] + 1;
                      }
                      $teamData2=Teamdata::where(['team_no'=>$nextTeamId])->where(['game_id'=>$request['game_id']])->first();
                      
                    
                      $teamData->team_status=2;
                      if($nextTeamId == 1){
                        $teamData2->team_status = 2;
                       }
                       else{
                        $teamData2->team_status = 1;
                       }
                     
                    
                      $teamData->save();
                      $teamData2->save();
                     
                    DB::commit();
                  }catch(\Exception $err){
                    DB::rollBack();
                    $data=null;
                    $teamData=null;
                    $teamData2=null;
                  }
                  if(is_null($teamData && $teamData2 && $data)){
                      return response()->json([
                          'status' =>0,
                          'message' =>'internal server error',
                          'error_msg'=>$err->getMessage()            
                      ],500);            
                  }else{
                           return response()->json([
                               'status' => 1,
                               'message'=> 'player bidding successfull'
                           ],200);                    
                       }
                  }                  
      }
 }





//select team acc to max bid
     public function SelectTeam(adminAllotTeam $request){
        $gameData=Gamesizing::where(['game_id'=>$request['game_id']])->first();
      
        $playerData=Playerdata::where(['game_id'=>$request['game_id']])->where(['player_status' => 1])->first();
        if($playerData['player_no'] != $request['player_no']){
         
            return response()->json([
                'message'=>'This player bid is not active yet',
            ]);

        }
        if($gameData['player_size'] < $request['player_no']){
            return response()->json([
                'message'=>'Invalid  Player No : Player no should be between 1 to '. $gameData['player_size'],
            ]);

        }

        $allTeamBid =Teamdata::where(['game_id'=>$request['game_id']])->distinct()->pluck('team_status')->count();
       
    if($allTeamBid == 1){   //to check if all team bidded successfully or not
        $playerData = Playerdata::where(['player_status'=> 1])->where(['game_id'=>$request['game_id']])->first(); 
        $playerId=$playerData->player_no;
        $maxBid = Playerbidding::where(['player_no'=> $request['player_no']])->where(['game_id'=>$request['game_id']])->max('bid_price');
       
        if($maxBid == null ){  //if player is remained unsold
            $maxPlayerNo=Gamesizing::where(['game_id'=>$request['game_id']])->first();
              
            if($playerId == $maxPlayerNo['player_size']){
                $nextPlayerId = 1;
              }
              else{
                $nextPlayerId=$playerId + 1;
              }
    
            $playerData2 = Playerdata::where(['game_id'=>$request['game_id']])->where(['player_no'=>$nextPlayerId])->first(); 
            
            if( $nextPlayerId == 1){
                $playerData2->player_status = 2;
               }
               else{
                $playerData2->player_status = 1;
               }
            try{
                //update data in data base.
                $playerData->player_status = 2;
                
                $playerData->save();
                $playerData2->save();
          
              }catch(\Exception $err){
                    $playerData=null;
                    $playerData2= null;
            }
            if($playerData == null && $playerData2 ==null){
                return response()->json([
                    'message' => 'Internal server error',
                ],500);
            }
            else{
                $updateFirstTeam =Teamdata::where(['game_id'=>$request['game_id']])->where(['team_no'=> 1])->first();
                try{
                    $updateFirstTeam->team_status = 1;
                    $updateTeamData =  Teamdata::where(['game_id'=>$request['game_id'],'team_status'=> 2])->where('team_no', '!=', 1)->update(['team_status' => 0]);
                    $updateFirstTeam->save();
                
                  }catch(\Exception $err){ 
                        $updateFirstTeam=null;
                        $updateTeamData= null;
                  }
                  if($playerData == null && $playerData2 ==null){
                    return response()->json([
                        'message' => 'Internal server error',
                    ],500);
                }
                 else{
                        return response()->json([
                            'status' => 1,
                            'message'=> 'team updated successfully'
                        ],200);  
                    }
                  
                }

                               
          }
            
            else{   //if player is bidded by any team
             
                $teamAllot= Playerbidding::where('player_no', 'like', $playerId)->where(['game_id'=>$request['game_id']])->where(['bid_price'=>$maxBid])->first();
               
                $maxPlayerNo=Gamesizing::where(['game_id'=>$request['game_id']])->first();
                $team=Teamdata::where(['game_id'=>$request['game_id']])->where(['team_no'=>$teamAllot['team_no']])->first();
                $remainingAmount=$team['team_max_bid_amount'] - $teamAllot['bid_price'];
    
               
                if($playerId == $maxPlayerNo['player_size']){
                    $nextPlayerId = 1;
                  }
                  else{
                    $nextPlayerId=$playerId + 1;
                  }
        
                $playerData2 = Playerdata::where(['game_id'=>$request['game_id']])->where(['player_no'=>$nextPlayerId])->first(); 
                
                if( $nextPlayerId == 1){
                    $playerData2->player_status = 2;
                   }
                   else{
                    $playerData2->player_status = 1;
                   }
        
                DB::beginTransaction();
                try{
                    //update data in data base.
                    $playerData->player_current_bid_price = $maxBid;
                    $playerData->player_status = 2;
                    $playerData->team_allot= $teamAllot['team_no'];
                    $team->team_max_bid_amount=$remainingAmount;
                    $playerData->save();
                    $playerData2->save();
                    $team->save();
                    DB::commit();
    
                  }catch(\Exception $err){
                        DB::rollBack();
                        $playerData=null;
                        $playerData2= null;
                }
                if(is_null($playerData && $playerData2)){
                    return response()->json([
                        'status' =>0,
                        'message' =>'internal server error',
                        'error_msg'=>$err->getMessage()            
                    ],500);            
                }else{
                    
                      $updateFirstTeam =Teamdata::where(['game_id'=>$request['game_id']])->where(['team_no'=> 1])->first();
                      try{
                          
                          $updateFirstTeam->team_status = 1;
                          $updateTeamData =  Teamdata::where(['game_id'=>$request['game_id'],'team_status'=> 2])->where('team_no', '!=', 1)->update(['team_status' => 0]);
                          $updateFirstTeam->save();
                        }catch(\Exception $err){
                              
                            $updateFirstTeam=null;
                            $updateTeamData= null;
                      }

                    return response()->json([
                        'status' => 1,
                        'message'=> 'Player updated successfully'
                    ],200);                    
                }
               
            }
    
    }
    else{
        return response()-> json([
            'message'=>'Bidding process is not finished yet'
        ]);
    }
     }   
    }
    

   
























   


   

