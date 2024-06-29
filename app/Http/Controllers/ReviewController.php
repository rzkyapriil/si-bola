<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'pemesanan_id' => ['required', 'numeric'],
                'komentar' => ['required', 'string'],
            ],
            [
                'required' => 'Input :attribute dibutuhkan.',
            ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator, 'review')->withInput();
        }

        $data = $validator->validated();

        $review = new Review();
        $review->pemesanan_id = $data['pemesanan_id'];
        $review->komentar = $data['komentar'];
        $review->save();

        Session::flash("message", "Komentar atau Kritik berhasil dikirim!");
        Session::flash("alert", "success");
        return redirect()->back();
    }
}
