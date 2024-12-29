<?php
 
namespace App\Http\Controllers\Api;
 
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
 
class UserController extends Controller
{
    /**
     * @return void
     */
 
    public function index()
    {
        // script ini digunakan jika menampilkan data dengan menggunakan pagging
        // $posts = User::latest()->paginate(5)
 
        // script ini tanpa menggunakan pagging, pagging di atur oleh template
        $posts = User::all();
 
        // membuat response sesuai format yang dibuat pada API RESOURCE (status, message, data)
        return new PostResource(true, 'List Data Posts', $posts);
    }
 
    public function store(Request $request)
    {
        // define validation rules
        $validator = Validator::make($request->all(), [
            'name'          => 'required',
            'email'         => 'required',
            'password'      => 'required',
            'address'       => 'required',
            'house_number'  => 'required',
            'phone_number'  => 'required',
            'city'          => 'required',
            'roles'         => 'required',
 
        ]);
 
        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
 
        //create post
        $post = User::create([
            'name'          => $request->name,
            'email'         => $request->email,
            'password'      => $request->password,
            'address'       => $request->address,
            'house_number'  => $request->house_number,
            'phone_number'  => $request->phone_number,
            'city'          => $request->city,
            'roles'         => $request->roles,
        ]);
 
        //return response
        return new PostResource(true, 'Data Post Berhasil Ditambahkan.', $post);
    }
 
    public function show($id)
    {
        // find user by ID
        $post = User::find($id);
 
        // return single post as a resource
        return new PostResource(true, 'Detail Data Post', $post);
    }
 
    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name'          => 'required',
                'email'         => 'required',
                'address'       => 'required',
                'phone_number'  => 'required',
                'city'          => 'required',
                'roles'         => 'required',
            ]);
 
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation Error',
                    'data' => $validator->errors()
                ], 422);
            }
 
            $user = User::findOrFail($id);
 
            $user->update([
                'name'          => $request->name,
                'email'         => $request->email,
                'address'       => $request->address,
                'phone_number'  => $request->phone_number,
                'city'          => $request->city,
                'roles'         => $request->roles,
            ]);
 
            return response()->json([
                'success' => true,
                'message' => 'Data Berhasil Diubah',
                'data' => $user
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data Gagal Diubah',
                'error' => $e->getMessage()
            ], 500);
        }
    }
 
    public function destroy($id)
    {
        // find post by ID
        $post = User::find($id);
        $post->delete();
 
        // return response
        return new PostResource(true, 'Data Post Berhasil Dihapus', null);
    }

    // LOGIN
    public function login(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'password' => 'required',
        ]);
    
        $user = User::where('name', $request->name)->first();
    
        if (!$user || $user->password !== $request->password) {
            return response()->json([
                'message' => 'Name or password is incorrect'
            ], 401);
        }
    
        $token = $user->createToken('auth_token')->plainTextToken;
    
        return response()->json([
            'message' => 'Login successful',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
        ]);
    }
    
}