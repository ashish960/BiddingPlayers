<?php 

Namespace App\services;
use App\Models\Playerdata;
use App\Models\Playerbidding;
use App\Models\Teamdata;
use App\Models\User;
use App\Models\Gamesizing;

class playerBidStatus{
    public static function playerStatus(){
        
            $teamAllot= Playerbidding::where('Player_No', 'like', $playerId)->where(['Game_Id'=>$request['game_id']])->where(['Bid_Price'=>$maxBid])->first();
            $maxPlayerNo=Gamesizing::where(['Game_Id'=>$request['game_id']])->first();
            if($playerId == $maxPlayerNo['Player_Size']){
                
                $nextPlayerId = 1;
              }
              else{
                $nextPlayerId=$playerId + 1;
              }
    
            $playerData2 = Playerdata::where(['Player_Game_Id'=>$request['game_id']])->where(['Player_No'=>$nextPlayerId])->first(); 
            if( $nextPlayerId == 1){
                $playerData2->Player_Status = 2;
               }
               else{
                $playerData2->Player_Status = 1;
               }
    
            DB::beginTransaction();
            try{
                //update data in data base.
                $playerData->Player_CurrentBidPrice_Price = $maxBid;
                $playerData->Player_Status = 2;
                $playerData->Team_Allot= $teamAllot['Team_Id'];
                $playerData->save();
                $playerData2->save();
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
                  $updateFirstTeam =Teamdata::where(['Team_Game_Id'=>$request['game_id']])->where(['Team_Id'=> 1])->first();
                  DB::beginTransaction();
                  try{
                      
                      $updateFirstTeam->Team_Status = 1;
                      $updateTeamData =  Teamdata::where(['Team_Game_Id'=>$request['game_id'],'Team_Status'=> 2])->where('Team_Id', '!=', 1)->update(['Team_Status' => 0]);
                      $updateFirstTeam->save();
                    
                      DB::commit();
      
                    }catch(\Exception $err){
                          DB::rollBack();
                          $playerData=null;
                          $playerData2= null;
                  }

                return response()->json([
                    'status' => 1,
                    'message'=> 'user data updated successfully'
                ],200);                    
            }
           
        



        return[

        ];
    }
}

