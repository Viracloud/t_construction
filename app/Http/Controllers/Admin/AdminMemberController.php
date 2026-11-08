<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\MemberSkill;
use App\Models\MemberAward;

class AdminMemberController extends Controller
{
    public function index()
    {
        $members = Member::orderBy('id','asc')->get();
        return view('admin.member.index',compact('members'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'name' => 'required|string|max:255',
            'slug' => 'required|alpha_dash|unique:members,slug',
            'designation' => 'required|string',
            'short_description' => 'required|string',
            'description' => 'required|string',
        ]);

        $obj = new Member();
        if($request->hasFile('image')) {
            $final_name = 'member_image_'.time().'.'.$request->image->extension();
            $request->image->move(public_path('uploads'), $final_name);
            \App\Support\ImageOptimizer::optimize(public_path('uploads/'.$final_name));
            $obj->image = $final_name;
        }
        $obj->name = $request->name;
        $obj->slug = $request->slug;
        $obj->seo_title = filled($request->seo_title) ? mb_substr(trim($request->seo_title), 0, 255) : null;
        $obj->seo_meta_description = filled($request->seo_meta_description) ? trim($request->seo_meta_description) : null;
        $obj->designation = $request->designation;
        $obj->short_description = $request->short_description;
        $obj->description = $request->description;
        $obj->show_on_home = $request->show_on_home;
        $obj->phone = $request->phone;
        $obj->email = $request->email;
        $obj->experience = $request->experience;
        $obj->facebook = $request->facebook;
        $obj->twitter = $request->twitter;
        $obj->linkedin = $request->linkedin;
        $obj->instagram = $request->instagram;
        $obj->save();

        return redirect()->back()->with('success', 'Item created successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|alpha_dash|unique:members,slug,'.$id,
            'designation' => 'required|string',
            'short_description' => 'required|string',
            'description' => 'required|string',
        ]);

        $obj = Member::where('id', $id)->first();
        if($request->hasFile('image')) {
            $request->validate([
                'image' => 'mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $final_name = 'member_image_'.time().'.'.$request->image->extension();
            if($obj->image && file_exists(public_path('uploads/'.$obj->image))) {
                unlink(public_path('uploads/'.$obj->image));
            }
            $request->image->move(public_path('uploads'), $final_name);
            \App\Support\ImageOptimizer::optimize(public_path('uploads/'.$final_name));
            $obj->image = $final_name;
        }
        $obj->name = $request->name;
        $obj->slug = $request->slug;
        $obj->seo_title = filled($request->seo_title) ? mb_substr(trim($request->seo_title), 0, 255) : null;
        $obj->seo_meta_description = filled($request->seo_meta_description) ? trim($request->seo_meta_description) : null;
        $obj->designation = $request->designation;
        $obj->short_description = $request->short_description;
        $obj->description = $request->description;
        $obj->show_on_home = $request->show_on_home;
        $obj->phone = $request->phone;
        $obj->email = $request->email;
        $obj->experience = $request->experience;
        $obj->facebook = $request->facebook;
        $obj->twitter = $request->twitter;
        $obj->linkedin = $request->linkedin;
        $obj->instagram = $request->instagram;
        $obj->save();

        return redirect()->back()->with('success', 'Item updated successfully.');
    }

    public function delete($id)
    {

        MemberSkill::where('member_id', $id)->delete();
        $all_awards = MemberAward::where('member_id', $id)->get();
        foreach($all_awards as $award) {
            if($award->photo && file_exists(public_path('uploads/'.$award->photo))) {
                unlink(public_path('uploads/'.$award->photo));
            }
        }
        MemberAward::where('member_id', $id)->delete();

        $obj = Member::where('id', $id)->first();
        if($obj->image && file_exists(public_path('uploads/'.$obj->image))) {
            unlink(public_path('uploads/'.$obj->image));
        }
        $obj->delete();

        return redirect()->back()->with('success', 'Item deleted successfully.');
    }

    public function skills($member_id)
    {
        $member = Member::where('id', $member_id)->first();
        $member_skills = MemberSkill::where('member_id', $member_id)->get();
        return view('admin.member.skill', compact('member_skills', 'member'));
    }

    public function skill_store(Request $request, $member_id)
    {
        $request->validate([
            'name' => 'required|string',
            'percentage' => 'required|string',
        ]);

        $obj = new MemberSkill();
        $obj->member_id = $member_id;
        $obj->name = $request->name;
        $obj->percentage = $request->percentage;
        $obj->save();

        return redirect()->back()->with('success', 'Item created successfully.');
    }

    public function skill_update(Request $request, $skill_id)
    {
        $request->validate([
            'name' => 'required|string',
            'percentage' => 'required|string',
        ]);

        $obj = MemberSkill::where('id', $skill_id)->first();
        $obj->name = $request->name;
        $obj->percentage = $request->percentage;
        $obj->save();

        return redirect()->back()->with('success', 'Item updated successfully.');
    }

    public function skill_delete(Request $request, $skill_id)
    {
        $obj = MemberSkill::where('id', $skill_id)->first();
        $obj->delete();

        return redirect()->back()->with('success', 'Item deleted successfully.');
    }


    public function awards($member_id)
    {
        $member = Member::where('id', $member_id)->first();
        $member_awards = MemberAward::where('member_id', $member_id)->get();
        return view('admin.member.award', compact('member_awards', 'member'));
    }

    public function award_store(Request $request, $member_id)
    {
        $request->validate([
            'name' => 'required|string',
            'photo' => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $obj = new MemberAward();

        if($request->hasFile('photo')) {
            $final_name = 'member_award_photo_'.time().'.'.$request->photo->extension();
            $request->photo->move(public_path('uploads'), $final_name);
            \App\Support\ImageOptimizer::optimize(public_path('uploads/'.$final_name));
            $obj->photo = $final_name;
        }

        $obj->member_id = $member_id;
        $obj->name = $request->name;
        $obj->save();

        return redirect()->back()->with('success', 'Item created successfully.');
    }

    public function award_update(Request $request, $award_id)
    {
        $request->validate([
            'name' => 'required|string',
        ]);

        $obj = MemberAward::where('id', $award_id)->first();

        if($request->hasFile('photo')) {
            $request->validate([
                'photo' => 'mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $final_name = 'member_award_photo_'.time().'.'.$request->photo->extension();
            if($obj->photo && file_exists(public_path('uploads/'.$obj->photo))) {
                unlink(public_path('uploads/'.$obj->photo));
            }
            $request->photo->move(public_path('uploads'), $final_name);
            \App\Support\ImageOptimizer::optimize(public_path('uploads/'.$final_name));
            $obj->photo = $final_name;
        }

        $obj->name = $request->name;
        $obj->save();

        return redirect()->back()->with('success', 'Item updated successfully.');
    }

    public function award_delete(Request $request, $award_id)
    {
        $obj = MemberAward::where('id', $award_id)->first();
        if($obj->photo && file_exists(public_path('uploads/'.$obj->photo))) {
            unlink(public_path('uploads/'.$obj->photo));
        }
        $obj->delete();

        return redirect()->back()->with('success', 'Item deleted successfully.');
    }
}
