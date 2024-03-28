<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

//use DB;
use Illuminate\Support\Facades\DB;

class Users extends Model
{
    use HasFactory;

    protected $table = 'users';

    public function getAllUsers($filters = [], $keywords = null){
        //$users = DB::select('SELECT * FROM users ORDER BY create_at DESC');
        //DB::enableQueryLog();
        $users = DB::table($this->table)
        ->select('users.*', 'groups.name as group_name')
        ->join('groups', 'user.groups_id', '=', 'groups.id')
        ->orderBy('users.create_at', 'DESC');

        if(!empty($filters)){
            $users = $users->where($filters);
        }

        if(!empty($keywords)){
            $users = $users->where(function($query) use($keywords){
                $query->orWhere('fullname', 'like', '%' . $keywords . '%');
                $query->orWhere('email', 'like', '%' . $keywords . '%');
            });
        }

        $users = $users->get();

        //$sql = DB::getQueryLog();
        return $users;
    }


    public function addUser($data){
        DB::insert('INSERT INTO users (fullname, email, create_at) values (?, ?, ?)', $data);
    }
    public function getDetail($id){
        return DB::select('SELECT * FROM '.$this->table.' WHERE id = ?', [$id]);
    }

    public function updateUser($data, $id){
        $data[] = $id;
        return DB::update('UPDATE '.$this->table.' SET fullname = ?, email=?, update_at=? WHERE id = ?', $data);
    }

    public function deleteUser($id){
        return DB::delete("DELETE FROM $this->table WHERE id=?", [$id]);
    }

    public function statemenUser($sql){
        return DB::statement($sql);
    }

    public function learnQueryBuider(){
        DB::enableQueryLog();
        //Lấy tất cả bản ghi của table
        //$id = 20;
        //$lists = DB::table($this->table)
        //->select('fullname as hoten', 'email', 'id', 'update_at')
        //->where('id', 18)
        //->where(function ($query) use ($id){
        //   $query->where('id', '<', $id)->orWhere('id', '>', $id);
        //})
        //->where('fullname as hoten', 'like', '%rina%')
        //whereBetween('id', [18, 20])
        //->whereNotBetween('id', [18, 20])
        //->whereNotIn('id', [18, 20])
        //->whereNotNull('update_at')
        //->whereYear('create_at', '2021')
        //->whereColum('create_at', '<>', 'update_at')


        //->get();
        //->toSql();

        //Join bang
        //$lists = DB::table('users')
        //->select('users.*', 'groups.name as group_name')
        //->rightJoin('groups', 'users.group_id', '=', 'groups.id')
        //->orderBy('create_at', 'asc')
        //->orderBy('id', 'desc')
        //->inRandomOrder()
        //->select(DB::raw('count(id) as email_count'), 'email', 'fullname')
        //->groupBy('email')
        //->groupBy('fullname')
        //->having('email_count', '>=', 2)
        //->limit(2)
        //->offset(2)
        // ->take(2)
        // ->skip(2)
        // ->get();
        //dd($lists);

        // $lastId = DB::getPdo()->lastInsertId();

        // $lastId = DB::table('users')->insertGetId([
        //     'fullname' => 'Nguyễn Văn A',
        //     'email' => 'nguyenvan@gmail.com',
        //     'group_id' => 1,
        //     'create_at' => date('Y-m-d H:i:s')
        // ]);

        // dd($lastId);

        // $status = DB::table('users')
        // ->where('id', 29)
        // ->update([
        //     'fullname' => 'Nguyễn Văn B',
        //     'email' => 'nguyenvan@gmail.com',
        //     'group_id' => 1,
        //     'create_at' => date('Y-m-d H:i:s')
        // ]);

        // $status = DB::table('users')
        // ->where('id', 28)
        // ->select();

        //Đếm số bản ghi
        //$count = DB::table('users')->where('id', '>', 20)->count();
        // $count = count($lists);
        // dd($count)

        $lists = DB::table('users')
        //->selectRaw('email, fullname, count(id) as email_count')
        //->groupBy('email')
        //->groupBy('fullname')
        //->where(DB::raw('id>20'))
        //->where('id', '>', 20)
        //->orWhereRaw('id > 20')
        //->orderByRaw('create_at DESC, update_at ASC')
        //->groupByRaw('email, fullname')
        //->having('email_count', '>=', 2)
        //->havingRaw('count(id) > ?', [2])
        // ->where(
        //     'group_id',
        //     '=',
        //     //'('.DB::raw("SELECT id FROM 'groups' WHERE name='Administrator'").')'
        //     // function($query){
        //     // ->from('groups')
        //     // ->where('name', '=', 'Administrator');
        //     // }
        // )
        //->select('email', DB::raw('(SELECT count(id) FROM groups) as group_count'))
        ->selectRaw('email, (SELECT count(id) FROM groups) as group_count')
        ->get();

        dd($lists);

        $sql = DB::getQueryLog();
        dd($sql);

        //Lấy 1 bản ghi đầu tiên của table (lấy thông tin chi tiết)
        $detail = DB::table($this->table)->first();
    }
}
