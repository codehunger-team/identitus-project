<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dns;

class DnsController extends Controller
{
     //set Dns
     public function set_dns($domainId)
     {   
         $dns = Dns::where('domain_id',$domainId)->first();
         return view('admin.dns.dns',compact('domainId','dns'));
     }
 
     //view Dns
     public function view_dns($domainId)
     {   
         $dns = Dns::where('domain_id',$domainId)->first();
         return view('admin.dns.view-dns',compact('domainId','dns'));
     }
 
     //store Dns
     public function store_dns(Request $request)
     {   
         $data = $request->except('_token');
         $data['user_id'] = NULL;
         
         $isDomain = Dns::where('domain_id',$request->domain_id)->first();
         if(isset($isDomain)) {
             Dns::where('domain_id',$request->domain_id)->update($data);  
             return back()->with('msg', 'Dns updated successfully');     
         } else {
             Dns::create($data); 
             return back()->with('msg', 'Dns added successfully');
         }
         
     }
}
