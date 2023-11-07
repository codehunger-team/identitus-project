<?php

namespace Codehunger\Blog\Traits;

use Codehunger\Blog\Entities\Knowledgebase;
use App\UserAgentParser\UserAgentParser;

trait ViewsCounterTrait {
    /*
    |
    |
    |
    | This Trais is used to Handle the Views Counter
    |
    |
    |
    */


    /**
     * This function is used to register a view
     * @param Request
     * @return Void
     */

    public function registerView($knowledgebaseId)
    {
        $knowledgebase = Knowledgebase::findOrFail($knowledgebaseId);

        // If Duplicate Exists, Increment Hit by 1

        $checkForDuplicate = $this->checkDuplicateView($knowledgebase);
        if($checkForDuplicate){
            $checkForDuplicate->update([
                'hits' => $checkForDuplicate['hits'] + 1,
            ]);
            return true;
        }

        // Else Create New Entry

        $knowledgebase->views()->create([
            'browser_user_agent_id' => UserAgentParser::parseUserAgent(request()->server('HTTP_USER_AGENT')),
            'session_token' => session()->get('_token'),
            'hits' => 1,
        ]);
        return true;
    }

    /**
     * Check if Duplicate View on a single Resource
     */

    public function checkDuplicateView($knowledgebase)
    {
        return $knowledgebase->views()->where([
            'browser_user_agent_id' => UserAgentParser::parseUserAgent(request()->server('HTTP_USER_AGENT')),
            'session_token' => session()->get('_token')
        ])->first();
    }
}