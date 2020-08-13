<?php

namespace App\Http\Controllers;
use App\Diary;
use App\Http\Requests\CreateDiary; // 追加
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DiaryController extends Controller
{
    public function index() {
        // $diaries = Diary::all();
        $diaries = Diary::orderBy('id', 'desc')->get();
        return view('diaries.index', ['diaries' => $diaries]);

        // return view('diaries.index', compact('diaries'));
    }
    public function create() {
        return view('diaries.create');
    }
    public function store(CreateDiary $request)
    {
        // dd($request->title);

        $diary = new Diary(); //Diaryモデルをインスタンス化

        $diary->title = $request->title; //画面で入力されたタイトルを代入
        $diary->body = $request->body; //画面で入力された本文を代入
        $diary->user_id = Auth::user()->id;
        $diary->save(); //DBに保存

        return redirect()->route('diary.index'); //一覧ページにリダイレクト
    }
    public function destroy($id) {
        $diary = Diary::find($id);
        $diary->delete();
        return redirect()->route('diary.index');
    }
    public function edit(int $id) {
        $diary = Diary::find($id);
        return view('diaries.edit', ['diary' => $diary]);
    }
    public function update(int $id, CreateDiary $request)
    {
        $diary = Diary::find($id);

        $diary->title = $request->title; //画面で入力されたタイトルを代入
        $diary->body = $request->body; //画面で入力された本文を代入
        $diary->save(); //DBに保存

        return redirect()->route('diary.index'); //一覧ページにリダイレクト
    }
}
