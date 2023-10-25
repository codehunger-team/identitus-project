<?php

namespace Codehunger\Blog\Traits;

use App\UserAgentParser\UserAgentParser;
use Codehunger\Blog\Entities\Knowledgebase;
use Codehunger\Blog\Entities\KnowledgebaseReaction;

trait ReactionTrait {
    /*
    |
    |
    |
    | This Trais is used to Handle the Reactions Data
    |
    |
    |
    */


    /**
     * This functin is used to process the request of Reaction
     * @param Request
     * @return Void
     */

    public function registerReaction($request)
    {
        $duplicateReaction = $this->checkIfReactionExistsBySession($request);
        if($duplicateReaction){
            $this->storeOrUpdateReaction($request, $duplicateReaction);
        }else{
            $this->storeOrUpdateReaction($request);
        }
        return true;
    }

    /**
     * This function is used to check if the Reaction already exists from a particular session
     * If reaction Exists, It returns True else False
     * @param Request
     * @return Boolean
     */

    public function checkIfReactionExistsBySession($request)
    {
        $duplicateReaction = KnowledgebaseReaction::where([
            'knowledgebase_id' => $request->id,
            'browser_user_agent_id' => UserAgentParser::parseUserAgent(request()->server('HTTP_USER_AGENT')),
            'session_token' => session()->get('_token')
        ])->first();

        if($duplicateReaction){
            return $duplicateReaction;
        }

        return false;
    }

    /**
     * Register Reaction according to like/dislike
     * If Reaction Exists, it removes the previous reaction if reaction is same
     * Else, it updates the reaction
     */

    public function storeOrUpdateReaction($request, $duplicateReaction = null)
    {
        if($duplicateReaction != null){
            if($request->reaction == $duplicateReaction['reaction']){
                $duplicateReaction->delete();
            }else{
                $duplicateReaction->update([
                    'reaction' => $request->reaction,
                ]);
            }
            return true;
        }
        KnowledgebaseReaction::create([
            'knowledgebase_id' => $request->id,
            'reaction' => $request->reaction,
            'session_token' => session()->get('_token'),
            'ip_address' => $request->ip(),
            'browser_user_agent_id' => UserAgentParser::parseUserAgent(request()->server('HTTP_USER_AGENT'))
        ]);
        return true;
    }

    /**
     * This function is used to return the Reactions Stats
     * @param Knowledgebase_ID
     * @return Array
     */

    public function getReactions($knowledgebaseId)
    {
        $knowledgebase = Knowledgebase::findOrFail($knowledgebaseId);
        $reactions = [
            'likes' => $knowledgebase->getLikes(),
            'dislikes' => $knowledgebase->getDislikes(),
        ];
        return $reactions;
    }
}