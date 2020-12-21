<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\HelloRequest;
use Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Person;
use Illuminate\Support\Facades\Auth;


class HelloController extends Controller
{
    public function index(Request $request){

        // if ($request->hasCookie('msg'))
        // {
        //     $msg = 'Cookie:' . $request->cookie('msg');
        // }else{
        //     $msg = 'クッキーはありません';
        // }

        // $items = DB::select('select * from people');

        // if (isset($request->id))
        // {
        //     $param = ['id' => $request->id];
        //     $items = DB::select('select * from people where id = :id', $param);
        // }else{
        //     $items = DB::select('select * from people');
        // }

        // $items = DB::select('select * from people');

        // $items = DB::table('people')->get();
        // $items = DB::table('people')->orderBy('age', 'asc')->get();

        // $items = DB::table('people')->simplePaginate(5);

        $user = Auth::user();
        $sort = $request->sort;
        $items = DB::table('people')->orderBy($sort, 'asc')->paginate(5);
        $param = ['items' => $items, 'sort' => $sort, 'user' => $user];
        return view('hello.index', $param);
    }

    public function post(Request $request){

    // $validate_rule = [
    //     'msg' => 'required',
    // ];
    // $this->validate($request, $validate_rule);
    // $msg = $request->msg;
    // $response = response()->view('hello.index', ['msg' => '「' . $msg . '」をクッキーに保存しました']);
    // $response->cookie('msg', $msg, 100);
    // return $response;

    $items = DB::select('select * from people');
    return view('hello.index', ['items'=> $items]);

}

    public function add(Request $request)
    {
        return view('hello.add');
    }

    public function create(Request $request)
    {
        $param = [
            'name' => $request->name,
            'mail' => $request->mail,
            'age' => $request->age,
        ];
        // DB::insert('insert into people (name, mail, age) values (:name, :mail, :age)', $param);
        DB::table('people')->insert($param);
        return redirect('http://localhost/20201225_WebDev_TeamMMC/public/hello');
    }

    public function edit(Request $request)
    {
        // $param = ['id' => $request->id];
        // $item = DB::select('select * from people where id = :id', $param);
        $item = DB::table('people')->where('id', $request->id)->first();
        return view('hello.edit', ['form' => $item]);
    }

    public function update(Request $request)
    {
        $param = [
            'id' => $request->id,
            'name' => $request->name,
            'mail' => $request->mail,
            'age' => $request->age,
        ];

        // DB::update('update people set name =:name, mail = :mail, age = :age where id = :id', $param);

        DB::table('people')->where('id', $request->id)->update($param);
        return redirect('http://localhost/20201225_WebDev_TeamMMC/public/hello');
    }

    public function del(Request $request)
    {
        // $param = ['id' => $request->id];
        // $item = DB::select('select * from people where id = :id', $param);

        $item = DB::table('people')->where('id', $request->id)->first();
        return view('hello.del', ['form' => $item]);
    }

    public function remove(Request $request)
    {
        // $param = ['id' => $request->id];
        // DB::delete('delete from people where id = :id',$param);

        DB::table('people')->where('id', $request->id)->delete();
        return redirect('http://localhost/20201225_WebDev_TeamMMC/public/hello');
    }

    public function show(Request $request)
    {
        // $id = $request->id;
        // $items = DB::table('people')->where('id', '<=', $id)->get();

        // $name = $request->name;
        // $items = DB::table('people')->where('name', 'like', '%' . $name . '%')->orWhere('mail', 'like', '%' . $name . '%')->get();

        // $min = $request->min;
        // $max = $request->max;
        // $items = DB::table('people')->whereRaw('age >= ? and age <= ?', [$min, $max])->get();

        $page = $request->page;
        $items = DB::table('people')->offset($page * 3)->limit(3)->get();
        return view('hello.show', ['items' => $items]);
    }

    public function ses_get(Request $request)
    {
        $sesdata = $request->session()->get('msg');
        return view('hello.session', ['session_data' => $sesdata]);
    }

    public function ses_put(Request $request)
    {
        $msg = $request->input;
        $request->session()->put('msg', $msg);
        return redirect('http://localhost/20201225_WebDev_TeamMMC/public/hello/session');
    }
}

