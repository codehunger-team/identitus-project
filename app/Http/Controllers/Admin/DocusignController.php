<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Option;

class DocusignController extends Controller
{
    public function index()
    {
        return view('admin.docusign.index');
    }

    public function connect()
    {   
        try{
            $params = [
                'response_type' => 'code',
                'scope' => 'signature',
                'client_id' => Option::get_option('docusign_client_id'),
                'state' => 'a39fh23hnf23',
                'redirect_uri' => route('admin.docusign.callback'),
            ];
            $queryBuild = http_build_query($params);
            
            $url = "https://account-d.docusign.com/oauth/auth?";
    
            $botUrl = $url . $queryBuild;
            
            return redirect()->to($botUrl);
        } catch(Exception $e) {
            return redirect()->back()->with('error', 'Something Went wrong !');
        }
       
    }

    public function callback(Request $request)
    {
        $code = $request->code;

        if(empty(Option::get_option('docusign_auth_code'))) {
            Option::Create(
                [
                    'name' => 'docusign_auth_code',
                    'value' => $code,
                ],
            );
        }
        
        return redirect()->route('admin.docusign')->with('msg', 'Docusign Succesfully Connected');
    }
}
