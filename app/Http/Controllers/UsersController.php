<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users;

class UsersController extends Controller
{
    private $users;
    const _PER_PAGE = 4;

    public function __construct()
    {
        $this->users = new Users();
    }

    public function index(Request $request)
    {
        //$statement = $this->users->statemenUser("DELETE FROM users");
        //dd($statement);
        $title = 'Danh sách người dùng';

        //$this->users->learnQueryBuider();

        $filters = [];

        $keywords = null;

        if (!empty($request->status)){
            $status = $request->status;
            if($status=='active'){
                $status = 1;
            }else{
                $status = 0;
            }

            $filters[] = ['users.status', '=', $status];
        }

        if (!empty($request->group_id)){
            $groupId = $request->group_id;

            $filters[] = ['users.group_id', '=', $groupId];
        }

        if (!empty($request->keywords)){
            $keywords = $request->keywords;
        }

        //xử lý logic sắp xếp
        // $sortBy = 'fullname';
        // $sortType = 'asc';

        $sortBy = $request->input('sort-by');

        $sortType = $request->input('sort-type');

        $allowSort = ['asc', 'desc'];

        if(!empty($sortType) && in_array($sortType, $allowSort)){
            if($sortType=='desc'){
                $sortType = 'asc';
            }else{
                $sortType = 'desc';
            }
        }else{
            $sortType = 'asc';
        }

        $sortArr = [
            'sortBy' => $sortBy,
            'sortType' =>$sortType
        ];

        $usersList = $this->users->getAllUsers($filters, $keywords, $sortArr, self::_PER_PAGE);

        return view('clients.users.lists', compact('title', 'usersList','sortType'));
    }

    public function add()
    {
        $title = 'Thêm người dùng';

        $allGroups = getAllGroups();

        return view('clients.users.add', compact('title', 'allGroups'));
    }

    public function postAdd(Request $request)
    {
        $request->validate(
            [
                'fullname' => 'required|min:5',
                'email' => 'required|email|unique:users',
                'group_id' => ['required','integer', function($attribute, $value, $fail){
                    if ($value==0){
                        $fail('Bắt buộc phải chọn nhóm');
                    }
                }],
                'status'=> 'required|integer'
            ],
            [
                'fullname.required' => 'Họ và tên bắt buộc phải nhập',
                'fullname.min' => 'Họ và tên phải từ :min ký tự trở lên',
                'email.required' => 'Email bắt buộc phải nhập',
                'email.email' => 'Email không đúng định dạng',
                'email.unique' => 'Email đã tồn tại trên hệ thống',
                'group_id.required' => 'Nhóm không được để trống',
                'group_id.integer' => 'Nhóm không hợp lệ',
                'status.required' => 'Trạng thái không được để trống',
                'status.integer' => 'Trạng thá không hợp lệ'
            ]
        );
        //dd($request->all());

        $dataInsert = [
            'fullname' => $request->fullname,
            'email' => $request->email,
            'group_id' =>$request->group_id,
            'status' => $request->status,
            'create_at' => date('Y-m-d H:i:s')
        ];

        $this->users->addUser($dataInsert);
        return redirect()->route('users.index')->with('msg', 'Thêm người dùng thành công');
    }

    public function getEdit(Request $request, $id=0){

        $title = 'Cập nhật người dùng';

        if(!empty($id)){
            $userDetail = $this->users->getDetail($id);
            if(!empty($userDetail[0])){
                $request->session()->put('id', $id);
                $userDetail = $userDetail[0];
            }else{
                return redirect()->route('users.index')->with('msg', 'Người dùng không tồn tại');
            }
        }else{
            return redirect()->route('users.index')->with('msg', 'Liên kết không tồn tại');
        }

        return view('clients.users.edit', compact('title', 'userDetail'));
    }

    public function postEdit(Request $request){

        $id = session('id');
        if (empty($id)){
            return back()->with('msg', 'Lien ket khong ton tai');
        }
        
        $request->validate([
            'fullname' => 'required|min:5',
            'email' => 'required|email|unique:users,email,'.$id
        ],
        [
            'fullname.required' => 'Họ và tên bắt buộc phải nhập',
            'fullname.min' => 'Họ và tên phải từ :min ký tự trở lên',
            'email.required' => 'Email bắt buộc phải nhập',
            'email.email' => 'Email không đúng định dạng',
            'email.unique' => 'Email đã tồn tại trên hệ thống'
        ]);

        $dataUpdate = [
            $request->fullname,
            $request->email,
            date('Y-m-d H:i:s')
        ];

        $this->users->updateUser($dataUpdate, $id);

        //return redirect()->route('users.edit', ['id'=>$id])->with('Cap nhat nguoi dung');
        return back()->with('msg', 'Cap nhat nguoi dung');
    }

    public function delete($id=0){
        if(!empty($id)){
            $userDetail = $this->users->getDetail($id);
            if(!empty($userDetail[0])){
               $deleteStatus = $this->users->delete($id);
               if($deleteStatus){
                    $msg = 'Xóa người dùng thành công';
               }else{
                    $msg = 'Bạn không thể xóa người dùng lúc này. Vui lòng thử lại sau';
               }
            }else{
                $msg = 'Người dùng không tồn tại';
            }
        }else{
            $msg = 'Liên kết không tồn tại';
        }
        return redirect()->route('users.index')->with('msg',$msg);
    }
    } 